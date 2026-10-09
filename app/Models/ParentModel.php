<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ParentModel extends Model
{
    // We use ParentModel instead of Parent
    //  because parent is a PHP language keyword/context that we should avoid using as a class name.

    protected $table = 'parents';

    protected $fillable = [
        'user_id',
        'institute_id',
        'phone',
        'relationship',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class,'parent_id');
    }
}
