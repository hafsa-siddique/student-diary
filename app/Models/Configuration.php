<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Configuration extends Model
{
    protected $fillable = [
        'institute_id',
        'main_logo',
        'small_logo',
        'login_logo',
        'favicon',
        'primary_color',
        'secondary_color',
        'contact_email',
        'contact_phone',
        'address',
        'website',
    ];

    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }
}
