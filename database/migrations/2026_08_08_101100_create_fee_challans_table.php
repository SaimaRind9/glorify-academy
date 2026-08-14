<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fee_challans', function (Blueprint $table) {

            $table->id();

            $table->string('challan_no')->unique();

            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete();

            $table->foreignId('academic_session_id')
                ->constrained('academic_sessions')
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('month');

            $table->unsignedSmallInteger('year');

            $table->date('issue_date');

            $table->date('due_date');

            $table->decimal('subtotal', 10, 2)
                ->default(0);

            $table->decimal('late_fine', 10, 2)
                ->default(0);

            $table->decimal('total_amount', 10, 2)
                ->default(0);

            $table->decimal('paid_amount', 10, 2)
                ->default(0);

            $table->enum('status', [
                'Pending',
                'Partial',
                'Paid',
                'Cancelled',
            ])->default('Pending');

            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->unique(
                [
                    'student_id',
                    'academic_session_id',
                    'month',
                    'year'
                ],
                'student_month_challan_unique'
            );

            $table->index(
                [
                    'academic_session_id',
                    'month',
                    'year',
                    'status'
                ],
                'challan_report_idx'
            );

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_challans');
    }
};