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
        Schema::create('exams', function (Blueprint $table) {

            $table->id();

            // Class
            $table->foreignId('class_room_id')
                  ->constrained('class_rooms')
                  ->cascadeOnDelete();

            // Exam Information
            $table->string('exam_name');
            $table->string('session')->nullable();

            // Exam Dates
            $table->date('start_date');
            $table->date('end_date');

            // Status
            $table->boolean('status')
                  ->default(1);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};