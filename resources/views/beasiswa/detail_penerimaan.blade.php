@extends('layouts.app')

@section('title', 'Detail Status Penerimaan Beasiswa - ' . $registration->nama)

@section('content')
<!--
    View: beasiswa.detail_penerimaan
    Deskripsi: Halaman detail status pengajuan beasiswa mahasiswa (Read-Only Publik).
               Menampilkan status verifikasi ajuan secara transparan beserta rangkuman
               data identitas, akademik, program beasiswa yang dipilih, dan akses unduh berkas.
    Author: Sena
    Tanggal: 29 Oktober 2026
    Versi: 1.0.0
    Unit Kompetensi: J.620100.005.02, J.620100.010.01
-->

<div class="max-w-3xl mx-auto py-6 sm:py-10 space-y-8">

    <!-- Breadcrumb Navigasi -->
    <nav class="flex items-center gap-2 text-xs text-slate-500" aria-label="Breadcrumb">
        <a href="{{ route('beasiswa.home') }}" class="hover:text-blue-700 transition-colors">Beranda</a>
        <span>/</span>
        <a href="{{ route('beasiswa.hasil') }}" class="hover:text-blue-700 transition-colors">Hasil &amp; Rekapitulasi</a>
        <span>/</span>
        <span class="text-slate-800 font-bold">Detail Penerimaan</span>
    </nav>

    <!-- Header Judul -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 pb-5">
        <div>
            <span class="text-[11px] font-bold uppercase tracking-wider text-blue-700">LEMBAR STATUS RESMI</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 mt-1">
                Detail Penerimaan Beasiswa
            </h2>
            <p class="text-xs text-slate-500 mt-0.5">
                Nomor Registrasi Sistem: <span class="font-mono font-bold text-slate-700">#REG-{{ str_pad($registration->id, 5, '0', STR_PAD_LEFT) }}</span>
            </p>
        </div>

        <a href="{{ route('beasiswa.hasil') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-all self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Cari Nama Lain</span>
        </a>
    </div>

    <!-- Status Ajuan Banner (Modern Minimalist Sesuai Standar BNSP) -->
    @if($registration->status_ajuan === 'Terverifikasi')
        <div class="p-5 sm:p-6 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-950 flex items-start gap-4 shadow-xs">
            <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-800">Status Ajuan:</span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-xs font-semibold bg-emerald-600 text-white shadow-2xs">
                        <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                        <span>Terverifikasi</span>
                    </span>
                </div>
                <h3 class="text-base font-bold text-emerald-900">Selamat! Pengajuan Beasiswa Anda Telah Diterima</h3>
                <p class="text-xs text-emerald-800/90 leading-relaxed">
                    Berkas administrasi dan kelayakan IPK akademik Anda telah memenuhi standar seleksi. Silakan pantau pengumuman tahapan wawancara pada akun email terdaftar.
                </p>
            </div>
        </div>
    @elseif($registration->status_ajuan === 'Ditolak')
        <div class="p-5 sm:p-6 rounded-2xl bg-rose-50 border border-rose-200 text-rose-950 flex items-start gap-4 shadow-xs">
            <div class="w-10 h-10 rounded-xl bg-rose-600 text-white flex items-center justify-center shrink-0 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-rose-800">Status Ajuan:</span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-xs font-semibold bg-rose-600 text-white shadow-2xs">
                        <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                        <span>Ditolak</span>
                    </span>
                </div>
                <h3 class="text-base font-bold text-rose-900">Pengajuan Beasiswa Belum Memenuhi Persyaratan</h3>
                <p class="text-xs text-rose-800/90 leading-relaxed">
                    Mohon maaf, berkas atau kriteria akademik Anda belum memenuhi persyaratan minimum seleksi program beasiswa ini. Anda dapat mencoba kembali pada gelombang penerimaan berikutnya.
                </p>
            </div>
        </div>
    @else
        <!-- Default Status: Pending (Tenang & Rapi) -->
        <div class="p-5 sm:p-6 rounded-2xl bg-amber-50/80 border border-amber-200 text-amber-950 flex items-start gap-4 shadow-xs">
            <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-amber-800">Status Ajuan:</span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-xs font-semibold bg-amber-500 text-white shadow-2xs">
                        <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                        <span>Pending</span>
                    </span>
                </div>
                <h3 class="text-base font-bold text-amber-900">Pengajuan Berhasil Terkirim &amp; Dalam Antrean Review</h3>
                <p class="text-xs text-amber-800/90 leading-relaxed">
                    Data pendaftaran dan berkas lampiran Anda telah aman tersimpan dalam basis data sistem. Tim verifikator beasiswa kampus sedang melakukan pemeriksaan kelayakan akademik.
                </p>
            </div>
        </div>
    @endif

    <!-- Kartu Rincian Data Lengkap Mahasiswa -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        
        <div class="p-5 bg-slate-50/70 border-b border-slate-200 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800">Rangkuman Formulir Pendaftaran</h4>
            </div>
            <span class="text-[11px] text-slate-400 font-mono">ID: {{ $registration->id }}</span>
        </div>

        <div class="divide-y divide-slate-100">
            
            <!-- 1. Nama Lengkap -->
            <div class="p-4 sm:p-5 grid grid-cols-1 sm:grid-cols-3 gap-2 items-center">
                <span class="text-xs font-semibold text-slate-500">1. Nama Lengkap Mahasiswa</span>
                <span class="sm:col-span-2 text-sm font-extrabold text-slate-900">{{ $registration->nama }}</span>
            </div>

            <!-- 2. Alamat Email -->
            <div class="p-4 sm:p-5 grid grid-cols-1 sm:grid-cols-3 gap-2 items-center">
                <span class="text-xs font-semibold text-slate-500">2. Alamat Email Kampus</span>
                <span class="sm:col-span-2 text-sm font-mono text-slate-800">{{ $registration->email }}</span>
            </div>

            <!-- 3. Nomor Handphone -->
            <div class="p-4 sm:p-5 grid grid-cols-1 sm:grid-cols-3 gap-2 items-center">
                <span class="text-xs font-semibold text-slate-500">3. Nomor Handphone / WhatsApp</span>
                <span class="sm:col-span-2 text-sm font-mono text-slate-800">{{ $registration->nomor_hp }}</span>
            </div>

            <!-- 4. Semester -->
            <div class="p-4 sm:p-5 grid grid-cols-1 sm:grid-cols-3 gap-2 items-center">
                <span class="text-xs font-semibold text-slate-500">4. Semester Saat Ini</span>
                <div class="sm:col-span-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                        Semester {{ $registration->semester }} (Jenjang S1 Reguler)
                    </span>
                </div>
            </div>

            <!-- 5. IPK Terakhir -->
            <div class="p-4 sm:p-5 grid grid-cols-1 sm:grid-cols-3 gap-2 items-center">
                <span class="text-xs font-semibold text-slate-500">5. Nilai IPK Terakhir</span>
                <div class="sm:col-span-2 flex items-center gap-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-black font-mono {{ $registration->ipk >= 3.00 ? 'bg-emerald-50 text-emerald-800 border border-emerald-300' : 'bg-rose-50 text-rose-800 border border-rose-300' }}">
                        {{ number_format($registration->ipk, 2) }}
                    </span>
                    <span class="text-xs text-slate-500 font-medium">
                        (Standar kelayakan minimum: &ge; 3.00)
                    </span>
                </div>
            </div>

            <!-- 6. Pilihan Beasiswa -->
            <div class="p-4 sm:p-5 grid grid-cols-1 sm:grid-cols-3 gap-2 items-center">
                <span class="text-xs font-semibold text-slate-500">6. Skema Program Beasiswa</span>
                <div class="sm:col-span-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                        {{ $registration->pilihan_beasiswa }}
                    </span>
                </div>
            </div>

            <!-- 7. Berkas Persyaratan -->
            <div class="p-4 sm:p-5 grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4 items-center">
                <span class="text-xs font-semibold text-slate-500">7. Berkas Persyaratan Syarat</span>
                <div class="sm:col-span-2">
                    @if($registration->berkas)
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-3 rounded-xl bg-slate-50 border border-slate-200">
                            <!-- Nama Berkas File -->
                            <div class="flex items-center gap-2 min-w-0">
                                <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span class="text-xs font-mono text-slate-700 truncate" title="{{ basename($registration->berkas) }}">
                                    {{ basename($registration->berkas) }}
                                </span>
                            </div>

                            <!-- Tombol Unduh & Preview Selalu Bersebelahan (Samping-sampingan) -->
                            <div class="flex items-center gap-2 shrink-0">
                                <a href="{{ route('beasiswa.berkas.download', $registration->id) }}" 
                                   data-slot="button" 
                                   data-variant="specialtive" 
                                   class="group/button inline-flex shrink-0 items-center justify-center border-transparent font-medium whitespace-nowrap transition-all outline-none select-none active:not-aria-[haspopup]:translate-y-px [&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-3.5 border-0 bg-gradient-to-b from-[#38BDF8] via-[#2563EB] to-[#1D4ED8] text-white ring-1 ring-inset ring-white/20 shadow-[inset_0_1px_0_rgba(255,255,255,0.35),0_6px_12px_-3px_rgba(29,78,216,0.5)] bg-clip-padding hover:from-[#60A5FA] hover:via-[#3B82F6] hover:to-[#2563EB] active:translate-y-px active:bg-gradient-to-b active:from-[#2563EB] active:via-[#1D4ED8] active:to-[#1E3A8A] active:shadow-[inset_0_1px_0_rgba(255,255,255,0.15)] cursor-pointer gap-1.5 px-3.5 h-8 rounded-[8px] text-xs">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    <span>Unduh Berkas</span>
                                </a>

                                <a href="{{ $registration->berkas_url }}" 
                                   target="_blank"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white text-slate-700 hover:bg-slate-100 border border-slate-200 text-xs font-bold transition-all shadow-2xs whitespace-nowrap">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <span>Preview</span>
                                </a>
                            </div>
                        </div>
                    @else
                        <span class="text-xs text-slate-400 italic">Tidak ada berkas yang diunggah.</span>
                    @endif
                </div>
            </div>

            <!-- 8. Tanggal Pendaftaran -->
            <div class="p-4 sm:p-5 grid grid-cols-1 sm:grid-cols-3 gap-2 items-center">
                <span class="text-xs font-semibold text-slate-500">8. Waktu Registrasi Masuk</span>
                <span class="sm:col-span-2 text-xs font-mono text-slate-700">
                    {{ $registration->created_at->format('d F Y, H:i:s') }} WIB
                </span>
            </div>

        </div>

    </div>

    <!-- Tombol Navigasi Bawah -->
    <div class="flex flex-wrap items-center justify-between gap-3 pt-4 border-t border-slate-200">
        <a href="{{ route('beasiswa.hasil') }}" 
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Kembali ke Pencarian</span>
        </a>

        <a href="{{ route('beasiswa.home') }}" 
           data-slot="button" 
           data-variant="specialtive" 
           class="group/button inline-flex shrink-0 items-center justify-center border-transparent font-medium whitespace-nowrap transition-all outline-none select-none active:not-aria-[haspopup]:translate-y-px [&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4 border-0 bg-gradient-to-b from-[#38BDF8] via-[#2563EB] to-[#1D4ED8] text-white ring-1 ring-inset ring-white/20 shadow-[inset_0_1px_0_rgba(255,255,255,0.35),0_8px_16px_-4px_rgba(29,78,216,0.5)] bg-clip-padding hover:from-[#60A5FA] hover:via-[#3B82F6] hover:to-[#2563EB] active:translate-y-px active:bg-gradient-to-b active:from-[#2563EB] active:via-[#1D4ED8] active:to-[#1E3A8A] active:shadow-[inset_0_1px_0_rgba(255,255,255,0.15)] cursor-pointer gap-2 px-5 h-11 rounded-[10px] text-xs">
            <span>Kembali ke Beranda</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
        </a>
    </div>

</div>
@endsection

