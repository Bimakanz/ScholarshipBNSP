<?php

namespace Database\Seeders;

/**
 * Seeder: BeasiswaRegistrationSeeder
 *
 * Deskripsi: Menyediakan data awal (sample data) pendaftaran beasiswa untuk
 *            memudahkan pengujian tampilan antarmuka, rekapitulasi, dan grafik
 *            oleh Asesor Uji Kompetensi BNSP.
 * Initial State: Tabel beasiswa_registrations mungkin masih kosong.
 * Final State: Tabel beasiswa_registrations terisi beberapa data pendaftar awal.
 *
 * Author: Peserta Uji Kompetensi BNSP - Junior Web Developer
 * Tanggal: 07 September 2026
 * Versi: 1.0.0
 * Unit Kompetensi: J.620100.015.01 & J.620100.017.02
 */

use App\Models\BeasiswaRegistration;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BeasiswaRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan folder penyimpanan berkas ada
        if (! Storage::disk('public')->exists('berkas_beasiswa')) {
            Storage::disk('public')->makeDirectory('berkas_beasiswa');
        }

        // Buat dummy file berkas contoh
        $dummyBerkas = 'berkas_beasiswa/sample_berkas_syarat.pdf';
        if (! Storage::disk('public')->exists($dummyBerkas)) {
            Storage::disk('public')->put($dummyBerkas, '%PDF-1.4 Contoh Berkas Syarat Pendaftaran Beasiswa Kampus Online BNSP');
        }

        $sampleData = [
            [
                'nama' => 'Ahmad Fauzi Pratama',
                'email' => 'ahmad.fauzi@student.kampus.ac.id',
                'nomor_hp' => '081234567890',
                'semester' => 5,
                'ipk' => 3.85,
                'pilihan_beasiswa' => 'Beasiswa PPTI',
                'berkas' => $dummyBerkas,
                'status_ajuan' => 'Terverifikasi',
                'created_at' => now()->subDays(3),
            ],
            [
                'nama' => 'Siti Nurhaliza Putri',
                'email' => 'siti.nurhaliza@student.kampus.ac.id',
                'nomor_hp' => '085712345678',
                'semester' => 3,
                'ipk' => 3.45,
                'pilihan_beasiswa' => 'Beasiswa PBTI',
                'berkas' => $dummyBerkas,
                'status_ajuan' => 'Belum diverifikasi',
                'created_at' => now()->subDays(2),
            ],
            [
                'nama' => 'Budi Santoso',
                'email' => 'budi.santoso@student.kampus.ac.id',
                'nomor_hp' => '082198765432',
                'semester' => 7,
                'ipk' => 3.60,
                'pilihan_beasiswa' => 'Beasiswa PPTI',
                'berkas' => $dummyBerkas,
                'status_ajuan' => 'Belum diverifikasi',
                'created_at' => now()->subDay(),
            ],
        ];

        foreach ($sampleData as $data) {
            BeasiswaRegistration::updateOrCreate(
                ['email' => $data['email']],
                $data
            );
        }
    }
}
