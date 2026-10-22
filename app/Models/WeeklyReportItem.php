<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyReportItem extends Model
{
    protected $fillable = [
        'weekly_report_id', 'teacher_assignment_id', 
        'grade_or_score', 'remarks'
    ];

    public function weeklyReport() {
        return $this->belongsTo(WeeklyReport::class);
    }

    public function teacherAssignment() {
        return $this->belongsTo(TeacherAssignment::class);
    }
}
