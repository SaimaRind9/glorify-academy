<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'class_room_id',
        'subject_id',
        'student_id',
        'total_marks',
        'obtained_marks',
        'passing_marks',
        'grade',
        'result_status',
        'remarks',
        'is_absent',
        'status',
    ];

    protected $casts = [
        'total_marks'    => 'decimal:2',
        'obtained_marks' => 'decimal:2',
        'passing_marks'  => 'decimal:2',
        'is_absent'      => 'boolean',
        'status'         => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function exam()
    {
        return $this->belongsTo(
            Exam::class,
            'exam_id',
            'id'
        );
    }

    public function classRoom()
    {
        return $this->belongsTo(
            ClassRoom::class,
            'class_room_id',
            'id'
        );
    }

    public function subject()
    {
        return $this->belongsTo(
            Subject::class,
            'subject_id',
            'id'
        );
    }

    public function student()
    {
        return $this->belongsTo(
            Student::class,
            'student_id',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Grade Calculation
    |--------------------------------------------------------------------------
    */

    public static function calculateGrade(
        float $obtainedMarks,
        float $totalMarks
    ): string {

        if ($totalMarks <= 0) {
            return 'N/A';
        }

        $percentage = ($obtainedMarks / $totalMarks) * 100;

        if ($percentage >= 90) {
            return 'A+';
        }

        if ($percentage >= 80) {
            return 'A';
        }

        if ($percentage >= 70) {
            return 'B';
        }

        if ($percentage >= 60) {
            return 'C';
        }

        if ($percentage >= 50) {
            return 'D';
        }

        return 'F';
    }

    /*
    |--------------------------------------------------------------------------
    | Result Status Calculation
    |--------------------------------------------------------------------------
    */

    public static function calculateResultStatus(
        ?float $obtainedMarks,
        float $passingMarks,
        bool $isAbsent = false
    ): string {

        if ($isAbsent) {
            return 'Absent';
        }

        if ($obtainedMarks === null) {
            return 'Pending';
        }

        return $obtainedMarks >= $passingMarks
            ? 'Pass'
            : 'Fail';
    }

    /*
    |--------------------------------------------------------------------------
    | Percentage Accessor
    |--------------------------------------------------------------------------
    */

    public function getPercentageAttribute(): float
    {
        if ((float) $this->total_marks <= 0) {
            return 0;
        }

        if ($this->is_absent || $this->obtained_marks === null) {
            return 0;
        }

        return round(
            ((float) $this->obtained_marks / (float) $this->total_marks) * 100,
            2
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Automatic Calculations Before Saving
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::saving(function (Mark $mark) {

            if ($mark->is_absent) {

                $mark->obtained_marks = null;
                $mark->grade = null;
                $mark->result_status = 'Absent';

                return;
            }

            if ($mark->obtained_marks === null) {

                $mark->grade = null;
                $mark->result_status = 'Pending';

                return;
            }

            $mark->grade = self::calculateGrade(
                (float) $mark->obtained_marks,
                (float) $mark->total_marks
            );

            $mark->result_status = self::calculateResultStatus(
                (float) $mark->obtained_marks,
                (float) $mark->passing_marks,
                false
            );

        });
    }
}