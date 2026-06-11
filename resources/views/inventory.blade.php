@extends('layouts.dashboard')

@section('title', 'Inventaris - Vern Dashboard')
@section('page_title', 'Inventaris')

@section('content')
<!-- Toast Notification Container -->
<div id="toastContainer" style="position: fixed; top: 24px; right: 24px; z-index: 100000; display: flex; flex-direction: column; gap: 12px; pointer-events: none;"></div>

<!-- Stock Status Details Popover -->
<div id="statusDetailsPopover" style="position: absolute; display: none; z-index: 999999; background: white; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.08), 0 1px 3px rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.06); width: 280px; padding: 16px; font-family: 'Plus Jakarta Sans', sans-serif; opacity: 0; transform: translateY(-5px); transition: opacity 0.15s ease, transform 0.15s ease; pointer-events: auto;">
    <!-- Visual Bar -->
    <div id="popoverProgressBar" style="display: flex; height: 16px; border-radius: 6px; overflow: hidden; margin-bottom: 12px; background-color: #F1F3F6; gap: 2px;"></div>
    
    <!-- Legend / Labels of segments -->
    <div id="popoverLabels" style="display: flex; justify-content: space-between; font-size: 8px; color: #8B8E97; font-weight: 700; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.05em; font-family: 'Plus Jakarta Sans', sans-serif;"></div>

    <!-- Divider -->
    <div style="height: 1px; background-color: rgba(0,0,0,0.05); margin-bottom: 12px;"></div>

    <!-- Title / Main status info -->
    <div id="popoverTitle" style="font-size: 11px; font-weight: 800; color: #000000; margin-bottom: 4px; font-family: 'Plus Jakarta Sans', sans-serif; line-height: 1.4;"></div>
    
    <!-- Subtitle / Details -->
    <div id="popoverSubtitle" style="font-size: 10px; font-weight: 500; color: #8B8E97; line-height: 1.4; font-family: 'Plus Jakarta Sans', sans-serif;"></div>

    <!-- Arrow pointing down -->
    <div id="popoverArrow" style="position: absolute; bottom: -6px; left: 50%; transform: translateX(-50%) rotate(45deg); width: 12px; height: 12px; background-color: #FFFFFF; border-right: 1px solid rgba(0,0,0,0.06); border-bottom: 1px solid rgba(0,0,0,0.06); z-index: -1;"></div>
</div>

<div class="bg-white rounded-[20px] p-8 border border-black/5 shadow-sm">
    <!-- Header Row -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-[18px] font-bold text-black tracking-[-2%]">Tabel Inventaris</h2>
        
        <div class="flex items-center gap-6">
            <!-- Import From Excel -->
            <button class="flex items-center gap-2 text-sm font-bold text-[#8B8E97] hover:text-black transition-all cursor-pointer">
                <span>Impor Dari</span>
                <iconify-icon icon="vscode-icons:file-type-excel" width="20" height="20"></iconify-icon>
            </button>

            <!-- Add Product Button -->
            <button onclick="openAddProductModal()" class="flex items-center gap-2 bg-[#0077FF] hover:bg-[#0062D1] text-white px-5 py-3 rounded-[12px] text-sm font-bold transition-all shadow-sm shadow-[#0077FF]/20 cursor-pointer">
                <iconify-icon icon="material-symbols:add-rounded" width="20" height="20"></iconify-icon>
                <span>Tambah Produk</span>
            </button>
        </div>
    </div>

    <!-- Alert Notice Banner (Figma Exact) -->
    <div class="mb-6 flex items-center gap-3 px-4 py-3 rounded-[10px]" style="background-color: #E8F0FE; border: 1px solid #1D38FF; width: 100%;">
        <iconify-icon icon="material-symbols:info-rounded" class="text-[#1D38FF]" width="20" height="20" style="flex-shrink: 0;"></iconify-icon>
        <span class="text-[13px] font-semibold text-black tracking-[-1%]">Sebagian besar produk dalam kondisi baik. Beberapa item memerlukan perhatian untuk pengisian ulang stok.</span>
    </div>

    <!-- Filter & Search Controls (Part 2) -->
    <div class="flex items-center justify-between gap-4 mb-6">
        <!-- Left: Filters -->
        <div class="flex items-center gap-3">
            <!-- Filter Button -->
            <button id="btnFilterAll" onclick="selectInventoryFilter('all')" class="text-[13px] font-bold text-[#0077FF] bg-[#0077FF]/5 border border-[#0077FF]/20 transition-all cursor-pointer" style="padding: 6px 16px; border-radius: 8px;">
                <span>Filter</span>
            </button>

            <!-- Healthy Pill -->
            <button id="btnFilterHealthy" onclick="selectInventoryFilter('healthy')" class="text-[13px] font-semibold text-[#8B8E97] bg-white hover:bg-gray-50 transition-all cursor-pointer" style="padding: 6px 16px; display: flex; align-items: center; gap: 8px; border: 1px solid rgba(0,0,0,0.1); border-radius: 8px;">
                <span id="dotFilterHealthy" style="width: 6px; height: 6px; border-radius: 50%; background-color: #9CA3AF; display: inline-block; flex-shrink: 0;"></span>
                <span>Sehat</span>
            </button>

            <!-- Running Low Pill -->
            <button id="btnFilterLow" onclick="selectInventoryFilter('running low')" class="text-[13px] font-semibold text-[#8B8E97] bg-white hover:bg-gray-50 transition-all cursor-pointer" style="padding: 6px 16px; display: flex; align-items: center; gap: 8px; border: 1px solid rgba(0,0,0,0.1); border-radius: 8px;">
                <span id="dotFilterLow" style="width: 6px; height: 6px; border-radius: 50%; background-color: #9CA3AF; display: inline-block; flex-shrink: 0;"></span>
                <span>Stok Menipis</span>
            </button>

            <!-- Out Of Stock Pill -->
            <button id="btnFilterOut" onclick="selectInventoryFilter('out of stock')" class="text-[13px] font-semibold text-[#8B8E97] bg-white hover:bg-gray-50 transition-all cursor-pointer" style="padding: 6px 16px; display: flex; align-items: center; gap: 8px; border: 1px solid rgba(0,0,0,0.1); border-radius: 8px;">
                <span id="dotFilterOut" style="width: 6px; height: 6px; border-radius: 50%; background-color: #9CA3AF; display: inline-block; flex-shrink: 0;"></span>
                <span>Stok Habis</span>
            </button>
        </div>

        <!-- Right: Search Input (Figma Gray Style via Inline CSS) -->
        <div style="position: relative; display: flex; align-items: center; width: 280px; height: 38px; background-color: #F1F3F6; border-radius: 10px; padding: 0 14px; gap: 8px;">
            <iconify-icon icon="solar:magnifer-linear" width="18" height="18" class="text-black" style="flex-shrink: 0;"></iconify-icon>
            <input 
                id="inventorySearchInput"
                type="text" 
                placeholder="Cari" 
                class="placeholder:text-[#8B8E97]"
                style="width: 100%; height: 100%; background: transparent; border: none; outline: none; font-size: 13px; font-weight: 600; color: #000000; padding: 0;"
                oninput="applyInventoryFilters()"
            />
        </div>
    </div>

    <!-- Custom CSS to strip out any global table borders and match Figma -->
    <style>
        .figma-table {
            width: max-content !important;
            min-width: 100%;
            border-collapse: separate !important;
            border-spacing: 0 !important;
            border: none !important;
        }
        .figma-table th {
            border: none !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
            color: #1A1D1F !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            padding: 12px 16px !important;
            background-color: #FFFFFF !important;
            text-align: left;
        }
        .figma-table td {
            border: none !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
            padding: 16px 16px !important;
            vertical-align: middle !important;
            color: #1A1D1F !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            background-color: #FFFFFF !important;
        }
        .figma-table tr:hover td {
            background-color: #F8F9FB !important;
        }
        /* Ensure variant rows have solid background to prevent scroll-under bleed-through */
        .figma-table tr[class*="variant-row-"] td {
            background-color: #FAFBFC !important;
        }
        .figma-table tr[class*="variant-row-"]:hover td {
            background-color: #F1F3F5 !important;
        }

        /* Sticky / Frozen Columns */
        .figma-table th.col-sticky-1,
        .figma-table td.col-sticky-1 {
            position: sticky !important;
            left: 0 !important;
            z-index: 3 !important;
        }
        .figma-table th.col-sticky-2,
        .figma-table td.col-sticky-2 {
            position: sticky !important;
            left: 48px !important;
            z-index: 3 !important;
        }
        .figma-table th.col-sticky-3,
        .figma-table td.col-sticky-3 {
            position: sticky !important;
            left: 288px !important;
            z-index: 3 !important;
        }
        .figma-table th.col-sticky-4,
        .figma-table td.col-sticky-4 {
            position: sticky !important;
            left: 400px !important;
            z-index: 3 !important;
        }
        /* Sticky Action column on the right */
        /* Drop-shadow on the last frozen left col to show scroll depth */
        .figma-table th.col-sticky-4,
        .figma-table td.col-sticky-4 {
            box-shadow: 4px 0 8px -2px rgba(0,0,0,0.06) !important;
        }

        /* Grade Badges (Figma Capsule/Pill Style) */
        .grade-badge-a, .grade-badge-b, .grade-badge-c {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 2px 10px !important;
            height: 22px !important;
            border-radius: 100px !important;
            font-size: 11px !important;
            font-weight: 700 !important;
        }
        .grade-badge-a {
            color: #10B981 !important;
            background-color: #E8FDF5 !important;
            border: 1px solid #A7F3D0 !important;
        }
        .grade-badge-b {
            color: #0077FF !important;
            background-color: #EEF6FF !important;
            border: 1px solid #BFDBFE !important;
        }
        .grade-badge-c {
            color: #FF8F00 !important;
            background-color: #FFF8EE !important;
            border: 1px solid #FFE4BB !important;
        }

        /* Status Pills (White Background, Colored Borders, Colored Text) */
        .status-healthy, .status-low, .status-out {
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            padding: 4px 12px !important;
            border-radius: 100px !important;
            font-size: 11px !important;
            font-weight: 700 !important;
            background-color: #FFFFFF !important;
            white-space: nowrap !important;
        }
        .status-healthy {
            color: #10B981 !important;
            border: 1px solid #D1FAE5 !important;
        }
        .status-low {
            color: #0077FF !important;
            border: 1px solid #DBEAFE !important;
        }
        .status-out {
            color: #FF4D4D !important;
            border: 1px solid #FEE2E2 !important;
        }
        .status-dot-figma {
            width: 6px !important;
            height: 6px !important;
            border-radius: 50% !important;
            display: inline-block !important;
            flex-shrink: 0 !important;
        }

        /* Barcode Scanner Laser Effect */
        @keyframes scan-laser {
            0% {
                top: 5%;
                opacity: 0;
            }
            15% {
                opacity: 1;
            }
            85% {
                opacity: 1;
            }
            100% {
                top: 90%;
                opacity: 0;
            }
        }
        .laser-scanning {
            display: block !important;
            animation: scan-laser 1.2s ease-in-out forwards;
        }
        
        @keyframes barcode-fade-in {
            0% {
                opacity: 0;
                transform: scale(0.96);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }
        .barcode-animated {
            animation: barcode-fade-in 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        /* Error Highlight State */
        .input-error-state {
            border: 1px solid #FF4D4D !important;
            background-color: #FFF5F5 !important;
        }
        .error-message-text {
            color: #FF4D4D;
            font-size: 11px;
            font-weight: 600;
            margin-top: 4px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            display: block;
        }

        /* Premium scrollbar styling for fixed header modal container */
        .premium-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .premium-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .premium-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.15);
            border-radius: 10px;
        }
        .premium-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.3);
        }
    </style>

    <!-- Inventory Data Table & Pagination (Part 3) -->
    <div class="-mx-8" style="overflow-x: auto; position: relative;">
        <table class="figma-table">
            <thead>
                <tr>
                    <th class="col-sticky-1" style="width: 48px; min-width: 48px; padding-left: 24px !important;">
                        <input type="checkbox" class="w-4 h-4 rounded border-black/10 text-[#0077FF] focus:ring-[#0077FF] cursor-pointer" />
                    </th>
                    <th class="col-sticky-2" style="min-width: 240px;">
                        <div class="flex items-center gap-1 cursor-pointer">
                            <span>Produk & Varian</span>
                            <iconify-icon icon="tabler:arrows-sort" width="14" height="14" class="text-black/30"></iconify-icon>
                        </div>
                    </th>
                    <th class="col-sticky-3" style="min-width: 112px;">Kategori</th>
                    <th class="col-sticky-4" style="min-width: 100px;">
                        <div class="flex items-center gap-1 cursor-pointer">
                            <span>Nilai</span>
                            <iconify-icon icon="material-symbols:help-outline" width="14" height="14" class="text-black/30"></iconify-icon>
                            <iconify-icon icon="tabler:arrows-sort" width="14" height="14" class="text-black/30"></iconify-icon>
                        </div>
                    </th>
                    <th style="min-width: 130px;">
                        <div class="flex items-center gap-1 cursor-pointer">
                            <span>Status</span>
                            <iconify-icon icon="tabler:arrows-sort" width="14" height="14" class="text-black/30"></iconify-icon>
                        </div>
                    </th>
                    <th style="min-width: 120px;">
                        <div class="flex items-center gap-1 cursor-pointer">
                            <span>Penjualan Harian</span>
                            <iconify-icon icon="tabler:arrows-sort" width="14" height="14" class="text-black/30"></iconify-icon>
                        </div>
                    </th>
                    <th style="min-width: 150px;">
                        <div class="flex items-center gap-1 cursor-pointer">
                            <span>Pendapatan Bulanan</span>
                            <iconify-icon icon="tabler:arrows-sort" width="14" height="14" class="text-black/30"></iconify-icon>
                        </div>
                    </th>
                    <th style="min-width: 160px;">SKU / Kode Batang</th>
                    <th style="min-width: 180px;">Harga Beli & Jual</th>
                    <th style="min-width: 130px;">
                        <div class="flex items-center justify-end gap-1 cursor-pointer">
                            <span>Stok Aktual</span>
                            <iconify-icon icon="tabler:arrows-sort" width="14" height="14" class="text-black/30"></iconify-icon>
                        </div>
                    </th>
                    <th style="min-width: 100px; padding-right: 24px !important; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <!-- Parent Row -->
                <tr class="cursor-pointer hover:bg-gray-50/50" onclick="toggleVariants({{ $product->id }})">
                    <td class="col-sticky-1" style="padding-left: 24px !important;" onclick="event.stopPropagation()">
                        <input type="checkbox" class="w-4 h-4 rounded border-black/10 text-[#0077FF] focus:ring-[#0077FF] cursor-pointer" />
                    </td>
                    <td class="col-sticky-2">
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 flex items-center justify-center rounded-md hover:bg-gray-100 transition-all">
                                <iconify-icon id="arrow-icon-{{ $product->id }}" icon="solar:alt-arrow-right-linear" width="16" height="16" class="transition-transform duration-200"></iconify-icon>
                            </div>
                            <img src="{{ $product->image_path ?? 'https://images.unsplash.com/photo-1568254183919-78a4f43a2877?w=100&auto=format&fit=crop&q=60' }}" alt="" class="w-10 h-10 rounded-[8px] object-cover border border-black/5" />
                            <div class="flex flex-col">
                                <span class="font-bold text-black">{{ $product->name }}</span>
                                <span class="text-[11px] text-gray-400 font-medium">{{ $product->variants->count() }} Varian</span>
                            </div>
                        </div>
                    </td>
                    <td class="col-sticky-3">{{ $product->category->name ?? 'Tanpa Kategori' }}</td>
                    <td class="col-sticky-4">
                        <span class="grade-badge-{{ strtolower($product->grade) }}">{{ strtoupper($product->grade) }}</span>
                    </td>
                    <td>
                        @if (strtolower($product->status) === 'healthy')
                            <span class="status-healthy cursor-pointer" onclick="event.stopPropagation(); showStatusPopover(this)"
                                  data-status="healthy"
                                  data-stock="{{ $product->variants->sum('actual_stock') }}"
                                  data-min-stock="{{ $product->variants->sum('min_stock') }}"
                                  data-daily-sales="{{ $product->daily_sales }}"
                                  data-price="{{ $product->variants->first()->selling_price ?? 0 }}">
                                <span class="status-dot-figma" style="background-color: #10B981;"></span>
                                <span>Sehat</span>
                            </span>
                        @elseif (strtolower($product->status) === 'running low')
                            <span class="status-low cursor-pointer" onclick="event.stopPropagation(); showStatusPopover(this)"
                                  data-status="running low"
                                  data-stock="{{ $product->variants->sum('actual_stock') }}"
                                  data-min-stock="{{ $product->variants->sum('min_stock') }}"
                                  data-daily-sales="{{ $product->daily_sales }}"
                                  data-price="{{ $product->variants->first()->selling_price ?? 0 }}">
                                <span class="status-dot-figma" style="background-color: #0077FF;"></span>
                                <span>Stok Menipis</span>
                            </span>
                        @else
                            <span class="status-out cursor-pointer" onclick="event.stopPropagation(); showStatusPopover(this)"
                                  data-status="out of stock"
                                  data-stock="{{ $product->variants->sum('actual_stock') }}"
                                  data-min-stock="{{ $product->variants->sum('min_stock') }}"
                                  data-daily-sales="{{ $product->daily_sales }}"
                                  data-price="{{ $product->variants->first()->selling_price ?? 0 }}">
                                <span class="status-dot-figma" style="background-color: #FF4D4D;"></span>
                                <span>Stok Habis</span>
                            </span>
                        @endif
                    </td>
                    <td>{{ $product->daily_sales }} unit</td>
                    <td>Rp{{ number_format($product->monthly_revenue, 0, ',', '.') }}</td>
                    <td class="text-gray-400 text-[11px] font-medium">-</td>
                    <td class="text-gray-400 text-[11px] font-medium">-</td>
                    <td class="text-right font-bold">{{ $product->variants->sum('actual_stock') }} Total</td>
                    <td style="padding-right: 24px !important; text-align: center;" onclick="event.stopPropagation()">
                        <button class="w-8 h-8 mx-auto flex items-center justify-center rounded-lg hover:bg-gray-100 transition-all cursor-pointer text-gray-400 hover:text-black border-0 bg-transparent">
                            <iconify-icon icon="solar:menu-dots-bold" width="18" height="18"></iconify-icon>
                        </button>
                    </td>
                </tr>

                <!-- Child Variant Rows -->
                @foreach ($product->variants as $variant)
                @php
                    $safeProduct = [
                        'name' => $product->name,
                        'details' => $product->details,
                        'image_path' => $product->image_path,
                        'grade' => $product->grade,
                        'daily_sales' => $product->daily_sales,
                        'monthly_revenue' => $product->monthly_revenue,
                    ];
                    $safeVariant = [
                        'variant_name' => $variant->variant_name,
                        'variant_unit' => $variant->variant_unit,
                        'sku' => $variant->sku,
                        'actual_stock' => $variant->actual_stock,
                        'min_stock' => $variant->min_stock,
                        'cost_price' => $variant->cost_price,
                        'selling_price' => $variant->selling_price,
                        'enable_stock_alert' => $variant->enable_stock_alert,
                        'barcode' => $variant->barcode,
                    ];
                @endphp
                <tr class="variant-row-{{ $product->id }} transition-colors" 
                    style="display: none;"
                    data-variant='{!! json_encode($safeVariant, JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_TAG) !!}'
                    data-product='{!! json_encode($safeProduct, JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_TAG) !!}'>
                    <td class="col-sticky-1" style="padding-left: 24px !important;"></td>
                    <td class="col-sticky-2" style="padding-left: 48px !important;">
                        <div class="flex items-center gap-2">
                            <span style="width: 6px; height: 6px; border-radius: 50%; background-color: #CBD5E1; display: inline-block;"></span>
                            <span class="font-semibold text-gray-700">{{ $variant->variant_name }}</span>
                            <span class="text-[10px] text-gray-400 font-bold bg-gray-100 px-1.5 py-0.5 rounded">{{ $variant->variant_unit }}</span>
                        </div>
                    </td>
                    <td class="col-sticky-3"></td>
                    <td class="col-sticky-4"></td>
                    <td>
                        @if ($variant->actual_stock === 0)
                            <span class="status-out cursor-pointer" onclick="event.stopPropagation(); showStatusPopover(this)"
                                  data-status="out of stock"
                                  data-stock="{{ $variant->actual_stock }}"
                                  data-min-stock="{{ $variant->min_stock }}"
                                  data-daily-sales="{{ $product->daily_sales }}"
                                  data-price="{{ $variant->selling_price }}">
                                <span class="status-dot-figma" style="background-color: #FF4D4D;"></span>
                                <span>Stok Habis</span>
                            </span>
                        @elseif ($variant->enable_stock_alert && $variant->actual_stock <= $variant->min_stock)
                            <span class="status-low cursor-pointer" onclick="event.stopPropagation(); showStatusPopover(this)"
                                  data-status="running low"
                                  data-stock="{{ $variant->actual_stock }}"
                                  data-min-stock="{{ $variant->min_stock }}"
                                  data-daily-sales="{{ $product->daily_sales }}"
                                  data-price="{{ $variant->selling_price }}">
                                <span class="status-dot-figma" style="background-color: #0077FF;"></span>
                                <span>Stok Menipis</span>
                            </span>
                        @else
                            <span class="status-healthy cursor-pointer" onclick="event.stopPropagation(); showStatusPopover(this)"
                                  data-status="healthy"
                                  data-stock="{{ $variant->actual_stock }}"
                                  data-min-stock="{{ $variant->min_stock }}"
                                  data-daily-sales="{{ $product->daily_sales }}"
                                  data-price="{{ $variant->selling_price }}">
                                <span class="status-dot-figma" style="background-color: #10B981;"></span>
                                <span>Sehat</span>
                            </span>
                        @endif
                    </td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        <div class="flex flex-col text-[11px] leading-tight">
                            <span class="font-bold text-gray-700">SKU: {{ $variant->sku }}</span>
                            <span class="text-gray-400">BC: {{ $variant->barcode }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="flex flex-col text-[11px] leading-tight">
                            <span class="text-gray-400">Beli: <span class="text-gray-700 font-semibold">Rp{{ number_format($variant->cost_price, 0, ',', '.') }}</span></span>
                            <span class="text-gray-400">Jual: <span class="text-blue-600 font-bold">Rp{{ number_format($variant->selling_price, 0, ',', '.') }}</span></span>
                        </div>
                    </td>
                    <td class="text-right" onclick="event.stopPropagation()">
                        <input type="text" value="{{ $variant->actual_stock }}" class="w-[90px] h-[34px] text-center border border-black/10 rounded-[6px] font-bold text-black focus:outline-none focus:border-[#0077FF]" />
                    </td>
                    <td style="padding-right: 24px !important; text-align: center;">
                        <button
                            type="button"
                            onclick="showDetailSidebar(this)"
                            data-variant='{!! json_encode($safeVariant, JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_TAG) !!}'
                            data-product='{!! json_encode($safeProduct, JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_TAG) !!}'
                            style="display: inline-flex; align-items: center; gap: 5px; padding: 6px 14px; background-color: #0077FF; color: #fff; border: none; border-radius: 8px; font-size: 11px; font-weight: 700; cursor: pointer; transition: background 0.2s; white-space: nowrap; font-family: 'Plus Jakarta Sans', sans-serif;"
                            onmouseover="this.style.backgroundColor='#0062D1'"
                            onmouseout="this.style.backgroundColor='#0077FF'">
                            <iconify-icon icon="solar:eye-bold" width="13" height="13"></iconify-icon>
                            Detail
                        </button>
                    </td>
                </tr>
                @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer Controls (Figma Style) -->
    <div class="flex items-center justify-end gap-4 mt-6 pt-4 border-t border-black/5">
        <!-- Page counter -->
        <span class="text-[12px] font-semibold text-[#8B8E97]">Menampilkan Halaman 1 dari 3</span>

        <!-- Page buttons -->
        <div class="flex items-center gap-2">
            <!-- Prev Page Button -->
            <button class="w-8 h-8 flex items-center justify-center border border-black/10 rounded-[6px] text-gray-400 bg-white hover:bg-gray-50 transition-all cursor-not-allowed" disabled>
                <iconify-icon icon="solar:alt-arrow-left-linear" width="16" height="16"></iconify-icon>
            </button>

            <!-- Page Number Active -->
            <button class="w-8 h-8 flex items-center justify-center border border-[#0077FF]/20 rounded-[6px] text-[#0077FF] bg-[#0077FF]/5 font-bold text-[13px] transition-all cursor-pointer">
                1
            </button>

            <!-- Next Page Button Active -->
            <button class="w-8 h-8 flex items-center justify-center bg-[#0077FF] rounded-[6px] text-white shadow-sm shadow-[#0077FF]/20 hover:bg-[#0062D1] transition-all cursor-pointer">
                <iconify-icon icon="solar:alt-arrow-right-linear" width="16" height="16"></iconify-icon>
            </button>
        </div>
    </div>
</div>

<!-- Add New Product Modal Backdrop -->
<div id="addProductModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="z-index: 9999; background-color: rgba(0, 0, 0, 0.4); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); display: none; opacity: 0; transition: opacity 0.3s ease;">
    <!-- Modal Container -->
    <div class="bg-white rounded-[24px] shadow-2xl w-full max-w-[800px] relative transform scale-95 opacity-0 transition-all duration-300" id="modalContainer" style="padding: 32px; background-color: #FFFFFF; border-radius: 24px; box-sizing: border-box; max-height: 90vh; display: flex; flex-direction: column; overflow: hidden;">
        <!-- Close Button -->
        <button onclick="closeAddProductModal()" class="w-8 h-8 flex items-center justify-center rounded-full bg-[#F1F3F6] hover:bg-gray-200 transition-all cursor-pointer text-gray-600 hover:text-black border-0" style="position: absolute; top: 32px; right: 32px; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; padding: 0; outline: none; z-index: 10;">
            <iconify-icon icon="material-symbols:close-rounded" width="20" height="20"></iconify-icon>
        </button>

        <!-- Header: Title and Stepper -->
        <div class="flex items-center justify-between mb-4" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; flex-shrink: 0;">
            <div style="display: flex; align-items: center; gap: 24px;">
                <h3 id="modalTitleText" class="text-black" style="font-size: 20px; font-weight: 700; margin: 0; font-family: 'Plus Jakarta Sans', sans-serif;">Tambah Produk Baru</h3>
                <!-- Stepper -->
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div id="stepCircle1" style="width: 24px; height: 24px; border-radius: 50%; background-color: #0077FF; color: #FFFFFF; font-size: 12px; font-weight: 700; display: flex; align-items: center; justify-content: center; transition: all 0.3s;">1</div>
                    <div style="width: 32px; height: 1px; background-color: #E5E7EB;"></div>
                    <div id="stepCircle2" style="width: 24px; height: 24px; border-radius: 50%; background-color: #F1F3F6; color: #8B8E97; font-size: 12px; font-weight: 700; display: flex; align-items: center; justify-content: center; transition: all 0.3s;">2</div>
                    <div style="width: 32px; height: 1px; background-color: #E5E7EB;"></div>
                    <div id="stepCircle3" style="width: 24px; height: 24px; border-radius: 50%; background-color: #F1F3F6; color: #8B8E97; font-size: 12px; font-weight: 700; display: flex; align-items: center; justify-content: center; transition: all 0.3s;">3</div>
                </div>
            </div>
        </div>

        <!-- Progress Indicator Bar -->
        <div style="width: 100%; height: 4px; background-color: #FAFAFA; border-radius: 2px; margin-bottom: 24px; overflow: hidden; position: relative; flex-shrink: 0;">
            <div id="modalProgressBar" style="width: 33%; height: 100%; background-color: #0077FF; border-radius: 2px; transition: all 0.3s;"></div>
        </div>

        <!-- Form Content -->
        <form id="multiStepProductForm" class="premium-scrollbar" onsubmit="event.preventDefault();" style="margin: 0; flex: 1; overflow-y: auto; padding-right: 12px; min-height: 0;">@csrf
            <!-- Step 1: Add New Product Content (General Details) -->
            <div id="step1Content" style="display: flex; flex-direction: column; gap: 24px;">
                <!-- Section 1: Product Details -->
                <div>
                    <h4 style="font-size: 11px; font-weight: 700; color: #8B8E97; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 16px 0; font-family: 'Plus Jakarta Sans', sans-serif;">Detail Produk</h4>
                    <div style="display: flex; gap: 24px;">
                        <!-- Left Inputs -->
                        <div style="flex: 1; display: flex; flex-direction: column; gap: 16px;">
                            <!-- Product Name -->
                            <div style="display: flex; flex-direction: column;">
                                <label style="display: block; font-size: 12px; font-weight: 700; color: #000000; margin-bottom: 6px;">Nama Produk</label>
                                <input type="text" id="productNameInput" oninput="clearFieldError('productNameInput')" placeholder="Nama Produk" style="width: 100%; height: 42px; background-color: #F1F3F6; border: 1px solid transparent; border-radius: 10px; padding: 12px 16px; font-size: 13px; font-weight: 500; color: #000000; outline: none; box-sizing: border-box; transition: all 0.2s;" />
                                <span id="productNameInputError" style="color: #FF4D4D; font-size: 10px; font-weight: 600; display: none; margin-top: 4px; font-family: 'Plus Jakarta Sans', sans-serif;"></span>
                            </div>
                            <!-- Details -->
                            <div style="display: flex; flex-direction: column;">
                                <label style="display: block; font-size: 12px; font-weight: 700; color: #000000; margin-bottom: 6px;">Keterangan</label>
                                <textarea id="productDetailsInput" placeholder="Keterangan" style="width: 100%; height: 80px; background-color: #F1F3F6; border: 1px solid transparent; border-radius: 10px; padding: 12px 16px; font-size: 13px; font-weight: 500; color: #000000; outline: none; resize: none; box-sizing: border-box;"></textarea>
                            </div>
                        </div>
                        <!-- Right Image Upload -->
                        <div style="width: 280px; display: flex; flex-direction: column; justify-content: flex-end;">
                            <input type="file" id="productImageInput" accept="image/*" style="display: none;" onchange="handleImageUpload(event)">
                            <div id="imageUploadContainer" onclick="triggerImageUpload()" style="border: 1px dashed rgba(0, 0, 0, 0.1); border-radius: 12px; height: 140px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px; background-color: #FFFFFF; padding: 16px; box-sizing: border-box; cursor: pointer; position: relative; overflow: hidden; transition: all 0.2s;">
                                <div id="uploadPlaceholder" style="display: flex; flex-direction: column; align-items: center; gap: 10px; text-align: center;">
                                    <iconify-icon icon="solar:camera-add-linear" width="24" height="24" style="color: #8B8E97;"></iconify-icon>
                                    <span style="font-size: 11px; font-weight: 600; color: #8B8E97; line-height: 1.4;">Pilih Foto dari<br>Komputer</span>
                                    <button type="button" class="transition-all" style="background-color: #000000; color: #FFFFFF; font-size: 12px; font-weight: 700; padding: 6px 20px; border: none; border-radius: 100px; outline: none; pointer-events: none;">Jelajahi</button>
                                </div>
                                <div id="imagePreviewContainer" style="display: none; width: 100%; height: 100%; position: absolute; top: 0; left: 0;">
                                    <img id="imagePreview" src="" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; object-position: center;" />
                                    <!-- Hover overlay to change photo -->
                                    <div id="imageHoverOverlay" style="position: absolute; inset: 0; background: rgba(0,0,0,0.4); display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.2s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0'">
                                        <span style="color: #FFFFFF; font-size: 11px; font-weight: 700; background: rgba(0,0,0,0.6); padding: 6px 14px; border-radius: 100px;">Ganti Foto</span>
                                    </div>
                                </div>
                            </div>
                            <span id="productImageInputError" style="color: #FF4D4D; font-size: 10px; font-weight: 600; display: none; margin-top: 4px; font-family: 'Plus Jakarta Sans', sans-serif;"></span>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Category -->
                <div style="display: flex; gap: 24px;">
                    <!-- Category -->
                    <div style="flex: 1; display: flex; flex-direction: column;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
                            <label style="font-size: 12px; font-weight: 700; color: #000000;">Kategori</label>
                            <button type="button" onclick="addCategory()" class="cursor-pointer" style="background: none; border: none; color: #1053D5; font-size: 11px; font-weight: 700; padding: 0; outline: none;">+ Tambah Kategori</button>
                        </div>
                        <select id="productCategorySelect" onchange="clearFieldError('productCategorySelect')" style="width: 100%; height: 42px; padding: 0 16px; background-color: #F1F3F6; border: 1px solid transparent; border-radius: 10px; font-size: 13px; font-weight: 500; color: #000000; outline: none; box-sizing: border-box; appearance: none; -webkit-appearance: none; background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2216%22 height=%2216%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%238B8E97%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><path d=%22m6 9 6 6 6-6%22/></svg>'); background-repeat: no-repeat; background-position: right 16px center; cursor: pointer; transition: all 0.2s;">
                            <option value="" disabled selected style="color: #8B8E97;">Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <span id="productCategorySelectError" style="color: #FF4D4D; font-size: 10px; font-weight: 600; display: none; margin-top: 4px; font-family: 'Plus Jakarta Sans', sans-serif;"></span>
                    </div>
                </div>

                <script>
                    // Tambah kategori baru milik user yang sedang login.
                    async function addCategory() {
                        const name = window.prompt('Nama kategori baru:');
                        if (name === null) return; // dibatalkan
                        const trimmed = name.trim();
                        if (!trimmed) return;

                        const token = document.querySelector('input[name="_token"]')?.value || '';
                        try {
                            const res = await fetch('{{ route('categories.store') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': token,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({ name: trimmed })
                            });
                            const data = await res.json();

                            if (!res.ok) {
                                const msg = data?.errors?.name?.[0] || data?.message || 'Gagal menambah kategori.';
                                alert(msg);
                                return;
                            }

                            // Tambahkan ke dropdown lalu pilih otomatis.
                            const select = document.getElementById('productCategorySelect');
                            const option = document.createElement('option');
                            option.value = data.category.id;
                            option.textContent = data.category.name;
                            select.appendChild(option);
                            select.value = data.category.id;
                            clearFieldError('productCategorySelect');
                        } catch (e) {
                            console.error('Gagal menambah kategori:', e);
                            alert('Tidak dapat terhubung ke server.');
                        }
                    }
                </script>

                <!-- Footer: Add Price Button -->
                <div style="display: flex; justify-content: flex-end; margin-top: 16px;">
                    <button type="button" onclick="handleStep1Next()" class="transition-all cursor-pointer" style="background-color: #000000; color: #FFFFFF; font-size: 13px; font-weight: 700; padding: 12px 32px; border: none; border-radius: 100px; display: flex; align-items: center; gap: 8px; outline: none; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                        <span>Konfigurasi Varian</span>
                        <iconify-icon icon="solar:alt-arrow-right-linear" width="16" height="16" style="margin-top: 1px;"></iconify-icon>
                    </button>
                </div>
            </div>

            <!-- Step 2: Product Variants Builder -->
            <div id="step2Content" style="display: none; flex-direction: column; gap: 20px;">
                <!-- Section: Variant Input Area -->
                <div style="background-color: #F8FAFC; border: 1px solid rgba(0,0,0,0.05); border-radius: 16px; padding: 20px; display: flex; flex-direction: column; gap: 16px;">
                    <h4 style="font-size: 12px; font-weight: 700; color: #000000; margin: 0; font-family: 'Plus Jakarta Sans', sans-serif;">Tambah Detail Varian Baru</h4>
                    
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
                        <!-- Variant Name -->
                        <div style="display: flex; flex-direction: column;">
                            <label style="font-size: 11px; font-weight: 700; color: #000000; margin-bottom: 6px;">Nama Varian (cth. Rasa Coklat, 1kg)</label>
                            <input type="text" id="varNameInput" placeholder="Nama" style="height: 38px; background-color: #FFFFFF; border: 1px solid rgba(0,0,0,0.1); border-radius: 8px; padding: 0 12px; font-size: 12px; outline: none;" />
                        </div>
                        <!-- Unit -->
                        <div style="display: flex; flex-direction: column;">
                            <label style="font-size: 11px; font-weight: 700; color: #000000; margin-bottom: 6px;">Satuan</label>
                            <select id="varUnitSelect" style="height: 38px; background-color: #FFFFFF; border: 1px solid rgba(0,0,0,0.1); border-radius: 8px; padding: 0 12px; font-size: 12px; outline: none; appearance: none; -webkit-appearance: none; background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2214%22 height=%2214%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%238B8E97%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><path d=%22m6 9 6 6 6-6%22/></svg>'); background-repeat: no-repeat; background-position: right 10px center;">
                                <option value="Box">Box</option>
                                <option value="Pcs" selected>Pcs</option>
                                <option value="Packs">Pack</option>
                                <option value="Sacks">Sack</option>
                            </select>
                        </div>
                        <!-- SKU -->
                        <div style="display: flex; flex-direction: column;">
                            <label style="font-size: 11px; font-weight: 700; color: #000000; margin-bottom: 6px;">SKU (Otomatis jika kosong)</label>
                            <input type="text" id="varSkuInput" placeholder="Kode SKU" style="height: 38px; background-color: #FFFFFF; border: 1px solid rgba(0,0,0,0.1); border-radius: 8px; padding: 0 12px; font-size: 12px; outline: none;" />
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
                        <!-- Initial Stock -->
                        <div style="display: flex; flex-direction: column;">
                            <label style="font-size: 11px; font-weight: 700; color: #000000; margin-bottom: 6px;">Stok Awal</label>
                            <input type="number" id="varStockInput" placeholder="0" style="height: 38px; background-color: #FFFFFF; border: 1px solid rgba(0,0,0,0.1); border-radius: 8px; padding: 0 12px; font-size: 12px; outline: none;" />
                        </div>
                        <!-- Expired Date -->
                        <div style="display: flex; flex-direction: column;">
                            <label style="font-size: 11px; font-weight: 700; color: #000000; margin-bottom: 6px;">Tanggal Kedaluwarsa</label>
                            <input type="date" id="varExpiredInput" style="height: 38px; background-color: #FFFFFF; border: 1px solid rgba(0,0,0,0.1); border-radius: 8px; padding: 0 12px; font-size: 12px; outline: none;" />
                        </div>
                        <!-- Cost Price -->
                        <div style="display: flex; flex-direction: column;">
                            <label style="font-size: 11px; font-weight: 700; color: #000000; margin-bottom: 6px;">Harga Beli (Rp)</label>
                            <input type="number" id="varCostPriceInput" oninput="varCalculateSellingPrice()" placeholder="Harga Beli" style="height: 38px; background-color: #FFFFFF; border: 1px solid rgba(0,0,0,0.1); border-radius: 8px; padding: 0 12px; font-size: 12px; outline: none;" />
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
                        <!-- Selling Price -->
                        <div style="display: flex; flex-direction: column;">
                            <label style="font-size: 11px; font-weight: 700; color: #000000; margin-bottom: 6px;">Harga Jual (Rp)</label>
                            <input type="number" id="varSellingPriceInput" oninput="varCalculateMargin()" placeholder="Harga Jual" style="height: 38px; background-color: #FFFFFF; border: 1px solid rgba(0,0,0,0.1); border-radius: 8px; padding: 0 12px; font-size: 12px; outline: none;" />
                        </div>
                        <!-- Margin -->
                        <div style="display: flex; flex-direction: column;">
                            <label style="font-size: 11px; font-weight: 700; color: #000000; margin-bottom: 6px;">Margin (%)</label>
                            <input type="number" id="varMarginInput" oninput="varCalculateSellingPrice()" placeholder="Margin %" style="height: 38px; background-color: #FFFFFF; border: 1px solid rgba(0,0,0,0.1); border-radius: 8px; padding: 0 12px; font-size: 12px; outline: none;" />
                        </div>
                        <!-- Barcode -->
                        <div style="display: flex; flex-direction: column;">
                            <label style="font-size: 11px; font-weight: 700; color: #000000; margin-bottom: 6px;">Kode Batang (Dibuat dari SKU)</label>
                            <input type="text" id="varBarcodeInput" readonly placeholder="Buat kode batang dari SKU" style="height: 38px; background-color: #F1F3F6; cursor: not-allowed; border: 1px solid rgba(0,0,0,0.1); border-radius: 8px; padding: 0 12px; font-size: 12px; outline: none;" />
                        </div>
                    </div>

                    <!-- Min Stock & Alert Toggle -->
                    <div style="display: flex; gap: 24px; align-items: center;">
                        <div style="flex: 1; display: flex; flex-direction: column;">
                            <label style="font-size: 11px; font-weight: 700; color: #000000; margin-bottom: 6px;">Peringatan Stok Minimum</label>
                            <input type="number" id="varMinStockInput" placeholder="Min" style="height: 38px; background-color: #FFFFFF; border: 1px solid rgba(0,0,0,0.1); border-radius: 8px; padding: 0 12px; font-size: 12px; outline: none;" />
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px; margin-top: 18px;">
                            <input type="checkbox" id="varAlertToggle" checked style="width: 16px; height: 16px;" />
                            <label for="varAlertToggle" style="font-size: 11px; font-weight: 700; color: #000000; cursor: pointer;">Aktifkan Peringatan</label>
                        </div>
                    </div>

                    <!-- Section: Vern AI Price Optimization -->
                    <div style="display: flex; gap: 24px; margin-top: 8px;">
                        <!-- Left AI Recommendation Box -->
                        <div style="flex: 1; border: 1px solid rgba(0, 0, 0, 0.08); border-radius: 12px; padding: 20px; background-color: #FFFFFF; display: flex; flex-direction: column; justify-content: space-between; min-height: 125px; box-sizing: border-box;">
                            <div style="display: flex; flex-direction: column; gap: 6px;">
                                <span style="font-size: 13px; font-weight: 700; color: #000000; margin: 0; font-family: 'Plus Jakarta Sans', sans-serif;">Vern AI Price Optimization</span>
                                <p style="font-size: 11px; color: #8B8E97; line-height: 1.4; font-weight: 500; margin: 0;">Dapatkan rekomendasi harga berbasis AI berdasarkan biaya, permintaan, dan tren pasar untuk memaksimalkan keuntungan Anda.</p>
                            </div>
                            <button type="button" onclick="runAiOptimization()" class="transition-all cursor-pointer" style="background-color: #000000; color: #FFFFFF; font-size: 12px; font-weight: 700; padding: 8px 24px; border: none; border-radius: 100px; outline: none; align-self: flex-start;">Buat Harga Optimal</button>
                        </div>
                        <!-- Right AI Recommendation Box -->
                        <div style="width: 280px; border: 1px solid rgba(0, 0, 0, 0.08); border-radius: 12px; padding: 20px; background-color: #FFFFFF; display: flex; flex-direction: column; justify-content: space-between; min-height: 125px; box-sizing: border-box;">
                            <div style="display: flex; flex-direction: column; gap: 12px;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-size: 11px; font-weight: 700; color: #8B8E97; text-transform: uppercase;">Harga Optimal AI</span>
                                    <span id="aiDemandBadge" style="display: none; background-color: #E8F0FE; color: #1D38FF; font-size: 9px; font-weight: 700; padding: 2px 8px; border-radius: 100px;">Permintaan Tinggi</span>
                                </div>
                                <div style="display: flex; align-items: baseline; gap: 6px;">
                                    <span id="valRecomPrice" style="font-size: 20px; font-weight: 800; color: #000000; font-family: 'Plus Jakarta Sans', sans-serif;">---</span>
                                    <span id="valRecomMargin" style="font-size: 12px; font-weight: 700; color: #10B981;">---</span>
                                </div>
                            </div>
                            <button id="applyRecomPriceBtn" type="button" onclick="applyRecommendation()" class="transition-all cursor-pointer" style="display: none; background-color: #0077FF; color: #FFFFFF; font-size: 11px; font-weight: 700; padding: 6px 16px; border: none; border-radius: 100px; outline: none; align-self: flex-start;">Terapkan Rekomendasi</button>
                        </div>
                    </div>

                    <!-- Section: Generate Barcode -->
                    <div style="display: flex; gap: 24px; align-items: flex-end; margin-top: 8px;">
                        <!-- Generate Barcode Box -->
                        <div style="flex: 1;">
                            <label style="display: block; font-size: 11px; font-weight: 700; color: #000000; margin-bottom: 6px;">Pembuat Kode Batang</label>
                            <div id="barcodeContainer" style="background-color: #FFFFFF; border: 1px solid rgba(0,0,0,0.1); border-radius: 12px; padding: 14px; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 90px; box-sizing: border-box; transition: all 0.2s; position: relative;">
                                <!-- Before generation -->
                                <div id="barcodeBeforeGen" style="display: flex; flex-direction: column; justify-content: space-between; height: 60px; width: 100%;">
                                    <span style="font-size: 10px; font-weight: 700; color: #8B8E97; text-transform: uppercase; letter-spacing: 0.05em; margin: 0;">Buat kode batang dari SKU</span>
                                    <button onclick="generateBarcode()" type="button" class="transition-all cursor-pointer" style="background-color: #000000; color: #FFFFFF; font-size: 11px; font-weight: 700; padding: 6px 16px; border: none; border-radius: 100px; outline: none; align-self: flex-start;">Buat</button>
                                </div>
                                
                                <!-- After generation -->
                                <div id="barcodeAfterGen" style="display: none; flex-direction: column; align-items: center; justify-content: center; width: 100%; position: relative;">
                                    <div id="barcodeSvgWrapper" style="width: 100%; display: flex; justify-content: center; background: transparent; position: relative; padding: 2px 0;">
                                        <svg id="barcodeSvg" style="opacity: 0;"></svg>
                                        <!-- Laser scan overlay line -->
                                        <div id="barcodeLaser" style="position: absolute; left: 10%; right: 10%; height: 2px; background-color: #EF4444; box-shadow: 0 0 8px #EF4444; display: none; pointer-events: none; opacity: 0;"></div>
                                    </div>
                                    <button onclick="generateBarcode(true)" type="button" style="background: transparent; border: none; color: #0077FF; font-size: 10px; font-weight: 700; cursor: pointer; text-decoration: underline; padding: 0; outline: none; margin-top: 4px;">Buat Ulang</button>
                                </div>
                            </div>
                        </div>
                        <!-- Barcode Usecase Card -->
                        <div style="width: 280px;">
                            <div style="border: 1px solid rgba(0, 0, 0, 0.08); border-radius: 12px; padding: 16px; background-color: #FFFFFF; height: 90px; display: flex; flex-direction: column; justify-content: center; gap: 4px; box-sizing: border-box;">
                                <span style="font-size: 11px; font-weight: 700; color: #000000; margin: 0;">Kegunaan Kode Batang</span>
                                <p style="font-size: 10px; color: #8B8E97; font-weight: 500; margin: 0; line-height: 1.3;">Kode batang yang dihasilkan dapat dicetak dan digunakan sebagai pengenal produk untuk transaksi dan pemantauan stok.</p>
                            </div>
                        </div>
                    </div>

                    <button type="button" onclick="addVariantToList()" style="align-self: flex-end; background-color: #0077FF; color: #FFFFFF; font-size: 12px; font-weight: 700; padding: 10px 24px; border: none; border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                        + Tambah Varian ke Produk
                    </button>
                    <span id="variantBuilderError" style="color: #FF4D4D; font-size: 11px; font-weight: 600; display: none;"></span>
                </div>

                <!-- Section: Variant Table List -->
                <div style="flex: 1; max-height: 180px; overflow-y: auto; border: 1px solid rgba(0,0,0,0.08); border-radius: 12px;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 11px;">
                        <thead>
                            <tr style="background-color: #F1F3F6; border-bottom: 1px solid rgba(0,0,0,0.05); font-weight: 700;">
                                <th style="padding: 10px;">Nama Varian</th>
                                <th style="padding: 10px;">SKU / BC</th>
                                <th style="padding: 10px;">Stok / Peringatan</th>
                                <th style="padding: 10px;">Beli / Jual</th>
                                <th style="padding: 10px; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="variantsListTableBody">
                            <tr>
                                <td colspan="5" style="padding: 20px; text-align: center; color: #8B8E97; font-weight: 600;">Belum ada varian yang ditambahkan. Silakan isi form dan tambahkan varian.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Footer Buttons -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 12px;">
                    <!-- Back Button -->
                    <button type="button" onclick="goToStep(1)" class="transition-all cursor-pointer" style="background-color: transparent; border: 1px solid rgba(0,0,0,0.1); color: #8B8E97; font-size: 13px; font-weight: 700; padding: 12px 32px; border-radius: 100px; display: flex; align-items: center; gap: 8px; outline: none;">
                        <iconify-icon icon="solar:alt-arrow-left-linear" width="16" height="16"></iconify-icon>
                        <span>Kembali</span>
                    </button>
                    <!-- Submit / Save Button -->
                    <button type="button" onclick="handleStep2Submit()" class="transition-all cursor-pointer" style="background-color: #000000; color: #FFFFFF; font-size: 13px; font-weight: 700; padding: 12px 32px; border: none; border-radius: 100px; display: flex; align-items: center; gap: 8px; outline: none; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                        <span>Simpan Produk & Varian</span>
                    </button>
                </div>
            </div>

            <!-- Success Content Page -->
            <div id="successContent" style="display: none; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 32px 0 16px 0; gap: 24px;">
                <!-- Illustrated Checkmark & Sparks -->
                <div style="position: relative; display: flex; align-items: center; justify-content: center; width: 120px; height: 120px;">
                    <!-- Document Icon Background -->
                    <div style="position: absolute; left: 16px; top: 24px; opacity: 0.15;">
                        <iconify-icon icon="solar:document-bold" width="60" height="60" style="color: #0077FF;"></iconify-icon>
                    </div>
                    <!-- Check Circle -->
                    <iconify-icon icon="solar:check-circle-bold" width="80" height="80" style="color: #0077FF; z-index: 2;"></iconify-icon>
                    <!-- Confetti sparkles -->
                    <iconify-icon icon="twemoji:confetti-ball" width="32" height="32" style="position: absolute; right: 0; top: 12px;"></iconify-icon>
                    <iconify-icon icon="noto:sparkles" width="24" height="24" style="position: absolute; left: 8px; bottom: 20px;"></iconify-icon>
                </div>

                <!-- Text information -->
                <div style="display: flex; flex-direction: column; gap: 8px; max-width: 320px;">
                    <h4 style="font-size: 16px; font-weight: 700; color: #000000; margin: 0; line-height: 1.4; font-family: 'Plus Jakarta Sans', sans-serif;">Produk berhasil ditambahkan!</h4>
                    <p style="font-size: 12px; color: #8B8E97; font-weight: 500; margin: 0; line-height: 1.4;">Produk dan variannya telah disimpan ke dalam gudang.</p>
                </div>

                <!-- See Product Button -->
                <button type="button" onclick="closeAddProductModal()" class="transition-all cursor-pointer" style="background-color: #000000; color: #FFFFFF; font-size: 13px; font-weight: 700; padding: 12px 36px; border: none; border-radius: 100px; outline: none; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    Lihat Produk
                </button>
            </div>
        </form>

    </div>
</div>

<script>
    window.onerror = function(message, source, lineno, colno, error) {
        console.error("Global JS Error: " + message + " at " + source + ":" + lineno);
        return false;
    };

    let currentStep = 1;
    let isSkuManuallyEdited = false;


    // Add styles dynamically for tooltips
    if (!document.getElementById('tooltipStyles')) {
        const style = document.createElement('style');
        style.id = 'tooltipStyles';
        style.innerHTML = `
            .tooltip-container:hover .tooltip-box {
                opacity: 1 !important;
                pointer-events: auto !important;
            }
        `;
        document.head.appendChild(style);
    }

    function toggleAlertState() {
        const checkbox = document.getElementById('stockAlertToggle');
        const pill = document.getElementById('togglePill');
        const knob = document.getElementById('toggleKnob');
        if (checkbox.checked) {
            pill.style.backgroundColor = '#0077FF';
            knob.style.left = '22px';
        } else {
            pill.style.backgroundColor = '#E5E7EB';
            knob.style.left = '2px';
        }
    }



    let recommendedSellingPrice = 0;
    let recommendedMarginVal = 0;

    function runAiOptimization() {
        const costInput = document.getElementById('varCostPriceInput');
        const costVal = parseFloat(costInput.value.trim());

        if (isNaN(costVal) || costVal <= 0) {
            costInput.classList.add('input-error-state');
            costInput.focus();
            return;
        }

        costInput.classList.remove('input-error-state');

        const recomPrice = document.getElementById('valRecomPrice');
        const recomMargin = document.getElementById('valRecomMargin');
        const demandBadge = document.getElementById('aiDemandBadge');
        const applyBtn = document.getElementById('applyRecomPriceBtn');

        recomPrice.textContent = "Memperkirakan...";
        recomMargin.textContent = "Memperkirakan...";
        applyBtn.style.display = 'none';

        setTimeout(() => {
            // Assume 25% margin recommendation
            recommendedMarginVal = 25;
            recommendedSellingPrice = Math.round((costVal * 1.25) / 100) * 100;

            recomPrice.textContent = "Rp " + recommendedSellingPrice.toLocaleString('id-ID');
            recomMargin.textContent = recommendedMarginVal + "%";
            demandBadge.style.display = 'block';
            applyBtn.style.display = 'block';
        }, 800);
    }

    function applyRecommendation() {
        document.getElementById('varSellingPriceInput').value = recommendedSellingPrice;
        document.getElementById('varMarginInput').value = recommendedMarginVal;
    }

    function resetPriceRecommendation() {
        const valRecomPrice = document.getElementById('valRecomPrice');
        const valRecomMargin = document.getElementById('valRecomMargin');
        const aiDemandBadge = document.getElementById('aiDemandBadge');
        const applyRecomPriceBtn = document.getElementById('applyRecomPriceBtn');

        if (valRecomPrice) valRecomPrice.textContent = "---";
        if (valRecomMargin) valRecomMargin.textContent = "---";
        if (aiDemandBadge) aiDemandBadge.style.display = 'none';
        if (applyRecomPriceBtn) applyRecomPriceBtn.style.display = 'none';
        
        const costInput = document.getElementById('varCostPriceInput');
        if (costInput) costInput.classList.remove('input-error-state');
    }

    function triggerImageUpload() {
        document.getElementById('productImageInput').click();
    }

    function handleImageUpload(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('uploadPlaceholder').style.display = 'none';
                document.getElementById('imagePreviewContainer').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }

    function resetImageUpload() {
        document.getElementById('productImageInput').value = '';
        document.getElementById('imagePreview').src = '';
        document.getElementById('uploadPlaceholder').style.display = 'flex';
        document.getElementById('imagePreviewContainer').style.display = 'none';
    }

    function openAddProductModal() {
        // Restore initial modal size and state
        document.getElementById('modalContainer').style.maxWidth = '800px';
        const stepperHeader = document.querySelector('#modalContainer > div:nth-child(2)');
        const progressBar = document.querySelector('#modalContainer > div:nth-child(3)');
        if (stepperHeader) stepperHeader.style.display = 'flex';
        if (progressBar) progressBar.style.display = 'block';

        goToStep(1);
        resetImageUpload();
        resetPriceRecommendation();
        isSkuManuallyEdited = false;
        window.currentVariantSkuRandCode = null;

        const modal = document.getElementById('addProductModal');
        const container = document.getElementById('modalContainer');
        modal.style.display = 'flex';
        // Force reflow
        modal.offsetHeight;
        modal.style.opacity = '1';
        setTimeout(() => {
            container.classList.remove('scale-95', 'opacity-0');
            container.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeAddProductModal() {
        const modal = document.getElementById('addProductModal');
        const container = document.getElementById('modalContainer');
        container.classList.remove('scale-100', 'opacity-100');
        container.classList.add('scale-95', 'opacity-0');
        modal.style.opacity = '0';
        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
    }

    function toggleVariants(productId) {
        const rows = document.querySelectorAll('.variant-row-' + productId);
        const arrow = document.getElementById('arrow-icon-' + productId);
        
        let isOpen = false;
        rows.forEach(row => {
            if (row.style.display === 'none') {
                row.style.display = 'table-row';
                isOpen = true;
            } else {
                row.style.display = 'none';
            }
        });

        if (arrow) {
            if (isOpen) {
                arrow.style.transform = 'rotate(90deg)';
            } else {
                arrow.style.transform = 'rotate(0deg)';
            }
        }
    }

    // Close on backdrop click
    document.getElementById('addProductModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeAddProductModal();
        }
    });

    // Helper to generate SKU suggestions based on product name - variant name - random code
    function generateSkuSuggestion() {
        if (isSkuManuallyEdited) return;
        const productName = document.getElementById('productNameInput').value.trim();
        const variantName = document.getElementById('varNameInput').value.trim();

        if (!productName && !variantName) {
            document.getElementById('varSkuInput').value = '';
            return;
        }

        // Clean & slugify: replace non-alphanumeric chars with hyphen, uppercase
        const cleanProduct = productName.toUpperCase().replace(/[^A-Z0-9]+/g, '-').replace(/^-+|-+$/g, '');
        const cleanVariant = variantName.toUpperCase().replace(/[^A-Z0-9]+/g, '-').replace(/^-+|-+$/g, '');

        if (!window.currentVariantSkuRandCode) {
            window.currentVariantSkuRandCode = Math.floor(1000 + Math.random() * 9000);
        }

        let suggestion = '';
        if (cleanProduct && cleanVariant) {
            suggestion = `${cleanProduct}-${cleanVariant}-${window.currentVariantSkuRandCode}`;
        } else if (cleanProduct) {
            suggestion = `${cleanProduct}-${window.currentVariantSkuRandCode}`;
        } else if (cleanVariant) {
            suggestion = `${cleanVariant}-${window.currentVariantSkuRandCode}`;
        }

        document.getElementById('varSkuInput').value = suggestion;
    }

    // Attach SKU Auto-suggestion Event Listeners
    document.getElementById('productNameInput').addEventListener('input', generateSkuSuggestion);
    document.getElementById('varNameInput').addEventListener('input', generateSkuSuggestion);
    document.getElementById('varSkuInput').addEventListener('input', function() {
        isSkuManuallyEdited = this.value.trim().length > 0;
    });


    // Barcode Generator Functions
    function generateBarcode(forceNew = false) {
        if (typeof JsBarcode === 'undefined') {
            const script = document.createElement('script');
            script.src = "https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js";
            script.onload = function() {
                runBarcodeGeneration(forceNew);
            };
            document.head.appendChild(script);
        } else {
            runBarcodeGeneration(forceNew);
        }
    }

    async function runBarcodeGeneration(forceNew = false) {
        const skuInput = document.getElementById('varSkuInput');
        const errorSpan = document.getElementById('variantBuilderError');
        errorSpan.style.display = 'none';

        if (forceNew) {
            skuInput.value = '';
        }
        let skuValue = skuInput.value.trim();

        const beforeGenBtn = document.querySelector('#barcodeBeforeGen button');
        const regenBtn = document.querySelector('#barcodeAfterGen button');
        const originalBtnText = beforeGenBtn ? beforeGenBtn.textContent : 'Generate';

        if (beforeGenBtn) beforeGenBtn.disabled = true;
        if (regenBtn) regenBtn.disabled = true;

        if (!skuValue) {
            let uniqueFound = false;
            let attempts = 0;
            const maxAttempts = 10;

            while (!uniqueFound && attempts < maxAttempts) {
                const randomNum = Math.floor(10000000 + Math.random() * 90000000);
                const testSku = "VERN-" + randomNum;
                attempts++;

                // Check local variants list
                const localExists = productVariants.some(v => v.sku.toLowerCase() === testSku.toLowerCase());
                if (localExists) continue;

                // Check database
                try {
                    const res = await fetch(`/products/check-sku?sku=${encodeURIComponent(testSku)}`);
                    const data = await res.json();
                    if (!data.exists) {
                        skuValue = testSku;
                        uniqueFound = true;
                    }
                } catch (err) {
                    console.error('SKU validation error during generation:', err);
                    skuValue = testSku;
                    uniqueFound = true;
                }
            }

            if (!skuValue) {
                errorSpan.textContent = 'Tidak dapat membuat SKU unik setelah beberapa percobaan. Silakan masukkan secara manual.';
                errorSpan.style.display = 'block';
                if (beforeGenBtn) beforeGenBtn.disabled = false;
                if (regenBtn) regenBtn.disabled = false;
                return;
            }
            skuInput.value = skuValue;
        } else {
            // Check manual SKU uniqueness
            const localExists = productVariants.some(v => v.sku.toLowerCase() === skuValue.toLowerCase());
            if (localExists) {
                errorSpan.textContent = `SKU "${skuValue}" sudah ditambahkan ke daftar di bawah.`;
                errorSpan.style.display = 'block';
                skuInput.focus();
                if (beforeGenBtn) beforeGenBtn.disabled = false;
                if (regenBtn) regenBtn.disabled = false;
                return;
            }

            try {
                const res = await fetch(`/products/check-sku?sku=${encodeURIComponent(skuValue)}`);
                const data = await res.json();
                if (data.exists) {
                    errorSpan.textContent = `SKU "${skuValue}" sudah ada di database. Silakan gunakan SKU yang unik.`;
                    errorSpan.style.display = 'block';
                    skuInput.focus();
                    if (beforeGenBtn) beforeGenBtn.disabled = false;
                    if (regenBtn) regenBtn.disabled = false;
                    return;
                }
            } catch (err) {
                console.error(err);
            }
        }

        // Generate distinct unique barcode (e.g. 12-digit number starting with 880)
        let barcodeValue = '';
        let barcodeUnique = false;
        let barcodeAttempts = 0;
        const maxBarcodeAttempts = 20;

        while (!barcodeUnique && barcodeAttempts < maxBarcodeAttempts) {
            const randomNum = Math.floor(100000000 + Math.random() * 900000000); // 9 digits
            const testBarcode = "880" + randomNum;
            barcodeAttempts++;

            // Local check
            const localBcExists = productVariants.some(v => v.barcode === testBarcode);
            if (localBcExists) continue;

            // Database check
            try {
                const res = await fetch(`/products/check-sku?barcode=${encodeURIComponent(testBarcode)}`);
                const data = await res.json();
                if (!data.exists) {
                    barcodeValue = testBarcode;
                    barcodeUnique = true;
                }
            } catch (err) {
                console.error('Barcode validation check failed:', err);
                barcodeValue = testBarcode;
                barcodeUnique = true;
            }
        }

        if (!barcodeValue) {
            errorSpan.textContent = 'Could not generate a unique barcode. Please try again.';
            errorSpan.style.display = 'block';
            if (beforeGenBtn) beforeGenBtn.disabled = false;
            if (regenBtn) regenBtn.disabled = false;
            return;
        }

        if (beforeGenBtn) beforeGenBtn.disabled = false;
        if (regenBtn) regenBtn.disabled = false;

        // Auto-populate barcode input field
        const barcodeInput = document.getElementById('varBarcodeInput');
        if (barcodeInput) {
            barcodeInput.value = barcodeValue;
        }

        // Toggle layout states
        document.getElementById('barcodeBeforeGen').style.display = 'none';
        document.getElementById('barcodeAfterGen').style.display = 'flex';
        
        const wrapper = document.getElementById('barcodeSvgWrapper');
        const svg = document.getElementById('barcodeSvg');
        // Reset classes for re-animation
        svg.classList.remove('barcode-animated');
        svg.style.opacity = '0';

        const laser = document.getElementById('barcodeLaser');
        laser.classList.remove('laser-scanning');
        laser.style.display = 'none';

        try {
            // Generate barcode with optimal spacing
            JsBarcode("#barcodeSvg", barcodeValue, {
                format: "CODE128",
                width: 1.4,
                height: 32,
                displayValue: true,
                fontSize: 10,
                background: "transparent",
                lineColor: "#000000",
                marginTop: 2,
                marginBottom: 2
            });

            // Trigger scanner line and fade-in animations
            setTimeout(() => {
                laser.classList.add('laser-scanning');
                svg.classList.add('barcode-animated');
            }, 50);

        } catch (e) {
            console.error("Barcode generation failed:", e);
        }
    }

    function resetBarcodeState() {
        const before = document.getElementById('barcodeBeforeGen');
        const after = document.getElementById('barcodeAfterGen');
        if (before) before.style.display = 'flex';
        if (after) after.style.display = 'none';
        const svg = document.getElementById('barcodeSvg');
        if (svg) svg.innerHTML = '';
    }

    // Validation Helper Functions
    function showFieldError(inputId, errorText) {
        const inputEl = document.getElementById(inputId);
        if (!inputEl) return;
        
        let container = inputEl;
        if (inputId === 'barcodeContainer') {
            container = document.getElementById('barcodeContainer');
        } else if (inputId === 'costPriceInput' || inputId === 'sellingPriceInput' || inputId === 'marginInput' || inputId === 'minStockInput' || inputId === 'reorderPointInput') {
            container = document.getElementById(inputId + 'Container') || inputEl;
        } else if (inputEl.closest('div[style*="background-color"]') && inputId !== 'productNameInput' && inputId !== 'variantNameInput') {
            container = inputEl.closest('div[style*="background-color"]');
        }
        
        container.classList.add('input-error-state');
        
        let errSpan = document.getElementById(inputId + 'Error');
        if (!errSpan) {
            errSpan = document.createElement('span');
            errSpan.id = inputId + 'Error';
            errSpan.className = 'error-message-text';
            container.parentNode.appendChild(errSpan);
        }
        errSpan.textContent = errorText;
        errSpan.style.display = 'block';
    }

    function clearFieldError(inputId) {
        const inputEl = document.getElementById(inputId);
        let container = inputEl;
        if (inputId === 'barcodeContainer') {
            container = document.getElementById('barcodeContainer');
        } else if (inputId === 'costPriceInput' || inputId === 'sellingPriceInput' || inputId === 'marginInput' || inputId === 'minStockInput' || inputId === 'reorderPointInput') {
            container = document.getElementById(inputId + 'Container') || inputEl;
        } else if (inputEl && inputEl.closest('div[style*="background-color"]') && inputId !== 'productNameInput' && inputId !== 'variantNameInput') {
            container = inputEl.closest('div[style*="background-color"]');
        }
        
        if (container) {
            container.classList.remove('input-error-state');
        }
        
        const errSpan = document.getElementById(inputId + 'Error');
        if (errSpan) {
            errSpan.style.display = 'none';
        }
    }

    // Step-specific validations
    function validateStep1() {
        let isValid = true;

        // Product Name
        const nameVal = document.getElementById('productNameInput').value.trim();
        if (nameVal.length < 3) {
            showFieldError('productNameInput', 'Nama produk wajib diisi (minimal 3 karakter).');
            isValid = false;
        } else {
            clearFieldError('productNameInput');
        }

        // Category
        const categoryVal = document.getElementById('productCategorySelect').value;
        if (!categoryVal) {
            showFieldError('productCategorySelect', 'Silakan pilih kategori produk.');
            isValid = false;
        } else {
            clearFieldError('productCategorySelect');
        }

        // Variant Name
        const variantNameVal = document.getElementById('variantNameInput').value.trim();
        if (!variantNameVal) {
            showFieldError('variantNameInput', 'Nama varian produk wajib diisi.');
            isValid = false;
        } else {
            clearFieldError('variantNameInput');
        }

        // Variant Unit
        const variantUnitVal = document.getElementById('variantUnitSelect').value;
        if (!variantUnitVal) {
            showFieldError('variantUnitSelect', 'Silakan pilih satuan unit varian.');
            isValid = false;
        } else {
            clearFieldError('variantUnitSelect');
        }

        // SKU
        const skuVal = document.getElementById('skuInput').value.trim();
        if (!skuVal) {
            showFieldError('skuInput', 'SKU wajib diisi.');
            isValid = false;
        } else {
            clearFieldError('skuInput');
        }

        // Initial Stock
        const stockVal = document.getElementById('initialStockInput').value.trim();
        if (stockVal === '' || isNaN(parseInt(stockVal)) || parseInt(stockVal) < 0) {
            showFieldError('initialStockInput', 'Stok awal wajib diisi dengan angka minimal 0.');
            isValid = false;
        } else {
            clearFieldError('initialStockInput');
        }

        // Barcode Generated check
        const isBarcodeVisible = document.getElementById('barcodeAfterGen').style.display === 'flex';
        if (!isBarcodeVisible) {
            showFieldError('barcodeContainer', 'Silakan generate barcode terlebih dahulu.');
            isValid = false;
        } else {
            clearFieldError('barcodeContainer');
        }

        // Expired date checks (optional but if partially filled, require all)
        const day = document.getElementById('expDaySelect').value;
        const month = document.getElementById('expMonthSelect').value;
        const year = document.getElementById('expYearSelect').value;
        if (day || month || year) {
            if (!day || !month || !year) {
                showFieldError('expDaySelect', 'Silakan pilih tanggal expired secara lengkap.');
                isValid = false;
            } else {
                clearFieldError('expDaySelect');
            }
        } else {
            clearFieldError('expDaySelect');
        }

        return isValid;
    }

    // Manage array of variants
    let productVariants = [];

    function varCalculateSellingPrice() {
        const costInput = document.getElementById('varCostPriceInput');
        const marginInput = document.getElementById('varMarginInput');
        const sellingInput = document.getElementById('varSellingPriceInput');

        const cost = parseFloat(costInput.value);
        const margin = parseFloat(marginInput.value);

        if (!isNaN(cost) && cost > 0 && !isNaN(margin)) {
            const sellingPrice = Math.round(cost * (1 + margin / 100));
            sellingInput.value = sellingPrice;
        }
    }

    function varCalculateMargin() {
        const costInput = document.getElementById('varCostPriceInput');
        const marginInput = document.getElementById('varMarginInput');
        const sellingInput = document.getElementById('varSellingPriceInput');

        const cost = parseFloat(costInput.value);
        const selling = parseFloat(sellingInput.value);

        if (!isNaN(cost) && cost > 0 && !isNaN(selling)) {
            const margin = ((selling - cost) / cost) * 100;
            marginInput.value = Math.round(margin);
        }
    }

    async function addVariantToList() {
        const nameInput = document.getElementById('varNameInput');
        const unitSelect = document.getElementById('varUnitSelect');
        const skuInput = document.getElementById('varSkuInput');
        const stockInput = document.getElementById('varStockInput');
        const expiredInput = document.getElementById('varExpiredInput');
        const costPriceInput = document.getElementById('varCostPriceInput');
        const sellingPriceInput = document.getElementById('varSellingPriceInput');
        const marginInput = document.getElementById('varMarginInput');
        const barcodeInput = document.getElementById('varBarcodeInput');
        const minStockInput = document.getElementById('varMinStockInput');
        const alertToggle = document.getElementById('varAlertToggle');

        const errorSpan = document.getElementById('variantBuilderError');
        errorSpan.style.display = 'none';

        // Validation for builder
        if (!nameInput.value.trim()) {
            errorSpan.textContent = 'Nama varian produk wajib diisi.';
            errorSpan.style.display = 'block';
            nameInput.focus();
            return;
        }

        const cost = parseFloat(costPriceInput.value);
        if (isNaN(cost) || cost <= 0) {
            errorSpan.textContent = 'Harga beli harus lebih dari 0.';
            errorSpan.style.display = 'block';
            costPriceInput.focus();
            return;
        }

        const sell = parseFloat(sellingPriceInput.value);
        if (isNaN(sell) || sell <= 0) {
            errorSpan.textContent = 'Harga jual harus lebih dari 0.';
            errorSpan.style.display = 'block';
            sellingPriceInput.focus();
            return;
        }

        if (sell < cost) {
            errorSpan.textContent = 'Harga jual tidak boleh kurang dari harga beli.';
            errorSpan.style.display = 'block';
            sellingPriceInput.focus();
            return;
        }

        const margin = parseFloat(marginInput.value);
        if (isNaN(margin) || margin < 0) {
            errorSpan.textContent = 'Persentase margin wajib diisi.';
            errorSpan.style.display = 'block';
            marginInput.focus();
            return;
        }

        const stock = parseInt(stockInput.value);
        if (isNaN(stock) || stock < 0) {
            errorSpan.textContent = 'Stok awal minimal harus 0.';
            errorSpan.style.display = 'block';
            stockInput.focus();
            return;
        }

        const minStock = parseInt(minStockInput.value);
        if (isNaN(minStock) || minStock < 0) {
            errorSpan.textContent = 'Level peringatan stok minimum minimal harus 0.';
            errorSpan.style.display = 'block';
            minStockInput.focus();
            return;
        }

        // Require SKU and Barcode to be present/generated
        let skuVal = skuInput.value.trim();
        if (!skuVal) {
            errorSpan.textContent = 'Silakan masukkan atau buat kode SKU terlebih dahulu.';
            errorSpan.style.display = 'block';
            skuInput.focus();
            return;
        }
        let bcVal = barcodeInput.value.trim();
        if (!bcVal) {
            errorSpan.textContent = 'Silakan buat barcode terlebih dahulu sebelum menambahkan varian.';
            errorSpan.style.display = 'block';
            return;
        }

        // 1. Periksa keunikan lokal (sudah ditambahkan di daftar varian modal saat ini)
        const localExists = productVariants.some(v => v.sku.toLowerCase() === skuVal.toLowerCase());
        if (localExists) {
            errorSpan.textContent = `SKU "${skuVal}" sudah ditambahkan ke daftar varian di bawah.`;
            errorSpan.style.display = 'block';
            skuInput.focus();
            return;
        }

        // 2. Check database uniqueness via async check
        const saveBtn = document.querySelector('button[onclick="addVariantToList()"]');
        const originalBtnText = saveBtn.innerHTML;
        saveBtn.disabled = true;
        saveBtn.textContent = 'Memeriksa SKU...';

        try {
            const res = await fetch(`/products/check-sku?sku=${encodeURIComponent(skuVal)}`);
            const data = await res.json();
            if (data.exists) {
                errorSpan.textContent = `SKU "${skuVal}" sudah ada di database gudang. Silakan gunakan SKU yang unik.`;
                errorSpan.style.display = 'block';
                skuInput.focus();
                saveBtn.disabled = false;
                saveBtn.innerHTML = originalBtnText;
                return;
            }
        } catch (err) {
            console.error('Failed to verify SKU uniqueness:', err);
        }

        saveBtn.disabled = false;
        saveBtn.innerHTML = originalBtnText;

        const newVariant = {
            variant_name: nameInput.value.trim(),
            variant_unit: unitSelect.value,
            sku: skuVal,
            initial_stock: stock,
            expired_date: expiredInput.value || null,
            cost_price: cost,
            selling_price: sell,
            margin: margin,
            barcode: bcVal,
            min_stock: minStock,
            enable_stock_alert: alertToggle.checked ? 1 : 0
        };

        productVariants.push(newVariant);
        renderVariantsList();

        // Reset builder inputs
        nameInput.value = '';
        skuInput.value = '';
        stockInput.value = '';
        expiredInput.value = '';
        costPriceInput.value = '';
        sellingPriceInput.value = '';
        marginInput.value = '';
        barcodeInput.value = '';
        minStockInput.value = '';

        isSkuManuallyEdited = false;
        window.currentVariantSkuRandCode = null;

        // Reset Barcode Visual state & AI price recommendation cards
        if (typeof resetBarcodeState === 'function') resetBarcodeState();
        if (typeof resetPriceRecommendation === 'function') resetPriceRecommendation();
    }

    function removeVariantFromList(index) {
        productVariants.splice(index, 1);
        renderVariantsList();
    }

    function renderVariantsList() {
        const tbody = document.getElementById('variantsListTableBody');
        if (productVariants.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" style="padding: 20px; text-align: center; color: #8B8E97; font-weight: 600;">Belum ada varian yang ditambahkan. Silakan isi formulir dan tambahkan varian.</td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = '';
        productVariants.forEach((v, index) => {
            tbody.innerHTML += `
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <td style="padding: 10px; font-weight: 700; color: #000;">${v.variant_name} (${v.variant_unit})</td>
                    <td style="padding: 10px;">
                        <div style="font-size: 10px; color: #8B8E97;">SKU: <b>${v.sku}</b></div>
                        <div style="font-size: 10px; color: #8B8E97;">BC: <b>${v.barcode}</b></div>
                    </td>
                    <td style="padding: 10px;">
                        <div>Stock: <b>${v.initial_stock}</b></div>
                        <div style="font-size: 10px; color: #8B8E97;">Alert: ${v.enable_stock_alert ? `Min ${v.min_stock}` : 'Off'}</div>
                    </td>
                    <td style="padding: 10px;">
                        <div>Cost: Rp${v.cost_price.toLocaleString('id-ID')}</div>
                        <div>Sell: Rp${v.selling_price.toLocaleString('id-ID')}</div>
                    </td>
                    <td style="padding: 10px; text-align: center;">
                        <button type="button" onclick="removeVariantFromList(${index})" style="background: transparent; border: none; color: #FF4D4D; cursor: pointer; display: inline-flex; align-items: center; justify-content: center;">
                            <iconify-icon icon="solar:trash-bin-trash-linear" width="16" height="16"></iconify-icon>
                        </button>
                    </td>
                </tr>
            `;
        });
    }

    function goToStep(step) {
        document.getElementById('step1Content').style.display = step === 1 ? 'flex' : 'none';
        document.getElementById('step2Content').style.display = step === 2 ? 'flex' : 'none';
        document.getElementById('successContent').style.display = step === 'success' ? 'flex' : 'none';

        const stepperHeader = document.querySelector('#modalContainer > div:nth-child(2)');
        const progressBar = document.querySelector('#modalContainer > div:nth-child(3)');

        if (step === 'success') {
            if (stepperHeader) stepperHeader.style.display = 'none';
            if (progressBar) progressBar.style.display = 'none';
            document.getElementById('modalContainer').style.maxWidth = '460px';
            return;
        } else {
            if (stepperHeader) stepperHeader.style.display = 'flex';
            if (progressBar) progressBar.style.display = 'block';
            document.getElementById('modalContainer').style.maxWidth = '800px';
        }

        currentStep = step;

        const titleEl = document.getElementById('modalTitleText');
        if (step === 1) {
            titleEl.textContent = "Add New Product";
        } else if (step === 2) {
            titleEl.textContent = "Configure Variants";
        }

        const c1 = document.getElementById('stepCircle1');
        const c2 = document.getElementById('stepCircle2');
        const progress = document.getElementById('modalProgressBar');

        // Hide unused stepper 3 indicator circle
        const c3 = document.getElementById('stepCircle3');
        if (c3) {
            c3.style.display = 'none';
            const separator = c3.previousElementSibling;
            if (separator) separator.style.display = 'none';
        }

        if (step === 1) {
            c1.style.backgroundColor = '#0077FF'; c1.style.color = '#FFFFFF';
            c2.style.backgroundColor = '#F1F3F6'; c2.style.color = '#8B8E97';
            progress.style.width = '50%';
        } else if (step === 2) {
            c1.style.backgroundColor = '#0077FF'; c1.style.color = '#FFFFFF';
            c2.style.backgroundColor = '#0077FF'; c2.style.color = '#FFFFFF';
            progress.style.width = '100%';
        }
    }

    function triggerImageUpload() {
        document.getElementById('productImageInput').click();
    }

    function handleImageUpload(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('uploadPlaceholder').style.display = 'none';
                document.getElementById('imagePreviewContainer').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }

    function resetImageUpload() {
        document.getElementById('productImageInput').value = '';
        document.getElementById('imagePreview').src = '';
        document.getElementById('uploadPlaceholder').style.display = 'flex';
        document.getElementById('imagePreviewContainer').style.display = 'none';
    }

    function openAddProductModal() {
        document.getElementById('modalContainer').style.maxWidth = '800px';
        const stepperHeader = document.querySelector('#modalContainer > div:nth-child(2)');
        const progressBar = document.querySelector('#modalContainer > div:nth-child(3)');
        if (stepperHeader) stepperHeader.style.display = 'flex';
        if (progressBar) progressBar.style.display = 'block';

        productVariants = [];
        renderVariantsList();
        goToStep(1);
        resetImageUpload();
        isSkuManuallyEdited = false;
        window.currentVariantSkuRandCode = null;

        const modal = document.getElementById('addProductModal');
        const container = document.getElementById('modalContainer');
        modal.style.display = 'flex';
        modal.offsetHeight;
        modal.style.opacity = '1';
        setTimeout(() => {
            container.classList.remove('scale-95', 'opacity-0');
            container.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeAddProductModal() {
        const modal = document.getElementById('addProductModal');
        const container = document.getElementById('modalContainer');
        container.classList.remove('scale-100', 'opacity-100');
        container.classList.add('scale-95', 'opacity-0');
        modal.style.opacity = '0';
        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
    }

    function showFieldError(inputId, errorText) {
        const inputEl = document.getElementById(inputId);
        if (!inputEl) return;
        
        inputEl.classList.add('input-error-state');
        let errSpan = document.getElementById(inputId + 'Error');
        if (!errSpan) {
            errSpan = document.createElement('span');
            errSpan.id = inputId + 'Error';
            errSpan.className = 'error-message-text';
            inputEl.parentNode.appendChild(errSpan);
        }
        errSpan.textContent = errorText;
        errSpan.style.display = 'block';
    }

    function clearFieldError(inputId) {
        const inputEl = document.getElementById(inputId);
        if (inputEl) {
            inputEl.classList.remove('input-error-state');
        }
        const errSpan = document.getElementById(inputId + 'Error');
        if (errSpan) {
            errSpan.style.display = 'none';
        }
    }

    function validateStep1() {
        let isValid = true;

        const nameVal = document.getElementById('productNameInput').value.trim();
        if (nameVal.length < 3) {
            showFieldError('productNameInput', 'Nama produk minimal harus 3 karakter.');
            isValid = false;
        } else {
            clearFieldError('productNameInput');
        }

        const categoryVal = document.getElementById('productCategorySelect').value;
        if (!categoryVal) {
            showFieldError('productCategorySelect', 'Silakan pilih kategori.');
            isValid = false;
        } else {
            clearFieldError('productCategorySelect');
        }

        return isValid;
    }

    function handleStep1Next() {
        if (validateStep1()) {
            goToStep(2);
        }
    }

    function handleStep2Submit() {
        if (productVariants.length === 0) {
            const errorSpan = document.getElementById('variantBuilderError');
            errorSpan.textContent = 'Silakan tambahkan setidaknya satu varian sebelum menyimpan.';
            errorSpan.style.display = 'block';
            return;
        }

        submitProductForm();
    }

    function submitProductForm() {
        const formData = new FormData();
        formData.append('name', document.getElementById('productNameInput').value);
        formData.append('details', document.getElementById('productDetailsInput').value);
        formData.append('category_id', document.getElementById('productCategorySelect').value);
        
        const imageFile = document.getElementById('productImageInput').files[0];
        if (imageFile) {
            formData.append('image', imageFile);
        }

        // Append variants array
        productVariants.forEach((v, index) => {
            formData.append(`variants[${index}][variant_name]`, v.variant_name);
            formData.append(`variants[${index}][variant_unit]`, v.variant_unit);
            formData.append(`variants[${index}][sku]`, v.sku);
            formData.append(`variants[${index}][initial_stock]`, v.initial_stock);
            if (v.expired_date) {
                formData.append(`variants[${index}][expired_date]`, v.expired_date);
            }
            formData.append(`variants[${index}][barcode]`, v.barcode);
            formData.append(`variants[${index}][cost_price]`, v.cost_price);
            formData.append(`variants[${index}][selling_price]`, v.selling_price);
            formData.append(`variants[${index}][margin]`, v.margin);
            formData.append(`variants[${index}][min_stock]`, v.min_stock);
            formData.append(`variants[${index}][enable_stock_alert]`, v.enable_stock_alert);
        });

        const token = document.querySelector('input[name="_token"]')?.value || '';
        const saveBtn = document.querySelector('#step2Content button[onclick="handleStep2Submit()"]');
        const originalBtnText = saveBtn.innerHTML;
        saveBtn.disabled = true;
        saveBtn.textContent = 'Menyimpan...';

        fetch('/products', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            }
        })
        .then(async response => {
            const isJson = response.headers.get('content-type')?.includes('application/json');
            const data = isJson ? await response.json() : null;

            if (!response.ok) {
                if (response.status === 422 && data && data.errors) {
                    return data;
                }
                const errorMsg = (data && data.message) ? data.message : 'Server error occurred.';
                throw new Error(errorMsg);
            }
            return data;
        })
        .then(data => {
            saveBtn.disabled = false;
            saveBtn.innerHTML = originalBtnText;

            if (!data) return;

            if (data.success) {
                goToStep('success');
                const seeProductBtn = document.querySelector('#successContent button');
                if (seeProductBtn) {
                    seeProductBtn.onclick = function() {
                        window.location.reload();
                    };
                }
            } else if (data.errors) {
                // Parsing pemetaan error validasi di sisi server
                let errorMsg = 'Validasi gagal: ';
                Object.keys(data.errors).forEach(key => {
                    errorMsg += '\nâ€¢ ' + data.errors[key][0];
                });
                showToast(errorMsg, 'error');
            }
        })
        .catch(err => {
            saveBtn.disabled = false;
            saveBtn.innerHTML = originalBtnText;
            console.error('Submission failed:', err);
            showToast(err.message || 'Gagal menyimpan produk. Silakan periksa koneksi atau hubungi admin.', 'error');
        });
    }

    function showToast(message, type = 'error') {
        const container = document.getElementById('toastContainer');
        if (!container) return;

        // Create toast element
        const toast = document.createElement('div');
        toast.style.display = 'flex';
        toast.style.alignItems = 'center';
        toast.style.gap = '12px';
        toast.style.padding = '14px 20px';
        toast.style.borderRadius = '12px';
        toast.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)';
        toast.style.backgroundColor = '#FFFFFF';
        toast.style.border = '1px solid rgba(0, 0, 0, 0.05)';
        toast.style.pointerEvents = 'auto';
        toast.style.transform = 'translateY(-20px)';
        toast.style.opacity = '0';
        toast.style.transition = 'all 0.4s cubic-bezier(0.16, 1, 0.3, 1)';
        toast.style.minWidth = '300px';
        toast.style.maxWidth = '400px';

        // Set colors & icons based on type
        let iconHtml = '';
        if (type === 'success') {
            toast.style.borderLeft = '4px solid #10B981';
            iconHtml = `<iconify-icon icon="solar:check-circle-bold" width="20" height="20" style="color: #10B981; flex-shrink: 0;"></iconify-icon>`;
        } else {
            toast.style.borderLeft = '4px solid #FF4D4D';
            iconHtml = `<iconify-icon icon="solar:danger-bold" width="20" height="20" style="color: #FF4D4D; flex-shrink: 0;"></iconify-icon>`;
        }

        toast.innerHTML = `
            ${iconHtml}
            <div style="flex: 1; font-size: 13px; font-weight: 600; color: #1A1D1F; font-family: 'Plus Jakarta Sans', sans-serif; line-height: 1.4; white-space: pre-line;">${message}</div>
            <button onclick="this.parentElement.remove()" style="background: transparent; border: none; color: #8B8E97; cursor: pointer; display: flex; align-items: center; justify-content: center; padding: 0; outline: none; margin-left: 8px;">
                <iconify-icon icon="material-symbols:close-rounded" width="16" height="16"></iconify-icon>
            </button>
        `;

        container.appendChild(toast);

        // Force reflow
        toast.offsetHeight;

        // Animate in
        toast.style.transform = 'translateY(0)';
        toast.style.opacity = '1';

        // Auto-dismiss after 4 seconds
        setTimeout(() => {
            toast.style.transform = 'translateY(-20px)';
            toast.style.opacity = '0';
            setTimeout(() => {
                toast.remove();
            }, 400);
        }, 4000);
    }

    // Stock Status Popover Functions
    function showStatusPopover(el) {
        const popover = document.getElementById('statusDetailsPopover');
        if (!popover) return;

        const status = el.getAttribute('data-status').toLowerCase();
        const stock = parseInt(el.getAttribute('data-stock')) || 0;
        const minStock = parseInt(el.getAttribute('data-min-stock')) || 0;
        const dailySales = parseInt(el.getAttribute('data-daily-sales')) || 0;
        const price = parseFloat(el.getAttribute('data-price')) || 0;

        const progressBar = document.getElementById('popoverProgressBar');
        const labels = document.getElementById('popoverLabels');
        const title = document.getElementById('popoverTitle');
        const subtitle = document.getElementById('popoverSubtitle');

        // Reset elements
        progressBar.innerHTML = '';
        labels.innerHTML = '';

        if (status === 'healthy') {
            progressBar.innerHTML = `
                <div style="width: 50%; background-color: #10B981;"></div>
                <div style="width: 25%; background-color: #34D399;"></div>
                <div style="width: 25%; background-color: #FFD29D;"></div>
            `;
            labels.innerHTML = `
                <span>Stok Saat Ini</span>
                <span>Stok Zona Aman</span>
                <span>Stok Masuk</span>
            `;
            title.textContent = 'Tingkat stok Anda sehat';
            subtitle.textContent = 'Inventaris saat ini cukup untuk memenuhi permintaan.';
        } else if (status === 'running low') {
            const daysLeft = dailySales > 0 ? Math.ceil(stock / dailySales) : 5;
            progressBar.innerHTML = `
                <div style="width: 25%; background-color: #FF8F00;"></div>
                <div style="width: 40%; background-color: #FFB04C;"></div>
                <div style="width: 35%; background-color: #FFEDD5;"></div>
            `;
            labels.innerHTML = `
                <span>Stok Saat Ini</span>
                <span>Stok Zona Aman</span>
                <span>Stok Masuk</span>
            `;
            title.textContent = 'Stok Anda hampir habis';
            subtitle.textContent = `Item ini akan habis dalam ${daysLeft} hari, berdasarkan penjualan terkini.`;
        } else {
            const daysOut = 3;
            const lostSalesQty = dailySales > 0 ? (dailySales * daysOut) : 3;
            const lostSalesVal = lostSalesQty * price;
            const formattedLostSales = lostSalesVal > 0 ? 'Rp ' + lostSalesVal.toLocaleString('id-ID') : 'Rp 450.000';

            progressBar.innerHTML = `
                <div style="width: 15%; background-color: #FF4D4D;"></div>
                <div style="width: 55%; background: repeating-linear-gradient(45deg, #FFCDCD, #FFCDCD 4px, #FEE2E2 4px, #FEE2E2 8px);"></div>
                <div style="width: 30%; background-color: #FF8F00;"></div>
            `;
            labels.innerHTML = `
                <span>Stok Aktual</span>
                <span>Stok CELAH</span>
                <span>Stok Masuk</span>
            `;
            title.textContent = 'Anda mungkin kehilangan penjualan karena inventaris tidak tersedia';
            subtitle.textContent = `Habis selama ${daysOut} hari. Perkiraan penjualan yang hilang ${formattedLostSales}.`;
        }

        // Show popover to calculate dimensions
        popover.style.display = 'block';
        
        // Position popover centered above the status pill
        const rect = el.getBoundingClientRect();
        const popoverWidth = popover.offsetWidth;
        const popoverHeight = popover.offsetHeight;
        
        const top = rect.top + window.scrollY - popoverHeight - 10;
        const left = rect.left + window.scrollX + (rect.width / 2) - (popoverWidth / 2);
        
        popover.style.top = `${top}px`;
        popover.style.left = `${left}px`;
        
        // Trigger transition
        popover.offsetHeight; // Force reflow
        popover.style.opacity = '1';
        popover.style.transform = 'translateY(0)';

        // Click outside listener
        const dismissHandler = function(e) {
            if (!popover.contains(e.target) && e.target !== el && !el.contains(e.target)) {
                closeStatusPopover();
                document.removeEventListener('click', dismissHandler);
            }
        };
        
        setTimeout(() => {
            document.addEventListener('click', dismissHandler);
        }, 10);
    }

    function closeStatusPopover() {
        const popover = document.getElementById('statusDetailsPopover');
        if (!popover) return;
        popover.style.opacity = '0';
        popover.style.transform = 'translateY(-5px)';
        setTimeout(() => {
            if (popover.style.opacity === '0') {
                popover.style.display = 'none';
            }
        }, 150);
    }

    // Product Details Sidebar Functions
    function showDetailSidebar(btn) {
        try {
            const variant = JSON.parse(btn.getAttribute('data-variant'));
            const product = JSON.parse(btn.getAttribute('data-product'));
            openProductDetailsSidebar({ _variant: variant, _product: product });
        } catch(e) {
            console.error('showDetailSidebar error:', e);
            alert('Gagal membuka detail: ' + e.message);
        }
    }

    function openProductDetailsSidebar(element) {
        try {
            let variant, product;
            if (element._variant) {
                // Called from showDetailSidebar with pre-parsed objects
                variant = element._variant;
                product = element._product;
            } else {
                const variantData = element.getAttribute('data-variant');
                const productData = element.getAttribute('data-product');
                if (!variantData || !productData) {
                    console.error('Missing data attributes', element);
                    return;
                }
                variant = JSON.parse(variantData);
                product = JSON.parse(productData);
            }

            document.getElementById('detailProductImage').src = product.image_path || 'https://images.unsplash.com/photo-1568254183919-78a4f43a2877?w=100&auto=format&fit=crop&q=60';
            document.getElementById('detailProductName').textContent = `${product.name} (${variant.variant_name})`;
            document.getElementById('detailProductSku').textContent = `SKU : ${variant.sku}`;

            const badge = document.getElementById('detailStatusBadge');
            badge.className = '';
            
            let statusText = 'Healthy';
            let statusClass = 'status-healthy';
            let dotColor = '#10B981';
            
            const isLow = variant.enable_stock_alert && variant.actual_stock <= variant.min_stock;
            if (variant.actual_stock === 0) {
                statusText = 'Out Of Stock';
                statusClass = 'status-out';
                dotColor = '#FF4D4D';
            } else if (isLow) {
                statusText = 'Running Low';
                statusClass = 'status-low';
                dotColor = '#0077FF';
            }
            
            badge.className = statusClass;
            badge.innerHTML = `<span class="status-dot-figma" style="background-color: ${dotColor};"></span><span>${statusText}</span>`;

            const aiText = document.getElementById('detailAiAnalysisText');
            if (statusText === 'Healthy') {
                aiText.textContent = 'This product is in good condition with healthy stock levels based on sales velocity.';
            } else if (statusText === 'Running Low') {
                aiText.textContent = 'This product is running low based on recent sales trends.';
            } else {
                aiText.textContent = 'This product is currently out of stock and requires immediate attention.';
            }

            document.getElementById('detailProductPrice').textContent = `Rp ${parseFloat(variant.selling_price).toLocaleString('id-ID')}`;
            document.getElementById('detailCurrentStock').textContent = `${variant.actual_stock} ${variant.variant_unit}`;
            document.getElementById('detailStockAlert').textContent = `${variant.min_stock} ${variant.variant_unit}`;
            document.getElementById('detailDescription').textContent = product.details || 'No description provided for this product.';

            const dailySales = product.daily_sales || 0;
            const monthlyRevenue = product.monthly_revenue || 0;
            const costValue = variant.cost_price * variant.actual_stock;
            
            const promptText = `Analyze my current inventory for "${product.name}" (${variant.variant_name}), which is critically ${statusText.toLowerCase()} with only ${variant.actual_stock} units remaining.

Current data:
- Daily Sales: ${dailySales}
- Monthly Revenue: Rp ${monthlyRevenue.toLocaleString('id-ID')}
- Product Price: Rp ${parseFloat(variant.selling_price).toLocaleString('id-ID')}
- Cost Value: Rp ${costValue.toLocaleString('id-ID')}
- Grade: ${product.grade || 'A'}

Please suggest:
1. Optimal reorder quantity based on sales velocity and demand forecasting
2. Ideal reorder timing to avoid stockout
3. Supplier negotiation strategy to minimize cost
4. Safety stock level recommendation
5. Any pricing or promotional actions to manage current low stock`;

            document.getElementById('detailAiPromptText').textContent = promptText;
            // Reset mitigation prompt visibility
            const promptContainer = document.getElementById('detailAiPromptContainer');
            if (promptContainer) promptContainer.style.display = 'none';
            const mitigationBtn = document.getElementById('detailMitigationBtn');
            if (mitigationBtn) mitigationBtn.textContent = 'Get Mitigation Strategy';

            switchDetailTab('info');

            const backdrop = document.getElementById('productDetailsSidebarBackdrop');
            const sidebar = document.getElementById('productDetailsSidebar');
            backdrop.style.display = 'block';
            // Force reflow
            backdrop.offsetHeight;
            backdrop.style.opacity = '1';
            sidebar.style.transform = 'translateX(0)';
        } catch (error) {
            console.error("Failed to open product details sidebar:", error);
            showToast("Failed to display product details: " + error.message, "error");
        }
    }

    function showMitigationStrategy() {
        const container = document.getElementById('detailAiPromptContainer');
        const btn = document.getElementById('detailMitigationBtn');
        if (container) {
            container.style.display = 'flex';
            container.scrollIntoView({ behavior: 'smooth', block: 'end' });
        }
        if (btn) {
            btn.textContent = 'Your Strategy Ready';
        }
    }

    function closeProductDetailsSidebar() {
        const backdrop = document.getElementById('productDetailsSidebarBackdrop');
        const sidebar = document.getElementById('productDetailsSidebar');
        sidebar.style.transform = 'translateX(100%)';
        backdrop.style.opacity = '0';
        setTimeout(() => {
            backdrop.style.display = 'none';
        }, 300);
    }

    function switchDetailTab(tab) {
        const btnInfo = document.getElementById('tabBtnInfo');
        const btnSuppliers = document.getElementById('tabBtnSuppliers');
        const btnAnalytics = document.getElementById('tabBtnAnalytics');

        const contentInfo = document.getElementById('tabContentInfo');
        const contentSuppliers = document.getElementById('tabContentSuppliers');
        const contentAnalytics = document.getElementById('tabContentAnalytics');

        btnInfo.className = 'pb-3 text-[13px] font-bold text-gray-400 border-b-2 border-transparent hover:text-black cursor-pointer transition-all bg-transparent outline-none';
        btnSuppliers.className = 'pb-3 text-[13px] font-bold text-gray-400 border-b-2 border-transparent hover:text-black cursor-pointer transition-all bg-transparent outline-none';
        btnAnalytics.className = 'pb-3 text-[13px] font-bold text-gray-400 border-b-2 border-transparent hover:text-black cursor-pointer transition-all bg-transparent outline-none';

        contentInfo.style.display = 'none';
        contentSuppliers.style.display = 'none';
        contentAnalytics.style.display = 'none';

        if (tab === 'info') {
            btnInfo.className = 'pb-3 text-[13px] font-bold text-[#0077FF] border-b-2 border-[#0077FF] cursor-pointer transition-all bg-transparent outline-none';
            contentInfo.style.display = 'flex';
        } else if (tab === 'suppliers') {
            btnSuppliers.className = 'pb-3 text-[13px] font-bold text-[#0077FF] border-b-2 border-[#0077FF] cursor-pointer transition-all bg-transparent outline-none';
            contentSuppliers.style.display = 'flex';
        } else if (tab === 'analytics') {
            btnAnalytics.className = 'pb-3 text-[13px] font-bold text-[#0077FF] border-b-2 border-[#0077FF] cursor-pointer transition-all bg-transparent outline-none';
            contentAnalytics.style.display = 'flex';
        }
    }

    function copyAiPrompt() {
        const text = document.getElementById('detailAiPromptText').textContent;
        navigator.clipboard.writeText(text).then(() => {
            showToast('Suggested AI Prompt copied to clipboard!', 'success');
        }).catch(err => {
            console.error('Failed to copy text: ', err);
        });
    }

    // Client-side Search and Filter for Inventory Page
    let activeInventoryFilter = 'all';

    function selectInventoryFilter(status) {
        activeInventoryFilter = status;
        
        const btnAll = document.getElementById('btnFilterAll');
        const btnHealthy = document.getElementById('btnFilterHealthy');
        const btnLow = document.getElementById('btnFilterLow');
        const btnOut = document.getElementById('btnFilterOut');
        
        const dotHealthy = document.getElementById('dotFilterHealthy');
        const dotLow = document.getElementById('dotFilterLow');
        const dotOut = document.getElementById('dotFilterOut');
        
        // Reset styles
        btnAll.className = "text-[13px] font-bold text-black bg-white hover:bg-gray-50 transition-all cursor-pointer";
        btnAll.style.border = "1px solid rgba(0,0,0,0.1)";
        
        btnHealthy.className = "text-[13px] font-semibold text-[#8B8E97] bg-white hover:bg-gray-50 transition-all cursor-pointer";
        btnHealthy.style.border = "1px solid rgba(0,0,0,0.1)";
        btnHealthy.style.backgroundColor = "#FFFFFF";
        btnHealthy.style.color = "#8B8E97";
        dotHealthy.style.backgroundColor = "#9CA3AF";
        
        btnLow.className = "text-[13px] font-semibold text-[#8B8E97] bg-white hover:bg-gray-50 transition-all cursor-pointer";
        btnLow.style.border = "1px solid rgba(0,0,0,0.1)";
        btnLow.style.backgroundColor = "#FFFFFF";
        btnLow.style.color = "#8B8E97";
        dotLow.style.backgroundColor = "#9CA3AF";
        
        btnOut.className = "text-[13px] font-semibold text-[#8B8E97] bg-white hover:bg-gray-50 transition-all cursor-pointer";
        btnOut.style.border = "1px solid rgba(0,0,0,0.1)";
        btnOut.style.backgroundColor = "#FFFFFF";
        btnOut.style.color = "#8B8E97";
        dotOut.style.backgroundColor = "#9CA3AF";
        
        if (status === 'all') {
            btnAll.className = "text-[13px] font-bold text-[#0077FF] bg-[#0077FF]/5 border border-[#0077FF]/20 transition-all cursor-pointer";
            btnAll.style.border = "";
        } else if (status === 'healthy') {
            btnHealthy.style.backgroundColor = "#E8FDF5";
            btnHealthy.style.color = "#10B981";
            btnHealthy.style.borderColor = "#A7F3D0";
            dotHealthy.style.backgroundColor = "#10B981";
        } else if (status === 'running low') {
            btnLow.style.backgroundColor = "#EEF6FF";
            btnLow.style.color = "#0077FF";
            btnLow.style.borderColor = "#BFDBFE";
            dotLow.style.backgroundColor = "#0077FF";
        } else if (status === 'out of stock') {
            btnOut.style.backgroundColor = "#FFF5F5";
            btnOut.style.color = "#FF4D4D";
            btnOut.style.borderColor = "#FEE2E2";
            dotOut.style.backgroundColor = "#FF4D4D";
        }
        
        applyInventoryFilters();
    }

    function applyInventoryFilters() {
        const query = document.getElementById('inventorySearchInput').value.toLowerCase().trim();
        const tbody = document.querySelector('.figma-table tbody');
        if (!tbody) return;
        
        const rows = Array.from(tbody.querySelectorAll('tr'));
        let groups = [];
        let currentGroup = null;
        
        rows.forEach(row => {
            if (row.className.includes('cursor-pointer') && !row.className.includes('variant-row-')) {
                if (currentGroup) groups.push(currentGroup);
                currentGroup = { parent: row, variants: [] };
            } else if (row.className.includes('variant-row-')) {
                if (currentGroup) currentGroup.variants.push(row);
            }
        });
        if (currentGroup) groups.push(currentGroup);
        
        groups.forEach(group => {
            const parent = group.parent;
            const nameEl = parent.querySelector('.font-bold.text-black');
            const categoryEl = parent.querySelector('.col-sticky-3');
            const nameText = nameEl ? nameEl.textContent.toLowerCase() : '';
            const categoryText = categoryEl ? categoryEl.textContent.toLowerCase() : '';
            
            const parentSearchMatch = nameText.includes(query) || categoryText.includes(query);
            
            const statusSpan = parent.querySelector('span[data-status]');
            const parentStatus = statusSpan ? statusSpan.getAttribute('data-status').toLowerCase() : '';
            const parentFilterMatch = (activeInventoryFilter === 'all' || parentStatus === activeInventoryFilter);
            
            let anyVariantMatch = false;
            
            group.variants.forEach(varRow => {
                const varNameEl = varRow.querySelector('.font-semibold.text-gray-700');
                const varSkuEl = varRow.querySelector('.font-bold.text-gray-700');
                const varName = varNameEl ? varNameEl.textContent.toLowerCase() : '';
                const varSkuText = varSkuEl ? varSkuEl.textContent.toLowerCase() : '';
                
                const varSearchMatch = varName.includes(query) || varSkuText.includes(query);
                
                const varStatusSpan = varRow.querySelector('span[data-status]');
                const varStatus = varStatusSpan ? varStatusSpan.getAttribute('data-status').toLowerCase() : '';
                const varFilterMatch = (activeInventoryFilter === 'all' || varStatus === activeInventoryFilter);
                
                const showVar = (query === '' || varSearchMatch || parentSearchMatch) && varFilterMatch;
                
                if (showVar) {
                    anyVariantMatch = true;
                    varRow.setAttribute('data-filtered-visible', 'true');
                } else {
                    varRow.setAttribute('data-filtered-visible', 'false');
                }
            });
            
            const showParent = (parentSearchMatch && parentFilterMatch) || anyVariantMatch;
            
            if (showParent) {
                parent.setAttribute('data-filtered-out', 'false');
            } else {
                parent.setAttribute('data-filtered-out', 'true');
            }
        });
        
        inventoryCurrentPage = 1;
        setupInventoryPagination();
    }

    let inventoryCurrentPage = 1;
    const inventoryPerPage = 10;

    function setupInventoryPagination() {
        const tbody = document.querySelector('.figma-table tbody');
        if (!tbody) return;
        
        const rows = Array.from(tbody.querySelectorAll('tr'));
        let groups = [];
        let currentGroup = null;
        
        rows.forEach(row => {
            if (row.className.includes('cursor-pointer') && !row.className.includes('variant-row-')) {
                if (currentGroup) groups.push(currentGroup);
                currentGroup = { parent: row, variants: [] };
            } else if (row.className.includes('variant-row-')) {
                if (currentGroup) currentGroup.variants.push(row);
            }
        });
        if (currentGroup) groups.push(currentGroup);
        
        const visibleGroups = groups.filter(group => group.parent.getAttribute('data-filtered-out') !== 'true');
        
        const totalRows = visibleGroups.length;
        const totalPages = Math.max(1, Math.ceil(totalRows / inventoryPerPage));
        
        if (inventoryCurrentPage > totalPages) {
            inventoryCurrentPage = totalPages;
        }
        if (inventoryCurrentPage < 1) {
            inventoryCurrentPage = 1;
        }
        
        const start = (inventoryCurrentPage - 1) * inventoryPerPage;
        const end = start + inventoryPerPage;
        
        groups.forEach(group => {
            group.parent.style.display = 'none';
            group.variants.forEach(v => v.style.display = 'none');
        });
        
        visibleGroups.forEach((group, index) => {
            if (index >= start && index < end) {
                group.parent.style.display = '';
                group.variants.forEach(varRow => {
                    updateVariantRowVisibility(varRow, group.parent);
                });
            }
        });
        
        renderInventoryPaginationControls(totalPages, totalRows);
    }

    function renderInventoryPaginationControls(totalPages, totalRows) {
        const table = document.querySelector('.figma-table');
        if (!table) return;
        const footer = table.parentNode.nextElementSibling;
        if (!footer) return;
        
        const showStart = totalRows === 0 ? 0 : (inventoryCurrentPage - 1) * inventoryPerPage + 1;
        const showEnd = Math.min(inventoryCurrentPage * inventoryPerPage, totalRows);
        
        footer.innerHTML = `
            <span class="text-[12px] font-semibold text-[#8B8E97]">Showing ${showStart}-${showEnd} of ${totalRows} products</span>
            <div class="flex items-center gap-2">
                <button onclick="changeInventoryPage(-1)" ${inventoryCurrentPage === 1 ? 'disabled style="cursor: not-allowed; opacity: 0.5;"' : 'style="cursor: pointer;"'} class="w-8 h-8 flex items-center justify-center border border-black/10 rounded-[6px] text-gray-400 bg-white hover:bg-gray-50 transition-all border-0">
                    <iconify-icon icon="solar:alt-arrow-left-linear" width="16" height="16"></iconify-icon>
                </button>
                <span class="text-[12px] font-bold text-[#0077FF] bg-[#0077FF]/5 px-3 py-1 rounded-[6px] border border-[#0077FF]/10">${inventoryCurrentPage} / ${totalPages}</span>
                <button onclick="changeInventoryPage(1)" ${inventoryCurrentPage === totalPages ? 'disabled style="cursor: not-allowed; opacity: 0.5;"' : 'style="cursor: pointer;"'} class="w-8 h-8 flex items-center justify-center bg-[#0077FF] rounded-[6px] text-white shadow-sm shadow-[#0077FF]/20 hover:bg-[#0062D1] transition-all border-0">
                    <iconify-icon icon="solar:alt-arrow-right-linear" width="16" height="16"></iconify-icon>
                </button>
            </div>
        `;
    }

    function changeInventoryPage(direction) {
        inventoryCurrentPage += direction;
        setupInventoryPagination();
    }

    function updateVariantRowVisibility(varRow, parentRow) {
        const arrowIcon = parentRow.querySelector('[id^="arrow-icon-"]');
        const isExpanded = arrowIcon && arrowIcon.style.transform === 'rotate(90deg)';
        const isFilteredVisible = varRow.getAttribute('data-filtered-visible') !== 'false';
        
        if (isExpanded && isFilteredVisible) {
            varRow.style.display = '';
        } else {
            varRow.style.display = 'none';
        }
    }

    function toggleVariants(productId) {
        const rows = document.querySelectorAll('.variant-row-' + productId);
        const arrow = document.getElementById('arrow-icon-' + productId);
        const isCollapsed = !arrow.style.transform || arrow.style.transform === 'rotate(0deg)';
        
        if (isCollapsed) {
            arrow.style.transform = 'rotate(90deg)';
            rows.forEach(row => {
                const isFilteredVisible = row.getAttribute('data-filtered-visible') !== 'false';
                if (isFilteredVisible) {
                    row.style.display = '';
                }
            });
        } else {
            arrow.style.transform = 'rotate(0deg)';
            rows.forEach(row => {
                row.style.display = 'none';
            });
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        setupInventoryPagination();
    });
</script>

@endsection

@push('sidebar')
<!-- Product Details Sidebar Drawer Backdrop Wrapper -->
<div id="productDetailsSidebarBackdrop" class="fixed inset-0" style="z-index: 9999; background-color: rgba(0, 0, 0, 0.4); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); display: none; opacity: 0; transition: opacity 0.3s ease;" onclick="closeProductDetailsSidebar()">
    <!-- Product Details Sidebar Drawer -->
    <div id="productDetailsSidebar" class="fixed right-0 top-0 bottom-0 z-[10000] w-[460px] bg-white shadow-2xl border-l border-black/5 flex flex-col" style="font-family: 'Plus Jakarta Sans', sans-serif; transform: translateX(100%); transition: transform 0.3s ease-in-out;" onclick="event.stopPropagation()">
    <!-- Sidebar Header -->
    <div class="p-6 border-b border-black/5 flex items-center justify-between flex-shrink-0" style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(0,0,0,0.05); box-sizing: border-box;">
        <h3 class="text-[18px] font-bold text-black m-0">Product Details</h3>
        <button onclick="closeProductDetailsSidebar()" class="w-8 h-8 flex items-center justify-center rounded-full bg-[#F1F3F6] hover:bg-gray-200 text-gray-500 hover:text-black cursor-pointer transition-all border-none outline-none" style="width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; padding: 0;">
            <iconify-icon icon="material-symbols:close-rounded" width="20" height="20"></iconify-icon>
        </button>
    </div>

    <!-- Sidebar Content (Scrollable) -->
    <div class="flex-1 overflow-y-auto premium-scrollbar p-6 flex flex-col gap-6" style="flex: 1; overflow-y: auto; padding: 24px; box-sizing: border-box; display: flex; flex-direction: column; gap: 24px;">
        <!-- Product Main Info -->
        <div class="flex items-start gap-4" style="display: flex; gap: 16px;">
            <img id="detailProductImage" src="" alt="Product Image" class="w-20 h-20 rounded-xl object-cover border border-black/5" style="width: 80px; height: 80px; border-radius: 12px; object-fit: cover;" />
            <div class="flex flex-col gap-1.5" style="display: flex; flex-direction: column; gap: 6px;">
                <h4 id="detailProductName" class="text-[16px] font-bold text-black leading-tight m-0"></h4>
                <span id="detailProductSku" class="text-[12px] text-gray-500 font-semibold m-0"></span>
                <div>
                    <span id="detailStatusBadge" class="status-healthy"></span>
                </div>
            </div>
        </div>

        <!-- Vern AI Product Analyze Card -->
        <div class="p-4 rounded-2xl border border-blue-100 flex items-center justify-between gap-4" style="padding: 16px; border-radius: 16px; background: linear-gradient(90deg, #F1F5F9 0%, #E2E8F0 100%); border: 1px solid rgba(29,56,255,0.08); display: flex; justify-content: space-between; align-items: center; gap: 16px;">
            <div class="flex flex-col gap-1" style="display: flex; flex-direction: column; gap: 4px;">
                <div class="flex items-center gap-1.5" style="display: flex; align-items: center; gap: 6px;">
                    <span class="text-[10px] font-extrabold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full uppercase tracking-wider" style="font-size: 8px; font-weight: 800; color: #1D38FF; background-color: #E8F0FE; padding: 2px 8px; border-radius: 100px;">Vern AI</span>
                    <span class="text-[11px] font-bold text-gray-800" style="font-size: 11px; font-weight: 700; color: #1A1D1F;">Product Analyze</span>
                </div>
                <p id="detailAiAnalysisText" class="text-[12px] font-medium text-gray-600 leading-normal m-0" style="font-size: 12px; line-height: 1.4; color: #8B8E97; margin: 0; font-weight: 500;"></p>
            </div>
            <button id="detailMitigationBtn" onclick="showMitigationStrategy()" class="bg-black hover:bg-gray-800 text-white font-bold text-[11px] px-4 py-2 rounded-full cursor-pointer transition-all border-none outline-none flex-shrink-0" style="background-color: #000; color: #fff; font-size: 10px; font-weight: 700; padding: 8px 16px; border-radius: 100px; border: none; flex-shrink: 0;">Get Mitigation Strategy</button>
        </div>

        <!-- Tabs -->
        <div class="flex border-b border-black/5 gap-6" style="display: flex; border-bottom: 1px solid rgba(0,0,0,0.05); gap: 24px;">
            <button onclick="switchDetailTab('info')" id="tabBtnInfo" style="padding-bottom: 12px; border: none; border-bottom: 2px solid transparent; font-size: 13px; font-weight: 700; background: transparent; cursor: pointer;">Product Info</button>
            <button onclick="switchDetailTab('suppliers')" id="tabBtnSuppliers" style="padding-bottom: 12px; border: none; border-bottom: 2px solid transparent; font-size: 13px; font-weight: 700; background: transparent; cursor: pointer;">Suppliers</button>
            <button onclick="switchDetailTab('analytics')" id="tabBtnAnalytics" style="padding-bottom: 12px; border: none; border-bottom: 2px solid transparent; font-size: 13px; font-weight: 700; background: transparent; cursor: pointer;">Analytics</button>
        </div>

        <!-- Product Info Content -->
        <div id="tabContentInfo" class="flex-col gap-6" style="display: flex; flex-direction: column; gap: 24px;">
            <div class="flex flex-col border border-black/5 rounded-xl overflow-hidden" style="display: flex; flex-direction: column; border: 1px solid rgba(0,0,0,0.05); border-radius: 12px; overflow: hidden;">
                <div class="flex items-center justify-between p-3.5 border-b border-black/5 bg-gray-50/50" style="display: flex; justify-content: space-between; align-items: center; padding: 14px; border-bottom: 1px solid rgba(0,0,0,0.05); background-color: #FAFAFA;">
                    <span class="text-[12px] font-bold text-gray-500" style="font-size: 12px; font-weight: 700; color: #8B8E97;">Product Price</span>
                    <span id="detailProductPrice" class="text-[13px] font-bold text-black" style="font-size: 13px; font-weight: 700; color: #000000;"></span>
                </div>
                <div class="flex items-center justify-between p-3.5 border-b border-black/5 bg-gray-50/50" style="display: flex; justify-content: space-between; align-items: center; padding: 14px; border-bottom: 1px solid rgba(0,0,0,0.05); background-color: #FAFAFA;">
                    <span class="text-[12px] font-bold text-gray-500" style="font-size: 12px; font-weight: 700; color: #8B8E97;">Current Stock</span>
                    <span id="detailCurrentStock" class="text-[13px] font-bold text-black" style="font-size: 13px; font-weight: 700; color: #000000;"></span>
                </div>
                <div class="flex items-center justify-between p-3.5 bg-gray-50/50" style="display: flex; justify-content: space-between; align-items: center; padding: 14px; background-color: #FAFAFA;">
                    <span class="text-[12px] font-bold text-gray-500" style="font-size: 12px; font-weight: 700; color: #8B8E97;">Stock Alert</span>
                    <span id="detailStockAlert" class="text-[13px] font-bold text-black" style="font-size: 13px; font-weight: 700; color: #000000;"></span>
                </div>
            </div>
            <div class="flex flex-col gap-2" style="display: flex; flex-direction: column; gap: 8px;">
                <h5 class="text-[13px] font-bold text-black m-0" style="font-size: 13px; font-weight: 700; color: #000; margin: 0;">Description</h5>
                <p id="detailDescription" class="text-[12px] text-gray-500 font-medium leading-relaxed m-0" style="font-size: 12px; color: #8B8E97; line-height: 1.6; margin: 0; font-weight: 500;"></p>
            </div>
            <div id="detailAiPromptContainer" class="flex flex-col gap-3" style="display: none; flex-direction: column; gap: 12px;">
                <div class="flex items-center justify-between" style="display: flex; justify-content: space-between; align-items: center;">
                    <h5 class="text-[13px] font-bold text-black m-0" style="font-size: 13px; font-weight: 700; color: #000; margin: 0;">Suggested AI Prompt</h5>
                    <span class="text-[10px] font-extrabold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full uppercase tracking-wider" style="font-size: 8px; font-weight: 800; color: #1D38FF; background-color: #E8F0FE; padding: 2px 8px; border-radius: 100px;">Vern AI</span>
                </div>
                <div class="relative p-4 rounded-xl border border-black/5 bg-gray-50/50 flex flex-col" style="position: relative; padding: 16px; border-radius: 12px; border: 1px solid rgba(0,0,0,0.05); background-color: #FAFAFA; display: flex; flex-direction: column;">
                    <button onclick="copyAiPrompt()" class="flex items-center gap-1.5 bg-white border border-black/5 hover:bg-gray-50 text-[11px] font-bold text-gray-600 px-3 py-1.5 rounded-lg cursor-pointer transition-all outline-none" style="position: absolute; top: 16px; right: 16px; border: 1px solid rgba(0,0,0,0.08); background-color: #fff; padding: 6px 12px; border-radius: 8px; display: flex; align-items: center; gap: 6px; cursor: pointer;">
                        <iconify-icon icon="solar:copy-linear" width="14" height="14" style="color: #8B8E97;"></iconify-icon>
                        <span style="font-size: 11px; font-weight: 700; color: #8B8E97;">Copy</span>
                    </button>
                    <pre id="detailAiPromptText" class="text-[11px] text-gray-500 font-medium leading-relaxed whitespace-pre-wrap m-0" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; color: #8B8E97; line-height: 1.6; margin: 0; padding-right: 64px; font-weight: 500;"></pre>
                </div>
                <div class="flex items-center gap-2.5 px-4 py-3 rounded-lg border border-blue-100" style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 10px; background-color: #E8F0FE; border: 1px solid #1D38FF;">
                    <iconify-icon icon="material-symbols:info-rounded" class="text-[#1D38FF]" width="16" height="16" style="flex-shrink: 0;"></iconify-icon>
                    <span class="text-[11px] font-bold text-black" style="font-size: 11px; font-weight: 700; color: #000000;">Use this prompt in your AI tool to get restocking recommendations</span>
                </div>
            </div>
        </div>

        <!-- Suppliers Tab Content -->
        <div id="tabContentSuppliers" class="flex-col gap-4" style="display: none; flex-direction: column; gap: 16px;">
            <div class="p-4 border border-black/5 rounded-xl bg-gray-50/50" style="padding: 16px; border: 1px solid rgba(0,0,0,0.05); border-radius: 12px; background-color: #FAFAFA;">
                <h5 class="text-[13px] font-bold text-black mb-2" style="margin: 0 0 8px 0; font-size: 13px; font-weight: 700;">Primary Supplier</h5>
                <div class="flex flex-col gap-1 text-[12px] font-medium text-gray-500" style="display: flex; flex-direction: column; gap: 4px; font-size: 12px; color: #8B8E97; font-weight: 500;">
                    <span>Name: PT. Pangan Mandiri Jaya</span>
                    <span>Lead Time: 3-5 days</span>
                    <span>Minimum Order: 50 Box</span>
                </div>
            </div>
        </div>

        <!-- Analytics Tab Content -->
        <div id="tabContentAnalytics" class="flex-col gap-4" style="display: none; flex-direction: column; gap: 16px;">
            <div class="p-4 border border-black/5 rounded-xl bg-gray-50/50" style="padding: 16px; border: 1px solid rgba(0,0,0,0.05); border-radius: 12px; background-color: #FAFAFA;">
                <h5 class="text-[13px] font-bold text-black mb-2" style="margin: 0 0 8px 0; font-size: 13px; font-weight: 700;">Sales Forecast</h5>
                <div class="flex flex-col gap-1 text-[12px] font-medium text-gray-500" style="display: flex; flex-direction: column; gap: 4px; font-size: 12px; color: #8B8E97; font-weight: 500;">
                    <span>Predicted demand next month: +15%</span>
                    <span>Recommended safety stock: 12 Box</span>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endpush

