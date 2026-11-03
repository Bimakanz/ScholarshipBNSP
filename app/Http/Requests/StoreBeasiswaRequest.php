<?php

namespace App\Http\Requests;

/**
 * Form Request: StoreBeasiswaRequest
 *
 * Deskripsi: Form Request untuk menangani otorisasi, sanitasi, dan validasi ketat
 *            pada formulir pendaftaran beasiswa online mahasiswa.
 * Initial State: Input HTTP request mentah diterima dari formulir pendaftaran.
 * Final State: Data terverifikasi valid sesuai kriteria aturan bisnis BNSP atau
 *              mengembalikan respons redirect dengan pesan kesalahan spesifik.
 *
 * Author: Sena
 * Tanggal: 29 Oktober 2026
 * Versi: 1.0.0
 * Unit Kompetensi: J.620100.015.01 & J.620100.016.01
 */

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBeasiswaRequest extends FormRequest
{
    /**
     * Menentukan apakah pengguna diizinkan untuk membuat request ini.
     *
     * Deskripsi: Menentukan izin otorisasi akses endpoint pendaftaran.
     * Initial State: Status otorisasi belum ditentukan.
     * Final State: Mengembalikan boolean true (publik dapat mendaftar).
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Mendapatkan aturan validasi yang berlaku untuk request ini.
     *
     * Deskripsi: Mendefinisikan aturan validasi untuk seluruh komponen form pendaftaran.
     * Initial State: Aturan validasi belum dipetakan.
     * Final State: Menghasilkan array asosiatif berisi aturan validasi Laravel.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => [
                'required',
                'string',
                'max:150',
                'regex:/^[\pL\s\.\,\'\-]+$/u',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:150',
            ],
            'nomor_hp' => [
                'required',
                'numeric',
                'digits_between:10,13',
            ],
            'semester' => [
                'required',
                'integer',
                'between:1,8',
            ],
            'ipk' => [
                'required',
                'numeric',
                'between:0.00,4.00',
                'min:3.00',
            ],
            'pilihan_beasiswa' => [
                'required',
                'string',
                'in:Beasiswa PPTI,Beasiswa PBTI',
            ],
            'berkas' => [
                'required',
                'file',
                'mimes:pdf,jpg,jpeg,png,zip',
                'max:2048', // Maksimal 2MB (2048 KB)
            ],
        ];
    }

    /**
     * Menyesuaikan nama atribut validasi agar pesan kesalahan ramah pengguna.
     *
     * Deskripsi: Mapping nama field input form ke nama deskriptif berbahasa Indonesia.
     * Initial State: Atribut masih menggunakan key database.
     * Final State: Atribut terbaca humanis pada pesan validasi.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'nama' => 'Nama Lengkap',
            'email' => 'Alamat Email',
            'nomor_hp' => 'Nomor Handphone/WhatsApp',
            'semester' => 'Semester Saat Ini',
            'ipk' => 'Nilai IPK Terakhir',
            'pilihan_beasiswa' => 'Pilihan Beasiswa',
            'berkas' => 'Berkas Persyaratan',
        ];
    }

    /**
     * Kustomisasi pesan kesalahan validasi (Custom Validation Messages).
     *
     * Deskripsi: Memberikan umpan balik error dalam Bahasa Indonesia yang jelas.
     * Initial State: Pesan error default framework (Bahasa Inggris).
     * Final State: Pesan error informatif sesuai kaidah uji kompetensi.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'nama.regex' => 'Nama lengkap hanya boleh mengandung huruf, spasi, titik, atau tanda petik.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid (contoh: mahasiswa@kampus.ac.id).',
            'nomor_hp.required' => 'Nomor HP wajib diisi.',
            'nomor_hp.numeric' => 'Nomor HP hanya boleh berisi karakter angka.',
            'nomor_hp.digits_between' => 'Nomor HP harus berdurasi antara 10 sampai 13 digit angka.',
            'semester.required' => 'Semester saat ini wajib dipilih.',
            'semester.between' => 'Pilihan semester harus antara semester 1 sampai 8 (Jenjang S1).',
            'ipk.required' => 'Nilai IPK terakhir belum tersedia.',
            'ipk.min' => 'Maaf, IPK Anda di bawah 3.00, Anda tidak memenuhi syarat untuk mendaftar beasiswa.',
            'pilihan_beasiswa.required' => 'Silakan pilih jenis beasiswa yang diminati.',
            'pilihan_beasiswa.in' => 'Pilihan beasiswa yang dipilih tidak terdaftar pada sistem.',
            'berkas.required' => 'Berkas persyaratan wajib diunggah.',
            'berkas.mimes' => 'Format berkas hanya diperbolehkan berekstensi: PDF, JPG, JPEG, PNG, atau ZIP.',
            'berkas.max' => 'Ukuran berkas melebihi batas maksimal 2MB (2048 KB).',
        ];
    }
}
