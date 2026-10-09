<?php

namespace App\Http\Controllers\API\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentEnrollmentResource;
use App\Models\AcademicSession;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentEnrollment;
use Illuminate\Http\Request;

class StudentEnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $instituteId = $request->user()->institute_id;
        $query = StudentEnrollment::with([
            'student',
            'schoolClass',
            'section',
            'academicSession',
        ])->whereHas('student', fn ($q) => $q->where('institute_id', $instituteId));

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', fn ($q) =>
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('student_code', 'like', "%{$search}%")
            );
        }
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }
        if ($request->filled('section_id')) {
            $query->where('section_id', $request->section_id);
        }
        $statsQuery = clone $query;
        $enrollments = $query->latest('enrollment_date')->paginate(5);
        $currentSession = AcademicSession::where('institute_id', $instituteId)
            ->where('status', true)
            ->whereDate('start_date', '<=', today())
            ->whereDate('end_date', '>=', today())
            ->first();

        return response()->json([
            'status' => true,
            'message' => 'Student enrollments retrieved successfully.',
            'statistics' => [
                'total' => (clone $statsQuery)->count(),
                'active' => (clone $statsQuery)->where('status', true)->count(),
                'inactive' => (clone $statsQuery)->where('status', false)->count(),
            ],
            'current_session' => $currentSession ? [
                'id' => $currentSession->id,
                'name' => $currentSession->name,
            ] : null,
            'data' => StudentEnrollmentResource::collection($enrollments),
            'pagination' => [
                'current_page' => $enrollments->currentPage(),
                'last_page' => $enrollments->lastPage(),
                'per_page' => $enrollments->perPage(),
                'from' => $enrollments->firstItem(),
                'to' => $enrollments->lastItem(),
                'total' => $enrollments->total(),
            ],
        ]);
    }
    public function store(Request $request)
    {
        $instituteId = $request->user()->institute_id;
        $validatedData = $request->validate([
            'student_id' => 'required|exists:students,id',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'academic_session_id' => 'required|exists:academic_sessions,id',
            'enrollment_date' => 'required|date',
            'status' => 'sometimes|boolean',
        ]);
        
        $student = Student::where('id', $validatedData['student_id'])
            ->where('institute_id', $instituteId)
            ->first();
        if (!$student) {
            return response()->json([
                'status' => false,
                'message' => 'Student not found in your institute.',
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

         $academicSession = AcademicSession::where('id',$validatedData['academic_session_id'] )
            ->where('institute_id', $instituteId)
            ->first();
        if (!$academicSession) {
            return response()->json([
                'status' => false,
                'message' => 'Academic session not found in your institute.',
            ], 404);
        }

        $enrollmentExists = StudentEnrollment::where('student_id',$student->id)
            ->where('academic_session_id',$academicSession->id)->exists();
        if($enrollmentExists){
            return response()->json([
                'status' => false,
                'message' => 'Student is already enrolled in this academic session.',
            ], 422);
        }

        $enrollment = StudentEnrollment::create([
            'student_id' => $student->id,
            'class_id' => $class->id,
            'section_id' => $section->id,
            'academic_session_id' => $academicSession->id,
            'enrollment_date' => $validatedData['enrollment_date'],
            'status' => $validatedData['status'] ?? true,
        ]);

        $enrollment->load([
            'student',
            'schoolClass.subjects',
            'section',
            'academicSession',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Student enrolled successfully.',
            'data' => new StudentEnrollmentResource($enrollment),
        ], 201);
    }

    public function show(Request $request,StudentEnrollment $studentEnrollment)
    {
        $instituteId = $request->user()->institute_id;
        $studentEnrollment->load('student');
        if (!$studentEnrollment->student ||
            $studentEnrollment->student->institute_id !== $instituteId
        ) {
            return response()->json([
                'status' => false,
                'message' => 'Enrollment not found.',
            ], 404);
        }
        $studentEnrollment->load([
            'schoolClass.subjects',
            'section',
            'academicSession',
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Student enrollment retrieved successfully.',
            'data' => new StudentEnrollmentResource($studentEnrollment),
        ], 200);
    }

    public function update(Request $request,StudentEnrollment $studentEnrollment)
    {
        $instituteId = $request->user()->institute_id;
        $studentEnrollment->load('student');
        if (!$studentEnrollment->student ||
            $studentEnrollment->student->institute_id !== $instituteId
        ) {
            return response()->json([
                'status' => false,
                'message' => 'Enrollment not found.',
            ], 404);
        }
        $validatedData = $request->validate([
            'student_id' => 'required|exists:students,id',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'academic_session_id' => 'required|exists:academic_sessions,id',
            'enrollment_date' => 'required|date',
        ]);
        $student = Student::where('id', $validatedData['student_id'])
            ->where('institute_id', $instituteId)
            ->first();
        if (!$student) {
            return response()->json([
                'status' => false,
                'message' => 'Student not found in your institute.',
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
         $academicSession = AcademicSession::where('id',$validatedData['academic_session_id'] )
            ->where('institute_id', $instituteId)
            ->first();
        if (!$academicSession) {
            return response()->json([
                'status' => false,
                'message' => 'Academic session not found in your institute.',
            ], 404);
        }
        $enrollmentExists = StudentEnrollment::where('student_id',$student->id)
            ->where('academic_session_id',$academicSession->id)
            ->where('id', '!=', $studentEnrollment->id)
            ->exists();
        if ($enrollmentExists) {
            return response()->json([
                'status' => false,
                'message' => 'Student is already enrolled in this academic session.',
            ], 422);
        }
        $studentEnrollment->update([
            'student_id' => $student->id,
            'class_id' => $class->id,
            'section_id' => $section->id,
            'academic_session_id' => $academicSession->id,
            'enrollment_date' => $validatedData['enrollment_date'],
        ]);
        $studentEnrollment->load([
            'student',
            'schoolClass.subjects',
            'section',
            'academicSession',
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Student enrollment updated successfully.',
            'data' => new StudentEnrollmentResource($studentEnrollment),
        ], 200);
    }

    public function destroy(Request $request,StudentEnrollment $studentEnrollment)
    {
        $instituteId = $request->user()->institute_id;
        $studentEnrollment->load('student');
        if (!$studentEnrollment->student ||
            $studentEnrollment->student->institute_id !== $instituteId
        ) {
            return response()->json([
                'status' => false,
                'message' => 'Enrollment not found.',
            ], 404);
        }
        $studentEnrollment->delete();
        return response()->json([
            'status' => true,
            'message' => 'Student enrollment deleted successfully.',
        ], 200);
    }

     public function updateStatus(Request $request,StudentEnrollment $studentEnrollment) 
    {
        $instituteId = $request->user()->institute_id;
        $studentEnrollment->load('student');
        if (!$studentEnrollment->student ||
            $studentEnrollment->student->institute_id !== $instituteId
        ) {
            return response()->json([
                'status' => false,
                'message' => 'Enrollment not found.',
            ], 404);
        }

        $studentEnrollment->status = !$studentEnrollment->status;
        $studentEnrollment->save();
        $studentEnrollment->load([
            'student',
            'schoolClass.subjects',
            'section',
            'academicSession',
        ]);

        return response()->json([
            'status' => true,
            'message' => $studentEnrollment->status
                ? 'Enrollment activated successfully.'
                : 'Enrollment deactivated successfully.',
            'data' => new StudentEnrollmentResource($studentEnrollment),
        ], 200);
    }

    public function studentEnrollments(Request $request,Student $student) 
    {
        $instituteId = $request->user()->institute_id;
        if ($student->institute_id !== $instituteId) {
            return response()->json([
                'status' => false,
                'message' => 'Student not found.',
            ], 404);
        }
        $enrollments = $student->enrollments()
            ->with([
                'schoolClass',
                'section',
                'academicSession',
            ])->paginate(5);

        return response()->json([
            'status' => true,
            'message' => 'Student enrollments retrieved successfully.',
            'data' => StudentEnrollmentResource::collection($enrollments),
        ], 200);
    }

    public function classStudents(Request $request,SchoolClass $class) 
    {
        $instituteId = $request->user()->institute_id;
        if ($class->institute_id !== $instituteId) {
            return response()->json([
                'status' => false,
                'message' => 'Class not found.',
            ], 404);
        }
        $enrollments = StudentEnrollment::with([
            'student',
            'section',
            'academicSession',
        ])->where('class_id', $class->id)->paginate(5);

        return response()->json([
            'status' => true,
            'message' => 'Class students retrieved successfully.',
            'data' => StudentEnrollmentResource::collection($enrollments),
        ], 200);
    }
}
