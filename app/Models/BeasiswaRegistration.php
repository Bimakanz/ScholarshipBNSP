<?php

namespace App\Models;

/**
 * Model: BeasiswaRegistration
 *
 * Deskripsi: Model Eloquent yang merepresentasikan entitas pendaftaran beasiswa
 *            pada tabel 'beasiswa_registrations'. Mengelola manipulasi data,
 *            casting tipe data, serta accessor URL berkas dan badge status.
 * Initial State: Objek pendaftaran belum diinstansiasi atau dipetakan ke database.
 * Final State: Entitas pendaftaran terhubung ke tabel beasiswa_registrations dan siap digunakan.
 *
 * Author: Sena
 * Tanggal: 29 Oktober 2026
 * Versi: 1.0.0
 * Unit Kompetensi: J.620100.015.01 & J.620100.017.02
 */

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BeasiswaRegistration extends Model
{
    use HasFactory;

    /**
     * Nama tabel database yang terhubung dengan model.
     *
     * @var string
     */
    protected $table = 'beasiswa_registrations';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'email',
        'nomor_hp',
        'semester',
        'ipk',
        'pilihan_beasiswa',
        'berkas',
        'status_ajuan',
    ];

    /**
     * Definisi casting tipe atribut.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'semester' => 'integer',
        'ipk' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Accessor untuk mendapatkan URL lengkap berkas yang tersimpan di storage public.
     *
     * Deskripsi: Menghasilkan URL publik untuk file berkas yang diunggah.
     * Initial State: Nilai kolom berkas tersimpan dalam bentuk relative path.
     * Final State: Mengembalikan full URL yang dapat diakses oleh browser.
     */
    public function getBerkasUrlAttribute(): string
    {
        if (empty($this->berkas)) {
            return '#';
        }

        return Storage::url($this->berkas);
    }

    /**
     * Accessor untuk mendapatkan kelas CSS badge status ajuan.
     *
     * Deskripsi: Menentukan warna badge visual berdasarkan status ajuan pendaftar.
     * Initial State: Status ajuan berupa teks string enum.
     * Final State: Mengembalikan string kelas CSS untuk styling UI modern.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status_ajuan) {
            'Terverifikasi' => 'bg-emerald-50 text-emerald-800 border border-emerald-200/90',
            'Ditolak' => 'bg-rose-50 text-rose-800 border border-rose-200/90',
            default => 'bg-amber-50 text-amber-800 border border-amber-200/90',
        };
    }

    /**
     * Accessor untuk mendapatkan ekstensi file berkas.
     *
     * Deskripsi: Membantu identifikasi tipe file (PDF, gambar, atau zip).
     * Initial State: Path berkas lengkap tersimpan di database.
     * Final State: Mengembalikan ekstensi huruf kecil file (misal: 'pdf', 'png').
     */
    public function getBerkasExtensionAttribute(): string
    {
        return strtolower(pathinfo($this->berkas, PATHINFO_EXTENSION));
    }
}
