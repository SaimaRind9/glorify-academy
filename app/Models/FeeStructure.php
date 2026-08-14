<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeStructure extends Model
{
    protected $fillable = [
        'academic_session_id',
        'class_room_id',
        'shift_id',
        'fee_type_id',
        'amount',
        'effective_from',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'effective_from' => 'date',
    ];

    public function academicSession()
    {
        return $this->belongsTo(AcademicSession::class);
    }

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function feeType()
    {
        return $this->belongsTo(FeeType::class);
    }
}