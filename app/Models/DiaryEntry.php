<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiaryEntry extends Model
{
    protected $fillable = [
        'teacher_assignment_id',
        'diary_date',
        'classwork',
        'homework',
        'instructions',
        'due_date',
        'status',
        'scheduled_at',
        'published_at',
    ];

    protected $casts = [
        'diary_date' => 'date',
        'due_date' => 'date',
        'scheduled_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    public function teacherAssignment(): BelongsTo
    {
        return $this->belongsTo(TeacherAssignment::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(DiaryAttachment::class);
    }
    public function parentFeedbacks()
{
    return $this->hasMany(DiaryParentFeedback::class);
}
}
