<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NurseryActivityAssessment extends Model
{
    use HasFactory;

    public const ASSESSMENT_LEVELS = [
        'Excellent',
        'Very Good',
        'Good',
        'Satisfactory',
        'Needs Improvement',
    ];

    protected $fillable = [
        'exam_id',
        'class_room_id',
        'student_id',
        'nursery_activity_type_id',
        'assessment',
        'remarks',
        'status',
        'publish_status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function classRoom(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function activityType(): BelongsTo
    {
        return $this->belongsTo(
            NurseryActivityType::class,
            'nursery_activity_type_id'
        );
    }

    public function getStarsAttribute(): string
    {
        return match ($this->assessment) {
            'Excellent' => '★★★★★',
            'Very Good' => '★★★★☆',
            'Good' => '★★★☆☆',
            'Satisfactory' => '★★☆☆☆',
            'Needs Improvement' => '★☆☆☆☆',
            default => '☆☆☆☆☆',
        };
    }

    public function getScoreAttribute(): int
    {
        return match ($this->assessment) {
            'Excellent' => 5,
            'Very Good' => 4,
            'Good' => 3,
            'Satisfactory' => 2,
            'Needs Improvement' => 1,
            default => 0,
        };
    }
}