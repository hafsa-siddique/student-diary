<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentDailyReport extends Model
{
    protected $table = 'student_daily_reports';

    protected $fillable = [
        'student_id',
        'class_id',
        'section_id',
        'teacher_id',
        'report_date',
        'uniform_status',
        'cleanliness_status',
        'parent_signed',
        'parent_signed_at'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
