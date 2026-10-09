<?php

namespace App\Http\Controllers\API\v1\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Resources\DiaryAttachmentResource;
use App\Models\DiaryAttachment;
use App\Models\DiaryEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DiaryAttachmentController extends Controller
{
    public function store(Request $request, DiaryEntry $diary)
    {
        $user = $request->user();
        $teacher = $user->teacher;
        if (!$teacher) {
            return response()->json([
                'status' => false,
                'message' => 'Teacher profile not found.',
            ], 404);
        }
        $diary->load('teacherAssignment');
        if (!$diary->teacherAssignment ||
            $diary->teacherAssignment->teacher_id !== $teacher->id
        ) {
            return response()->json([
                'status' => false,
                'message' => 'Diary not found.',
            ], 404);
        }
        $validatedData = $request->validate([
            'attachment' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ]);
        $file = $validatedData['attachment'];
        $path = $file->store('diaries', 'public');
        $attachment = DiaryAttachment::create([
            'diary_entry_id' => $diary->id,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'file_type' => $file->getClientMimeType(),
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Attachment uploaded successfully.',
            'data' => new DiaryAttachmentResource($attachment),
        ], 201);
    }

    public function index(Request $request, DiaryEntry $diary)
    {
        $user = $request->user();
        $teacher = $user->teacher;
        if (!$teacher) {
            return response()->json([
                'status' => false,
                'message' => 'Teacher profile not found.',
            ], 404);
        }
        $diary->load('teacherAssignment');

        if (!$diary->teacherAssignment ||
            $diary->teacherAssignment->teacher_id !== $teacher->id
        ) {
            return response()->json([
                'status' => false,
                'message' => 'Diary not found.',
            ], 404);
        }
        $attachments = $diary->attachments()->paginate(5);
        return response()->json([
            'status' => true,
            'message' => 'Diary attachments retrieved successfully.',
            'data' => DiaryAttachmentResource::collection($attachments),
        ], 200);
    }

    public function destroy(Request $request,DiaryEntry $diary,DiaryAttachment $attachment) 
    {
        $user = $request->user();
        $teacher = $user->teacher;
        if (!$teacher) {
            return response()->json([
                'status' => false,
                'message' => 'Teacher profile not found.',
            ], 404);
        }
        $diary->load('teacherAssignment');

        if (!$diary->teacherAssignment ||
            $diary->teacherAssignment->teacher_id !== $teacher->id
        ) {
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
        if ($attachment->file_path) {
            Storage::disk('public')->delete($attachment->file_path);
        }
        $attachment->delete();
        return response()->json([
            'status' => true,
            'message' => 'Attachment deleted successfully.',
        ], 200);
    }
}