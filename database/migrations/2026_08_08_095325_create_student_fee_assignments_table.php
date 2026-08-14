<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_fee_assignments', function (Blueprint $table) {

            $table->id();

            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete();

            $table->foreignId('academic_session_id')
                ->constrained('academic_sessions')
                ->cascadeOnDelete();

            $table->foreignId('fee_type_id')
                ->constrained('fee_types')
                ->cascadeOnDelete();

            $table->decimal('custom_amount', 10, 2)
                ->nullable();

            $table->date('effective_from');

            $table->enum('status', [
                'Active',
                'Inactive'
            ])->default('Active');

            $table->timestamps();

            $table->unique(
                [
                    'student_id',
                    'academic_session_id',
                    'fee_type_id',
                    'effective_from'
                ],
                'student_fee_assignment_unique'
            );

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_fee_assignments');
    }
};