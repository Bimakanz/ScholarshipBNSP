<?php

/**
 * Migration: CreateBeasiswaRegistrationsTable
 *
 * Deskripsi: Migration untuk membuat tabel beasiswa_registrations yang digunakan
 *            untuk menyimpan data pendaftaran beasiswa online mahasiswa.
 * Initial State: Tabel beasiswa_registrations belum ada di dalam database.
 * Final State: Tabel beasiswa_registrations berhasil terbuat dengan skema lengkap.
 *
 * Author: Peserta Uji Kompetensi BNSP - Junior Web Developer
 * Tanggal: 07 September 2026
 * Versi: 1.0.0
 * Unit Kompetensi: J.620100.015.01 & J.620100.017.02
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Deskripsi: Menjalankan eksekusi skema tabel beasiswa_registrations.
     * Initial State: Tabel beasiswa_registrations belum tersedia pada database.
     * Final State: Tabel beasiswa_registrations terbentuk beserta seluruh kolom & constraint.
     */
    public function up(): void
    {
        Schema::create('beasiswa_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->string('email', 150);
            $table->string('nomor_hp', 20);
            $table->unsignedTinyInteger('semester');
            $table->decimal('ipk', 3, 2);
            $table->string('pilihan_beasiswa', 100);
            $table->string('berkas', 255);
            $table->enum('status_ajuan', ['Belum diverifikasi', 'Terverifikasi', 'Ditolak'])
                ->default('Belum diverifikasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * Deskripsi: Membatalkan migration dengan menghapus tabel beasiswa_registrations.
     * Initial State: Tabel beasiswa_registrations ada di dalam database.
     * Final State: Tabel beasiswa_registrations terhapus dari database.
     */
    public function down(): void
    {
        Schema::dropIfExists('beasiswa_registrations');
    }
};
