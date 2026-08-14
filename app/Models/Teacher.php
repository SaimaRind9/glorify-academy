<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'name',
        'email',
        'phone',
        'qualification',
        'experience',
        'class_room_id',
        'status',
        'photo',
    ];

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
    }
}