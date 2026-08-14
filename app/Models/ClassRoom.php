<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Student;

class ClassRoom extends Model
{
    protected $fillable = [
        'class_name',
        'description',
        'image'
    ];


    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }


    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function classSubjects()
{
    return $this->hasMany(ClassSubject::class);
}

public function subjects()
{
    return $this->belongsToMany(
        Subject::class,
        'class_subjects'
    )->withPivot([
        'subject_type',
        'full_marks',
        'pass_marks',
        'status',
    ])->withTimestamps();
}

public function nurseryActivityAssessments()
{
    return $this->hasMany(NurseryActivityAssessment::class);
}
}