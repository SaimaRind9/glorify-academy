<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeePayment extends Model
{
    protected $fillable = [
        'fee_challan_id',
        'receipt_no',
        'payment_date',
        'amount',
        'payment_method',
        'reference_no',
        'remarks',
        'received_by',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function challan()
    {
        return $this->belongsTo(
            FeeChallan::class,
            'fee_challan_id'
        );
    }

    public function receiver()
    {
        return $this->belongsTo(
            User::class,
            'received_by'
        );
    }
}