<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fee_structures', function (Blueprint $table) {

            $table->id();

            $table->foreignId('academic_session_id')
                ->constrained('academic_sessions')
                ->cascadeOnDelete();

            $table->foreignId('class_room_id')
                ->constrained('class_rooms')
                ->cascadeOnDelete();

            $table->foreignId('shift_id')
                ->constrained('shifts')
                ->cascadeOnDelete();

            $table->foreignId('fee_type_id')
                ->constrained('fee_types')
                ->cascadeOnDelete();

            $table->decimal('amount', 10, 2);

            $table->date('effective_from');

            $table->enum('status', [
                'Active',
                'Inactive'
            ])->default('Active');

            $table->timestamps();

            $table->index(
    [
        'academic_session_id',
        'class_room_id',
        'shift_id',
        'fee_type_id'
    ],
    'fee_structure_lookup_idx'
);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_structures');
    }
};