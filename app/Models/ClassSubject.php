<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSubject extends Model
{
    protected $fillable = [
        'class_room_id',
        'subject_id',
        'subject_type',
        'full_marks',
        'pass_marks',
        'status',
    ];

    public function classRoom()
    {
        return $this->belongsTo(
            ClassRoom::class,
            'class_room_id',
            'id'
        );
    }

    public function subject()
    {
        return $this->belongsTo(
            Subject::class,
            'subject_id',
            'id'
        );
    }
}