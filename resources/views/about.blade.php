<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tentang Kami - Vern Warehouse</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Lexend+Deca:wght@300;400;500;600;700;800&family=Caveat:wght@400;700&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <!-- Alpine.js CDN (Di-disable karena conflict dengan Livewire v3/v4 yang meng-include Alpine secara otomatis, tetapi karena halaman ini tidak memiliki komponen Livewire, kita perlu menyertakannya agar interaksi Alpine berfungsi) -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

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
                        <a href="{{ route('home') }}" wire:navigate class="text-sm transition-colors duration-300 text-[#B3B3B3] font-medium hover:text-white">
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" wire:navigate class="text-sm transition-colors duration-300 text-[#0077FF] font-semibold">
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
            <section class="relative bg-[#0077FF] overflow-hidden pt-[206px] pb-[206px] flex flex-col items-center text-center px-6">
                <!-- Checkerboard Decorations -->
                <div class="absolute inset-0 pointer-events-none z-0">
                    <img src="{{ asset('assets/images/backgrounds/about/hero/about-hero-pixel.svg') }}" alt="Decoration" class="w-full h-full object-cover" />
                </div>

                <!-- Content -->
                <div class="relative z-10 max-w-[1066px] flex flex-col items-center">
                    <h1 class="text-[48px] font-bold text-white tracking-[-3%] font-['Plus_Jakarta_Sans'] leading-tight">
                        Solusi Cerdas untuk Manajemen Stok Bisnis Anda
                    </h1>

                    <p class="text-[16px] font-normal text-white tracking-[-3%] font-['Plus_Jakarta_Sans'] max-w-[600px] mt-[21px] leading-relaxed">
                        VERN adalah platform inventory intelligence yang membantu bisnis dalam mengelola stok dan mengambil keputusan yang lebih tepat.
                    </p>

                    <button class="bg-white text-[#0077FF] h-[45px] px-8 rounded-full font-semibold text-[14px] tracking-[-3%] font-['Plus_Jakarta_Sans'] hover:bg-white/90 transition-all mt-[21px]">
                        Coba Vern Gratis
                    </button>
                </div>
            </section>

            <!-- Misi & Roadmap Section -->
            <section class="py-32 bg-white flex flex-col items-center">
                <div class="max-w-[1158px] w-full px-6 flex flex-col items-center">
                    <!-- Mission Text -->
                    <h2 class="reveal-type text-[32px] font-semibold tracking-[-3%] font-['Plus_Jakarta_Sans'] text-center leading-snug max-w-[1000px]" data-bg-color="#8B8E97" data-fg-color="#000000">
                        Misi kami adalah menghadirkan VERN sebagai platform inventory intelligence berbasis cloud yang membantu bisnis mengambil keputusan lebih cepat, tepat, dan berbasis data.
                    </h2>

                    <!-- Roadmap Title with Gradient -->
                    <div class="mt-[60px] mb-[27px]">
                        <h3 class="text-[16px] font-medium tracking-[-3%] font-['Plus_Jakarta_Sans'] text-transparent bg-clip-text bg-gradient-to-r from-[#0077FF] to-[#FBA518]">
                            Roadmap dan Target Kami
                        </h3>
                    </div>

                    <!-- Timeline Container -->
                    <div class="relative w-[1158px] mt-48 mb-48">
                        <!-- Timeline Bar -->
                        <div class="flex w-full h-[50px] relative z-20">
                            <div class="w-[193px] h-full bg-[#EBF5FF]"></div>
                            <div class="w-[193px] h-full bg-[#0077FF]/[0.24]"></div>
                            <div class="w-[193px] h-full bg-[#A3CFFF]"></div>
                            <div class="w-[193px] h-full bg-[#91C5FF]"></div>
                            <div class="w-[193px] h-full bg-[#6FB3FF]"></div>
                            <div class="w-[193px] h-full bg-[#0077FF]"></div>
                        </div>

                        <!-- Vertical Lines and Labels Layer -->
                        <div class="absolute top-0 left-0 w-full h-full pointer-events-none">
                            <!-- MARCH (Below - 1) -->
                            <div class="absolute left-[0px] top-[50px] h-[150px] flex flex-col items-start">
                                <div class="w-[1px] h-full bg-[#D9D9D9]"></div>
                                <div class="mt-4 flex flex-col gap-1">
                                    <span class="text-[12px] text-[#8B8E97] font-['Plus_Jakarta_Sans'] whitespace-nowrap">Maret, 2026</span>
                                    <span class="text-[16px] font-bold text-black font-['Plus_Jakarta_Sans'] whitespace-nowrap">Awal Pengembangan</span>
                                </div>
                            </div>

                            <!-- JUNE (Above - 2) -->
                            <div class="absolute left-[193px] bottom-[50px] h-[150px] flex flex-col-reverse items-start">
                                <div class="w-[1px] h-full bg-[#D9D9D9]"></div>
                                <div class="mb-4 flex flex-col gap-1">
                                    <span class="text-[12px] text-[#8B8E97] font-['Plus_Jakarta_Sans'] whitespace-nowrap">Juni, 2026</span>
                                    <span class="text-[16px] font-bold text-black font-['Plus_Jakarta_Sans'] whitespace-nowrap">Rilis Vern</span>
                                </div>
                            </div>

                            <!-- AUGUST (Below - 3) -->
                            <div class="absolute left-[386px] top-[50px] h-[150px] flex flex-col items-start">
                                <div class="w-[1px] h-full bg-[#D9D9D9]"></div>
                                <div class="mt-4 flex flex-col gap-1">
                                    <span class="text-[12px] text-[#8B8E97] font-['Plus_Jakarta_Sans'] whitespace-nowrap">Agustus, 2026</span>
                                    <span class="text-[16px] font-bold text-black font-['Plus_Jakarta_Sans'] whitespace-nowrap">Validasi Pengguna</span>
                                </div>
                            </div>

                            <!-- OCTOBER (Above - 4) -->
                            <div class="absolute left-[579px] bottom-[50px] h-[150px] flex flex-col-reverse items-start">
                                <div class="w-[1px] h-full bg-[#D9D9D9]"></div>
                                <div class="mb-4 flex flex-col gap-1">
                                    <span class="text-[12px] text-[#8B8E97] font-['Plus_Jakarta_Sans'] whitespace-nowrap">Oktober, 2026</span>
                                    <span class="text-[16px] font-bold text-black font-['Plus_Jakarta_Sans'] whitespace-nowrap">Penguatan Pasar</span>
                                </div>
                            </div>

                            <!-- NOVEMBER (Below - 5) -->
                            <div class="absolute left-[772px] top-[50px] h-[150px] flex flex-col items-start">
                                <div class="w-[1px] h-full bg-[#D9D9D9]"></div>
                                <div class="mt-4 flex flex-col gap-1">
                                    <span class="text-[12px] text-[#8B8E97] font-['Plus_Jakarta_Sans'] whitespace-nowrap">November, 2026</span>
                                    <span class="text-[16px] font-bold text-black font-['Plus_Jakarta_Sans'] whitespace-nowrap">Vern Scale Up</span>
                                </div>
                            </div>

                            <!-- JANUARY (Above - 6) -->
                            <div class="absolute left-[965px] bottom-[50px] h-[150px] flex flex-col-reverse items-start">
                                <div class="w-[1px] h-full bg-[#D9D9D9]"></div>
                                <div class="mb-4 flex flex-col gap-1">
                                    <span class="text-[12px] text-[#8B8E97] font-['Plus_Jakarta_Sans'] whitespace-nowrap">Januari, 2027</span>
                                    <span class="text-[16px] font-bold text-black font-['Plus_Jakarta_Sans'] whitespace-nowrap">Inkubasi & Funding Stage</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Stats & Visi Section -->
            <section class="bg-[#F2FAFF] pb-32">
                <div class="max-w-[1158px] mx-auto px-6 pt-[108px]">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-20">
                        <!-- Left Column: Stats -->
                        <div class="border-l border-[#D9D9D9] pl-10">
                            <div class="flex flex-col gap-6">
                                <!-- Gradient Title -->
                                <div class="text-[16px] font-semibold font-['Plus_Jakarta_Sans'] tracking-[-3%] text-transparent bg-clip-text bg-gradient-to-r from-[#0077FF] to-[#FBA518] self-start">
                                    Kemana Kita Akan Pergi
                                </div>
                                <h2 class="text-[32px] font-semibold text-black leading-tight tracking-[-3%] font-['Plus_Jakarta_Sans'] max-w-[450px]">
                                    Kami membangun platform yang membantu bisnis memahami stok dan mengambil keputusan yang lebih tepat.
                                </h2>

                                <div class="mt-12 grid grid-cols-2 gap-8">
                                    <!-- Stat 1 -->
                                    <div class="flex flex-col gap-4">
                                        <img src="{{ asset('assets/images/backgrounds/about/values/stat-100-plus.svg') }}" alt="100+" class="w-12 h-12" />
                                        <div>
                                            <div class="text-[32px] font-semibold text-black tracking-[-3%] font-['Plus_Jakarta_Sans']">
                                                100+
                                            </div>
                                            <p class="text-[14px] text-black font-medium leading-relaxed font-['Plus_Jakarta_Sans'] mt-2">
                                                Produk berhasil dikelola dalam tahap awal penggunaan
                                            </p>
                                        </div>
                                    </div>
                                    <!-- Stat 2 -->
                                    <div class="flex flex-col gap-4">
                                        <img src="{{ asset('assets/images/backgrounds/about/values/stat-80-percent.svg') }}" alt="80%" class="w-12 h-12" />
                                        <div>
                                            <div class="text-[32px] font-semibold text-black tracking-[-3%] font-['Plus_Jakarta_Sans']">
                                                80%
                                            </div>
                                            <p class="text-[14px] text-black font-medium leading-relaxed font-['Plus_Jakarta_Sans'] mt-2">
                                                Potensi pengurangan risiko kehabisan stok melalui monitoring berbasis data
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Visi -->
                        <div class="border-l border-[#D9D9D9] pl-10 flex flex-col">
                            <div class="flex flex-col gap-6 h-full">
                                <!-- Gradient Title -->
                                <div class="text-[16px] font-semibold font-['Plus_Jakarta_Sans'] tracking-[-3%] text-transparent bg-clip-text bg-gradient-to-r from-[#0077FF] to-[#FBA518] self-start">
                                    Visi Kami
                                </div>

                                <div class="flex flex-col gap-10 mt-auto pb-4">
                                    <p class="text-[18px] font-medium text-black leading-relaxed font-['Plus_Jakarta_Sans'] tracking-[-3%]">
                                        Visi kami tetap sama:
                                        <span class="bg-[#9CC4F2] px-2 py-0.5 rounded-[8px]">Vern menghadirkan</span>
                                        platform inventory intelligence yang membantu bisnis mengambil keputusan berbasis data secara lebih cepat dan akurat.
                                    </p>

                                    <p class="text-[18px] font-medium text-black leading-relaxed font-['Plus_Jakarta_Sans'] tracking-[-3%]">
                                        Teknologi VERN dirancang
                                        <span class="bg-[#9CC4F2] px-2 py-0.5 rounded-[8px]">untuk mendukung pertumbuhan bisnis</span>
                                        dengan sistem yang adaptif, terukur, dan siap berkembang.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Team Section -->
            <section class="bg-white pb-32">
                <div class="max-w-[1158px] mx-auto px-6 pt-[100px]">
                    <!-- Team Header -->
                    <div class="flex flex-col md:flex-row justify-between items-start gap-10 mb-20">
                        <div class="flex flex-col gap-6 max-w-[600px]">
                            <div class="text-[16px] font-semibold font-['Plus_Jakarta_Sans'] tracking-[-3%] text-transparent bg-clip-text bg-gradient-to-r from-[#0077FF] to-[#FBA518] self-start">
                                Insan Dibalik Vern
                            </div>
                            <h2 class="text-[32px] font-semibold text-black leading-tight tracking-[-3%] font-['Plus_Jakarta_Sans']">
                                Dibangun oleh tim yang berkomitmen menghadirkan solusi terbaik untuk bisnis.
                            </h2>
                        </div>
                        <div class="max-w-[380px] mt-auto">
                            <p class="text-[16px] text-black leading-relaxed font-['Plus_Jakarta_Sans']">
                                Didukung oleh individu dengan keahlian dan pengalaman di bidang teknologi, bisnis, dan pengembangan produk.
                            </p>
                        </div>
                    </div>

                    <!-- Team Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-x-[103px] gap-y-16">
                        <!-- Ananda -->
                        <div class="flex flex-col items-center text-center gap-6">
                            <img src="{{ asset('assets/images/team/ananda.svg') }}" alt="Ananda" class="w-full h-auto" />
                            <div class="flex flex-col gap-1">
                                <span class="text-[24px] font-bold text-black tracking-[-3%] font-['Plus_Jakarta_Sans']">Ananda</span>
                                <span class="text-[24px] font-medium text-[#B3B3B3] tracking-[-3%] font-['Plus_Jakarta_Sans']">CTO</span>
                            </div>
                        </div>

                        <!-- Niko -->
                        <div class="flex flex-col items-center text-center gap-6">
                            <img src="{{ asset('assets/images/team/niko.svg') }}" alt="Niko" class="w-full h-auto" />
                            <div class="flex flex-col gap-1">
                                <span class="text-[24px] font-bold text-black tracking-[-3%] font-['Plus_Jakarta_Sans']">Niko</span>
                                <span class="text-[24px] font-medium text-[#B3B3B3] tracking-[-3%] font-['Plus_Jakarta_Sans']">COO</span>
                            </div>
                        </div>

                        <!-- Dimas -->
                        <div class="flex flex-col items-center text-center gap-6">
                            <img src="{{ asset('assets/images/team/dimas.svg') }}" alt="Dimas" class="w-full h-auto" />
                            <div class="flex flex-col gap-1">
                                <span class="text-[24px] font-bold text-black tracking-[-3%] font-['Plus_Jakarta_Sans']">Dimas</span>
                                <span class="text-[24px] font-medium text-[#B3B3B3] tracking-[-3%] font-['Plus_Jakarta_Sans']">CEO</span>
                            </div>
                        </div>

                        <!-- Ratih -->
                        <div class="flex flex-col items-center text-center gap-6">
                            <img src="{{ asset('assets/images/team/ratih.svg') }}" alt="Ratih" class="w-full h-auto" />
                            <div class="flex flex-col gap-1">
                                <span class="text-[24px] font-bold text-black tracking-[-3%] font-['Plus_Jakarta_Sans']">Ratih</span>
                                <span class="text-[24px] font-medium text-[#B3B3B3] tracking-[-3%] font-['Plus_Jakarta_Sans']">CMO</span>
                            </div>
                        </div>

                        <!-- Natasya -->
                        <div class="flex flex-col items-center text-center gap-6">
                            <img src="{{ asset('assets/images/team/natasya.svg') }}" alt="Natasya" class="w-full h-auto" />
                            <div class="flex flex-col gap-1">
                                <span class="text-[24px] font-bold text-black tracking-[-3%] font-['Plus_Jakarta_Sans']">Natasya</span>
                                <span class="text-[24px] font-medium text-[#B3B3B3] tracking-[-3%] font-['Plus_Jakarta_Sans']">CFO</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Core Values Section -->
            <section class="relative overflow-hidden flex flex-col items-center">
                <!-- Full Background SVG -->
                <div class="absolute inset-0 z-0">
                    <img src="{{ asset('assets/images/about/values/core-values-bg.svg') }}" alt="" class="w-full h-full object-cover" />
                </div>

                <div class="relative z-10 w-full max-w-[1158px] px-6 flex flex-col items-center">
                    <!-- Headline -->
                    <h2 class="text-[48px] font-bold text-white tracking-[-0.03em] font-['Plus_Jakarta_Sans'] pt-[187px] mb-[100px]">
                        Core Values Kami
                    </h2>

                    <!-- Values Grid -->
                    <div class="grid grid-cols-4 gap-x-8 w-full pb-[235px]">
                        <!-- Value 1: People First -->
                        <div class="flex flex-col border-r border-[#D9D9D9] pr-8">
                            <img src="{{ asset('assets/images/about/values/people first.svg') }}" alt="People First" class="w-12 h-12 self-start" />
                            <h3 class="text-[28px] font-semibold text-white tracking-[-0.03em] font-['Plus_Jakarta_Sans'] mt-[40px] mb-[33px]">
                                People First
                            </h3>
                            <p class="text-[16px] font-medium text-white tracking-[-0.03em] font-['Plus_Jakarta_Sans'] leading-relaxed">
                                Kami membangun untuk manusia, bukan sekadar sistem.
                            </p>
                        </div>

                        <!-- Value 2: Sustainable Work -->
                        <div class="flex flex-col border-r border-[#D9D9D9] pr-8">
                            <img src="{{ asset('assets/images/about/values/Sustainable Work.svg') }}" alt="Sustainable Work" class="w-12 h-12 self-start" />
                            <h3 class="text-[28px] font-semibold text-white tracking-[-0.03em] font-['Plus_Jakarta_Sans'] mt-[40px] mb-[33px]">
                                Sustainable Work
                            </h3>
                            <p class="text-[16px] font-medium text-white tracking-[-0.03em] font-['Plus_Jakarta_Sans'] leading-relaxed">
                                Kami menghargai keseimbangan antara kerja dan kehidupan.
                            </p>
                        </div>

                        <!-- Value 3: Take Ownership -->
                        <div class="flex flex-col border-r border-[#D9D9D9] pr-8">
                            <img src="{{ asset('assets/images/about/values/Take Ownership.svg') }}" alt="Take Ownership" class="w-12 h-12 self-start" />
                            <h3 class="text-[28px] font-semibold text-white tracking-[-0.03em] font-['Plus_Jakarta_Sans'] mt-[40px] mb-[33px]">
                                Take Ownership
                            </h3>
                            <p class="text-[16px] font-medium text-white tracking-[-0.03em] font-['Plus_Jakarta_Sans'] leading-relaxed">
                                Kami bergerak cepat dan bertanggung jawab penuh.
                            </p>
                        </div>

                        <!-- Value 4: Keep Growing -->
                        <div class="flex flex-col">
                            <img src="{{ asset('assets/images/about/values/Keep Growing.svg') }}" alt="Keep Growing" class="w-12 h-12 self-start" />
                            <h3 class="text-[28px] font-semibold text-white tracking-[-0.03em] font-['Plus_Jakarta_Sans'] mt-[40px] mb-[33px]">
                                Keep Growing
                            </h3>
                            <p class="text-[16px] font-medium text-white tracking-[-0.03em] font-['Plus_Jakarta_Sans'] leading-relaxed">
                                Kami terus belajar dan berkembang bersama.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Gallery Section -->
            <section class="bg-[#F2FAFF] py-32 overflow-hidden">
                <div class="max-w-[1158px] mx-auto px-6">
                    <!-- Gallery Header -->
                    <div class="mb-20">
                        <div class="text-[16px] font-medium font-['Plus_Jakarta_Sans'] tracking-[-3%] text-transparent bg-clip-text bg-gradient-to-r from-[#0077FF] from-[37%] to-[#FBA518] self-start mb-4">
                            Galeri
                        </div>
                        <h2 class="text-[32px] font-semibold text-black leading-tight tracking-[-3%] font-['Plus_Jakarta_Sans'] max-w-[588px]">
                            Kenangan dibalik hiruk pikuk setiap proses demi terbentuknya Vern
                        </h2>
                    </div>

                    <!-- Gallery Items -->
                    <div class="flex flex-col gap-32">
                        <!-- Item 1: Brainstorming -->
                        <div class="flex flex-col md:flex-row items-center gap-16">
                            <!-- Photo Card -->
                            <div class="relative group">
                                <div class="bg-white p-4 shadow-[0_20px_50px_rgba(0,0,0,0.05)] relative z-10">
                                    <img src="{{ asset('assets/images/about/gallery/brainstorming-photo.svg') }}" alt="Brainstorming" class="w-[500px] h-auto object-cover" />
                                </div>
                                <!-- Brainstorm Sticker -->
                                <div class="absolute -top-16 -right-16 z-20 w-[180px] h-[180px]">
                                    <img src="{{ asset('assets/images/about/gallery/brainstorm-sticker.svg') }}" alt="Brainstorm Sticker" class="w-full h-full" />
                                </div>
                            </div>
                            <!-- Text -->
                            <div class="flex flex-col max-w-[460px]">
                                <h3 class="text-[54px] font-bold text-black tracking-[-3%] font-['Caveat'] leading-none mb-6">
                                    Brainstorming
                                </h3>
                                <p class="text-[16px] font-medium text-black tracking-[-3%] font-['Plus_Jakarta_Sans'] leading-relaxed">
                                    Keseruan saat melakukan sprint untuk membangun vern dengan nilai nilai utama yang di prioritaskan
                                </p>
                            </div>
                        </div>

                        <!-- Item 2: Improvement -->
                        <div class="flex flex-col md:flex-row items-center gap-16">
                            <!-- Photo Card -->
                            <div class="relative group">
                                <!-- Laugh Emoji Sticker -->
                                <div class="absolute -top-16 -left-12 z-20 w-[160px] h-[160px]">
                                    <img src="{{ asset('assets/images/about/gallery/laugh-emoji.svg') }}" alt="Laugh Emoji" class="w-full h-full" />
                                </div>
                                <div class="bg-white p-4 shadow-[0_20px_50px_rgba(0,0,0,0.05)] relative z-10">
                                    <img src="{{ asset('assets/images/about/gallery/improvement-photo.svg') }}" alt="Improvement" class="w-[500px] h-auto object-cover" />
                                </div>
                            </div>
                            <!-- Text -->
                            <div class="flex flex-col max-w-[460px]">
                                <h3 class="text-[54px] font-bold text-black tracking-[-3%] font-['Caveat'] leading-none mb-6">
                                    Improvement
                                </h3>
                                <p class="text-[16px] font-medium text-black tracking-[-3%] font-['Plus_Jakarta_Sans'] leading-relaxed">
                                    Improvisasi kebutuhan terkait bisnis vern dan validasi ide bersama sama
                                </p>
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
        @livewireScripts
    </body>
</html>
