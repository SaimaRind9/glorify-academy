<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeChallan extends Model
{
    protected $fillable = [
        'challan_no',
        'student_id',
        'academic_session_id',
        'month',
        'year',
        'issue_date',
        'due_date',
        'subtotal',
        'late_fine',
        'total_amount',
        'paid_amount',
        'status',
        'remarks',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'subtotal' => 'decimal:2',
        'late_fine' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function academicSession()
    {
        return $this->belongsTo(AcademicSession::class);
    }

    public function items()
    {
        return $this->hasMany(FeeChallanItem::class);
    }
    public function payments()
{
    return $this->hasMany(FeePayment::class);
}
}