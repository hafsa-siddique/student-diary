<?php

namespace App\Http\Controllers\API\v1\Parent;

use App\Http\Controllers\Controller;
use App\Http\Resources\DiaryAttachmentResource;
use App\Http\Resources\ParentDiaryResource;
use App\Models\DiaryAttachment;
use App\Models\DiaryEntry;
use App\Models\DiaryParentFeedback;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DiaryController extends Controller
{
    // Get published diaries for one of the parent's children.
    public function studentDiaries(Request $request,Student $student) 
    {
        $user = $request->user();
        $parent = $user->parent;
        if ($student->parent_id !== $parent->id ||
            $student->institute_id !== $user->institute_id
        ) {
            return response()->json([
                'status' => false,
                'message' => 'Student not found.',
            ], 404);
        }
        $validatedData = $request->validate([
            'date' => 'nullable|date',
            'subject_id' => 'nullable|integer|exists:subjects,id',
        ]);
        $enrollments = $student->enrollments()
            ->where('status', true)
            ->get();
        if ($enrollments->isEmpty()) {
            return response()->json([
                'status' => true,
                'message' => 'No published diaries found.',
                'data' => [],
            ], 200);
        }
        $diaries = DiaryEntry::with([
            'teacherAssignment.schoolClass',
            'teacherAssignment.section',
            'teacherAssignment.subject',
            'teacherAssignment.teacher.user',
            'teacherAssignment.academicSession',
            'attachments',
        ])
        ->where('status', 'published')
        ->whereHas('teacherAssignment', function ($query) use ($enrollments) {
            $query->where(function ($query) use ($enrollments) {
                foreach ($enrollments as $enrollment) {
                    $query->orWhere(function ($query) use ($enrollment) {
                        $query->where('class_id',$enrollment->class_id)
                        ->where('section_id',$enrollment->section_id)
                        ->where('academic_session_id',$enrollment->academic_session_id);
                    });
                }
            });
        });
        if (!empty($validatedData['date'])) {
            $diaries->whereDate('diary_date',$validatedData['date']);
        }
        if (!empty($validatedData['subject_id'])) {
            $diaries->whereHas('teacherAssignment',function ($query) use ($validatedData) {
                    $query->where('subject_id',$validatedData['subject_id']);
                }
            );
        }
         $diaries = $diaries->orderByDesc('diary_date')->paginate(10);

        foreach ($diaries->items() as $diary) {
            $diary->setRelation('studentContext', $student);
        }
        return response()->json([
            'status' => true,
            'message' => 'Student diaries retrieved successfully.',
            'data' => ParentDiaryResource::collection($diaries),
        ], 200);
    }

    public function show(Request $request,DiaryEntry $diary) 
    {
        $user = $request->user();
        $parent = $user->parent;
        if ($diary->status !== 'published') {
            return response()->json([
                'status' => false,
                'message' => 'Diary not found.',
            ], 404);
        }
        $diary->load([
            'teacherAssignment.schoolClass',
            'teacherAssignment.section',
            'teacherAssignment.subject',
            'teacherAssignment.teacher.user',
            'teacherAssignment.academicSession',
            'attachments',
        ]);
        if (!$diary->teacherAssignment) {
            return response()->json([
                'status' => false,
                'message' => 'Diary not found.',
            ], 404);
        }
        $student = Student::where('parent_id', $parent->id)
            ->where('institute_id', $user->institute_id)
            ->whereHas('enrollments', function ($query) use ($diary) {
                $query->where('status', true)
                    ->where('class_id',$diary->teacherAssignment->class_id)
                    ->where('section_id',$diary->teacherAssignment->section_id)
                    ->where('academic_session_id',$diary->teacherAssignment->academic_session_id);
            })->first();
        if (!$student) {
            return response()->json([
                'status' => false,
                'message' => 'Diary not found.',
            ], 404);
        }
        $diary->setRelation('studentContext', $student);
        return response()->json([
            'status' => true,
            'message' => 'Diary retrieved successfully.',
            'data' => new ParentDiaryResource($diary),
        ], 200);
    }

    public function attachments(Request $request,DiaryEntry $diary)
    {
        $user = $request->user();
        $parent = $user->parent;
        if ($diary->status !== 'published') {
            return response()->json([
                'status' => false,
                'message' => 'Diary not found.',
            ], 404);
        }
        $diary->load('teacherAssignment');
        if (!$diary->teacherAssignment) {
            return response()->json([
                'status' => false,
                'message' => 'Diary not found.',
            ], 404);
        }
        $student = Student::where('parent_id', $parent->id)
            ->where('institute_id', $user->institute_id)
            ->whereHas('enrollments', function ($query) use ($diary) {
                $query->where('status', true)
                    ->where('class_id',$diary->teacherAssignment->class_id)
                    ->where('section_id',$diary->teacherAssignment->section_id)
                    ->where('academic_session_id',$diary->teacherAssignment->academic_session_id);
            })->exists();
        
        if (!$student) {
            return response()->json([
                'status' => false,
                'message' => 'Diary not found.',
            ], 404);
        }
        $attachments = $diary->attachments() ->paginate(5); 
        return response()->json([ 
            'status' => true, 
            'message' => 'Diary attachments retrieved successfully.', 
            'data' => DiaryAttachmentResource::collection( $attachments ),
         ], 200);
    }

    public function downloadAttachment(Request $request, DiaryEntry $diary, DiaryAttachment $attachment)
    {
        $user = $request->user();
        $parent = $user->parent;
        if ($diary->status !== 'published') {
            return response()->json([
                'status' => false,
                'message' => 'Diary not found.',
            ], 404);
        }
        if ($attachment->diary_entry_id !== $diary->id) { 
            return response()->json([ 
                'status' => false, 
                'message' => 'Attachment not found.', 
            ], 404); 
        }
        $diary->load('teacherAssignment');
        if (!$diary->teacherAssignment) {
            return response()->json([
                'status' => false,
                'message' => 'Diary not found.',
            ], 404);
        }
        $student = Student::where('parent_id', $parent->id)
            ->where('institute_id', $user->institute_id)
            ->whereHas('enrollments', function ($query) use ($diary) {
                $query->where('status', true)
                    ->where('class_id',$diary->teacherAssignment->class_id)
                    ->where('section_id',$diary->teacherAssignment->section_id)
                    ->where('academic_session_id',$diary->teacherAssignment->academic_session_id);
            })->exists();
        if (!$student) {
            return response()->json([
                'status' => false,
                'message' => 'Diary not found.',
            ], 404);
        }
        if ( !$attachment->file_path || 
            !Storage::disk('public')->exists( $attachment->file_path ) 
            ) { 
                return response()->json([ 
                    'status' => false, 
                    'message' => 'Attachment file not found.',
                ], 404); 
        }
        $filePath = Storage::disk('public')->path($attachment->file_path);
        return response()->download(
            $filePath,
            $attachment->file_name
        );
    }
    public function updateFeedback(Request $request, DiaryEntry $diary)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'is_completed' => 'boolean',
            'remarks' => 'nullable|string|max:1000',
        ]);
        $feedback = DiaryParentFeedback::firstOrNew(
            [
                'diary_entry_id' => $diary->id,
                'student_id' => $validated['student_id'],
            ]);
        $feedback->parent_id = $request->user()->id;    
        if ($request->has('is_completed')) {
            $feedback->is_completed = $validated['is_completed'];
        }
        if ($request->has('remarks')) {
            $feedback->remarks = $validated['remarks'];
        }
        $feedback->save();
        return response()->json([
            'status' => true,
            'message' => 'Feedback saved successfully.',
            'data' => $feedback,
        ]);
    }
}