<?php

namespace App\Http\Controllers\API\v1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
        ]);
        if (!Hash::check($request->current_password, $request->user()->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Current password is incorrect.',
            ], 422);
        }
        return response()->json([
            'status' => true,
            'message' => 'Current password verified.',
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user = $request->user();
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Current password is incorrect.',
            ], 422);
        }
        $user->update([
            'password' => Hash::make($request->password),
            'password_changed_at' => now(),
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Password updated successfully.',
        ]);
    }
}