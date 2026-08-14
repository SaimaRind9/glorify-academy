<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('teachers', 'email')) {
            Schema::table('teachers', function (Blueprint $table) {
                $table->string('email')
                    ->nullable()
                    ->unique()
                    ->after('name');
            });
        }

        if (!Schema::hasColumn('teachers', 'status')) {
            Schema::table('teachers', function (Blueprint $table) {
                $table->enum('status', ['Active', 'Inactive'])
                    ->default('Active')
                    ->after('class_room_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('teachers', 'email')) {
            Schema::table('teachers', function (Blueprint $table) {
                $table->dropUnique(['email']);
                $table->dropColumn('email');
            });
        }

        if (Schema::hasColumn('teachers', 'status')) {
            Schema::table('teachers', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};