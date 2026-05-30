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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('variant_name');
            $table->string('variant_unit');
            $table->string('sku')->unique();
            $table->integer('initial_stock')->default(0);
            $table->integer('actual_stock')->default(0);
            $table->date('expired_date')->nullable();
            $table->string('barcode')->nullable();
            $table->decimal('cost_price', 15, 2)->default(0);
            $table->decimal('selling_price', 15, 2)->default(0);
            $table->decimal('margin', 5, 2)->default(0);
            $table->integer('min_stock')->default(0);
            $table->boolean('enable_stock_alert')->default(false);
            $table->string('image_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
