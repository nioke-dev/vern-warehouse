<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Produk demo dimiliki oleh user pertama (manager). Saat seeding tidak
        // ada user yang login, jadi user_id harus diisi manual.
        $userId = User::orderBy('id')->value('id');
        Product::saving(function ($product) use ($userId) {
            if (empty($product->user_id)) {
                $product->user_id = $userId;
            }
        });
        ProductVariant::saving(function ($variant) use ($userId) {
            if (empty($variant->user_id)) {
                $variant->user_id = $userId;
            }
        });
        Category::saving(function ($category) use ($userId) {
            if (empty($category->user_id)) {
                $category->user_id = $userId;
            }
        });

        // Create Categories
        $frozenFood = Category::create(['name' => 'Frozen Food']);
        $snacks = Category::create(['name' => 'Snacks']);
        $bakery = Category::create(['name' => 'Bakery']);

        // Create Star Nugget Product
        $starNugget = Product::create([
            'name' => 'Star Nugget',
            'details' => 'Premium chicken nugget with star shape.',
            'category_id' => $frozenFood->id,
            'grade' => 'A',
            'status' => 'Healthy',
            'daily_sales' => 100,
            'monthly_revenue' => 10000000,
        ]);

        ProductVariant::create([
            'product_id' => $starNugget->id,
            'variant_name' => '1kg',
            'variant_unit' => 'Pcs',
            'sku' => 'VERN-10001010',
            'initial_stock' => 100,
            'actual_stock' => 20,
            'cost_price' => 45000,
            'selling_price' => 50000,
            'margin' => 10,
            'min_stock' => 10,
            'enable_stock_alert' => true,
        ]);

        ProductVariant::create([
            'product_id' => $starNugget->id,
            'variant_name' => '2kg',
            'variant_unit' => 'Pcs',
            'sku' => 'VERN-20002020',
            'initial_stock' => 50,
            'actual_stock' => 0,
            'cost_price' => 90000,
            'selling_price' => 100000,
            'margin' => 10,
            'min_stock' => 5,
            'enable_stock_alert' => true,
        ]);

        // Create Chicken Qotuf
        $chickenQotuf = Product::create([
            'name' => 'Chicken Qotuf',
            'details' => 'Middle-Eastern style spiced chicken nugget.',
            'category_id' => $frozenFood->id,
            'grade' => 'B',
            'status' => 'Running Low',
            'daily_sales' => 5,
            'monthly_revenue' => 400000,
        ]);

        ProductVariant::create([
            'product_id' => $chickenQotuf->id,
            'variant_name' => '1kg',
            'variant_unit' => 'Pcs',
            'sku' => 'VERN-30003030',
            'initial_stock' => 30,
            'actual_stock' => 5,
            'cost_price' => 72000,
            'selling_price' => 80000,
            'margin' => 10,
            'min_stock' => 5,
            'enable_stock_alert' => true,
        ]);

        // Create Naan Pizza
        $naanPizza = Product::create([
            'name' => 'Naan Pizza',
            'details' => 'Traditional flatbread base pizza Italiano flavor.',
            'category_id' => $bakery->id,
            'grade' => 'A',
            'status' => 'Healthy',
            'daily_sales' => 50,
            'monthly_revenue' => 10000000,
        ]);

        ProductVariant::create([
            'product_id' => $naanPizza->id,
            'variant_name' => 'Italiano',
            'variant_unit' => 'Box',
            'sku' => 'VERN-40004040',
            'initial_stock' => 150,
            'actual_stock' => 100,
            'cost_price' => 22500,
            'selling_price' => 25000,
            'margin' => 10,
            'min_stock' => 20,
            'enable_stock_alert' => true,
        ]);

        // Create Kanzler Singles
        $kanzler = Product::create([
            'name' => 'Kanzler Singles',
            'details' => 'Ready to eat premium sausage singles pack.',
            'category_id' => $snacks->id,
            'grade' => 'A',
            'status' => 'Healthy',
            'daily_sales' => 100,
            'monthly_revenue' => 10000000,
        ]);

        ProductVariant::create([
            'product_id' => $kanzler->id,
            'variant_name' => 'Box',
            'variant_unit' => 'Pcs',
            'sku' => 'VERN-50005050',
            'initial_stock' => 120,
            'actual_stock' => 20,
            'cost_price' => 45000,
            'selling_price' => 50000,
            'margin' => 10,
            'min_stock' => 10,
            'enable_stock_alert' => true,
        ]);
    }
}
