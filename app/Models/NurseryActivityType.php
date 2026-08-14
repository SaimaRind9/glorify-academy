<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NurseryActivityType extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_name',
        'display_order',
        'status',
    ];

    protected $casts = [
        'display_order' => 'integer',
        'status' => 'boolean',
    ];

    public function assessments(): HasMany
    {
        return $this->hasMany(
            NurseryActivityAssessment::class,
            'nursery_activity_type_id'
        );
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order')
            ->orderBy('activity_name');
    }
}