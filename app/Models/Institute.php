<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Institute extends Model
{
     protected $fillable = [
        'name',
        'code',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function configuration(): HasOne
    {
        return $this->hasOne(Configuration::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function teachers(): HasMany
    {
        return $this->hasMany(Teacher::class);
    }

    public function parents(): HasMany
    {
        return $this->hasMany(ParentModel::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function academicSessions(): HasMany
    {
        return $this->hasMany(AcademicSession::class);
    }

    public function classes(): HasMany
    {
        return $this->hasMany(SchoolClass::class);
    }

    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }

    public function hasRelatedRecords(): bool
    {
        return $this->configuration()->exists()
            || $this->users()->exists()
            || $this->teachers()->exists()
            || $this->parents()->exists()
            || $this->students()->exists()
            || $this->academicSessions()->exists()
            || $this->classes()->exists()
            || $this->subjects()->exists();
    }
}
