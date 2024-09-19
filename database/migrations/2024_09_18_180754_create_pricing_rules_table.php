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
            $table->enum('vehicle_type', ['common', 'luxury']);
            $table->decimal('buyer_fee_percentage'); // e.g., 10.00 for 10%
            $table->decimal('min_buyer_fee'); // Minimum buyer fee amount
            $table->decimal('max_buyer_fee'); // Maximum buyer fee amount
            $table->decimal('seller_fee_percentage'); // e.g., 2.00 for 2%
            $table->json('association_fee');
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
