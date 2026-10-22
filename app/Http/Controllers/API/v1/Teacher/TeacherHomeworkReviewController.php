<?php

namespace App\Http\Controllers\API\v1\Teacher;

use App\Http\Controllers\Controller;
use App\Models\DiaryEntry;
use App\Models\DiaryParentFeedback;
use App\Models\Student;
use App\Models\TeacherAssignment;
use Illuminate\Http\Request;

class TeacherHomeworkReviewController extends Controller
{
    public function getStudentsHomeworkReview(Request $request, $assignmentId)
    {
        $date = $request->query('date', now()->subDay()->toDateString()); 
        $assignment = TeacherAssignment::with(['schoolClass', 'section', 'subject'])->findOrFail($assignmentId);
        $diary = DiaryEntry::where('teacher_assignment_id', $assignmentId)
            ->where('diary_date', $date)
            ->first();
        $students = Student::whereHas('enrollments', function ($query) use ($assignment) {
            $query->where('class_id', $assignment->class_id)
                ->where('section_id', $assignment->section_id)
                ->where('academic_session_id',$assignment->academic_session_id);
        })
        ->orderBy('id', 'asc')
        ->get();
        $studentList = $students->map(function ($student) use ($diary) {
            $feedback = null;
            if ($diary) {
                $feedback = DiaryParentFeedback::where('diary_entry_id', $diary->id)
                    ->where('student_id', $student->id)
                    ->first();
            }

            return [
                'student_id' => $student->id,
                'roll_number' => $student->roll_number ?? '—',
                'student_name' => $student->name,
                'feedback_id' => $feedback?->id,
                'is_completed' => $feedback?->is_completed ?? false,
                'remarks' => $feedback?->remarks ?? '',
                'teacher_acknowledged' => $feedback?->teacher_acknowledged ?? false,
                'acknowledged_at' => $feedback?->acknowledged_at,
            ];
        });

        $totalStudents = $students->count();
        $completedCount = $studentList->where('is_completed', true)->count();
        $pendingCount = $totalStudents - $completedCount;
        $remarksCount = $studentList->where('remarks', '!=', '')->count();

        return response()->json([
            'status' => true,
            'data' => [
                'assignment' => [
                    'class' => $assignment->schoolClass->name ?? '—',
                    'section' => $assignment->section->name ?? '—',
                    'subject' => $assignment->subject->name ?? '—',
                    'date' => $date,
                    'diary_exists' => (bool)$diary,
                ],
                'summary' => [
                    'total' => $totalStudents,
                    'completed' => $completedCount,
                    'pending' => $pendingCount,
                    'new_remarks' => $remarksCount,
                ],
                'students' => $studentList->values()
            ]
        ]);
    }
    public function acknowledge(Request $request, $feedbackId)
    {
        $feedback = DiaryParentFeedback::findOrFail($feedbackId);
        $feedback->update([
            'teacher_acknowledged' => true,
            'acknowledged_at' => now(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Remark acknowledged successfully.',
            'data' => $feedback
        ]);
    }
}
