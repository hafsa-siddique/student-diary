<?php

namespace App\Http\Controllers\API\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ParentResource;
use App\Http\Resources\StudentResource;
use App\Models\ParentModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ParentController extends Controller
{
    public function index(Request $request)
    {
        $instituteId = $request->user()->institute_id;
        $query = ParentModel::where('institute_id', $instituteId);
        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status',$request->status === 'active' ? 1 : 0
            );
        }
        $parents = $query->latest()->paginate(5);
        $statistics = ParentModel::where('institute_id', $instituteId)
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('SUM(status = 1) as active')
            ->selectRaw('SUM(status = 0) as inactive')
            ->first();
        return response()->json([
            'status' => true,
            'count' => $parents->total(),
            'message' => 'Parents retrieved successfully.',
            'data' => ParentResource::collection($parents->items()),
            'statistics' => [
                'total' => (int) $statistics->total,
                'active' => (int) $statistics->active,
                'inactive' => (int) $statistics->inactive,
            ],
            'meta' => [
                'current_page' => $parents->currentPage(),
                'last_page' => $parents->lastPage(),
                'per_page' => $parents->perPage(),
                'total' => $parents->total(),
                'from' => $parents->firstItem(),
                'to' => $parents->lastItem(),
            ],
        ], 200);
    }

    public function store(Request $request)
    {
        $instituteId = $request->user()->institute_id;
        $validatedData = $request->validate([
            'name' => 'required|string|regex:/^[A-Za-z ]+$/|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:30',
            'relationship' => 'nullable|string',
            'status' => 'sometimes|boolean',
        ]);
        $parent = DB::transaction(function () use ($validatedData, $instituteId) {
            $user = User::create([
                'institute_id' => $instituteId,
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => 'parent',
                'status' => $validatedData['status'] ?? true,
            ]);
            $parentData = [
                'user_id' => $user->id,
                'institute_id' => $instituteId,
                'phone' => $validatedData['phone'] ?? null,
                'relationship' => $validatedData['relationship'] ?? null,
                'status' => $validatedData['status'] ?? true,
            ];
            $parent = ParentModel::create($parentData);
            return $parent->load('user');
        });
        return response()->json([
            'status' => true,
            'message' => 'Parent created successfully.',
            'data' => new ParentResource($parent),
        ], 201);
    }

    public function show(Request $request,ParentModel $parent)
    {
        if ($parent->institute_id !== $request->user()->institute_id) {
            return response()->json([
                'status' => false,
                'message' => 'Parent not found.',
            ], 404);
        }
        $parent->load('user');
        return response()->json([
            'status' => true,
            'message' => 'Parent retrieved successfully.',
            'data' => new ParentResource($parent),
        ], 200);
    }

    public function update(Request $request, ParentModel $parent)
    {
        if ($parent->institute_id !== $request->user()->institute_id) {
            return response()->json([
                'status' => false,
                'message' => 'Parent not found.',
            ], 404);
        }
        $parent->load('user');
        $validatedData = $request->validate([
            'name' => 'required|string|regex:/^[A-Za-z ]+$/|max:255',
            'email' => 'required|email|unique:users,email,' . $parent->user_id,
            'password' => 'nullable|string|min:8',
            'phone' => 'nullable|string|max:30',
            'relationship' => 'nullable|string',
        ]);
        DB::transaction(function () use ($parent, $validatedData) {
            $parent->user->name = $validatedData['name'];
            $parent->user->email = $validatedData['email'];
            if (!empty($validatedData['password'])) {
                $parent->user->password =
                    Hash::make($validatedData['password']);
            }
            $parent->user->save();
            $parent->phone = $validatedData['phone'] ?? null;
            $parent->relationship = $validatedData['relationship'] ?? null;
            $parent->save();
        });
        $parent->load('user');
        return response()->json([
            'status' => true,
            'message' => 'Parent updated successfully.',
            'data' => new ParentResource($parent),
        ], 200);
    }

    public function destroy(Request $request, ParentModel $parent)
    {
        if ($parent->institute_id !== $request->user()->institute_id) {
            return response()->json([
                'status' => false,
                'message' => 'Parent not found.',
            ], 404);
        }
        if ($parent->students()->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Parent cannot be deleted because they have students.',
            ], 422);
        }
        DB::transaction(function () use ($parent) {
            $user = $parent->user;
            $parent->delete();
            if ($user) {
                $user->delete();
            }
        });
        return response()->json([
            'status' => true,
            'message' => 'Parent deleted successfully.',
        ], 200);
    }

    public function updateStatus(Request $request, ParentModel $parent)
    {
        if ($parent->institute_id !== $request->user()->institute_id) {
            return response()->json([
                'status' => false,
                'message' => 'Parent not found.',
            ], 404);
        }
        $newStatus = !$parent->status;
        DB::transaction(function () use ($parent, $newStatus) {
            $parent->status = $newStatus;
            $parent->save();
            if ($parent->user) {
                $parent->user->status = $newStatus;
                $parent->user->save();
            }
        });
        return response()->json([
            'status' => true,
            'message' => $newStatus
                ? 'Parent activated successfully.'
                : 'Parent deactivated successfully.',
            'data' => new ParentResource($parent->load('user')),
        ], 200);
    }

    public function students(Request $request, ParentModel $parent)
    {
        $instituteId = $request->user()->institute_id;
        if ($parent->institute_id !== $instituteId) {
            return response()->json([
                'status' => false,
                'message' => 'Parent not found.',
            ], 404);
        }

        $students = $parent->students()
            ->where('institute_id', $instituteId)
            ->with([
                    'enrollments.schoolClass',
                    'enrollments.section',
                ])
            ->paginate(5);

        return response()->json([
            'status' => true,
            'message' => 'Parent students retrieved successfully.',
            'data' => StudentResource::collection($students),
        ], 200);
    }
}
