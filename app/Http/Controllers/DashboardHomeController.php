<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardHomeController extends Controller
{
    public function index()
    {
        // User yang sedang login — dipakai untuk memfilter query raw join
        // (query raw join tidak terkena Global Scope per-user otomatis).
        $userId = auth()->id();

        // ===== Sales Activity Stats (real counts) =====
        $toBeShipped = Order::where('status', 'belum lunas')->count();
        $toBePacked = Order::count();
        $toBeInvoiced = Order::where('status', 'lunas')->count();

        // Percentage change vs last month
        $now = Carbon::now();
        $thisMonthOrders = Order::whereMonth('created_at', $now->month)->whereYear('created_at', $now->year)->count();
        $lastMonthOrders = Order::whereMonth('created_at', $now->copy()->subMonth()->month)->whereYear('created_at', $now->copy()->subMonth()->year)->count();
        $orderChangePercent = $lastMonthOrders > 0 ? round((($thisMonthOrders - $lastMonthOrders) / $lastMonthOrders) * 100, 1) : 0;

        $thisMonthRevenue = Order::whereMonth('created_at', $now->month)->whereYear('created_at', $now->year)->sum('total_amount');

        // ===== Top Selling Category (by total qty sold) =====
        $totalQtySold = OrderItem::whereHas('order')->sum('qty') ?: 1;
        $topCategories = Category::select('categories.id', 'categories.name')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->join('product_variants', 'product_variants.product_id', '=', 'products.id')
            ->join('order_items', 'order_items.product_variant_id', '=', 'product_variants.id')
            ->where('products.user_id', $userId)
            ->groupBy('categories.id', 'categories.name')
            ->selectRaw('SUM(order_items.qty) as total_sold')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get()
            ->map(function ($cat) use ($totalQtySold) {
                return [
                    'name' => $cat->name,
                    'percentage' => round(($cat->total_sold / $totalQtySold) * 100),
                ];
            })
            ->toArray();

        // If no order items exist, show categories with product count proportion
        if (empty($topCategories)) {
            $totalProducts = Product::count() ?: 1;
            $topCategories = Category::withCount('products')
                ->orderByDesc('products_count')
                ->limit(5)
                ->get()
                ->map(fn($cat) => [
                    'name' => $cat->name,
                    'percentage' => round(($cat->products_count / $totalProducts) * 100),
                ])
                ->toArray();
        }

        // ===== Top Selling Items (top 6 products by qty sold, with daily breakdown for heatmap) =====
        $topItemsData = Product::select('products.id', 'products.name')
            ->join('product_variants', 'product_variants.product_id', '=', 'products.id')
            ->join('order_items', 'order_items.product_variant_id', '=', 'product_variants.id')
            ->where('products.user_id', $userId)
            ->groupBy('products.id', 'products.name')
            ->selectRaw('SUM(order_items.qty) as total_sold')
            ->orderByDesc('total_sold')
            ->limit(6)
            ->get();

        $topItems = $topItemsData->pluck('name')->toArray();

        // Build heatmap data: for each top product, get daily sales for last 7 days
        $heatmapData = [];
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::SUNDAY);
        foreach ($topItemsData as $product) {
            $dailySales = [];
            for ($d = 0; $d < 7; $d++) {
                $date = $startOfWeek->copy()->addDays($d);
                $qty = OrderItem::join('product_variants', 'product_variants.id', '=', 'order_items.product_variant_id')
                    ->join('orders', 'orders.id', '=', 'order_items.order_id')
                    ->where('product_variants.product_id', $product->id)
                    ->where('orders.user_id', $userId)
                    ->whereDate('orders.order_date', $date)
                    ->sum('order_items.qty');
                $dailySales[] = (int)$qty;
            }
            $heatmapData[$product->name] = $dailySales;
        }

        // If no top items, use product names from DB
        if (empty($topItems)) {
            $topItems = Product::limit(6)->pluck('name')->toArray();
            foreach ($topItems as $name) {
                $heatmapData[$name] = [0, 0, 0, 0, 0, 0, 0];
            }
        }

        // ===== Sales Orders (real, latest 10) =====
        $orders = Order::with('items.variant.product')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // ===== Chart Data: Total Product Details (monthly stock data for current year) =====
        $monthlyProductData = [];
        for ($m = 1; $m <= 12; $m++) {
            $date = Carbon::create($now->year, $m, 1);

            // Products created up to end of that month
            $totalProducts = Product::where('created_at', '<=', $date->copy()->endOfMonth())->count();

            // Variants with stock levels
            $variants = ProductVariant::whereHas('product', function ($q) use ($date) {
                $q->where('created_at', '<=', $date->copy()->endOfMonth());
            });

            $totalStock = (clone $variants)->sum('actual_stock');
            $highStock = (clone $variants)->where('actual_stock', '>', DB::raw('min_stock * 2'))->count();
            $lowStock = (clone $variants)->where('actual_stock', '<=', 'min_stock')->where('enable_stock_alert', true)->count();

            $monthlyProductData[] = [
                'totalStock' => (int)$totalStock,
                'highStock' => (int)$highStock,
                'lowStock' => (int)$lowStock,
            ];
        }

        // ===== Chart Data: Purchase & Sales (daily orders for current month) =====
        $daysInMonth = $now->daysInMonth;
        $monthlySalesData = [];
        $monthlyPurchaseData = [];
        $dailyLabels = [];

        for ($d = 1; $d <= $daysInMonth; $d++) {
            $date = Carbon::create($now->year, $now->month, $d);
            $dailyLabels[] = $d === 1 ? $date->format('d F') : ($d === $daysInMonth ? $date->format('d F') : '');

            // Sales = total_amount of lunas orders on that day
            $salesAmount = Order::whereDate('order_date', $date)->where('status', 'lunas')->sum('total_amount');
            $monthlySalesData[] = (int)$salesAmount;

            // Purchase = total cost_price * qty for orders on that day (approximation)
            $purchaseAmount = OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id')
                ->join('product_variants', 'product_variants.id', '=', 'order_items.product_variant_id')
                ->where('orders.user_id', $userId)
                ->whereDate('orders.order_date', $date)
                ->selectRaw('SUM(order_items.qty * product_variants.cost_price) as total')
                ->value('total') ?? 0;
            $monthlyPurchaseData[] = (int)$purchaseAmount;
        }

        // Low stock variants for notification bell (reuse from dashboard layout)
        $lowStockVariants = ProductVariant::where('enable_stock_alert', true)
            ->whereColumn('actual_stock', '<=', 'min_stock')
            ->whereHas('product')
            ->with('product')
            ->get();

        return view('dashboard-home', compact(
            'toBeShipped',
            'toBePacked',
            'toBeInvoiced',
            'orderChangePercent',
            'thisMonthRevenue',
            'topCategories',
            'orders',
            'topItems',
            'heatmapData',
            'monthlyProductData',
            'monthlySalesData',
            'monthlyPurchaseData',
            'dailyLabels',
            'lowStockVariants'
        ));
    }
}
