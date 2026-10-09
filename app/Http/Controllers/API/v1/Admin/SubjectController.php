<?php

namespace App\Http\Controllers\API\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectResource;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $instituteId = $request->user()->institute_id;
        $query = Subject::where('institute_id', $instituteId);
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status === 'active');
        }
        $subjects = $query
            ->orderBy('id')
            ->paginate($request->integer('per_page', 5))
            ->withQueryString();
        $total = Subject::where('institute_id', $instituteId)->count();
        $active = Subject::where('institute_id', $instituteId)
            ->where('status', 1)
            ->count();
        $inactive = $total - $active;
        return SubjectResource::collection($subjects)
            ->additional([
                'status' => true,
                'message' => 'Subjects retrieved successfully.',
                'statistics' => [
                    'total' => $total,
                    'active' => $active,
                    'inactive' => $inactive,
                ],
            ]);
    }

    public function store(Request $request)
    {
        $instituteId = $request->user()->institute_id;
        $validatedData = $request->validate([
            'name' => 'required|string|max:100|unique:subjects,name,NULL,id,institute_id,' . $instituteId,
            'code' => 'required|string|max:50|unique:subjects,code,NULL,id,institute_id,' . $instituteId,
            'description' => 'nullable|string',
            'status' => 'sometimes|boolean',
        ]);
        $subject = Subject::create([
            'institute_id' => $instituteId,
            'name' => $validatedData['name'],
            'code' => $validatedData['code'],
            'description' => $validatedData['description'] ?? null,
            'status' => $validatedData['status'] ?? true,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Subject created successfully.',
            'data' => new SubjectResource($subject),
        ], 201);
    }

    public function show(Request $request, Subject $subject)
    {
        $instituteId = $request->user()->institute_id;
        if ($subject->institute_id !== $instituteId) {
            return response()->json([
                'status' => false,
                'message' => 'Subject not found.',
            ], 404);
        }
        $subject->loadCount([
            'classes',
            'teacherAssignments',
        ]);
        $subject->class_names = $subject->classes()
        ->pluck('name')
        ->values();
        return response()->json([
            'status' => true,
            'message' => 'Subject retrieved successfully.',
            'data' => new SubjectResource($subject),
        ], 200);
    }

    public function update(Request $request, Subject $subject)
    {
        $instituteId = $request->user()->institute_id;
        if ($subject->institute_id !== $instituteId) {
            return response()->json([
                'status' => false,
                'message' => 'Subject not found.',
            ], 404);
        }
        $validatedData = $request->validate([
            'name' => 'required|string|max:100|unique:subjects,name,' . $subject->id . ',id,institute_id,' . $instituteId,
            'code' => 'required|string|max:50|unique:subjects,code,' . $subject->id . ',id,institute_id,' . $instituteId,
            'description' => 'nullable|string',
             'status' => 'sometimes|boolean',
        ]);
        $subject->update([
            'name' => $validatedData['name'],
            'code' => $validatedData['code'],
            'description' => $validatedData['description'] ?? null,
            'status' => $validatedData['status'] ?? $subject->status,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Subject updated successfully.',
            'data' => new SubjectResource($subject),
        ], 200);
    }

    public function destroy(Request $request, Subject $subject)
    {
        $instituteId = $request->user()->institute_id;
        if ($subject->institute_id !== $instituteId) {
            return response()->json([
                'status' => false,
                'message' => 'Subject not found.',
            ], 404);
        }
        if ($subject->classes()->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Subject cannot be deleted because it is assigned to classes.',
            ], 422);
        }
        if ($subject->teacherAssignments()->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Subject cannot be deleted because it has teacher assignments.',
            ], 422);
        }
        $subject->delete();
        return response()->json([
            'status' => true,
            'message' => 'Subject deleted successfully.',
        ], 200);
    }

    public function updateStatus(Request $request, Subject $subject)
    {
        $instituteId = $request->user()->institute_id;
        if ($subject->institute_id !== $instituteId) {
            return response()->json([
                'status' => false,
                'message' => 'Subject not found.',
            ], 404);
        }
        $subject->status = !$subject->status;
        $subject->save();
        return response()->json([
            'status' => true,
            'message' => $subject->status
                ? 'Subject activated successfully.'
                : 'Subject deactivated successfully.',
            'data' => new SubjectResource($subject),
        ], 200);
    }
}