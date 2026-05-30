@extends('layouts.dashboard')

@section('title', 'Dashboard - Vern')
@section('page_title', 'Dashboard')

@section('content')
<div class="flex flex-col gap-6">

    <!-- Row 1: Sales Activity + Top Selling Category + Top Selling Items -->
    <div class="grid grid-cols-12 gap-6">

        <!-- Sales Activity (col-span-4) -->
        <div class="col-span-12 lg:col-span-4 bg-white rounded-[16px] border border-black/5 p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-[16px] font-bold text-black tracking-[-0.03em]">Sales Activity</h3>
                <button class="w-7 h-7 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors text-gray-400">
                    <iconify-icon icon="solar:menu-dots-bold" width="18" height="18"></iconify-icon>
                </button>
            </div>

            <div class="flex flex-col gap-4">
                <!-- To be Shipped -->
                <div class="bg-[#F8F9FB] rounded-[12px] p-4 flex items-center justify-between">
                    <div>
                        <p class="text-[11px] font-medium text-[#8B8E97] mb-1">To be Shipped</p>
                        <div class="flex items-center gap-3">
                            <span class="text-[28px] font-bold text-black leading-none">{{ $toBeShipped }}</span>
                            <span class="text-[11px] font-semibold text-[#22C55E] bg-[#22C55E]/10 px-2 py-0.5 rounded-full">↑+3.4%</span>
                        </div>
                    </div>
                    <!-- Mini Sparkline SVG -->
                    <div class="flex flex-col items-end gap-1">
                        <span class="text-[11px] font-semibold text-[#8B8E97]">$3,345</span>
                        <svg width="80" height="30" viewBox="0 0 80 30" fill="none">
                            <path d="M0 25 Q10 20, 20 22 T40 15 T60 18 T80 8" stroke="#22C55E" stroke-width="2" fill="none"/>
                        </svg>
                    </div>
                </div>

                <!-- To be Packed -->
                <div class="bg-[#F8F9FB] rounded-[12px] p-4 flex items-center justify-between">
                    <div>
                        <p class="text-[11px] font-medium text-[#8B8E97] mb-1">To be Packed</p>
                        <div class="flex items-center gap-3">
                            <span class="text-[28px] font-bold text-black leading-none">{{ $toBePacked }}</span>
                            <span class="text-[11px] font-semibold text-[#22C55E] bg-[#22C55E]/10 px-2 py-0.5 rounded-full">↑+4.5%</span>
                        </div>
                    </div>
                    <!-- Mini Bar Chart -->
                    <div class="flex items-end gap-[3px] h-[30px]">
                        @php $bars = [12, 18, 25, 15, 22, 28, 20, 14, 26, 19, 24, 30]; @endphp
                        @foreach($bars as $h)
                            <div class="w-[4px] rounded-full bg-[#0077FF]" style="height: {{ $h }}px;"></div>
                        @endforeach
                    </div>
                </div>

                <!-- To be Invoiced -->
                <div class="bg-[#F8F9FB] rounded-[12px] p-4 flex items-center justify-between">
                    <div>
                        <p class="text-[11px] font-medium text-[#8B8E97] mb-1">To be Invoiced</p>
                        <div class="flex items-center gap-3">
                            <span class="text-[28px] font-bold text-black leading-none">{{ $toBeInvoiced }}</span>
                            <span class="text-[11px] font-semibold text-[#EF4444] bg-[#EF4444]/10 px-2 py-0.5 rounded-full">↓-1.6%</span>
                        </div>
                    </div>
                    <!-- Donut Chart -->
                    <div class="relative w-[50px] h-[50px]">
                        <svg viewBox="0 0 36 36" class="w-full h-full">
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#E5E7EB" stroke-width="3"/>
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#FBA518" stroke-width="3" stroke-dasharray="40, 100" stroke-linecap="round"/>
                        </svg>
                        <span class="absolute inset-0 flex items-center justify-center text-[10px] font-bold text-black">40%</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-center gap-4 mt-4 text-[10px] text-[#8B8E97]">
                <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span>
            </div>
        </div>

        <!-- Top Selling Category (col-span-4) -->
        <div class="col-span-12 lg:col-span-4 bg-white rounded-[16px] border border-black/5 p-6" x-data="{ period: 'month' }">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-[16px] font-bold text-black tracking-[-0.03em]">Top Sellings Category</h3>
                <button class="w-7 h-7 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors text-gray-400">
                    <iconify-icon icon="solar:menu-dots-bold" width="18" height="18"></iconify-icon>
                </button>
            </div>

            <!-- Period Tabs -->
            <div class="flex items-center bg-[#F3F4F6] rounded-lg p-1 mb-6 w-max">
                <button @click="period = 'week'" :class="period === 'week' ? 'bg-white shadow-sm text-black' : 'text-[#8B8E97]'" class="px-4 py-1.5 rounded-md text-[12px] font-semibold transition-all">Week</button>
                <button @click="period = 'month'" :class="period === 'month' ? 'bg-white shadow-sm text-black' : 'text-[#8B8E97]'" class="px-4 py-1.5 rounded-md text-[12px] font-semibold transition-all">Month</button>
                <button @click="period = 'year'" :class="period === 'year' ? 'bg-white shadow-sm text-black' : 'text-[#8B8E97]'" class="px-4 py-1.5 rounded-md text-[12px] font-semibold transition-all">Year</button>
            </div>

            <!-- Category Bars -->
            <div class="flex flex-col gap-5">
                @foreach($topCategories as $cat)
                <div class="flex flex-col gap-2">
                    <div class="flex items-center justify-between">
                        <span class="text-[13px] font-medium text-black truncate max-w-[70%]">{{ $cat['name'] }}</span>
                        <span class="text-[13px] font-bold text-black">{{ $cat['percentage'] }}%</span>
                    </div>
                    <div class="w-full h-[8px] bg-[#F3F4F6] rounded-full overflow-hidden">
                        @php
                            $colors = ['#FBA518', '#0077FF', '#22C55E', '#EF4444', '#8B5CF6'];
                            $color = $colors[$loop->index % count($colors)];
                        @endphp
                        <div class="h-full rounded-full transition-all duration-700" style="width: {{ $cat['percentage'] }}%; background-color: {{ $color }};"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Top Selling Items Heatmap (col-span-4) -->
        <div class="col-span-12 lg:col-span-4 bg-white rounded-[16px] border border-black/5 p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-[16px] font-bold text-black tracking-[-0.03em]">Top Selling Items</h3>
                <button class="w-7 h-7 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors text-gray-400">
                    <iconify-icon icon="solar:menu-dots-bold" width="18" height="18"></iconify-icon>
                </button>
            </div>

            <!-- Legend -->
            <div class="flex items-center gap-3 mb-4">
                <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded-sm bg-[#E8F5E9]"></div><span class="text-[10px] text-[#8B8E97] font-medium">0k - 5k</span></div>
                <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded-sm bg-[#0077FF]"></div><span class="text-[10px] text-[#8B8E97] font-medium">5k - 15k</span></div>
                <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded-sm bg-[#FBA518]"></div><span class="text-[10px] text-[#8B8E97] font-medium">15k - 25k</span></div>
            </div>

            <!-- Heatmap Grid -->
            <div class="flex flex-col gap-2">
                @foreach($topItems as $item)
                <div class="flex items-center gap-2">
                    <span class="text-[11px] font-medium text-[#8B8E97] w-[70px] truncate">{{ $item }}</span>
                    <div class="flex gap-1.5 flex-1">
                        @for($d = 0; $d < 7; $d++)
                            @php
                                $rand = rand(0, 2);
                                $heatColors = ['bg-[#E8F5E9]', 'bg-[#0077FF]', 'bg-[#FBA518]'];
                            @endphp
                            <div class="flex-1 h-[24px] rounded-[4px] {{ $heatColors[$rand] }}"></div>
                        @endfor
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Day Labels -->
            <div class="flex items-center gap-2 mt-2 pl-[78px]">
                @foreach(['S', 'M', 'T', 'W', 'T', 'F', 'S'] as $day)
                    <span class="flex-1 text-center text-[10px] font-medium text-[#8B8E97]">{{ $day }}</span>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Row 2: Total Product Details + Purchase & Sales -->
    <div class="grid grid-cols-12 gap-6">

        <!-- Total Product Details - Bar Chart (col-span-6) -->
        <div class="col-span-12 lg:col-span-6 bg-white rounded-[16px] border border-black/5 p-6">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-[16px] font-bold text-black tracking-[-0.03em]">Total Product Details</h3>
                <div class="flex items-center gap-2 bg-[#F8F9FB] rounded-lg px-3 py-1.5 text-[12px] font-medium text-[#8B8E97]">
                    <iconify-icon icon="solar:calendar-linear" width="14" height="14"></iconify-icon>
                    This Years
                    <iconify-icon icon="solar:alt-arrow-down-linear" width="14" height="14"></iconify-icon>
                </div>
            </div>

            <!-- Legend -->
            <div class="flex items-center gap-4 mb-4">
                <div class="flex items-center gap-1.5"><div class="w-2.5 h-2.5 rounded-full bg-[#22C55E]"></div><span class="text-[11px] font-medium text-[#8B8E97]">Total Stock Items</span></div>
                <div class="flex items-center gap-1.5"><div class="w-2.5 h-2.5 rounded-full bg-[#0077FF]"></div><span class="text-[11px] font-medium text-[#8B8E97]">High Stock Items</span></div>
                <div class="flex items-center gap-1.5"><div class="w-2.5 h-2.5 rounded-full bg-[#FBA518]"></div><span class="text-[11px] font-medium text-[#8B8E97]">Low Stock Items</span></div>
            </div>

            <div style="height: 250px; position: relative;">
                <canvas id="productDetailsChart"></canvas>
            </div>
        </div>

        <!-- Purchase & Sales - Line Chart (col-span-6) -->
        <div class="col-span-12 lg:col-span-6 bg-white rounded-[16px] border border-black/5 p-6">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-[16px] font-bold text-black tracking-[-0.03em]">Purchase & Sales</h3>
                <div class="flex items-center gap-2 bg-[#F8F9FB] rounded-lg px-3 py-1.5 text-[12px] font-medium text-[#8B8E97]">
                    <iconify-icon icon="solar:calendar-linear" width="14" height="14"></iconify-icon>
                    This Month
                    <iconify-icon icon="solar:alt-arrow-down-linear" width="14" height="14"></iconify-icon>
                </div>
            </div>

            <!-- Legend -->
            <div class="flex items-center gap-4 mb-4">
                <div class="flex items-center gap-1.5"><div class="w-2.5 h-2.5 rounded-full bg-[#22C55E]"></div><span class="text-[11px] font-medium text-[#8B8E97]">Sales</span></div>
                <div class="flex items-center gap-1.5"><div class="w-2.5 h-2.5 rounded-full bg-[#8B5CF6]"></div><span class="text-[11px] font-medium text-[#8B8E97]">Purchase</span></div>
            </div>

            <div style="height: 250px; position: relative;">
                <canvas id="purchaseSalesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Row 3: Sales Order Table -->
    <div class="bg-white rounded-[16px] border border-black/5 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-[16px] font-bold text-black tracking-[-0.03em]">Sales Order</h3>
            <div class="flex items-center gap-2 bg-[#F8F9FB] rounded-lg px-3 py-1.5 text-[12px] font-medium text-[#8B8E97]">
                <iconify-icon icon="solar:calendar-linear" width="14" height="14"></iconify-icon>
                This Years
                <iconify-icon icon="solar:alt-arrow-down-linear" width="14" height="14"></iconify-icon>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left border-b border-black/5">
                        <th class="pb-3 pl-2 w-8"><input type="checkbox" class="w-4 h-4 rounded border-gray-300 accent-[#0077FF]" /></th>
                        <th class="pb-3 text-[12px] font-semibold text-[#8B8E97]">Customers Name</th>
                        <th class="pb-3 text-[12px] font-semibold text-[#8B8E97] text-center">Packed</th>
                        <th class="pb-3 text-[12px] font-semibold text-[#8B8E97]">Date</th>
                        <th class="pb-3 text-[12px] font-semibold text-[#8B8E97] text-center">Shipped</th>
                        <th class="pb-3 text-[12px] font-semibold text-[#8B8E97]">Order Status</th>
                        <th class="pb-3 text-[12px] font-semibold text-[#8B8E97]">Amount</th>
                        <th class="pb-3 text-[12px] font-semibold text-[#8B8E97]">Invoiced</th>
                        <th class="pb-3 text-[12px] font-semibold text-[#8B8E97] text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($orders->count() > 0)
                        @foreach($orders as $order)
                        <tr class="border-b border-black/5 hover:bg-[#FAFBFC] transition-colors">
                            <td class="py-4 pl-2"><input type="checkbox" class="w-4 h-4 rounded border-gray-300 accent-[#0077FF]" /></td>
                            <td class="py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-[#0077FF]/20 to-[#FBA518]/20 flex items-center justify-center text-[12px] font-bold text-[#0077FF]">
                                        {{ strtoupper(substr($order->customer_name, 0, 2)) }}
                                    </div>
                                    <span class="text-[13px] font-semibold text-black">{{ $order->customer_name }}</span>
                                </div>
                            </td>
                            <td class="py-4 text-center">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-[#22C55E]/10 text-[12px] font-bold text-[#22C55E]">{{ $order->items->count() }}</span>
                            </td>
                            <td class="py-4 text-[13px] font-medium text-[#8B8E97]">{{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y') }}</td>
                            <td class="py-4 text-center">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-[#0077FF]/10 text-[12px] font-bold text-[#0077FF]">{{ $order->items->sum('qty') }}</span>
                            </td>
                            <td class="py-4">
                                @php
                                    $statusMap = [
                                        'lunas' => ['label' => 'Confirmed', 'bg' => 'bg-[#22C55E]/10', 'text' => 'text-[#22C55E]'],
                                        'belum lunas' => ['label' => 'Pending', 'bg' => 'bg-[#FBA518]/10', 'text' => 'text-[#FBA518]'],
                                        'batal' => ['label' => 'Cancel', 'bg' => 'bg-[#EF4444]/10', 'text' => 'text-[#EF4444]'],
                                    ];
                                    $s = $statusMap[$order->status] ?? $statusMap['belum lunas'];
                                @endphp
                                <span class="inline-flex px-3 py-1 rounded-full text-[11px] font-semibold {{ $s['bg'] }} {{ $s['text'] }}">{{ $s['label'] }}</span>
                            </td>
                            <td class="py-4 text-[13px] font-semibold text-black">${{ number_format($order->total_amount, 2) }}</td>
                            <td class="py-4 text-[13px] font-medium text-[#8B8E97]">{{ $order->order_id }}</td>
                            <td class="py-4">
                                <div class="flex items-center justify-center gap-1">
                                    <button class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center text-[#8B8E97] transition-colors"><iconify-icon icon="solar:trash-bin-2-linear" width="16"></iconify-icon></button>
                                    <button class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center text-[#8B8E97] transition-colors"><iconify-icon icon="solar:pen-linear" width="16"></iconify-icon></button>
                                    <button class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center text-[#8B8E97] transition-colors"><iconify-icon icon="solar:menu-dots-bold" width="16"></iconify-icon></button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        @foreach($demoOrders as $demo)
                        <tr class="border-b border-black/5 hover:bg-[#FAFBFC] transition-colors">
                            <td class="py-4 pl-2"><input type="checkbox" class="w-4 h-4 rounded border-gray-300 accent-[#0077FF]" /></td>
                            <td class="py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-[#0077FF]/20 to-[#FBA518]/20 flex items-center justify-center text-[12px] font-bold text-[#0077FF]">
                                        {{ strtoupper(substr($demo['name'], 0, 2)) }}
                                    </div>
                                    <span class="text-[13px] font-semibold text-black">{{ $demo['name'] }}</span>
                                </div>
                            </td>
                            <td class="py-4 text-center">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-[#22C55E]/10 text-[12px] font-bold text-[#22C55E]">{{ $demo['packed'] }}</span>
                            </td>
                            <td class="py-4 text-[13px] font-medium text-[#8B8E97]">{{ $demo['date'] }}</td>
                            <td class="py-4 text-center">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-[#0077FF]/10 text-[12px] font-bold text-[#0077FF]">{{ $demo['shipped'] }}</span>
                            </td>
                            <td class="py-4">
                                @php
                                    $demoStatusMap = [
                                        'Confirmed' => ['bg' => 'bg-[#22C55E]/10', 'text' => 'text-[#22C55E]'],
                                        'Pending' => ['bg' => 'bg-[#FBA518]/10', 'text' => 'text-[#FBA518]'],
                                        'Cancel' => ['bg' => 'bg-[#EF4444]/10', 'text' => 'text-[#EF4444]'],
                                    ];
                                    $ds = $demoStatusMap[$demo['status']];
                                @endphp
                                <span class="inline-flex px-3 py-1 rounded-full text-[11px] font-semibold {{ $ds['bg'] }} {{ $ds['text'] }}">{{ $demo['status'] }}</span>
                            </td>
                            <td class="py-4 text-[13px] font-semibold text-black">${{ number_format($demo['amount'], 2) }}</td>
                            <td class="py-4 text-[13px] font-medium text-[#8B8E97]">{{ $demo['invoice'] }}</td>
                            <td class="py-4">
                                <div class="flex items-center justify-center gap-1">
                                    <button class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center text-[#8B8E97] transition-colors"><iconify-icon icon="solar:trash-bin-2-linear" width="16"></iconify-icon></button>
                                    <button class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center text-[#8B8E97] transition-colors"><iconify-icon icon="solar:pen-linear" width="16"></iconify-icon></button>
                                    <button class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center text-[#8B8E97] transition-colors"><iconify-icon icon="solar:menu-dots-bold" width="16"></iconify-icon></button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ====== Total Product Details - Bar Chart ======
    const productCtx = document.getElementById('productDetailsChart');
    if (productCtx) {
        new Chart(productCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [
                    {
                        label: 'Total Stock Items',
                        data: [2200, 1800, 2500, 2100, 2800, 2400, 3200, 2600, 2900, 2300, 2700, 3000],
                        backgroundColor: '#22C55E',
                        borderRadius: 4,
                        barPercentage: 0.6,
                        categoryPercentage: 0.7,
                    },
                    {
                        label: 'High Stock Items',
                        data: [1800, 1500, 2000, 1700, 2200, 2000, 2800, 2100, 2400, 1900, 2200, 2500],
                        backgroundColor: '#0077FF',
                        borderRadius: 4,
                        barPercentage: 0.6,
                        categoryPercentage: 0.7,
                    },
                    {
                        label: 'Low Stock Items',
                        data: [800, 600, 1000, 700, 1200, 900, 1500, 1000, 1300, 800, 1100, 1400],
                        backgroundColor: '#FBA518',
                        borderRadius: 4,
                        barPercentage: 0.6,
                        categoryPercentage: 0.7,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11, family: 'Plus Jakarta Sans', weight: 500 }, color: '#8B8E97' },
                        border: { display: false },
                    },
                    y: {
                        grid: { color: '#F3F4F6', drawBorder: false },
                        ticks: {
                            font: { size: 11, family: 'Plus Jakarta Sans', weight: 500 },
                            color: '#8B8E97',
                            callback: function(val) {
                                if (val >= 1000) return (val / 1000) + ' K';
                                return val;
                            },
                        },
                        border: { display: false },
                    }
                }
            }
        });
    }

    // ====== Purchase & Sales - Line Chart ======
    const salesCtx = document.getElementById('purchaseSalesChart');
    if (salesCtx) {
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: ['01 February', '05', '10', '15', '20', '25', '28 February'],
                datasets: [
                    {
                        label: 'Sales',
                        data: [100, 150, 120, 200, 180, 250, 350],
                        borderColor: '#22C55E',
                        backgroundColor: 'rgba(34, 197, 94, 0.05)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 2,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: '#22C55E',
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 2,
                    },
                    {
                        label: 'Purchase',
                        data: [80, 100, 90, 140, 130, 160, 250],
                        borderColor: '#8B5CF6',
                        backgroundColor: 'rgba(139, 92, 246, 0.05)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 2,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: '#8B5CF6',
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 2,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#000',
                        bodyColor: '#8B8E97',
                        borderColor: '#E5E7EB',
                        borderWidth: 1,
                        cornerRadius: 8,
                        padding: 10,
                        displayColors: true,
                        boxPadding: 4,
                    }
                },
                scales: {
                    x: {
                        grid: { color: '#F3F4F6', drawBorder: false },
                        ticks: { font: { size: 11, family: 'Plus Jakarta Sans', weight: 500 }, color: '#8B8E97' },
                        border: { display: false },
                    },
                    y: {
                        grid: { color: '#F3F4F6', drawBorder: false },
                        ticks: { font: { size: 11, family: 'Plus Jakarta Sans', weight: 500 }, color: '#8B8E97' },
                        border: { display: false },
                    }
                }
            }
        });
    }
});
</script>
@endsection
