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
      Schema::create('students', function (Blueprint $table) {

    $table->id();

    $table->string('student_id')->unique();

    $table->string('name');

    $table->string('father_name');

    $table->date('dob')->nullable();

    $table->string('gender')->nullable();

    $table->string('contact');

    $table->text('address')->nullable();

    $table->string('photo')->nullable();

    $table->date('admission_date')->nullable();


    // Class relation
    $table->foreignId('class_room_id')
          ->constrained('class_rooms')
          ->onDelete('cascade');


    $table->timestamps();

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
