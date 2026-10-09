<?php

namespace App\Http\Controllers\API\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentEnrollmentResource;
use App\Http\Resources\StudentResource;
use App\Models\AcademicSession;
use App\Models\Institute;
use App\Models\ParentModel;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $instituteId = $request->user()->institute_id;

        $query = Student::with('parent.user')
            ->where('institute_id', $instituteId);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('student_code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            });
        }
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status === 'active');
        }
        $students = $query->latest()->paginate(5);
        $statisticsQuery = Student::where('institute_id', $instituteId);
        $totalStudents = (clone $statisticsQuery)->count();
        $activeStudents = (clone $statisticsQuery)->where('status', true)->count();
        $inactiveStudents = (clone $statisticsQuery)->where('status', false)->count();
        return response()->json([
            'status' => true,
            'message' => 'Students retrieved successfully.',
            'statistics' => [
                'total_students' => $totalStudents,
                'active_students' => $activeStudents,
                'inactive_students' => $inactiveStudents,
            ],
            'data' => StudentResource::collection($students->items()),
            'meta' => [
                'current_page' => $students->currentPage(),
                'last_page' => $students->lastPage(),
                'per_page' => $students->perPage(),
                'total' => $students->total(),
                'from' => $students->firstItem(),
                'to' => $students->lastItem(),
            ],
        ], 200);
    }

    public function store(Request $request)
    {
        $instituteId = $request->user()->institute_id;
        $validatedData = $request->validate([
            'parent_id' => 'required|exists:parents,id',
            'student_code' => 'required|string|max:50|unique:students,student_code,NULL,id,institute_id,' . $instituteId,
            'name' => 'required|string|regex:/^[A-Za-z ]+$/|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|in:male,female,other',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'sometimes|boolean',
        ]);
        $parent = ParentModel::where('id', $validatedData['parent_id'])
            ->where('institute_id', $instituteId)
            ->first();
        if (!$parent) {
            return response()->json([
                'status' => false,
                'message' => 'Parent not found in your institute.',
            ], 404);
        }
        $studentData = [
            'parent_id' => $parent->id,
            'institute_id' => $instituteId,
            'student_code' => $validatedData['student_code'],
            'name' => $validatedData['name'],
            'date_of_birth' => $validatedData['date_of_birth'] ?? null,
            'gender' => $validatedData['gender'] ?? null,
            'status' => $validatedData['status'] ?? true,
        ];
        if (isset($validatedData['profile_picture'])) {
            $studentData['profile_picture'] =
                $validatedData['profile_picture']->store('students', 'public');
        }
        $student = Student::create($studentData);
        $student->load('parent.user');
        return response()->json([
            'status' => true,
            'message' => 'Student created successfully.',
            'data' => new StudentResource($student),
        ], 201);
    }

    public function show(Request $request, Student $student)
    {
        if ($student->institute_id !== $request->user()->institute_id) {
            return response()->json([
                'status' => false,
                'message' => 'Student not found.',
            ], 404);
        }
        $student->load([
            'parent.user',
            'enrollments.schoolClass',
            'enrollments.section',
            'enrollments.academicSession',]);
        return response()->json([
            'status' => true,
            'message' => 'Student retrieved successfully.',
            'data' => [
            ...(new StudentResource($student))->resolve(),
            'enrollments' => $student->enrollments->map(function ($enrollment) {
                return [
                    'id' => $enrollment->id,
                    'class' => $enrollment->schoolClass?->name,
                    'section' => $enrollment->section?->name,
                    'academic_session' => $enrollment->academicSession?->name,
                    'enrollment_date' => $enrollment->enrollment_date,
                    'status' => (bool) $enrollment->status,
                ];
            })->values(),
        ],
        ], 200);
    }

    public function update(Request $request, Student $student)
    {
        $instituteId = $request->user()->institute_id;
        if ($student->institute_id !== $instituteId) {
            return response()->json([
                'status' => false,
                'message' => 'Student not found.',
            ], 404);
        }
        $validatedData = $request->validate([
            'parent_id' => 'required|exists:parents,id',
            'student_code' => 'required|string|max:50|unique:students,student_code,' . $student->id . ',id,institute_id,' . $instituteId,
            'name' => 'required|string|regex:/^[A-Za-z ]+$/|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|in:male,female,other',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        $parent = ParentModel::where('id', $validatedData['parent_id'])
            ->where('institute_id', $instituteId)
            ->first();
        if (!$parent) {
            return response()->json([
                'status' => false,
                'message' => 'Parent not found in your institute.',
            ], 404);
        }
        $studentData = [
            'parent_id' => $parent->id,
            'student_code' => $validatedData['student_code'],
            'name' => $validatedData['name'],
            'date_of_birth' => $validatedData['date_of_birth'] ?? null,
            'gender' => $validatedData['gender'] ?? null,
        ];
        if (isset($validatedData['profile_picture'])) {
            if ($student->profile_picture) {
                Storage::disk('public')->delete($student->profile_picture);
            }
            $studentData['profile_picture'] =
                $validatedData['profile_picture']->store('students', 'public');
        }
        $student->update($studentData);
        $student->load('parent.user');

        return response()->json([
            'status' => true,
            'message' => 'Student updated successfully.',
            'data' => new StudentResource($student),
        ], 200);
    }

    public function destroy(Request $request, Student $student)
    {
        if ($student->institute_id !== $request->user()->institute_id) {
            return response()->json([
                'status' => false,
                'message' => 'Student not found.',
            ], 404);
        }
        if ($student->enrollments()->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Student cannot be deleted because they have enrollment records.',
            ], 422);
        }
        $student->delete();
        return response()->json([
            'status' => true,
            'message' => 'Student deleted successfully.',
        ], 200);
    }

    public function updateStatus(Request $request, Student $student)
    {
        if ($student->institute_id !== $request->user()->institute_id) {
            return response()->json([
                'status' => false,
                'message' => 'Student not found.',
            ], 404);
        }
        $student->status = !$student->status;
        $student->save();

        return response()->json([
            'status' => true,
            'message' => $student->status
                ? 'Student activated successfully.'
                : 'Student deactivated successfully.',
            'data' => new StudentResource($student),
        ], 200);
    }

    public function storeWithEnrollment(Request $request)
    {
        $instituteId = $request->user()->institute_id;
        $studentCode = $this->generateStudentCode($instituteId);
        $validatedData = $request->validate([
            'parent_id' => 'required|integer|exists:parents,id',
            // 'student_code' => ['required','string','max:50','unique:students,student_code,NULL,id,institute_id,' . $instituteId,],
            'name' => ['required', 'string', 'regex:/^[A-Za-z ]+$/', 'max:255'],
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'class_id' => 'required|integer|exists:classes,id',
            'section_id' => 'required|integer|exists:sections,id',
            'academic_session_id' => 'required|integer|exists:academic_sessions,id',
            'enrollment_date' => 'required|date',
            'status' => 'sometimes|boolean',
            'enrollment_status' => 'sometimes|boolean',
        ]);
        // Verify that the parent belongs to this institute.
        $parent = ParentModel::where('id', $validatedData['parent_id'])
            ->where('institute_id', $instituteId)
            ->first();
        if (!$parent) {
            return response()->json([
                'status' => false,
                'message' => 'Parent not found in your institute.',
            ], 404);
        }
        // Verify that the class belongs to this institute.
        $schoolClass = SchoolClass::where('id', $validatedData['class_id'])
            ->where('institute_id', $instituteId)
            ->first();
        if (!$schoolClass) {
            return response()->json([
                'status' => false,
                'message' => 'Class not found in your institute.',
            ], 404);
        }
        // The selected section must belong to the selected class.
        $section = Section::where('id', $validatedData['section_id'])
            ->where('class_id', $schoolClass->id)
            ->first();
        if (!$section) {
            return response()->json([
                'status' => false,
                'message' => 'Section does not belong to the selected class.',
            ], 422);
        }
        // Verify that the session belongs to this institute.
        $academicSession = AcademicSession::where('id',$validatedData['academic_session_id'])
            ->where('institute_id', $instituteId)
            ->first();
        if (!$academicSession) {
            return response()->json([
                'status' => false,
                'message' => 'Academic session not found in your institute.',
            ], 404);
        }
        $profilePicturePath = null;
        try {
            if ($request->hasFile('profile_picture')) {
                $profilePicturePath = $request->file('profile_picture')
                    ->store('students', 'public');
            }
            [$student, $enrollment] = DB::transaction(function () use (
                $validatedData,
                $parent,
                $schoolClass,
                $section,
                $academicSession,
                $instituteId,
                $studentCode,
                $profilePicturePath
            ) {
                // Create the student record.
                $student = Student::create([
                    'parent_id' => $parent->id,
                    'institute_id' => $instituteId,
                    'student_code' => $studentCode,
                    'name' => $validatedData['name'],
                    'date_of_birth' => $validatedData['date_of_birth'] ?? null,
                    'gender' => $validatedData['gender'] ?? null,
                    'profile_picture' => $profilePicturePath,
                    'status' => $validatedData['status'] ?? true,
                ]);

                // Create the enrollment record for the new student.
                $enrollment = StudentEnrollment::create([
                    'student_id' => $student->id,
                    'class_id' => $schoolClass->id,
                    'section_id' => $section->id,
                    'academic_session_id' => $academicSession->id,
                    'enrollment_date' => $validatedData['enrollment_date'],
                    'status' => $validatedData['enrollment_status'] ?? true,
                ]);

                return [$student, $enrollment];
            });
        } catch (\Throwable $exception) {
            // Do not leave an uploaded picture behind if the database transaction fails.
            if ($profilePicturePath) {
                Storage::disk('public')->delete($profilePicturePath);
            }
            throw $exception;
        }
        $student->load('parent.user');
        $enrollment->load([
            'student',
            'schoolClass',
            'section',
            'academicSession',
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Student created and enrolled successfully.',
            'data' => [
                'student' => new StudentResource($student),
                'enrollment' => new StudentEnrollmentResource($enrollment),
            ],
        ], 201);
    }

    private function generateStudentCode(int $instituteId): string
    {
        $institute = Institute::findOrFail($instituteId);
        $prefix = $institute->code . '-S';
        $lastStudent = Student::where('institute_id', $instituteId)
            ->where('student_code', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->first();
        if (!$lastStudent) {
            $nextNumber = 1;
        } else {
            $lastCode = $lastStudent->student_code;
            // Example: ABC001-S001 → 001
            $lastNumber = (int) str_replace($prefix, '', $lastCode);
            $nextNumber = $lastNumber + 1;
        }
        return $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    public function nextCode(Request $request)
    {
        $instituteId = $request->user()->institute_id;
        $studentCode = $this->generateStudentCode($instituteId);
        return response()->json([
            'status' => true,
            'data' => [
                'student_code' => $studentCode,
            ],
        ]);
    }
}