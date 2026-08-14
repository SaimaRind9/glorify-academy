<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nursery_activity_assessments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('exam_id')
                ->constrained('exams')
                ->cascadeOnDelete();

            $table->foreignId('class_room_id')
                ->constrained('class_rooms')
                ->cascadeOnDelete();

            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete();

            $table->foreignId('nursery_activity_type_id')
                ->constrained('nursery_activity_types')
                ->cascadeOnDelete();

            $table->enum('assessment', [
                'Excellent',
                'Very Good',
                'Good',
                'Satisfactory',
                'Needs Improvement',
            ]);

            $table->text('remarks')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();

            $table->unique(
                [
                    'exam_id',
                    'student_id',
                    'nursery_activity_type_id',
                ],
                'nursery_assessment_unique'
            );

            $table->index([
                'exam_id',
                'class_room_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nursery_activity_assessments');
    }
};