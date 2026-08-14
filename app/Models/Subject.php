<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
    'teacher_id',
    'subject_name',
    'subject_code',
    'description',
    'status',
];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function classSubjects()
    {
        return $this->hasMany(ClassSubject::class);
    }

    public function classRooms()
    {
        return $this->belongsToMany(
            ClassRoom::class,
            'class_subjects'
        )->withPivot([
            'subject_type',
            'full_marks',
            'pass_marks',
            'status',
        ])->withTimestamps();
    }
    public function teacher()
{
    return $this->belongsTo(Teacher::class);
}
}