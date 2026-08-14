<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ClassRoom;
use App\Models\Attendance;
use App\Models\NurseryActivityAssessment;
use App\Models\Shift;

class Student extends Model
{
    protected $fillable = [
    'student_id',
    'name',
    'father_name',
    'dob',
    'gender',
    'contact',
    'address',
    'photo',
    'admission_date',
    'class_room_id',
    'blood_group',
    'shift_id',
    'quran_classes',
    'valid_from',
    'valid_until'
];

    public function classRoom()
{
    return $this->belongsTo(
        ClassRoom::class,
        'class_room_id'
    );
}

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

public function nurseryActivityAssessments()
{
    return $this->hasMany(NurseryActivityAssessment::class);
} 
public function shift()
{
    return $this->belongsTo(Shift::class);
}   
}