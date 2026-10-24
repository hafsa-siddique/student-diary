<?php

namespace App\Http\Controllers\API\v1\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentDailyReport;
use App\Models\TeacherAssignment;
use Illuminate\Http\Request;

class CleanlinessReportController extends Controller
{
    public function getInchargeClassStudents(Request $request)
    {
        $teacherId = $request->user()->teacher->id ?? null;
        
        if (!$teacherId) {
            return response()->json([
                'status' => false, 
                'message' => 'Teacher profile not found.'
            ], 404);
        }
        $assignment = TeacherAssignment::where('teacher_id', $teacherId)
            ->where('is_incharge', 1)
            ->where('status', 1)
            ->with(['schoolClass', 'section'])
            ->first();

        if (!$assignment) {
            return response()->json([
                'status' => false, 
                'message' => 'You are not assigned as a class in-charge for any active class.'
            ], 403);
        }

        $students = Student::whereHas('enrollments', function($q) use ($assignment) {
            $q->where('class_id', $assignment->class_id)
            ->where('section_id', $assignment->section_id)
            ->where('academic_session_id', $assignment->academic_session_id)
            ->where('status', true);
        })->get();

        $reportDate = $request->query('date', today()->toDateString());
        $existingReports = StudentDailyReport::where('report_date', $reportDate)
            ->where('class_id', $assignment->class_id)
            ->where('section_id', $assignment->section_id)
            ->get()
            ->keyBy('student_id');

        return response()->json([
            'status' => true,
            'class_info' => $assignment,
            'students' => $students,
            'existing_reports' => $existingReports
        ]);
    }
    public function storeReports(Request $request)
    {
        $request->validate([
            'reports' => 'required|array',
            'reports.*.student_id' => 'required|exists:students,id',
            'reports.*.class_id' => 'required|exists:classes,id',
            'reports.*.section_id' => 'required|exists:sections,id',
            'reports.*.uniform_status' => 'required|string',
            'reports.*.cleanliness_status' => 'required|string',
        ]);

        $teacherId = $request->user()->teacher->id ?? null;
        $today = today()->toDateString();

        foreach ($request->reports as $reportData) {
            StudentDailyReport::updateOrCreate(
                [
                    'student_id' => $reportData['student_id'],
                    'report_date' => $today,
                ],
                [
                    'class_id' => $reportData['class_id'],
                    'section_id' => $reportData['section_id'],
                    'teacher_id' => $teacherId,
                    'uniform_status' => $reportData['uniform_status'],
                    'cleanliness_status' => $reportData['cleanliness_status'],
                ]
            );
        }

        return response()->json([
            'status' => true,
            'message' => 'Daily uniform & cleanliness reports saved successfully.'
        ]);
    }
}
