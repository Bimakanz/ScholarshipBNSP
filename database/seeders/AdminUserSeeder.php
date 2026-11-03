<?php

namespace Database\Seeders;

/**
 * Seeder: AdminUserSeeder
 *
 * Deskripsi: Membuat akun default administrator untuk pengelolaan verifikasi beasiswa BNSP.
 * Author: Sena
 * Tanggal: 29 Oktober 2026
 * Versi: 1.0.0
 */

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@kampus.ac.id'],
            [
                'name' => 'Administrator Panitia',
                'password' => Hash::make('admin123'),
            ]
        );
    }
}
