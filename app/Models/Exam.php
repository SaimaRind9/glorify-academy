<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [

        'class_room_id',
        'exam_name',
        'session',
        'start_date',
        'end_date',
        'status',
        'teacher_id',

    ];

    protected $casts = [

        'start_date' => 'date',
        'end_date'   => 'date',
        'status'     => 'boolean',

    ];

    public function classRoom()
    {
        return $this->belongsTo(
            ClassRoom::class,
            'class_room_id',
            'id'
        );
    }

    public function nurseryActivityAssessments()
{
    return $this->hasMany(NurseryActivityAssessment::class);
}
public function teacher()
{
    return $this->belongsTo(Teacher::class);
}
}

