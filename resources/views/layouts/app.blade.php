<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <!--
        Layout: App Layout
        Deskripsi: Master Layout Portal Akademik Kampus untuk Sistem Pendaftaran Beasiswa.
                   Menyediakan Navigation Bar resmi, container responsif bernuansa Royal Blue / Slate,
                   dan footer institusi pendidikan tinggi.
        Author: Sena
        Tanggal: 29 Oktober 2026
        Versi: 1.0.0
        Unit Kompetensi: J.620100.005.02 (Mengimplementasikan User Interface)
    -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Sistem Pendaftaran Beasiswa Kampus Online') - Portal Akademik Resmi</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Chart.js for Multimedia Graphics (Unit J.620100.010.01 & J.620100.019.02) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col min-h-screen text-slate-800 bg-slate-50 antialiased selection:bg-blue-700 selection:text-white font-sans">
    <!-- Top Accent Stripe -->
    <div class="h-1 bg-gradient-to-r from-blue-700 via-indigo-600 to-amber-500"></div>

    <!-- Header & Navigation Bar Utama (Portal Akademik) - Morphing: Kotak Edge-to-Edge di Paling Atas, Floating Capsule Pill saat Scroll -->
    <header id="main-header" class="sticky top-0 z-40 w-full morph-header">
        <div id="header-container" class="max-w-7xl mx-auto px-4 sm:px-8 py-3.5 sm:py-4 morph-container">
            <div class="flex items-center justify-between gap-3">
                
                <!-- Logo & Identitas Kampus (Typography Bersih Tanpa Icon Kotak Biru) -->
                <a href="{{ route('beasiswa.home') }}" class="flex items-center gap-3 group focus:outline-none shrink-0">
                    <div class="flex flex-col">
                        <div class="flex items-center gap-1.5">
                            <span class="text-[10px] font-extrabold uppercase tracking-widest text-blue-700 leading-tight">PORTAL AKADEMIK</span>
                        </div>
                        <h1 class="text-sm sm:text-base font-extrabold tracking-tight text-slate-900 leading-none group-hover:text-blue-700 transition-colors">
                            Beasiswa Kampus
                        </h1>
                    </div>
                </a>

                <!-- Desktop Segmented Capsule Navigation Tabs (3 Menu Wajib BNSP) -->
                <nav class="hidden md:flex items-center p-1.5 bg-slate-100/80 backdrop-blur-md rounded-full border border-slate-200/80 shadow-inner gap-1" aria-label="Main Navigation">
                    
                    <!-- Menu 1: Pilihan Beasiswa -->
                    <a href="{{ route('beasiswa.index') }}" 
                       id="nav-beasiswa"
                       class="flex items-center gap-2 px-4 py-2 rounded-full text-xs transition-all duration-200 {{ request()->routeIs('beasiswa.index') || request()->routeIs('beasiswa.home') ? 'bg-gradient-to-b from-[#38BDF8] via-[#2563EB] to-[#1D4ED8] text-white ring-1 ring-inset ring-white/20 shadow-[inset_0_1px_0_rgba(255,255,255,0.35),0_6px_14px_-3px_rgba(29,78,216,0.45)] font-bold' : 'text-slate-600 hover:text-blue-700 hover:bg-white/80 font-semibold' }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <span>Pilihan Beasiswa</span>
                    </a>

                    <!-- Menu 2: Daftar Beasiswa -->
                    <a href="{{ route('beasiswa.create') }}" 
                       id="nav-daftar"
                       class="flex items-center gap-2 px-4 py-2 rounded-full text-xs transition-all duration-200 {{ request()->routeIs('beasiswa.create') ? 'bg-gradient-to-b from-[#38BDF8] via-[#2563EB] to-[#1D4ED8] text-white ring-1 ring-inset ring-white/20 shadow-[inset_0_1px_0_rgba(255,255,255,0.35),0_6px_14px_-3px_rgba(29,78,216,0.45)] font-bold' : 'text-slate-600 hover:text-blue-700 hover:bg-white/80 font-semibold' }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <span>Daftar Beasiswa</span>
                    </a>

                    <!-- Menu 3: Hasil & Rekapitulasi -->
                    <a href="{{ route('beasiswa.hasil') }}" 
                       id="nav-hasil"
                       class="flex items-center gap-2 px-4 py-2 rounded-full text-xs transition-all duration-200 {{ request()->routeIs('beasiswa.hasil') || request()->routeIs('beasiswa.detail') ? 'bg-gradient-to-b from-[#38BDF8] via-[#2563EB] to-[#1D4ED8] text-white ring-1 ring-inset ring-white/20 shadow-[inset_0_1px_0_rgba(255,255,255,0.35),0_6px_14px_-3px_rgba(29,78,216,0.45)] font-bold' : 'text-slate-600 hover:text-blue-700 hover:bg-white/80 font-semibold' }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span>Hasil &amp; Rekapitulasi</span>
                    </a>
                </nav>

                <!-- Right Quick Dynamic CTA Pill -->
                <div class="hidden md:flex items-center gap-2 shrink-0">
                    @if(request()->routeIs('beasiswa.create'))
                        <a href="{{ route('beasiswa.hasil') }}" 
                           class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-slate-100 hover:bg-slate-200/80 text-slate-700 text-xs font-bold border border-slate-200/90 transition-all shadow-2xs">
                            <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <span>Cek Status</span>
                        </a>
                    @else
                        <a href="{{ route('beasiswa.create') }}" 
                           data-slot="button" 
                           data-variant="specialtive" 
                           class="group/button inline-flex shrink-0 items-center justify-center font-bold text-xs rounded-full px-4 py-2 bg-gradient-to-b from-[#38BDF8] via-[#2563EB] to-[#1D4ED8] text-white ring-1 ring-inset ring-white/20 shadow-[inset_0_1px_0_rgba(255,255,255,0.35),0_6px_14px_-3px_rgba(29,78,216,0.45)] hover:from-[#60A5FA] hover:via-[#3B82F6] hover:to-[#2563EB] active:translate-y-px transition-all gap-1.5 cursor-pointer">
                            <span>Daftar Sekarang</span>
                            <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    @endif
                </div>

                <!-- Mobile Menu Button (Capsule Round Toggle) -->
                <div class="flex md:hidden">
                    <button type="button" 
                            id="mobile-menu-btn" 
                            class="w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center border border-slate-200 transition-colors cursor-pointer" 
                            aria-label="Toggle navigation">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                        </svg>
                    </button>
                </div>

            </div>

            <!-- Mobile Navigation Menu Floating Card -->
            <div id="mobile-menu" class="hidden md:hidden mt-3 pt-3 border-t border-slate-200/80">
                <div class="flex flex-col gap-1.5">
                    <a href="{{ route('beasiswa.index') }}" 
                       class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('beasiswa.index') || request()->routeIs('beasiswa.home') ? 'bg-gradient-to-b from-[#38BDF8] via-[#2563EB] to-[#1D4ED8] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-100' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        <span>1. Pilihan Beasiswa</span>
                    </a>
                    <a href="{{ route('beasiswa.create') }}" 
                       class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('beasiswa.create') ? 'bg-gradient-to-b from-[#38BDF8] via-[#2563EB] to-[#1D4ED8] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-100' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        <span>2. Daftar Beasiswa</span>
                    </a>
                    <a href="{{ route('beasiswa.hasil') }}" 
                       class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('beasiswa.hasil') || request()->routeIs('beasiswa.detail') ? 'bg-gradient-to-b from-[#38BDF8] via-[#2563EB] to-[#1D4ED8] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-100' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        <span>3. Hasil &amp; Rekapitulasi</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Notifikasi Flash Message Global -->
    @if(session('success') || session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pt-5">
            @if(session('success'))
                <div class="flex items-center gap-3.5 p-4 text-emerald-950 bg-emerald-50 rounded-xl border border-emerald-200 shadow-xs text-xs font-medium" role="alert">
                    <div class="w-7 h-7 rounded-lg bg-emerald-600 text-white flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div class="leading-relaxed">
                        <span class="font-bold text-emerald-900">Berhasil!</span> {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="flex items-center gap-3.5 p-4 text-rose-950 bg-rose-50 rounded-xl border border-rose-200 shadow-xs text-xs font-medium" role="alert">
                    <div class="w-7 h-7 rounded-lg bg-rose-600 text-white flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <div class="leading-relaxed">
                        <span class="font-bold text-rose-900">Perhatian:</span> {{ session('error') }}
                    </div>
                </div>
            @endif
        </div>
    @endif

    <!-- Main Content Container -->
    <main class="@yield('main_class', 'flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10')">
        @yield('content')
    </main>

    <!-- Footer Institusi Portal Akademik -->
    <footer class="mt-auto bg-white border-t border-slate-200/90 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-slate-500">
            <div class="flex items-center gap-2.5">
                <span>Biro Administrasi Akademik &amp; Kemahasiswaan (BAAK)</span>
            </div>
        </div>
    </footer>

    <!-- Script Morphing Dynamic Navbar & Menu Mobile -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.getElementById('main-header');
            let isTicking = false;

            function handleScroll() {
                if (!header) return;
                if (!isTicking) {
                    window.requestAnimationFrame(function() {
                        // Saat scroll lebih dari 20px, berubah menjadi floating capsule
                        if (window.scrollY > 20) {
                            header.classList.add('is-scrolled');
                        } else {
                            header.classList.remove('is-scrolled');
                        }
                        isTicking = false;
                    });
                    isTicking = true;
                }
            }

            window.addEventListener('scroll', handleScroll, { passive: true });
            handleScroll(); // Pengecekan saat halaman pertama kali dibuka

            // Toggle menu mobile
            const btn = document.getElementById('mobile-menu-btn');
            const menu = document.getElementById('mobile-menu');
            if (btn && menu) {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    menu.classList.toggle('hidden');
                });

                document.addEventListener('click', function(e) {
                    if (!menu.contains(e.target) && !btn.contains(e.target)) {
                        menu.classList.add('hidden');
                    }
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
