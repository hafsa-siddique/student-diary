<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'institute_id',
        'user_id',
        'message',
        'date',
    ];
}
