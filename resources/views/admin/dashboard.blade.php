@extends('layouts.admin')

@section('title', 'Panel Administrator - Rekapitulasi & Verifikasi Pendaftar')

@section('content')
<!--
    View: admin.dashboard
    Deskripsi: Dashboard pengelolaan data pendaftar beasiswa kampus khusus Administrator.
               Menggunakan master layout terisolasi (layouts.admin), menampilkan metrik,
               grafik statistik Chart.js, serta tabel lengkap pendaftar dengan pengubah status ajuan.
    Author: Sena
    Tanggal: 29 Oktober 2026
    Versi: 1.0.0
    Unit Kompetensi: J.620100.005.02, J.620100.010.01, J.620100.015.01, J.620100.017.02, J.620100.019.02
-->

<div class="space-y-8">
    
    <!-- Header Admin Dashboard -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-200 pb-5">
        <div>
            <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">
                Panel Verifikasi &amp; Rekapitulasi Beasiswa
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 max-w-2xl mt-1">
                Kelola berkas calon penerima beasiswa, lakukan evaluasi kelayakan akademik, dan perbarui status ajuan pendaftar.
            </p>
        </div>
    </div>

    <!-- Metrik Statistik Pendaftaran (Key Performance Indicators) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Pendaftar -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400">Total Berkas Masuk</span>
                <span class="text-2xl sm:text-3xl font-black tracking-tight text-slate-900 font-mono mt-0.5 block">{{ $totalPendaftar }}</span>
                <span class="text-[11px] font-semibold text-blue-700 block mt-0.5">Mahasiswa terdaftar</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center shrink-0 border border-blue-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
        </div>

        <!-- Pending (Belum diverifikasi) -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400">Berkas Pending</span>
                <span class="text-2xl sm:text-3xl font-black tracking-tight text-amber-600 font-mono mt-0.5 block">{{ $totalBelumDiverifikasi }}</span>
                <span class="text-[11px] font-semibold text-amber-700 block mt-0.5">Menunggu verifikasi</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 border border-amber-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <!-- Terverifikasi -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400">Terverifikasi</span>
                <span class="text-2xl sm:text-3xl font-black tracking-tight text-emerald-600 font-mono mt-0.5 block">{{ $totalTerverifikasi }}</span>
                <span class="text-[11px] font-semibold text-emerald-700 block mt-0.5">Disetujui panitia</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <!-- Ditolak -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400">Tidak Memenuhi</span>
                <span class="text-2xl sm:text-3xl font-black tracking-tight text-rose-600 font-mono mt-0.5 block">{{ $totalDitolak }}</span>
                <span class="text-[11px] font-semibold text-rose-700 block mt-0.5">Berkas ditolak</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0 border border-rose-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

    </div>

    <!-- TABEL UTAMA KELOLA DATA & STATUS PENDAFTAR -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden space-y-4">
        
        <!-- Header & Filter Tabel -->
        <div class="p-5 sm:p-6 border-b border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="text-base sm:text-lg font-extrabold text-slate-900 tracking-tight">
                    Tabel Rekapitulasi &amp; Pengubahan Status Ajuan
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Gunakan kontrol dropdown pada kolom <strong class="text-blue-700 font-bold">"Ubah Status"</strong> untuk menyetujui atau menolak berkas.
                </p>
            </div>

            <!-- Form Filter & Pencarian Cepat Admin (Shadcn UI Select Dropdown) -->
            <form id="admin-filter-form" method="GET" action="{{ route('admin.dashboard') }}" class="flex flex-wrap items-center gap-2">
                <div class="relative">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari nama / email..." 
                        class="pl-9 pr-3 py-2 bg-slate-50 rounded-xl border border-slate-200 text-xs font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-700 focus:bg-white w-48 sm:w-60 transition-all">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>

                <!-- Shadcn Select Component untuk Filter Status -->
                <div class="relative" id="filter-select-wrapper">
                    <input type="hidden" name="status" id="filter-status-input" value="{{ request('status') }}">
                    
                    <!-- SelectTrigger -->
                    <button 
                        type="button" 
                        id="filter-select-trigger" 
                        onclick="toggleFilterSelect(event)"
                        class="flex h-9 min-w-[145px] items-center justify-between rounded-md border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-800 shadow-2xs hover:bg-slate-50 focus:outline-none focus:ring-1 focus:ring-slate-950 cursor-pointer transition-all">
                        <span id="filter-select-label" class="flex items-center gap-1.5">
                            @if(request('status') === 'Belum diverifikasi')
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                <span>Pending</span>
                            @elseif(request('status') === 'Terverifikasi')
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                <span>Terverifikasi</span>
                            @elseif(request('status') === 'Ditolak')
                                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                <span>Ditolak</span>
                            @else
                                <span>Semua Status</span>
                            @endif
                        </span>
                        <svg class="h-4 w-4 text-slate-400 shrink-0 ml-1.5 transition-transform" id="filter-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- SelectContent (Shadcn Popover) -->
                    <div 
                        id="filter-select-menu" 
                        class="hidden absolute right-0 sm:left-0 mt-1.5 z-40 min-w-[160px] rounded-md border border-slate-200 bg-white text-slate-950 shadow-md p-1">
                        <div class="space-y-0.5">
                            <!-- Option: Semua Status -->
                            <button 
                                type="button" 
                                onclick="selectFilterOption('')"
                                class="relative flex w-full cursor-pointer select-none items-center rounded-sm py-1.5 pl-8 pr-2 text-xs font-medium outline-none hover:bg-slate-100 text-left transition-colors {{ request('status') == '' ? 'bg-slate-100 font-bold' : '' }}">
                                @if(request('status') == '')
                                    <span class="absolute left-2 flex h-3.5 w-3.5 items-center justify-center">
                                        <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </span>
                                @endif
                                <span>Semua Status</span>
                            </button>

                            <!-- Option: Pending -->
                            <button 
                                type="button" 
                                onclick="selectFilterOption('Belum diverifikasi')"
                                class="relative flex w-full cursor-pointer select-none items-center rounded-sm py-1.5 pl-8 pr-2 text-xs font-medium outline-none hover:bg-slate-100 text-left transition-colors {{ request('status') === 'Belum diverifikasi' ? 'bg-amber-50 text-amber-900 font-bold' : '' }}">
                                @if(request('status') === 'Belum diverifikasi')
                                    <span class="absolute left-2 flex h-3.5 w-3.5 items-center justify-center">
                                        <svg class="h-4 w-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </span>
                                @endif
                                <span class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                    <span>Pending</span>
                                </span>
                            </button>

                            <!-- Option: Terverifikasi -->
                            <button 
                                type="button" 
                                onclick="selectFilterOption('Terverifikasi')"
                                class="relative flex w-full cursor-pointer select-none items-center rounded-sm py-1.5 pl-8 pr-2 text-xs font-medium outline-none hover:bg-slate-100 text-left transition-colors {{ request('status') === 'Terverifikasi' ? 'bg-emerald-50 text-emerald-900 font-bold' : '' }}">
                                @if(request('status') === 'Terverifikasi')
                                    <span class="absolute left-2 flex h-3.5 w-3.5 items-center justify-center">
                                        <svg class="h-4 w-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </span>
                                @endif
                                <span class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    <span>Terverifikasi</span>
                                </span>
                            </button>

                            <!-- Option: Ditolak -->
                            <button 
                                type="button" 
                                onclick="selectFilterOption('Ditolak')"
                                class="relative flex w-full cursor-pointer select-none items-center rounded-sm py-1.5 pl-8 pr-2 text-xs font-medium outline-none hover:bg-slate-100 text-left transition-colors {{ request('status') === 'Ditolak' ? 'bg-rose-50 text-rose-900 font-bold' : '' }}">
                                @if(request('status') === 'Ditolak')
                                    <span class="absolute left-2 flex h-3.5 w-3.5 items-center justify-center">
                                        <svg class="h-4 w-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </span>
                                @endif
                                <span class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                    <span>Ditolak</span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>

                @if(request('search') || request('status'))
                    <a href="{{ route('admin.dashboard') }}" 
                       class="inline-flex items-center gap-1.5 h-9 px-3 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-xs transition-all border border-slate-200 shadow-2xs"
                       title="Hapus filter & reset">
                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        <span>Reset</span>
                    </a>
                @endif
            </form>
        </div>

        <!-- Tabel Responsif -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-[11px] font-extrabold text-slate-600 uppercase tracking-wider">
                        <th class="py-3.5 px-4 text-center w-12">No</th>
                        <th class="py-3.5 px-4">Nama Mahasiswa</th>
                        <th class="py-3.5 px-4">Kontak</th>
                        <th class="py-3.5 px-4 text-center">Semester</th>
                        <th class="py-3.5 px-4 text-center">IPK</th>
                        <th class="py-3.5 px-4">Beasiswa</th>
                        <th class="py-3.5 px-4 text-center">Berkas</th>
                        <th class="py-3.5 px-4 text-center">Status Ajuan</th>
                        <th class="py-3.5 px-4 text-center">Ubah Status</th>
                        <th class="py-3.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pendaftar as $index => $item)
                        <tr class="hover:bg-blue-50/30 transition-colors">
                            
                            <!-- Nomor Urut (Mengikuti Penomoran Halaman Pagination) -->
                            <td class="py-4 px-4 text-center font-mono text-slate-400">
                                {{ $pendaftar->firstItem() ? $pendaftar->firstItem() + $index : $index + 1 }}
                            </td>

                            <!-- Nama & Waktu Daftar -->
                            <td class="py-4 px-4">
                                <span class="font-extrabold text-slate-900 block text-xs sm:text-sm">{{ $item->nama }}</span>
                                <span class="text-[11px] text-slate-400 font-mono">{{ $item->created_at->format('d M Y, H:i') }} WIB</span>
                            </td>

                            <!-- Kontak Email & HP -->
                            <td class="py-4 px-4 space-y-1">
                                <div class="flex items-center gap-1.5 text-slate-700 text-xs">
                                    <svg class="w-3.5 h-3.5 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    <span class="truncate max-w-[160px]">{{ $item->email }}</span>
                                </div>
                                <div class="flex items-center gap-1.5 text-slate-600 text-xs font-mono">
                                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    <span>{{ $item->nomor_hp }}</span>
                                </div>
                            </td>

                            <!-- Semester -->
                            <td class="py-4 px-4 text-center">
                                <span class="px-2.5 py-1 rounded-md bg-blue-50 text-blue-800 border border-blue-100 font-mono font-bold text-xs">
                                    Sem. {{ $item->semester }}
                                </span>
                            </td>

                            <!-- Nilai IPK -->
                            <td class="py-4 px-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-mono font-bold {{ $item->ipk >= 3.00 ? 'bg-emerald-50 text-emerald-800 border border-emerald-300' : 'bg-rose-50 text-rose-800 border border-rose-300' }}">
                                    {{ number_format($item->ipk, 2) }}
                                </span>
                            </td>

                            <!-- Pilihan Beasiswa -->
                            <td class="py-4 px-4">
                                <span class="font-bold text-slate-900 block text-xs">{{ $item->pilihan_beasiswa }}</span>
                            </td>

                            <!-- Berkas Persyaratan -->
                            <td class="py-4 px-4 text-center">
                                @if($item->berkas)
                                    <div class="inline-flex items-center gap-1.5">
                                        <a href="{{ route('beasiswa.berkas.download', $item->id) }}" 
                                           title="Unduh Berkas" 
                                           class="p-1.5 rounded-lg border border-slate-200 hover:bg-blue-50 hover:text-blue-700 text-slate-700 transition-all shadow-2xs">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                        </a>
                                        <a href="{{ $item->berkas_url }}" 
                                           target="_blank" 
                                           title="Preview Tab Baru" 
                                           class="p-1.5 rounded-lg border border-slate-200 hover:bg-blue-50 hover:text-blue-700 text-slate-700 transition-all shadow-2xs">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400 italic">-</span>
                                @endif
                            </td>

                            <!-- Status Ajuan Saat Ini (Shadcn Badge Minimalis) -->
                            <td class="py-4 px-4 text-center">
                                @if($item->status_ajuan === 'Terverifikasi')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-xs font-medium bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span>Terverifikasi</span>
                                    </span>
                                @elseif($item->status_ajuan === 'Ditolak')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-xs font-medium bg-rose-50 text-rose-800 border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        <span>Ditolak</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-xs font-medium bg-amber-50 text-amber-800 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        <span>Pending</span>
                                    </span>
                                @endif
                            </td>

                            <!-- UBAH STATUS VERIFIKASI (Shadcn DropdownMenu Form) -->
                            <td class="py-4 px-4 text-center">
                                <div class="relative inline-block text-left" id="status-dropdown-wrap-{{ $item->id }}">
                                    <!-- Trigger Button -->
                                    <button 
                                        type="button" 
                                        onclick="toggleRowStatusMenu({{ $item->id }}, event)"
                                        class="inline-flex items-center justify-between gap-1.5 h-8 px-2.5 rounded-md border border-slate-200 bg-white text-xs font-semibold shadow-2xs hover:bg-slate-50 focus:outline-none focus:ring-1 focus:ring-slate-950 transition-all cursor-pointer">
                                        <span class="flex items-center gap-1.5">
                                            @if($item->status_ajuan === 'Terverifikasi')
                                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                                <span class="text-emerald-700 font-bold">Setujui</span>
                                            @elseif($item->status_ajuan === 'Ditolak')
                                                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                                <span class="text-rose-700 font-bold">Tolak</span>
                                            @else
                                                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                                <span class="text-amber-700 font-bold">Pending</span>
                                            @endif
                                        </span>
                                        <svg class="w-3.5 h-3.5 text-slate-400 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>

                                    <!-- Dropdown Menu (Shadcn Popover) -->
                                    <div 
                                        id="status-menu-{{ $item->id }}" 
                                        class="hidden absolute right-0 mt-1 z-30 min-w-[140px] rounded-md border border-slate-200 bg-white text-slate-900 shadow-md p-1">
                                        <form method="POST" action="{{ route('admin.status.update', $item->id) }}" id="form-status-{{ $item->id }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status_ajuan" id="status-val-{{ $item->id }}" value="{{ $item->status_ajuan }}">
                                            
                                            <!-- Option 1: Pending -->
                                            <button 
                                                type="button" 
                                                onclick="submitStatusChange({{ $item->id }}, 'Belum diverifikasi')"
                                                class="relative flex w-full items-center rounded-sm py-1.5 pl-7 pr-2 text-xs font-medium hover:bg-slate-100 transition-colors cursor-pointer text-left {{ $item->status_ajuan === 'Belum diverifikasi' ? 'bg-amber-50 text-amber-900 font-bold' : 'text-slate-700' }}">
                                                @if($item->status_ajuan === 'Belum diverifikasi')
                                                    <span class="absolute left-2 flex h-3.5 w-3.5 items-center justify-center">
                                                        <svg class="h-3.5 w-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                    </span>
                                                @endif
                                                <span class="flex items-center gap-1.5">
                                                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                                    <span>Pending</span>
                                                </span>
                                            </button>

                                            <!-- Option 2: Setujui -->
                                            <button 
                                                type="button" 
                                                onclick="submitStatusChange({{ $item->id }}, 'Terverifikasi')"
                                                class="relative flex w-full items-center rounded-sm py-1.5 pl-7 pr-2 text-xs font-medium hover:bg-slate-100 transition-colors cursor-pointer text-left {{ $item->status_ajuan === 'Terverifikasi' ? 'bg-emerald-50 text-emerald-900 font-bold' : 'text-slate-700' }}">
                                                @if($item->status_ajuan === 'Terverifikasi')
                                                    <span class="absolute left-2 flex h-3.5 w-3.5 items-center justify-center">
                                                        <svg class="h-3.5 w-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                    </span>
                                                @endif
                                                <span class="flex items-center gap-1.5">
                                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                                    <span>Setujui</span>
                                                </span>
                                            </button>

                                            <!-- Option 3: Tolak -->
                                            <button 
                                                type="button" 
                                                onclick="submitStatusChange({{ $item->id }}, 'Ditolak')"
                                                class="relative flex w-full items-center rounded-sm py-1.5 pl-7 pr-2 text-xs font-medium hover:bg-slate-100 transition-colors cursor-pointer text-left {{ $item->status_ajuan === 'Ditolak' ? 'bg-rose-50 text-rose-900 font-bold' : 'text-slate-700' }}">
                                                @if($item->status_ajuan === 'Ditolak')
                                                    <span class="absolute left-2 flex h-3.5 w-3.5 items-center justify-center">
                                                        <svg class="h-3.5 w-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                    </span>
                                                @endif
                                                <span class="flex items-center gap-1.5">
                                                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                                    <span>Tolak</span>
                                                </span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>

                            <!-- Aksi Detail & Hapus -->
                            <td class="py-4 px-4 text-center">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('beasiswa.detail', $item->id) }}" 
                                       target="_blank"
                                       title="Buka Lembar Detail"
                                       class="p-1.5 rounded-lg border border-slate-200 hover:bg-slate-100 text-slate-600 hover:text-slate-900 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>

                                    <form method="POST" action="{{ route('admin.pendaftar.destroy', $item->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pendaftar ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Data" class="p-1.5 rounded-lg border border-slate-200 hover:bg-rose-50 text-slate-400 hover:text-rose-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="py-12 text-center text-slate-400 text-xs">
                                <div class="space-y-2">
                                    <svg class="w-8 h-8 mx-auto text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <p class="font-medium">Belum ada data pendaftaran beasiswa yang sesuai dengan kriteria filter.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer Tabel: Info Data & Shadcn Pagination Component (Maksimal 5 data per halaman) -->
        <div class="p-4 sm:p-5 border-t border-slate-200 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-4">
            
            <!-- Info Data -->
            <div class="text-xs text-slate-500">
                @if($pendaftar->total() > 0)
                    Menampilkan <strong class="text-slate-900 font-semibold">{{ $pendaftar->firstItem() }}</strong> sampai <strong class="text-slate-900 font-semibold">{{ $pendaftar->lastItem() }}</strong> dari <strong class="text-slate-900 font-semibold">{{ $pendaftar->total() }}</strong> pendaftar (maks. 5 data)
                @else
                    Tidak ada data pendaftar yang ditampilkan
                @endif
            </div>

            <!-- Shadcn Pagination Component -->
            @if($pendaftar->hasPages())
                <nav role="navigation" aria-label="pagination" class="flex items-center justify-end">
                    <ul class="flex flex-row items-center gap-1">
                        
                        <!-- Previous Page Link -->
                        <li>
                            @if($pendaftar->onFirstPage())
                                <span aria-disabled="true" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-xs font-medium opacity-50 cursor-not-allowed h-8 px-2.5 gap-1 border border-slate-200 bg-white text-slate-400">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                    <span>Sebelumnya</span>
                                </span>
                            @else
                                <a href="{{ $pendaftar->previousPageUrl() }}" 
                                   class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-xs font-medium transition-colors hover:bg-slate-100 hover:text-slate-900 h-8 px-2.5 gap-1 border border-slate-200 bg-white text-slate-700 shadow-2xs">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                    <span>Sebelumnya</span>
                                </a>
                            @endif
                        </li>

                        <!-- Numeric Pagination Elements -->
                        @foreach ($pendaftar->getUrlRange(1, $pendaftar->lastPage()) as $page => $url)
                            <li>
                                @if ($page == $pendaftar->currentPage())
                                    <span aria-current="page" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-xs font-semibold h-8 w-8 bg-gradient-to-b from-[#38BDF8] via-[#2563EB] to-[#1D4ED8] text-white ring-1 ring-inset ring-white/20 shadow-xs">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" 
                                       class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-xs font-medium transition-colors hover:bg-slate-100 hover:text-slate-900 h-8 w-8 border border-slate-200 bg-white text-slate-700 shadow-2xs">
                                        {{ $page }}
                                    </a>
                                @endif
                            </li>
                        @endforeach

                        <!-- Next Page Link -->
                        <li>
                            @if($pendaftar->hasMorePages())
                                <a href="{{ $pendaftar->nextPageUrl() }}" 
                                   class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-xs font-medium transition-colors hover:bg-slate-100 hover:text-slate-900 h-8 px-2.5 gap-1 border border-slate-200 bg-white text-slate-700 shadow-2xs">
                                    <span>Berikutnya</span>
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            @else
                                <span aria-disabled="true" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-xs font-medium opacity-50 cursor-not-allowed h-8 px-2.5 gap-1 border border-slate-200 bg-white text-slate-400">
                                    <span>Berikutnya</span>
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </span>
                            @endif
                        </li>

                    </ul>
                </nav>
            @endif

        </div>

    </div>

</div>

<!-- Inisialisasi Script Kontrol Dropdown Shadcn & Grafik Chart.js -->
<script>
    // 1. Kontrol Dropdown Select Filter Status (Shadcn Style)
    function toggleFilterSelect(e) {
        e.stopPropagation();
        const menu = document.getElementById('filter-select-menu');
        const chevron = document.getElementById('filter-chevron');
        if (menu) {
            menu.classList.toggle('hidden');
            if (chevron) chevron.classList.toggle('rotate-180');
        }
        closeAllRowMenus();
    }

    function selectFilterOption(val) {
        document.getElementById('filter-status-input').value = val;
        document.getElementById('admin-filter-form').submit();
    }

    // 2. Kontrol Dropdown Baris Tabel Ubah Status (Shadcn Style)
    function toggleRowStatusMenu(id, e) {
        e.stopPropagation();
        const menu = document.getElementById('status-menu-' + id);
        const isClosed = menu ? menu.classList.contains('hidden') : true;
        
        closeAllRowMenus();
        const filterMenu = document.getElementById('filter-select-menu');
        const chevron = document.getElementById('filter-chevron');
        if (filterMenu) filterMenu.classList.add('hidden');
        if (chevron) chevron.classList.remove('rotate-180');

        if (menu && isClosed) {
            menu.classList.remove('hidden');
        }
    }

    function submitStatusChange(id, status) {
        document.getElementById('status-val-' + id).value = status;
        document.getElementById('form-status-' + id).submit();
    }

    function closeAllRowMenus() {
        document.querySelectorAll('[id^="status-menu-"]').forEach(el => el.classList.add('hidden'));
    }

    // Klik di luar jendela menutup semua popover dropdown
    document.addEventListener('click', function() {
        const filterMenu = document.getElementById('filter-select-menu');
        const chevron = document.getElementById('filter-chevron');
        if (filterMenu) filterMenu.classList.add('hidden');
        if (chevron) chevron.classList.remove('rotate-180');
        closeAllRowMenus();
    });

    // Menutup dengan tombol Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const filterMenu = document.getElementById('filter-select-menu');
            const chevron = document.getElementById('filter-chevron');
            if (filterMenu) filterMenu.classList.add('hidden');
            if (chevron) chevron.classList.remove('rotate-180');
            closeAllRowMenus();
        }
    });
</script>
@endsection

