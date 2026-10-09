<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiaryAttachment extends Model
{
    protected $fillable = [
        'diary_entry_id',
        'file_name',
        'file_path',
        'file_type',
    ];

    public function diaryEntry(): BelongsTo
    {
        return $this->belongsTo(DiaryEntry::class);
    }
}
