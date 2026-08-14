<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fee_payments', function (Blueprint $table) {

            $table->id();

            $table->foreignId('fee_challan_id')
                ->constrained('fee_challans')
                ->cascadeOnDelete();

            $table->string('receipt_no')
                ->unique();

            $table->date('payment_date');

            $table->decimal('amount', 10, 2);

            $table->enum('payment_method', [
                'Cash',
                'Bank',
                'Online'
            ])->default('Cash');

            $table->string('reference_no')
                ->nullable();

            $table->text('remarks')
                ->nullable();

            $table->foreignId('received_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(
                [
                    'fee_challan_id',
                    'payment_date'
                ],
                'fee_payment_lookup_idx'
            );

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_payments');
    }
};