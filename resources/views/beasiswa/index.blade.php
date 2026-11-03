@extends('layouts.app')

@section('title', 'Katalog Pilihan Beasiswa Kampus')

@section('main_class', 'flex-1 w-full')

@section('content')
<!--
    View: beasiswa.index
    Deskripsi: Halaman katalog dan informasi pilihan beasiswa (Menu 1).
               Mengimplementasikan Split Hero Academic Banner bernuansa Royal Blue & Indigo,
               3-Step Alur Pendaftaran Sekuensial, serta 2 Kartu Beasiswa Terstruktur.
    Author: Sena
    Tanggal: 29 Oktober 2026
    Versi: 1.0.0
    Unit Kompetensi: J.620100.005.02 (Mengimplementasikan User Interface)
-->

<!-- 1. SPLIT HERO SECTION / ACADEMIC BANNER -->
<section class="relative bg-gradient-to-br from-blue-900 via-indigo-900 to-slate-900 text-white overflow-hidden py-14 sm:py-20 px-4 sm:px-6 lg:px-8 border-b border-blue-950 shadow-sm">
    <!-- Ambient Academic Pattern Background -->
    <div class="absolute inset-0 opacity-10 pointer-events-none bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:20px_20px]"></div>
    
    <div class="max-w-7xl mx-auto relative z-10">
        <!-- Hero Content (Left-Aligned, Spacious & Breathable) -->
        <div class="max-w-3xl space-y-6 text-left">

            <!-- Judul Utama -->
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-[1.18]">
                Raih Beasiswa Pendidikan Tinggi.<br class="hidden sm:inline"/>
                <span class="text-amber-400">Fokus Belajar, Bangun Masa Depan.</span>
            </h2>

            <!-- Sub-deskripsi Faktual -->
            <p class="text-blue-100/90 text-sm sm:text-base leading-relaxed max-w-2xl font-normal">
                Program bantuan pembiayaan studi penuh dan tunjangan kemahasiswaan untuk mencetak generasi unggul berdaya saing global. Terintegrasi langsung dengan validasi IPK otomatis melalui Sistem Informasi Akademik (SIAKAD) universitas.
            </p>

            <!-- Tombol CTA -->
            <div class="flex flex-wrap items-center gap-3.5 pt-2">
                <a href="{{ route('beasiswa.create') }}" 
                   data-slot="button" 
                   data-variant="specialtive" 
                   class="group/button inline-flex shrink-0 items-center justify-center border-transparent font-medium whitespace-nowrap transition-all outline-none select-none active:not-aria-[haspopup]:translate-y-px [&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4 border-0 bg-gradient-to-b from-[#38BDF8] via-[#2563EB] to-[#1D4ED8] text-white ring-1 ring-inset ring-white/20 shadow-[inset_0_1px_0_rgba(255,255,255,0.35),0_8px_16px_-4px_rgba(29,78,216,0.5)] bg-clip-padding hover:from-[#60A5FA] hover:via-[#3B82F6] hover:to-[#2563EB] active:translate-y-px active:bg-gradient-to-b active:from-[#2563EB] active:via-[#1D4ED8] active:to-[#1E3A8A] active:shadow-[inset_0_1px_0_rgba(255,255,255,0.15)] cursor-pointer gap-2 px-6 h-11 rounded-[10px] text-[15px]">
                    <span>Daftar Beasiswa Sekarang</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
                <a href="#katalog-beasiswa" 
                   class="inline-flex items-center gap-2 px-5 py-3.5 rounded-xl bg-white/10 hover:bg-white/20 text-white border border-white/25 font-semibold text-sm backdrop-blur-xs transition-all">
                    <span>Pelajari Persyaratan</span>
                    <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </a>
            </div>

            <!-- Ringkasan Fitur Unggulan -->
            <div class="pt-4 flex flex-wrap items-center gap-6 text-xs text-blue-200 border-t border-blue-800/60">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>100% Bebas Biaya SPP / UKT</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Uang Saku &amp; Laptop Belajar</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Penempatan Karir Profesional</span>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- MAIN CONTAINER FOR CONTENT -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 space-y-16">

    <!-- 2. ALUR PENDAFTARAN MENURUN BERGELOMBANG (ZIG-ZAG PROGRESSION FLOW) -->
    <div class="space-y-8">
        <div class="text-center max-w-xl mx-auto space-y-1.5">
            <span class="text-[11px] font-bold uppercase tracking-wider text-blue-700">PROSEDUR RESMI</span>
            <h3 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">3 Langkah Alur Pendaftaran</h3>
            <p class="text-xs sm:text-sm text-slate-500">Ikuti tahapan berurutan secara terstruktur untuk menyelesaikan proses pengajuan beasiswa kampus.</p>
        </div>

        <!-- Container Alur Menurun (Zig-Zag) Tanpa Gap Bebas Spasi -->
        <div class="max-w-5xl mx-auto relative">
            
            <!-- LANGKAH 1 (KIRI) -->
            <div class="flex flex-col md:flex-row items-center justify-start">
                <div class="w-full md:w-8/12 lg:w-7/12">
                    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-sm hover:shadow-md hover:border-blue-300 transition-all space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3.5">
                                <span class="w-12 h-12 rounded-xl bg-blue-700 text-white font-extrabold text-lg flex items-center justify-center shadow-xs">
                                    01
                                </span>
                                <div>
                                    <span class="text-[11px] font-bold uppercase tracking-wider text-blue-700">Tahap Pertama</span>
                                    <h4 class="text-lg sm:text-xl font-extrabold text-slate-900 leading-tight">Cek Kualifikasi &amp; Syarat Standar</h4>
                                </div>
                            </div>
                            <span class="hidden sm:inline-flex px-3 py-1 rounded-md text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                Sistem Otomatis
                            </span>
                        </div>

                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Pastikan IPK semester terakhir Anda minimal <strong class="text-blue-700 font-bold">3.00</strong> pada jenjang S1 (semester 1 s.d. 8). Sistem Informasi Akademik (SIAKAD) akan memeriksa kelayakan secara otomatis sebelum formulir pendaftaran dapat dibuka.
                        </p>

                        <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center gap-2 text-xs">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-slate-50 text-slate-700 border border-slate-200 font-medium">
                                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Standar Nilai IPK &ge; 3.00</span>
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-slate-50 text-slate-700 border border-slate-200 font-medium">
                                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Mahasiswa Aktif Semester 1 - 8</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ARROW CONNECTOR 1 -> 2: KELUAR DARI TENGAH CARD 1 DENGAN JARAK KE CARD 2 -->
            <div class="relative w-full h-20 sm:h-24 my-1">
                <!-- Desktop: Garis Lengkung dari Tengah Card 1 (x: 290) menuju Tengah Card 2 (x: 710) dengan Jarak Bersih -->
                <div class="hidden md:block w-full h-full">
                    <svg class="w-full h-full overflow-visible" viewBox="0 0 1000 90" fill="none" preserveAspectRatio="none">
                        <!-- Garis lengkung keluar dari tepat tengah Card 1 (x: 290, y: 0) -->
                        <path d="M 290 0 C 290 48, 710 24, 710 60" 
                              stroke="#2563eb" 
                              stroke-width="3" 
                              stroke-dasharray="8 6" 
                              stroke-linecap="round" 
                              vector-effect="non-scaling-stroke" />
                        <!-- Kepala Panah Menghadap ke Bawah Tepat di Tengah Card 2 dengan Jarak Bernafas -->
                        <polygon points="702,60 718,60 710,74" fill="#2563eb" />
                    </svg>
                </div>

                <!-- Mobile: Garis Vertikal Menurun dari Tengah dengan Jarak -->
                <div class="flex md:hidden flex-col items-center justify-center h-14 my-1">
                    <svg class="w-6 h-full overflow-visible" viewBox="0 0 24 56" fill="none">
                        <path d="M 12 0 L 12 34" stroke="#2563eb" stroke-width="2.5" stroke-dasharray="6 4" stroke-linecap="round" />
                        <polygon points="6,32 18,32 12,44" fill="#2563eb" />
                    </svg>
                </div>
            </div>

            <!-- LANGKAH 2 (KANAN) -->
            <div class="flex flex-col md:flex-row items-center justify-end">
                <div class="w-full md:w-8/12 lg:w-7/12">
                    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-sm hover:shadow-md hover:border-blue-300 transition-all space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3.5">
                                <span class="w-12 h-12 rounded-xl bg-blue-700 text-white font-extrabold text-lg flex items-center justify-center shadow-xs">
                                    02
                                </span>
                                <div>
                                    <span class="text-[11px] font-bold uppercase tracking-wider text-blue-700">Tahap Kedua</span>
                                    <h4 class="text-lg sm:text-xl font-extrabold text-slate-900 leading-tight">Isi Formulir &amp; Unggah Berkas</h4>
                                </div>
                            </div>
                            <span class="hidden sm:inline-flex px-3 py-1 rounded-md text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                Pengisian Data
                            </span>
                        </div>

                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Lengkapi identitas mahasiswa, nomor handphone aktif, tentukan pilihan program beasiswa (PPTI atau PBTI), dan unggah dokumen persyaratan dalam format digital (PDF, JPG, PNG, atau ZIP maks. 2MB).
                        </p>

                        <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center gap-2 text-xs">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-slate-50 text-slate-700 border border-slate-200 font-medium">
                                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Formulir Terstandar BNSP</span>
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-slate-50 text-slate-700 border border-slate-200 font-medium">
                                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Lampiran Berkas Digital (Maks. 2MB)</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ARROW CONNECTOR 2 -> 3: KELUAR DARI TENGAH CARD 2 DENGAN JARAK KE CARD 3 -->
            <div class="relative w-full h-20 sm:h-24 my-1">
                <!-- Desktop: Garis Lengkung dari Tengah Card 2 (x: 710) menuju Tengah Card 3 (x: 290) dengan Jarak Bersih -->
                <div class="hidden md:block w-full h-full">
                    <svg class="w-full h-full overflow-visible" viewBox="0 0 1000 90" fill="none" preserveAspectRatio="none">
                        <!-- Garis lengkung keluar dari tepat tengah Card 2 (x: 710, y: 0) -->
                        <path d="M 710 0 C 710 48, 290 24, 290 60" 
                              stroke="#2563eb" 
                              stroke-width="3" 
                              stroke-dasharray="8 6" 
                              stroke-linecap="round" 
                              vector-effect="non-scaling-stroke" />
                        <!-- Kepala Panah Menghadap ke Bawah Tepat di Tengah Card 3 dengan Jarak Bernafas -->
                        <polygon points="282,60 298,60 290,74" fill="#2563eb" />
                    </svg>
                </div>

                <!-- Mobile: Garis Vertikal Menurun dari Tengah dengan Jarak -->
                <div class="flex md:hidden flex-col items-center justify-center h-14 my-1">
                    <svg class="w-6 h-full overflow-visible" viewBox="0 0 24 56" fill="none">
                        <path d="M 12 0 L 12 34" stroke="#2563eb" stroke-width="2.5" stroke-dasharray="6 4" stroke-linecap="round" />
                        <polygon points="6,32 18,32 12,44" fill="#2563eb" />
                    </svg>
                </div>
            </div>

            <!-- LANGKAH 3 (KIRI) -->
            <div class="flex flex-col md:flex-row items-center justify-start">
                <div class="w-full md:w-8/12 lg:w-7/12">
                    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-sm hover:shadow-md hover:border-blue-300 transition-all space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3.5">
                                <span class="w-12 h-12 rounded-xl bg-blue-700 text-white font-extrabold text-lg flex items-center justify-center shadow-xs">
                                    03
                                </span>
                                <div>
                                    <span class="text-[11px] font-bold uppercase tracking-wider text-blue-700">Tahap Ketiga</span>
                                    <h4 class="text-lg sm:text-xl font-extrabold text-slate-900 leading-tight">Pantau Status Verifikasi &amp; Rekap</h4>
                                </div>
                            </div>
                            <span class="hidden sm:inline-flex px-3 py-1 rounded-md text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                Hasil Pengajuan
                            </span>
                        </div>

                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Setelah pendaftaran berhasil dikirim, data pengajuan otomatis tersimpan dalam sistem dengan status awal <strong class="text-blue-700 font-bold">"Belum diverifikasi"</strong>. Anda dapat melihat rangkuman data serta berkas lampiran secara transparan di menu Hasil.
                        </p>

                        <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center gap-2 text-xs">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-slate-50 text-slate-700 border border-slate-200 font-medium">
                                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Status Ajuan Real-Time</span>
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-slate-50 text-slate-700 border border-slate-200 font-medium">
                                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Akses Unduh Berkas Persyaratan</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- 3. KATALOG PILIHAN BEASISWA (2 KARTU BESAR) -->
    <div id="katalog-beasiswa" class="space-y-8 scroll-mt-24">
        
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 border-b border-slate-200 pb-5">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-blue-700">SKEMA PROGRAM KAMPUS</span>
                <h3 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 mt-1">Katalog Pilihan Beasiswa</h3>
            </div>
            <p class="text-xs text-slate-500 max-w-md">
                Tersedia 2 program beasiswa unggulan kampus. Silakan pelajari rincian fasilitas dan persyaratannya di bawah ini.
            </p>
        </div>

        <!-- 2 Kartu Beasiswa Besar Berdampingan -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @foreach($daftarBeasiswa as $beasiswa)
                <article class="bg-white rounded-2xl border-2 {{ $beasiswa['accent_color'] ?? 'border-blue-600' }} shadow-md hover:shadow-xl transition-all flex flex-col justify-between overflow-hidden">
                    
                    <div>
                        <!-- Header Kartu Beasiswa -->
                        <div class="p-6 sm:p-7 bg-slate-50 border-b border-slate-200">
                            
                            <div class="flex items-center justify-between gap-3 mb-3">
                                <span class="px-2.5 py-1 rounded-md text-xs font-bold border {{ $beasiswa['badge_color'] }}">
                                    {{ $beasiswa['badge'] }}
                                </span>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-semibold">
                                    <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>{{ $beasiswa['sisa_hari'] }} hari tersisa</span>
                                </span>
                            </div>

                            <h4 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                                {{ $beasiswa['judul_lengkap'] ?? $beasiswa['nama'] }}
                            </h4>
                            <span class="block text-xs font-semibold text-blue-700 mt-0.5">
                                {{ $beasiswa['kategori'] }}
                            </span>

                            <p class="text-slate-600 text-xs sm:text-sm leading-relaxed mt-3 font-normal">
                                {{ $beasiswa['deskripsi'] }}
                            </p>
                        </div>

                        <!-- Panel Spesifikasi Ringkas (Grid) -->
                        <div class="p-6 sm:p-7 space-y-6">
                            
                            <div class="grid grid-cols-2 gap-3.5 p-4 rounded-xl bg-blue-50/60 border border-blue-100">
                                <div class="space-y-0.5">
                                    <span class="text-[11px] font-semibold text-slate-500 uppercase">Syarat IPK</span>
                                    <span class="text-sm font-extrabold text-blue-900 block flex items-center gap-1.5">
                                        &ge; {{ $beasiswa['ipk_minimal'] }} (Skala 4.00)
                                    </span>
                                </div>
                                <div class="space-y-0.5">
                                    <span class="text-[11px] font-semibold text-slate-500 uppercase">Alokasi Kuota</span>
                                    <span class="text-sm font-extrabold text-slate-900 block">
                                        {{ $beasiswa['kuota'] }}
                                    </span>
                                </div>
                                <div class="space-y-0.5 pt-2.5 border-t border-blue-200/60">
                                    <span class="text-[11px] font-semibold text-slate-500 uppercase">Cakupan Biaya</span>
                                    <span class="text-xs font-bold text-emerald-700 block">
                                        100% Bebas Biaya Kuliah
                                    </span>
                                </div>
                                <div class="space-y-0.5 pt-2.5 border-t border-blue-200/60">
                                    <span class="text-[11px] font-semibold text-slate-500 uppercase">Batas Akhir</span>
                                    <span class="text-xs font-bold text-slate-900 block">
                                        {{ $beasiswa['batas_pendaftaran'] }}
                                    </span>
                                </div>
                            </div>

                            <!-- Cakupan Fasilitas / Benefit -->
                            <div class="space-y-2.5">
                                <h5 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Cakupan &amp; Fasilitas Beasiswa:</span>
                                </h5>
                                <ul class="space-y-2 text-xs text-slate-700">
                                    @foreach($beasiswa['cakupan'] as $cakupan)
                                        <li class="flex items-start gap-2">
                                            <span class="text-emerald-600 font-bold mt-0.5">✓</span>
                                            <span class="leading-relaxed">{{ $cakupan }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- Dokumen Persyaratan -->
                            <div class="space-y-2.5">
                                <h5 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span>Dokumen Berkas Persyaratan:</span>
                                </h5>
                                <ul class="space-y-2 text-xs text-slate-700">
                                    @foreach($beasiswa['syarat_berkas'] as $syarat)
                                        <li class="flex items-start gap-2">
                                            <span class="text-blue-600 font-bold mt-0.5">•</span>
                                            <span class="leading-relaxed">{{ $syarat }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                        </div>
                    </div>

                    <!-- Tombol Action di Bawah Kartu -->
                    <div class="p-6 sm:p-7 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-3">
                        <span class="text-xs font-semibold text-slate-500">
                            Jenjang S1 Reguler (Semester 1 - 8)
                        </span>
                        <a href="{{ route('beasiswa.create', ['pilihan' => $beasiswa['nama']]) }}" 
                           data-slot="button" 
                           data-variant="specialtive" 
                           class="w-full sm:w-auto group/button inline-flex shrink-0 items-center justify-center border-transparent font-medium whitespace-nowrap transition-all outline-none select-none active:not-aria-[haspopup]:translate-y-px [&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4 border-0 bg-gradient-to-b from-[#38BDF8] via-[#2563EB] to-[#1D4ED8] text-white ring-1 ring-inset ring-white/20 shadow-[inset_0_1px_0_rgba(255,255,255,0.35),0_8px_16px_-4px_rgba(29,78,216,0.5)] bg-clip-padding hover:from-[#60A5FA] hover:via-[#3B82F6] hover:to-[#2563EB] active:translate-y-px active:bg-gradient-to-b active:from-[#2563EB] active:via-[#1D4ED8] active:to-[#1E3A8A] active:shadow-[inset_0_1px_0_rgba(255,255,255,0.15)] cursor-pointer gap-2 px-6 h-11 rounded-[10px] text-xs">
                            <span>Pilih &amp; Daftar {{ $beasiswa['nama'] }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>

                </article>
            @endforeach
        </div>

    </div>

</div>
@endsection
