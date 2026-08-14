<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentFeeAssignment extends Model
{
    protected $fillable = [
        'student_id',
        'academic_session_id',
        'fee_type_id',
        'custom_amount',
        'effective_from',
        'status',
    ];

    protected $casts = [
        'custom_amount' => 'decimal:2',
        'effective_from' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function academicSession()
    {
        return $this->belongsTo(AcademicSession::class);
    }

    public function feeType()
    {
        return $this->belongsTo(FeeType::class);
    }
}