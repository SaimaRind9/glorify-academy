<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fee_challan_items', function (Blueprint $table) {

            $table->id();

            $table->foreignId('fee_challan_id')
                ->constrained('fee_challans')
                ->cascadeOnDelete();

            $table->foreignId('fee_type_id')
                ->nullable()
                ->constrained('fee_types')
                ->nullOnDelete();

            $table->string('description');

            $table->decimal('amount', 10, 2);

            $table->timestamps();

            $table->index(
                [
                    'fee_challan_id',
                    'fee_type_id'
                ],
                'challan_item_lookup_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_challan_items');
    }
};