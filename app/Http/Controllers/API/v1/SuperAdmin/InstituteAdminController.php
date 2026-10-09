<?php

namespace App\Http\Controllers\Api\v1\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Resources\InstituteAdminResource;
use App\Models\Institute;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InstituteAdminController extends Controller
{
    public function show(Institute $institute)
    {
        $admin = User::where('institute_id', $institute->id)
            ->where('role', 'admin')
            ->first();
        if (!$admin) {
            return response()->json([
                'status' => false,
                'message' => 'Admin not found for this institute.',
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'Institute admin retrieved successfully.',
            'data' => new InstituteAdminResource($admin),
        ], 200);
    }

    public function store(Request $request, Institute $institute)
    {
        $existingAdmin = User::where('institute_id', $institute->id)
            ->where('role', 'admin')->exists();
        if ($existingAdmin) {
            return response()->json([
                'status' => false,
                'message' => 'This institute already has an admin.',
            ], 422);
        }
        $validatedData = $request->validate([
            'name' => 'required|string|regex:/^[A-Za-z ]+$/|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'status' => 'sometimes|boolean'
        ]);
        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create([
            ...$validatedData,
            'institute_id' => $institute->id,
            'role' => 'admin'
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Institute admin created successfully.',
            'data' => new InstituteAdminResource($user),
        ], 201);
    }

    public function update(Request $request, Institute $institute)
    {
        $admin = User::where('institute_id', $institute->id)
            ->where('role', 'admin')->first();
        if (!$admin) {
            return response()->json([
                'status' => false,
                'message' => 'Admin not found for this institute.',
            ], 404);
        }
        $validatedData = $request->validate([
            'name' => 'required|string|regex:/^[A-Za-z ]+$/|max:255',
            'email' => 'required|email|unique:users,email,'.$admin->id,
            'password' => 'nullable|string|min:8',
        ]);
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }
        $admin->update($validatedData);
        return response()->json([
            'status' => true,
            'message' => 'Institute admin updated successfully.',
            'data' => new InstituteAdminResource($admin),
        ], 200);
    }

    public function updateStatus(Institute $institute)
    {
        $admin = User::where('institute_id', $institute->id)
            ->where('role', 'admin')->first();
        if (!$admin) {
            return response()->json([
                'status' => false,
                'message' => 'Admin not found for this institute.',
            ], 404);
        }
        $admin->status = !$admin->status;
        $admin->save();
        return response()->json([
            'status' => true,
            'message' => $admin->status
                ? 'Institute admin activated successfully.'
                : 'Institute admin deactivated successfully.',
            'data' => new InstituteAdminResource($admin),
        ], 200);
    }
}
