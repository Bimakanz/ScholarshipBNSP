@extends('layouts.app')

@section('title', 'Hasil & Rekapitulasi Pendaftaran Beasiswa')

@section('content')
<!--
    View: beasiswa.hasil
    Deskripsi: Halaman pencarian hasil status pendaftaran beasiswa kampus (Publik / Mahasiswa).
               Didesain bersih dan terpusat dengan input pencarian nama di tengah.
               Hasil pencarian mengarahkan ke halaman detail penerimaan read-only.
    Author: Sena
    Tanggal: 29 Oktober 2026
    Versi: 1.0.0
    Unit Kompetensi: J.620100.005.02, J.620100.010.01
-->

<div class="max-w-4xl mx-auto py-6 sm:py-10 space-y-10">

    <!-- Header Section Terpusat -->
    <div class="text-center space-y-3">
        

        <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900">
            Hasil &amp; Status Pendaftaran Beasiswa
        </h2>

        <p class="text-xs sm:text-sm text-slate-500 max-w-xl mx-auto leading-relaxed">
            Periksa hasil pengajuan beasiswa Anda dengan memasukkan nama lengkap yang digunakan saat melakukan registrasi.
        </p>
    </div>

    <!-- Form Search Input di Tengah Halaman -->
    <div class="bg-white rounded-2xl border border-slate-200 p-4 sm:p-6 shadow-sm hover:border-blue-300 transition-all">
        <form method="GET" action="{{ route('beasiswa.hasil') }}" class="relative flex flex-col sm:flex-row items-center gap-3">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ $search }}" 
                    placeholder="Ketik nama mahasiswa (contoh: Bima Gilang Ramadhan)..." 
                    class="w-full pl-12 pr-4 py-3.5 bg-slate-50 rounded-xl border border-slate-200 text-sm font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-700 focus:bg-white transition-all shadow-inner"
                    autofocus
                >
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto shrink-0">
                <button 
                    type="submit" 
                    data-slot="button" 
                    data-variant="specialtive" 
                    data-size="default" 
                    class="group/button w-full sm:w-auto inline-flex shrink-0 items-center justify-center border-transparent font-medium whitespace-nowrap transition-all outline-none select-none active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none [&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4 border-0 bg-gradient-to-b from-[#38BDF8] via-[#2563EB] to-[#1D4ED8] text-white ring-1 ring-inset ring-white/20 shadow-[inset_0_1px_0_rgba(255,255,255,0.35),0_8px_16px_-4px_rgba(29,78,216,0.5)] bg-clip-padding hover:from-[#60A5FA] hover:via-[#3B82F6] hover:to-[#2563EB] active:translate-y-px active:bg-gradient-to-b active:from-[#2563EB] active:via-[#1D4ED8] active:to-[#1E3A8A] active:shadow-[inset_0_1px_0_rgba(255,255,255,0.15)] disabled:opacity-60 cursor-pointer gap-2 px-5 h-11 rounded-[10px] text-[15px]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <span>Cari Nama</span>
                </button>

                @if($search !== '')
                    <a 
                        href="{{ route('beasiswa.hasil') }}" 
                        class="px-4 py-3.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-sm transition-all"
                        title="Reset Pencarian">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        <!-- Informasi Cepat / Panduan -->
        <div class="mt-4 pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3 text-xs text-slate-500">
            <span class="font-mono text-[11px] text-slate-400">
                Total Mahasiswa Terdaftar: <strong class="text-slate-700 font-bold">{{ $totalPendaftar }} Orang</strong>
            </span>
        </div>
    </div>

    <!-- Area Hasil Pencarian (Hanya Menampilkan Nama yang Dicari) -->
    <div class="space-y-4">
        
        @if($search !== '')
            <!-- Jika User Melakukan Pencarian -->
            <div class="flex items-center justify-between text-xs text-slate-500 px-1">
                <span>Hasil pencarian untuk nama: <strong class="text-blue-700 font-bold font-mono">"{{ $search }}"</strong></span>
                <span>Ditemukan: <strong class="text-slate-800">{{ $pendaftar->count() }} data</strong></span>
            </div>

            @if($pendaftar->count() > 0)
                <div class="grid grid-cols-1 gap-3.5">
                    @foreach($pendaftar as $item)
                        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs hover:shadow-md hover:border-blue-300 transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            
                            <!-- Informasi Pendaftar -->
                            <div class="space-y-1.5">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="text-base font-extrabold text-slate-900 tracking-tight">
                                        {{ $item->nama }}
                                    </h3>

                                    <!-- Badge Program Beasiswa -->
                                    <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                        {{ $item->pilihan_beasiswa }}
                                    </span>
                                </div>

                                <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        <span>Semester {{ $item->semester }} (S1)</span>
                                    </span>
                                    <span class="text-slate-300">•</span>
                                    <span class="flex items-center gap-1 font-mono">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>{{ $item->created_at->format('d M Y, H:i') }} WIB</span>
                                    </span>
                                </div>
                            </div>

                            <!-- Status & Tombol Aksi Buka Detail -->
                            <div class="flex items-center justify-between sm:justify-end gap-3.5 shrink-0 pt-3 sm:pt-0 border-t sm:border-t-0 border-slate-100">
                                
                                <!-- Badge Status Ajuan Sesuai Aturan BNSP (Read-Only) -->
                                @if($item->status_ajuan === 'Terverifikasi')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span>Terverifikasi</span>
                                    </span>
                                @elseif($item->status_ajuan === 'Ditolak')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-rose-50 text-rose-800 border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        <span>Ditolak</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-amber-50 text-amber-800 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        <span>Pending</span>
                                    </span>
                                @endif

                                <!-- Link ke Halaman Detail Penerimaan (Specialtive Bright Blue Style) -->
                                <a 
                                    href="{{ route('beasiswa.detail', $item->id) }}" 
                                    data-slot="button" 
                                    data-variant="specialtive" 
                                    class="group/button inline-flex shrink-0 items-center justify-center border-transparent font-medium whitespace-nowrap transition-all outline-none select-none active:not-aria-[haspopup]:translate-y-px [&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-3.5 border-0 bg-gradient-to-b from-[#38BDF8] via-[#2563EB] to-[#1D4ED8] text-white ring-1 ring-inset ring-white/20 shadow-[inset_0_1px_0_rgba(255,255,255,0.35),0_6px_12px_-3px_rgba(29,78,216,0.5)] bg-clip-padding hover:from-[#60A5FA] hover:via-[#3B82F6] hover:to-[#2563EB] active:translate-y-px active:bg-gradient-to-b active:from-[#2563EB] active:via-[#1D4ED8] active:to-[#1E3A8A] active:shadow-[inset_0_1px_0_rgba(255,255,255,0.15)] cursor-pointer gap-1.5 px-3.5 h-9 rounded-[8px] text-xs">
                                    <span>Lihat Detail</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>

                            </div>

                        </div>
                    @endforeach
                </div>
            @else
                <!-- State Kosong jika Data Tidak Ditemukan -->
                <div class="bg-white rounded-2xl border border-slate-200 p-10 text-center space-y-3">
                    <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 border border-amber-200 mx-auto flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h4 class="text-base font-bold text-slate-800">Data Pendaftar Tidak Ditemukan</h4>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto">
                        Tidak ditemukan berkas pendaftaran dengan nama <strong class="text-slate-700 font-mono">"{{ $search }}"</strong>. Pastikan ejaan nama sesuai dengan yang didaftarkan.
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('beasiswa.create') }}" 
                           data-slot="button" 
                           data-variant="specialtive" 
                           class="group/button inline-flex shrink-0 items-center justify-center border-transparent font-medium whitespace-nowrap transition-all outline-none select-none active:not-aria-[haspopup]:translate-y-px [&_svg]:pointer-events-none [&_svg]:shrink-0 border-0 bg-gradient-to-b from-[#38BDF8] via-[#2563EB] to-[#1D4ED8] text-white ring-1 ring-inset ring-white/20 shadow-[inset_0_1px_0_rgba(255,255,255,0.35),0_8px_16px_-4px_rgba(29,78,216,0.5)] bg-clip-padding hover:from-[#60A5FA] hover:via-[#3B82F6] hover:to-[#2563EB] active:translate-y-px active:bg-gradient-to-b active:from-[#2563EB] active:via-[#1D4ED8] active:to-[#1E3A8A] active:shadow-[inset_0_1px_0_rgba(255,255,255,0.15)] cursor-pointer gap-2 px-4 h-10 rounded-[10px] text-xs">
                            <span>Ajukan Pendaftaran Baru</span>
                        </a>
                    </div>
                </div>
            @endif

        @else
            <!-- Tampilan Awal: Hanya Instruksi Pencarian (Tidak Menampilkan Nama Orang Lain) -->
            <div class="bg-white rounded-2xl border border-dashed border-slate-300 p-10 sm:p-12 text-center space-y-4">
                <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-700 border border-blue-200 mx-auto flex items-center justify-center shadow-2xs">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                
                <div class="space-y-1.5 max-w-md mx-auto">
                    <h4 class="text-base font-extrabold text-slate-900">
                        Cari Status Pengajuan Beasiswa Anda
                    </h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Ketik nama lengkap Anda pada kolom pencarian di atas untuk mengecek status verifikasi administrasi dan kelayakan berkas beasiswa.
                    </p>
                </div>

                <div class="pt-2 flex items-center justify-center gap-2 text-xs text-slate-400">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span>Privasi Terjaga • Data hanya ditampilkan sesuai kata kunci nama Anda</span>
                </div>
            </div>
        @endif

    </div>

</div>
@endsection
