<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom user_id (nullable dulu agar bisa di-backfill).
        Schema::table('product_variants', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')
                ->constrained()->cascadeOnDelete();
        });

        // Isi user_id mengikuti pemilik produk induknya.
        DB::statement('
            UPDATE product_variants pv
            JOIN products p ON p.id = pv.product_id
            SET pv.user_id = p.user_id
        ');

        // SKU tidak lagi unik global — unik per user (per bisnis).
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropUnique('product_variants_sku_unique');
            $table->unique(['user_id', 'sku']);
        });
    }

    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'sku']);
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->unique('sku');
        });
    }
};
