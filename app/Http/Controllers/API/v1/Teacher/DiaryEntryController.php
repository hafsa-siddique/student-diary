<?php

namespace App\Http\Controllers\API\v1\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeacherDiaryResource;
use App\Models\DiaryEntry;
use App\Models\PlatformSetting;
use App\Models\TeacherAssignment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DiaryEntryController extends Controller
{
    public function index(Request $request)
{
    $user = $request->user();
    $teacher = $user->teacher;
    if (!$teacher) {
        return response()->json([
            'status' => false,
            'message' => 'Teacher profile not found.',
        ], 404);
    }
    $request->validate([
        'diary_date' => 'nullable|date',
        'status' => 'nullable|in:draft,scheduled,published',
    ]);
    $query = DiaryEntry::with([
        'teacherAssignment.schoolClass',
        'teacherAssignment.section',
        'teacherAssignment.subject',
        'teacherAssignment.academicSession',
        'attachments',
    ])->whereHas('teacherAssignment', function ($q) use ($teacher, $user) {
        $q->where('teacher_id', $teacher->id)
            ->whereHas('schoolClass', fn($q) =>
                $q->where('institute_id', $user->institute_id)
            );
    });

    if ($request->filled('diary_date')) {
        $query->whereDate('diary_date', $request->diary_date);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $today = now()->toDateString();
    $todayAssignments = $teacher->assignments()
        ->where('status', true)
        ->whereHas('schoolClass', fn($q) =>
            $q->where('institute_id', $user->institute_id)
        )->count();
    $todayDiaries = (clone $query)->whereDate('diary_date', $today);
    $publishedToday = (clone $todayDiaries)
        ->where('status', 'published')
        ->count();
    $remainingToday = max($todayAssignments - $publishedToday, 0);
    $scheduled = (clone $query)
        ->where('status', 'scheduled')
        ->count();
    $diaries = $query->latest('diary_date')->latest('id')->paginate(5);
        return response()->json([
        'status' => true,
        'message' => 'Teacher diaries retrieved successfully.',
        'statistics' => [
            'total' => $todayAssignments,
            'published' => $publishedToday,
            'remaining' => $remainingToday,
            'scheduled' => $scheduled,
        ],
         'data' => TeacherDiaryResource::collection($diaries),
        'pagination' => [
            'current_page' => $diaries->currentPage(),
            'last_page' => $diaries->lastPage(),
            'per_page' => $diaries->perPage(),
            'total' => $diaries->total(),
        ],
    ], 200);
}
    public function availableAssignments(Request $request)
    {
        $teacher = $request->user()->teacher;
        if (!$teacher) {
            return response()->json([
                'status' => false,
                'message' => 'Teacher profile not found.',
            ], 404);
        }
        $request->validate([
            'diary_date' => 'required|date',
        ]);
        $assignments = TeacherAssignment::with([
            'schoolClass',
            'section',
            'subject',
            'academicSession',
        ])
        ->where('teacher_id', $teacher->id)
        ->where('status', true)
        ->whereHas('schoolClass', fn($q) =>
            $q->where('institute_id', $request->user()->institute_id)
        )
        ->whereDoesntHave('diaryEntries', function ($q) use ($request) {
            $q->whereDate('diary_date', $request->diary_date)
            ->whereIn('status', ['draft', 'published']);
        })->get();
        return response()->json([
            'status' => true,
            'message' => 'Available assignments retrieved successfully.',
            'data' => $assignments,
        ], 200);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $teacher = $user->teacher;
        $maxDiaryLength = (int) PlatformSetting::getVal('max_diary_length', 2000);
        $validatedData = $request->validate([
            'teacher_assignment_id' => 'required|exists:teacher_assignments,id',
            'diary_date' => 'required|date',
            'classwork' => 'nullable|string|max:'.$maxDiaryLength,
            'homework' => 'nullable|string|max:'.$maxDiaryLength,
            'instructions' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'required|in:draft,scheduled,published',
            'scheduled_at' => 'nullable|date',
        ], [
            'classwork.max' => "The classwork notes cannot exceed {$maxDiaryLength} characters.",
            'homework.max' => "The homework notes cannot exceed {$maxDiaryLength} characters.",
        ]);
        // Get assignment
        $assignment = TeacherAssignment::where('id',$validatedData['teacher_assignment_id'])
            ->where('teacher_id', $teacher->id)->first();
        if (!$assignment) {
            return response()->json([
                'status' => false,
                'message' => 'Teacher assignment not found.',
            ], 404);
        }
        if ($validatedData['status'] === 'draft') {
            $validatedData['scheduled_at'] = null;
            $validatedData['published_at'] = null;
        } elseif ($validatedData['status'] === 'published') {
            $validatedData['scheduled_at'] = null;
            $validatedData['published_at'] = now();
        } elseif ($validatedData['status'] === 'scheduled') {
            if (empty($validatedData['scheduled_at'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'scheduled_at is required when status is scheduled.',
                ], 422);
            }
            $scheduledAt = Carbon::parse(
                $validatedData['scheduled_at']
            );
            if (!$scheduledAt->isFuture()) {
                return response()->json([
                    'status' => false,
                    'message' => 'scheduled_at must be a future date and time.',
                ], 422);
            }
            $validatedData['scheduled_at'] = $scheduledAt;
            $validatedData['published_at'] = null;
        }
        $diary = DiaryEntry::create($validatedData);
        $diary->load([
            'teacherAssignment.schoolClass',
            'teacherAssignment.section',
            'teacherAssignment.subject',
            'teacherAssignment.academicSession',
            'attachments',
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Diary created successfully.',
            'data' => new TeacherDiaryResource($diary),
        ], 201);
    }

    public function show(Request $request,DiaryEntry $diary)
    {
        $user = $request->user();
        $teacher = $user->teacher;
        $diary->load([
            'teacherAssignment',
            'teacherAssignment.schoolClass',
            'teacherAssignment.section',
            'teacherAssignment.subject',
            'teacherAssignment.academicSession',
            'attachments',
        ]);

        if (!$diary->teacherAssignment ||
            $diary->teacherAssignment->teacher_id !== $teacher->id
        ) {
            return response()->json([
                'status' => false,
                'message' => 'Diary not found.',
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'Diary retrieved successfully.',
            'data' => new TeacherDiaryResource($diary),
        ], 200);
    }

    public function update(Request $request,DiaryEntry $diary)
    {
        $user = $request->user();
        $teacher = $user->teacher;
        $diary->load('teacherAssignment');

        if (!$diary->teacherAssignment ||
            $diary->teacherAssignment->teacher_id !== $teacher->id
        ) {
            return response()->json([
                'status' => false,
                'message' => 'Diary not found.',
            ], 404);
        }
        $validatedData = $request->validate([
            'teacher_assignment_id' => 'required|exists:teacher_assignments,id',
            'diary_date' => 'required|date',
            'classwork' => 'nullable|string',
            'homework' => 'nullable|string',
            'instructions' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'required|in:draft,scheduled,published',
            'scheduled_at' => 'nullable|date',
        ]);

        $assignment = TeacherAssignment::where('id',$validatedData['teacher_assignment_id'])
            ->where('teacher_id', $teacher->id)->first();
        if (!$assignment) {
            return response()->json([
                'status' => false,
                'message' => 'Teacher assignment not found.',
            ], 404);
        }
        if ($validatedData['status'] === 'draft') {
            $validatedData['scheduled_at'] = null;
            $validatedData['published_at'] = null;
        } elseif ($validatedData['status'] === 'published') {
            $validatedData['scheduled_at'] = null;
            if ($diary->status !== 'published') {
                $validatedData['published_at'] = now();
            } else {
                $validatedData['published_at'] = $diary->published_at;
            }
        } elseif ($validatedData['status'] === 'scheduled') {
            if (empty($validatedData['scheduled_at'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'scheduled_at is required when status is scheduled.',
                ], 422);
            }

            $scheduledAt = Carbon::parse($validatedData['scheduled_at']);
            if (!$scheduledAt->isFuture()) {
                return response()->json([
                    'status' => false,
                    'message' => 'scheduled_at must be a future date and time.',
                ], 422);
            }
            $validatedData['scheduled_at'] = $scheduledAt;
            $validatedData['published_at'] = null;
        }
        $diary->update($validatedData);
        $diary->load([
            'teacherAssignment.schoolClass',
            'teacherAssignment.section',
            'teacherAssignment.subject',
            'teacherAssignment.academicSession',
            'attachments',
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Diary updated successfully.',
            'data' => new TeacherDiaryResource($diary),
        ], 200);
    }

    public function destroy(Request $request,DiaryEntry $diary)
    {
        $user = $request->user();
        $teacher = $user->teacher;
        $diary->load(['teacherAssignment','attachments',]);
        if (!$diary->teacherAssignment ||
            $diary->teacherAssignment->teacher_id !== $teacher->id
        ) {
            return response()->json([
                'status' => false,
                'message' => 'Diary not found.',
            ], 404);
        }
        foreach ($diary->attachments as $attachment) {
            if ($attachment->file_path) {
                Storage::disk('public')->delete(
                    $attachment->file_path
                );
            }
        }
        $diary->delete();
        return response()->json([
            'status' => true,
            'message' => 'Diary deleted successfully.',
        ], 200);
    }
}
