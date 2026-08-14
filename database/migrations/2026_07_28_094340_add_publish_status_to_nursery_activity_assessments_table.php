<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nursery_activity_assessments', function (Blueprint $table) {

            $table->enum('publish_status', [
                'Draft',
                'Published'
            ])->default('Draft')->after('status');

        });
    }

    public function down(): void
    {
        Schema::table('nursery_activity_assessments', function (Blueprint $table) {

            $table->dropColumn('publish_status');

        });
    }
};