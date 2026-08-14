<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->string('email')->nullable()->unique()->after('name');

            $table->enum('status', ['Active', 'Inactive'])
                ->default('Active')
                ->after('class_room_id');
        });
    }

    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropUnique(['email']);
            $table->dropColumn(['email', 'status']);
        });
    }
};