@extends('layouts.dashboard')

@section('title', 'Integrasi - Vern Dashboard')
@section('page_title', 'Integrasi')

@section('content')
<div class="bg-[#F8F9FB] min-h-screen">
    <!-- Filters, Search & Add Integration Button -->
    <div class="mb-8 flex flex-col gap-4">
        <!-- Row 1: Filter Tabs (Left) & Add Integrations (Right) -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <button id="tabFilterAll" onclick="selectIntegrationFilter('all')" class="text-[13px] font-bold text-black bg-[#EBEFF5] transition-all cursor-pointer rounded-[8px] border-0" style="padding: 8px 16px;">
                    Semua
                </button>
                <button id="tabFilterActive" onclick="selectIntegrationFilter('active')" class="text-[13px] font-semibold text-[#8B8E97] bg-transparent hover:bg-black/5 transition-all cursor-pointer rounded-[8px] border-0" style="padding: 8px 16px;">
                    Aktif
                </button>
                <button id="tabFilterInactive" onclick="selectIntegrationFilter('inactive')" class="text-[13px] font-semibold text-[#8B8E97] bg-transparent hover:bg-black/5 transition-all cursor-pointer rounded-[8px] border-0" style="padding: 8px 16px;">
                    Tidak Aktif
                </button>
            </div>
            
            <button onclick="showToast('Fitur Add Integration sedang dipersiapkan!', 'success')" class="flex items-center gap-2 bg-[#0077FF] hover:bg-[#0062D1] text-white px-5 py-3 rounded-[12px] text-sm font-bold transition-all shadow-sm shadow-[#0077FF]/20 cursor-pointer border-0">
                <iconify-icon icon="material-symbols:add-rounded" width="20" height="20"></iconify-icon>
                <span>Add Integrations</span>
            </button>
        </div>

        <!-- Row 2: Search Input -->
        <div style="position: relative; display: flex; align-items: center; width: 100%; max-width: 640px; height: 44px; background-color: #F1F3F6; border-radius: 9999px; padding: 0 18px; gap: 10px;">
            <iconify-icon icon="solar:magnifer-linear" width="18" height="18" class="text-gray-400" style="flex-shrink: 0;"></iconify-icon>
            <input 
                id="integrationSearchInput"
                type="text" 
                placeholder="Cari Integrasi..." 
                class="placeholder:text-[#8B8E97]"
                style="width: 100%; height: 100%; background: transparent; border: none; outline: none; font-size: 13px; font-weight: 600; color: #000000; padding: 0;"
                oninput="applyIntegrationFilters()"
            />
        </div>
    </div>

    <!-- Integrations Categories -->
    <div class="flex flex-col gap-10">
        
        <!-- Category: Point of Sale -->
        <div class="integration-category-section" id="catPos">
            <div class="mb-8">
                <h3 class="text-[18px] font-bold text-black tracking-tight mb-1">Point of Sale</h3>
                <p class="text-xs text-[#8B8E97] font-medium">Sambungkan akun Vern Anda dengan aplikasi POS lain untuk pengalaman penjualan yang terpadu.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Card: Moka POS -->
                <div class="integration-card bg-white rounded-[20px] border border-black/5 shadow-sm overflow-hidden flex flex-col justify-between" data-name="moka pos point of sale" data-active="false">
                    <div class="p-6 flex items-start gap-4">
                        <!-- Moka Brand Icon (Blue with Crown/M symbol) -->
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-[#2B4C8C] flex-shrink-0 shadow-sm overflow-hidden">
                            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="48" height="48" fill="#2B4C8C"/>
                                <path d="M14 30.5L20 18L24 24.5L28 18L34 30.5H30L27 24.5L24 29L21 24.5L18 30.5H14Z" fill="white"/>
                                <circle cx="24" cy="15" r="2" fill="white"/>
                            </svg>
                        </div>
                        <div class="flex flex-col gap-1 flex-1">
                            <span class="font-bold text-black text-sm">Moka Pos</span>
                            <p class="text-xs text-gray-500 font-medium leading-relaxed">Sinkronkan transaksi dan stok dari Moka ke Vern secara real-time untuk kontrol bisnis yang lebih akurat.</p>
                        </div>
                    </div>
                    <div class="px-6 py-4 border-t border-black/5 bg-white flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <button onclick="showIntegrationDetail('Moka Pos', 'Sinkronisasi transaksi pos real-time dengan Moka POS.')" class="text-xs font-bold text-gray-500 hover:text-black transition-all bg-white border border-black/10 px-3 py-1.5 rounded-lg cursor-pointer">Detail</button>
                            <button onclick="confirmDeleteIntegration('Moka Pos')" class="text-xs font-bold px-3 py-1.5 rounded-lg cursor-pointer transition-all" style="color: #FF4D4D; border: 1px solid #FFE0E0; background-color: #FFFFFF;">Hapus Integrasi</button>
                        </div>
                        <!-- Toggle Switch -->
                        <div onclick="toggleIntegrationState(this, 'Moka Pos')" class="toggle-switch" style="width: 44px; height: 24px; min-width: 44px; border-radius: 9999px; background-color: #E2E8F0; padding: 2px; display: flex; align-items: center; cursor: pointer; transition: all 0.3s ease; flex-shrink: 0; position: relative;">
                            <div class="toggle-knob" style="width: 20px; height: 20px; border-radius: 9999px; background-color: #FFFFFF; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); transform: translateX(0);"></div>
                        </div>
                    </div>
                </div>

                <!-- Card: Majoo POS -->
                <div class="integration-card bg-white rounded-[20px] border border-black/5 shadow-sm overflow-hidden flex flex-col justify-between" data-name="majoo pos point of sale" data-active="true">
                    <div class="p-6 flex items-start gap-4">
                        <!-- Majoo Brand Icon (Turquoise circular logo style) -->
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-[#00A59B] flex-shrink-0 shadow-sm overflow-hidden">
                            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="48" height="48" fill="#00A59B"/>
                                <circle cx="24" cy="24" r="10" stroke="white" stroke-width="3" fill="none"/>
                                <path d="M21 21L27 27" stroke="white" stroke-width="3" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="flex flex-col gap-1 flex-1">
                            <span class="font-bold text-black text-sm">Majoo Pos</span>
                            <p class="text-xs text-gray-500 font-medium leading-relaxed">Hubungkan Majoo dengan Vern untuk memantau penjualan dan operasional dalam satu dashboard.</p>
                        </div>
                    </div>
                    <div class="px-6 py-4 border-t border-black/5 bg-white flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <button onclick="showIntegrationDetail('Majoo Pos', 'Sinkronisasi penjualan dan pencatatan kasir otomatis.')" class="text-xs font-bold text-gray-500 hover:text-black transition-all bg-white border border-black/10 px-3 py-1.5 rounded-lg cursor-pointer">Detail</button>
                            <button onclick="confirmDeleteIntegration('Majoo Pos')" class="text-xs font-bold px-3 py-1.5 rounded-lg cursor-pointer transition-all" style="color: #FF4D4D; border: 1px solid #FFE0E0; background-color: #FFFFFF;">Hapus Integrasi</button>
                        </div>
                        <!-- Toggle Switch (Active) -->
                        <div onclick="toggleIntegrationState(this, 'Majoo Pos')" class="toggle-switch" style="width: 44px; height: 24px; min-width: 44px; border-radius: 9999px; background-color: #10B981; padding: 2px; display: flex; align-items: center; cursor: pointer; transition: all 0.3s ease; flex-shrink: 0; position: relative;">
                            <div class="toggle-knob" style="width: 20px; height: 20px; border-radius: 9999px; background-color: #FFFFFF; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); transform: translateX(20px);"></div>
                        </div>
                    </div>
                </div>

                <!-- Card: Jubelio -->
                <div class="integration-card bg-white rounded-[20px] border border-black/5 shadow-sm overflow-hidden flex flex-col justify-between" data-name="jubelio omnichannel point of sale" data-active="false">
                    <div class="p-6 flex items-start gap-4">
                        <!-- Jubelio Brand Icon (White square with colorful logo) -->
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-white border border-black/10 flex-shrink-0 shadow-sm overflow-hidden p-1">
                            <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 5C11.5 5 8 9.5 8 15.5C8 20.5 11 23 15 23.5V20.5C13.5 20 12 18.5 12 15.5C12 11.5 14.5 8.5 18 8.5C21.5 8.5 24 11.5 24 15.5C24 18.5 22.5 20 21 20.5V23.5C25 23 28 20.5 28 15.5C28 9.5 24.5 5 18 5Z" fill="#E28413"/>
                                <path d="M18 13C16.3 13 15 14.3 15 16C15 17.7 16.3 19 18 19C19.7 19 21 17.7 21 16C21 14.3 19.7 13 18 13Z" fill="#F45B69"/>
                            </svg>
                        </div>
                        <div class="flex flex-col gap-1 flex-1">
                            <span class="font-bold text-black text-sm">Jubelio</span>
                            <p class="text-xs text-gray-500 font-medium leading-relaxed">Integrasikan Jubelio ke Vern untuk menyatukan data penjualan online dan offline secara otomatis.</p>
                        </div>
                    </div>
                    <div class="px-6 py-4 border-t border-black/5 bg-white flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <button onclick="showIntegrationDetail('Jubelio', 'Mengelola sinkronisasi omnichannel dengan e-commerce.')" class="text-xs font-bold text-gray-500 hover:text-black transition-all bg-white border border-black/10 px-3 py-1.5 rounded-lg cursor-pointer">Detail</button>
                            <button onclick="confirmDeleteIntegration('Jubelio')" class="text-xs font-bold px-3 py-1.5 rounded-lg cursor-pointer transition-all" style="color: #FF4D4D; border: 1px solid #FFE0E0; background-color: #FFFFFF;">Hapus Integrasi</button>
                        </div>
                        <!-- Toggle Switch -->
                        <div onclick="toggleIntegrationState(this, 'Jubelio')" class="toggle-switch" style="width: 44px; height: 24px; min-width: 44px; border-radius: 9999px; background-color: #E2E8F0; padding: 2px; display: flex; align-items: center; cursor: pointer; transition: all 0.3s ease; flex-shrink: 0; position: relative;">
                            <div class="toggle-knob" style="width: 20px; height: 20px; border-radius: 9999px; background-color: #FFFFFF; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); transform: translateX(0);"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category: Komunikasi dan Pemasaran -->
        <div class="integration-category-section" id="catMarketing">
            <div class="mb-8">
                <h3 class="text-[18px] font-bold text-black tracking-tight mb-1">Komunikasi dan Pemasaran</h3>
                <p class="text-xs text-[#8B8E97] font-medium">Sambungkan akun Vern Anda dengan aplikasi lain untuk pengalaman penjualan yang terpadu.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Card: MailChimp -->
                <div class="integration-card bg-white rounded-[20px] border border-black/5 shadow-sm overflow-hidden flex flex-col justify-between" data-name="mailchimp komunikasi pemasaran email" data-active="true">
                    <div class="p-6 flex items-start gap-4">
                        <!-- Mailchimp Brand Icon (Yellow) -->
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-[#FFE01B] flex-shrink-0 shadow-sm overflow-hidden">
                            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="48" height="48" fill="#FFE01B"/>
                                <circle cx="24" cy="25" r="9" fill="black"/>
                                <circle cx="21" cy="22" r="2" fill="#FFE01B"/>
                                <circle cx="27" cy="22" r="2" fill="#FFE01B"/>
                                <path d="M19 28C21 30 27 30 29 28" stroke="#FFE01B" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="flex flex-col gap-1 flex-1">
                            <span class="font-bold text-black text-sm">MailChimp</span>
                            <p class="text-xs text-gray-500 font-medium leading-relaxed">Otomatis kirim email promosi, follow-up, dan loyalty campaign dari data real-time Vern ke Mailchimp.</p>
                        </div>
                    </div>
                    <div class="px-6 py-4 border-t border-black/5 bg-white flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <button onclick="showIntegrationDetail('MailChimp', 'Kampanye email pemasaran otomatis berdasarkan riwayat pembelian.')" class="text-xs font-bold text-gray-500 hover:text-black transition-all bg-white border border-black/10 px-3 py-1.5 rounded-lg cursor-pointer">Detail</button>
                            <button onclick="confirmDeleteIntegration('MailChimp')" class="text-xs font-bold px-3 py-1.5 rounded-lg cursor-pointer transition-all" style="color: #FF4D4D; border: 1px solid #FFE0E0; background-color: #FFFFFF;">Hapus Integrasi</button>
                        </div>
                        <!-- Toggle Switch (Active) -->
                        <div onclick="toggleIntegrationState(this, 'MailChimp')" class="toggle-switch" style="width: 44px; height: 24px; min-width: 44px; border-radius: 9999px; background-color: #10B981; padding: 2px; display: flex; align-items: center; cursor: pointer; transition: all 0.3s ease; flex-shrink: 0; position: relative;">
                            <div class="toggle-knob" style="width: 20px; height: 20px; border-radius: 9999px; background-color: #FFFFFF; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); transform: translateX(20px);"></div>
                        </div>
                    </div>
                </div>

                <!-- Card: Google Mail -->
                <div class="integration-card bg-white rounded-[20px] border border-black/5 shadow-sm overflow-hidden flex flex-col justify-between" data-name="google mail gmail komunikasi" data-active="false">
                    <div class="p-6 flex items-start gap-4">
                        <!-- Gmail Brand Icon -->
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-white border border-black/10 flex-shrink-0 shadow-sm overflow-hidden p-1">
                            <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 9V27C6 28.7 7.3 30 9 30H12V15L18 20L24 15V30H27C28.7 30 30 28.7 30 27V9C30 7.3 28.7 6 27 6H24L18 11L12 6H9C7.3 6 6 7.3 6 9Z" fill="#EA4335"/>
                                <path d="M12 6V15L18 20L24 15V6H12Z" fill="#FBBC05"/>
                                <path d="M6 9V17L12 12V6H9C7.3 6 6 7.3 6 9Z" fill="#4285F4"/>
                                <path d="M30 9V17L24 12V6H27C28.7 6 30 7.3 30 9Z" fill="#34A853"/>
                            </svg>
                        </div>
                        <div class="flex flex-col gap-1 flex-1">
                            <span class="font-bold text-black text-sm">Google Mail</span>
                            <p class="text-xs text-gray-500 font-medium leading-relaxed">Hubungkan Gmail Anda untuk mengirimkan resi digital, invoice pembelian, dan penawaran langsung ke pelanggan.</p>
                        </div>
                    </div>
                    <div class="px-6 py-4 border-t border-black/5 bg-white flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <button onclick="showIntegrationDetail('Google Mail', 'Kirim invoice digital otomatis menggunakan server email Google Mail.')" class="text-xs font-bold text-gray-500 hover:text-black transition-all bg-white border border-black/10 px-3 py-1.5 rounded-lg cursor-pointer">Detail</button>
                            <button onclick="confirmDeleteIntegration('Google Mail')" class="text-xs font-bold px-3 py-1.5 rounded-lg cursor-pointer transition-all" style="color: #FF4D4D; border: 1px solid #FFE0E0; background-color: #FFFFFF;">Hapus Integrasi</button>
                        </div>
                        <!-- Toggle Switch -->
                        <div onclick="toggleIntegrationState(this, 'Google Mail')" class="toggle-switch" style="width: 44px; height: 24px; min-width: 44px; border-radius: 9999px; background-color: #E2E8F0; padding: 2px; display: flex; align-items: center; cursor: pointer; transition: all 0.3s ease; flex-shrink: 0; position: relative;">
                            <div class="toggle-knob" style="width: 20px; height: 20px; border-radius: 9999px; background-color: #FFFFFF; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); transform: translateX(0);"></div>
                        </div>
                    </div>
                </div>

                <!-- Card: Kommo -->
                <div class="integration-card bg-white rounded-[20px] border border-black/5 shadow-sm overflow-hidden flex flex-col justify-between" data-name="kommo crm komunikasi pemasaran" data-active="false">
                    <div class="p-6 flex items-start gap-4">
                        <!-- Kommo Brand Icon (Purple/Violet logo) -->
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-[#56348B] flex-shrink-0 shadow-sm overflow-hidden">
                            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="48" height="48" fill="#56348B"/>
                                <path d="M16 16H32V20H20V24H30V28H20V32H16V16Z" fill="white"/>
                            </svg>
                        </div>
                        <div class="flex flex-col gap-1 flex-1">
                            <span class="font-bold text-black text-sm">Kommo</span>
                            <p class="text-xs text-gray-500 font-medium leading-relaxed">Integrasikan Kommo CRM untuk mencatat interaksi chat penjualan dan melacak progress prospek pelanggan.</p>
                        </div>
                    </div>
                    <div class="px-6 py-4 border-t border-black/5 bg-white flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <button onclick="showIntegrationDetail('Kommo', 'Kelola riwayat leads dan funnel penjualan online.')" class="text-xs font-bold text-gray-500 hover:text-black transition-all bg-white border border-black/10 px-3 py-1.5 rounded-lg cursor-pointer">Detail</button>
                            <button onclick="confirmDeleteIntegration('Kommo')" class="text-xs font-bold px-3 py-1.5 rounded-lg cursor-pointer transition-all" style="color: #FF4D4D; border: 1px solid #FFE0E0; background-color: #FFFFFF;">Hapus Integrasi</button>
                        </div>
                        <!-- Toggle Switch -->
                        <div onclick="toggleIntegrationState(this, 'Kommo')" class="toggle-switch" style="width: 44px; height: 24px; min-width: 44px; border-radius: 9999px; background-color: #E2E8F0; padding: 2px; display: flex; align-items: center; cursor: pointer; transition: all 0.3s ease; flex-shrink: 0; position: relative;">
                            <div class="toggle-knob" style="width: 20px; height: 20px; border-radius: 9999px; background-color: #FFFFFF; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); transform: translateX(0);"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category: Sistem Perusahaan -->
        <div class="integration-category-section" id="catEnterprise">
            <div class="mb-8">
                <h3 class="text-[18px] font-bold text-black tracking-tight mb-1">Sistem Perusahaan</h3>
                <p class="text-xs text-[#8B8E97] font-medium">Sambungkan akun Vern Anda dengan aplikasi lain untuk pengalaman penjualan yang terpadu.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Card: Odoo -->
                <div class="integration-card bg-white rounded-[20px] border border-black/5 shadow-sm overflow-hidden flex flex-col justify-between" data-name="odoo erp enterprise" data-active="true">
                    <div class="p-6 flex items-start gap-4">
                        <!-- Odoo Brand Icon -->
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-[#875A7B] flex-shrink-0 shadow-sm overflow-hidden">
                            <span class="text-white font-extrabold text-[12px] tracking-tighter">odoo</span>
                        </div>
                        <div class="flex flex-col gap-1 flex-1">
                            <span class="font-bold text-black text-sm">Odoo</span>
                            <p class="text-xs text-gray-500 font-medium leading-relaxed">Hubungkan data persediaan gudang Vern dengan modul Inventory & Purchase Odoo secara otomatis.</p>
                        </div>
                    </div>
                    <div class="px-6 py-4 border-t border-black/5 bg-white flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <button onclick="showIntegrationDetail('Odoo', 'Integrasi ERP Odoo untuk sinkronisasi inventory secara multi-warehouse.')" class="text-xs font-bold text-gray-500 hover:text-black transition-all bg-white border border-black/10 px-3 py-1.5 rounded-lg cursor-pointer">Detail</button>
                            <button onclick="confirmDeleteIntegration('Odoo')" class="text-xs font-bold px-3 py-1.5 rounded-lg cursor-pointer transition-all" style="color: #FF4D4D; border: 1px solid #FFE0E0; background-color: #FFFFFF;">Hapus Integrasi</button>
                        </div>
                        <!-- Toggle Switch (Active) -->
                        <div onclick="toggleIntegrationState(this, 'Odoo')" class="toggle-switch" style="width: 44px; height: 24px; min-width: 44px; border-radius: 9999px; background-color: #10B981; padding: 2px; display: flex; align-items: center; cursor: pointer; transition: all 0.3s ease; flex-shrink: 0; position: relative;">
                            <div class="toggle-knob" style="width: 20px; height: 20px; border-radius: 9999px; background-color: #FFFFFF; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); transform: translateX(20px);"></div>
                        </div>
                    </div>
                </div>

                <!-- Card: SAP -->
                <div class="integration-card bg-white rounded-[20px] border border-black/5 shadow-sm overflow-hidden flex flex-col justify-between" data-name="sap erp enterprise" data-active="false">
                    <div class="p-6 flex items-start gap-4">
                        <!-- SAP Brand Icon -->
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-white border border-black/10 flex-shrink-0 shadow-sm overflow-hidden">
                            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="48" height="48" fill="#F4F4F4"/>
                                <path d="M12 20H18C20 20 21 21 21 23V25C21 27 20 28 18 28H12V20ZM15 22V26H18C19 26 19.5 25.5 19.5 25V23C19.5 22.5 19 22 18 22H15Z" fill="#0A6ED1"/>
                                <path d="M24 20L28 28H26L25 26H23L22 28H20L24 20ZM24.5 22L23.5 25H25.5L24.5 22Z" fill="#0A6ED1"/>
                                <path d="M30 20H36V23H32V25H35V27H32V28H30V20Z" fill="#0A6ED1"/>
                            </svg>
                        </div>
                        <div class="flex flex-col gap-1 flex-1">
                            <span class="font-bold text-black text-sm">SAP</span>
                            <p class="text-xs text-gray-500 font-medium leading-relaxed">Modul integrasi premium untuk perusahaan korporasi berskala enterprise ke database internal SAP.</p>
                        </div>
                    </div>
                    <div class="px-6 py-4 border-t border-black/5 bg-white flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <button onclick="showIntegrationDetail('SAP', 'Integrasi SAP ERP berskala Enterprise untuk logistik skala besar.')" class="text-xs font-bold text-gray-500 hover:text-black transition-all bg-white border border-black/10 px-3 py-1.5 rounded-lg cursor-pointer">Detail</button>
                            <button onclick="confirmDeleteIntegration('SAP')" class="text-xs font-bold px-3 py-1.5 rounded-lg cursor-pointer transition-all" style="color: #FF4D4D; border: 1px solid #FFE0E0; background-color: #FFFFFF;">Hapus Integrasi</button>
                        </div>
                        <!-- Toggle Switch -->
                        <div onclick="toggleIntegrationState(this, 'SAP')" class="toggle-switch" style="width: 44px; height: 24px; min-width: 44px; border-radius: 9999px; background-color: #E2E8F0; padding: 2px; display: flex; align-items: center; cursor: pointer; transition: all 0.3s ease; flex-shrink: 0; position: relative;">
                            <div class="toggle-knob" style="width: 20px; height: 20px; border-radius: 9999px; background-color: #FFFFFF; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); transform: translateX(0);"></div>
                        </div>
                    </div>
                </div>

                <!-- Card: Accurate -->
                <div class="integration-card bg-white rounded-[20px] border border-black/5 shadow-sm overflow-hidden flex flex-col justify-between" data-name="accurate finance accounting enterprise" data-active="false">
                    <div class="p-6 flex items-start gap-4">
                        <!-- Accurate Brand Icon (Red with stylized graphic) -->
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-[#EF4444] flex-shrink-0 shadow-sm overflow-hidden">
                            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="48" height="48" fill="#EF4444"/>
                                <circle cx="24" cy="24" r="11" stroke="white" stroke-width="3" fill="none"/>
                                <path d="M24 16V24L29 27" stroke="white" stroke-width="3" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="flex flex-col gap-1 flex-1">
                            <span class="font-bold text-black text-sm">Accurate</span>
                            <p class="text-xs text-gray-500 font-medium leading-relaxed">Ekspor otomatis seluruh ringkasan jurnal umum transaksi Vern ke program pembukuan keuangan Accurate.</p>
                        </div>
                    </div>
                    <div class="px-6 py-4 border-t border-black/5 bg-white flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <button onclick="showIntegrationDetail('Accurate', 'Sinkronisasi laporan laba rugi dan akunting Accurate.')" class="text-xs font-bold text-gray-500 hover:text-black transition-all bg-white border border-black/10 px-3 py-1.5 rounded-lg cursor-pointer">Detail</button>
                            <button onclick="confirmDeleteIntegration('Accurate')" class="text-xs font-bold px-3 py-1.5 rounded-lg cursor-pointer transition-all" style="color: #FF4D4D; border: 1px solid #FFE0E0; background-color: #FFFFFF;">Hapus Integrasi</button>
                        </div>
                        <!-- Toggle Switch -->
                        <div onclick="toggleIntegrationState(this, 'Accurate')" class="toggle-switch" style="width: 44px; height: 24px; min-width: 44px; border-radius: 9999px; background-color: #E2E8F0; padding: 2px; display: flex; align-items: center; cursor: pointer; transition: all 0.3s ease; flex-shrink: 0; position: relative;">
                            <div class="toggle-knob" style="width: 20px; height: 20px; border-radius: 9999px; background-color: #FFFFFF; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); transform: translateX(0);"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal Detail Integrasi -->
<div id="integrationDetailModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="z-index: 99999; background-color: rgba(0, 0, 0, 0.4); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); display: none; opacity: 0; transition: opacity 0.3s ease;">
    <div class="bg-white rounded-[24px] shadow-2xl w-full max-w-[500px] relative transform scale-95 opacity-0 transition-all duration-300" id="detailModalContainer" style="padding: 32px; background-color: #FFFFFF; border-radius: 24px; box-sizing: border-box;">
        <button onclick="closeIntegrationDetail()" class="w-8 h-8 flex items-center justify-center rounded-full bg-[#F1F3F6] hover:bg-gray-200 transition-all cursor-pointer text-gray-600 hover:text-black border-0" style="position: absolute; top: 24px; right: 24px; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; padding: 0;">
            <iconify-icon icon="material-symbols:close-rounded" width="20" height="20"></iconify-icon>
        </button>
        
        <div class="flex items-center gap-3 mb-4">
            <iconify-icon icon="solar:widget-bold-duotone" width="36" height="36" class="text-[#0077FF]"></iconify-icon>
            <h3 id="modalDetailTitle" class="text-lg font-bold text-black m-0" style="font-family: 'Plus Jakarta Sans', sans-serif;">Detail Integrasi</h3>
        </div>
        
        <p id="modalDetailDescription" class="text-sm text-gray-500 font-medium leading-relaxed mb-6"></p>
        
        <div class="flex justify-end gap-3">
            <button onclick="closeIntegrationDetail()" class="px-5 py-2.5 rounded-full font-bold text-xs bg-gray-100 hover:bg-gray-200 transition-all cursor-pointer border-0 text-gray-700">Tutup</button>
            <button onclick="showToast('Konfigurasi berhasil disimpan!', 'success'); closeIntegrationDetail();" class="px-5 py-2.5 rounded-full font-bold text-xs bg-[#0077FF] text-white hover:bg-[#0062D1] transition-all cursor-pointer border-0">Simpan Konfigurasi</button>
        </div>
    </div>
</div>

<script>
    let activeIntegrationFilter = 'all'; // 'all', 'active', 'inactive'

    function selectIntegrationFilter(filterType) {
        activeIntegrationFilter = filterType;
        
        const tabAll = document.getElementById('tabFilterAll');
        const tabActive = document.getElementById('tabFilterActive');
        const tabInactive = document.getElementById('tabFilterInactive');
        
        // Reset styles and classes
        tabAll.className = "text-[13px] font-semibold text-[#8B8E97] bg-transparent hover:bg-black/5 transition-all cursor-pointer rounded-[8px] border-0";
        tabActive.className = "text-[13px] font-semibold text-[#8B8E97] bg-transparent hover:bg-black/5 transition-all cursor-pointer rounded-[8px] border-0";
        tabInactive.className = "text-[13px] font-semibold text-[#8B8E97] bg-transparent hover:bg-black/5 transition-all cursor-pointer rounded-[8px] border-0";
        
        if (filterType === 'all') {
            tabAll.className = "text-[13px] font-bold text-black bg-[#EBEFF5] transition-all cursor-pointer rounded-[8px] border-0";
        } else if (filterType === 'active') {
            tabActive.className = "text-[13px] font-bold text-black bg-[#EBEFF5] transition-all cursor-pointer rounded-[8px] border-0";
        } else if (filterType === 'inactive') {
            tabInactive.className = "text-[13px] font-bold text-black bg-[#EBEFF5] transition-all cursor-pointer rounded-[8px] border-0";
        }
        
        applyIntegrationFilters();
    }

    function applyIntegrationFilters() {
        const query = document.getElementById('integrationSearchInput').value.toLowerCase().trim();
        const cards = document.querySelectorAll('.integration-card');
        
        cards.forEach(card => {
            const name = card.getAttribute('data-name');
            const isActive = card.getAttribute('data-active') === 'true';
            
            const matchesSearch = name.includes(query);
            
            let matchesFilter = false;
            if (activeIntegrationFilter === 'all') {
                matchesFilter = true;
            } else if (activeIntegrationFilter === 'active' && isActive) {
                matchesFilter = true;
            } else if (activeIntegrationFilter === 'inactive' && !isActive) {
                matchesFilter = true;
            }
            
            if (matchesSearch && matchesFilter) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
        
        // Hide empty category sections dynamically
        const categories = document.querySelectorAll('.integration-category-section');
        categories.forEach(cat => {
            const visibleCards = cat.querySelectorAll('.integration-card[style*="display: flex"]');
            const totalVisible = Array.from(cat.querySelectorAll('.integration-card')).filter(c => c.style.display !== 'none').length;
            
            if (totalVisible === 0) {
                cat.style.display = 'none';
            } else {
                cat.style.display = 'block';
            }
        });
    }

    function toggleIntegrationState(element, name) {
        const knob = element.querySelector('.toggle-knob');
        const card = element.closest('.integration-card');
        const isActive = card.getAttribute('data-active') === 'true';
        
        if (isActive) {
            // Deactivate
            card.setAttribute('data-active', 'false');
            element.style.backgroundColor = "#E2E8F0";
            knob.style.transform = "translateX(0)";
            showToast(`Integrasi ${name} telah dinonaktifkan.`, 'error');
        } else {
            // Activate
            card.setAttribute('data-active', 'true');
            element.style.backgroundColor = "#10B981";
            knob.style.transform = "translateX(20px)";
            showToast(`Integrasi ${name} berhasil diaktifkan!`, 'success');
        }
        
        applyIntegrationFilters();
    }

    function confirmDeleteIntegration(name) {
        if (confirm(`Apakah Anda yakin ingin menghapus integrasi dengan ${name}?`)) {
            showToast(`Integrasi dengan ${name} berhasil dihapus!`, 'success');
            // Remove the card visually as a frontend simulation
            const cards = document.querySelectorAll('.integration-card');
            cards.forEach(card => {
                if (card.querySelector('.font-bold').textContent === name) {
                    card.style.display = 'none';
                    card.setAttribute('data-name', ''); // strip search key
                }
            });
            applyIntegrationFilters();
        }
    }

    function showIntegrationDetail(name, desc) {
        document.getElementById('modalDetailTitle').textContent = `Pengaturan ${name}`;
        document.getElementById('modalDetailDescription').textContent = `${desc} Konfigurasi rincian integrasi dapat disesuaikan pada form di bawah ini sebelum menyimpan perubahan.`;
        
        const modal = document.getElementById('integrationDetailModal');
        const container = document.getElementById('detailModalContainer');
        
        modal.style.display = 'flex';
        modal.offsetHeight;
        modal.style.opacity = '1';
        setTimeout(() => {
            container.classList.remove('scale-95', 'opacity-0');
            container.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeIntegrationDetail() {
        const modal = document.getElementById('integrationDetailModal');
        const container = document.getElementById('detailModalContainer');
        
        container.classList.remove('scale-100', 'opacity-100');
        container.classList.add('scale-95', 'opacity-0');
        modal.style.opacity = '0';
        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
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
@endsection
