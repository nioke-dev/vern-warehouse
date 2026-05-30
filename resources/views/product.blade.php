<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Produk Kami - Vern Warehouse</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Lexend+Deca:wght@300;400;500;600;700;800&family=Caveat:wght@400;700&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <!-- Alpine.js CDN -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- Midtrans Snap JS -->
        <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

        <!-- GSAP & ScrollTrigger & SplitType CDNs for Vision Text Reveal Animation -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
        <script src="https://unpkg.com/split-type"></script>

        <style>
            /* Fade Transition for Interactive tabs */
            .fade-enter {
                opacity: 0;
                transform: translateY(10px);
            }
            .fade-enter-active {
                transition: opacity 0.4s ease, transform 0.4s ease;
            }
            .fade-leave-active {
                transition: opacity 0.4s ease, transform 0.4s ease;
                opacity: 0;
                transform: translateY(-10px);
            }
            
            /* Highlight Animation */
            @keyframes highlight-product {
                0% { width: 0; }
                100% { width: 100%; }
            }
            @keyframes highlight-line-product {
                0% { width: 0; opacity: 0; }
                30% { width: 0; opacity: 1; }
                100% { width: 100%; opacity: 1; }
            }
            .animate-highlight-product {
                animation: highlight-product 1.2s cubic-bezier(0.65, 0, 0.35, 1) forwards;
            }
            .animate-highlight-line-product {
                animation: highlight-line-product 1.2s cubic-bezier(0.65, 0, 0.35, 1) forwards;
            }

            .shadow-pricing {
                box-shadow: 0px 2px 4px 3px rgba(0, 0, 0, 0.05);
            }
        </style>
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
                        <a href="{{ route('home') }}" wire:navigate class="text-sm transition-colors duration-300 text-[#B3B3B3] font-medium hover:text-white">
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" wire:navigate class="text-sm transition-colors duration-300 text-[#B3B3B3] font-medium hover:text-white">
                            Tentang Kami
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('product') }}" wire:navigate class="text-sm transition-colors duration-300 text-[#0077FF] font-semibold">
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
            <section class="relative w-full overflow-hidden flex flex-col items-center">
                <!-- Full Background BG Image (Full Width with Gradient Fade Out at the bottom) -->
                <div class="absolute left-0 right-0 z-0 pointer-events-none overflow-hidden" style="top: 0; height: 950px;">
                    <img src="{{ asset('assets/images/backgrounds/product/hero/product-hero-bg.svg') }}" alt="Hero Background" class="w-full h-full object-cover object-top opacity-90" />
                    <!-- Fading overlay to blend smoothly into the white page background -->
                    <div class="absolute bottom-0 left-0 right-0 h-[200px]" style="background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 1) 100%);"></div>
                </div>

                <div class="relative z-10 w-full max-w-[1158px] px-6 pt-[200px] pb-[100px] flex flex-col items-start">
                    <!-- Headline -->
                    <h1 class="text-[48px] font-bold text-black tracking-[-0.03em] font-['Plus_Jakarta_Sans'] max-w-[920px] leading-tight mb-4">
                        Kelola Inventory dengan Insight yang
                        <span class="relative inline-block">
                            <span class="relative z-10 text-black">Lebih Cerdas</span>
                            <!-- Blue highlight fill -->
                            <div class="absolute bottom-0 left-0 h-[100%] bg-[#0077FF]/[0.24] -z-[1] origin-left animate-highlight-product"></div>
                            <!-- Blue underline -->
                            <div class="absolute bottom-0 left-0 h-[3px] bg-[#0077FF] origin-left animate-highlight-line-product"></div>
                        </span>
                    </h1>
                    
                    <!-- Description -->
                    <p class="text-[16px] font-normal text-black tracking-[-0.03em] font-['Plus_Jakarta_Sans'] max-w-[561px] leading-relaxed mb-8">
                        VERN membantu bisnis memantau stok, menganalisis pergerakan inventory, dan mengambil keputusan yang lebih tepat melalui data dan automation.
                    </p>

                    <!-- Buttons -->
                    <div class="flex items-center gap-6 mb-16 relative z-10">
                        <button class="bg-black text-white px-[15px] h-[40px] rounded-[10px] text-[16px] font-semibold tracking-[-0.03em] font-['Plus_Jakarta_Sans'] hover:bg-gray-800 transition-colors flex items-center justify-center cursor-pointer">
                            Jadwalkan Demo
                        </button>
                        <button class="text-black text-[16px] font-medium tracking-[-0.03em] font-['Plus_Jakarta_Sans'] hover:text-gray-600 transition-colors cursor-pointer">
                            Kontak Sales Vern
                        </button>
                    </div>

                    <!-- Video Placeholder (Figma Playful GIF) -->
                    <div class="relative w-full mx-auto aspect-video bg-[#F8F9FA] rounded-[20px] shadow-[0_20px_60px_rgba(0,119,255,0.15)] overflow-hidden z-10 border border-white/50">
                        <img src="{{ asset('assets/images/product/gif/Dashboad-Playful.gif') }}" alt="Dashboard Playful Preview" style="width: 100%; height: 100%; object-fit: contain;" />
                    </div>
                </div>
            </section>

            <!-- Interactive Features Section (Alpine.js) -->
            <section class="w-full bg-white py-24 px-6 flex justify-center" x-data="{ 
                activeFeature: 0,
                features: [
                    {
                        title: 'Isi Deskripsi Produk',
                        description: 'Lengkapi informasi produk untuk membantu sistem mengenali pola stok dan pergerakan inventory.',
                        image: '{{ asset('assets/images/product/features/isi deskripsi produk.svg') }}'
                    },
                    {
                        title: 'Setting Trigger',
                        description: 'Atur batas minimum stok agar VERN dapat mendeteksi potensi kehabisan produk lebih awal.',
                        image: '{{ asset('assets/images/product/features/setting trigger.svg') }}'
                    },
                    {
                        title: 'Dapatkan Notifikasi',
                        description: 'Terima notifikasi otomatis saat stok mulai menipis atau membutuhkan restock segera.',
                        image: '{{ asset('assets/images/product/features/dapatkan notifikasi.svg') }}'
                    }
                ]
            }">
                <div class="w-full max-w-[1158px] flex flex-col lg:flex-row items-start justify-between gap-16 lg:gap-24">
                    
                    <!-- Left Side: Content & Tabs -->
                    <div class="w-full lg:w-[45%] flex flex-col">
                        <!-- Small Label -->
                        <div class="text-[16px] font-medium font-['Plus_Jakarta_Sans'] tracking-[-0.03em] mb-4">
                            <span class="text-[#0077FF]">Notifikasi</span> <span class="text-[#FFA500]">Stok</span>
                        </div>
                        
                        <!-- Main Headline -->
                        <h2 class="text-[48px] font-bold text-black leading-tight tracking-[-0.03em] font-['Plus_Jakarta_Sans'] mb-6">
                            Ambil Tindakan Lebih Cepat Sebelum Stok Menipis
                        </h2>

                        <!-- Indicators -->
                        <div class="flex items-center gap-3 mb-8">
                            <template x-for="(feature, index) in features" :key="index">
                                <div class="h-2 rounded-full transition-all duration-300 cursor-pointer"
                                     :class="activeFeature === index ? 'w-10 bg-[#0077FF]' : 'w-10 bg-[#E5E7EB]'"
                                     @click="activeFeature = index">
                                </div>
                            </template>
                        </div>

                        <!-- CTA Button -->
                        <button class="flex items-center gap-2 border border-gray-200 rounded-[8px] px-5 py-2 mb-12 hover:bg-gray-50 transition-colors w-max cursor-pointer">
                            <span class="text-[16px] font-medium font-['Plus_Jakarta_Sans'] tracking-[-0.03em] text-black">Mulai Sekarang</span>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.33331 8H12.6666" stroke="#B3B3B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M8 3.33331L12.6667 7.99998L8 12.6666" stroke="#B3B3B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>

                        <!-- Tabs -->
                        <div class="flex flex-col gap-8">
                            <template x-for="(feature, index) in features" :key="index">
                                <div class="flex flex-col cursor-pointer group" @click="activeFeature = index">
                                    <h3 class="text-[24px] font-semibold tracking-[-0.03em] font-['Plus_Jakarta_Sans'] transition-colors"
                                        :class="activeFeature === index ? 'text-black mb-2' : 'text-black/60 group-hover:text-black/80'">
                                        <span x-text="feature.title"></span>
                                    </h3>
                                    
                                    <!-- Smooth Accordion Expansion for Description -->
                                    <div class="overflow-hidden transition-all duration-300 ease-in-out"
                                         :style="activeFeature === index ? 'max-height: 150px; opacity: 1;' : 'max-height: 0px; opacity: 0;'">
                                        <p class="text-[16px] font-medium text-[#B3B3B3] tracking-[-0.03em] font-['Plus_Jakarta_Sans'] leading-relaxed pt-1" x-text="feature.description">
                                        </p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Right Side: Interactive Image -->
                    <div class="w-full lg:w-[55%] flex items-center justify-center relative min-h-[500px]">
                        <div class="w-full relative rounded-[30px] overflow-hidden">
                            <template x-for="(feature, index) in features" :key="index">
                                <div x-show="activeFeature === index" 
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-200"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     class="w-full h-auto">
                                    <img :src="feature.image" :alt="feature.title" class="w-full h-auto object-contain" />
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Interactive Monitoring Section (Flipped Layout - Alpine.js) -->
            <section class="w-full bg-[#FAFAFA] py-24 px-6 flex justify-center" x-data="{
                activeMonitoring: 0,
                monitorings: [
                    {
                        title: 'Masuk ke Vern',
                        description: 'Masuk ke akun anda untuk melihat keseluruhan tabel produk dan seluruh analisisnya',
                        image: '{{ asset('assets/images/product/monitoring/masuk ke vern.svg') }}'
                    },
                    {
                        title: 'Klik Tabel Produk',
                        description: 'Klik setiap tabel produk yang ingin anda lihat kondisi kesehatan stoknya untuk mendapat tindakan lanjutan',
                        image: '{{ asset('assets/images/product/monitoring/klik tabel produk.svg') }}'
                    },
                    {
                        title: 'Cek Kesehatan Produk',
                        description: 'Ketika status produk sudah muncul, anda bisa menentukan strategi mitigasi untuk mengupgrade status produk',
                        image: '{{ asset('assets/images/product/monitoring/cek kesehatan produk.svg') }}'
                    }
                ]
            }">
                <div class="w-full max-w-[1158px] flex flex-col lg:flex-row-reverse items-start justify-between gap-16 lg:gap-24">
                    
                    <!-- Right Side (Now on the Right visually due to reverse): Content & Tabs -->
                    <div class="w-full lg:w-[45%] flex flex-col">
                        <!-- Small Label -->
                        <div class="text-[16px] font-medium font-['Plus_Jakarta_Sans'] tracking-[-0.03em] mb-4">
                            <span class="text-[#0077FF]">Status Kesehatan</span> <span class="text-[#FFA500]">Stok</span>
                        </div>
                        
                        <!-- Main Headline -->
                        <h2 class="text-[48px] font-bold text-black leading-tight tracking-[-0.03em] font-['Plus_Jakarta_Sans'] mb-6">
                            Lihat dan Pantau selalu kondisi Inventory anda Real time
                        </h2>

                        <!-- Indicators (Orange Theme) -->
                        <div class="flex items-center gap-3 mb-8">
                            <template x-for="(item, index) in monitorings" :key="index">
                                <div class="h-2 rounded-full transition-all duration-300 cursor-pointer"
                                     :class="activeMonitoring === index ? 'w-10 bg-[#FBA518]' : 'w-10 bg-[#E5E7EB]'"
                                     @click="activeMonitoring = index">
                                </div>
                            </template>
                        </div>

                        <!-- CTA Button -->
                        <button class="flex items-center gap-2 border border-gray-200 bg-white rounded-[8px] px-5 py-2 mb-12 hover:bg-gray-50 transition-colors w-max shadow-sm cursor-pointer">
                            <span class="text-[16px] font-medium font-['Plus_Jakarta_Sans'] tracking-[-0.03em] text-black">Mulai Sekarang</span>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.33331 8H12.6666" stroke="#B3B3B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M8 3.33331L12.6667 7.99998L8 12.6666" stroke="#B3B3B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>

                        <!-- Tabs -->
                        <div class="flex flex-col gap-8">
                            <template x-for="(item, index) in monitorings" :key="index">
                                <div class="flex flex-col cursor-pointer group" @click="activeMonitoring = index">
                                    <h3 class="text-[24px] font-semibold tracking-[-0.03em] font-['Plus_Jakarta_Sans'] transition-colors"
                                        :class="activeMonitoring === index ? 'text-black mb-2' : 'text-black/60 group-hover:text-black/80'">
                                        <span x-text="item.title"></span>
                                    </h3>
                                    
                                    <!-- Smooth Accordion Expansion for Description -->
                                    <div class="overflow-hidden transition-all duration-300 ease-in-out"
                                         :style="activeMonitoring === index ? 'max-height: 150px; opacity: 1;' : 'max-height: 0px; opacity: 0;'">
                                        <p class="text-[16px] font-medium text-[#B3B3B3] tracking-[-0.03em] font-['Plus_Jakarta_Sans'] leading-relaxed pt-1" x-text="item.description">
                                        </p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Left Side (Now on the Left visually): Interactive Image -->
                    <div class="w-full lg:w-[55%] flex items-center justify-center relative min-h-[500px]">
                        <div class="w-full relative rounded-[30px] overflow-hidden">
                            <template x-for="(item, index) in monitorings" :key="index">
                                <div x-show="activeMonitoring === index" 
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-200"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     class="w-full h-auto">
                                    <img :src="item.image" :alt="item.title" class="w-full h-auto object-contain" />
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Other Features Section -->
            <section class="w-full bg-white py-24 px-6 flex flex-col items-center">
                <div class="w-full max-w-[1158px] flex flex-col">
                    
                    <!-- Header Area -->
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-8 mb-16">
                        <!-- Left: Title & Button -->
                        <div class="flex flex-col max-w-[600px]">
                            <div class="text-[16px] font-semibold font-['Plus_Jakarta_Sans'] tracking-[-0.03em] mb-3">
                                <span class="text-[#0077FF]">Fit</span><span class="text-[#FFA500]">ur</span>
                            </div>
                            <h2 class="text-[32px] font-semibold text-black leading-tight tracking-[-0.03em] font-['Plus_Jakarta_Sans'] mb-8">
                                Fitur lain yang tidak kalah pentingnya
                            </h2>
                            <button class="bg-[#0077FF] hover:bg-blue-600 text-white flex items-center gap-2 rounded-[30px] px-6 py-3 w-max transition-colors cursor-pointer">
                                <span class="text-[14px] font-semibold font-['Plus_Jakarta_Sans'] tracking-[-0.03em]">Coba Vern</span>
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3.33331 8H12.6666" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M8 3.33331L12.6667 7.99998L8 12.6666" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Right: Description -->
                        <div class="max-w-[460px] mb-[10px]">
                            <p class="text-[16px] font-medium text-black leading-relaxed tracking-[-0.03em] font-['Plus_Jakarta_Sans']">
                                Fitur ini bisa anda dapatkan dengan berlangganan vern dan dengan semua fitur powerfull yang ada
                            </p>
                        </div>
                    </div>

                    <!-- 3 Cards Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                        <!-- Card 1 -->
                        <div class="w-full">
                            <img src="{{ asset('assets/images/product/other-features/supply chain analysis.svg') }}" alt="Supply Chain" class="w-full h-auto" />
                        </div>
                        <!-- Card 2 -->
                        <div class="w-full">
                            <img src="{{ asset('assets/images/product/other-features/invoice generator.svg') }}" alt="Invoice Generator" class="w-full h-auto" />
                        </div>
                        <!-- Card 3 -->
                        <div class="w-full">
                            <img src="{{ asset('assets/images/product/other-features/vern recommendation.svg') }}" alt="Vern Recommendation" class="w-full h-auto" />
                        </div>
                    </div>

                    <!-- Integration Banner -->
                    <div class="w-full flex justify-center">
                        <img src="{{ asset('assets/images/product/other-features/integrasi platform.svg') }}" alt="Integrations" class="w-full h-auto" />
                    </div>

                </div>
            </section>

            <!-- Product Pricing Section -->
            <section id="pricing" class="py-24 bg-[#F2FAFF] font-['Plus_Jakarta_Sans']" x-data="{
                proFeatures: [
                    { name: 'Stock Gap Analysis', icon: '{{ asset('assets/images/icons/pricing/Stock Gap Analysis.svg') }}' },
                    { name: 'Inventory Monitoring', icon: '{{ asset('assets/images/icons/pricing/Inventory Monitoring.svg') }}' },
                    { name: 'Dashboard Sederhana', icon: '{{ asset('assets/images/icons/pricing/Dashboard Sederhana.svg') }}' },
                    { name: 'Laporan Inventory Otomatis', icon: '{{ asset('assets/images/icons/pricing/Laporan Inventory Otomatis.svg') }}' },
                    { name: 'Moving Detection', icon: '{{ asset('assets/images/icons/pricing/Moving Detection.svg') }}' },
                    { name: '3 Role Maksimal', icon: '{{ asset('assets/images/icons/pricing/3 Role Maksimal.svg') }}' }
                ],
                enterpriseFeatures: [
                    { name: 'AI Feature untuk prediksi & insight', icon: '{{ asset('assets/images/icons/pricing/AI Feature untuk prediksi & insight.svg') }}' },
                    { name: 'Branch warehouse controlling', icon: '{{ asset('assets/images/icons/pricing/Branch warehouse controlling.svg') }}' },
                    { name: 'Shrinkage monitoring', icon: '{{ asset('assets/images/icons/pricing/Shrinkage monitoring.svg') }}' },
                    { name: 'Supplier analysis', icon: '{{ asset('assets/images/icons/pricing/Supplier analysis.svg') }}' },
                    { name: 'Dashboard analitik lengkap', icon: '{{ asset('assets/images/icons/pricing/Dashboard analitik lengkap.svg') }}' },
                    { name: 'Advanced reporting & decision support', icon: '{{ asset('assets/images/icons/pricing/Advanced reporting & decision support.svg') }}' }
                ]
            }">
                <div class="max-w-[1280px] mx-auto px-6">
                    <div class="flex flex-col lg:flex-row justify-between items-start gap-20">
                        
                        <!-- Left Side: Content & Testimonial -->
                        <div class="flex flex-col gap-10 w-full lg:max-w-[420px] flex-shrink-0 pt-4">
                            <div class="flex flex-col gap-6">
                                <h4 class="text-[16px] font-medium tracking-[-3%]">
                                    <span class="text-[#0077FF]">Paket</span> 
                                    <span class="text-[#737373]"> dan </span>
                                    <span class="text-[#FBA518]">Harga</span>
                                </h4>
                                
                                <h2 class="text-[40px] font-bold leading-tight tracking-[-3%] text-black/90">
                                    Dimulai dari yang <br /> Kecil, cocok untuk <br /> kantong anda!
                                </h2>
                            </div>

                            <!-- Industry Section -->
                            <div class="flex flex-col gap-4">
                                <p class="text-[16px] font-medium text-[#737373] tracking-[-3%]">
                                    Cocok untuk bisnis di Area
                                </p>
                                <div class="flex items-center gap-6">
                                    <img src="{{ asset('assets/images/logos/industries/RETAIL.svg') }}" alt="Retail" class="h-[18px] w-auto grayscale-0 object-contain" />
                                    <img src="{{ asset('assets/images/logos/industries/F&B.svg') }}" alt="F&B" class="h-[18px] w-auto grayscale-0 object-contain" />
                                    <img src="{{ asset('assets/images/logos/industries/GARMEN.svg') }}" alt="Garmen" class="h-[18px] w-auto grayscale-0 object-contain" />
                                </div>
                            </div>

                            <!-- Akses Fitur Awal Vern -->
                            <div class="flex flex-col gap-2 mt-2">
                                <h3 class="text-[22px] font-bold text-black tracking-[-3%]">Akses Fitur awal Vern</h3>
                                <p class="text-[16px] text-[#737373] leading-relaxed max-w-[340px] font-medium">
                                    Anda bisa mencoba vern dengan gratis selama 30 hari dan rasakan manfaatnya
                                </p>
                                <button class="bg-black text-white px-8 py-3 rounded-full font-semibold w-max mt-4 hover:opacity-90 transition-opacity cursor-pointer">
                                    Mulai Gratis Vern
                                </button>
                            </div>

                            <!-- Testimonial -->
                            <div class="mt-4 flex flex-col gap-6">
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
                                                <span class="text-[32px] font-bold tracking-[-3%]"><span class="text-[#0077FF]">IDR </span><span class="text-[#FBA518]">99.000</span></span>
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
                                            <template x-for="feature in proFeatures" :key="feature.name">
                                                <li class="flex items-center gap-3 border-b border-black/5 pb-4">
                                                    <img :src="feature.icon" :alt="feature.name" class="w-5 h-5 flex-shrink-0" />
                                                    <span class="text-[14px] font-medium tracking-[-3%] text-black" x-text="feature.name"></span>
                                                </li>
                                            </template>
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
                                                <span class="text-[32px] font-bold tracking-[-3%]"><span class="text-[#0077FF]">IDR </span><span class="text-[#FBA518]">199.000</span></span>
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
                                            <template x-for="feature in enterpriseFeatures" :key="feature.name">
                                                <li class="flex items-center gap-3 border-b border-black/5 pb-4">
                                                    <img :src="feature.icon" :alt="feature.name" class="w-5 h-5 flex-shrink-0" />
                                                    <span class="text-[14px] font-medium tracking-[-3%] text-black" x-text="feature.name"></span>
                                                </li>
                                            </template>
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

            <!-- Testimonials Section -->
            <section class="w-full bg-[#F5F5F5] py-24 px-6 flex justify-center">
                <div class="w-full max-w-[1158px] flex flex-col">
                    <!-- Headline: Bold 32px -->
                    <h2 class="text-[32px] font-bold text-black leading-tight tracking-[-0.03em] font-['Plus_Jakarta_Sans'] max-w-[580px] mb-16">
                        Lihat bagaimana VERN membantu pelaku bisnis mengelola stok dengan lebih efektif.
                    </h2>

                    <!-- Testimonial Cards: Guslong ~32%, Purwanti ~68% -->
                    <div class="grid grid-cols-1 md:grid-cols-[358fr_756fr] gap-8">
                        <!-- Card 1: Guslong -->
                        <div class="bg-white rounded-[20px] p-10 flex flex-col justify-between min-h-[320px]">
                            <p class="text-[28px] font-semibold text-black leading-snug tracking-[-0.03em] font-['Plus_Jakarta_Sans'] mb-[14px]">
                                &#x201C;Dengan Vern profit bisnis saya bisa maksimal&#x201D;
                            </p>
                            <div>
                                <div class="flex items-center gap-3 mb-[26px]">
                                    <img src="{{ asset('assets/images/product/testimonials/guslong.svg') }}" alt="Guslong" class="w-14 h-14 rounded-[4px] object-cover" />
                                    <div class="flex flex-col">
                                        <p class="text-[18px] font-bold text-black tracking-[-0.03em] font-['Plus_Jakarta_Sans']">Guslong</p>
                                        <p class="text-[10px] font-semibold text-black tracking-[-0.03em] font-['Plus_Jakarta_Sans']">Owner Apotik Krisna Farma</p>
                                    </div>
                                </div>
                                <button class="bg-black text-white rounded-[100px] font-semibold text-[14px] tracking-[-0.03em] font-['Plus_Jakarta_Sans'] hover:opacity-90 transition-opacity px-[15px] py-[10px] cursor-pointer">
                                    Baca Kisah Mereka
                                </button>
                            </div>
                        </div>

                        <!-- Card 2: Purwanti -->
                        <div class="bg-white rounded-[20px] p-10 flex flex-col justify-between min-h-[320px]">
                            <p class="text-[28px] font-semibold text-black leading-snug tracking-[-0.03em] font-['Plus_Jakarta_Sans'] mb-[14px]">
                                &#x201C;VERN membantu kami memahami produk mana yang benar-benar bergerak.&#x201D;
                            </p>
                            <div>
                                <div class="flex items-center gap-3 mb-[26px]">
                                    <img src="{{ asset('assets/images/product/testimonials/purwanti.svg') }}" alt="Purwanti" class="w-14 h-14 rounded-[4px] object-cover" />
                                    <div class="flex flex-col">
                                        <p class="text-[18px] font-bold text-black tracking-[-0.03em] font-['Plus_Jakarta_Sans']">Purwanti</p>
                                        <p class="text-[10px] font-semibold text-black tracking-[-0.03em] font-['Plus_Jakarta_Sans']">Owner Supermarket Warna Warni</p>
                                    </div>
                                </div>
                                <button class="bg-black text-white rounded-[100px] font-semibold text-[14px] tracking-[-0.03em] font-['Plus_Jakarta_Sans'] hover:opacity-90 transition-opacity px-[15px] py-[10px] cursor-pointer">
                                    Baca Kisah Mereka
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Contact Section -->
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

                                    <!-- Radio Options -->
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
                                                    <div class="w-full h-full border-2 rounded-full transition-all duration-300"
                                                        :class="metodeKelola === 'Manual' ? 'border-[#0077FF]' : 'border-black/10 group-hover:border-black/20'"
                                                    ></div>
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
                                                    <div class="w-full h-full border-2 rounded-full transition-all duration-300"
                                                        :class="metodeKelola === 'Excel' ? 'border-[#0077FF]' : 'border-black/10 group-hover:border-black/20'"
                                                    ></div>
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
                                                    <div class="w-full h-full border-2 rounded-full transition-all duration-300"
                                                        :class="metodeKelola === 'Belum ada sistem' ? 'border-[#0077FF]' : 'border-black/10 group-hover:border-black/20'"
                                                    ></div>
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
                <!-- Giant Background Decoration -->
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
                            <li><a href="#" class="text-sm font-medium text-[#4A4A4A] hover:text-[#0077FF] transition-colors tracking-[-3%] font-['Plus_Jakarta_Sans']">Fitur Utama</a></li>
                            <li><a href="#" class="text-sm font-medium text-[#4A4A4A] hover:text-[#0077FF] transition-colors tracking-[-3%] font-['Plus_Jakarta_Sans']">Tim</a></li>
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
