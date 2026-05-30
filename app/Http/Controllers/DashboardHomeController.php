<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardHomeController extends Controller
{
    public function index()
    {
        // Sales Activity Stats
        $toBeShipped = Order::where('status', 'belum lunas')->count() ?: 212;
        $toBePacked = Order::count() ?: 324;
        $toBeInvoiced = Order::where('status', 'lunas')->count() ?: 123;

        // Top Selling Category
        $categories = Category::withCount('products')->get();
        $topCategories = [];
        if ($categories->count() > 0) {
            foreach ($categories as $cat) {
                $topCategories[] = [
                    'name' => $cat->name,
                    'percentage' => $cat->products_count > 0 ? min(100, $cat->products_count * 15) : rand(15, 45),
                ];
            }
        }
        if (empty($topCategories)) {
            $topCategories = [
                ['name' => 'Ergonomic Office Chair', 'percentage' => 40],
                ['name' => 'Minimalist Leather Wallet', 'percentage' => 18],
                ['name' => 'Smartwatch with Fitness Tracking', 'percentage' => 45],
            ];
        }

        // Sales Orders
        $orders = Order::with('items.variant.product')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // If no real orders, provide demo data
        $demoOrders = [];
        if ($orders->isEmpty()) {
            $demoOrders = [
                ['name' => 'Anwar Hussen', 'packed' => 4, 'date' => 'Feb 01, 2025', 'shipped' => 6, 'status' => 'Confirmed', 'amount' => 34.00, 'invoice' => 'INV-000003'],
                ['name' => 'Tahsan Khan', 'packed' => 3, 'date' => 'Feb 01, 2025', 'shipped' => 9, 'status' => 'Pending', 'amount' => 134.00, 'invoice' => 'INV-000004'],
                ['name' => 'Hasan Khan', 'packed' => 2, 'date' => 'Feb 01, 2025', 'shipped' => 3, 'status' => 'Cancel', 'amount' => 38.00, 'invoice' => 'INV-000005'],
            ];
        }

        // Top Selling Items (product names for heatmap)
        $topItems = ['T-Shirt', 'Shoes', 'Wallet', 'Cosmetic', 'Electronic', 'Watch'];

        return view('dashboard-home', compact(
            'toBeShipped',
            'toBePacked',
            'toBeInvoiced',
            'topCategories',
            'orders',
            'demoOrders',
            'topItems'
        ));
    }
}
