@extends('layouts.app')

@section('title', 'Formulir Pendaftaran Beasiswa')

@section('content')
<!--
    View: beasiswa.daftar
    Deskripsi: Halaman formulir pendaftaran beasiswa online bernuansa Portal Akademik Resmi.
               Mengimplementasikan logika 10 butir aturan wajib BNSP, konstanta simulasi IPK (3.4 & 2.9),
               reusable custom dropdown component, kontrol kondisional aktif/non-aktif, dan auto-focus.
    Author: Sena
    Tanggal: 29 Oktober 2026
    Versi: 1.0.0
    Unit Kompetensi: J.620100.005.02, J.620100.016.01, J.620100.017.02, J.620100.019.02
-->

<div class="max-w-3xl mx-auto space-y-8">
    
    <!-- Header Halaman Formulir -->
    <div class="text-center space-y-2">
        <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">Formulir Pendaftaran Beasiswa</h2>
        <p class="text-xs sm:text-sm text-slate-500 max-w-lg mx-auto">
            Lengkapi data diri dan berkas administrasi akademik di bawah ini. Kelayakan pengajuan diverifikasi otomatis oleh standar nilai IPK kampus.
        </p>
    </div>

    <!-- Alert Box Peringatan Syarat IPK < 3.00 (Kondisional) -->
    <div id="ipk-warning-box" class="hidden transition-all duration-200">
        <div class="flex items-start gap-3.5 p-4 sm:p-5 rounded-2xl bg-rose-50 border-2 border-rose-300 text-rose-950 shadow-sm" role="alert">
            <div class="w-8 h-8 rounded-xl bg-rose-600 text-white flex items-center justify-center shrink-0 mt-0.5 shadow-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="space-y-1">
                <h4 class="text-xs sm:text-sm font-extrabold uppercase tracking-wider text-rose-950">
                    Peringatan Kelayakan IPK (Tidak Memenuhi Syarat)
                </h4>
                <p id="ipk-warning-text" class="text-xs font-semibold text-rose-800 leading-relaxed">
                    Maaf, IPK Anda di bawah 3.00, Anda tidak memenuhi syarat untuk mendaftar beasiswa.
                </p>
                <p class="text-[11px] font-semibold text-rose-700">
                    Sesuai petunjuk asesmen BNSP: Elemen Pilihan Beasiswa, Upload Berkas Syarat, dan tombol Daftar dinonaktifkan oleh sistem.
                </p>
            </div>
        </div>
    </div>

    <!-- Card Utama Formulir Pendaftaran -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-md p-6 sm:p-10">
        
        <!-- PANEL SIMULASI KONSTANTA IPK (COLLAPSIBLE / ACCORDION - AWAL TERTUTUP) -->
        <div class="mb-8 rounded-2xl bg-gradient-to-br from-blue-50/90 via-indigo-50/60 to-slate-50 border border-blue-200/90 shadow-xs overflow-hidden transition-all">
            <!-- Header Toggle Drop Button -->
            <button type="button" 
                    id="btn-toggle-simulasi" 
                    aria-expanded="false"
                    class="w-full p-4 sm:p-5 flex items-center justify-between gap-3 text-left hover:bg-blue-100/40 transition-colors focus:outline-none cursor-pointer">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="truncate">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-xs sm:text-sm font-black uppercase tracking-wider text-blue-950">
                                Switch Simulasi Konstanta IPK
                            </span>
                        </div>
                        <span class="block text-[11px] text-slate-500 mt-0.5 truncate">
                            Klik untuk membuka opsi simulasi respon sistem (IPK 3.40 / 2.90)
                        </span>
                    </div>
                </div>

                <!-- Dropdown Indicator -->
                <div class="flex items-center gap-2 shrink-0 ml-2">
                    <div class="w-7 h-7 rounded-lg bg-white border border-blue-200 flex items-center justify-center text-blue-700 shadow-2xs">
                        <svg id="chevron-simulasi" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>
            </button>

            <!-- Collapsible Content (Ketutup di Awal) -->
            <div id="panel-simulasi-content" class="hidden px-4 sm:px-5 pb-5 pt-2 border-t border-blue-200/60 space-y-3 bg-white/50">
                <p class="text-[11px] text-slate-600 font-medium">
                    Standar Uji Kompetensi BNSP (FR.IA.02 Butir 5) — Klik tombol untuk menguji respon otomatisasi antarmuka terhadap standar kelayakan IPK &ge; 3.00:
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <!-- Tombol Simulasi 1: IPK = 3.4 (Memenuhi Syarat) -->
                    <button type="button" 
                            id="btn-simulate-pass" 
                            title="Set Konstanta IPK = 3.4 (Memenuhi syarat & Auto-focus ke pilihan beasiswa)"
                            class="w-full px-4 py-2.5 rounded-xl text-xs font-bold transition-all shadow-xs flex items-center justify-center gap-2 cursor-pointer bg-emerald-600 text-white border-2 border-emerald-600 hover:bg-emerald-700 ring-2 ring-emerald-300">
                        <svg class="w-4 h-4 text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Simulasi Konstanta IPK = 3.4 (Memenuhi Syarat)</span>
                    </button>
                    <!-- Tombol Simulasi 2: IPK = 2.9 (Di Bawah Standar) -->
                    <button type="button" 
                            id="btn-simulate-fail" 
                            title="Set Konstanta IPK = 2.9 (Di bawah standar & Non-aktifkan pilihan)"
                            class="w-full px-4 py-2.5 rounded-xl text-xs font-bold transition-all shadow-xs flex items-center justify-center gap-2 cursor-pointer bg-white text-rose-800 border-2 border-rose-300 hover:bg-rose-50">
                        <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                        <span>Simulasi Konstanta IPK = 2.9 (Di Bawah Standar)</span>
                    </button>
                </div>
            </div>
        </div>

        <form id="form-pendaftaran-beasiswa" 
              action="{{ route('beasiswa.store') }}" 
              method="POST" 
              enctype="multipart/form-data" 
              class="space-y-6"
              novalidate>
            @csrf

            <!-- 1. Input: Nama Lengkap -->
            <div>
                <label for="nama" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    1. Masukkan Nama Lengkap <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <input type="text" 
                           name="nama" 
                           id="nama" 
                           value="{{ old('nama') }}" 
                           placeholder="Contoh: Bima Gilang Ramadhan" 
                           class="w-full px-4 py-3 rounded-xl border {{ $errors->has('nama') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-300 bg-white' }} focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-700 text-sm font-medium text-slate-900 transition-all shadow-2xs"
                           required>
                </div>
                @error('nama')
                    <p class="mt-1.5 text-xs text-rose-600 font-semibold flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- 2. Input: Email -->
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    2. Masukkan Email <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <input type="email" 
                           name="email" 
                           id="email" 
                           value="{{ old('email') }}" 
                           placeholder="nama.mahasiswa@student.kampus.ac.id" 
                           class="w-full px-4 py-3 rounded-xl border {{ $errors->has('email') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-300 bg-white' }} focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-700 text-sm font-medium text-slate-900 transition-all shadow-2xs"
                           required>
                </div>
                <p class="mt-1 text-[11px] text-slate-500">Program memeriksa keabsahan format email standar RFC (contoh: user@domain.com).</p>
                @error('email')
                    <p class="mt-1.5 text-xs text-rose-600 font-semibold flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- 3. Input: Nomor Handphone -->
            <div>
                <label for="nomor_hp" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    3. Nomor Handphone / WhatsApp <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <input type="tel" 
                           name="nomor_hp" 
                           id="nomor_hp" 
                           value="{{ old('nomor_hp') }}" 
                           placeholder="081234567890" 
                           maxlength="13"
                           class="w-full px-4 py-3 rounded-xl border {{ $errors->has('nomor_hp') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-300 bg-white' }} focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-700 text-sm font-medium text-slate-900 transition-all shadow-2xs"
                           required>
                </div>
                <p class="mt-1 text-[11px] text-slate-500">Hanya menerima format angka (10 s.d. 13 digit numerik).</p>
                @error('nomor_hp')
                    <p class="mt-1.5 text-xs text-rose-600 font-semibold flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- 4 & 5. Semester Saat Ini & IPK Terakhir (Grid 2 Kolom) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                
                <!-- 4. Reusable Dropdown: Semester Saat Ini -->
                <div>
                    <div class="flex items-center justify-between h-7 mb-2">
                        <label for="trigger-semester" class="text-xs font-bold uppercase tracking-wider text-slate-700">
                            4. Semester Saat Ini <span class="text-rose-500">*</span>
                        </label>
                        <span class="inline-flex items-center text-[10px] font-mono font-bold uppercase px-2 py-0.5 rounded bg-slate-100 text-slate-600 border border-slate-200">
                            S1 Reguler
                        </span>
                    </div>
                    <x-custom-dropdown 
                        name="semester" 
                        id="semester" 
                        label="" 
                        placeholder="Pilih Semester (1 - 8)" 
                        subtitle="Jenjang S1 Reguler (1 - 8)"
                        :required="true"
                        :options="$semesterOptions ?? []"
                        :value="old('semester')"
                        :columns="4"
                    />
                    <p class="mt-2 text-[11px] text-slate-500">Pilihan semester aktif jenjang S1 (semester 1 s.d. 8).</p>
                </div>

                <!-- 5. Input: Nilai IPK Terakhir (Readonly / Otomatis Sistem SIAKAD) -->
                <div>
                    <div class="flex items-center justify-between h-7 mb-2">
                        <label for="ipk_display" class="text-xs font-bold uppercase tracking-wider text-slate-700 shrink-0">
                            5. IPK Terakhir
                        </label>
                        <span id="ipk-status-indicator" class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-0.5 rounded-md bg-slate-100 text-slate-500 border border-slate-200 shrink-0">
                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Menunggu Data Mahasiswa</span>
                        </span>
                    </div>

                    <!-- Hidden input to submit the actual validated IPK value -->
                    <input type="hidden" name="ipk" id="ipk_value" value="{{ old('ipk', $simulatedIpk ?? '3.40') }}" data-server-ipk="{{ old('ipk', $simulatedIpk ?? '3.40') }}">

                    <div class="relative h-[58px]">
                        <input type="text" 
                               id="ipk_display" 
                               value="{{ !empty(old('nama')) && !empty(old('semester')) ? old('ipk', $simulatedIpk ?? '3.40') : '' }}" 
                               placeholder="Menunggu input Nama &amp; Semester..." 
                               readonly
                               class="w-full h-[58px] px-4 rounded-xl border border-slate-300 bg-slate-100 font-mono text-slate-500 text-sm cursor-not-allowed select-none transition-all shadow-2xs focus:outline-none"
                               aria-describedby="ipk-help">
                        
                        <!-- Overlay Animasi Titik Saat Sinkronisasi -->
                        <div id="ipk-loading-overlay" class="hidden absolute inset-0 flex items-center justify-between px-4 bg-slate-100/95 rounded-xl border border-slate-300 pointer-events-none transition-opacity duration-200">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-slate-700">Sinkronisasi SIAKAD</span>
                                <span class="inline-flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-700 animate-bounce"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-700 animate-bounce [animation-delay:0.15s]"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-700 animate-bounce [animation-delay:0.3s]"></span>
                                </span>
                            </div>
                            <span class="text-[10px] font-mono font-bold uppercase tracking-wider text-blue-800 bg-blue-100 px-2 py-0.5 rounded border border-blue-200">
                                SIAKAD
                            </span>
                        </div>
                    </div>

                    <p id="ipk-help" class="mt-2 text-[11px] text-slate-500">
                        Sinkronisasi otomatis SIAKAD setelah Nama &amp; Semester terisi.
                    </p>
                    @error('ipk')
                        <p class="mt-1.5 text-xs text-rose-600 font-semibold flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>

            <!-- 6. Reusable Dropdown: Pilihan Beasiswa (Kondisional: Disabled jika IPK < 3.00, Auto-Focus jika >= 3.00) -->
            <div id="wrapper-pilihan-beasiswa" class="transition-all duration-200">
                <x-custom-dropdown 
                    name="pilihan_beasiswa" 
                    id="pilihan_beasiswa" 
                    label="6. Pilihan Beasiswa" 
                    placeholder="-- Pilih Program Beasiswa --" 
                    subtitle="Pilih skema beasiswa yang sesuai"
                    :required="true"
                    :options="$beasiswaOptions ?? []"
                    :value="old('pilihan_beasiswa', $selectedBeasiswa)"
                    :columns="1"
                />
                <p class="mt-1 text-[11px] text-slate-500">Pilih salah satu program beasiswa yang sesuai dengan kualifikasi studi Anda.</p>
            </div>

            <!-- 7. File Input: Upload Berkas Syarat (Kondisional: Disabled jika IPK < 3.00) -->
            <div id="wrapper-berkas" class="transition-all duration-200">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    7. Upload Berkas Syarat (PDF / JPG / ZIP) <span class="text-rose-500">*</span>
                </label>

                <!-- Hidden file input for native submission -->
                <input id="berkas" 
                       name="berkas" 
                       type="file" 
                       accept=".pdf,.jpg,.jpeg,.png,.zip" 
                       class="sr-only"
                       required>

                <!-- State 1: Dropzone Box -->
                <div id="file-dropzone" 
                     class="group relative flex flex-col items-center justify-center p-8 border-2 border-slate-300 border-dashed rounded-2xl hover:border-blue-600 hover:bg-blue-50/40 transition-all bg-slate-50/60 cursor-pointer text-center">
                    
                    <div class="w-12 h-12 rounded-xl bg-white text-blue-700 border border-slate-200 group-hover:scale-105 group-hover:bg-blue-700 group-hover:text-white flex items-center justify-center mb-3 transition-all shadow-xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                    </div>

                    <p class="text-xs sm:text-sm font-bold text-slate-800 group-hover:text-blue-700 transition-colors">
                        Klik area ini untuk memilih berkas persyaratan
                    </p>
                    <p class="text-[11px] text-slate-500 mt-0.5">
                        atau drag &amp; drop file berkas langsung ke dalam kotak ini
                    </p>
                    
                    <div class="mt-3.5 flex flex-wrap items-center justify-center gap-1.5">
                        <span class="px-2.5 py-0.5 rounded-md bg-white border border-slate-200 text-[10px] font-mono font-bold text-slate-700">PDF</span>
                        <span class="px-2.5 py-0.5 rounded-md bg-white border border-slate-200 text-[10px] font-mono font-bold text-slate-700">JPG / PNG</span>
                        <span class="px-2.5 py-0.5 rounded-md bg-white border border-slate-200 text-[10px] font-mono font-bold text-slate-700">ZIP</span>
                        <span class="text-slate-300 text-xs">•</span>
                        <span class="text-[11px] font-semibold text-slate-600">Maksimal 2 MB</span>
                    </div>
                </div>

                <!-- State 2: Selected File Card -->
                <div id="file-card-preview" class="hidden transition-all p-4 rounded-xl bg-white border-2 border-blue-200 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-3.5 min-w-0">
                            <div id="file-preview-icon" class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 overflow-hidden border border-slate-200 bg-slate-50">
                                <!-- Dynamic Icon -->
                            </div>

                            <div class="min-w-0">
                                <div class="flex items-center gap-2">
                                    <h5 id="file-card-name" class="font-bold text-slate-900 text-xs sm:text-sm truncate max-w-[220px] sm:max-w-xs">
                                        nama_file.pdf
                                    </h5>
                                    <span id="file-card-ext-badge" class="px-2 py-0.5 rounded text-[10px] font-mono font-bold uppercase tracking-wide bg-blue-50 text-blue-800 border border-blue-200">
                                        PDF
                                    </span>
                                </div>
                                <div class="flex items-center gap-2 text-xs text-slate-500 mt-0.5">
                                    <span id="file-card-size">0.00 MB</span>
                                    <span>•</span>
                                    <span class="inline-flex items-center gap-1 text-emerald-700 font-bold">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Siap diunggah
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0 self-end sm:self-center">
                            <button type="button" 
                                    id="btn-ganti-file" 
                                    class="px-3 py-1.5 rounded-lg text-xs font-bold text-slate-800 bg-white hover:bg-slate-100 border border-slate-300 transition-all flex items-center gap-1.5 cursor-pointer">
                                <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                <span>Ganti Berkas</span>
                            </button>
                            <button type="button" 
                                    id="btn-hapus-file" 
                                    title="Hapus berkas terpilih"
                                    class="p-2 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-all cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                @error('berkas')
                    <p class="mt-1.5 text-xs text-rose-600 font-semibold flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- 8. Tombol Aksi: Daftar (Submit) & Batal (Reset) -->
            <div class="pt-6 border-t border-slate-200 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-3.5">
                
                <!-- Tombol Batal -->
                <button type="button" 
                        id="btn-batal" 
                        class="w-full sm:w-auto px-6 py-3 rounded-xl border border-slate-300 bg-white hover:bg-slate-100 text-slate-700 font-bold text-xs transition-all shadow-xs text-center cursor-pointer">
                    Batal
                </button>

                <!-- Tombol Daftar (Specialtive Bright Blue Style) -->
                <button type="submit" 
                        id="btn-daftar" 
                        data-slot="button" 
                        data-variant="specialtive" 
                        data-size="default" 
                        class="group/button w-full sm:w-auto inline-flex shrink-0 items-center justify-center border-transparent font-medium whitespace-nowrap transition-all outline-none select-none active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none disabled:opacity-50 disabled:grayscale [&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4 border-0 bg-gradient-to-b from-[#38BDF8] via-[#2563EB] to-[#1D4ED8] text-white ring-1 ring-inset ring-white/20 shadow-[inset_0_1px_0_rgba(255,255,255,0.35),0_8px_16px_-4px_rgba(29,78,216,0.5)] bg-clip-padding hover:from-[#60A5FA] hover:via-[#3B82F6] hover:to-[#2563EB] active:translate-y-px active:bg-gradient-to-b active:from-[#2563EB] active:via-[#1D4ED8] active:to-[#1E3A8A] active:shadow-[inset_0_1px_0_rgba(255,255,255,0.15)] cursor-pointer gap-2 px-6 h-11 rounded-[10px] text-[15px]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Daftar Beasiswa</span>
                </button>
            </div>

        </form>
    </div>

</div>

@push('scripts')
<script>
/**
 * Modul Reusable Dropdown Manager & Logika Form Pendaftaran
 * Author: Sena
 * Tanggal: 29 Oktober 2026
 * Versi: 1.0.0
 * Unit Kompetensi: J.620100.005.02, J.620100.016.01, J.620100.017.02, J.620100.019.02
 */
document.addEventListener('DOMContentLoaded', function () {
    // Deklarasi Konstanta IPK Standar BNSP (FR.IA.02 Butir 5)
    const IPK_TINGGI = 3.40;
    const IPK_RENDAH = 2.90;

    // Registry Reusable Dropdown Components
    window.academicDropdowns = {};

    /**
     * Inisialisasi Komponen Reusable Dropdown
     */
    function initCustomDropdown(id) {
        const select = document.getElementById(id);
        const trigger = document.getElementById('trigger-' + id);
        const menu = document.getElementById('menu-' + id);
        const chevron = document.getElementById('chevron-' + id);
        const labelTitle = document.getElementById('label-title-' + id);
        const labelSubtitle = document.getElementById('label-subtitle-' + id);
        const badge = document.getElementById('badge-' + id);
        const iconBox = document.getElementById('icon-box-' + id);
        const container = document.getElementById('container-' + id);
        const options = menu ? menu.querySelectorAll('.custom-dropdown-option') : [];

        if (!trigger || !menu) return null;

        const dropdown = {
            id,
            select,
            trigger,
            menu,
            isOpen: false,

            open() {
                if (trigger.disabled) return;
                // Tutup dropdown lain yang sedang terbuka
                Object.values(window.academicDropdowns).forEach(d => {
                    if (d.id !== id) d.close();
                });
                menu.classList.remove('hidden');
                trigger.setAttribute('aria-expanded', 'true');
                if (chevron) chevron.classList.add('rotate-180');
                this.isOpen = true;
            },

            close() {
                menu.classList.add('hidden');
                trigger.setAttribute('aria-expanded', 'false');
                if (chevron) chevron.classList.remove('rotate-180');
                this.isOpen = false;
            },

            toggle() {
                if (this.isOpen) this.close();
                else this.open();
            },

            select(val, title, subtitle, badgeText, iconType) {
                if (select) {
                    select.value = val;
                    select.dispatchEvent(new Event('change', { bubbles: true }));
                }

                if (labelTitle && title) labelTitle.textContent = title;
                if (labelSubtitle && subtitle) labelSubtitle.textContent = subtitle;

                if (badge) {
                    if (badgeText) {
                        badge.textContent = badgeText;
                        badge.classList.remove('hidden');
                        badge.classList.add('inline-block');
                    } else {
                        badge.classList.add('hidden');
                    }
                }

                if (iconBox) {
                    iconBox.className = 'w-8 h-8 rounded-lg bg-blue-100 text-blue-800 flex items-center justify-center shrink-0 font-mono font-bold text-xs transition-colors';
                    if (iconType === 'code') {
                        iconBox.innerHTML = '<svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>';
                    } else if (iconType === 'briefcase') {
                        iconBox.innerHTML = '<svg class="w-4 h-4 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>';
                    } else if (!isNaN(val) && val !== '') {
                        iconBox.innerHTML = `<span>${val}</span>`;
                    }
                }

                // Update checkmark visual
                options.forEach(opt => {
                    const check = opt.querySelector('.option-check-icon');
                    if (opt.dataset.value === String(val)) {
                        opt.classList.add('border-blue-200', 'bg-blue-50/50');
                        opt.classList.remove('border-transparent');
                        if (check) check.classList.remove('opacity-0');
                    } else {
                        opt.classList.remove('border-blue-200', 'bg-blue-50/50');
                        opt.classList.add('border-transparent');
                        if (check) check.classList.add('opacity-0');
                    }
                });

                this.close();
            },

            setDisabled(disabled) {
                trigger.disabled = disabled;
                if (disabled) {
                    this.close();
                    trigger.classList.add('bg-slate-100', 'text-slate-400', 'cursor-not-allowed', 'border-slate-200');
                    trigger.classList.remove('bg-white', 'hover:border-blue-500');
                } else {
                    trigger.classList.remove('bg-slate-100', 'text-slate-400', 'cursor-not-allowed', 'border-slate-200');
                    trigger.classList.add('bg-white', 'hover:border-blue-500');
                }
            },

            focus() {
                if (!trigger.disabled) {
                    trigger.focus();
                }
            }
        };

        trigger.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            dropdown.toggle();
        });

        options.forEach(opt => {
            opt.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                dropdown.select(
                    this.dataset.value,
                    this.dataset.title,
                    this.dataset.subtitle,
                    this.dataset.badge,
                    this.dataset.icon
                );
            });
        });

        window.academicDropdowns[id] = dropdown;
        return dropdown;
    }

    // Inisialisasi Reusable Dropdowns
    const semesterDropdown = initCustomDropdown('semester');
    const beasiswaDropdown = initCustomDropdown('pilihan_beasiswa');

    // Tutup dropdown saat klik di luar
    document.addEventListener('click', function (e) {
        Object.values(window.academicDropdowns).forEach(d => {
            const container = document.getElementById('container-' + d.id);
            if (container && !container.contains(e.target)) {
                d.close();
            }
        });
    });

    // Tutup dropdown dengan tombol Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            Object.values(window.academicDropdowns).forEach(d => d.close());
        }
    });

    // ACCORDION: Toggle Panel Simulasi IPK (Awal Tertutup, Klik Header untuk Buka)
    (function () {
        const toggleBtn = document.getElementById('btn-toggle-simulasi');
        const panelContent = document.getElementById('panel-simulasi-content');
        const chevronSimulasi = document.getElementById('chevron-simulasi');
        const labelToggle = document.getElementById('label-toggle-simulasi');

        if (!toggleBtn || !panelContent) return;

        toggleBtn.addEventListener('click', function () {
            const isOpen = !panelContent.classList.contains('hidden');
            if (isOpen) {
                panelContent.classList.add('hidden');
                chevronSimulasi && chevronSimulasi.classList.remove('rotate-180');
                if (labelToggle) labelToggle.textContent = 'Buka Drop';
                toggleBtn.setAttribute('aria-expanded', 'false');
            } else {
                panelContent.classList.remove('hidden');
                chevronSimulasi && chevronSimulasi.classList.add('rotate-180');
                if (labelToggle) labelToggle.textContent = 'Tutup';
                toggleBtn.setAttribute('aria-expanded', 'true');
            }
        });
    })();

    // Referensi Elemen DOM Lainnya
    const namaInput = document.getElementById('nama');
    const semesterSelect = document.getElementById('semester');
    const ipkValueInput = document.getElementById('ipk_value');
    const ipkDisplayInput = document.getElementById('ipk_display');
    const ipkStatusIndicator = document.getElementById('ipk-status-indicator');
    const ipkLoadingOverlay = document.getElementById('ipk-loading-overlay');
    const ipkWarningBox = document.getElementById('ipk-warning-box');
    const ipkWarningText = document.getElementById('ipk-warning-text');
    
    const btnSimulatePass = document.getElementById('btn-simulate-pass');
    const btnSimulateFail = document.getElementById('btn-simulate-fail');

    const berkasInput = document.getElementById('berkas');
    const fileDropzone = document.getElementById('file-dropzone');
    const fileCardPreview = document.getElementById('file-card-preview');
    const filePreviewIcon = document.getElementById('file-preview-icon');
    const fileCardName = document.getElementById('file-card-name');
    const fileCardExtBadge = document.getElementById('file-card-ext-badge');
    const fileCardSize = document.getElementById('file-card-size');
    const btnGantiFile = document.getElementById('btn-ganti-file');
    const btnHapusFile = document.getElementById('btn-hapus-file');
    const btnDaftar = document.getElementById('btn-daftar');
    const btnBatal = document.getElementById('btn-batal');
    const nomorHpInput = document.getElementById('nomor_hp');
    const form = document.getElementById('form-pendaftaran-beasiswa');

    const wrapperPilihan = document.getElementById('wrapper-pilihan-beasiswa');
    const wrapperBerkas = document.getElementById('wrapper-berkas');
    let checkTimeout = null;

    // Nilai IPK aktif dari server (hasil acak realistis) atau konstanta fallback
    let activeIpk = parseFloat(ipkValueInput.dataset.serverIpk || ipkValueInput.value) || IPK_TINGGI;
    let isIpkSynced = false;

    /**
     * Memeriksa apakah data penting (Nama Lengkap dan Semester) sudah diisi oleh mahasiswa
     * @returns {boolean}
     */
    function isImportantDataFilled() {
        const nama = namaInput ? namaInput.value.trim() : '';
        const semester = semesterSelect ? semesterSelect.value.trim() : '';
        return nama.length >= 2 && semester !== '';
    }

    /**
     * Mengembalikan tampilan IPK ke status belum tersinkronisasi (menunggu input data penting)
     */
    function resetToWaitingState() {
        if (checkTimeout) {
            clearTimeout(checkTimeout);
        }
        isIpkSynced = false;

        if (ipkLoadingOverlay) {
            ipkLoadingOverlay.classList.add('hidden');
        }

        if (ipkDisplayInput) {
            ipkDisplayInput.value = '';
            ipkDisplayInput.placeholder = 'Menunggu input Nama & Semester...';
            ipkDisplayInput.className = 'w-full h-[58px] px-4 rounded-xl border border-slate-300 bg-slate-100 font-mono text-slate-500 text-sm cursor-not-allowed select-none transition-all shadow-2xs';
        }

        if (ipkStatusIndicator) {
            ipkStatusIndicator.className = 'inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-0.5 rounded-md bg-slate-100 text-slate-500 border border-slate-200 shrink-0';
            ipkStatusIndicator.innerHTML = `
                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Menunggu Data Mahasiswa</span>
            `;
        }


        // Kunci pilihan beasiswa, upload berkas, dan tombol daftar sebelum IPK tersinkronisasi
        if (beasiswaDropdown) beasiswaDropdown.setDisabled(true);
        if (berkasInput) berkasInput.disabled = true;
        if (btnDaftar) btnDaftar.disabled = true;

        if (wrapperPilihan) wrapperPilihan.classList.add('opacity-50', 'pointer-events-none');
        if (wrapperBerkas) wrapperBerkas.classList.add('opacity-50', 'pointer-events-none');
    }

    /**
     * Memeriksa dan mengeksekusi logika kelayakan IPK
     * @param {number} ipk Nilai IPK mahasiswa
     * @param {boolean} shouldFocus Apakah auto-focus ke Pilihan Beasiswa saat Lolos
     * @param {number} delayMs Durasi animasi sinkronisasi (ms)
     */
    function checkAndSetIPK(ipk, shouldFocus = false, delayMs = 350) {
        if (checkTimeout) {
            clearTimeout(checkTimeout);
        }

        if (ipkLoadingOverlay) {
            ipkLoadingOverlay.classList.remove('hidden');
        }

        // Kunci sementara saat proses sinkronisasi
        if (beasiswaDropdown) beasiswaDropdown.setDisabled(true);
        if (berkasInput) berkasInput.disabled = true;
        if (btnDaftar) btnDaftar.disabled = true;

        checkTimeout = setTimeout(() => {
            const formattedIpk = Number(ipk).toFixed(2);
            activeIpk = Number(ipk);
            ipkValueInput.value = formattedIpk;
            ipkDisplayInput.value = formattedIpk;
            isIpkSynced = true;

            if (ipkLoadingOverlay) {
                ipkLoadingOverlay.classList.add('hidden');
            }

            // Update status visual tombol switcher simulasi
            if (btnSimulatePass && btnSimulateFail) {
                if (ipk >= 3.00) {
                    btnSimulatePass.className = 'w-full px-4 py-2.5 rounded-xl text-xs font-bold transition-all shadow-xs flex items-center justify-center gap-2 cursor-pointer bg-emerald-600 text-white border-2 border-emerald-600 hover:bg-emerald-700 ring-2 ring-emerald-300';
                    btnSimulateFail.className = 'w-full px-4 py-2.5 rounded-xl text-xs font-bold transition-all shadow-xs flex items-center justify-center gap-2 cursor-pointer bg-white text-rose-800 border-2 border-rose-300 hover:bg-rose-50';
                } else {
                    btnSimulateFail.className = 'w-full px-4 py-2.5 rounded-xl text-xs font-bold transition-all shadow-xs flex items-center justify-center gap-2 cursor-pointer bg-rose-600 text-white border-2 border-rose-600 ring-2 ring-rose-300';
                    btnSimulatePass.className = 'w-full px-4 py-2.5 rounded-xl text-xs font-bold transition-all shadow-xs flex items-center justify-center gap-2 cursor-pointer bg-white text-emerald-800 border-2 border-emerald-300 hover:bg-emerald-50';
                }
            }

            if (ipk < 3.00) {
                // LOGIKA 6 BNSP: IPK < 3.00 -> Pilihan Beasiswa, Berkas, dan Tombol Simpan NON-AKTIF
                if (beasiswaDropdown) beasiswaDropdown.setDisabled(true);
                if (berkasInput) berkasInput.disabled = true;
                if (btnDaftar) btnDaftar.disabled = true;

                if (wrapperPilihan) wrapperPilihan.classList.add('opacity-50', 'pointer-events-none');
                if (wrapperBerkas) wrapperBerkas.classList.add('opacity-50', 'pointer-events-none');

                if (ipkStatusIndicator) {
                    ipkStatusIndicator.className = 'inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-0.5 rounded-md bg-rose-50 text-rose-800 border border-rose-300 shrink-0';
                    ipkStatusIndicator.innerHTML = `
                        <svg class="w-3.5 h-3.5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <span>Tidak Lolos (&lt; 3.00)</span>
                    `;
                }

                ipkDisplayInput.className = 'w-full h-[58px] px-4 rounded-xl border-2 border-rose-300 bg-rose-50 text-rose-950 font-mono font-black text-base cursor-not-allowed select-none transition-all shadow-2xs';

                if (ipkWarningText) {
                    ipkWarningText.textContent = `Maaf, IPK Anda di bawah 3.00 (Nilai saat ini: ${formattedIpk}), Anda tidak memenuhi syarat untuk mendaftar beasiswa.`;
                }
                if (ipkWarningBox) ipkWarningBox.classList.remove('hidden');

            } else {
                // LOGIKA 7 BNSP: IPK >= 3.00 -> Elemen Aktif & Autofocus ke Pilihan Beasiswa
                if (beasiswaDropdown) beasiswaDropdown.setDisabled(false);
                if (berkasInput) berkasInput.disabled = false;
                if (btnDaftar) btnDaftar.disabled = false;

                if (wrapperPilihan) wrapperPilihan.classList.remove('opacity-50', 'pointer-events-none');
                if (wrapperBerkas) wrapperBerkas.classList.remove('opacity-50', 'pointer-events-none');

                if (ipkStatusIndicator) {
                    ipkStatusIndicator.className = 'inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-0.5 rounded-md bg-emerald-50 text-emerald-800 border border-emerald-300 shrink-0';
                    ipkStatusIndicator.innerHTML = `
                        <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Lolos (&ge; 3.00)</span>
                    `;
                }

                ipkDisplayInput.className = 'w-full h-[58px] px-4 rounded-xl border border-emerald-300 bg-emerald-50/60 text-emerald-950 font-mono font-black text-base cursor-not-allowed select-none transition-all shadow-2xs';

                if (ipkWarningBox) ipkWarningBox.classList.add('hidden');

                // Auto-Focus ke Dropdown Pilihan Beasiswa
                if (shouldFocus && beasiswaDropdown) {
                    setTimeout(() => {
                        beasiswaDropdown.focus();
                    }, 80);
                }
            }
        }, delayMs);
    }

    /**
     * Mengevaluasi isian form dan mensinkronkan IPK bila data penting sudah terisi
     * @param {string} triggerSource Sumber pemicu evaluasi ('nama' atau 'semester')
     */
    function evaluateFormAndSyncIPK(triggerSource = '') {
        if (isImportantDataFilled()) {
            if (!isIpkSynced || triggerSource === 'semester') {
                checkAndSetIPK(activeIpk, activeIpk >= 3.00, 350);
            }
        } else {
            resetToWaitingState();
        }
    }

    // Event Listener Input Nama: Cek kelengkapan data penting
    if (namaInput) {
        namaInput.addEventListener('input', function () {
            evaluateFormAndSyncIPK('nama');
        });
        namaInput.addEventListener('change', function () {
            evaluateFormAndSyncIPK('nama');
        });
    }

    // Event Listener Semester: Cek kelengkapan data & picu sinkronisasi nilai IPK
    if (semesterSelect) {
        semesterSelect.addEventListener('change', function () {
            evaluateFormAndSyncIPK('semester');
        });
    }

    // Inisialisasi awal saat halaman dimuat:
    // Jika data penting (nama & semester) sudah terisi (misal setelah redirect error validasi),
    // langsung tampilkan nilai IPK. Jika belum, tampilkan status menunggu input data.
    if (isImportantDataFilled()) {
        checkAndSetIPK(activeIpk, activeIpk >= 3.00, 100);
    } else {
        resetToWaitingState();
    }

    // Event Listener Switcher Konstanta IPK (Mode Demonstrasi Asesor BNSP FR.IA.02)
    if (btnSimulatePass) {
        btnSimulatePass.addEventListener('click', function () {
            // Jika nama atau semester belum terisi, lengkapi otomatis agar asesor mudah menguji
            if (namaInput && namaInput.value.trim().length === 0) {
                namaInput.value = 'Bima Gilang Ramadhan';
            }
            if (semesterSelect && semesterSelect.value === '' && semesterDropdown) {
                semesterDropdown.select('4', 'Semester 4', 'Tingkat 2 (Tahun ke-2)', '', '');
            }
            activeIpk = IPK_TINGGI;
            checkAndSetIPK(IPK_TINGGI, true, 80);
        });
    }

    if (btnSimulateFail) {
        btnSimulateFail.addEventListener('click', function () {
            // Jika nama atau semester belum terisi, lengkapi otomatis agar asesor mudah menguji
            if (namaInput && namaInput.value.trim().length === 0) {
                namaInput.value = 'Bima Gilang Ramadhan';
            }
            if (semesterSelect && semesterSelect.value === '' && semesterDropdown) {
                semesterDropdown.select('4', 'Semester 4', 'Tingkat 2 (Tahun ke-2)', '', '');
            }
            activeIpk = IPK_RENDAH;
            checkAndSetIPK(IPK_RENDAH, false, 80);
        });
    }

    // LOGIKA 3 BNSP: Sanitasi Nomor HP Hanya Angka
    if (nomorHpInput) {
        nomorHpInput.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }

    // Logika Upload Berkas & Preview Card
    function handleFileSelected(file) {
        if (!file) {
            clearFileSelection();
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            alert('Peringatan: Ukuran file melebihi batas maksimal 2MB!');
            clearFileSelection();
            return;
        }

        const ext = file.name.split('.').pop().toLowerCase();
        fileCardName.textContent = file.name;
        fileCardExtBadge.textContent = ext.toUpperCase();

        if (file.size >= 1024 * 1024) {
            fileCardSize.textContent = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
        } else {
            fileCardSize.textContent = (file.size / 1024).toFixed(1) + ' KB';
        }

        if (['jpg', 'jpeg', 'png'].includes(ext)) {
            fileCardExtBadge.className = 'px-2 py-0.5 rounded text-[10px] font-mono font-bold uppercase bg-blue-50 text-blue-800 border border-blue-200';
            const reader = new FileReader();
            reader.onload = function (e) {
                filePreviewIcon.className = 'w-12 h-12 rounded-xl flex items-center justify-center shrink-0 overflow-hidden border border-slate-200 bg-slate-50';
                filePreviewIcon.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-full h-full object-cover">`;
            };
            reader.readAsDataURL(file);
        } else if (ext === 'pdf') {
            fileCardExtBadge.className = 'px-2 py-0.5 rounded text-[10px] font-mono font-bold uppercase bg-rose-50 text-rose-800 border border-rose-200';
            filePreviewIcon.className = 'w-12 h-12 rounded-xl flex items-center justify-center shrink-0 overflow-hidden border border-rose-200 bg-rose-50 text-rose-700 font-bold text-xs';
            filePreviewIcon.innerHTML = `PDF`;
        } else if (ext === 'zip') {
            fileCardExtBadge.className = 'px-2 py-0.5 rounded text-[10px] font-mono font-bold uppercase bg-amber-50 text-amber-800 border border-amber-200';
            filePreviewIcon.className = 'w-12 h-12 rounded-xl flex items-center justify-center shrink-0 overflow-hidden border border-amber-200 bg-amber-50 text-amber-700 font-bold text-xs';
            filePreviewIcon.innerHTML = `ZIP`;
        } else {
            fileCardExtBadge.className = 'px-2 py-0.5 rounded text-[10px] font-mono font-bold uppercase bg-slate-100 text-slate-800 border border-slate-200';
            filePreviewIcon.className = 'w-12 h-12 rounded-xl flex items-center justify-center shrink-0 overflow-hidden border border-slate-200 bg-slate-50 text-slate-700 font-bold text-xs';
            filePreviewIcon.innerHTML = `DOC`;
        }

        fileDropzone.classList.add('hidden');
        fileCardPreview.classList.remove('hidden');
    }

    function clearFileSelection() {
        berkasInput.value = '';
        fileCardPreview.classList.add('hidden');
        fileDropzone.classList.remove('hidden');
    }

    if (fileDropzone) {
        fileDropzone.addEventListener('click', function () {
            if (berkasInput.disabled) return;
            berkasInput.click();
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            fileDropzone.addEventListener(eventName, function (e) {
                e.preventDefault();
                e.stopPropagation();
                if (!berkasInput.disabled) {
                    fileDropzone.classList.add('border-blue-700', 'bg-blue-50/50');
                }
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            fileDropzone.addEventListener(eventName, function (e) {
                e.preventDefault();
                e.stopPropagation();
                fileDropzone.classList.remove('border-blue-700', 'bg-blue-50/50');
            });
        });

        fileDropzone.addEventListener('drop', function (e) {
            if (berkasInput.disabled) return;
            const dt = e.dataTransfer;
            if (dt && dt.files && dt.files.length > 0) {
                berkasInput.files = dt.files;
                handleFileSelected(dt.files[0]);
            }
        });
    }

    if (btnGantiFile) {
        btnGantiFile.addEventListener('click', function (e) {
            e.preventDefault();
            if (berkasInput.disabled) return;
            berkasInput.click();
        });
    }

    if (btnHapusFile) {
        btnHapusFile.addEventListener('click', function (e) {
            e.preventDefault();
            clearFileSelection();
        });
    }

    berkasInput.addEventListener('change', function () {
        if (this.files && this.files.length > 0) {
            handleFileSelected(this.files[0]);
        } else {
            clearFileSelection();
        }
    });

    // Tombol Batal
    if (btnBatal) {
        btnBatal.addEventListener('click', function () {
            if (confirm('Apakah Anda yakin ingin membatalkan pengisian formulir?')) {
                form.reset();
                clearFileSelection();
                resetToWaitingState();
                window.location.href = "{{ route('beasiswa.index') }}";
            }
        });
    }
});
</script>
@endpush
@endsection
