<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Studi Kasus - Vern Warehouse</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Lexend+Deca:wght@300;400;500;600;700;800&family=Caveat:wght@400;700&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <!-- GSAP & ScrollTrigger & SplitType CDNs for Smooth Scrolling -->
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
                        <a href="{{ route('casestudy') }}" wire:navigate class="text-sm transition-colors duration-300 text-[#0077FF] font-semibold">
                            Studi Kasus
                        </a>
                    </li>
                </ul>

                <!-- Action Items -->
                <div class="flex items-center gap-4 mr-1">
                    <a href="/login" class="text-white font-medium text-sm hover:opacity-80 transition-opacity">Masuk</a>
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

        <main class="font-['Plus_Jakarta_Sans']" x-data="{ 
            activeSection: 'tentang',
            scrollToSection(id) {
                const el = document.getElementById(id);
                if (el) {
                    const offset = 140; // adjusting for the landing page sticky navbar height
                    const bodyRect = document.body.getBoundingClientRect().top;
                    const elementRect = el.getBoundingClientRect().top;
                    const elementPosition = elementRect - bodyRect;
                    const targetScrollY = elementPosition - offset;

                    const scrollObj = { y: window.scrollY };
                    
                    gsap.to(scrollObj, {
                        y: targetScrollY,
                        duration: 1.0,
                        ease: 'power2.out',
                        onUpdate: () => {
                            window.scrollTo(0, scrollObj.y);
                        }
                    });
                }
            }
        }" x-init="
            const sections = ['tentang', 'challenge', 'solution', 'result'];
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        activeSection = entry.target.id;
                    }
                });
            }, {
                rootMargin: '-20% 0px -60% 0px',
                threshold: 0.1
            });

            sections.forEach(id => {
                const el = document.getElementById(id);
                if (el) observer.observe(el);
            });
        ">

            <!-- ===== SECTION 1: Hero ===== -->
            <section class="w-full bg-[#0077FF] pt-[160px] pb-[205px] px-6 flex justify-center">
                <div class="w-full max-w-[1158px] flex flex-col gap-10">

                    <!-- Client Logo SVG -->
                    <div class="w-auto">
                        <img src="{{ asset('assets/images/case-study/warna-warni/logo.svg') }}" alt="Supermarket Warna Warni" class="h-auto w-auto" />
                    </div>

                    <!-- Title -->
                    <h1 class="text-[48px] font-medium text-white leading-tight tracking-[-0.03em] max-w-[820px]">
                        Bagaimana Vern Membantu Supermarket Warna Warni Mengurangi Shrinkage dan Menata Visibilitas Stok Secara Real-Time
                    </h1>

                    <!-- Key Metrics -->
                    <div class="flex flex-col sm:flex-row gap-10 sm:gap-20 mt-2">
                        <div class="flex flex-col gap-2">
                            <span class="text-[56px] font-medium text-white tracking-[-0.03em] leading-none">42%</span>
                            <span class="text-[18px] font-medium text-white/90 tracking-[-0.03em] max-w-[160px] leading-snug">Penurunan shrinkage dalam 3 bulan pertama implementasi</span>
                        </div>
                        <div class="flex flex-col gap-2">
                            <span class="text-[56px] font-medium text-white tracking-[-0.03em] leading-none">3X</span>
                            <span class="text-[18px] font-medium text-white/90 tracking-[-0.03em] max-w-[160px] leading-snug">Lebih cepat dalam proses pengecekan stok harian</span>
                        </div>
                        <div class="flex flex-col gap-2">
                            <span class="text-[56px] font-medium text-white tracking-[-0.03em] leading-none">98%</span>
                            <span class="text-[18px] font-medium text-white/90 tracking-[-0.03em] max-w-[160px] leading-snug">Akurasi visibilitas stok antar rak dan gudang</span>
                        </div>
                    </div>

                </div>
            </section>

            <!-- ===== SECTION 2: Testimonial Quote ===== -->
            <section class="w-full bg-white pt-[62px] pb-10 px-6 flex justify-center">
                <div class="w-full max-w-[1158px] flex flex-col md:flex-row gap-16 items-start">

                    <!-- Left: Purwanti photo + name -->
                    <div class="flex-shrink-0 flex flex-col gap-4 -mt-[162px] z-10">
                        <img src="{{ asset('assets/images/case-study/warna-warni/testimonials/purwanti.svg') }}" alt="Purwanti" class="w-[276px] h-auto" />

                        <!-- Name -->
                        <p class="text-[32px] font-semibold text-black tracking-[-0.03em] leading-tight">Purwanti</p>
                        <!-- Role -->
                        <p class="text-[24px] font-semibold text-[#707371] tracking-[-0.03em] leading-tight">CEO Supermarket Warna Warni</p>
                    </div>

                    <!-- Right: Quote -->
                    <div class="flex-1 flex items-start pt-2">
                        <p class="text-[42px] font-medium text-black leading-snug tracking-[-0.03em]">
                            &#x201C;Sebelumnya kami sering kehilangan stok tanpa tahu penyebab pastinya. Setelah menggunakan Vern, kami bisa melihat pergerakan stok secara real-time dan langsung tahu area mana yang bermasalah&#x201D;
                        </p>
                    </div>

                </div>
            </section>

            <!-- ===== SECTION 3: Main Article Content (Grid with Sticky Sidebar) ===== -->
            <section class="w-full bg-white pb-32 px-6 flex justify-center">
                <div class="w-full max-w-[1158px] grid md:grid-cols-[1fr_260px] gap-20 items-start">

                    <!-- Left Column: Article Content -->
                    <div class="flex flex-col gap-24">
                        
                        <!-- Block: Tentang Supermarket Warna Warni -->
                        <div id="tentang" class="flex flex-col gap-8 scroll-mt-28">
                            <h2 class="text-[48px] font-bold text-black tracking-[-0.03em] leading-tight">
                                Tentang Supermarket Warna Warni
                            </h2>
                            <div class="flex flex-col gap-6 text-[28px] font-medium text-black leading-relaxed tracking-[-0.03em]">
                                <p>
                                    Supermarket Warna Warni merupakan jaringan retail modern yang melayani kebutuhan harian masyarakat dengan ribuan SKU produk aktif setiap harinya.
                                </p>
                                <p>
                                    Dengan aktivitas stok yang sangat dinamis, tim operasional menghadapi tantangan besar dalam menjaga ketersediaan barang sekaligus meminimalkan shrinkage akibat human error, miss tracking, hingga ketidaksesuaian stok antara rak dan gudang.
                                </p>
                            </div>
                        </div>

                        <!-- Block: Challenge -->
                        <div id="challenge" class="flex flex-col gap-8 scroll-mt-28">
                            <h2 class="text-[48px] font-bold text-black tracking-[-0.03em] leading-none">
                                Challenge
                            </h2>
                            <h3 class="text-[42px] font-medium text-black tracking-[-0.03em] leading-tight">
                                Minimnya Visibilitas Stok Menyebabkan Shrinkage dan Operasional Tidak Efisien
                            </h3>
                            <div class="flex flex-col gap-6 text-[28px] font-medium text-black leading-relaxed tracking-[-0.03em]">
                                <p>
                                    Sebelum menggunakan Vern, Supermarket Warna Warni menghadapi tantangan besar dalam menjaga akurasi inventory di tengah tingginya aktivitas operasional harian.
                                </p>
                                <p>
                                    Perbedaan antara data stok pada sistem dengan kondisi aktual di lapangan sering terjadi, sehingga tim kesulitan mendapatkan visibilitas inventory yang benar-benar akurat. Produk fast-moving juga kerap mengalami kekosongan tanpa terdeteksi lebih awal, yang berdampak langsung pada penjualan dan pengalaman pelanggan.
                                </p>
                                <p>
                                    Akibatnya, banyak keputusan operasional dibuat berdasarkan data yang terlambat atau tidak akurat.
                                </p>
                                <!-- Quote Inside Content -->
                                <p class="italic text-black font-medium leading-relaxed mt-4">
                                    &#x201C;Kami tahu ada masalah di inventory, tapi sulit mengetahui titik masalahnya secara cepat. Semua masih bergantung pada pengecekan manual.&#x201D;
                                </p>
                            </div>
                        </div>

                        <!-- Block: Solution -->
                        <div id="solution" class="flex flex-col gap-8 scroll-mt-28">
                            <h2 class="text-[48px] font-bold text-black tracking-[-0.03em] leading-none">
                                Solution
                            </h2>
                            <h3 class="text-[42px] font-medium text-black tracking-[-0.03em] leading-tight">
                                Vern Menghadirkan Visibilitas Stok yang Terintegrasi dan Real-Time
                            </h3>
                            <div class="flex flex-col gap-6 text-[28px] font-medium text-black leading-relaxed tracking-[-0.03em]">
                                <p>
                                    Untuk membantu Supermarket Warna Warni mengatasi permasalahan inventory, Vern menghadirkan sistem monitoring stok yang terintegrasi dan mudah digunakan oleh seluruh tim operasional.
                                </p>
                                <p>
                                    Melalui dashboard Vern, setiap pergerakan stok dapat dipantau secara real-time mulai dari gudang, distribusi internal, hingga display rak toko.
                                </p>
                            </div>
                        </div>

                        <!-- Block: Result -->
                        <div id="result" class="flex flex-col gap-8 scroll-mt-28">
                            <h2 class="text-[48px] font-bold text-black tracking-[-0.03em] leading-none">
                                Result
                            </h2>
                            <h3 class="text-[42px] font-medium text-black tracking-[-0.03em] leading-tight">
                                Operasional Lebih Terkontrol dan Shrinkage Berhasil Ditekan
                            </h3>
                            <div class="flex flex-col gap-6 text-[28px] font-medium text-black leading-relaxed tracking-[-0.03em]">
                                <p>
                                    Untuk membantu Supermarket Warna Warni mengatasi permasalahan inventory, Vern menghadirkan sistem monitoring stok yang terintegrasi dan mudah digunakan oleh seluruh tim operasional.
                                </p>
                                <p>
                                    Melalui dashboard Vern, setiap pergerakan stok dapat dipantau secara real-time mulai dari gudang, distribusi internal, hingga display rak toko.
                                </p>

                                <!-- Featured Blue Left-Border Quote -->
                                <div class="border-l-[13px] border-[#0077FF] pl-8 py-2 my-6">
                                    <p class="italic text-[42px] text-black font-medium leading-snug tracking-[-0.03em]">
                                        &#x201C;Vern bukan hanya membantu kami merapikan inventory, tapi juga membuat operasional toko berjalan lebih tenang dan terukur.&#x201D;
                                    </p>
                                </div>
                            </div>

                            <!-- Subsection: Dampak yang Dirasakan -->
                            <div class="flex flex-col gap-8 mt-12 pt-12 border-t border-[#E5E7EB]">
                                <h4 class="text-[48px] font-bold text-black tracking-[-0.03em] leading-tight">
                                    Dampak yang Dirasakan Tim Supermarket Warna Warni
                                </h4>
                                <div class="flex flex-col gap-6 text-[28px] font-medium text-black leading-relaxed tracking-[-0.03em]">
                                    <p>
                                        Dengan Vern, Supermarket Warna Warni berhasil mengubah proses inventory yang sebelumnya reaktif menjadi lebih proaktif dan berbasis data.
                                    </p>
                                    <p>
                                        Implementasi Vern membantu Supermarket Warna Warni membangun fondasi operasional retail yang lebih efisien, scalable, dan siap berkembang.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Block: Baca Cerita Lain -->
                        <div class="flex flex-col gap-8 pt-16 border-t border-[#E5E7EB]">
                            <h3 class="text-[48px] font-bold text-black tracking-[-0.03em] leading-tight">
                                Baca Cerita Lain
                            </h3>
                            
                            <!-- Gray Card -->
                            <div class="w-full max-w-[931px] bg-[#F3F3F3] rounded-[20px] p-12 flex flex-col gap-8 items-start">
                                <p class="text-[48px] font-semibold text-black tracking-[-0.03em] leading-tight">
                                    &#x201C;Dengan Vern profit bisnis saya bisa maksimal&#x201D;
                                </p>
                                <div class="flex items-center gap-4">
                                    <img src="{{ asset('assets/images/product/testimonials/guslong.svg') }}" alt="Guslong" class="w-12 h-12 rounded-[4px] object-cover" />
                                    <div class="flex flex-col">
                                        <span class="text-[16px] font-bold text-black tracking-[-0.02em]">Guslong</span>
                                        <span class="text-[14px] font-medium text-[#737373] tracking-[-0.02em]">Owner Apotik Krisna Farma</span>
                                    </div>
                                </div>

                                <button class="bg-black hover:bg-black/90 text-white font-bold text-[14px] py-4 px-8 rounded-full transition-all duration-300 cursor-pointer">
                                    Baca Kisah Mereka
                                </button>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column: Sticky Sidebar Table of Contents & Metrics -->
                    <div class="sticky top-[120px] flex flex-col gap-12 hidden md:flex">
                        <!-- Table of Contents -->
                        <div class="flex flex-col gap-3">
                            <a 
                                @click.prevent="scrollToSection('tentang')"
                                class="text-[32px] font-semibold tracking-[-0.03em] leading-none transition-colors duration-300 cursor-pointer hover:text-black"
                                :class="activeSection === 'tentang' ? 'text-black' : 'text-[#BEBFBF]'"
                            >Tentang</a>
                            <a 
                                @click.prevent="scrollToSection('challenge')"
                                class="text-[32px] font-semibold tracking-[-0.03em] leading-none transition-colors duration-300 cursor-pointer hover:text-black"
                                :class="activeSection === 'challenge' ? 'text-black' : 'text-[#BEBFBF]'"
                            >Challenge</a>
                            <a 
                                @click.prevent="scrollToSection('solution')"
                                class="text-[32px] font-semibold tracking-[-0.03em] leading-none transition-colors duration-300 cursor-pointer hover:text-black"
                                :class="activeSection === 'solution' ? 'text-black' : 'text-[#BEBFBF]'"
                            >Solution</a>
                            <a 
                                @click.prevent="scrollToSection('result')"
                                class="text-[32px] font-semibold tracking-[-0.03em] leading-none transition-colors duration-300 cursor-pointer hover:text-black"
                                :class="activeSection === 'result' ? 'text-black' : 'text-[#BEBFBF]'"
                            >Result</a>
                        </div>

                        <!-- Mini Metrics -->
                        <div class="flex flex-col gap-8 pt-8 border-t border-[#E5E7EB]">
                            <div class="flex flex-col gap-1">
                                <span class="text-[56px] font-medium text-black tracking-[-0.03em] leading-none">42%</span>
                                <span class="text-[16px] font-medium text-[#BEBFBF] tracking-[-0.03em] leading-snug">Penurunan shrinkage dalam 3 bulan pertama implementasi</span>
                            </div>
                            <div class="flex flex-col gap-1">
                                <span class="text-[56px] font-medium text-black tracking-[-0.03em] leading-none">3X</span>
                                <span class="text-[16px] font-medium text-[#BEBFBF] tracking-[-0.03em] leading-snug">Lebih cepat dalam proses pengecekan stok harian</span>
                            </div>
                            <div class="flex flex-col gap-1">
                                <span class="text-[56px] font-medium text-black tracking-[-0.03em] leading-none">98%</span>
                                <span class="text-[16px] font-medium text-[#BEBFBF] tracking-[-0.03em] leading-snug">Akurasi visibilitas stok antar rak dan gudang</span>
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

        <!-- GSAP Scroll Handling Script -->
        <script>
            document.addEventListener('livewire:navigated', async () => {
                if (typeof ScrollTrigger !== 'undefined') {
                    ScrollTrigger.getAll().forEach(t => t.kill());
                }

                // Registrasi ScrollTrigger ke GSAP
                gsap.registerPlugin(ScrollTrigger);

                // Tunggu font sampai benar-benar siap
                await document.fonts.ready;

                // Kasih delay sedikit biar layout stabil
                setTimeout(() => {
                    ScrollTrigger.refresh();
                }, 500);
            });
        </script>
        @livewireScripts
    </body>
</html>
