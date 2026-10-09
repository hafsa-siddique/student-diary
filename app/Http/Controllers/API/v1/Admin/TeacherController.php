<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AcademicSessionResource;
use App\Http\Resources\TeacherResource;
use App\Models\AcademicSession;
use App\Models\Institute;
use App\Models\Teacher;
use App\Models\TeacherAssignment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $instituteId = $request->user()->institute_id;
        $currentSession = AcademicSession::where('institute_id',$instituteId)
            ->whereDate('start_date', '<=', today())
            ->whereDate('end_date', '>=', today())
            ->first();
        $query = Teacher::with('user')
            ->where('institute_id', $instituteId);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('employee_code','like',"%{$search}%")
                ->orWhere('phone','like',"%{$search}%")
                ->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            });
        }
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('status', '1');
            } elseif ($request->status === 'inactive') {
                $query->where('status', '0');
            }
        }
        if ($currentSession) {
            $query->withCount([
                'assignments as current_assignment_count' => function ($assignmentQuery) use ($currentSession) {
                    $assignmentQuery
                        ->where('academic_session_id',$currentSession->id
                        )->where('status', '1');
                }
            ]);
        } else {
            $query->withCount([
                'assignments as current_assignment_count' => function ($assignmentQuery) {
                    $assignmentQuery->where('status', '1');
                }
            ]);
        }
        $query->withCount('assignments');
        $teachers = $query->orderBy('id', 'desc')
            ->paginate(5)
            ->withQueryString();
        $teacherBaseQuery = Teacher::where('institute_id',$instituteId);
        $totalFaculty = (clone $teacherBaseQuery)->count();
        $activeStaff = (clone $teacherBaseQuery)
            ->where('status', '1')
            ->count();
        $inactiveStaff = (clone $teacherBaseQuery)
            ->where('status', '0')
            ->count();
        $requiredAssignmentsPerTeacher = 6;
        $assignedCount = 0;
        $assignmentCount = 0;
        $unassignedCount = 0;
        if ($currentSession) {
            $assignmentCount = TeacherAssignment::where('academic_session_id', $currentSession->id)
                ->where('status', '1')
                ->whereHas('teacher', function ($query) use ($instituteId) {
                    $query->where('institute_id', $instituteId)
                        ->where('status', '1');
                })
                ->count();
            $assignedTeacherIds = TeacherAssignment::where('academic_session_id', $currentSession->id)
                ->where('status', '1')
                ->whereHas('teacher', function ($query) use ($instituteId) {
                    $query->where('institute_id', $instituteId)
                        ->where('status', '1');
                })
                ->pluck('teacher_id')
                ->unique();
            $assignedCount = $assignedTeacherIds->count();
            $requiredAllocations = $activeStaff * $requiredAssignmentsPerTeacher;
            $unassignedCount = max($requiredAllocations - $assignmentCount, 0);
        }
        return response()->json([
            'status' => true,
            'message' => 'Teachers retrieved successfully.',
            'statistics' => [
                'total_faculty' => $totalFaculty,
                'active_staff' => $activeStaff,
                'inactive_staff' => $inactiveStaff,
                'unassigned_count' => $unassignedCount,
                'assigned_count' => $assignedCount,
                'assignment_count' => $assignmentCount,
            ],
            'current_session' => $currentSession
                ? new AcademicSessionResource($currentSession)
                : null,
            'data' => TeacherResource::collection($teachers->items()),
            'meta' => [
                'current_page' => $teachers->currentPage(),
                'last_page' => $teachers->lastPage(),
                'per_page' => $teachers->perPage(),
                'total' => $teachers->total(),
                'from' => $teachers->firstItem(),
                'to' => $teachers->lastItem(),
            ],
        ], 200);
    }

    public function store(Request $request)
    {
        $instituteId = $request->user()->institute_id;
        $validatedData = $request->validate([
            'name' => 'required|string|regex:/^[A-Za-z ]+$/|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:30',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp,jfif|max:2048',
            'status' => 'sometimes|boolean',
        ]);
        $employeeCode = $this->generateEmployeeCode($instituteId);
        $teacher = DB::transaction(function () use ($validatedData, $instituteId,$employeeCode) {
            $user = User::create([
                'institute_id' => $instituteId,
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => 'teacher',
                'status' => $validatedData['status'] ?? true,
            ]);
            $teacherData = [
                'user_id' => $user->id,
                'institute_id' => $instituteId,
                'employee_code' => $employeeCode,
                'phone' => $validatedData['phone'] ?? null,
                'status' => $validatedData['status'] ?? true,
            ];
            if (isset($validatedData['profile_picture'])) {
                $teacherData['profile_picture'] =
                    $validatedData['profile_picture']->store('teachers', 'public');
            }
            $teacher = Teacher::create($teacherData);
            return $teacher->load('user');
        });
        return response()->json([
            'status' => true,
            'message' => 'Teacher created successfully.',
            'data' => new TeacherResource($teacher),
        ], 201);
    }

    public function show(Request $request,Teacher $teacher)
    {
        if ($teacher->institute_id !== $request->user()->institute_id) {
            return response()->json([
                'status' => false,
                'message' => 'Teacher not found.',
            ], 404);
        }
        $teacher->load([
            'user',
            'assignments.schoolClass',
            'assignments.section',
            'assignments.subject',
            'assignments.academicSession',
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Teacher retrieved successfully.',
            'data' => new TeacherResource($teacher),
        ], 200);
    }

    public function update(Request $request, Teacher $teacher)
    {
        if ($teacher->institute_id !== $request->user()->institute_id) {
            return response()->json([
                'status' => false,
                'message' => 'Teacher not found.',
            ], 404);
        }
        $teacher->load('user');
        $validatedData = $request->validate([
            'name' => 'required|string|regex:/^[A-Za-z ]+$/|max:255',
            'email' => 'required|email|unique:users,email,' . $teacher->user_id,
            'password' => 'nullable|string|min:8',
            'employee_code' => 'required|string|max:50|unique:teachers,employee_code,' . $teacher->id . ',id,institute_id,' . $request->user()->institute_id,
            'phone' => 'nullable|string|max:30',
            'status' => 'required|boolean',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        DB::transaction(function () use ($teacher, $validatedData) {
            $teacher->user->name = $validatedData['name'];
            $teacher->user->email = $validatedData['email'];
            if (!empty($validatedData['password'])) {
                $teacher->user->password =
                    Hash::make($validatedData['password']);
            }
            $teacher->user->save();
            $teacher->employee_code = $validatedData['employee_code'];
            $teacher->phone = $validatedData['phone'] ?? null;
            $teacher->status = $validatedData['status'];
            if (isset($validatedData['profile_picture'])) {
                if ($teacher->profile_picture) {
                    Storage::disk('public')->delete($teacher->profile_picture);
                }
                $teacher->profile_picture =
                    $validatedData['profile_picture']->store('teachers', 'public');
            }
            $teacher->save();
        });
        $teacher->load('user');
        return response()->json([
            'status' => true,
            'message' => 'Teacher updated successfully.',
            'data' => new TeacherResource($teacher),
        ], 200);
    }
    
    public function destroy(Request $request, Teacher $teacher)
    {
        if ($teacher->institute_id !== $request->user()->institute_id) {
            return response()->json([
                'status' => false,
                'message' => 'Teacher not found.',
            ], 404);
        }
        if ($teacher->assignments()->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Teacher cannot be deleted because they have assignments.',
            ], 422);
        }
        DB::transaction(function () use ($teacher) {
            $user = $teacher->user;
            $teacher->delete();
            if ($user) {
                $user->delete();
            }
        });
        return response()->json([
            'status' => true,
            'message' => 'Teacher deleted successfully.',
        ], 200);
    }

    public function updateStatus(Request $request, Teacher $teacher)
    {
        if ($teacher->institute_id !== $request->user()->institute_id) {
            return response()->json([
                'status' => false,
                'message' => 'Teacher not found.',
            ], 404);
        }
        $newStatus = !$teacher->status;
        DB::transaction(function () use ($teacher, $newStatus) {
            $teacher->status = $newStatus;
            $teacher->save();
            if ($teacher->user) {
                $teacher->user->status = $newStatus;
                $teacher->user->save();
            }
        });
        return response()->json([
            'status' => true,
            'message' => $newStatus
                ? 'Teacher activated successfully.'
                : 'Teacher deactivated successfully.',
            'data' => new TeacherResource($teacher->load('user')),
        ], 200);
    }
    private function generateEmployeeCode(int $instituteId): string
    {
        $institute = Institute::findOrFail($instituteId);
        $prefix = $institute->code . '-T';
        $lastTeacher = Teacher::where('institute_id', $instituteId)
            ->where('employee_code', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->first();

        if (!$lastTeacher) {
            $nextNumber = 1;
        } else {
            $lastCode = $lastTeacher->employee_code;
            $lastNumber = (int) str_replace($prefix, '', $lastCode);
            $nextNumber = $lastNumber + 1;
        }
        return $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    public function nextCode(Request $request)
    {
        $instituteId = $request->user()->institute_id;
        $employeeCode = $this->generateEmployeeCode($instituteId);
        return response()->json([
            'status' => true,
            'employee_code' => $employeeCode,
        ]);
    }
}
