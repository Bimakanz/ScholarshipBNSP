<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-100">
<head>
    <!--
        Layout: Admin Layout (Bebas dari app.blade)
        Deskripsi: Master Layout khusus Panel Administrator Beasiswa Kampus.
                   Navbar putih bersih modern tanpa icon shield centang,
                   dilengkapi dialog modal konfirmasi sebelum logout.
        Author: Sena
        Tanggal: 29 Oktober 2026
        Versi: 1.1.0
        Unit Kompetensi: J.620100.005.02 (Mengimplementasikan User Interface)
    -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Panel Administrator') - Sistem Seleksi Beasiswa Kampus</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Chart.js for Multimedia Graphics (Unit J.620100.010.01 & J.620100.019.02) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col min-h-screen text-slate-800 bg-slate-100 antialiased selection:bg-blue-700 selection:text-white font-sans">

    <!-- Top Accent Bar -->
    <div class="h-1 bg-gradient-to-r from-blue-700 via-indigo-600 to-amber-500"></div>

    <!-- Admin Navigation Bar (Putih Bersih, Tanpa Icon Shield Centang) -->
    <header class="sticky top-0 z-40 bg-white border-b border-slate-200 text-slate-800 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Identitas Panel Admin (Tanpa Icon Shield Centang) -->
                <div>
                    <div class="flex items-center gap-2">
                        <span class="block text-[10px] font-extrabold uppercase tracking-widest text-blue-700">PANEL ADMINISTRATOR</span>
                    </div>
                    <h1 class="text-base sm:text-lg font-extrabold tracking-tight text-slate-900 leading-tight">
                        Verifikasi &amp; Rekapitulasi Beasiswa
                    </h1>
                </div>

                <!-- Admin Session & Logout Control -->
                <div class="flex items-center gap-4">
                    
                    <div class="hidden sm:block text-right">
                        <span class="block text-xs font-bold text-slate-900">{{ Auth::user()->name ?? 'Administrator Panitia' }}</span>
                        <span class="block text-[11px] text-slate-500 font-mono">{{ Auth::user()->email ?? 'admin@kampus.ac.id' }}</span>
                    </div>

                    <!-- Tombol Keluar (Memicu Dialog Modal Konfirmasi - Specialtive Style) -->
                    <button 
                        type="button" 
                        onclick="openLogoutModal()"
                        data-slot="button" 
                        data-variant="specialtive" 
                        class="group/button inline-flex shrink-0 items-center justify-center border-transparent font-medium whitespace-nowrap transition-all outline-none select-none active:not-aria-[haspopup]:translate-y-px [&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-3.5 border-0 bg-gradient-to-b from-[#38BDF8] via-[#2563EB] to-[#1D4ED8] text-white ring-1 ring-inset ring-white/20 shadow-[inset_0_1px_0_rgba(255,255,255,0.35),0_6px_12px_-3px_rgba(29,78,216,0.5)] bg-clip-padding hover:from-[#60A5FA] hover:via-[#3B82F6] hover:to-[#2563EB] active:translate-y-px active:bg-gradient-to-b active:from-[#2563EB] active:via-[#1D4ED8] active:to-[#1E3A8A] active:shadow-[inset_0_1px_0_rgba(255,255,255,0.15)] cursor-pointer gap-1.5 px-3.5 h-9 rounded-[8px] text-xs">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>Keluar (Logout)</span>
                    </button>

                </div>

            </div>
        </div>
    </header>

    <!-- Notifikasi Flash Message Khusus Admin -->
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
                        <span class="font-bold text-emerald-900">Operasi Sukses:</span> {{ session('success') }}
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

    <!-- Main Content Slot -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
        @yield('content')
    </main>

    <!-- Footer Khusus Admin -->
    <footer class="mt-auto bg-slate-900 border-t border-slate-800 text-slate-400 py-6 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-white font-bold">Portal Administrasi Internal</span>
                <span>&bull;</span>
                <span>BAAK Universitas</span>
            </div>
            <div class="text-center md:text-right font-mono text-[11px]">
                Unit Kompetensi BNSP Junior Web Developer &bull; Author: Sena
            </div>
        </div>
    </footer>

    <!-- Dialog / Modal Konfirmasi Logout -->
    <div id="logout-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4" role="dialog" aria-modal="true" aria-labelledby="logout-modal-title">
        <!-- Backdrop Blur -->
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" onclick="closeLogoutModal()"></div>

        <!-- Modal Dialog Card -->
        <div class="relative z-10 w-full max-w-md bg-white rounded-3xl shadow-2xl border border-slate-200 p-6 sm:p-7 text-slate-800 space-y-5">
            
            <div class="flex items-start gap-4">
                <div class="space-y-1">
                    <h3 id="logout-modal-title" class="text-lg font-extrabold text-slate-900">
                        Konfirmasi Keluar Sesi
                    </h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Apakah Anda yakin ingin keluar dari Panel Administrator? Sesi manajemen pendaftaran Anda akan diakhiri.
                    </p>
                </div>
            </div>

            <!-- Tombol Aksi Modal -->
            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                <button 
                    type="button" 
                    onclick="closeLogoutModal()"
                    class="px-4 py-2.5 rounded-xl border border-slate-200 hover:bg-slate-100 text-slate-700 font-bold text-xs transition-all cursor-pointer">
                    Batal
                </button>

                <form id="logout-form" method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button 
                        type="submit" 
                        class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs transition-all shadow-sm hover:shadow-md cursor-pointer flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>Ya, Keluar</span>
                    </button>
                </form>
            </div>

        </div>
    </div>

    <!-- Script Kontrol Dialog Modal Logout -->
    <script>
        function openLogoutModal() {
            const modal = document.getElementById('logout-modal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.classList.add('overflow-hidden');
            }
        }

        function closeLogoutModal() {
            const modal = document.getElementById('logout-modal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.classList.remove('overflow-hidden');
            }
        }

        // Tutup dialog bila menekan tombol Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeLogoutModal();
            }
        });
    </script>

</body>
</html>
