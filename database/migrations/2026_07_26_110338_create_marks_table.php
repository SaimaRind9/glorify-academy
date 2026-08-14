<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('marks', function (Blueprint $table) {

            $table->id();

            $table->foreignId('exam_id')
                  ->constrained('exams')
                  ->cascadeOnDelete();

            $table->foreignId('class_room_id')
                  ->constrained('class_rooms')
                  ->cascadeOnDelete();

            $table->foreignId('subject_id')
                  ->constrained('subjects')
                  ->cascadeOnDelete();

            $table->foreignId('student_id')
                  ->constrained('students')
                  ->cascadeOnDelete();

            $table->decimal('total_marks', 8, 2);

            $table->decimal('obtained_marks', 8, 2)
                  ->nullable();

            $table->decimal('passing_marks', 8, 2);

            $table->string('grade', 20)
                  ->nullable();

            $table->string('result_status', 20)
                  ->nullable();

            $table->text('remarks')
                  ->nullable();

            $table->boolean('is_absent')
                  ->default(false);

            $table->boolean('status')
                  ->default(true);

            $table->timestamps();

            $table->unique(
                [
                    'exam_id',
                    'class_room_id',
                    'subject_id',
                    'student_id'
                ],
                'unique_student_exam_subject_mark'
            );

            $table->index([
                'exam_id',
                'class_room_id',
                'subject_id'
            ]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marks');
    }
};