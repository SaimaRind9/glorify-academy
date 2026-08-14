<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeChallanItem extends Model
{
    protected $fillable = [
        'fee_challan_id',
        'fee_type_id',
        'description',
        'amount',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function challan()
    {
        return $this->belongsTo(
            FeeChallan::class,
            'fee_challan_id'
        );
    }

    public function feeType()
    {
        return $this->belongsTo(FeeType::class);
    }
}