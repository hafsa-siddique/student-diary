<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyReport extends Model
{
    protected $fillable = [
        'student_id', 'class_id', 'section_id', 
        'week_start_date', 'week_end_date', 
        'parent_signed', 'signed_at', 'parent_name', 'signature_ref_id'
    ];

    protected $casts = [
        'parent_signed' => 'boolean',
        'signed_at' => 'datetime',
    ];

    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function items() {
        return $this->hasMany(WeeklyReportItem::class);
    }
}
