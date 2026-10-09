<?php

namespace App\Http\Controllers\API\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AcademicSessionResource;
use App\Http\Resources\ClassResource;
use App\Http\Resources\SectionResource;
use App\Models\AcademicSession;
use App\Models\SchoolClass;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $instituteId = $request->user()->institute_id;
        $query = SchoolClass::where('institute_id', $instituteId);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status',$request->status === 'active');
        }
        $currentSession = AcademicSession::where('institute_id',$instituteId)
            ->whereDate('start_date', '<=', today())
            ->whereDate('end_date', '>=', today())
            ->first();
        $classes = $query->withCount('sections')
            ->orderBy('id')
            ->paginate($request->integer('per_page', 5))
            ->withQueryString();
        $studentCounts = collect();
        if ($currentSession) {
            $studentCounts = DB::table('student_enrollments')
                ->where('academic_session_id', $currentSession->id)
                ->where('status', 1)
                ->whereIn('class_id',$classes->pluck('id'))
                ->select('class_id',DB::raw(
                        'COUNT(DISTINCT student_id) as student_count'))
                ->groupBy('class_id')
                ->pluck('student_count', 'class_id');
        }
        $classes->getCollection()->transform(function ($class) use ($studentCounts) {
            $class->student_count = (int) ($studentCounts[$class->id] ?? 0);
            return $class;
        });
        $activeClasses = SchoolClass::where('institute_id', $instituteId)
            ->where('status', 1)
            ->orderBy('id')
            ->get();
        if ($currentSession) {
            $studentCounts = DB::table('student_enrollments')
                ->where('academic_session_id', $currentSession->id)
                ->where('status', 1)
                ->whereIn('class_id', $activeClasses->pluck('id'))
                ->select('class_id',DB::raw('COUNT(DISTINCT student_id) as student_count'))
                ->groupBy('class_id')
                ->pluck('student_count', 'class_id');
        } else {
            $studentCounts = collect();
        }
        $activeClasses->transform(function ($class) use ($studentCounts) {
            $class->student_count = (int) ($studentCounts[$class->id] ?? 0);
            return $class;
        });
        $statistics = SchoolClass::where('institute_id',$instituteId)
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('SUM(status = 1) as active')
            ->selectRaw('SUM(status = 0) as inactive')
            ->first();

        return response()->json([
            'status' => true,
            'count' => $classes->total(),
            'message' => 'Classes retrieved successfully.',

            'statistics' => [
                'total' => (int) $statistics->total,
                'active' => (int) $statistics->active,
                'inactive' => (int) $statistics->inactive,
            ],
            'current_session' => $currentSession
                ? new AcademicSessionResource($currentSession)
                : null,

            'data' => ClassResource::collection(
                $classes->items()
            ),
            'class_distribution' => $activeClasses->map(fn ($class) => [
                'id' => $class->id,
                'name' => $class->name,
                'student_count' => $class->student_count,
            ]),
            'meta' => [
                'current_page' => $classes->currentPage(),
                'last_page' => $classes->lastPage(),
                'per_page' => $classes->perPage(),
                'total' => $classes->total(),
                'from' => $classes->firstItem(),
                'to' => $classes->lastItem(),
            ],
        ], 200);
    }

    public function store(Request $request)
    {
        $instituteId = $request->user()->institute_id;

        $validatedData = $request->validate([
            'name' => 'required|string|max:100|unique:classes,name,NULL,id,institute_id,' . $instituteId,
            'description' => 'nullable|string',
            'status' => 'sometimes|boolean',
            'sections' => 'required|array|min:1',
            'sections.*' => 'required|string|max:100|distinct:ignore_case',
        ]);

        $class = DB::transaction(function () use ($validatedData, $instituteId) {
            $class = SchoolClass::create([
                'institute_id' => $instituteId,
                'name' => $validatedData['name'],
                'description' => $validatedData['description'] ?? null,
                'status' => $validatedData['status'] ?? true,
            ]);

            foreach ($validatedData['sections'] as $sectionName) {
                Section::create([
                    'class_id' => $class->id,
                    'name' => $sectionName,
                    'status' => true,
                ]);
            }

            return $class;
        });

        return response()->json([
            'status' => true,
            'message' => 'Class and sections created successfully.',
            'data' => new ClassResource($class->load('sections')),
        ], 201);
    }
    public function show(Request $request, SchoolClass $class)
    {
        $instituteId = $request->user()->institute_id;

        if ($class->institute_id !== $instituteId) {
            return response()->json([
                'status' => false,
                'message' => 'Class not found.',
            ], 404);
        }
        $currentSession = AcademicSession::where('institute_id',$instituteId)
            ->whereDate('start_date', '<=', today())
            ->whereDate('end_date', '>=', today())
            ->first();
        $class->loadCount('sections');
        $studentCount = 0;
        if ($currentSession) {
            $studentCount = DB::table('student_enrollments')
                ->where('academic_session_id', $currentSession->id)
                ->where('status', 1)
                ->where('class_id', $class->id)
                ->distinct()
                ->count('student_id');
        }
        $class->student_count = $studentCount;
        $class->academic_session = $currentSession;
        return response()->json([
            'status' => true,
            'message' => 'Class retrieved successfully.',
            'data' => new ClassResource($class),
        ], 200);
    }
    public function update(Request $request, SchoolClass $class)
    {
        $instituteId = $request->user()->institute_id;
        if ($class->institute_id !== $instituteId) {
            return response()->json([
                'status' => false,
                'message' => 'Class not found.',
            ], 404);
        }
        $validatedData = $request->validate([
            'name' => 'required|string|max:100|unique:classes,name,' . $class->id . ',id,institute_id,' . $instituteId,
            'description' => 'nullable|string',
            'status' => 'sometimes|boolean',
            'sections' => 'required|array|min:1',
            'sections.*.id' => 'nullable|integer',
            'sections.*.name' => 'required|string|max:100',
            'sections.*.status' => 'sometimes|boolean',
        ]);
        DB::transaction(function () use ($class, $validatedData) {
            $class->update([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'] ?? null,
                'status' => $validatedData['status'] ?? $class->status,
            ]);
            $existingSections = $class->sections()->get()->keyBy('id');
            $updatedIds = [];
            foreach ($validatedData['sections'] as $sectionData) {
                if (!empty($sectionData['id'])) {
                    $section = $existingSections->get($sectionData['id']);
                    if (!$section) {
                        abort(422, 'Invalid section.');
                    }
                    $section->update([
                        'name' => $sectionData['name'],
                        'status' => $sectionData['status'] ?? $section->status,
                    ]);
                    $updatedIds[] = $section->id;
                } else {
                    $section = Section::create([
                        'class_id' => $class->id,
                        'name' => $sectionData['name'],
                        'status' => $sectionData['status'] ?? true,
                    ]);

                    $updatedIds[] = $section->id;
                }
            }
            foreach ($existingSections as $section) {
                if (!in_array($section->id, $updatedIds)) {
                    if (DB::table('student_enrollments')
                        ->where('section_id', $section->id)
                        ->exists()
                    ) {
                        abort(422, "Section '{$section->name}' cannot be removed because it has enrollment records.");
                    }
                    $section->delete();
                }
            }
        });
        $class->loadCount('sections');
        $class->load('sections');
        $currentSession = AcademicSession::where('institute_id', $instituteId)
            ->whereDate('start_date', '<=', today())
            ->whereDate('end_date', '>=', today())
            ->first();
        $class->student_count = $currentSession
            ? DB::table('student_enrollments')
                ->where('academic_session_id', $currentSession->id)
                ->where('status', 1)
                ->where('class_id', $class->id)
                ->distinct()
                ->count('student_id')
            : 0;
        return response()->json([
            'status' => true,
            'message' => 'Class and sections updated successfully.',
            'data' => new ClassResource($class),
        ], 200);
    }
    public function destroy(Request $request, SchoolClass $class)
    {
        if ($class->institute_id !== $request->user()->institute_id) {
            return response()->json([
                'status' => false,
                'message' => 'Class not found.',
            ], 404);
        }

        if ($class->sections()->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Class cannot be deleted because it has sections.',
            ], 422);
        }

        if ($class->enrollments()->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Class cannot be deleted because it has enrollment records.',
            ], 422);
        }

        if ($class->teacherAssignments()->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Class cannot be deleted because it has teacher assignments.',
            ], 422);
        }

        if ($class->subjects()->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Class cannot be deleted because subjects are assigned to it.',
            ], 422);
        }

        $class->delete();

        return response()->json([
            'status' => true,
            'message' => 'Class deleted successfully.',
        ], 200);
    }

    public function updateStatus(Request $request, SchoolClass $class)
    {
        if ($class->institute_id !== $request->user()->institute_id) {
            return response()->json([
                'status' => false,
                'message' => 'Class not found.',
            ], 404);
        }

        $class->status = !$class->status;
        $class->save();

        return response()->json([
            'status' => true,
            'message' => $class->status
                ? 'Class activated successfully.'
                : 'Class deactivated successfully.',
            'data' => new ClassResource($class),
        ], 200);
    }

    public function sections(Request $request, SchoolClass $class)
    {
        $instituteId = $request->user()->institute_id;
        if ($class->institute_id !== $instituteId) {
            return response()->json([
                'status' => false,
                'message' => 'Class not found.',
            ], 404);
        }
        $currentSession = AcademicSession::where('institute_id', $instituteId)
            ->whereDate('start_date', '<=', today())
            ->whereDate('end_date', '>=', today())
            ->first();
        $sections = $class->sections()->get();
        $studentCounts = collect();
        if ($currentSession) {
            $studentCounts = DB::table('student_enrollments')
                ->where('academic_session_id', $currentSession->id)
                ->where('status', 1)
                ->where('class_id', $class->id)
                ->select('section_id', DB::raw('COUNT(DISTINCT student_id) as student_count'))
                ->groupBy('section_id')
                ->pluck('student_count', 'section_id');
        }
        $sections->each(function ($section) use ($studentCounts) {
            $section->student_count = (int) ($studentCounts[$section->id] ?? 0);
        });
        return response()->json([
            'status' => true,
            'message' => 'Class sections retrieved successfully.',
            'data' => SectionResource::collection($sections),
        ], 200);
    }

}