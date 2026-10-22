<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiaryParentFeedback extends Model
{
    protected $table = 'diary_parent_feedbacks';
    protected $fillable = [
        'diary_entry_id',
        'student_id',
        'parent_id',
        'is_completed',
        'remarks',
        'teacher_acknowledged',
        'acknowledged_at',
    ];

    public function diaryEntry(): BelongsTo
    {
        return $this->belongsTo(DiaryEntry::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_id');
    }
}
