<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-900">
<head>
    <!--
        View: admin.login (Standalone Document - Terpisah Penuh dari Layout User app.blade)
        Deskripsi: Halaman login administrator beasiswa dengan tampilan card vertikal proporsional di tengah layar,
                   berlatar belakang biru akademis bertitik-titik putih persis seperti Hero section,
                   dilengkapi bayangan kontras kuat (shadow).
        Author: Sena
        Tanggal: 29 Oktober 2026
        Versi: 1.0.0
        Unit Kompetensi: J.620100.005.02, J.620100.015.01
    -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login Administrator - Portal Beasiswa</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-900 via-indigo-900 to-slate-900 text-slate-100 flex flex-col justify-between p-4 sm:p-6 lg:p-8 relative overflow-x-hidden font-sans antialiased selection:bg-blue-600 selection:text-white">

    <!-- Ambient Academic Pattern Background (Titik-titik Putih Persis Seperti Hero) -->
    <div class="absolute inset-0 opacity-15 pointer-events-none bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:20px_20px]"></div>

    <!-- Ambient Subtle Glow di Belakang Form Login -->
    <div class="absolute inset-x-0 top-1/4 h-96 bg-gradient-to-tr from-blue-500/30 via-indigo-500/25 to-amber-500/20 rounded-full blur-3xl opacity-75 pointer-events-none"></div>

    <!-- Card Login Administrator di Tengah (Desain Vertikal Proporsional, Lebih Tinggi dengan Shadow Kuat) -->
    <main class="relative z-10 w-full max-w-md mx-auto my-auto bg-white rounded-3xl shadow-[0_25px_60px_-15px_rgba(0,0,0,0.55)] border border-white/30 p-7 sm:p-9 text-slate-800 space-y-6">
        
        <!-- Header Form Login (Tengah & Ikon Menonjol) -->
        <div class="text-center space-y-2.5">
            <div class="w-13 h-13 w-12 h-12 rounded-2xl bg-blue-700 text-white mx-auto flex items-center justify-center shadow-md">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <div>
                <span class="block text-[11px] font-extrabold uppercase tracking-wider text-blue-700">PANEL TERBATAS</span>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 mt-0.5">
                    Login Administrator
                </h1>
            </div>
            <p class="text-xs text-slate-500 leading-relaxed px-2">
                Masuk untuk mengelola dan memverifikasi data pendaftar beasiswa kampus.
            </p>
        </div>

        <!-- Notifikasi Error Login Jika Ada -->
        @if(session('error'))
            <div class="p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold flex items-center gap-2">
                <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Form Login (Susunan Vertikal Rapi) -->
        <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4">
            @csrf

            <!-- Input Username / Email -->
            <div class="space-y-1.5">
                <label for="login" class="block text-xs font-bold text-slate-700">
                    Email / Username Administrator <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        id="login" 
                        name="login" 
                        value="{{ old('login', 'admin@kampus.ac.id') }}" 
                        placeholder="admin@kampus.ac.id atau admin" 
                        required 
                        class="w-full pl-10 pr-4 py-3 bg-slate-50 rounded-xl border @error('login') border-rose-300 bg-rose-50/50 @else border-slate-200 @enderror text-xs sm:text-sm font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-700 focus:bg-white transition-all shadow-2xs"
                    >
                </div>
                @error('login')
                    <p class="text-[11px] text-rose-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Input Password -->
            <div class="space-y-1.5">
                <label for="password" class="block text-xs font-bold text-slate-700">
                    Kata Sandi (Password) <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="••••••••" 
                        required 
                        class="w-full pl-10 pr-4 py-3 bg-slate-50 rounded-xl border @error('password') border-rose-300 bg-rose-50/50 @else border-slate-200 @enderror text-xs sm:text-sm font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-700 focus:bg-white transition-all shadow-2xs"
                    >
                </div>
                @error('password')
                    <p class="text-[11px] text-rose-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Baris Remember Me & Info Enkripsi -->
            <div class="flex items-center justify-between text-xs pt-1">
                <label class="flex items-center gap-2 text-slate-600 cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded text-blue-700 focus:ring-blue-500 border-slate-300">
                    <span>Ingat Sesi Saya</span>
                </label>
                <span class="text-slate-400 text-[11px]">Sistem SIAKAD Terenkripsi</span>
            </div>

            <!-- Submit Button (Specialtive Bright Blue Style) -->
            <button 
                type="submit" 
                data-slot="button" 
                data-variant="specialtive" 
                data-size="default" 
                class="group/button inline-flex shrink-0 items-center justify-center border-transparent font-medium whitespace-nowrap transition-all outline-none select-none active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-destructive aria-invalid:ring-3 aria-invalid:ring-destructive/20 [&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4 border-0 bg-gradient-to-b from-[#38BDF8] via-[#2563EB] to-[#1D4ED8] text-white ring-1 ring-inset ring-white/20 shadow-[inset_0_1px_0_rgba(255,255,255,0.35),0_8px_16px_-4px_rgba(29,78,216,0.5)] bg-clip-padding hover:from-[#60A5FA] hover:via-[#3B82F6] hover:to-[#2563EB] active:translate-y-px active:bg-gradient-to-b active:from-[#2563EB] active:via-[#1D4ED8] active:to-[#1E3A8A] active:shadow-[inset_0_1px_0_rgba(255,255,255,0.15)] disabled:opacity-60 cursor-pointer gap-2 px-2.5 h-11 w-full rounded-[10px] text-[15px] mt-2">
                <span>Masuk ke Panel Administrator</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </button>
        </form>

        <!-- Box Bantuan Akun Demo Asesor BNSP -->
        <div class="p-3.5 rounded-xl bg-blue-50 border border-blue-200/80 text-xs text-slate-700 space-y-1.5">
            <div class="flex items-center gap-1.5 font-bold text-blue-900">
                <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Akun Pengujian Demo (BNSP):</span>
            </div>
            <div class="font-mono text-[11px] space-y-0.5 text-slate-600">
                <p>Email: <strong class="text-blue-900">admin@kampus.ac.id</strong></p>
                <p>Password: <strong class="text-blue-900">admin123</strong> (atau <strong class="text-blue-900">admin</strong>)</p>
            </div>
        </div>

        <!-- Link Kembali ke Halaman Publik -->
        <div class="text-center pt-1 border-t border-slate-100">
            <a href="{{ route('beasiswa.home') }}" class="text-xs font-semibold text-slate-500 hover:text-blue-700 transition-colors inline-flex items-center gap-1.5">
                <span>&larr;</span>
                <span>Kembali ke Portal Publik Mahasiswa</span>
            </a>
        </div>

    </main>
</body>
</html>
