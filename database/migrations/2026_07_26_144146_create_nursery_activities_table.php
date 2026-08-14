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
        Schema::create('nursery_activities', function (Blueprint $table) {

            $table->id();

            $table->foreignId('exam_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('student_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('class_room_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('english',[
                'Excellent',
                'Very Good',
                'Good',
                'Satisfactory',
                'Needs Improvement'
            ]);

            $table->enum('math',[
                'Excellent',
                'Very Good',
                'Good',
                'Satisfactory',
                'Needs Improvement'
            ]);

            $table->enum('drawing',[
                'Excellent',
                'Very Good',
                'Good',
                'Satisfactory',
                'Needs Improvement'
            ]);

            $table->enum('writing',[
                'Excellent',
                'Very Good',
                'Good',
                'Satisfactory',
                'Needs Improvement'
            ]);

            $table->enum('reading',[
                'Excellent',
                'Very Good',
                'Good',
                'Satisfactory',
                'Needs Improvement'
            ]);

            $table->enum('behaviour',[
                'Excellent',
                'Very Good',
                'Good',
                'Satisfactory',
                'Needs Improvement'
            ]);

            $table->enum('confidence',[
                'Excellent',
                'Very Good',
                'Good',
                'Satisfactory',
                'Needs Improvement'
            ]);

            $table->enum('participation',[
                'Excellent',
                'Very Good',
                'Good',
                'Satisfactory',
                'Needs Improvement'
            ]);

            $table->enum('cleanliness',[
                'Excellent',
                'Very Good',
                'Good',
                'Satisfactory',
                'Needs Improvement'
            ]);

            $table->text('teacher_remarks')
                ->nullable();

            $table->boolean('status')
                ->default(true);

            $table->timestamps();

            $table->unique([
                'exam_id',
                'student_id'
            ]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nursery_activities');
    }
};