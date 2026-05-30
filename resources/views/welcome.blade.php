<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Kendalikan Inventori - Vern Warehouse</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Lexend+Deca:wght@300;400;500;600;700;800&family=Caveat:wght@400;700&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <!-- Alpine.js CDN (Di-disable karena conflict dengan Livewire v3/v4 yang meng-include Alpine secara otomatis, tetapi karena halaman ini tidak memiliki komponen Livewire, kita perlu menyertakannya agar interaksi Alpine berfungsi) -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- Midtrans Snap JS -->
        <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

        <!-- GSAP & ScrollTrigger & SplitType CDNs for Vision Text Reveal Animation -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
        <script src="https://unpkg.com/split-type"></script>
    </head>
    <body class="min-h-screen bg-white overflow-x-hidden font-['Plus_Jakarta_Sans']">
        <!-- Floating Navbar -->
        <nav class="fixed top-6 left-1/2 -translate-x-1/2 z-[1000] w-full max-w-[800px] px-4">
            <div class="bg-black rounded-full pr-1 pl-4 py-2 flex items-center justify-between border border-white/10 shadow-2xl">
                <!-- Logo Container -->
                <a href="{{ route('home') }}" wire:navigate class="flex items-center ml-2">
                    <img src="{{ asset('assets/images/logos/vern-logo-navbar-landing.png') }}" alt="Vern" class="h-5 w-auto" />
                </a>

                <!-- Menu Items -->
                <ul class="hidden md:flex items-center gap-5">
                    <li>
                        <a href="{{ route('home') }}" wire:navigate class="text-sm transition-colors duration-300 text-[#0077FF] font-semibold">
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" wire:navigate class="text-sm transition-colors duration-300 text-[#B3B3B3] font-medium hover:text-white">
                            Tentang Kami
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('product') }}" wire:navigate class="text-sm transition-colors duration-300 text-[#B3B3B3] font-medium hover:text-white">
                            Produk
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('casestudy') }}" wire:navigate class="text-sm transition-colors duration-300 text-[#B3B3B3] font-medium hover:text-white">
                            Studi Kasus
                        </a>
                    </li>
                </ul>

                <!-- Action Items -->
                <div class="flex items-center gap-4 mr-1">
                    <a href="{{ route('login') }}" wire:navigate class="text-white font-medium text-sm hover:opacity-80 transition-opacity">Masuk</a>
                    <button class="bg-[#0077FF] text-white px-5 py-2 rounded-full text-sm font-semibold hover:bg-[#0066EE] transition-all transform hover:scale-105 active:scale-95">
                        Coba Vern Gratis
                    </button>
                </div>
                
                <!-- Mobile Toggle Placeholder -->
                <div class="md:hidden text-white cursor-pointer pr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </div>
            </div>
        </nav>

        <main>
            <!-- Hero Section -->
            <section class="relative min-h-[90vh] flex items-center pt-10 lg:pt-20" x-data>
                <!-- Background Mesh -->
                <div
                    class="absolute top-0 right-0 w-full lg:w-3/4 h-[140%] pointer-events-none z-0 bg-no-repeat bg-right-top bg-cover opacity-100 transition-opacity duration-1000"
                    style="background-image: url('{{ asset('assets/images/backgrounds/hero-mesh.png') }}')"
                >
                    <!-- Gradient halus agar transisi ke putih tetap cantik -->
                    <div class="absolute inset-0 bg-gradient-to-l from-transparent via-transparent to-white"></div>
                </div>

                <div class="container mx-auto px-6 lg:px-24 relative z-10">
                    <div class="grid lg:grid-cols-2 gap-12 items-center">
                        <!-- Left Content -->
                        <div class="z-10 mt-10 lg:mt-0 max-w-[580px]">
                            <h1 class="text-4xl lg:text-[48px] font-bold text-black leading-[1.2] tracking-[-0.03em] mb-4">
                                Kendalikan Inventori,<br />
                                Kendalikan
                                <span class="relative inline-block ml-2 group">
                                    <!-- Teks Utama -->
                                    <span class="relative z-10 text-black">Bisnis Anda</span>
                                    <!-- Efek Stabilo (#0077FF dengan Opacity 24% sesuai Figma) -->
                                    <div class="absolute bottom-0 left-0 w-full h-[100%] bg-[#0077FF]/[0.24] -z-1 origin-left animate-highlight"></div>
                                    <!-- Garis Bawah Tegas -->
                                    <div class="absolute bottom-0 left-0 w-full h-[3px] bg-[#0077FF] origin-left animate-highlight-line"></div>
                                </span>
                            </h1>

                            <p class="text-[16px] text-black/80 leading-relaxed tracking-[-0.03em] mb-10 max-w-[511px]">
                                VERN membantu bisnis anda mendeteksi kekurangan stok, mencegah
                                penyusutan, dan mengungkap stok produk yang bergerak lambat
                                sebelum menjadi deadstock yang mahal.
                            </p>

                            <!-- Buttons & Handwritten Note -->
                            <div class="flex flex-col items-start gap-4 mb-10">
                                <div class="flex flex-wrap items-center gap-6">
                                    <button @click="$dispatch('open-checkout', { package: 'Pro', price: 'IDR 99.000' })" class="bg-black text-white px-8 py-3.5 rounded-xl font-bold text-[16px] hover:bg-gray-900 transition-all shadow-lg shadow-black/10 cursor-pointer">
                                        Mulai Menggunakan Vern
                                    </button>
                                    <a href="#cara-kerja" class="flex items-center gap-2 text-black font-bold text-[16px] hover:text-[#0077FF] transition-colors group">
                                        Lihat Cara Kerjanya
                                    </a>
                                </div>

                                <!-- Handwritten Note Badge -->
                                <div class="relative ml-2">
                                    <img src="{{ asset('assets/images/photos/tidak-ada-pembayaran-diawal.svg') }}" alt="Tidak ada pembayaran di awal" class="w-[260px] h-auto opacity-100" />
                                </div>
                            </div>

                            <!-- Marquee Trust Section -->
                            <div class="mt-10">
                                <p class="text-[16px] font-semibold text-[#737373] tracking-[-0.05em] mb-8">
                                    Membantu tim di beberapa sektor Bisnis
                                </p>
                                <div class="marquee-container relative overflow-hidden">
                                    <div class="marquee-content flex items-center gap-10 flex-nowrap">
                                        <!-- Logo Marquee -->
                                        <img src="{{ asset('assets/images/marquee/RETAIL.svg') }}" alt="Retail" class="h-6 w-auto grayscale opacity-100 hover:grayscale-0 transition-all flex-shrink-0" />
                                        <img src="{{ asset('assets/images/marquee/F&B.svg') }}" alt="F&B" class="h-6 w-auto grayscale opacity-100 hover:grayscale-0 transition-all flex-shrink-0" />
                                        <img src="{{ asset('assets/images/marquee/GARMEN.svg') }}" alt="Garmen" class="h-6 w-auto grayscale opacity-100 hover:grayscale-0 transition-all flex-shrink-0" />
                                        <img src="{{ asset('assets/images/marquee/E-COMMERCE.svg') }}" alt="E-Commerce" class="h-6 w-auto grayscale opacity-100 hover:grayscale-0 transition-all flex-shrink-0" />
                                        <!-- Duplicate for infinite loop -->
                                        <img src="{{ asset('assets/images/marquee/RETAIL.svg') }}" alt="Retail" class="h-6 w-auto grayscale opacity-100 hover:grayscale-0 transition-all flex-shrink-0" />
                                        <img src="{{ asset('assets/images/marquee/F&B.svg') }}" alt="F&B" class="h-6 w-auto grayscale opacity-100 hover:grayscale-0 transition-all flex-shrink-0" />
                                        <img src="{{ asset('assets/images/marquee/GARMEN.svg') }}" alt="Garmen" class="h-6 w-auto grayscale opacity-100 hover:grayscale-0 transition-all flex-shrink-0" />
                                        <img src="{{ asset('assets/images/marquee/E-COMMERCE.svg') }}" alt="E-Commerce" class="h-6 w-auto grayscale opacity-100 hover:grayscale-0 transition-all flex-shrink-0" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Visual -->
                        <div class="relative flex justify-end items-center lg:h-[800px]">
                            <!-- Background mesh/glow behind image -->
                            <div class="absolute w-[150%] h-[150%] bg-blue-400/10 blur-[150px] rounded-full -z-10 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"></div>

                            <!-- Hero Image Container -->
                            <div class="relative w-full lg:w-[100%] max-w-[800px] lg:-mr-12 lg:-mt-10 transform hover:scale-[1] transition-transform duration-700 aspect-square lg:aspect-auto flex items-center justify-end z-10">
                                <img src="{{ asset('assets/images/photos/hero-man.svg') }}" alt="Hero Man" class="w-full h-auto drop-shadow-[0_45px_45px_rgba(0,0,0,0.2)]" />
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 2: Why Choose Vern (Tabs Navigation) -->
            <section x-data="{ activeTab: 'analisis' }" class="pt-0 pb-24 bg-transparent relative lg:-mt-10">
                <div class="container mx-auto px-6 lg:px-24 relative z-10 text-center">
                    <!-- Section Title with Gradient -->
                    <h2 class="text-3xl lg:text-[30px] font-bold mb-16 tracking-[-0.03em] font-['Plus_Jakarta_Sans']">
                        <span class="bg-gradient-to-r from-[#0077FF] to-[#FBA518] bg-clip-text text-transparent">
                            Kenapa Harus memilih Vern
                        </span>
                    </h2>

                    <!-- Tabs Navigation -->
                    <div class="flex flex-wrap justify-center gap-4 lg:gap-12 mb-12 border-b border-gray-100">
                        <!-- Tab 1: Dashboard Analisis -->
                        <button
                            @click="activeTab = 'analisis'"
                            class="flex items-center gap-3 pb-6 transition-all relative group cursor-pointer"
                        >
                            <img
                                src="{{ asset('assets/images/icons/section-kenapa-harus-memilih-vern/icon-dashboard-analisis-aktif.svg') }}"
                                alt=""
                                class="w-6 h-6"
                                x-show="activeTab === 'analisis'"
                            />
                            <img
                                src="{{ asset('assets/images/icons/section-kenapa-harus-memilih-vern/icon-dashboard-analisis-nonaktif.svg') }}"
                                alt=""
                                class="w-6 h-6"
                                x-show="activeTab !== 'analisis'"
                                style="display: none;"
                            />
                            <span
                                class="text-[16px] font-semibold tracking-[-0.03em] transition-colors"
                                :class="activeTab === 'analisis' ? 'text-black' : 'text-[#B3B3B3]'"
                            >
                                Dashboard Analisis
                            </span>
                            <!-- Active Underline -->
                            <div
                                class="absolute bottom-0 left-0 h-[2px] bg-gradient-to-r from-[#0077FF] to-[#FBA518] transition-all duration-300"
                                :class="activeTab === 'analisis' ? 'w-full' : 'w-0'"
                            ></div>
                        </button>

                        <!-- Tab 2: Status Analisis Stok -->
                        <button
                            @click="activeTab = 'stok'"
                            class="flex items-center gap-3 pb-6 transition-all relative group cursor-pointer"
                        >
                            <img
                                src="{{ asset('assets/images/icons/section-kenapa-harus-memilih-vern/icon-status-analisis-stok-aktif.svg') }}"
                                alt=""
                                class="w-6 h-6"
                                x-show="activeTab === 'stok'"
                                style="display: none;"
                            />
                            <img
                                src="{{ asset('assets/images/icons/section-kenapa-harus-memilih-vern/icon-status-analisis-stok-nonaktif.svg') }}"
                                alt=""
                                class="w-6 h-6"
                                x-show="activeTab !== 'stok'"
                            />
                            <span
                                class="text-[16px] font-semibold tracking-[-0.03em] transition-colors"
                                :class="activeTab === 'stok' ? 'text-black' : 'text-[#B3B3B3]'"
                            >
                                Status Analisis Stok
                            </span>
                            <!-- Active Underline -->
                            <div
                                class="absolute bottom-0 left-0 h-[2px] bg-gradient-to-r from-[#0077FF] to-[#FBA518] transition-all duration-300"
                                :class="activeTab === 'stok' ? 'w-full' : 'w-0'"
                            ></div>
                        </button>

                        <!-- Tab 3: Notifikasi Deadstock -->
                        <button
                            @click="activeTab = 'notifikasi'"
                            class="flex items-center gap-3 pb-6 transition-all relative group cursor-pointer"
                        >
                            <img
                                src="{{ asset('assets/images/icons/section-kenapa-harus-memilih-vern/icon-notifikasi-deadstock-aktif.svg') }}"
                                alt=""
                                class="w-6 h-6"
                                x-show="activeTab === 'notifikasi'"
                                style="display: none;"
                            />
                            <img
                                src="{{ asset('assets/images/icons/section-kenapa-harus-memilih-vern/icon-notifikasi-deadstock-nonaktif.svg') }}"
                                alt=""
                                class="w-6 h-6"
                                x-show="activeTab !== 'notifikasi'"
                            />
                            <span
                                class="text-[16px] font-semibold tracking-[-0.03em] transition-colors"
                                :class="activeTab === 'notifikasi' ? 'text-black' : 'text-[#B3B3B3]'"
                            >
                                Notifikasi Deadstock
                            </span>
                            <!-- Active Underline -->
                            <div
                                class="absolute bottom-0 left-0 h-[2px] bg-gradient-to-r from-[#0077FF] to-[#FBA518] transition-all duration-300"
                                :class="activeTab === 'notifikasi' ? 'w-full' : 'w-0'"
                            ></div>
                        </button>

                        <!-- Tab 4: Integrasi E-Commerce -->
                        <button
                            @click="activeTab = 'integrasi'"
                            class="flex items-center gap-3 pb-6 transition-all relative group cursor-pointer"
                        >
                            <img
                                src="{{ asset('assets/images/icons/section-kenapa-harus-memilih-vern/icon-integrasi-ecommerce-aktif.svg') }}"
                                alt=""
                                class="w-6 h-6"
                                x-show="activeTab === 'integrasi'"
                                style="display: none;"
                            />
                            <img
                                src="{{ asset('assets/images/icons/section-kenapa-harus-memilih-vern/icon-integrasi-ecommerce-nonaktif.svg') }}"
                                alt=""
                                class="w-6 h-6"
                                x-show="activeTab !== 'integrasi'"
                            />
                            <span
                                class="text-[16px] font-semibold tracking-[-0.03em] transition-colors"
                                :class="activeTab === 'integrasi' ? 'text-black' : 'text-[#B3B3B3]'"
                            >
                                Integrasi E-Commerce
                            </span>
                            <!-- Active Underline -->
                            <div
                                class="absolute bottom-0 left-0 h-[2px] bg-gradient-to-r from-[#0077FF] to-[#FBA518] transition-all duration-300"
                                :class="activeTab === 'integrasi' ? 'w-full' : 'w-0'"
                            ></div>
                        </button>
                    </div>

                    <!-- Dashboard Preview Container -->
                    <div class="relative max-w-[1200px] mx-auto rounded-[32px] overflow-hidden shadow-[0_40px_100px_rgba(0,0,0,0.08)] bg-gray-50 transition-all duration-700">
                        <!-- Dynamic Dashboard Images -->
                        <img
                            src="{{ asset('assets/images/dashboards/dashboard-analisis.svg') }}"
                            alt="Dashboard Analisis"
                            class="w-full h-auto"
                            x-show="activeTab === 'analisis'"
                            x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                        />
                        <img
                            src="{{ asset('assets/images/dashboards/status-analisis-stok.svg') }}"
                            alt="Status Analisis Stok"
                            class="w-full h-auto"
                            x-show="activeTab === 'stok'"
                            x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            style="display: none;"
                        />
                        <img
                            src="{{ asset('assets/images/dashboards/notifikasi-deadstock.svg') }}"
                            alt="Notifikasi Deadstock"
                            class="w-full h-auto"
                            x-show="activeTab === 'notifikasi'"
                            x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            style="display: none;"
                        />
                        <img
                            src="{{ asset('assets/images/dashboards/integrasi-ecommerce.svg') }}"
                            alt="Integrasi E-Commerce"
                            class="w-full h-auto"
                            x-show="activeTab === 'integrasi'"
                            x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            style="display: none;"
                        />

                        <!-- Bottom Blur Overlay -->
                        <div class="absolute bottom-0 left-0 w-full h-[150px] bg-gradient-to-t from-white via-white/80 to-transparent z-10 pointer-events-none"></div>
                    </div>
                </div>
            </section>

            <!-- Section 3: Problems Section -->
            <section class="py-24 bg-[#F2FAFF] relative overflow-hidden">
                <div class="container mx-auto px-6 lg:px-24 relative z-10">
                    <!-- Section Header -->
                    <div class="flex flex-col lg:flex-row justify-between items-start gap-8 mb-16">
                        <div class="max-w-[700px]">
                            <p class="font-['Plus_Jakarta_Sans'] font-medium text-[16px] tracking-[-0.03em] mb-4">
                                <span class="text-[#0077FF]">Masalah yang kami</span>
                                <span class="text-[#FBA518] ml-1">temukan</span>
                            </p>
                            <h2 class="text-[32px] font-semibold text-black leading-[1.3] tracking-[-0.03em] font-['Plus_Jakarta_Sans']">
                                Masalah Inventori Diam-Diam Menggerus Keuntungan Bisnis Anda Lebih Besar dari yang Anda Sadari.
                            </h2>
                        </div>
                        <div class="lg:max-w-[460px] pt-8">
                            <p class="text-[16px] font-medium text-black leading-relaxed tracking-[-0.03em] font-['Plus_Jakarta_Sans']">
                                Tanpa visibilitas inventori yang jelas, bisnis kehilangan pendapatan, terjebak dalam stok mati, dan menanggung biaya operasional yang terus membengkak.
                            </p>
                        </div>
                    </div>

                    <!-- Problem Cards Grid -->
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Card 1 -->
                        <div class="bg-white rounded-[10px] border border-black/10 p-[12px] flex flex-col h-[455px] transition-all hover:shadow-xl hover:shadow-blue-900/5">
                            <div class="h-[280px] bg-[#E0F2FE] rounded-[8px] relative overflow-hidden flex items-center justify-center">
                                <!-- Inner Mesh Background for Card Image -->
                                <div class="absolute inset-0 opacity-40 bg-[radial-gradient(circle_at_50%_50%,#BAE6FD_0%,transparent_70%)]"></div>
                                <img src="{{ asset('assets/images/problems/stok-tidak-akurat.svg') }}" alt="Stok tidak akurat" class="relative z-10 w-full h-full object-cover" />
                            </div>
                            <div class="p-6 pt-8 flex-1">
                                <h3 class="text-[24px] font-semibold text-black mb-3 font-['Plus_Jakarta_Sans'] tracking-[-0.03em]">
                                    Stok tidak akurat
                                </h3>
                                <p class="text-[16px] font-medium text-[#B3B3B3] leading-relaxed font-['Plus_Jakarta_Sans'] tracking-[-0.03em]">
                                    Ketidakakuratan stok menghambat keputusan dan menggerus pendapatan.
                                </p>
                            </div>
                        </div>

                        <!-- Card 2 -->
                        <div class="bg-white rounded-[10px] border border-black/10 p-[12px] flex flex-col h-[455px] transition-all hover:shadow-xl hover:shadow-blue-900/5">
                            <div class="h-[280px] bg-[#E0F2FE] rounded-[8px] relative overflow-hidden flex items-center justify-center">
                                <div class="absolute inset-0 opacity-40 bg-[radial-gradient(circle_at_50%_50%,#BAE6FD_0%,transparent_70%)]"></div>
                                <img src="{{ asset('assets/images/problems/dead-stock.svg') }}" alt="Dead Stock" class="relative z-10 w-full h-full object-cover" />
                            </div>
                            <div class="p-6 pt-8 flex-1">
                                <h3 class="text-[24px] font-semibold text-black mb-3 font-['Plus_Jakarta_Sans'] tracking-[-0.03em]">
                                    Dead Stock
                                </h3>
                                <p class="text-[16px] font-medium text-[#B3B3B3] leading-relaxed font-['Plus_Jakarta_Sans'] tracking-[-0.03em]">
                                    Dead stock memperlambat perputaran bisnis dan membebani cash flow.
                                </p>
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <div class="bg-white rounded-[10px] border border-black/10 p-[12px] flex flex-col h-[455px] transition-all hover:shadow-xl hover:shadow-blue-900/5">
                            <div class="h-[280px] bg-[#E0F2FE] rounded-[8px] relative overflow-hidden flex items-center justify-center">
                                <div class="absolute inset-0 opacity-40 bg-[radial-gradient(circle_at_50%_50%,#BAE6FD_0%,transparent_70%)]"></div>
                                <img src="{{ asset('assets/images/problems/visibilitas-stok.svg') }}" alt="Kurangnya visibilitas stok" class="relative z-10 w-full h-full object-cover" />
                            </div>
                            <div class="p-6 pt-8 flex-1">
                                <h3 class="text-[24px] font-semibold text-black mb-3 font-['Plus_Jakarta_Sans'] tracking-[-0.03em]">
                                    Kurangnya visibilitas stok
                                </h3>
                                <p class="text-[16px] font-medium text-[#B3B3B3] leading-relaxed font-['Plus_Jakarta_Sans'] tracking-[-0.03em]">
                                    Stok tidak terlihat secara real-time, membuat bisnis selalu terlambat bereaksi.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 4: Vision Section -->
            <section class="py-12 bg-white relative overflow-hidden">
                <div class="container mx-auto px-6 lg:px-24 relative z-10 text-center">
                    <p class="font-['Plus_Jakarta_Sans'] font-medium text-[16px] tracking-[-0.03em] mb-6 text-center">
                        <span class="inline-block" style="background: linear-gradient(90deg, #0077FF 37%, #FBA518 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                            Visi Kami Kedepan
                        </span>
                    </p>

                    <div class="max-w-[1000px] mx-auto">
                        <h2
                            class="reveal-type text-[28px] lg:text-[40px] font-medium leading-[1.4] tracking-[-0.03em] font-['Plus_Jakarta_Sans']"
                            data-bg-color="#cccccc"
                            data-fg-color="#000000"
                        >
                            “Vern hadir untuk membuat setiap pergerakan stok terlihat dengan
                            jelas. Kami percaya keputusan terbaik lahir dari data yang akurat
                            dan real-time. Sehingga bisnis tidak lagi bereaksi terhadap
                            masalah, tapi mampu mengantisipasinya sejak awal.”
                        </h2>
                    </div>
                </div>
            </section>

            <!-- Section 5: Team Section -->
            <section class="py-12 bg-white relative overflow-hidden">
                <div class="container mx-auto px-6 lg:px-24 relative z-10 text-center">
                    <p class="font-['Plus_Jakarta_Sans'] font-medium text-[16px] tracking-[-0.03em] mb-8">
                        <span class="text-[#0077FF]">Insan</span>
                        <span class="text-[#B3B3B3] mx-1">Dibalik</span>
                        <span class="text-[#FBA518]">Vern</span>
                    </p>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-10 mb-20">
                        <!-- Member 1 -->
                        <div class="flex flex-col items-center">
                            <div class="mb-8 w-full aspect-[4/5] flex items-center justify-center">
                                <img src="{{ asset('assets/images/team/ananda.svg') }}" alt="Ananda" class="w-full h-full object-contain" />
                            </div>
                            <h4 class="text-[24px] font-bold text-black font-['Plus_Jakarta_Sans'] tracking-[-0.03em] mb-1">
                                Ananda
                            </h4>
                            <p class="text-[20px] font-bold text-[#D1D1D1] font-['Plus_Jakarta_Sans'] tracking-[-0.01em]">
                                CTO
                            </p>
                        </div>

                        <!-- Member 2 -->
                        <div class="flex flex-col items-center">
                            <div class="mb-8 w-full aspect-[4/5] flex items-center justify-center">
                                <img src="{{ asset('assets/images/team/niko.svg') }}" alt="Niko" class="w-full h-full object-contain" />
                            </div>
                            <h4 class="text-[24px] font-bold text-black font-['Plus_Jakarta_Sans'] tracking-[-0.03em] mb-1">
                                Niko
                            </h4>
                            <p class="text-[20px] font-bold text-[#D1D1D1] font-['Plus_Jakarta_Sans'] tracking-[-0.01em]">
                                COO
                            </p>
                        </div>

                        <!-- Member 3 -->
                        <div class="flex flex-col items-center">
                            <div class="mb-8 w-full aspect-[4/5] flex items-center justify-center">
                                <img src="{{ asset('assets/images/team/dimas.svg') }}" alt="Dimas" class="w-full h-full object-contain" />
                            </div>
                            <h4 class="text-[24px] font-bold text-black font-['Plus_Jakarta_Sans'] tracking-[-0.03em] mb-1">
                                Dimas
                            </h4>
                            <p class="text-[20px] font-bold text-[#D1D1D1] font-['Plus_Jakarta_Sans'] tracking-[-0.01em]">
                                CEO
                            </p>
                        </div>

                        <!-- Member 4 -->
                        <div class="flex flex-col items-center">
                            <div class="mb-8 w-full aspect-[4/5] flex items-center justify-center">
                                <img src="{{ asset('assets/images/team/ratih.svg') }}" alt="Ratih" class="w-full h-full object-contain" />
                            </div>
                            <h4 class="text-[24px] font-bold text-black font-['Plus_Jakarta_Sans'] tracking-[-0.03em] mb-1">
                                Ratih
                            </h4>
                            <p class="text-[20px] font-bold text-[#D1D1D1] font-['Plus_Jakarta_Sans'] tracking-[-0.01em]">
                                CMO
                            </p>
                        </div>

                        <!-- Member 5 -->
                        <div class="flex flex-col items-center">
                            <div class="mb-8 w-full aspect-[4/5] flex items-center justify-center">
                                <img src="{{ asset('assets/images/team/natasya.svg') }}" alt="Natasya" class="w-full h-full object-contain" />
                            </div>
                            <h4 class="text-[24px] font-bold text-black font-['Plus_Jakarta_Sans'] tracking-[-0.03em] mb-1">
                                Natasya
                            </h4>
                            <p class="text-[20px] font-bold text-[#D1D1D1] font-['Plus_Jakarta_Sans'] tracking-[-0.01em]">
                                CFO
                            </p>
                        </div>
                    </div>

                    <button class="bg-[#0077FF] text-white px-10 py-4 rounded-full font-bold text-[16px] hover:bg-[#0066DD] transition-all shadow-lg shadow-blue-500/25 mb-32">
                        Lihat Cerita Kami
                    </button>
                </div>
            </section>

            <!-- Section 6: Solusi Section -->
            <section class="py-24 bg-white relative overflow-hidden">
                <div class="container mx-auto px-6 lg:px-24 relative z-10">
                    <!-- Section Header: Left-Right Layout -->
                    <div class="flex flex-col lg:flex-row justify-between items-start gap-8 mb-20 text-left">
                        <div class="max-w-[700px]">
                            <p class="inline-block font-['Plus_Jakarta_Sans'] font-medium text-[16px] tracking-[-0.03em] mb-4 bg-gradient-to-r from-[#0077FF] via-[#0077FF] to-[#FBA518] bg-clip-text text-transparent">
                                Solusi
                            </p>
                            <h2 class="text-[32px] font-semibold text-black leading-[1.3] tracking-[-0.03em] font-['Plus_Jakarta_Sans']">
                                Vern menawarkan Visibilitas penuh kepada Inventory Anda
                            </h2>
                        </div>
                        <div class="lg:max-w-[460px] flex flex-col gap-6 pt-4">
                            <p class="text-[16px] font-normal text-black leading-relaxed tracking-[-0.03em] font-['Plus_Jakarta_Sans']">
                                Deteksi celah stok, ungkap risiko penyusutan, dan identifikasi produk yang bergerak lambat sebelum menjadi masalah yang mahal.
                            </p>
                            <button class="w-fit bg-[#0077FF] text-white px-6 py-3 rounded-full font-medium text-[14px] flex items-center gap-2 hover:bg-[#0066DD] transition-all">
                                Coba Vern <span class="text-xl">→</span>
                              </button>
                        </div>
                    </div>

                    <!-- Solution Cards Grid (2x2) -->
                    <div class="grid md:grid-cols-2 gap-8">
                        <!-- Card 1: Notifikasi Stok -->
                        <div class="bg-white rounded-[24px] border border-gray-100 p-0 flex flex-col group cursor-pointer hover:shadow-2xl hover:shadow-blue-500/5 transition-all duration-500 text-left overflow-hidden">
                            <!-- Image Container -->
                            <div class="aspect-[5/5] bg-[#F8FAFC] rounded-t-[24px] rounded-b-0 pt-5 pr-5 relative overflow-hidden border-b border-gray-50 flex items-start justify-start">
                                <img src="{{ asset('assets/images/solutions/notifikasi-stok.svg') }}" alt="Notifikasi Stok" class="w-full h-full object-cover object-left-top" />
                                <!-- Efek Blur/Fade Bawah -->
                                <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-[#F8FAFC] via-[#F8FAFC]/80 to-transparent z-10"></div>
                            </div>

                            <!-- Text Area -->
                            <div class="p-6 mt-auto">
                                <div class="flex justify-between items-end">
                                    <div class="max-w-[80%]">
                                        <h3 class="text-[24px] font-bold text-black mb-1 font-['Plus_Jakarta_Sans'] tracking-[-0.03em]">
                                            Notifikasi Stok
                                        </h3>
                                        <p class="text-[16px] text-[#B3B3B3] font-medium font-['Plus_Jakarta_Sans'] tracking-[-0.03em] leading-tight">
                                            Dapatkan notifikasi pemberitahuan stok.
                                        </p>
                                    </div>
                                    <div class="w-10 h-10 flex items-center justify-center transition-transform group-hover:translate-x-1 group-hover:-translate-y-1">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7 17L17 7M17 7H7M17 7V17" stroke="black" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2: Inventory Analisis -->
                        <div class="bg-white rounded-[24px] border border-gray-100 p-0 flex flex-col group cursor-pointer hover:shadow-2xl hover:shadow-blue-500/5 transition-all duration-500 text-left overflow-hidden">
                            <div class="aspect-[5/5] bg-[#F8FAFC] rounded-t-[24px] rounded-b-0 pt-5 pr-5 relative overflow-hidden border-b border-gray-50 flex items-start justify-start">
                                <img src="{{ asset('assets/images/solutions/inventory-analisis.svg') }}" alt="Inventory Analisis" class="w-full h-full object-cover object-left-top" />
                                <!-- Efek Blur/Fade Bawah -->
                                <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-[#F8FAFC] via-[#F8FAFC]/80 to-transparent z-10"></div>
                            </div>

                            <div class="p-6 mt-auto">
                                <div class="flex justify-between items-end">
                                    <div class="max-w-[80%]">
                                        <h3 class="text-[24px] font-bold text-black mb-1 font-['Plus_Jakarta_Sans'] tracking-[-0.03em]">
                                            Inventory Analisis
                                        </h3>
                                        <p class="text-[16px] text-[#B3B3B3] font-medium font-['Plus_Jakarta_Sans'] tracking-[-0.03em] leading-tight">
                                            Ketahui performa semua produkmu.
                                        </p>
                                    </div>
                                    <div class="w-10 h-10 flex items-center justify-center transition-transform group-hover:translate-x-1 group-hover:-translate-y-1">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7 17L17 7M17 7H7M17 7V17" stroke="black" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card 3: Status Kesehatan Stok -->
                        <div class="bg-white rounded-[24px] border border-gray-100 p-0 flex flex-col group cursor-pointer hover:shadow-2xl hover:shadow-blue-500/5 transition-all duration-500 text-left overflow-hidden">
                            <div class="aspect-[5/5] bg-[#F8FAFC] rounded-t-[24px] rounded-b-0 pt-5 pr-5 relative overflow-hidden border-b border-gray-50 flex items-start justify-start">
                                <img src="{{ asset('assets/images/solutions/status-kesehatan-stok.svg') }}" alt="Status Kesehatan Stok" class="w-full h-full object-cover object-left-top" />
                                <!-- Efek Blur/Fade Bawah -->
                                <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-[#F8FAFC] via-[#F8FAFC]/80 to-transparent z-10"></div>
                            </div>

                            <div class="p-6 mt-auto">
                                <div class="flex justify-between items-end">
                                    <div class="max-w-[80%]">
                                        <h3 class="text-[24px] font-bold text-black mb-1 font-['Plus_Jakarta_Sans'] tracking-[-0.03em]">
                                            Status Kesehatan Stok
                                        </h3>
                                        <p class="text-[16px] text-[#B3B3B3] font-medium font-['Plus_Jakarta_Sans'] tracking-[-0.03em] leading-tight">
                                            Pantau Kesehatan stok barangmu.
                                        </p>
                                    </div>
                                    <div class="w-10 h-10 flex items-center justify-center transition-transform group-hover:translate-x-1 group-hover:-translate-y-1">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7 17L17 7M17 7H7M17 7V17" stroke="black" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card 4: Integrasi Lintas Platform -->
                        <div class="bg-white rounded-[24px] border border-gray-100 p-0 flex flex-col group cursor-pointer hover:shadow-2xl hover:shadow-blue-500/5 transition-all duration-500 text-left overflow-hidden">
                            <div class="aspect-[5/5] bg-[#F8FAFC] rounded-t-[24px] rounded-b-0 pt-5 pr-5 relative overflow-hidden border-b border-gray-50 flex items-start justify-start">
                                <img src="{{ asset('assets/images/solutions/integrasi-lintas-platform.svg') }}" alt="Integrasi Lintas Platform" class="w-full h-full object-cover object-left-top" />
                                <!-- Efek Blur/Fade Bawah -->
                                <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-[#F8FAFC] via-[#F8FAFC]/80 to-transparent z-10"></div>
                            </div>

                            <div class="p-6 mt-auto">
                                <div class="flex justify-between items-end">
                                    <div class="max-w-[80%]">
                                        <h3 class="text-[24px] font-bold text-black mb-1 font-['Plus_Jakarta_Sans'] tracking-[-0.03em]">
                                            Integrasi Lintas Platform
                                        </h3>
                                        <p class="text-[16px] text-[#B3B3B3] font-medium font-['Plus_Jakarta_Sans'] tracking-[-0.03em] leading-tight">
                                            Integrasikan semua platform penjualan Anda.
                                        </p>
                                    </div>
                                    <div class="w-10 h-10 flex items-center justify-center transition-transform group-hover:translate-x-1 group-hover:-translate-y-1">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7 17L17 7M17 7H7M17 7V17" stroke="black" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 7: Cara Kerja Vern -->
            <section id="cara-kerja" class="pt-24 pb-32 scroll-mt-32 relative overflow-hidden bg-white">
                <!-- Background Wave Dekoratif -->
                <div class="absolute inset-0 z-0 pointer-events-none opacity-20">
                    <svg width="100%" height="100%" viewBox="0 0 1440 800" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full object-cover">
                        <path d="M-100 400C100 250 400 250 600 400C800 550 1100 550 1440 400" stroke="#0077FF" stroke-opacity="0.05" stroke-width="2" />
                    </svg>
                </div>
                <!-- Background Clouds -->
                <div class="absolute inset-x-0 bottom-0 z-0 pointer-events-none">
                    <img src="{{ asset('assets/images/workflow/bg-clouds.svg') }}" alt="" class="w-full h-auto" />
                </div>

                <div class="container mx-auto px-6 relative z-10">
                    <!-- Header Cara Kerja -->
                    <div class="text-center mb-20">
                        <p class="text-[16px] font-bold mb-4 font-['Plus_Jakarta_Sans'] tracking-wider">
                            <span class="text-[#0077FF]">Cara</span>
                            <span class="text-[#808080]"> Kerja</span>
                            <span class="text-[#FF8A00]"> Vern</span>
                        </p>
                        <h2 class="text-[40px] md:text-[48px] font-bold text-black leading-[1.2] mb-6 font-['Plus_Jakarta_Sans'] tracking-[-0.04em] max-w-[800px] mx-auto">
                            Dari stok berantakan jadi <br class="hidden md:inline" /> terkontrol hanya dalam
                            <span class="text-[#0077FF]">30 hari!</span>
                        </h2>
                        <p class="text-[18px] text-[#808080] font-medium font-['Plus_Jakarta_Sans'] max-w-[600px] mx-auto">
                            Ubah stok yang berantakan jadi sistem yang bisa Anda kendalikan.
                        </p>
                    </div>

                    <!-- Timeline & Cards Grid -->
                    <div class="relative max-w-[1050px] mx-auto translate-y-20">
                        <!-- Garis Putus-putus Timeline (Desktop Only) -->
                        <div class="hidden md:block absolute top-[16%] left-[9%] right-[16%] h-[2px] z-0">
                            <svg width="100%" height="2" viewBox="0 0 800 2" fill="none" preserveAspectRatio="none">
                                <!-- Bagian 1: Abu-abu (Hari Ini ke Hari ke-7) -->
                                <line x1="0" y1="1" x2="400" y2="1" stroke="#E5E7EB" stroke-width="2" stroke-dasharray="8 8" />
                                <!-- Bagian 2: Biru (Hari ke-7 ke Hari ke-30) -->
                                <line x1="400" y1="1" x2="800" y2="1" stroke="#0077FF" stroke-width="2" stroke-dasharray="8 8" />
                            </svg>
                        </div>

                        <!-- Grid Konten -->
                        <div class="grid md:grid-cols-3 gap-8 relative z-10">
                            <!-- Step 1: Hari Ini -->
                            <div class="flex flex-col items-center">
                                <div class="w-full">
                                    <img src="{{ asset('assets/images/workflow/hari-ini.svg') }}" alt="Hari Ini" class="w-full h-auto" />
                                </div>
                            </div>

                            <!-- Step 2: Hari ke-7 -->
                            <div class="flex flex-col items-center">
                                <div class="w-full">
                                    <img src="{{ asset('assets/images/workflow/hari-ke-7.svg') }}" alt="Hari ke-7" class="w-full h-auto" />
                                </div>
                            </div>

                            <!-- Step 3: Hari ke-30 -->
                            <div class="flex flex-col items-center">
                                <div class="w-full">
                                    <img src="{{ asset('assets/images/workflow/hari-ke-30.svg') }}" alt="Hari ke-30" class="w-full h-auto" />
                                </div>
                            </div>
                        </div>
            </section>

            <!-- Section 8: Pricing Section -->
            <section id="pricing" class="py-24 bg-[#F2FAFF] font-['Plus_Jakarta_Sans']" x-data>
                <div class="max-w-[1280px] mx-auto px-6">
                    <div class="flex flex-col lg:flex-row justify-between items-center gap-20">
                        
                        <!-- Left Side: Content & Testimonial -->
                        <div class="flex flex-col gap-10 w-full lg:max-w-[400px] flex-shrink-0">
                            <div class="flex flex-col gap-6">
                                <h4 class="text-[16px] font-medium tracking-[-3%]">
                                    <span class="bg-gradient-to-r from-[#0077FF] to-[#FBA518] bg-clip-text text-transparent">Paket</span> 
                                    <span class="text-[#737373]"> dan </span>
                                    <span class="bg-gradient-to-r from-[#0077FF] to-[#FBA518] bg-clip-text text-transparent">Harga</span>
                                </h4>
                                
                                <h2 class="text-[40px] font-bold leading-tight tracking-[-3%] text-black/80">
                                    Dimulai dari yang <br /> Kecil, cocok untuk <br /> kantong anda!
                                </h2>
                            </div>

                            <!-- Marquee Industry Section -->
                            <div class="flex flex-col gap-6">
                                <p class="text-[16px] font-semibold text-[#737373] tracking-[-5%]">
                                    Cocok untuk bisnis di Area
                                </p>
                                
                                <div class="marquee-container relative overflow-hidden">
                                    <div class="marquee-content flex items-center gap-10 flex-nowrap">
                                        <!-- First set of logos -->
                                        <div class="flex-shrink-0"><img src="{{ asset('assets/images/logos/industries/RETAIL.svg') }}" alt="Retail" class="h-[15px] w-auto grayscale opacity-100 hover:grayscale-0 transition-all duration-300" /></div>
                                        <div class="flex-shrink-0"><img src="{{ asset('assets/images/logos/industries/F&B.svg') }}" alt="F&B" class="h-[15px] w-auto grayscale opacity-100 hover:grayscale-0 transition-all duration-300" /></div>
                                        <div class="flex-shrink-0"><img src="{{ asset('assets/images/logos/industries/GARMEN.svg') }}" alt="Garmen" class="h-[15px] w-auto grayscale opacity-100 hover:grayscale-0 transition-all duration-300" /></div>
                                        <div class="flex-shrink-0"><img src="{{ asset('assets/images/logos/industries/E-COMMERCE.svg') }}" alt="E-Commerce" class="h-[15px] w-auto grayscale opacity-100 hover:grayscale-0 transition-all duration-300" /></div>
                                        <!-- Duplicate set for infinite loop -->
                                        <div class="flex-shrink-0"><img src="{{ asset('assets/images/logos/industries/RETAIL.svg') }}" alt="Retail" class="h-[15px] w-auto grayscale opacity-100 hover:grayscale-0 transition-all duration-300" /></div>
                                        <div class="flex-shrink-0"><img src="{{ asset('assets/images/logos/industries/F&B.svg') }}" alt="F&B" class="h-[15px] w-auto grayscale opacity-100 hover:grayscale-0 transition-all duration-300" /></div>
                                        <div class="flex-shrink-0"><img src="{{ asset('assets/images/logos/industries/GARMEN.svg') }}" alt="Garmen" class="h-[15px] w-auto grayscale opacity-100 hover:grayscale-0 transition-all duration-300" /></div>
                                        <div class="flex-shrink-0"><img src="{{ asset('assets/images/logos/industries/E-COMMERCE.svg') }}" alt="E-Commerce" class="h-[15px] w-auto grayscale opacity-100 hover:grayscale-0 transition-all duration-300" /></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Testimonial -->
                            <div class="mt-12 flex flex-col gap-6">
                                <p class="text-[18px] font-bold text-[#B3B3B3] italic tracking-[-3%] font-['Caveat'] leading-relaxed">
                                    “Kami memberikan harga affordable dengan memberikan Value <br /> dari Vern secara maksimal untuk membantu bisnis anda <br /> tumbuh.”
                                </p>
                                
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 rounded-xl overflow-hidden">
                                        <img src="{{ asset('assets/images/photos/pricing/niko-profile.svg') }}" alt="Niko Profile" class="w-full h-full object-cover" />
                                    </div>
                                    <div class="flex flex-col">
                                        <p class="text-[18px] font-semibold text-black tracking-[-3%]">Niko</p>
                                        <p class="text-[14px] font-semibold text-black tracking-[-3%] opacity-60">COO Vern</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side: Pricing Cards -->
                        <div class="flex-1 w-full max-w-[850px]">
                            <div class="grid md:grid-cols-2 gap-8 items-start">
                                <!-- Pro Card -->
                                <div class="bg-white rounded-[20px] shadow-pricing flex flex-col overflow-hidden w-full">
                                    <div class="p-8 bg-[#FBFBFB] flex flex-col gap-4">
                                        <h3 class="text-[24px] font-semibold tracking-[-3%] text-black">Pro</h3>
                                        <p class="text-[12px] text-[#737373] opacity-60">Automation untuk operasional harian</p>
                                        
                                        <div class="flex flex-col gap-1 mt-2">
                                            <div class="flex items-baseline gap-2">
                                                <span class="text-[32px] font-bold bg-gradient-to-r from-[#0077FF] to-[#FBA518] bg-clip-text text-transparent tracking-[-3%]">IDR 99.000</span>
                                                <span class="text-[14px] text-[#737373] opacity-60">/Bulan</span>
                                            </div>
                                            <p class="text-[12px] text-[#737373] leading-relaxed opacity-80">
                                                Solusi untuk bisnis yang mulai butuh kontrol inventory lebih rapi dan insight operasional.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="p-8 bg-white flex flex-col gap-6 border-t border-black/5">
                                        <h4 class="text-[14px] font-semibold tracking-[-3%] text-[#B3B3B3]">FITUR KUNCI</h4>
                                        
                                        <ul class="flex flex-col gap-4">
                                            <li class="flex items-center gap-3 border-b border-black/5 pb-4">
                                                <img src="{{ asset('assets/images/icons/pricing/Stock Gap Analysis.svg') }}" alt="Stock Gap Analysis" class="w-5 h-5 flex-shrink-0" />
                                                <span class="text-[14px] font-medium tracking-[-3%] text-black">Stock Gap Analysis</span>
                                            </li>
                                            <li class="flex items-center gap-3 border-b border-black/5 pb-4">
                                                <img src="{{ asset('assets/images/icons/pricing/Inventory Monitoring.svg') }}" alt="Inventory Monitoring" class="w-5 h-5 flex-shrink-0" />
                                                <span class="text-[14px] font-medium tracking-[-3%] text-black">Inventory Monitoring</span>
                                            </li>
                                            <li class="flex items-center gap-3 border-b border-black/5 pb-4">
                                                <img src="{{ asset('assets/images/icons/pricing/Dashboard Sederhana.svg') }}" alt="Dashboard Sederhana" class="w-5 h-5 flex-shrink-0" />
                                                <span class="text-[14px] font-medium tracking-[-3%] text-black">Dashboard Sederhana</span>
                                            </li>
                                            <li class="flex items-center gap-3 border-b border-black/5 pb-4">
                                                <img src="{{ asset('assets/images/icons/pricing/Laporan Inventory Otomatis.svg') }}" alt="Laporan Inventory Otomatis" class="w-5 h-5 flex-shrink-0" />
                                                <span class="text-[14px] font-medium tracking-[-3%] text-black">Laporan Inventory Otomatis</span>
                                            </li>
                                            <li class="flex items-center gap-3 border-b border-black/5 pb-4">
                                                <img src="{{ asset('assets/images/icons/pricing/Moving Detection.svg') }}" alt="Moving Detection" class="w-5 h-5 flex-shrink-0" />
                                                <span class="text-[14px] font-medium tracking-[-3%] text-black">Moving Detection</span>
                                            </li>
                                            <li class="flex items-center gap-3 border-b border-black/5 pb-4">
                                                <img src="{{ asset('assets/images/icons/pricing/3 Role Maksimal.svg') }}" alt="3 Role Maksimal" class="w-5 h-5 flex-shrink-0" />
                                                <span class="text-[14px] font-medium tracking-[-3%] text-black">3 Role Maksimal</span>
                                            </li>
                                        </ul>

                                        <div class="mt-4 flex flex-col items-center gap-4">
                                            <button @click="$dispatch('open-checkout', { package: 'Pro', price: 'IDR 99.000' })" class="w-full bg-black text-white h-[56px] rounded-[12px] flex items-center justify-center gap-3 font-semibold text-[16px] tracking-[-3%] hover:opacity-90 transition-opacity cursor-pointer">
                                                <img src="{{ asset('assets/images/icons/pricing/Mulai Menggunakan Vern icon button.svg') }}" class="w-5 h-5" />
                                                Mulai Menggunakan Vern
                                            </button>
                                            <p class="font-['Caveat'] font-bold text-[16px] text-black tracking-[-3%]">Bisa pakai Qris</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Enterprise Card -->
                                <div class="bg-white rounded-[20px] shadow-pricing flex flex-col overflow-hidden w-full">
                                    <div class="p-8 bg-[#FBFBFB] flex flex-col gap-4">
                                        <h3 class="text-[24px] font-semibold tracking-[-3%] text-black">Enterprise</h3>
                                        <p class="text-[12px] text-[#737373] opacity-60">Control penuh untuk multi-warehouse & scale</p>
                                        
                                        <div class="flex flex-col gap-1 mt-2">
                                            <div class="flex items-baseline gap-2">
                                                <span class="text-[32px] font-bold bg-gradient-to-r from-[#0077FF] to-[#FBA518] bg-clip-text text-transparent tracking-[-3%]">IDR 199.000</span>
                                                <span class="text-[14px] text-[#737373] opacity-60">/Bulan</span>
                                            </div>
                                            <p class="text-[12px] text-[#737373] leading-relaxed opacity-80">
                                                Dirancang untuk bisnis yang butuh visibilitas penuh, kontrol cabang, dan analitik mendalam.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="p-8 bg-white flex flex-col gap-6 border-t border-black/5">
                                        <h4 class="text-[14px] font-semibold tracking-[-3%] text-[#B3B3B3]">EVERYTHING IN PRO +</h4>
                                        
                                        <ul class="flex flex-col gap-4">
                                            <li class="flex items-center gap-3 border-b border-black/5 pb-4">
                                                <img src="{{ asset('assets/images/icons/pricing/AI Feature untuk prediksi & insight.svg') }}" alt="AI Feature untuk prediksi & insight" class="w-5 h-5 flex-shrink-0" />
                                                <span class="text-[14px] font-medium tracking-[-3%] text-black">AI Feature untuk prediksi & insight</span>
                                            </li>
                                            <li class="flex items-center gap-3 border-b border-black/5 pb-4">
                                                <img src="{{ asset('assets/images/icons/pricing/Branch warehouse controlling.svg') }}" alt="Branch warehouse controlling" class="w-5 h-5 flex-shrink-0" />
                                                <span class="text-[14px] font-medium tracking-[-3%] text-black">Branch warehouse controlling</span>
                                            </li>
                                            <li class="flex items-center gap-3 border-b border-black/5 pb-4">
                                                <img src="{{ asset('assets/images/icons/pricing/Shrinkage monitoring.svg') }}" alt="Shrinkage monitoring" class="w-5 h-5 flex-shrink-0" />
                                                <span class="text-[14px] font-medium tracking-[-3%] text-black">Shrinkage monitoring</span>
                                            </li>
                                            <li class="flex items-center gap-3 border-b border-black/5 pb-4">
                                                <img src="{{ asset('assets/images/icons/pricing/Supplier analysis.svg') }}" alt="Supplier analysis" class="w-5 h-5 flex-shrink-0" />
                                                <span class="text-[14px] font-medium tracking-[-3%] text-black">Supplier analysis</span>
                                            </li>
                                            <li class="flex items-center gap-3 border-b border-black/5 pb-4">
                                                <img src="{{ asset('assets/images/icons/pricing/Dashboard analitik lengkap.svg') }}" alt="Dashboard analitik lengkap" class="w-5 h-5 flex-shrink-0" />
                                                <span class="text-[14px] font-medium tracking-[-3%] text-black">Dashboard analitik lengkap</span>
                                            </li>
                                            <li class="flex items-center gap-3 border-b border-black/5 pb-4">
                                                <img src="{{ asset('assets/images/icons/pricing/Advanced reporting & decision support.svg') }}" alt="Advanced reporting & decision support" class="w-5 h-5 flex-shrink-0" />
                                                <span class="text-[14px] font-medium tracking-[-3%] text-black">Advanced reporting & decision support</span>
                                            </li>
                                        </ul>

                                        <div class="mt-4 flex flex-col items-center gap-4">
                                            <button @click="$dispatch('open-checkout', { package: 'Enterprise', price: 'IDR 199.000' })" class="w-full bg-black text-white h-[56px] rounded-[12px] flex items-center justify-center gap-3 font-semibold text-[16px] tracking-[-3%] hover:opacity-90 transition-opacity cursor-pointer">
                                                <img src="{{ asset('assets/images/icons/pricing/Upgrade ke Enterprise icon button.svg') }}" class="w-5 h-5" />
                                                Upgrade ke Enterprise
                                            </button>
                                            <p class="font-['Caveat'] font-bold text-[16px] text-[#737373] tracking-[-3%]">Support Fitur add-on</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 9: FAQ Section -->
            <section id="faq" class="py-32 bg-white font-['Plus_Jakarta_Sans']">
                <div class="max-w-[1280px] mx-auto px-6">
                    <div class="flex flex-col lg:flex-row justify-between items-start gap-20">
                        
                        <!-- Left Side: Header -->
                        <div class="flex flex-col gap-4 lg:max-w-[400px] flex-shrink-0">
                            <h4 class="text-[16px] font-bold text-[#0077FF] tracking-tight uppercase">FAQ</h4>
                            <h2 class="text-[40px] font-bold leading-[1.2] tracking-[-3%] text-black/80">
                                Hal hal yang sering <br /> ditanyakan Teman <br /> UMKM.
                            </h2>
                        </div>

                        <!-- Right Side: Accordion (Alpine.js) -->
                        <div x-data="{ activeIndex: 0 }" class="flex-1 w-full max-w-[800px]">
                            <div class="flex flex-col">
                                
                                <!-- FAQ 1 -->
                                <div class="border-b border-black/5 last:border-0">
                                    <button @click="activeIndex = activeIndex === 0 ? -1 : 0" class="w-full py-8 flex justify-between items-center text-left group transition-all duration-300 cursor-pointer">
                                        <span class="text-[32px] font-semibold tracking-[-5%] transition-colors duration-300" :class="activeIndex === 0 ? 'text-black' : 'text-black/80 group-hover:text-black'">
                                            Apa itu Vern?
                                        </span>
                                        <div class="flex-shrink-0 ml-4">
                                            <img :src="activeIndex === 0 ? '{{ asset('assets/images/icons/faq/close.svg') }}' : '{{ asset('assets/images/icons/faq/plus.svg') }}'" :alt="activeIndex === 0 ? 'Close' : 'Open'" class="w-10 h-10 transition-transform duration-300" :class="activeIndex === 0 ? 'rotate-0' : 'group-hover:scale-110'" />
                                        </div>
                                    </button>

                                    <!-- Answer with Transition -->
                                    <div class="overflow-hidden transition-all duration-500 ease-in-out" :style="activeIndex === 0 ? 'max-height: 200px; opacity: 1;' : 'max-height: 0px; opacity: 0;'">
                                        <div class="pb-10">
                                            <p class="text-[24px] font-medium text-[#B3B3B3] tracking-[-5%] leading-relaxed max-w-[700px]">
                                                Vern adalah platform inventory Intelligence untuk membantu UMKM mengontrol visibilitas Inventory mereka.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- FAQ 2 -->
                                <div class="border-b border-black/5 last:border-0">
                                    <button @click="activeIndex = activeIndex === 1 ? -1 : 1" class="w-full py-8 flex justify-between items-center text-left group transition-all duration-300 cursor-pointer">
                                        <span class="text-[32px] font-semibold tracking-[-5%] transition-colors duration-300" :class="activeIndex === 1 ? 'text-black' : 'text-black/80 group-hover:text-black'">
                                            Apakah jika bertanya gratis?
                                        </span>
                                        <div class="flex-shrink-0 ml-4">
                                            <img :src="activeIndex === 1 ? '{{ asset('assets/images/icons/faq/close.svg') }}' : '{{ asset('assets/images/icons/faq/plus.svg') }}'" :alt="activeIndex === 1 ? 'Close' : 'Open'" class="w-10 h-10 transition-transform duration-300" :class="activeIndex === 1 ? 'rotate-0' : 'group-hover:scale-110'" />
                                        </div>
                                    </button>

                                    <!-- Answer with Transition -->
                                    <div class="overflow-hidden transition-all duration-500 ease-in-out" :style="activeIndex === 1 ? 'max-height: 200px; opacity: 1;' : 'max-height: 0px; opacity: 0;'">
                                        <div class="pb-10">
                                            <p class="text-[24px] font-medium text-[#B3B3B3] tracking-[-5%] leading-relaxed max-w-[700px]">
                                                Arsanix adalah platform agregatror antara Developer dan user untuk mencapai kesepakatan dalam kemudahan membeli rumah
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- FAQ 3 -->
                                <div class="border-b border-black/5 last:border-0">
                                    <button @click="activeIndex = activeIndex === 2 ? -1 : 2" class="w-full py-8 flex justify-between items-center text-left group transition-all duration-300 cursor-pointer">
                                        <span class="text-[32px] font-semibold tracking-[-5%] transition-colors duration-300" :class="activeIndex === 2 ? 'text-black' : 'text-black/80 group-hover:text-black'">
                                            Berapa lama inventoryku bisa dikontrol?
                                        </span>
                                        <div class="flex-shrink-0 ml-4">
                                            <img :src="activeIndex === 2 ? '{{ asset('assets/images/icons/faq/close.svg') }}' : '{{ asset('assets/images/icons/faq/plus.svg') }}'" :alt="activeIndex === 2 ? 'Close' : 'Open'" class="w-10 h-10 transition-transform duration-300" :class="activeIndex === 2 ? 'rotate-0' : 'group-hover:scale-110'" />
                                        </div>
                                    </button>

                                    <!-- Answer with Transition -->
                                    <div class="overflow-hidden transition-all duration-500 ease-in-out" :style="activeIndex === 2 ? 'max-height: 200px; opacity: 1;' : 'max-height: 0px; opacity: 0;'">
                                        <div class="pb-10">
                                            <p class="text-[24px] font-medium text-[#B3B3B3] tracking-[-5%] leading-relaxed max-w-[700px]">
                                                Arsanix adalah platform agregatror antara Developer dan user untuk mencapai kesepakatan dalam kemudahan membeli rumah
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- FAQ 4 -->
                                <div class="border-b border-black/5 last:border-0">
                                    <button @click="activeIndex = activeIndex === 3 ? -1 : 3" class="w-full py-8 flex justify-between items-center text-left group transition-all duration-300 cursor-pointer">
                                        <span class="text-[32px] font-semibold tracking-[-5%] transition-colors duration-300" :class="activeIndex === 3 ? 'text-black' : 'text-black/80 group-hover:text-black'">
                                            Berapa biaya langganan Vern?
                                        </span>
                                        <div class="flex-shrink-0 ml-4">
                                            <img :src="activeIndex === 3 ? '{{ asset('assets/images/icons/faq/close.svg') }}' : '{{ asset('assets/images/icons/faq/plus.svg') }}'" :alt="activeIndex === 3 ? 'Close' : 'Open'" class="w-10 h-10 transition-transform duration-300" :class="activeIndex === 3 ? 'rotate-0' : 'group-hover:scale-110'" />
                                        </div>
                                    </button>

                                    <!-- Answer with Transition -->
                                    <div class="overflow-hidden transition-all duration-500 ease-in-out" :style="activeIndex === 3 ? 'max-height: 200px; opacity: 1;' : 'max-height: 0px; opacity: 0;'">
                                        <div class="pb-10">
                                            <p class="text-[24px] font-medium text-[#B3B3B3] tracking-[-5%] leading-relaxed max-w-[700px]">
                                                Arsanix adalah platform agregatror antara Developer dan user untuk mencapai kesepakatan dalam kemudahan membeli rumah
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </section>

            <!-- Section 10: Contact Section -->
            <section id="contact" class="relative py-32 overflow-hidden font-['Plus_Jakarta_Sans'] bg-[#0077FF]">
                <!-- Boxes Background SVG - Pushed lower -->
                <div class="absolute bottom-[-60px] left-0 w-full z-0">
                    <img src="{{ asset('assets/images/backgrounds/contact-boxes.svg') }}" class="w-full h-auto object-cover opacity-100" alt="Boxes Decoration" />
                </div>

                <div class="max-w-[1280px] mx-auto px-6 relative z-10">
                    <div class="flex flex-col lg:flex-row justify-between items-center gap-16">
                        
                        <!-- Left Side: Content -->
                        <div class="flex flex-col gap-10 lg:max-w-[500px]">
                            <div class="flex flex-col gap-6">
                                <h2 class="text-[36px] font-semibold leading-tight tracking-[-3%] text-white">
                                    Lihat bagaimana Vern membantu mengontrol stok dan meningkatkan profit bisnismu.
                                </h2>
                                <p class="text-[18px] font-medium leading-relaxed tracking-[-5%] text-white/90">
                                    Dapatkan demo singkat dan lihat langsung bagaimana Vern mempermudah pencatatan, meminimalkan selisih stok, dan bantu kamu ambil keputusan lebih cepat.
                                </p>
                            </div>

                            <!-- Checklist -->
                            <ul class="flex flex-col gap-6">
                                <li class="flex items-start gap-4">
                                    <img src="{{ asset('assets/images/icons/contact/check-white.svg') }}" alt="Check" class="w-6 h-6 flex-shrink-0 mt-0.5" />
                                    <p class="text-[14px] font-medium tracking-[-3%] text-white">
                                        Kurangi pencatatan manual yang rawan error
                                    </p>
                                </li>
                                <li class="flex items-start gap-4">
                                    <img src="{{ asset('assets/images/icons/contact/check-white.svg') }}" alt="Check" class="w-6 h-6 flex-shrink-0 mt-0.5" />
                                    <p class="text-[14px] font-medium tracking-[-3%] text-white">
                                        Pantau stok & pergerakan barang secara real-time
                                    </p>
                                </li>
                                <li class="flex items-start gap-4">
                                    <img src="{{ asset('assets/images/icons/contact/check-white.svg') }}" alt="Check" class="w-6 h-6 flex-shrink-0 mt-0.5" />
                                    <p class="text-[14px] font-medium tracking-[-3%] text-white">
                                        Hindari dead stock & kehabisan barang
                                    </p>
                                </li>
                            </ul>
                        </div>

                        <!-- Right Side: Form Card (Alpine.js) -->
                        <div class="w-full max-w-[550px]" x-data="{ nama: '', namaToko: '', nomorWhatsapp: '', metodeKelola: 'Manual' }">
                            <div class="bg-white rounded-[10px] p-10 shadow-2xl relative z-20">
                                <!-- Form Header -->
                                <div class="flex flex-col gap-6 mb-10">
                                    <img src="{{ asset('assets/images/logos/vern-logo-black.svg') }}" alt="Vern" class="h-8 w-auto self-start" />
                                    <div class="flex flex-col gap-2">
                                        <h3 class="text-[28px] font-bold tracking-[-3%] text-black/80">
                                            Jadwalkan Demo Gratis 15 Menit
                                        </h3>
                                        <p class="text-[18px] font-medium tracking-[-5%] text-[#737373]">
                                            Tim kami akan bantu memahami kebutuhan bisnismu dan menunjukkan cara kerja Vern secara langsung.
                                        </p>
                                    </div>
                                </div>

                                <!-- Form -->
                                <form action="#" method="POST" @submit.prevent="console.log('Form Submitted:', { nama, namaToko, nomorWhatsapp, metodeKelola })" class="flex flex-col gap-6">
                                    @csrf
                                    <div class="flex flex-col gap-2">
                                        <label class="text-[16px] font-semibold text-black/80">Nama*</label>
                                        <input 
                                            x-model="nama"
                                            type="text" 
                                            placeholder="Masukkan nama anda"
                                            class="h-[56px] px-5 bg-[#FAFAFA] rounded-[10px] border border-black/10 focus:outline-none focus:border-black/20 transition-all text-[14px]"
                                            required
                                        />
                                    </div>

                                    <div class="flex flex-col gap-2">
                                        <label class="text-[16px] font-semibold text-black/80">Nama Toko*</label>
                                        <input 
                                            x-model="namaToko"
                                            type="text" 
                                            placeholder="Masukkan nama toko anda"
                                            class="h-[56px] px-5 bg-[#FAFAFA] rounded-[10px] border border-black/10 focus:outline-none focus:border-black/20 transition-all text-[14px]"
                                            required
                                        />
                                    </div>

                                    <div class="flex flex-col gap-2">
                                        <label class="text-[16px] font-semibold text-black/80">Nomor Whatsapp*</label>
                                        <input 
                                            x-model="nomorWhatsapp"
                                            type="text" 
                                            placeholder="Masukkan nomor Whatsapp anda"
                                            class="h-[56px] px-5 bg-[#FAFAFA] rounded-[10px] border border-black/10 focus:outline-none focus:border-black/20 transition-all text-[14px]"
                                            required
                                        />
                                    </div>

                                    <!-- Radio Options (Circular Style) -->
                                    <div class="flex flex-col gap-4 mt-2">
                                        <p class="text-[16px] font-semibold text-black/80">Saat ini mengelola stok dengan?</p>
                                        <div class="flex flex-wrap gap-6">
                                            
                                            <!-- Option Manual -->
                                            <label class="flex items-center gap-3 cursor-pointer group">
                                                <div class="relative w-5 h-5">
                                                    <input 
                                                        type="radio" 
                                                        value="Manual" 
                                                        x-model="metodeKelola"
                                                        class="peer absolute inset-0 opacity-0 cursor-pointer z-10"
                                                    />
                                                    <!-- Outer Circle -->
                                                    <div class="w-full h-full border-2 rounded-full transition-all duration-300"
                                                        :class="metodeKelola === 'Manual' ? 'border-[#0077FF]' : 'border-black/10 group-hover:border-black/20'"
                                                    ></div>
                                                    <!-- Inner Dot -->
                                                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-2.5 h-2.5 bg-[#0077FF] rounded-full transition-all duration-300 opacity-0 scale-0"
                                                        :class="metodeKelola === 'Manual' ? 'opacity-100 scale-100' : ''"
                                                    ></div>
                                                </div>
                                                <span class="text-[14px] font-medium transition-colors duration-300"
                                                    :class="metodeKelola === 'Manual' ? 'text-[#0077FF]' : 'text-black/80'"
                                                >
                                                    Manual
                                                </span>
                                            </label>

                                            <!-- Option Excel -->
                                            <label class="flex items-center gap-3 cursor-pointer group">
                                                <div class="relative w-5 h-5">
                                                    <input 
                                                        type="radio" 
                                                        value="Excel" 
                                                        x-model="metodeKelola"
                                                        class="peer absolute inset-0 opacity-0 cursor-pointer z-10"
                                                    />
                                                    <!-- Outer Circle -->
                                                    <div class="w-full h-full border-2 rounded-full transition-all duration-300"
                                                        :class="metodeKelola === 'Excel' ? 'border-[#0077FF]' : 'border-black/10 group-hover:border-black/20'"
                                                    ></div>
                                                    <!-- Inner Dot -->
                                                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-2.5 h-2.5 bg-[#0077FF] rounded-full transition-all duration-300 opacity-0 scale-0"
                                                        :class="metodeKelola === 'Excel' ? 'opacity-100 scale-100' : ''"
                                                    ></div>
                                                </div>
                                                <span class="text-[14px] font-medium transition-colors duration-300"
                                                    :class="metodeKelola === 'Excel' ? 'text-[#0077FF]' : 'text-black/80'"
                                                >
                                                    Excel
                                                </span>
                                            </label>

                                            <!-- Option Belum ada sistem -->
                                            <label class="flex items-center gap-3 cursor-pointer group">
                                                <div class="relative w-5 h-5">
                                                    <input 
                                                        type="radio" 
                                                        value="Belum ada sistem" 
                                                        x-model="metodeKelola"
                                                        class="peer absolute inset-0 opacity-0 cursor-pointer z-10"
                                                    />
                                                    <!-- Outer Circle -->
                                                    <div class="w-full h-full border-2 rounded-full transition-all duration-300"
                                                        :class="metodeKelola === 'Belum ada sistem' ? 'border-[#0077FF]' : 'border-black/10 group-hover:border-black/20'"
                                                    ></div>
                                                    <!-- Inner Dot -->
                                                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-2.5 h-2.5 bg-[#0077FF] rounded-full transition-all duration-300 opacity-0 scale-0"
                                                        :class="metodeKelola === 'Belum ada sistem' ? 'opacity-100 scale-100' : ''"
                                                    ></div>
                                                </div>
                                                <span class="text-[14px] font-medium transition-colors duration-300"
                                                    :class="metodeKelola === 'Belum ada sistem' ? 'text-[#0077FF]' : 'text-black/80'"
                                                >
                                                    Belum ada sistem
                                                </span>
                                            </label>

                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <button 
                                        type="submit"
                                        class="mt-4 w-full h-[56px] bg-black text-white rounded-[10px] flex items-center justify-center gap-3 font-bold text-[16px] hover:bg-black/90 transition-all cursor-pointer"
                                    >
                                        Dapatkan Demo Gratis
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7 17L17 7M17 7H7M17 7V17" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </main>

        <!-- Footer Section -->
        <footer class="relative pt-[18px] overflow-hidden bg-white border-t border-black/5">
            <div class="max-w-[1280px] mx-auto px-6 relative pb-32">
                <!-- Giant Background Decoration - Perfectly at the bottom -->
                <div class="absolute bottom-0 left-0 w-full z-0 pointer-events-none">
                    <img src="{{ asset('assets/images/backgrounds/footer-brand-bg.svg') }}" class="w-full h-auto block opacity-100" alt="Vern Decoration" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 lg:gap-8 mb-40 relative z-10">
                    
                    <!-- Column 1: Brand -->
                    <div class="lg:col-span-4 flex flex-col gap-6">
                        <img src="{{ asset('assets/images/backgrounds/logo.svg') }}" alt="Vern Logo" class="h-8 w-auto self-start" />
                        <p class="text-[14px] font-medium text-[#8B8E97] font-['Plus_Jakarta_Sans'] leading-relaxed max-w-[280px]">
                            Lacak Inventori dan Hindari kerugian yang tidak anda Sadari
                        </p>
                        <p class="mt-8 text-[14px] font-normal text-[#797979] font-['DM_Sans'] leading-[140%] relative z-20">
                            Vern Team @ 2026. All rights Reserved.
                        </p>
                    </div>

                    <!-- Column 2: Menu -->
                    <div class="lg:col-span-2 flex flex-col gap-6">
                        <h4 class="text-[19.2px] font-semibold text-black tracking-[-3%] font-['Plus_Jakarta_Sans']">
                            Menu
                        </h4>
                        <ul class="flex flex-col gap-4">
                            <li><a href="{{ route('about') }}" wire:navigate class="text-sm font-medium text-[#4A4A4A] hover:text-[#0077FF] transition-colors tracking-[-3%] font-['Plus_Jakarta_Sans']">Tentang Kami</a></li>
                            <li><a href="{{ route('casestudy') }}" wire:navigate class="text-sm font-medium text-[#4A4A4A] hover:text-[#0077FF] transition-colors tracking-[-3%] font-['Plus_Jakarta_Sans']">Studi Kasus</a></li>
                            <li><a href="#" class="text-[13.33px] font-medium text-[#4A4A4A] hover:text-[#0077FF] transition-colors tracking-[-3%] font-['Plus_Jakarta_Sans']">Fitur Utama</a></li>
                            <li><a href="#" class="text-[13.33px] font-medium text-[#4A4A4A] hover:text-[#0077FF] transition-colors tracking-[-3%] font-['Plus_Jakarta_Sans']">Tim</a></li>
                        </ul>
                    </div>

                    <!-- Column 3: Sosial -->
                    <div class="lg:col-span-2 flex flex-col gap-6">
                        <h4 class="text-[19.2px] font-semibold text-black tracking-[-3%] font-['Plus_Jakarta_Sans']">
                            Sosial
                        </h4>
                        <ul class="flex flex-col gap-4">
                            <li><a href="#" class="text-[13.33px] font-medium text-[#4A4A4A] hover:text-[#0077FF] transition-colors tracking-[-3%] font-['Plus_Jakarta_Sans']">Instagram</a></li>
                            <li><a href="#" class="text-[13.33px] font-medium text-[#4A4A4A] hover:text-[#0077FF] transition-colors tracking-[-3%] font-['Plus_Jakarta_Sans']">X</a></li>
                            <li><a href="#" class="text-[13.33px] font-medium text-[#4A4A4A] hover:text-[#0077FF] transition-colors tracking-[-3%] font-['Plus_Jakarta_Sans']">Facebook</a></li>
                            <li><a href="#" class="text-[13.33px] font-medium text-[#4A4A4A] hover:text-[#0077FF] transition-colors tracking-[-3%] font-['Plus_Jakarta_Sans']">TikTok</a></li>
                        </ul>
                    </div>

                    <!-- Column 4: Newsletter -->
                    <div class="lg:col-span-4 flex flex-col gap-6">
                        <div class="flex flex-col gap-3">
                            <h4 class="text-[24px] font-semibold text-black tracking-[-3%] font-['Plus_Jakarta_Sans']">
                                Dapatkan Insight Inventori yang Menghasilkan Profit
                            </h4>
                            <p class="text-[12px] font-medium text-[#8B8E97] tracking-[-3%] font-['Plus_Jakarta_Sans'] leading-relaxed max-w-[340px]">
                                Tips, tren, dan strategi praktis untuk mengurangi kerugian, mengoptimalkan stok, dan meningkatkan efisiensi langsung to inbox Anda.
                            </p>
                        </div>

                        <!-- Newsletter Input Group (Alpine.js) -->
                        <div class="relative w-full max-w-[350px]" x-data="{ email: '' }">
                            <div class="flex items-center h-[45px] bg-white rounded-full border border-black/10 pl-[17px] pr-[4px] group focus-within:border-black/20 transition-all">
                                <input 
                                    x-model="email"
                                    type="email" 
                                    placeholder="Masukkan Email anda"
                                    class="flex-1 h-full bg-transparent outline-none text-[13.33px] text-black placeholder:text-[#8B8E97]"
                                />
                                <button 
                                    @click="console.log('Subscribing:', email)"
                                    class="h-[37px] pl-6 pr-4 bg-[#0077FF] text-white rounded-full flex items-center gap-3 transition-all cursor-pointer hover:bg-[#0066EE]"
                                >
                                    <span class="text-[14px] font-bold">Kirim</span>
                                    <img src="{{ asset('assets/images/icons/footer/send-arrow.svg') }}" alt="Send" class="w-5 h-5" />
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </footer>

        <!-- GSAP Text Reveal Animation Script -->
        <script>
            function initTextReveal() {
                // Kill previous ScrollTrigger instances to avoid memory leaks/conflicts during SPA navigation
                if (typeof ScrollTrigger !== 'undefined') {
                    ScrollTrigger.getAll().forEach(t => t.kill());
                }

                // Registrasi ScrollTrigger ke GSAP
                if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
                    gsap.registerPlugin(ScrollTrigger);
                }

                // Tunggu font sampai benar-benar siap
                if (document.fonts && document.fonts.ready) {
                    document.fonts.ready.then(() => {
                        setTimeout(runSplitAndGsap, 500);
                    });
                } else {
                    setTimeout(runSplitAndGsap, 500);
                }

                function runSplitAndGsap() {
                    const splitTypes = document.querySelectorAll(".reveal-type");

                    splitTypes.forEach((element) => {
                        const bg = element.dataset.bgColor || "#cccccc";
                        const fg = element.dataset.fgColor || "#000000";

                        if (typeof SplitType !== 'undefined' && typeof gsap !== 'undefined') {
                            const text = new SplitType(element, { types: "words,chars" });

                            gsap.from(text.chars, {
                                color: bg,
                                stagger: 0.1,
                                scrollTrigger: {
                                    trigger: element,
                                    start: "top 80%",
                                    end: "bottom 40%",
                                    scrub: true,
                                    markers: false,
                                },
                            });
                        }
                    });

                    if (typeof ScrollTrigger !== 'undefined') {
                        ScrollTrigger.refresh();
                    }
                }
            }

            // Run on initial page load
            document.addEventListener('DOMContentLoaded', initTextReveal);
            // Run on Livewire SPA navigation
            document.addEventListener('livewire:navigated', initTextReveal);
        </script>

        <!-- Checkout Modal -->
        <div x-data="{
            open: false,
            loading: false,
            packageName: '',
            priceText: '',
            form: {
                customer_name: '',
                email: '',
                whatsapp: ''
            },
            errorMessage: '',
            openCheckout(pkg, price) {
                this.packageName = pkg;
                this.priceText = price;
                this.open = true;
                this.errorMessage = '';
                this.form.customer_name = '';
                this.form.email = '';
                this.form.whatsapp = '';
            },
            async submitCheckout() {
                this.loading = true;
                this.errorMessage = '';
                try {
                    const response = await fetch('/package-orders', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            customer_name: this.form.customer_name,
                            email: this.form.email,
                            whatsapp: this.form.whatsapp,
                            package_name: this.packageName
                        })
                    });

                    const data = await response.json();
                    if (response.ok && data.success) {
                        if (window.snap) {
                            window.snap.pay(data.token, {
                                onSuccess: (result) => {
                                    this.open = false;
                                    window.location.reload();
                                },
                                onPending: (result) => {
                                    this.open = false;
                                    window.location.reload();
                                },
                                onError: (result) => {
                                    this.errorMessage = 'Pembayaran gagal. Silakan coba lagi.';
                                },
                                onClose: () => {}
                            });
                        } else {
                            window.location.href = data.redirect_url;
                        }
                    } else {
                        this.errorMessage = data.message || 'Terjadi kesalahan saat memproses pembayaran.';
                    }
                } catch (err) {
                    this.errorMessage = 'Gagal menghubungkan ke server: ' + err.message;
                } finally {
                    this.loading = false;
                }
            }
        }" @open-checkout.window="openCheckout($event.detail.package, $event.detail.price)"
           x-show="open" 
           class="fixed inset-0 z-[2000] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="opacity-0"
           x-transition:enter-end="opacity-100"
           x-transition:leave="transition ease-in duration-200"
           x-transition:leave-start="opacity-100"
           x-transition:leave-end="opacity-0"
           style="display: none;">
             
             <div class="bg-white rounded-2xl w-full max-w-[480px] overflow-hidden shadow-2xl relative"
                  @click.away="if (!loading) open = false"
                  x-transition:enter="transition ease-out duration-300 transform"
                  x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                  x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                  x-transition:leave="transition ease-in duration-200 transform"
                  x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                  x-transition:leave-end="opacity-0 translate-y-4 scale-95">
                  
                  <!-- Modal Header -->
                  <div class="p-6 bg-gradient-to-r from-[#0077FF] to-[#0055CC] text-white">
                      <h3 class="text-xl font-bold">Formulir Langganan Vern</h3>
                      <p class="text-sm opacity-90 mt-1">Lengkapi data Anda untuk melanjutkan pembayaran</p>
                      
                      <!-- Close Button -->
                      <button @click="open = false" :disabled="loading" class="absolute top-4 right-4 text-white/80 hover:text-white disabled:opacity-50">
                          <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                              <path d="M18 6L6 18M6 6l12 12"/>
                          </svg>
                      </button>
                  </div>

                  <!-- Modal Body -->
                  <form @submit.prevent="submitCheckout" class="p-6 flex flex-col gap-4">
                      <!-- Selected Package Info Card -->
                      <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex items-center justify-between">
                          <div>
                              <p class="text-xs text-[#0077FF] font-semibold uppercase tracking-wider">Paket Pilihan</p>
                              <h4 class="text-lg font-bold text-gray-900" x-text="'Vern ' + packageName"></h4>
                          </div>
                          <div class="text-right">
                              <p class="text-lg font-bold text-[#0077FF]" x-text="priceText + ' / Bulan'"></p>
                          </div>
                      </div>

                      <!-- Error Alert -->
                      <div x-show="errorMessage" x-text="errorMessage" class="bg-red-50 border border-red-200 text-red-600 rounded-xl p-3 text-sm" style="display: none;"></div>

                      <!-- Name Input -->
                      <div class="flex flex-col gap-1.5">
                          <label class="text-sm font-semibold text-gray-700">Nama Lengkap*</label>
                          <input x-model="form.customer_name" type="text" required placeholder="Masukkan nama lengkap Anda" class="w-full h-11 px-4 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-[#0077FF] outline-none text-sm transition-all" :disabled="loading" />
                      </div>

                      <!-- Email Input -->
                      <div class="flex flex-col gap-1.5">
                          <label class="text-sm font-semibold text-gray-700">Alamat Email*</label>
                          <input x-model="form.email" type="email" required placeholder="name@company.com" class="w-full h-11 px-4 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-[#0077FF] outline-none text-sm transition-all" :disabled="loading" />
                      </div>

                      <!-- Whatsapp Input -->
                      <div class="flex flex-col gap-1.5">
                          <label class="text-sm font-semibold text-gray-700">Nomor WhatsApp*</label>
                          <input x-model="form.whatsapp" @input="form.whatsapp = form.whatsapp.replace(/[^0-9+]/g, '')" type="text" required placeholder="Contoh: 08123456789" class="w-full h-11 px-4 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-[#0077FF] outline-none text-sm transition-all" :disabled="loading" />
                      </div>

                      <!-- Submit Button -->
                      <button type="submit" :disabled="loading" class="w-full h-12 bg-black text-white font-bold rounded-xl flex items-center justify-center gap-2 hover:bg-gray-900 transition-all shadow-lg mt-2">
                          <div x-show="loading" class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                          <span x-text="loading ? 'Memproses...' : 'Lanjutkan ke Pembayaran'"></span>
                      </button>
                  </form>
             </div>
        </div>

        @livewireScripts
    </body>
</html>
