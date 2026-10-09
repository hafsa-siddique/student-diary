<?php

namespace App\Http\Controllers\API\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AcademicSessionResource;
use App\Http\Resources\TeacherAssignmentResource;
use App\Models\AcademicSession;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherAssignment;
use Illuminate\Http\Request;

class TeacherAssignmentController extends Controller
{
    public function index(Request $request)
    {
        $instituteId = $request->user()->institute_id;
        $currentSession = AcademicSession::where('institute_id', $instituteId)
            ->whereDate('start_date', '<=', today())
            ->whereDate('end_date', '>=', today())
            ->first();
        $baseQuery = TeacherAssignment::whereHas('teacher', fn($q) =>
            $q->where('institute_id', $instituteId)
        )->when($currentSession, fn($q) =>
            $q->where('academic_session_id', $currentSession->id)
        );
        $total = (clone $baseQuery)->count();
        $active = (clone $baseQuery)->where('status', true)->count();
        $inactive = $total - $active;
        $assignments = (clone $baseQuery)
            ->with(['teacher.user', 'schoolClass', 'section', 'subject', 'academicSession'])
            ->when($request->filled('search'), fn($q) =>
                $q->whereHas('teacher.user', fn($q) =>
                    $q->where('name', 'like', '%' . $request->search . '%')
                )
            )
            ->when($request->filled('class_id'), fn($q) =>
                $q->where('class_id', $request->class_id)
            )
            ->when($request->filled('subject_id'), fn($q) =>
                $q->where('subject_id', $request->subject_id)
            )
            ->orderBy('id')
            ->paginate(5)
            ->withQueryString();

        return response()->json([
            'status' => true,
            'message' => 'Teacher assignments retrieved successfully.',
            'current_session' => $currentSession ? new AcademicSessionResource($currentSession) : null,
            'statistics' => [
                'total' => $total,
                'active' => $active,
                'inactive' => $inactive,
            ],
            'assignment_count' => $assignments->total(),
            'data' => TeacherAssignmentResource::collection($assignments),
        ], 200);
    }
    public function store(Request $request)
    {
        $instituteId = $request->user()->institute_id;

        $validatedData = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'academic_session_id' => 'required|exists:academic_sessions,id',
            'status' => 'sometimes|boolean',
        ]);
        $teacher = Teacher::where('id', $validatedData['teacher_id'])
            ->where('institute_id', $instituteId)
            ->first();
        if (!$teacher) {
            return response()->json([
                'status' => false,
                'message' => 'Teacher not found in your institute.',
            ], 404);
        }
        $class = SchoolClass::where('id', $validatedData['class_id'])
            ->where('institute_id', $instituteId)
            ->first();
        if (!$class) {
            return response()->json([
                'status' => false,
                'message' => 'Class not found in your institute.',
            ], 404);
        }

        $section = Section::where('id', $validatedData['section_id'])
            ->where('class_id', $class->id)
            ->first();
        if (!$section) {
            return response()->json([
                'status' => false,
                'message' => 'Section does not belong to the selected class.',
            ], 422);
        }

        $subject = Subject::where('id', $validatedData['subject_id'])
            ->where('institute_id', $instituteId)
            ->first();
        if (!$subject) {
            return response()->json([
                'status' => false,
                'message' => 'Subject not found in your institute.',
            ], 404);
        }

        // Validate Subject belongs to Class
        
        if (!$class->subjects()
            ->where('subjects.id', $subject->id)
            ->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'This subject is not assigned to the selected class.',
            ], 422);
        }

        $academicSession = AcademicSession::where(
            'id',
            $validatedData['academic_session_id']
        )
        ->where('institute_id', $instituteId)
        ->first();
        if (!$academicSession) {
            return response()->json([
                'status' => false,
                'message' => 'Academic session not found in your institute.',
            ], 404);
        }

        $assignmentExists = TeacherAssignment::where(
            'teacher_id',
            $teacher->id
        )
        ->where('class_id', $class->id)
        ->where('section_id', $section->id)
        ->where('subject_id', $subject->id)
        ->where('academic_session_id', $academicSession->id)
        ->exists();
        if ($assignmentExists) {
            return response()->json([
                'status' => false,
                'message' => 'This teacher assignment already exists.',
            ], 422);
        }

        $assignment = TeacherAssignment::create([
            'teacher_id' => $teacher->id,
            'class_id' => $class->id,
            'section_id' => $section->id,
            'subject_id' => $subject->id,
            'academic_session_id' => $academicSession->id,
            'status' => $validatedData['status'] ?? true,
        ]);

        $assignment->load([
            'teacher.user',
            'schoolClass',
            'section',
            'subject',
            'academicSession',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Teacher assigned successfully.',
            'data' => new TeacherAssignmentResource($assignment),
        ], 201);
    }

    public function show(Request $request,TeacherAssignment $teacherAssignment) {
        $instituteId = $request->user()->institute_id;
        $teacherAssignment->load('teacher');
        if (!$teacherAssignment->teacher ||
            $teacherAssignment->teacher->institute_id !== $instituteId
        ) {
            return response()->json([
                'status' => false,
                'message' => 'Teacher assignment not found.',
            ], 404);
        }
        $teacherAssignment->load([
            'teacher.user',
            'schoolClass',
            'section',
            'subject',
            'academicSession',
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Teacher assignment retrieved successfully.',
            'data' => new TeacherAssignmentResource($teacherAssignment),
        ], 200);
    }

    public function update(Request $request,TeacherAssignment $teacherAssignment) {
        $instituteId = $request->user()->institute_id;
        $teacherAssignment->load('teacher');
        if (!$teacherAssignment->teacher ||
            $teacherAssignment->teacher->institute_id !== $instituteId
        ) {
            return response()->json([
                'status' => false,
                'message' => 'Teacher assignment not found.',
            ], 404);
        }
        $validatedData = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'academic_session_id' => 'required|exists:academic_sessions,id',
        ]);

        $teacher = Teacher::where('id', $validatedData['teacher_id'])
            ->where('institute_id', $instituteId)
            ->first();
        if (!$teacher) {
            return response()->json([
                'status' => false,
                'message' => 'Teacher not found in your institute.',
            ], 404);
        }
        $class = SchoolClass::where('id', $validatedData['class_id'])
            ->where('institute_id', $instituteId)
            ->first();
        if (!$class) {
            return response()->json([
                'status' => false,
                'message' => 'Class not found in your institute.',
            ], 404);
        }
        $section = Section::where('id', $validatedData['section_id'])
            ->where('class_id', $class->id)
            ->first();
        if (!$section) {
            return response()->json([
                'status' => false,
                'message' => 'Section does not belong to the selected class.',
            ], 422);
        }
        $subject = Subject::where('id', $validatedData['subject_id'])
            ->where('institute_id', $instituteId)
            ->first();
        if (!$subject) {
            return response()->json([
                'status' => false,
                'message' => 'Subject not found in your institute.',
            ], 404);
        }
        if (!$class->subjects()
            ->where('subjects.id', $subject->id)
            ->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'This subject is not assigned to the selected class.',
            ], 422);
        }
        $academicSession = AcademicSession::where('id',$validatedData['academic_session_id'])
            ->where('institute_id', $instituteId)
            ->first();
        if (!$academicSession) {
            return response()->json([
                'status' => false,
                'message' => 'Academic session not found in your institute.',
            ], 404);
        }
        $assignmentExists = TeacherAssignment::where('teacher_id',$teacher->id)
            ->where('class_id', $class->id)
            ->where('section_id', $section->id)
            ->where('subject_id', $subject->id)
            ->where('academic_session_id', $academicSession->id)
            ->where('id', '!=', $teacherAssignment->id)
            ->exists();
        if ($assignmentExists) {
            return response()->json([
                'status' => false,
                'message' => 'This teacher assignment already exists.',
            ], 422);
        }
        $teacherAssignment->update([
            'teacher_id' => $teacher->id,
            'class_id' => $class->id,
            'section_id' => $section->id,
            'subject_id' => $subject->id,
            'academic_session_id' => $academicSession->id,
        ]);
        $teacherAssignment->load([
            'teacher.user',
            'schoolClass',
            'section',
            'subject',
            'academicSession',
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Teacher assignment updated successfully.',
            'data' => new TeacherAssignmentResource($teacherAssignment),
        ], 200);
    }

    public function destroy(Request $request,TeacherAssignment $teacherAssignment) {
        $instituteId = $request->user()->institute_id;
        $teacherAssignment->load('teacher');
        if (!$teacherAssignment->teacher ||
            $teacherAssignment->teacher->institute_id !== $instituteId
        ) {
            return response()->json([
                'status' => false,
                'message' => 'Teacher assignment not found.',
            ], 404);
        }
        if ($teacherAssignment->diaryEntries()->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Teacher assignment cannot be deleted because it has diary entries.',
            ], 422);
        }
        $teacherAssignment->delete();
        return response()->json([
            'status' => true,
            'message' => 'Teacher assignment deleted successfully.',
        ], 200);
    }

    public function updateStatus(Request $request,TeacherAssignment $teacherAssignment) {
        $instituteId = $request->user()->institute_id;
        $teacherAssignment->load('teacher');
        if (!$teacherAssignment->teacher ||
            $teacherAssignment->teacher->institute_id !== $instituteId
        ) {
            return response()->json([
                'status' => false,
                'message' => 'Teacher assignment not found.',
            ], 404);
        }
        $teacherAssignment->status = !$teacherAssignment->status;
        $teacherAssignment->save();
        $teacherAssignment->load([
            'teacher.user',
            'schoolClass',
            'section',
            'subject',
            'academicSession',
        ]);
        return response()->json([
            'status' => true,
            'message' => $teacherAssignment->status
                ? 'Teacher assignment activated successfully.'
                : 'Teacher assignment deactivated successfully.',
            'data' => new TeacherAssignmentResource($teacherAssignment),
        ], 200);
    }

    public function teacherAssignments(Request $request,Teacher $teacher) {
        $instituteId = $request->user()->institute_id;
        if ($teacher->institute_id !== $instituteId) {
            return response()->json([
                'status' => false,
                'message' => 'Teacher not found.',
            ], 404);
        }
        $assignments = $teacher->assignments()
            ->with([
                'teacher.user',
                'schoolClass',
                'section',
                'subject',
                'academicSession',
            ])
            ->paginate(5);
        return response()->json([
            'status' => true,
            'message' => 'Teacher assignments retrieved successfully.',
            'data' => TeacherAssignmentResource::collection($assignments),
        ], 200);
    }

    public function classAssignments(Request $request,SchoolClass $class) {
        $instituteId = $request->user()->institute_id;
        if ($class->institute_id !== $instituteId) {
            return response()->json([
                'status' => false,
                'message' => 'Class not found.',
            ], 404);
        }
        $assignments = $class->teacherAssignments()
            ->with([
                'teacher.user',
                'schoolClass',
                'section',
                'subject',
                'academicSession',
            ])->paginate(5);
        return response()->json([
            'status' => true,
            'message' => 'Class teacher assignments retrieved successfully.',
            'data' => TeacherAssignmentResource::collection($assignments),
        ], 200);
    }
}