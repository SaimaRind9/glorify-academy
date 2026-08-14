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
        Schema::create('class_subjects', function (Blueprint $table) {
            $table->id();

            $table->foreignId('class_room_id')
                ->constrained('class_rooms')
                ->cascadeOnDelete();

            $table->foreignId('subject_id')
                ->constrained('subjects')
                ->cascadeOnDelete();

            $table->enum('subject_type', [
                'Marks',
                'Grade',
                'Activity'
            ])->default('Marks');

            $table->unsignedInteger('full_marks')->nullable();
            $table->unsignedInteger('pass_marks')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();

            // Same subject cannot be assigned twice to the same class
            $table->unique(
                ['class_room_id', 'subject_id'],
                'class_subject_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_subjects');
    }
};