<?php

namespace App\Http\Controllers\API\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SectionResource;
use App\Models\Section;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index(Request $request)
    {
        $instituteId = $request->user()->institute_id;
        $sections = Section::with('schoolClass')
            ->whereHas('schoolClass', function ($query) use ($instituteId) {
                $query->where('institute_id', $instituteId);
            })->paginate(5);
        return response()->json([
            'status' => true,
            'message' => 'Sections retrieved successfully.',
            'data' => SectionResource::collection($sections),
        ], 200);
    }

    public function store(Request $request)
    {
        $instituteId = $request->user()->institute_id;
        $validatedData = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'name' => 'required|string|max:100',
            'status' => 'sometimes|boolean',
        ]);
        $class = SchoolClass::where('id', $validatedData['class_id'])
            ->where('institute_id', $instituteId)
            ->first();
        if (!$class) {
            return response()->json([
                'status' => false,
                'message' => 'Class not found in your institute.',
            ], 404);
        }
        $sectionExists = Section::where('class_id', $class->id)
            ->where('name', $validatedData['name'])
            ->exists();
        if ($sectionExists) {
            return response()->json([
                'status' => false,
                'message' => 'This section already exists in this class.',
            ], 422);
        }
        $section = Section::create([
            'class_id' => $class->id,
            'name' => $validatedData['name'],
            'status' => $validatedData['status'] ?? true,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Section created successfully.',
            'data' => new SectionResource($section),
        ], 201);
    }

    public function show(Request $request, Section $section)
    {
        $instituteId = $request->user()->institute_id;
        $section->load('schoolClass');
        if (!$section->schoolClass || $section->schoolClass->institute_id !== $instituteId) {
            return response()->json([
                'status' => false,
                'message' => 'Section not found.',
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'Section retrieved successfully.',
            'data' => new SectionResource($section),
        ], 200);
    }

    public function update(Request $request, Section $section)
    {
        $instituteId = $request->user()->institute_id;
        $section->load('schoolClass');
        if (!$section->schoolClass || $section->schoolClass->institute_id !== $instituteId) {
            return response()->json([
                'status' => false,
                'message' => 'Section not found.',
            ], 404);
        }
        $validatedData = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'name' => 'required|string|max:100',
        ]);
        $newClass = SchoolClass::where('id', $validatedData['class_id'])
            ->where('institute_id', $instituteId)
            ->first();
        if (!$newClass) {
            return response()->json([
                'status' => false,
                'message' => 'Class not found in your institute.',
            ], 404);
        }
        $sectionExists = Section::where('class_id', $newClass->id)
            ->where('name', $validatedData['name'])
            ->where('id', '!=', $section->id)
            ->exists();
        if ($sectionExists) {
            return response()->json([
                'status' => false,
                'message' => 'This section already exists in this class.',
            ], 422);
        }
        $section->update([
            'class_id' => $newClass->id,
            'name' => $validatedData['name'],
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Section updated successfully.',
            'data' => new SectionResource($section),
        ], 200);
    }

    public function destroy(Request $request, Section $section)
    {
        $instituteId = $request->user()->institute_id;
        $section->load('schoolClass');
        if (!$section->schoolClass || $section->schoolClass->institute_id !== $instituteId) {
            return response()->json([
                'status' => false,
                'message' => 'Section not found.',
            ], 404);
        }
        if ($section->enrollments()->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Section cannot be deleted because it has enrollment records.',
            ], 422);
        }
        if ($section->teacherAssignments()->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Section cannot be deleted because it has teacher assignments.',
            ], 422);
        }
        $section->delete();
        return response()->json([
            'status' => true,
            'message' => 'Section deleted successfully.',
        ], 200);
    }

    public function updateStatus(Request $request, Section $section)
    {
        $instituteId = $request->user()->institute_id;
        $section->load('schoolClass');
        if (!$section->schoolClass || $section->schoolClass->institute_id !== $instituteId) {
            return response()->json([
                'status' => false,
                'message' => 'Section not found.',
            ], 404);
        }
        $section->status = !$section->status;
        $section->save();
        return response()->json([
            'status' => true,
            'message' => $section->status
                ? 'Section activated successfully.'
                : 'Section deactivated successfully.',
            'data' => new SectionResource($section),
        ], 200);
    }
}