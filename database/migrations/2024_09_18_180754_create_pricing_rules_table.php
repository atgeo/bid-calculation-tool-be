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
        Schema::create('pricing_rules', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->decimal('buyer_fee_percentage'); // e.g., 10.00 for 10%
            $table->decimal('min_buyer_fee'); // Minimum buyer fee amount
            $table->decimal('max_buyer_fee'); // Maximum buyer fee amount
            $table->decimal('seller_fee_percentage'); // e.g., 2.00 for 2%
            $table->decimal('cost_1_to_500'); // Cost for $1 to $500
            $table->decimal('cost_501_to_1000'); // Cost for $501 to $1000
            $table->decimal('cost_1001_to_3000'); // Cost for $1001 to $3000
            $table->decimal('cost_over_3000'); // Cost for over $3000
            $table->decimal('storage_fee');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_rules');
    }
};
