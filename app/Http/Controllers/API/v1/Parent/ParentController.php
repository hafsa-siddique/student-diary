<?php

namespace App\Http\Controllers\API\v1\Parent;

use App\Http\Controllers\Controller;
use App\Http\Resources\ParentProfileResource;
use App\Http\Resources\StudentResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ParentController extends Controller
{
    public function me(Request $request)
    {
        $user = $request->user();
        $parent = $user->parent;
        $parent->load('user');
        return response()->json([
            'status' => true,
            'message' => 'Parent profile retrieved successfully.',
            'data' => new ParentProfileResource($parent),
        ], 200);
    }

    /**
     * Change logged-in parent's password.
     */
    public function changePassword(Request $request)
    {
        $user = $request->user();
        $parent = $user->parent;
        $validatedData = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);
        if (!Hash::check($validatedData['current_password'],$user->password))
        {
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

    public function children(Request $request)
    {
        $user = $request->user();
        $parent = $user->parent;
        $students = $parent->students()
            ->where('institute_id', $user->institute_id)
            ->with(['enrollments' => fn($query) => $query
                    ->where('status', true)
                    ->with(['schoolClass', 'section', 'academicSession']),
            ])
            ->paginate(5);

        return response()->json([
            'status' => true,
            'message' => 'Children retrieved successfully.',
            'data' => StudentResource::collection($students),
        ], 200);
    }
}