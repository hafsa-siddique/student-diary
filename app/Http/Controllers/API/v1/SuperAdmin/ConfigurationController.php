<?php

namespace App\Http\Controllers\API\v1\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ConfigurationResource;
use App\Models\Institute;
use Illuminate\Http\Request;
// use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function show(Institute $institute)
    {
        $configuration = $institute->configuration;
        if (!$configuration) {
            return response()->json([
                'status' => false,
                'message' => 'Configuration not found for this institute.',
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'Configuration retrieved successfully.',
            'data' => new ConfigurationResource($configuration),
        ], 200);
    }

    public function update(Request $request, Institute $institute)
    {
        $validatedData = $request->validate([
            'main_logo' => 'nullable|string|max:255',
            'small_logo' => 'nullable|string|max:255',
            'login_logo' => 'nullable|string|max:255',
            'favicon' => 'nullable|string|max:255',
            'login_layout' => 'nullable|in:layout_one,layout_two',
            'primary_color' => 'nullable|string|max:20',
            'secondary_color' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:500',
            'website' => 'nullable|url|max:255',
        ]);
        $logoFields = ['main_logo', 'small_logo', 'login_logo', 'login_cover_image', 'favicon'];
        foreach ($logoFields as $field) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('images', 'public');
                $validatedData[$field] = $path;
            } else {
                unset($validatedData[$field]);
            }
        }
        $configuration = $institute->configuration()->updateOrCreate(
            [
                'institute_id' => $institute->id,
            ],
            $validatedData
        );
        return response()->json([
            'status' => true,
            'message' => 'Configuration updated successfully.',
            'data' => new ConfigurationResource($configuration),
        ], 200);
    }    

    public function myConfiguration(Request $request)
    {
        $user = $request->user();
        $configuration = $user->institute?->configuration;
        if (!$configuration) {
            return response()->json([
                'status' => false,
                'message' => 'Configuration not found for your institute.',
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'Configuration retrieved successfully.',
            'data' => new ConfigurationResource($configuration),
        ], 200);
    }

    public function profile(Request $request)
    {
        $user = $request->user()->load([
            'institute.configuration',
            'parent'
        ]);
        return response()->json([
            'status' => true,
            'data' => [
                'admin' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'role' => $user->role,
                    'status' => $user->status,
                     'relationship' => $user->parent?->relationship,
                    'profile_picture' => $user->profile_picture
                        ? asset('storage/' . $user->profile_picture)
                        : null,
                    'joined_at' => $user->created_at?->format('Y-m-d'),
                    'last_login' => $user->last_login_at,
                    'password_changed_at' => $user->password_changed_at,
                ],
                'institute' => $user->institute ? [
                    'id' => $user->institute->id,
                    'name' => $user->institute->name,
                    'code' => $user->institute->code,
                    'email' => $user->institute->configuration?->contact_email,
                    'phone' => $user->institute->configuration?->contact_phone,
                    'address' => $user->institute->configuration?->address,
                    'website' => $user->institute->configuration?->website,
                ] : null,
                'configuration' => $user->institute?->configuration ? [
                    'id' => $user->institute->configuration->id,
                    'institute_id' => $user->institute->configuration->institute_id,
                    'main_logo' => $user->institute->configuration->main_logo
                        ? asset('storage/' . $user->institute->configuration->main_logo) : null,
                    'small_logo' => $user->institute->configuration->small_logo
                        ? asset('storage/' . $user->institute->configuration->small_logo) : null,
                    'login_logo' => $user->institute->configuration->login_logo
                        ? asset('storage/' . $user->institute->configuration->login_logo) : null,
                    'login_cover_image' => $user->institute->configuration->login_cover_image
                        ? asset('storage/' . $user->institute->configuration->login_cover_image) : null,
                    'favicon' => $user->institute->configuration->favicon
                        ? asset('storage/' . $user->institute->configuration->favicon) : null,
                    'primary_color' => $user->institute->configuration->primary_color,
                    'secondary_color' => $user->institute->configuration->secondary_color,
                ] : null,
            ],
        ]);
    }
}
