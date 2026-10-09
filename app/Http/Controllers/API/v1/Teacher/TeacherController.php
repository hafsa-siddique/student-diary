<?php

namespace App\Http\Controllers\API\v1\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeacherMyAssignmentResource;
use App\Http\Resources\TeacherProfileResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function me(Request $request)
    {
        $user = $request->user();
        $teacher = $user->teacher;
        if(!$teacher){
            return response()->json([
                'status' => false,
                'message' => 'Teacher profile not found.',
            ], 404);
        }
        $teacher->load('user');
        return response()->json([
            'status' => true,
            'message' => 'Teacher profile retrieved successfully.',
            'data' => new TeacherProfileResource($teacher),
        ],200);
    }

    public function changePassword(Request $request)
    {
        $validatedData = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|max:8|confirmed'
        ]);
        $user = $request->user();
        if(!Hash::check($validatedData['current_password'],$user->password)){
            return response()->json([
                'status' => false,
                'message' => 'Current password is incorrect.',
            ], 422);
        }
        $user->password = Hash::make($validatedData['new_password']);
        $user->save();
         return response()->json([
            'status' => true,
            'message' => 'Password changed successfully.',
        ], 200);
    }

    public function myAssignments(Request $request)
    {
        $user = $request->user();
        $teacher = $user->teacher;
        $query = $teacher->assignments()
            ->with(['schoolClass', 'section', 'subject', 'academicSession'])
            ->whereHas('schoolClass', fn($q) =>
                $q->where('institute_id', $user->institute_id)
            );
        $assignments = (clone $query)->paginate(5);
        $allAssignments = (clone $query)->get();
        return response()->json([
            'status' => true,
            'message' => 'Teacher assignments retrieved successfully.',
            'statistics' => [
                'total' => $allAssignments->count(),
                'active' => $allAssignments->where('status', true)->count(),
                'classes' => $allAssignments->pluck('schoolClass.id')->filter()->unique()->count(),
                'subjects' => $allAssignments->pluck('subject.id')->filter()->unique()->count(),
            ],
            'current_session' => $allAssignments
                ->firstWhere('academicSession.status', true)?->academicSession,
            'data' => TeacherMyAssignmentResource::collection($assignments),
        ], 200);
    }
}
