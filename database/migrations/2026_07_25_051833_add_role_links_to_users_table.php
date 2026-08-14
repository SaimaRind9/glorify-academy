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
    Schema::table('users', function (Blueprint $table) {

        $table->enum('status', ['Active', 'Inactive'])
              ->default('Active')
              ->after('role');

        $table->foreignId('teacher_id')
              ->nullable()
              ->constrained('teachers')
              ->nullOnDelete();

        $table->foreignId('student_id')
              ->nullable()
              ->constrained('students')
              ->nullOnDelete();

    });
}

    /**
     * Reverse the migrations.
     */
   public function down(): void
{
    Schema::table('users', function (Blueprint $table) {

        $table->dropForeign(['teacher_id']);
        $table->dropForeign(['student_id']);

        $table->dropColumn([
            'status',
            'teacher_id',
            'student_id'
        ]);

    });
}

    
};
