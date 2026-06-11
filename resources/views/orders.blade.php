@extends('layouts.dashboard')

@section('title', 'Pesanan - Vern Dashboard')
@section('page_title', 'Pesanan')

@section('content')
<div class="bg-white rounded-[20px] p-8 border border-black/5 shadow-sm">
    <!-- Header Row -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-[18px] font-bold text-black tracking-[-2%]">Pesanan</h2>
        
        <div class="flex items-center gap-6">
            <!-- Add Transaction Button -->
            <button onclick="openTransactionModal()" class="flex items-center gap-2 bg-[#0077FF] hover:bg-[#0062D1] text-white px-5 py-3 rounded-[12px] text-sm font-bold transition-all shadow-sm shadow-[#0077FF]/20 cursor-pointer">
                <iconify-icon icon="material-symbols:add-rounded" width="20" height="20"></iconify-icon>
                <span>Tambah Transaksi</span>
            </button>
        </div>
    </div>

    <!-- Filter & Search Controls -->
    <div class="flex items-center justify-between gap-4 mb-6">
        <!-- Left: Filters -->
        <div class="flex items-center gap-3">
            <button id="btnFilterOrdersAll" onclick="selectOrdersStatusFilter('all')" class="text-[13px] font-bold text-[#0077FF] bg-[#0077FF]/5 border border-[#0077FF]/20 transition-all cursor-pointer shadow-sm" style="padding: 6px 16px; border-radius: 8px;">
                <span>Filter</span>
            </button>

            <button id="btnFilterStatusPembayaran" onclick="cycleStatusFilter()" class="text-[13px] font-semibold text-[#8B8E97] bg-white hover:bg-gray-50 transition-all cursor-pointer shadow-sm" style="padding: 6px 16px; border: 1px solid rgba(0,0,0,0.08); border-radius: 8px; display: flex; align-items: center; gap: 6px;">
                <span>Status Pembayaran</span>
            </button>

            <button id="btnFilterTanggal" onclick="toggleDateSorting()" class="text-[13px] font-semibold text-[#8B8E97] bg-white hover:bg-gray-50 transition-all cursor-pointer shadow-sm" style="padding: 6px 16px; border: 1px solid rgba(0,0,0,0.08); border-radius: 8px; display: flex; align-items: center; gap: 6px;">
                <span>Tanggal Order</span>
                <iconify-icon id="sortDateIcon" icon="solar:sort-vertical-linear" width="14" height="14" style="color: #8B8E97;"></iconify-icon>
            </button>
        </div>

        <!-- Right: Search Input -->
        <div style="position: relative; display: flex; align-items: center; width: 280px; height: 38px; background-color: #F1F3F6; border-radius: 10px; padding: 0 14px; gap: 8px;">
            <iconify-icon icon="solar:magnifer-linear" width="18" height="18" class="text-black" style="flex-shrink: 0;"></iconify-icon>
            <input 
                id="ordersSearchInput"
                type="text" 
                placeholder="Cari" 
                class="placeholder:text-[#8B8E97]"
                style="width: 100%; height: 100%; background: transparent; border: none; outline: none; font-size: 13px; font-weight: 600; color: #000000; padding: 0;"
                oninput="applyOrdersFilters()"
            />
        </div>
    </div>

    <!-- Custom CSS for Orders Table -->
    <style>
        .orders-table {
            width: 100%;
            border-collapse: separate !important;
            border-spacing: 0 !important;
            border: none !important;
        }
        .orders-table th {
            border: none !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
            color: #1A1D1F !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            padding: 12px 16px !important;
            background-color: #FFFFFF !important;
            text-align: left;
        }
        .orders-table td {
            border: none !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
            padding: 16px 16px !important;
            vertical-align: middle !important;
            color: #1A1D1F !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            background-color: #FFFFFF !important;
        }
        .orders-table tr:hover td {
            background-color: #F8F9FB !important;
        }

        /* Status Pills matching Lunas/Belum Lunas colors */
        .status-lunas {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 4px 12px !important;
            border-radius: 100px !important;
            font-size: 11px !important;
            font-weight: 700 !important;
            color: #10B981 !important;
            background-color: #E8FDF5 !important;
            border: 1px solid #A7F3D0 !important;
            white-space: nowrap !important;
        }
        .status-belum-lunas {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 4px 12px !important;
            border-radius: 100px !important;
            font-size: 11px !important;
            font-weight: 700 !important;
            color: #FF4D4D !important;
            background-color: #FFF5F5 !important;
            border: 1px solid #FEE2E2 !important;
            white-space: nowrap !important;
        }

        .lihat-detail-btn {
            color: #0077FF !important;
            font-weight: 700 !important;
            font-size: 13px !important;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: color 0.2s;
        }
        .lihat-detail-btn:hover {
            color: #0056b3 !important;
            text-decoration: underline;
        }
    </style>

    <!-- Orders Data Table -->
    <div style="overflow-x: auto; position: relative;">
        <table class="orders-table">
            <thead>
                <tr>
                    <th style="width: 48px; min-width: 48px; padding-left: 24px !important;">
                        <input type="checkbox" class="w-4 h-4 rounded border-black/10 text-[#0077FF] focus:ring-[#0077FF] cursor-pointer" />
                    </th>
                    <th style="min-width: 150px;">
                        <div class="flex items-center gap-1 cursor-pointer">
                            <span>ID Pesanan</span>
                            <iconify-icon icon="tabler:arrows-sort" width="14" height="14" class="text-black/30"></iconify-icon>
                        </div>
                    </th>
                    <th style="min-width: 150px;">
                        <div class="flex items-center gap-1 cursor-pointer">
                            <span>Total Pesanan</span>
                            <iconify-icon icon="tabler:arrows-sort" width="14" height="14" class="text-black/30"></iconify-icon>
                        </div>
                    </th>
                    <th style="min-width: 130px;">
                        <div class="flex items-center gap-1 cursor-pointer">
                            <span>Status</span>
                            <iconify-icon icon="tabler:arrows-sort" width="14" height="14" class="text-black/30"></iconify-icon>
                        </div>
                    </th>
                    <th style="min-width: 180px;">
                        <div class="flex items-center gap-1 cursor-pointer">
                            <span>Pelanggan</span>
                            <iconify-icon icon="tabler:arrows-sort" width="14" height="14" class="text-black/30"></iconify-icon>
                        </div>
                    </th>
                    <th style="min-width: 180px;">
                        <div class="flex items-center gap-1 cursor-pointer">
                            <span>Tanggal Order</span>
                            <iconify-icon icon="tabler:arrows-sort" width="14" height="14" class="text-black/30"></iconify-icon>
                        </div>
                    </th>
                    <th style="min-width: 100px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td style="padding-left: 24px !important;">
                        <input type="checkbox" class="w-4 h-4 rounded border-black/10 text-[#0077FF] focus:ring-[#0077FF] cursor-pointer" />
                    </td>
                    <td class="font-bold text-black">{{ $order->order_id }}</td>
                    <td class="font-semibold text-black">Rp. {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td>
                        @if (strtolower($order->status) === 'lunas')
                            <span class="status-lunas">
                                <span>Lunas</span>
                            </span>
                        @else
                            <span class="status-belum-lunas">
                                <span>Belum Lunas</span>
                            </span>
                        @endif
                    </td>
                    <td class="text-gray-700 font-semibold">{{ $order->customer_name }}</td>
                    <td class="text-gray-500 font-medium" data-date="{{ $order->order_date }}">
                        {{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('d F Y') }}
                    </td>
                    <td style="text-align: center;">
                        @php
                            $itemsData = [];
                            foreach ($order->items as $item) {
                                $itemsData[] = [
                                    'product_name' => $item->variant->product->name ?? 'Produk Tidak Dikenal',
                                    'variant_name' => $item->variant->variant_name ?? '',
                                    'image_path' => $item->variant->product->image_path ?? null,
                                    'price' => (float)$item->price,
                                    'qty' => (int)$item->qty,
                                    'subtotal' => (float)$item->subtotal,
                                    'unit' => $item->variant->variant_unit ?? 'pcs',
                                    'sku' => $item->variant->sku ?? '-'
                                ];
                            }
                            $orderData = [
                                'order_id' => $order->order_id,
                                'customer_name' => $order->customer_name,
                                'total_amount' => (float)$order->total_amount,
                                'status' => $order->status,
                                'order_date' => \Carbon\Carbon::parse($order->order_date)->translatedFormat('d F Y'),
                                'items' => $itemsData
                            ];
                        @endphp
                        <button class="lihat-detail-btn" onclick="openOrderDetailModal({{ json_encode($orderData) }})">Lihat Detail</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    <div class="flex items-center justify-end gap-4 mt-6 pt-4 border-t border-black/5">
        <span class="text-[12px] font-semibold text-[#8B8E97]">Menampilkan Halaman 1 dari 3</span>
        <div class="flex items-center gap-2">
            <button class="w-8 h-8 flex items-center justify-center border border-black/10 rounded-[6px] text-gray-400 bg-white hover:bg-gray-50 transition-all cursor-not-allowed" disabled>
                <iconify-icon icon="solar:alt-arrow-left-linear" width="16" height="16"></iconify-icon>
            </button>
            <button class="w-8 h-8 flex items-center justify-center border border-[#0077FF]/20 rounded-[6px] text-[#0077FF] bg-[#0077FF]/5 font-bold text-[13px] transition-all cursor-pointer">
                1
            </button>
            <button class="w-8 h-8 flex items-center justify-center bg-[#0077FF] rounded-[6px] text-white shadow-sm shadow-[#0077FF]/20 hover:bg-[#0062D1] transition-all cursor-pointer">
                <iconify-icon icon="solar:alt-arrow-right-linear" width="16" height="16"></iconify-icon>
            </button>
        </div>
    </div>
</div>

<script>
    let activeOrderStatusFilter = 'all'; // 'all', 'lunas', 'belum lunas'
    let activeDateSortOrder = 'desc'; // 'desc', 'asc'

    function selectOrdersStatusFilter(status) {
        activeOrderStatusFilter = status;
        
        const btnAll = document.getElementById('btnFilterOrdersAll');
        const btnStatus = document.getElementById('btnFilterStatusPembayaran');
        
        if (status === 'all') {
            btnAll.className = "text-[13px] font-bold text-[#0077FF] bg-[#0077FF]/5 border border-[#0077FF]/20 transition-all cursor-pointer shadow-sm";
            btnAll.style.border = "";
            btnStatus.innerHTML = `<span>Status Pembayaran</span>`;
            btnStatus.style.backgroundColor = "#FFFFFF";
            btnStatus.style.color = "#8B8E97";
            btnStatus.style.borderColor = "rgba(0,0,0,0.08)";
        } else if (status === 'lunas') {
            btnAll.className = "text-[13px] font-semibold text-[#8B8E97] bg-white hover:bg-gray-50 transition-all cursor-pointer shadow-sm";
            btnAll.style.border = "1px solid rgba(0,0,0,0.08)";
            btnStatus.innerHTML = `<span>Status: Lunas</span>`;
            btnStatus.style.backgroundColor = "#E8FDF5";
            btnStatus.style.color = "#10B981";
            btnStatus.style.borderColor = "#A7F3D0";
        } else if (status === 'belum lunas') {
            btnAll.className = "text-[13px] font-semibold text-[#8B8E97] bg-white hover:bg-gray-50 transition-all cursor-pointer shadow-sm";
            btnAll.style.border = "1px solid rgba(0,0,0,0.08)";
            btnStatus.innerHTML = `<span>Status: Belum Lunas</span>`;
            btnStatus.style.backgroundColor = "#FFF5F5";
            btnStatus.style.color = "#FF4D4D";
            btnStatus.style.borderColor = "#FEE2E2";
        }
        
        applyOrdersFilters();
    }

    function cycleStatusFilter() {
        if (activeOrderStatusFilter === 'all') {
            selectOrdersStatusFilter('lunas');
        } else if (activeOrderStatusFilter === 'lunas') {
            selectOrdersStatusFilter('belum lunas');
        } else {
            selectOrdersStatusFilter('all');
        }
    }

    function toggleDateSorting() {
        activeDateSortOrder = activeDateSortOrder === 'desc' ? 'asc' : 'desc';
        
        const btnDate = document.getElementById('btnFilterTanggal');
        const sortIcon = document.getElementById('sortDateIcon');
        
        if (activeDateSortOrder === 'asc') {
            btnDate.style.backgroundColor = "#EEF6FF";
            btnDate.style.color = "#0077FF";
            btnDate.style.borderColor = "#BFDBFE";
            sortIcon.style.color = "#0077FF";
            sortIcon.setAttribute('icon', 'solar:sort-from-top-to-bottom-linear');
        } else {
            btnDate.style.backgroundColor = "#FFFFFF";
            btnDate.style.color = "#8B8E97";
            btnDate.style.borderColor = "rgba(0,0,0,0.08)";
            sortIcon.style.color = "#8B8E97";
            sortIcon.setAttribute('icon', 'solar:sort-from-bottom-to-top-linear');
        }
        
        sortOrdersTable();
    }

    let ordersCurrentPage = 1;
    const ordersPerPage = 10;
    let ordersFilteredRows = [];

    function setupOrdersPagination() {
        const tbody = document.querySelector('.orders-table tbody');
        if (!tbody) return;
        
        const allRows = Array.from(tbody.querySelectorAll('tr'));
        ordersFilteredRows = allRows.filter(row => row.dataset.filteredOut !== 'true');
        
        const totalRows = ordersFilteredRows.length;
        const totalPages = Math.max(1, Math.ceil(totalRows / ordersPerPage));
        
        if (ordersCurrentPage > totalPages) {
            ordersCurrentPage = totalPages;
        }
        if (ordersCurrentPage < 1) {
            ordersCurrentPage = 1;
        }
        
        const start = (ordersCurrentPage - 1) * ordersPerPage;
        const end = start + ordersPerPage;
        
        allRows.forEach(row => {
            row.style.display = 'none';
        });
        
        ordersFilteredRows.forEach((row, index) => {
            if (index >= start && index < end) {
                row.style.display = '';
            }
        });
        
        renderOrdersPaginationControls(totalPages, totalRows);
    }

    function renderOrdersPaginationControls(totalPages, totalRows) {
        const table = document.querySelector('.orders-table');
        if (!table) return;
        const footer = table.parentNode.nextElementSibling;
        if (!footer) return;
        
        const showStart = totalRows === 0 ? 0 : (ordersCurrentPage - 1) * ordersPerPage + 1;
        const showEnd = Math.min(ordersCurrentPage * ordersPerPage, totalRows);
        
        footer.innerHTML = `
            <span class="text-[12px] font-semibold text-[#8B8E97]">Menampilkan ${showStart}-${showEnd} dari ${totalRows} data</span>
            <div class="flex items-center gap-2">
                <button onclick="changeOrdersPage(-1)" ${ordersCurrentPage === 1 ? 'disabled style="cursor: not-allowed; opacity: 0.5;"' : 'style="cursor: pointer;"'} class="w-8 h-8 flex items-center justify-center border border-black/10 rounded-[6px] text-gray-400 bg-white hover:bg-gray-50 transition-all border-0">
                    <iconify-icon icon="solar:alt-arrow-left-linear" width="16" height="16"></iconify-icon>
                </button>
                <span class="text-[12px] font-bold text-[#0077FF] bg-[#0077FF]/5 px-3 py-1 rounded-[6px] border border-[#0077FF]/10">${ordersCurrentPage} / ${totalPages}</span>
                <button onclick="changeOrdersPage(1)" ${ordersCurrentPage === totalPages ? 'disabled style="cursor: not-allowed; opacity: 0.5;"' : 'style="cursor: pointer;"'} class="w-8 h-8 flex items-center justify-center bg-[#0077FF] rounded-[6px] text-white shadow-sm shadow-[#0077FF]/20 hover:bg-[#0062D1] transition-all border-0">
                    <iconify-icon icon="solar:alt-arrow-right-linear" width="16" height="16"></iconify-icon>
                </button>
            </div>
        `;
    }

    function changeOrdersPage(direction) {
        ordersCurrentPage += direction;
        setupOrdersPagination();
    }

    function applyOrdersFilters() {
        const query = document.getElementById('ordersSearchInput').value.toLowerCase().trim();
        const tbody = document.querySelector('.orders-table tbody');
        if (!tbody) return;
        
        const rows = Array.from(tbody.querySelectorAll('tr'));
        
        rows.forEach(row => {
            const orderIdEl = row.querySelector('td:nth-child(2)');
            const customerEl = row.querySelector('td:nth-child(5)');
            const statusEl = row.querySelector('td:nth-child(4) span');
            
            const orderId = orderIdEl ? orderIdEl.textContent.toLowerCase() : '';
            const customer = customerEl ? customerEl.textContent.toLowerCase() : '';
            const statusText = statusEl ? statusEl.textContent.toLowerCase().trim() : '';
            
            const matchesSearch = orderId.includes(query) || customer.includes(query);
            const matchesFilter = (activeOrderStatusFilter === 'all' || statusText === activeOrderStatusFilter);
            
            if (matchesSearch && matchesFilter) {
                row.dataset.filteredOut = 'false';
            } else {
                row.dataset.filteredOut = 'true';
            }
        });
        
        ordersCurrentPage = 1;
        setupOrdersPagination();
    }

    function sortOrdersTable() {
        const tbody = document.querySelector('.orders-table tbody');
        if (!tbody) return;
        
        const rows = Array.from(tbody.querySelectorAll('tr'));
        
        rows.sort((a, b) => {
            const dateAEl = a.querySelector('td[data-date]');
            const dateBEl = b.querySelector('td[data-date]');
            if (!dateAEl || !dateBEl) return 0;
            
            const dateA = new Date(dateAEl.getAttribute('data-date'));
            const dateB = new Date(dateBEl.getAttribute('data-date'));
            
            if (activeDateSortOrder === 'asc') {
                return dateA - dateB;
            } else {
                return dateB - dateA;
            }
        });
        
        rows.forEach(row => tbody.appendChild(row));
        setupOrdersPagination();
    }

    function showToast(message, type = 'success') {
        let toast = document.getElementById('custom-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'custom-toast';
            toast.style.position = 'fixed';
            toast.style.bottom = '24px';
            toast.style.right = '24px';
            toast.style.padding = '12px 24px';
            toast.style.borderRadius = '12px';
            toast.style.color = '#FFFFFF';
            toast.style.fontWeight = '700';
            toast.style.fontSize = '13px';
            toast.style.zIndex = '99999';
            toast.style.boxShadow = '0 10px 25px -5px rgba(0,0,0,0.1)';
            toast.style.transition = 'all 0.3s ease';
            document.body.appendChild(toast);
        }
        
        toast.textContent = message;
        if (type === 'success') {
            toast.style.backgroundColor = '#10B981';
        } else {
            toast.style.backgroundColor = '#EF4444';
        }
        
        toast.style.opacity = '1';
        toast.style.transform = 'translateY(0)';
        
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(10px)';
        }, 3000);
    }
</script>

<!-- Add New Transaction Modal Backdrop -->
<div id="addTransactionModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="z-index: 9999; background-color: rgba(0, 0, 0, 0.4); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); display: none; opacity: 0; transition: opacity 0.3s ease;">
    @csrf
    <!-- Modal Container -->
    <div class="bg-white rounded-[24px] shadow-2xl w-full max-w-[650px] relative transform scale-95 opacity-0 transition-all duration-300" id="txModalContainer" style="padding: 32px; background-color: #FFFFFF; border-radius: 24px; box-sizing: border-box; max-height: 90vh; display: flex; flex-direction: column; overflow: hidden;">
        <!-- Close Button -->
        <button onclick="closeTransactionModal()" class="w-8 h-8 flex items-center justify-center rounded-full bg-[#F1F3F6] hover:bg-gray-200 transition-all cursor-pointer text-gray-600 hover:text-black border-0" style="position: absolute; top: 32px; right: 32px; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; padding: 0; outline: none; z-index: 10;">
            <iconify-icon icon="material-symbols:close-rounded" width="20" height="20"></iconify-icon>
        </button>

        <!-- Header: Title and Stepper -->
        <div class="flex items-center justify-between mb-4" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; flex-shrink: 0; padding-right: 40px;">
            <div style="display: flex; align-items: center; gap: 24px;">
                <h3 id="txModalTitleText" style="font-size: 20px; font-weight: 700; margin: 0; color: #000000; font-family: 'Plus Jakarta Sans', sans-serif;">Transaksi Baru</h3>
                <!-- Stepper -->
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div id="txStepCircle1" style="width: 24px; height: 24px; border-radius: 50%; background-color: #0077FF; color: #FFFFFF; font-size: 12px; font-weight: 700; display: flex; align-items: center; justify-content: center; transition: all 0.3s;">1</div>
                    <div style="width: 24px; height: 1px; background-color: #E5E7EB;"></div>
                    <div id="txStepCircle2" style="width: 24px; height: 24px; border-radius: 50%; background-color: #F1F3F6; color: #8B8E97; font-size: 12px; font-weight: 700; display: flex; align-items: center; justify-content: center; transition: all 0.3s;">2</div>
                    <div style="width: 24px; height: 1px; background-color: #E5E7EB;"></div>
                    <div id="txStepCircle3" style="width: 24px; height: 24px; border-radius: 50%; background-color: #F1F3F6; color: #8B8E97; font-size: 12px; font-weight: 700; display: flex; align-items: center; justify-content: center; transition: all 0.3s;">3</div>
                </div>
            </div>
        </div>

        <!-- Progress Indicator Bar -->
        <div style="width: 100%; height: 4px; background-color: #FAFAFA; border-radius: 2px; margin-bottom: 24px; overflow: hidden; position: relative; flex-shrink: 0;">
            <div id="txModalProgressBar" style="width: 33%; height: 100%; background-color: #0077FF; border-radius: 2px; transition: all 0.3s;"></div>
        </div>

        <!-- Scrollable Form Container -->
        <div class="premium-scrollbar" style="flex: 1; overflow-y: auto; padding-right: 8px; min-height: 0;">
            
            <!-- STEP 1: Customer Details -->
            <div id="txStep1Content" style="display: flex; flex-direction: column; gap: 20px;">
                <div>
                    <h4 style="font-size: 11px; font-weight: 700; color: #8B8E97; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 16px 0; font-family: 'Plus Jakarta Sans', sans-serif;">Informasi Pelanggan</h4>
                    <p style="font-size: 12px; color: #8B8E97; margin: 0 0 20px 0; line-height: 1.4;">Tambahkan data customer untuk mempermudah pencatatan transaksi dan histori pembelian.</p>
                    
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
                        <div style="display: flex; flex-direction: column;">
                            <label style="font-size: 12px; font-weight: 700; color: #000000; margin-bottom: 6px;">Nama Pelanggan</label>
                            <input type="text" id="txCustomerName" placeholder="Nama Pelanggan" style="width: 100%; height: 42px; background-color: #F1F3F6; border: 1px solid transparent; border-radius: 10px; padding: 12px 16px; font-size: 13px; font-weight: 500; color: #000000; outline: none; box-sizing: border-box; transition: all 0.2s;" />
                            <span id="txCustomerNameError" style="color: #FF4D4D; font-size: 10px; font-weight: 600; display: none; margin-top: 4px;"></span>
                        </div>
                        <div style="display: flex; flex-direction: column;">
                            <label style="font-size: 12px; font-weight: 700; color: #000000; margin-bottom: 6px;">No. Handphone</label>
                            <input type="text" id="txCustomerPhone" placeholder="No. Handphone" style="width: 100%; height: 42px; background-color: #F1F3F6; border: 1px solid transparent; border-radius: 10px; padding: 12px 16px; font-size: 13px; font-weight: 500; color: #000000; outline: none; box-sizing: border-box; transition: all 0.2s;" />
                            <span id="txCustomerPhoneError" style="color: #FF4D4D; font-size: 10px; font-weight: 600; display: none; margin-top: 4px;"></span>
                        </div>
                    </div>
                </div>
                
                <!-- Action Footer -->
                <div style="display: flex; justify-content: flex-end; margin-top: 24px; padding-top: 16px; border-t: 1px solid rgba(0,0,0,0.05);">
                    <button onclick="validateAndGoToStep2()" class="transition-all cursor-pointer hover:bg-gray-800" style="background-color: #000000; color: #FFFFFF; font-size: 13px; font-weight: 700; padding: 12px 32px; border: none; border-radius: 100px; display: flex; align-items: center; gap: 8px; outline: none;">
                        <span>Pilih Produk</span>
                        <iconify-icon icon="solar:alt-arrow-right-linear" width="16" height="16" style="margin-top: 1px;"></iconify-icon>
                    </button>
                </div>
            </div>

            <!-- STEP 2: Cart & Selection -->
            <div id="txStep2Content" style="display: none; flex-direction: column; gap: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; background: rgba(0, 119, 255, 0.03); padding: 16px 20px; border-radius: 16px; border: 1px dashed rgba(0, 119, 255, 0.15);">
                    <div>
                        <h4 style="font-size: 13px; font-weight: 800; color: #000000; margin: 0 0 2px 0; font-family: 'Plus Jakarta Sans', sans-serif; tracking: -0.01em;">List Produk</h4>
                        <p style="font-size: 11px; color: #8B8E97; margin: 0; line-height: 1.4; font-weight: 500;">Pilih produk dan tentukan jumlah item untuk transaksi ini.</p>
                    </div>
                    <button onclick="showProductSelection()" class="bg-[#0077FF]/10 hover:bg-[#0077FF]/20 text-[#0077FF] hover:text-[#0062D1] text-xs font-bold px-4 py-2.5 rounded-[12px] border border-[#0077FF]/20 cursor-pointer transition-all flex items-center gap-1.5 shadow-sm shadow-[#0077FF]/5">
                        <iconify-icon icon="solar:add-square-linear" width="16" height="16"></iconify-icon>
                        <span>Tambah Produk</span>
                    </button>
                </div>

                <!-- Empty State -->
                <div id="cartEmptyState" style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 48px 24px; text-align: center; gap: 16px; background: #F8FAFC; border-radius: 20px; border: 1px solid rgba(0,0,0,0.02);">
                    <div style="width: 100px; height: 100px; border-radius: 30px; background: linear-gradient(135deg, #FFF5F5 0%, #FFF0F0 100%); display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px -6px rgba(255, 77, 77, 0.15);">
                        <iconify-icon icon="solar:cart-large-minimalistic-broken" width="44" height="44" style="color: #FF4D4D;"></iconify-icon>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 4px;">
                        <span style="font-size: 14px; font-weight: 800; color: #1A1D1F;">Keranjang Belanja Kosong</span>
                        <span style="font-size: 12px; color: #8B8E97; font-weight: 500;">Belum ada produk yang ditambahkan ke transaksi ini.</span>
                    </div>
                    <button onclick="showProductSelection()" class="bg-black hover:bg-gray-800 text-white text-xs font-bold px-6 py-2.5 rounded-full cursor-pointer transition-all border-none shadow-md shadow-black/10 flex items-center gap-1">
                        <span>Pilih Produk Sekarang</span>
                        <iconify-icon icon="solar:arrow-right-up-linear" width="14" height="14"></iconify-icon>
                    </button>
                </div>

                <!-- Cart Items Wrapper -->
                <div id="cartItemsWrapper" style="display: none; flex-direction: column; gap: 12px; max-height: 280px; overflow-y: auto; padding-right: 4px;" class="premium-scrollbar">
                    <!-- Inserted via JS -->
                </div>

                <!-- Sub-Panel: Product Selection Overlay List (Slide overlay within modal) -->
                <div id="productSelectionPanel" style="display: none; flex-direction: column; gap: 16px; border: 1px solid rgba(0,0,0,0.05); border-radius: 20px; padding: 20px; background: rgba(255, 255, 255, 0.75); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); box-shadow: 0 12px 30px -10px rgba(0,0,0,0.05);">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <iconify-icon icon="solar:box-linear" width="18" height="18" style="color: #0077FF;"></iconify-icon>
                            <span style="font-size: 13.5px; font-weight: 800; color: #000000;">Katalog Produk Gudang</span>
                        </div>
                        <button onclick="hideProductSelection()" style="background: rgba(255, 77, 77, 0.08); border: none; color: #FF4D4D; padding: 5px 12px; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 11px; transition: all 0.2s;">Batal</button>
                    </div>
                    
                    <!-- Cari Produk Search -->
                    <div style="position: relative; display: flex; align-items: center; width: 100%; height: 42px; background-color: #F1F3F6; border-radius: 12px; padding: 0 14px; gap: 8px; box-sizing: border-box; border: 1px solid transparent; transition: all 0.2s;" onfocusin="this.style.borderColor='#0077FF'; this.style.backgroundColor='#FFFFFF'" onfocusout="this.style.borderColor='transparent'; this.style.backgroundColor='#F1F3F6'">
                        <iconify-icon icon="solar:magnifer-linear" width="18" height="18" class="text-gray-400"></iconify-icon>
                        <input 
                            id="txProductSearch"
                            type="text" 
                            placeholder="Cari produk berdasarkan nama atau SKU..." 
                            oninput="filterSelectionProducts()"
                            style="width: 100%; height: 100%; background: transparent; border: none; outline: none; font-size: 13px; font-weight: 600; color: #000000; padding: 0;"
                        />
                    </div>

                    <!-- Products List -->
                    <div id="selectionProductsWrapper" style="display: flex; flex-direction: column; gap: 10px; max-height: 200px; overflow-y: auto; padding-right: 4px;" class="premium-scrollbar">
                        @foreach ($variants as $variant)
                        <div class="selection-product-item flex items-center justify-between p-3 bg-white/80 border border-black/5 rounded-[16px] hover:border-[#0077FF]/20 hover:bg-white hover:shadow-md transition-all duration-300" 
                             data-id="{{ $variant->id }}"
                             data-name="{{ strtolower($variant->product->name . ' ' . $variant->variant_name) }}">
                            <div class="flex items-center gap-3">
                                <img src="{{ $variant->product->image_path ?? 'https://images.unsplash.com/photo-1568254183919-78a4f43a2877?w=100&auto=format&fit=crop&q=60' }}" class="w-12 h-12 rounded-[12px] object-cover border border-black/5" />
                                <div class="flex flex-col gap-0.5">
                                    <span class="font-bold text-[13px] text-black leading-tight">{{ $variant->product->name }} <span class="text-xs text-gray-400 font-semibold">({{ $variant->variant_name }})</span></span>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span class="text-xs text-[#0077FF] font-extrabold">Rp {{ number_format($variant->selling_price, 0, ',', '.') }}</span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold {{ $variant->actual_stock > $variant->min_stock ? 'bg-[#E8FDF5] text-[#10B981] border border-[#A7F3D0]/30' : 'bg-[#FFF5F5] text-[#FF4D4D] border border-[#FEE2E2]/30' }}">
                                            Stok: {{ $variant->actual_stock }} {{ $variant->variant_unit }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <button onclick="addVariantToCart('{{ $variant->id }}', '{{ $variant->variant_name }}', '{{ $variant->product->name }}', {{ $variant->selling_price }}, '{{ $variant->product->image_path }}', {{ $variant->actual_stock }}, '{{ $variant->variant_unit }}')" class="bg-[#0077FF] hover:bg-[#0062D1] hover:shadow-md text-white text-[11px] font-bold px-4 py-2 rounded-full cursor-pointer transition-all border-none shadow-sm shadow-[#0077FF]/10 flex items-center gap-1">
                                <span>Pilih</span>
                                <iconify-icon icon="solar:import-linear" width="12" height="12"></iconify-icon>
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Step 2 Footer Totals & Action -->
                <div id="txStep2Footer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 24px; padding-top: 16px; border-top: 1px solid rgba(0,0,0,0.05);">
                    <div style="display: flex; flex-direction: column;">
                        <span style="font-size: 11px; font-weight: 700; color: #8B8E97; text-transform: uppercase;">Total Belanja</span>
                        <span id="txCartTotalLabel" style="font-size: 18px; font-weight: 800; color: #000000; font-family: 'Plus Jakarta Sans', sans-serif;">Rp. 0</span>
                    </div>
                    <button onclick="goToStep3()" class="transition-all cursor-pointer hover:bg-gray-800" style="background-color: #000000; color: #FFFFFF; font-size: 13px; font-weight: 700; padding: 12px 32px; border: none; border-radius: 100px; display: flex; align-items: center; gap: 8px; outline: none;">
                        <span>Detail Belanja</span>
                        <iconify-icon icon="solar:alt-arrow-right-linear" width="16" height="16" style="margin-top: 1px;"></iconify-icon>
                    </button>
                </div>
            </div>

            <!-- STEP 3: Summary Order Confirmation -->
            <div id="txStep3Content" style="display: none; flex-direction: column; gap: 20px;">
                <div>
                    <h4 style="font-size: 12px; font-weight: 700; color: #000000; margin: 0 0 4px 0; font-family: 'Plus Jakarta Sans', sans-serif;">Detail Order</h4>
                    <p style="font-size: 11px; color: #8B8E97; margin: 0 0 20px 0; line-height: 1.4;">Periksa dengan seksama order yang telah dibuat beserta informasi pembeli.</p>

                    <!-- Customer Summary Info -->
                    <div style="background-color: #FAFAFA; border-radius: 16px; padding: 16px; border: 1px solid rgba(0,0,0,0.05); display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">
                        <span style="font-size: 11px; font-weight: 800; color: #8B8E97; text-transform: uppercase; tracking-wider: 0.05em;">Informasi Pelanggan</span>
                        <div style="display: flex; flex-direction: column; gap: 4px; font-size: 13px;">
                            <div style="display: flex; justify-content: space-between;"><span style="color: #8B8E97; font-weight: 500;">Nama Pembeli</span><span id="txSummaryName" style="color: #000000; font-weight: 700;"></span></div>
                            <div style="display: flex; justify-content: space-between;"><span style="color: #8B8E97; font-weight: 500;">Nomor Handphone</span><span id="txSummaryPhone" style="color: #000000; font-weight: 700;"></span></div>
                        </div>
                    </div>

                    <!-- Items Summary List -->
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <span style="font-size: 11px; font-weight: 800; color: #8B8E97; text-transform: uppercase; tracking-wider: 0.05em;">Harga dan Qty Barang</span>
                        <div id="txSummaryItemsWrapper" style="display: flex; flex-direction: column; gap: 12px; max-height: 200px; overflow-y: auto;">
                            <!-- Inserted via JS -->
                        </div>
                    </div>
                </div>

                <!-- Step 3 Footer Pay Action -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 24px; padding-top: 16px; border-top: 1px solid rgba(0,0,0,0.05);">
                    <div style="display: flex; flex-direction: column;">
                        <span style="font-size: 11px; font-weight: 700; color: #8B8E97; text-transform: uppercase;">Total Belanja</span>
                        <span id="txSummaryTotalLabel" style="font-size: 18px; font-weight: 800; color: #000000; font-family: 'Plus Jakarta Sans', sans-serif;">Rp. 0</span>
                    </div>
                    <button id="txPayButton" onclick="submitTransaction()" class="transition-all cursor-pointer hover:bg-gray-800" style="background-color: #000000; color: #FFFFFF; font-size: 13px; font-weight: 700; padding: 12px 32px; border: none; border-radius: 100px; display: flex; align-items: center; gap: 8px; outline: none;">
                        <span>Bayar</span>
                        <iconify-icon icon="solar:alt-arrow-right-linear" width="16" height="16" style="margin-top: 1px;"></iconify-icon>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Order Detail Modal Backdrop -->
<div id="orderDetailModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="z-index: 9999; background-color: rgba(0, 0, 0, 0.4); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); display: none; opacity: 0; transition: opacity 0.3s ease;">
    <!-- Modal Container -->
    <div class="bg-white rounded-[24px] shadow-2xl w-full max-w-[600px] relative transform scale-95 opacity-0 transition-all duration-300" id="detailModalContainer" style="padding: 32px; background-color: #FFFFFF; border-radius: 24px; box-sizing: border-box; max-height: 90vh; display: flex; flex-direction: column; overflow: hidden;">
        <!-- Close Button -->
        <button onclick="closeOrderDetailModal()" class="w-8 h-8 flex items-center justify-center rounded-full bg-[#F1F3F6] hover:bg-gray-200 transition-all cursor-pointer text-gray-600 hover:text-black border-0" style="position: absolute; top: 32px; right: 32px; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; padding: 0; outline: none; z-index: 10;">
            <iconify-icon icon="material-symbols:close-rounded" width="20" height="20"></iconify-icon>
        </button>

        <!-- Header: Title -->
        <div class="mb-4" style="flex-shrink: 0; padding-right: 40px;">
            <h3 style="font-size: 20px; font-weight: 700; margin: 0 0 4px 0; color: #000000; font-family: 'Plus Jakarta Sans', sans-serif;">Detail Transaksi</h3>
            <span id="detailOrderId" class="text-xs font-extrabold text-[#0077FF] tracking-wide uppercase"></span>
        </div>

        <div style="height: 1px; background-color: rgba(0,0,0,0.05); margin-bottom: 20px; flex-shrink: 0;"></div>

        <!-- Scrollable content -->
        <div class="premium-scrollbar" style="flex: 1; overflow-y: auto; padding-right: 8px; min-height: 0; display: flex; flex-direction: column; gap: 20px;">
            <!-- Customer Information Card -->
            <div style="background-color: #FAFAFA; border-radius: 16px; padding: 16px; border: 1px solid rgba(0,0,0,0.05); display: flex; flex-direction: column; gap: 10px;">
                <span style="font-size: 11px; font-weight: 800; color: #8B8E97; text-transform: uppercase; tracking-wider: 0.05em;">Informasi Pelanggan</span>
                <div style="display: flex; flex-direction: column; gap: 6px; font-size: 13px;">
                    <div style="display: flex; justify-content: space-between;"><span style="color: #8B8E97; font-weight: 500;">Nama Pelanggan</span><span id="detailCustomerName" style="color: #000000; font-weight: 700;"></span></div>
                    <div style="display: flex; justify-content: space-between;"><span style="color: #8B8E97; font-weight: 500;">Tanggal Order</span><span id="detailOrderDate" style="color: #000000; font-weight: 700;"></span></div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #8B8E97; font-weight: 500;">Status Pembayaran</span>
                        <span id="detailOrderStatus"></span>
                    </div>
                </div>
            </div>

            <!-- Items List -->
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <span style="font-size: 11px; font-weight: 800; color: #8B8E97; text-transform: uppercase; tracking-wider: 0.05em;">Daftar Produk yang Dibeli</span>
                <div id="detailItemsList" style="display: flex; flex-direction: column; gap: 12px;">
                    <!-- Injected dynamically -->
                </div>
            </div>
        </div>

        <div style="height: 1px; background-color: rgba(0,0,0,0.05); margin-top: 20px; margin-bottom: 16px; flex-shrink: 0;"></div>

        <!-- Footer Total -->
        <div style="display: flex; justify-content: space-between; align-items: center; flex-shrink: 0;">
            <div style="display: flex; flex-direction: column;">
                <span style="font-size: 11px; font-weight: 700; color: #8B8E97; text-transform: uppercase;">Total Transaksi</span>
                <span id="detailTotalAmount" style="font-size: 20px; font-weight: 800; color: #000000; font-family: 'Plus Jakarta Sans', sans-serif;"></span>
            </div>
            <button onclick="closeOrderDetailModal()" class="bg-black hover:bg-gray-800 text-white text-xs font-bold px-6 py-3 rounded-full cursor-pointer transition-all border-none shadow-md shadow-black/10">
                Tutup Detail
            </button>
        </div>
    </div>
</div>

<script>
    // Order details functions
    function openOrderDetailModal(order) {
        document.getElementById('detailOrderId').textContent = order.order_id;
        document.getElementById('detailCustomerName').textContent = order.customer_name;
        document.getElementById('detailOrderDate').textContent = order.order_date;

        const statusEl = document.getElementById('detailOrderStatus');
        if (order.status.toLowerCase() === 'lunas') {
            statusEl.className = 'status-lunas';
            statusEl.innerHTML = '<span>Lunas</span>';
        } else {
            statusEl.className = 'status-belum-lunas';
            statusEl.innerHTML = '<span>Belum Lunas</span>';
        }

        const itemsList = document.getElementById('detailItemsList');
        itemsList.innerHTML = '';
        order.items.forEach(item => {
            itemsList.innerHTML += `
                <div class="flex items-center justify-between p-3.5 bg-gray-50 border border-black/5 rounded-[16px]">
                    <div class="flex items-center gap-3">
                        <img src="${item.image_path || 'https://images.unsplash.com/photo-1568254183919-78a4f43a2877?w=100&auto=format&fit=crop&q=60'}" class="w-12 h-12 rounded-[12px] object-cover border border-black/5" />
                        <div class="flex flex-col gap-0.5">
                            <span class="font-bold text-[13px] text-black leading-tight">${item.product_name} <span class="text-xs text-gray-400 font-semibold">(${item.variant_name})</span></span>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="text-xs text-[#8B8E97] font-semibold">SKU: <strong class="text-black">${item.sku}</strong></span>
                                <span class="text-[10px] text-gray-400 font-medium">Rp ${item.price.toLocaleString('id-ID')} x ${item.qty} ${item.unit}</span>
                            </div>
                        </div>
                    </div>
                    <span class="font-extrabold text-sm text-black">Rp ${item.subtotal.toLocaleString('id-ID')}</span>
                </div>
            `;
        });

        document.getElementById('detailTotalAmount').textContent = 'Rp. ' + order.total_amount.toLocaleString('id-ID');

        const modal = document.getElementById('orderDetailModal');
        const container = document.getElementById('detailModalContainer');
        modal.style.display = 'flex';
        modal.offsetHeight;
        modal.style.opacity = '1';
        setTimeout(() => {
            container.classList.remove('scale-95', 'opacity-0');
            container.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeOrderDetailModal() {
        const modal = document.getElementById('orderDetailModal');
        const container = document.getElementById('detailModalContainer');
        container.classList.remove('scale-100', 'opacity-100');
        container.classList.add('scale-95', 'opacity-0');
        modal.style.opacity = '0';
        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
    }

    // Wizard state variables
    let txCurrentStep = 1;
    let txCart = [];

    function openTransactionModal() {
        // Reset states
        txCurrentStep = 1;
        txCart = [];
        document.getElementById('txCustomerName').value = '';
        const phoneInput = document.getElementById('txCustomerPhone');
        phoneInput.value = '';
        
        // Add real-time phone input filtering to restrict non-digits
        if (!phoneInput.dataset.listenerAttached) {
            phoneInput.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
            phoneInput.dataset.listenerAttached = "true";
        }

        clearTxErrors();
        renderCart();

        const modal = document.getElementById('addTransactionModal');
        const container = document.getElementById('txModalContainer');
        modal.style.display = 'flex';
        modal.offsetHeight;
        modal.style.opacity = '1';
        setTimeout(() => {
            container.classList.remove('scale-95', 'opacity-0');
            container.classList.add('scale-100', 'opacity-100');
        }, 10);

        goToTxStep(1);
    }

    function closeTransactionModal() {
        const modal = document.getElementById('addTransactionModal');
        const container = document.getElementById('txModalContainer');
        container.classList.remove('scale-100', 'opacity-100');
        container.classList.add('scale-95', 'opacity-0');
        modal.style.opacity = '0';
        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
    }

    function goToTxStep(step) {
        txCurrentStep = step;
        
        // Update Content visibility
        document.getElementById('txStep1Content').style.display = step === 1 ? 'flex' : 'none';
        document.getElementById('txStep2Content').style.display = step === 2 ? 'flex' : 'none';
        document.getElementById('txStep3Content').style.display = step === 3 ? 'flex' : 'none';
        
        // Update circles
        const c1 = document.getElementById('txStepCircle1');
        const c2 = document.getElementById('txStepCircle2');
        const c3 = document.getElementById('txStepCircle3');
        const bar = document.getElementById('txModalProgressBar');

        c1.style.backgroundColor = '#F1F3F6'; c1.style.color = '#8B8E97';
        c2.style.backgroundColor = '#F1F3F6'; c2.style.color = '#8B8E97';
        c3.style.backgroundColor = '#F1F3F6'; c3.style.color = '#8B8E97';

        if (step === 1) {
            c1.style.backgroundColor = '#0077FF'; c1.style.color = '#FFFFFF';
            bar.style.width = '33%';
        } else if (step === 2) {
            c1.style.backgroundColor = '#0077FF'; c1.style.color = '#FFFFFF';
            c2.style.backgroundColor = '#0077FF'; c2.style.color = '#FFFFFF';
            bar.style.width = '66%';
        } else if (step === 3) {
            c1.style.backgroundColor = '#0077FF'; c1.style.color = '#FFFFFF';
            c2.style.backgroundColor = '#0077FF'; c2.style.color = '#FFFFFF';
            c3.style.backgroundColor = '#0077FF'; c3.style.color = '#FFFFFF';
            bar.style.width = '100%';
            renderSummary();
        }
    }

    function showTxError(id, text) {
        const input = document.getElementById(id);
        const err = document.getElementById(id + 'Error');
        if (input) input.style.border = '1px solid #FF4D4D';
        if (err) {
            err.textContent = text;
            err.style.display = 'block';
        }
    }

    function clearTxErrors() {
        const fields = ['txCustomerName', 'txCustomerPhone'];
        fields.forEach(f => {
            const input = document.getElementById(f);
            const err = document.getElementById(f + 'Error');
            if (input) input.style.border = '';
            if (err) err.style.display = 'none';
        });
    }

    function validateAndGoToStep2() {
        clearTxErrors();
        let isValid = true;
        const name = document.getElementById('txCustomerName').value.trim();
        const phone = document.getElementById('txCustomerPhone').value.trim();

        if (!name) {
            showTxError('txCustomerName', 'Nama customer wajib diisi.');
            isValid = false;
        }
        if (!phone) {
            showTxError('txCustomerPhone', 'Nomor handphone wajib diisi.');
            isValid = false;
        } else if (!/^[0-9]+$/.test(phone)) {
            showTxError('txCustomerPhone', 'Nomor handphone hanya boleh berisi angka.');
            isValid = false;
        } else if (phone.length < 8 || phone.length > 15) {
            showTxError('txCustomerPhone', 'Nomor handphone harus terdiri dari 8-15 digit.');
            isValid = false;
        }

        if (isValid) {
            goToTxStep(2);
        }
    }

    function showProductSelection() {
        document.getElementById('productSelectionPanel').style.display = 'flex';
        document.getElementById('txProductSearch').value = '';
        filterSelectionProducts();
    }

    function hideProductSelection() {
        document.getElementById('productSelectionPanel').style.display = 'none';
    }

    function filterSelectionProducts() {
        const query = document.getElementById('txProductSearch').value.toLowerCase().trim();
        const items = document.querySelectorAll('.selection-product-item');
        items.forEach(item => {
            const name = item.getAttribute('data-name');
            if (name.includes(query)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    }

    function addVariantToCart(id, name, productName, price, img, stock, unit) {
        // Check if already in cart
        const existing = txCart.find(c => c.variant_id === id);
        if (existing) {
            if (existing.qty < stock) {
                existing.qty++;
            } else {
                showToast('Kuantitas melebihi stok yang tersedia!', 'error');
            }
        } else {
            txCart.push({
                variant_id: id,
                variant_name: name,
                product_name: productName,
                price: price,
                image_path: img,
                stock: stock,
                unit: unit,
                qty: 1
            });
        }
        renderCart();
        hideProductSelection();
    }

    function updateCartQty(id, change) {
        const item = txCart.find(c => c.variant_id === id);
        if (!item) return;

        const newQty = item.qty + change;
        if (newQty <= 0) {
            txCart = txCart.filter(c => c.variant_id !== id);
        } else if (newQty > item.stock) {
            showToast('Stok tidak mencukupi!', 'error');
        } else {
            item.qty = newQty;
        }
        renderCart();
    }

    function renderCart() {
        const wrapper = document.getElementById('cartItemsWrapper');
        const empty = document.getElementById('cartEmptyState');
        const totalLabel = document.getElementById('txCartTotalLabel');

        if (txCart.length === 0) {
            wrapper.style.display = 'none';
            empty.style.display = 'flex';
            totalLabel.textContent = 'Rp. 0';
            return;
        }

        empty.style.display = 'none';
        wrapper.style.display = 'flex';

        wrapper.innerHTML = '';
        let total = 0;

        txCart.forEach(item => {
            const subtotal = item.price * item.qty;
            total += subtotal;

            wrapper.innerHTML += `
                <div class="flex items-center justify-between p-3.5 bg-gradient-to-r from-[#F8FAFC]/50 to-white border border-black/5 rounded-[16px] hover:border-[#0077FF]/15 hover:shadow-sm transition-all duration-300">
                    <div class="flex items-center gap-3">
                        <img src="${item.image_path || 'https://images.unsplash.com/photo-1568254183919-78a4f43a2877?w=100&auto=format&fit=crop&q=60'}" class="w-12 h-12 rounded-[12px] object-cover border border-black/5" />
                        <div class="flex flex-col gap-0.5">
                            <span class="font-bold text-[13px] text-black leading-tight">${item.product_name} <span class="text-xs text-[#8B8E97] font-semibold">(${item.variant_name})</span></span>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="text-xs text-[#0077FF] font-extrabold">Rp ${item.price.toLocaleString('id-ID')}</span>
                                <span class="text-[10px] text-[#8B8E97] font-medium">Subtotal: <strong class="text-black">Rp ${subtotal.toLocaleString('id-ID')}</strong></span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="flex items-center border border-black/5 rounded-full overflow-hidden bg-[#F8FAFC] shadow-inner p-0.5">
                            <button onclick="updateCartQty('${item.variant_id}', -1)" class="w-7 h-7 flex items-center justify-center text-gray-500 hover:text-black hover:bg-white rounded-full transition-all border-none bg-transparent cursor-pointer">
                                <iconify-icon icon="ic:round-minus" width="14" height="14"></iconify-icon>
                            </button>
                            <span style="width: 28px; text-align: center; font-size: 13px; font-weight: 700; color: #000;">${item.qty}</span>
                            <button onclick="updateCartQty('${item.variant_id}', 1)" class="w-7 h-7 flex items-center justify-center text-gray-500 hover:text-black hover:bg-white rounded-full transition-all border-none bg-transparent cursor-pointer">
                                <iconify-icon icon="ic:round-plus" width="14" height="14"></iconify-icon>
                            </button>
                        </div>
                        <button onclick="updateCartQty('${item.variant_id}', -${item.qty})" class="text-[#FF4D4D] hover:bg-[#FFF5F5] hover:text-[#D32F2F] transition-all rounded-full border-none cursor-pointer flex items-center justify-center p-2 bg-transparent">
                            <iconify-icon icon="solar:trash-bin-trash-linear" width="16" height="16"></iconify-icon>
                        </button>
                    </div>
                </div>
            `;
        });

        totalLabel.textContent = 'Rp. ' + total.toLocaleString('id-ID');
    }

    function goToStep3() {
        if (txCart.length === 0) {
            showToast('Silakan pilih minimal satu produk terlebih dahulu!', 'error');
            return;
        }
        goToTxStep(3);
    }

    function renderSummary() {
        const name = document.getElementById('txCustomerName').value.trim();
        const phone = document.getElementById('txCustomerPhone').value.trim();
        
        document.getElementById('txSummaryName').textContent = name;
        document.getElementById('txSummaryPhone').textContent = phone;

        const wrapper = document.getElementById('txSummaryItemsWrapper');
        const summaryTotalLabel = document.getElementById('txSummaryTotalLabel');

        wrapper.innerHTML = '';
        let total = 0;

        txCart.forEach(item => {
            const subtotal = item.price * item.qty;
            total += subtotal;

            wrapper.innerHTML += `
                <div class="flex items-center justify-between p-3 bg-white border border-black/5 rounded-xl">
                    <div class="flex items-center gap-3">
                        <img src="${item.image_path || 'https://images.unsplash.com/photo-1568254183919-78a4f43a2877?w=100&auto=format&fit=crop&q=60'}" class="w-10 h-10 rounded-lg object-cover border border-black/5" />
                        <div class="flex flex-col gap-0.5">
                            <span class="font-bold text-[12px] text-black">${item.product_name} (${item.variant_name})</span>
                            <span class="text-[10px] text-gray-400 font-medium">Rp ${item.price.toLocaleString('id-ID')} x ${item.qty} ${item.unit}</span>
                        </div>
                    </div>
                    <span class="font-bold text-xs text-black">Rp ${subtotal.toLocaleString('id-ID')}</span>
                </div>
            `;
        });

        summaryTotalLabel.textContent = 'Rp. ' + total.toLocaleString('id-ID');
    }

    function submitTransaction() {
        const name = document.getElementById('txCustomerName').value.trim();
        const phone = document.getElementById('txCustomerPhone').value.trim();
        const itemsPayload = txCart.map(c => ({
            variant_id: c.variant_id,
            qty: c.qty
        }));

        const payBtn = document.getElementById('txPayButton');
        const originalText = payBtn.innerHTML;
        payBtn.disabled = true;
        payBtn.innerHTML = 'Memproses...';

        const token = document.querySelector('input[name="_token"]')?.value || '';

        fetch('/orders', {
            method: 'POST',
            body: JSON.stringify({
                customer_name: name,
                phone: phone,
                items: itemsPayload
            }),
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(async response => {
            const data = await response.json();
            if (!response.ok) {
                throw new Error(data.message || 'Gagal membuat transaksi.');
            }
            return data;
        })
        .then(data => {
            payBtn.disabled = false;
            payBtn.innerHTML = originalText;

            if (data.token) {
                // Open Snap popup modal directly inside our dashboard
                window.snap.pay(data.token, {
                    onSuccess: function(result) {
                        showToast('Pembayaran berhasil! Memperbarui status...', 'success');
                        fetch(`/orders/${data.order_id}/mark-as-paid`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                        .then(() => {
                            setTimeout(() => { location.reload(); }, 1200);
                        });
                    },
                    onPending: function(result) {
                        showToast('Menunggu pembayaran diselesaikan...', 'success');
                        setTimeout(() => { location.reload(); }, 1500);
                    },
                    onError: function(result) {
                        showToast('Pembayaran gagal.', 'error');
                    },
                    onClose: function() {
                        showToast('Popup pembayaran ditutup.', 'error');
                        setTimeout(() => { location.reload(); }, 1000);
                    }
                });
            } else if (data.redirect_url) {
                showToast('Transaksi sukses dibuat! Mengarahkan...', 'success');
                setTimeout(() => {
                    window.location.href = data.redirect_url;
                }, 1000);
            } else {
                showToast('Transaksi berhasil, tetapi gagal mendapatkan token pembayaran.', 'error');
            }
        })
        .catch(err => {
            payBtn.disabled = false;
            payBtn.innerHTML = originalText;
            console.error('Checkout failed:', err);
            showToast(err.message || 'Gagal memproses pembayaran. Hubungi admin.', 'error');
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        setupOrdersPagination();
    });
</script>
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
@endsection
