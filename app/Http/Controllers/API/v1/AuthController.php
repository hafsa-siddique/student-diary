<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Institute;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'institute_id' => 'nullable|string',
            'email' => 'required|email',
            'password' => 'required|string',
        ]);    
        if(!$request->filled('institute_id')){
            if(!Auth::attempt([
                'email' => $request->email,
                'password' => $request->password,
                'role' => 'super_admin',
                'institute_id' => null,
            ])){
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid Credentials'
                ],401);
            }
        } else {
            $institute = Institute::where('code',$request->institute_id)->first();
            if(!$institute){
                return response()->json([
                    'message' => 'Invalid Institute Code'
                ],401);
            }
            if(!Auth::attempt([
                'email' => $request->email,
                'password' => $request->password,
                'institute_id' => $institute->id,
            ])){
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid Credentials'
                ],401);
            }
        }

        $user = User::findOrFail(Auth::id());
        if(!$user->status){
            Auth::logout();
            return response()->json([
                'message' => 'Account Inactive'
            ],403);
        }
        $previousLoginAt = $user->last_login_at;
        $user->update([
            'last_login_at' => now(),
        ]);

        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json([
            'status' => true,
            'message' => 'Login Successful',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'institute' => $user->institute?->name,
                'last_login_at' => $previousLoginAt,
            ],
            'token' => $token,
            'token_type' => 'Bearer',
        ],200);
    }

    public function me(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'status' => true,
            'message' => 'Login Successful',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'institute' => $user->institute?->name,
            ]
        ],200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        // $user->currentAccessToken()->delete();
        $user->tokens()->delete();
        return response()->json([
            'status' => true,
            'message' => 'Logout Successful'
        ],200);
    }
}
