@extends('layouts.dashboard')

@section('title', 'Dashboard - Vern')
@section('page_title', 'Dashboard')

@section('content')
<div class="flex flex-col gap-6">

    <!-- Row 1: Sales Activity + Top Selling Category + Top Selling Items -->
    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 24px;">

        <!-- Sales Activity -->
        <div class="bg-white rounded-[16px] border border-black/5 p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-[16px] font-bold text-black tracking-[-0.03em]">Sales Activity</h3>
                <button class="w-7 h-7 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors text-gray-400">
                    <iconify-icon icon="solar:menu-dots-bold" width="18" height="18"></iconify-icon>
                </button>
            </div>

            <!-- 3 Stat Cards Horizontal -->
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px;">
                <!-- To be Shipped -->
                <div class="bg-[#F8F9FB] rounded-[12px] p-4 flex flex-col">
                    <p class="text-[11px] font-medium text-[#8B8E97] mb-2">To be Shipped</p>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-[24px] font-bold text-black leading-none">{{ $toBeShipped }}</span>
                        <span class="text-[9px] font-semibold px-1.5 py-0.5 rounded-full whitespace-nowrap" style="color: {{ $orderChangePercent >= 0 ? '#22C55E' : '#EF4444' }}; background: {{ $orderChangePercent >= 0 ? 'rgba(34,197,94,0.1)' : 'rgba(239,68,68,0.1)' }};">{{ $orderChangePercent >= 0 ? '↑' : '↓' }}{{ $orderChangePercent >= 0 ? '+' : '' }}{{ $orderChangePercent }}%</span>
                    </div>
                    <div class="flex items-end justify-between mt-auto">
                        <svg width="70" height="24" viewBox="0 0 70 24" fill="none" class="flex-shrink-0">
                            <path d="M0 20 Q8 15, 15 17 T30 12 T45 14 T60 5 L70 3" stroke="#22C55E" stroke-width="2" fill="none" stroke-linecap="round"/>
                        </svg>
                        <span class="text-[10px] font-semibold text-[#8B8E97] ml-1">Rp{{ number_format($thisMonthRevenue, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- To be Packed -->
                <div class="bg-[#F8F9FB] rounded-[12px] p-4 flex flex-col">
                    <p class="text-[11px] font-medium text-[#8B8E97] mb-2">To be Packed</p>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-[24px] font-bold text-black leading-none">{{ $toBePacked }}</span>
                        <span class="text-[9px] font-semibold px-1.5 py-0.5 rounded-full whitespace-nowrap" style="color: {{ $orderChangePercent >= 0 ? '#22C55E' : '#EF4444' }}; background: {{ $orderChangePercent >= 0 ? 'rgba(34,197,94,0.1)' : 'rgba(239,68,68,0.1)' }};">{{ $orderChangePercent >= 0 ? '↑' : '↓' }}{{ $orderChangePercent >= 0 ? '+' : '' }}{{ $orderChangePercent }}%</span>
                    </div>
                    <div class="flex items-end justify-center mt-auto" style="height: 28px; gap: 3px;">
                        @php $bars = [12, 20, 28, 16, 24, 18, 26]; @endphp
                        @foreach($bars as $h)
                            <div style="width: 6px; height: {{ $h }}px; background: #0077FF; border-radius: 9999px;"></div>
                        @endforeach
                    </div>
                </div>

                <!-- To be Invoiced -->
                <div class="bg-[#F8F9FB] rounded-[12px] p-4 flex flex-col">
                    <p class="text-[11px] font-medium text-[#8B8E97] mb-2">To be Invoiced</p>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-[24px] font-bold text-black leading-none">{{ $toBeInvoiced }}</span>
                        @php $invoicePercent = $toBePacked > 0 ? round(($toBeInvoiced / $toBePacked) * 100) : 0; @endphp
                        <span class="text-[9px] font-semibold px-1.5 py-0.5 rounded-full whitespace-nowrap" style="color: {{ $invoicePercent >= 50 ? '#22C55E' : '#EF4444' }}; background: {{ $invoicePercent >= 50 ? 'rgba(34,197,94,0.1)' : 'rgba(239,68,68,0.1)' }};">{{ $invoicePercent }}%</span>
                    </div>
                    <div class="flex items-center justify-center mt-auto">
                        <div class="relative" style="width: 50px; height: 50px;">
                            <svg viewBox="0 0 36 36" style="width: 100%; height: 100%; transform: rotate(-90deg);">
                                <circle cx="18" cy="18" r="15.9155" fill="none" stroke="#E5E7EB" stroke-width="3"/>
                                <circle cx="18" cy="18" r="15.9155" fill="none" stroke="#FBA518" stroke-width="3" stroke-dasharray="{{ $invoicePercent }} {{ 100 - $invoicePercent }}" stroke-linecap="round"/>
                            </svg>
                            <span style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 700; color: #000;">{{ $invoicePercent }}%</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-5 mt-4 pl-2 text-[10px] font-medium text-[#8B8E97]">
                <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span>
            </div>
        </div>

        <!-- Top Sellings Category -->
        <div class="bg-white rounded-[16px] border border-black/5 p-6" x-data="{ period: 'month' }">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-[14px] font-bold text-black tracking-[-0.03em]">Top Sellings Category</h3>
                <button class="w-6 h-6 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors text-gray-400">
                    <iconify-icon icon="solar:menu-dots-bold" width="16" height="16"></iconify-icon>
                </button>
            </div>

            <!-- Period Tabs -->
            <div class="flex items-center bg-[#F3F4F6] rounded-lg p-1 mb-5">
                <button @click="period = 'week'" :class="period === 'week' ? 'bg-white shadow-sm text-black' : 'text-[#8B8E97]'" class="flex-1 py-1.5 rounded-md text-[11px] font-semibold transition-all">Week</button>
                <button @click="period = 'month'" :class="period === 'month' ? 'bg-white shadow-sm text-black' : 'text-[#8B8E97]'" class="flex-1 py-1.5 rounded-md text-[11px] font-semibold transition-all">Month</button>
                <button @click="period = 'year'" :class="period === 'year' ? 'bg-white shadow-sm text-black' : 'text-[#8B8E97]'" class="flex-1 py-1.5 rounded-md text-[11px] font-semibold transition-all">Year</button>
            </div>

            <!-- Category Bars -->
            <div class="flex flex-col gap-4">
                @php $catColors = ['#FBA518', '#0077FF', '#22C55E', '#EF4444', '#8B5CF6']; @endphp
                @foreach($topCategories as $cat)
                <div class="flex flex-col gap-1.5">
                    <div class="flex items-center justify-between">
                        <span class="text-[12px] font-medium text-black truncate" style="max-width: 75%;">{{ $cat['name'] }}</span>
                        <span class="text-[12px] font-bold text-black">{{ $cat['percentage'] }}%</span>
                    </div>
                    <div style="width: 100%; height: 6px; background: #F3F4F6; border-radius: 9999px; overflow: hidden;">
                        <div style="height: 100%; width: {{ $cat['percentage'] }}%; background: {{ $catColors[$loop->index % count($catColors)] }}; border-radius: 9999px; transition: width 0.7s;"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Top Selling Items Heatmap -->
        <div class="bg-white rounded-[16px] border border-black/5 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-[14px] font-bold text-black tracking-[-0.03em]">Top Selling Items</h3>
                <button class="w-6 h-6 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors text-gray-400">
                    <iconify-icon icon="solar:menu-dots-bold" width="16" height="16"></iconify-icon>
                </button>
            </div>

            <!-- Legend -->
            <div class="flex items-center gap-3 mb-4">
                <div class="flex items-center gap-1"><div style="width: 10px; height: 10px; border-radius: 2px; background: #E8F5E9;"></div><span class="text-[9px] text-[#8B8E97] font-medium">0k - 5k</span></div>
                <div class="flex items-center gap-1"><div style="width: 10px; height: 10px; border-radius: 2px; background: #0077FF;"></div><span class="text-[9px] text-[#8B8E97] font-medium">5k - 15k</span></div>
                <div class="flex items-center gap-1"><div style="width: 10px; height: 10px; border-radius: 2px; background: #FBA518;"></div><span class="text-[9px] text-[#8B8E97] font-medium">15k - 25k</span></div>
            </div>

            <!-- Heatmap Grid -->
            <div class="flex flex-col" style="gap: 5px;">
                @foreach($topItems as $item)
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-medium text-[#8B8E97] truncate" style="width: 55px;">{{ $item }}</span>
                    <div class="flex flex-1" style="gap: 4px;">
                        @for($d = 0; $d < 7; $d++)
                            @php
                                $qty = isset($heatmapData[$item]) ? ($heatmapData[$item][$d] ?? 0) : 0;
                                if ($qty >= 15) $hColor = '#FBA518';
                                elseif ($qty >= 5) $hColor = '#0077FF';
                                else $hColor = '#E8F5E9';
                            @endphp
                            <div style="flex: 1; height: 20px; border-radius: 3px; background: {{ $hColor }};" title="{{ $qty }} sold"></div>
                        @endfor
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Day Labels -->
            <div class="flex" style="gap: 4px; margin-top: 6px; padding-left: 63px;">
                @foreach(['S', 'M', 'T', 'W', 'T', 'F', 'S'] as $day)
                    <span style="flex: 1; text-align: center; font-size: 9px; font-weight: 500; color: #8B8E97;">{{ $day }}</span>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Row 2: Total Product Details + Purchase & Sales -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">

        <!-- Total Product Details - Bar Chart -->
        <div class="bg-white rounded-[16px] border border-black/5 p-6">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-[16px] font-bold text-black tracking-[-0.03em]">Total Product Details</h3>
                <div class="flex items-center gap-2 bg-[#F8F9FB] rounded-lg px-3 py-1.5 text-[12px] font-medium text-[#8B8E97] cursor-pointer">
                    <iconify-icon icon="solar:calendar-linear" width="14" height="14"></iconify-icon>
                    This Years
                    <iconify-icon icon="solar:alt-arrow-down-linear" width="14" height="14"></iconify-icon>
                </div>
            </div>
            <div class="flex items-center gap-4 mb-4">
                <div class="flex items-center gap-1.5"><div style="width: 10px; height: 10px; border-radius: 50%; background: #22C55E;"></div><span class="text-[11px] font-medium text-[#8B8E97]">Total Stock Items</span></div>
                <div class="flex items-center gap-1.5"><div style="width: 10px; height: 10px; border-radius: 50%; background: #0077FF;"></div><span class="text-[11px] font-medium text-[#8B8E97]">High Stock Items</span></div>
                <div class="flex items-center gap-1.5"><div style="width: 10px; height: 10px; border-radius: 50%; background: #FBA518;"></div><span class="text-[11px] font-medium text-[#8B8E97]">Low Stock Items</span></div>
            </div>
            <div style="height: 220px; position: relative;">
                <canvas id="productDetailsChart"></canvas>
            </div>
        </div>

        <!-- Purchase & Sales - Line Chart -->
        <div class="bg-white rounded-[16px] border border-black/5 p-6">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-[16px] font-bold text-black tracking-[-0.03em]">Purchase & Sales</h3>
                <div class="flex items-center gap-2 bg-[#F8F9FB] rounded-lg px-3 py-1.5 text-[12px] font-medium text-[#8B8E97] cursor-pointer">
                    <iconify-icon icon="solar:calendar-linear" width="14" height="14"></iconify-icon>
                    This Month
                    <iconify-icon icon="solar:alt-arrow-down-linear" width="14" height="14"></iconify-icon>
                </div>
            </div>
            <div class="flex items-center gap-4 mb-4">
                <div class="flex items-center gap-1.5"><div style="width: 10px; height: 10px; border-radius: 50%; background: #22C55E;"></div><span class="text-[11px] font-medium text-[#8B8E97]">Sales</span></div>
                <div class="flex items-center gap-1.5"><div style="width: 10px; height: 10px; border-radius: 50%; background: #8B5CF6;"></div><span class="text-[11px] font-medium text-[#8B8E97]">Purchase</span></div>
            </div>
            <div style="height: 220px; position: relative;">
                <canvas id="purchaseSalesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Row 3: Sales Order Table -->
    <div class="bg-white rounded-[16px] border border-black/5 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-[16px] font-bold text-black tracking-[-0.03em]">Sales Order</h3>
            <div class="flex items-center gap-2 bg-[#F8F9FB] rounded-lg px-3 py-1.5 text-[12px] font-medium text-[#8B8E97] cursor-pointer">
                <iconify-icon icon="solar:calendar-linear" width="14" height="14"></iconify-icon>
                This Years
                <iconify-icon icon="solar:alt-arrow-down-linear" width="14" height="14"></iconify-icon>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left border-b border-black/5">
                        <th class="pb-3 pl-3 w-10"><input type="checkbox" class="w-4 h-4 rounded border-gray-300 accent-[#0077FF]" /></th>
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
                            <td class="py-4 pl-3"><input type="checkbox" class="w-4 h-4 rounded border-gray-300 accent-[#0077FF]" /></td>
                            <td class="py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-[12px] font-bold text-[#0077FF]" style="background: linear-gradient(135deg, rgba(0,119,255,0.15), rgba(251,165,24,0.15));">
                                        {{ strtoupper(substr($order->customer_name, 0, 2)) }}
                                    </div>
                                    <span class="text-[13px] font-semibold text-black">{{ $order->customer_name }}</span>
                                </div>
                            </td>
                            <td class="py-4 text-center">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-[12px] font-bold" style="background: rgba(34,197,94,0.1); color: #22C55E;">{{ $order->items->count() }}</span>
                            </td>
                            <td class="py-4 text-[13px] font-medium text-[#8B8E97]">{{ \Carbon\Carbon::parse($order->order_date)->format('M d,Y') }}</td>
                            <td class="py-4 text-center">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-[12px] font-bold" style="background: rgba(0,119,255,0.1); color: #0077FF;">{{ $order->items->sum('qty') }}</span>
                            </td>
                            <td class="py-4">
                                @php
                                    $statusStyles = [
                                        'lunas' => ['label' => 'Confirmed', 'bg' => 'rgba(34,197,94,0.1)', 'color' => '#22C55E'],
                                        'belum lunas' => ['label' => 'Pending', 'bg' => 'rgba(251,165,24,0.1)', 'color' => '#FBA518'],
                                        'batal' => ['label' => 'Cancel', 'bg' => 'rgba(239,68,68,0.1)', 'color' => '#EF4444'],
                                    ];
                                    $s = $statusStyles[$order->status] ?? $statusStyles['belum lunas'];
                                @endphp
                                <span class="inline-flex px-3 py-1 rounded-full text-[11px] font-semibold" style="background: {{ $s['bg'] }}; color: {{ $s['color'] }};">{{ $s['label'] }}</span>
                            </td>
                            <td class="py-4 text-[13px] font-semibold text-black">${{ number_format($order->total_amount, 2) }}</td>
                            <td class="py-4 text-[13px] font-medium text-[#8B8E97]">{{ $order->order_id }}</td>
                            <td class="py-4">
                                <div class="flex items-center justify-center gap-1">
                                    <button class="w-7 h-7 rounded-md hover:bg-gray-100 flex items-center justify-center text-[#8B8E97] transition-colors"><iconify-icon icon="solar:trash-bin-2-linear" width="15"></iconify-icon></button>
                                    <button class="w-7 h-7 rounded-md hover:bg-gray-100 flex items-center justify-center text-[#8B8E97] transition-colors"><iconify-icon icon="solar:pen-linear" width="15"></iconify-icon></button>
                                    <button class="w-7 h-7 rounded-md hover:bg-gray-100 flex items-center justify-center text-[#8B8E97] transition-colors"><iconify-icon icon="solar:menu-dots-bold" width="15"></iconify-icon></button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9" class="py-12 text-center text-[13px] font-medium text-[#8B8E97]">Belum ada data pesanan</td>
                        </tr>
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
    // Real data from controller
    const monthlyProductData = @json($monthlyProductData);
    const monthlySalesData = @json($monthlySalesData);
    const monthlyPurchaseData = @json($monthlyPurchaseData);
    const dailyLabels = @json($dailyLabels);

    const productCtx = document.getElementById('productDetailsChart');
    if (productCtx) {
        new Chart(productCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [
                    { label: 'Total Stock Items', data: monthlyProductData.map(d => d.totalStock), backgroundColor: '#22C55E', borderRadius: 3, barPercentage: 0.55, categoryPercentage: 0.7 },
                    { label: 'High Stock Items', data: monthlyProductData.map(d => d.highStock), backgroundColor: '#0077FF', borderRadius: 3, barPercentage: 0.55, categoryPercentage: 0.7 },
                    { label: 'Low Stock Items', data: monthlyProductData.map(d => d.lowStock), backgroundColor: '#FBA518', borderRadius: 3, barPercentage: 0.55, categoryPercentage: 0.7 }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 11, family: 'Plus Jakarta Sans' }, color: '#8B8E97' }, border: { display: false } },
                    y: { grid: { color: '#F3F4F6' }, ticks: { font: { size: 11, family: 'Plus Jakarta Sans' }, color: '#8B8E97', callback: function(v) { return v >= 1000 ? (v/1000)+' K' : v; } }, border: { display: false } }
                }
            }
        });
    }

    const salesCtx = document.getElementById('purchaseSalesChart');
    if (salesCtx) {
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: dailyLabels,
                datasets: [
                    { label: 'Sales', data: monthlySalesData, borderColor: '#22C55E', backgroundColor: 'rgba(34,197,94,0.08)', tension: 0.4, fill: true, borderWidth: 2, pointRadius: 0, pointHoverRadius: 5 },
                    { label: 'Purchase', data: monthlyPurchaseData, borderColor: '#8B5CF6', backgroundColor: 'rgba(139,92,246,0.05)', tension: 0.4, fill: true, borderWidth: 2, pointRadius: 0, pointHoverRadius: 5 }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: { backgroundColor: '#fff', titleColor: '#000', bodyColor: '#8B8E97', borderColor: '#E5E7EB', borderWidth: 1, cornerRadius: 8, padding: 10, displayColors: true, boxPadding: 4 } },
                scales: {
                    x: { grid: { color: '#F3F4F6' }, ticks: { font: { size: 11, family: 'Plus Jakarta Sans' }, color: '#8B8E97', maxTicksLimit: 5 }, border: { display: false } },
                    y: { grid: { color: '#F3F4F6' }, ticks: { font: { size: 11, family: 'Plus Jakarta Sans' }, color: '#8B8E97' }, border: { display: false } }
                }
            }
        });
    }
});
</script>
@endsection
