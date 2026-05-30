<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', 'Vern Dashboard')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <!-- Iconify CDN Script -->
        <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>

        <style>
            /* Custom Scrollbar for dashboard */
            ::-webkit-scrollbar {
                width: 6px;
                height: 6px;
            }
            ::-webkit-scrollbar-track {
                background: transparent;
            }
            ::-webkit-scrollbar-thumb {
                background: #E5E7EB;
                border-radius: 3px;
            }
            ::-webkit-scrollbar-thumb:hover {
                background: #D1D5DB;
            }
        </style>
    </head>
    <body class="bg-[#F8F9FB] min-h-screen font-['Plus_Jakarta_Sans'] flex text-black">

        <!-- ===== SIDEBAR ===== -->
        <aside class="w-[280px] bg-white border-r border-black/5 flex flex-col h-screen sticky top-0 z-50">
            <!-- Brand Logo -->
            <div class="px-8 pt-8 pb-4 flex items-center justify-between">
                <a href="{{ route('home') }}" wire:navigate class="flex items-center">
                    <img src="{{ asset('assets/images/logos/Logo Vern Sidebar.svg') }}" alt="Vern" class="h-8 w-auto" />
                </a>
            </div>

            <!-- Search Bar -->
            <div class="px-6 py-4">
                <div class="relative flex items-center">
                    <span class="absolute left-3 flex items-center pointer-events-none text-gray-400">
                        <iconify-icon icon="solar:magnifer-linear" class="w-5 h-5"></iconify-icon>
                    </span>
                    <input 
                        type="text" 
                        placeholder="Search" 
                        class="w-full h-10 bg-[#FAFAFA] border border-black/5 rounded-[10px] pl-10 pr-4 text-[13px] font-medium text-[#292D32] placeholder:text-[#A0AEC0] focus:outline-none focus:border-[#0077FF] transition-all"
                    />
                </div>
            </div>

            <!-- Nav Items Container -->
            <div class="flex-1 overflow-y-auto px-6 py-4 flex flex-col gap-6">
                <!-- Group Menu -->
                <div class="flex flex-col gap-2">
                    <span class="px-3 text-[11px] font-bold text-[#8B8E97] uppercase tracking-wider">Menu</span>
                    
                    <ul class="flex flex-col gap-1">
                        <!-- Home -->
                        <li>
                            <a href="{{ route('dashboard.home') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-[10px] text-[14px] font-semibold transition-all duration-200 {{ Route::currentRouteName() === 'dashboard.home' ? 'bg-[#0077FF]/10 text-[#0077FF]' : 'text-[#B3B3B3] hover:bg-[#FAFAFA] hover:text-black' }}">
                                <iconify-icon icon="material-symbols:home-rounded" width="20" height="20"></iconify-icon>
                                <span>Home</span>
                            </a>
                        </li>
                        <!-- Inventory -->
                        <li>
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-[10px] text-[14px] font-semibold transition-all duration-200 {{ Route::currentRouteName() === 'dashboard' ? 'bg-[#0077FF]/10 text-[#0077FF]' : 'text-[#B3B3B3] hover:bg-[#FAFAFA] hover:text-black' }}">
                                <iconify-icon icon="material-symbols:inventory-2-rounded" width="20" height="20"></iconify-icon>
                                <span>Inventory</span>
                            </a>
                        </li>
                        <!-- Orders -->
                        <li>
                            <a href="{{ route('orders') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-[10px] text-[14px] font-semibold transition-all duration-200 {{ Route::currentRouteName() === 'orders' ? 'bg-[#0077FF]/10 text-[#0077FF]' : 'text-[#B3B3B3] hover:bg-[#FAFAFA] hover:text-black' }}">
                                <iconify-icon icon="solar:notes-bold" width="20" height="20"></iconify-icon>
                                <span>Orders</span>
                            </a>
                        </li>
                        <!-- Warehouse -->
                        <li>
                            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-[10px] text-[14px] font-semibold transition-all duration-200 text-[#B3B3B3] hover:bg-[#FAFAFA] hover:text-black">
                                <iconify-icon icon="material-symbols:warehouse" width="20" height="20"></iconify-icon>
                                <span>Warehouse</span>
                            </a>
                        </li>
                        <!-- Purchase Order -->
                        <li>
                            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-[10px] text-[14px] font-semibold transition-all duration-200 text-[#B3B3B3] hover:bg-[#FAFAFA] hover:text-black">
                                <iconify-icon icon="mdi:truck" width="20" height="20"></iconify-icon>
                                <span>Purchase Order</span>
                            </a>
                        </li>
                        <!-- Integrations -->
                        <li>
                            <a href="{{ route('integrations') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-[10px] text-[14px] font-semibold transition-all duration-200 {{ Route::currentRouteName() === 'integrations' ? 'bg-[#0077FF]/10 text-[#0077FF]' : 'text-[#B3B3B3] hover:bg-[#FAFAFA] hover:text-black' }}">
                                <iconify-icon icon="solar:widget-bold" width="20" height="20"></iconify-icon>
                                <span>Integrations</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Group Akun -->
                <div class="flex flex-col gap-2">
                    <span class="px-3 text-[11px] font-bold text-[#8B8E97] uppercase tracking-wider">Akun</span>
                    
                    <ul class="flex flex-col gap-1">
                        <!-- Business Profile -->
                        <li>
                            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-[10px] text-[14px] font-semibold transition-all duration-200 text-[#B3B3B3] hover:bg-[#FAFAFA] hover:text-black">
                                <iconify-icon icon="solar:user-bold" width="20" height="20"></iconify-icon>
                                <span>Business Profile</span>
                            </a>
                        </li>
                        <!-- Subscription -->
                        <li>
                            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-[10px] text-[14px] font-semibold transition-all duration-200 text-[#B3B3B3] hover:bg-[#FAFAFA] hover:text-black">
                                <iconify-icon icon="icon-park-solid:buy" width="20" height="20"></iconify-icon>
                                <span>Subscription</span>
                            </a>
                        </li>
                        <!-- Settings -->
                        <li>
                            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-[10px] text-[14px] font-semibold transition-all duration-200 text-[#B3B3B3] hover:bg-[#FAFAFA] hover:text-black">
                                <iconify-icon icon="solar:settings-bold" width="20" height="20"></iconify-icon>
                                <span>Settings</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Shop Profile Card (GulungJaya) -->
            <div class="px-6 py-6 border-t border-black/5 mt-auto">
                <div class="bg-[#F3F4F6] rounded-[12px] p-4 flex flex-col gap-1">
                    <span class="text-sm font-bold text-black">GulungJaya</span>
                    <span class="text-[10px] font-medium text-[#8B8E97]">Premium User - Until 30 June 2026</span>
                </div>
            </div>
        </aside>

        <!-- ===== MAIN CONTENT AREA ===== -->
        <div id="mainContentWrapper" class="flex-1 flex flex-col min-h-screen overflow-x-hidden">
            <!-- Top Bar Header -->
            <header class="h-[80px] bg-white border-b border-black/5 px-10 flex items-center justify-between sticky top-0 z-40">
                <!-- Page Title -->
                <h1 class="text-[24px] font-bold text-black tracking-[-3%]">@yield('page_title', 'Inventory')</h1>

                <!-- Right Side: User Menu & Notifications -->
                <div class="flex items-center gap-4">
                    <!-- Notification Bell and Dropdown -->
                    <div class="relative">
                        <button onclick="toggleNotificationDropdown()" class="w-10 h-10 bg-white border border-black/5 rounded-[10px] flex items-center justify-center text-gray-600 hover:bg-gray-50 transition-all cursor-pointer relative" id="notificationBellBtn">
                            <iconify-icon icon="solar:bell-linear" width="20" height="20"></iconify-icon>
                            @if(isset($lowStockVariants) && count($lowStockVariants) > 0)
                                <span class="absolute top-2.5 right-2.5 w-2.5 h-2.5 bg-[#FF4D4D] border-2 border-white rounded-full"></span>
                            @endif
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="notificationDropdown" class="hidden absolute right-0 mt-3 bg-white rounded-[20px] border border-black/5 shadow-xl w-[380px] z-50 p-6" style="transform-origin: top right;">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-sm font-bold text-black">Notifikasi</h3>
                                <button onclick="toggleNotificationDropdown()" class="text-gray-400 hover:text-black border-0 bg-transparent cursor-pointer flex items-center justify-center">
                                    <iconify-icon icon="material-symbols:close-rounded" width="18" height="18"></iconify-icon>
                                </button>
                            </div>

                            <div class="flex flex-col gap-3 max-h-[320px] overflow-y-auto pr-1">
                                @if(isset($lowStockVariants))
                                    @forelse($lowStockVariants as $variant)
                                        <div class="p-3 bg-gray-50 rounded-[12px] flex gap-3 border border-black/5">
                                            <div class="w-8 h-8 rounded-full bg-red-50 flex items-center justify-center text-[#FF4D4D] flex-shrink-0">
                                                <iconify-icon icon="solar:box-linear" width="18" height="18"></iconify-icon>
                                            </div>
                                            <div class="flex flex-col gap-1 flex-1">
                                                <span class="text-xs font-bold text-black">Stock #SKU {{ $variant->sku }} akan habis</span>
                                                <p class="text-[10px] text-gray-500 font-medium leading-relaxed">
                                                    Produk {{ $variant->product->name }} {{ $variant->variant_name }} akan habis estimasi dalam {{ $variant->actual_stock > 0 ? ceil($variant->actual_stock / max($variant->product->daily_sales ?? 1, 1)) : 10 }} Hari lagi, segera lakukan update stock
                                                </p>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="py-8 flex flex-col items-center justify-center text-gray-400 gap-2">
                                            <iconify-icon icon="solar:bell-off-linear" width="32" height="32"></iconify-icon>
                                            <span class="text-xs font-medium">Tidak ada notifikasi baru</span>
                                        </div>
                                    @endforelse
                                @endif
                            </div>

                            @if(isset($lowStockVariants) && count($lowStockVariants) > 0)
                                <div class="mt-4 pt-4 border-t border-black/5 flex justify-between items-center">
                                    <button onclick="markAllNotificationsAsRead()" class="text-[11px] font-bold text-gray-400 hover:text-[#0077FF] bg-transparent border-0 cursor-pointer p-0">Tanda semua telah dibaca</button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- User Account Badge -->
                    <div class="flex items-center gap-3 bg-white border border-black/5 shadow-sm rounded-full pl-4 pr-1 py-1 cursor-pointer hover:bg-gray-50 transition-all">
                        <span class="text-sm font-bold text-black tracking-[-2%]">Kevin Pradana</span>
                        <img 
                            src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80" 
                            alt="Kevin Pradana" 
                            class="w-8 h-8 rounded-full object-cover border border-black/10"
                        />
                    </div>

                    <!-- Log Out Button -->
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="w-10 h-10 bg-[#FFF5F5] border border-[#FFE0E0] rounded-[10px] flex items-center justify-center text-[#FF4D4D] hover:bg-[#FFEBEB] hover:border-[#FFD1D1] transition-all cursor-pointer">
                            <iconify-icon icon="ic:sharp-log-out" width="20" height="20"></iconify-icon>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Page Content Container -->
            <main class="flex-1 p-10">
                @yield('content')
            </main>
        </div>

        <script>
            function toggleNotificationDropdown() {
                const dropdown = document.getElementById('notificationDropdown');
                dropdown.classList.toggle('hidden');
            }

            function markAllNotificationsAsRead() {
                const bellBtn = document.getElementById('notificationBellBtn');
                const redDot = bellBtn.querySelector('.bg-\\[\\#FF4D4D\\]');
                if (redDot) redDot.remove();
                
                const container = document.querySelector('#notificationDropdown .overflow-y-auto');
                container.innerHTML = `
                    <div class="py-8 flex flex-col items-center justify-center text-gray-400 gap-2">
                        <iconify-icon icon="solar:bell-off-linear" width="32" height="32"></iconify-icon>
                        <span class="text-xs font-medium">Tidak ada notifikasi baru</span>
                    </div>
                `;
                
                const footer = document.querySelector('#notificationDropdown .border-t');
                if (footer) footer.remove();
                
                if (typeof showToast === 'function') {
                    showToast('Semua notifikasi telah dibaca.', 'success');
                } else {
                    alert('Semua notifikasi telah dibaca.');
                }
            }

            // Close notification dropdown when clicking outside
            document.addEventListener('click', function(event) {
                const dropdown = document.getElementById('notificationDropdown');
                const bellBtn = document.getElementById('notificationBellBtn');
                if (dropdown && bellBtn && !dropdown.classList.contains('hidden')) {
                    if (!dropdown.contains(event.target) && !bellBtn.contains(event.target)) {
                        dropdown.classList.add('hidden');
                    }
                }
            });
        </script>

        @livewireScripts
        @stack('sidebar')
    </body>
</html>

