<?php

namespace App\Http\Controllers\API\v1\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Resources\InstituteResource;
use App\Models\Configuration;
use App\Models\Institute;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InstituteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $institutes = Institute::query()
            ->when($request->filled('search'), fn($q) => $q->where(function ($q) use ($request) {
                $search = $request->search;
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%");
            }))
            ->latest()
            ->paginate($request->input('per_page', 5));
        return response()->json([
            'status' => true,
            'message' => 'Institutes retrieved successfully.',
            'statistics' => [
                'total' => Institute::count(),
                'active' => Institute::where('status', '1')->count(),
                'inactive' => Institute::where('status', '0')->count(),
            ],
            'data' => InstituteResource::collection($institutes),
            'pagination' => [
                'current_page' => $institutes->currentPage(),
                'last_page' => $institutes->lastPage(),
                'per_page' => $institutes->perPage(),
                'total' => $institutes->total(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:institutes,code',
            'status' => 'sometimes|boolean'
        ]);

        $institute = Institute::create($validatedData);

        return response()->json([
            'status' => true,
            'message' => 'Institute created successfully',
            'data' => new InstituteResource($institute)
        ],201);
    }

    public function show(Institute $institute)
    {
        return response()->json([
            'status' => true,
            'message' => 'Institute Info',
            'data' => new InstituteResource($institute)
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Institute $institute)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:institutes,code,'.$institute->id,
            'status' => 'sometimes|boolean'
        ]);
        $institute->update($validatedData);
        return response()->json([
            'status' => true,
            'message' => 'Institute updated successfully',
            'data' => new InstituteResource($institute)
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Institute $institute)
    {
        if($institute->status){
            return response()->json([
                'status' => false,
                'message' => 'Active institute cannot be deleted. Deactivate it first.',
            ], 422);
        }

         if ($institute->hasRelatedRecords()) {
            return response()->json([
                'status' => false,
                'message' => 'Institute cannot be deleted because it has related records.',
            ], 422);
        }

        $institute->delete();
        return response()->json([
            'status' => true,
            'message' => 'Institute deleted successfully',
        ],200);
    }

    public function updateStatus(Institute $institute)
    {
        $institute->status = !$institute->status;
        $institute->save();
        return response()->json([
            'status' => true,
            'message' => $institute->status
                ? 'Institute activated successfully.'
                : 'Institute deactivated successfully.',
            'data' => new InstituteResource($institute),
        ], 200);
    }
    public function storeInstituteWithAdmin(Request $request) 
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:institutes,code',
            'status' => 'sometimes|boolean',
            'admin_name' => 'required|string|regex:/^[A-Za-z ]+$/|max:255',
            'admin_email' => 'required|email|unique:users,email',
            'admin_password' => 'required|string|min:8',
        ]);
        $result = DB::transaction(function () use ($request) {
            // Create Institute
            $institute = Institute::create([
                'name' => $request->name,
                'code' => strtoupper($request->code),
                'status' => $request->status ?? 1,
            ]);
            $adminRole = Role::where('slug', 'admin')->first();
            $admin = User::create([
                'institute_id' => $institute->id,
                'name' => $request->admin_name,
                'email' => $request->admin_email,
                'password' => Hash::make($request->admin_password),
                'role_id' => $adminRole?->id,
                'status' => 1,
            ]);

            Configuration::create([
                'institute_id' => $institute->id,
                'contact_email' => $request->admin_email,
                'contact_phone' => null,
                'address' => null,
                'website' => null,
                'primary_color' => '#166534', 
                'secondary_color' => '#84CC16', 
                'main_logo' => null,
                'small_logo' => null,
                'login_logo' => null,
                'login_cover_image' => null,
                'favicon' => null,
            ]);

            return $institute;
        });

        return response()->json([
            'status' => true,
            'message' => 'Institute, admin, and configurations created successfully',
            'data' => new InstituteResource($result)
        ], 201);
    }
}
