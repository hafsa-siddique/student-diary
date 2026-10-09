<?php

namespace App\Http\Controllers\API\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassResource;
use App\Http\Resources\SubjectResource;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;

class ClassSubjectController extends Controller
{
    public function assign(Request $request, SchoolClass $class)
    {
        $instituteId = $request->user()->institute_id;
        if($class->institute_id !== $instituteId){
            return response()->json([
                'status' => false,
                'message' => 'Class not found.',
            ], 404);
        }
        $validatedData = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
        ]);
        $subject = Subject::where('id', $validatedData['subject_id'])
            ->where('institute_id', $instituteId)
            ->first();

        if (!$subject) {
            return response()->json([
                'status' => false,
                'message' => 'Subject not found in your institute.',
            ], 404);
        }
        if($class->subjects()->where('subjects.id',$subject->id)->exists()){
            return response()->json([
                'status' => false,
                'message' => 'This subject is already assigned to this class.',
            ], 422);
        }
        $class->subjects()->attach($subject->id);

        return response()->json([
            'status' => true,
            'message' => 'Subject assigned to class successfully.',
            'data' => [
                'class' => new ClassResource($class),
                'subject' => new SubjectResource($subject),
            ],
        ],201);
    }

    public function subjects(Request $request, SchoolClass $class)
    {
        $instituteId = $request->user()->institute_id;
        if ($class->institute_id !== $instituteId) {
            return response()->json([
                'status' => false,
                'message' => 'Class not found.',
            ], 404);
        }
        $subjects = $class->subjects()->paginate(5);

        return response()->json([
            'status' => true,
            'message' => 'Class subjects retrieved successfully.',
            'data' => SubjectResource::collection($subjects),
        ], 200);
    }

    public function classes(Request $request, Subject $subject)
    {
        $instituteId = $request->user()->institute_id;
        if ($subject->institute_id !== $instituteId) {
            return response()->json([
                'status' => false,
                'message' => 'Subject not found.',
            ], 404);
        }
        $classes = $subject->classes()->paginate(5);

        return response()->json([
            'status' => true,
            'message' => 'Subject classes retrieved successfully.',
            'data' => ClassResource::collection($classes),
        ], 200);
    }

    public function remove(Request $request,SchoolClass $class,Subject $subject) 
    {
        $instituteId = $request->user()->institute_id;
        if ($class->institute_id !== $instituteId) {
            return response()->json([
                'status' => false,
                'message' => 'Class not found.',
            ], 404);
        }
        if ($subject->institute_id !== $instituteId) {
            return response()->json([
                'status' => false,
                'message' => 'Subject not found.',
            ], 404);
        }
        if (!$class->subjects()->where('subjects.id', $subject->id)->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'This subject is not assigned to this class.',
            ], 404);
        }

        $class->subjects()->detach($subject->id);

        return response()->json([
            'status' => true,
            'message' => 'Subject removed from class successfully.',
        ], 200);
    }
}
