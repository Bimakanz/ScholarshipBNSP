<?php

namespace Tests\Feature;

/**
 * Feature Test: BeasiswaRegistrationTest
 *
 * Deskripsi: Rangkaian pengujian fitur otomatis (Automated Feature Tests)
 *            untuk memvalidasi fungsionalitas sistem pendaftaran beasiswa BNSP.
 * Author: Sena
 * Tanggal: 29 Oktober 2026
 * Versi: 1.0.0
 * Unit Kompetensi: J.620100.016.01 & J.620100.017.02
 */

use App\Models\BeasiswaRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BeasiswaRegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Uji aksesibilitas halaman informasi pilihan beasiswa (Menu 1).
     */
    public function test_halaman_pilihan_beasiswa_dapat_diakses(): void
    {
        $response = $this->get(route('beasiswa.index'));

        $response->assertStatus(200);
        $response->assertSee('Beasiswa PPTI');
        $response->assertSee('Beasiswa PBTI');
    }

    /**
     * Uji aksesibilitas formulir pendaftaran beasiswa (Menu 2).
     */
    public function test_halaman_formulir_pendaftaran_dapat_diakses(): void
    {
        $response = $this->get(route('beasiswa.create'));

        $response->assertStatus(200);
        $response->assertSee('Formulir Pendaftaran Beasiswa');
        $response->assertSee('IPK Terakhir');
        $response->assertSee('btn-simulate-pass', false);
        $response->assertSee('btn-simulate-fail', false);
    }

    /**
     * Uji simulasi IPK melalui query parameter untuk pengujian asesor BNSP.
     */
    public function test_halaman_formulir_mendukung_simulasi_ipk_melalui_query_param(): void
    {
        $responsePass = $this->get(route('beasiswa.create', ['ipk' => 3.40]));
        $responsePass->assertStatus(200);
        $responsePass->assertSee('value="3.40"', false);

        $responseFail = $this->get(route('beasiswa.create', ['ipk' => 2.90]));
        $responseFail->assertStatus(200);
        $responseFail->assertSee('value="2.90"', false);
    }

    /**
     * Uji aksesibilitas halaman hasil / rekapitulasi data (Menu 3).
     */
    public function test_halaman_hasil_rekapitulasi_dapat_diakses(): void
    {
        $response = $this->get(route('beasiswa.hasil'));

        $response->assertStatus(200);
        $response->assertSee('Hasil &amp; Status Pendaftaran Beasiswa', false);
    }

    /**
     * Uji validasi penolakan sistem jika IPK < 3.00.
     */
    public function test_pendaftaran_gagal_jika_ipk_kurang_dari_tiga(): void
    {
        Storage::fake('public');

        $payload = [
            'nama' => 'Bima Gilang',
            'email' => 'bima@student.kampus.ac.id',
            'nomor_hp' => '081234567890',
            'semester' => 4,
            'ipk' => 2.90, // IPK < 3.00
            'pilihan_beasiswa' => 'Beasiswa PPTI',
            'berkas' => UploadedFile::fake()->create('dokumen.pdf', 500, 'application/pdf'),
        ];

        $response = $this->from(route('beasiswa.create'))->post(route('beasiswa.store'), $payload);

        $response->assertSessionHasErrors(['ipk']);
        $this->assertDatabaseCount('beasiswa_registrations', 0);
    }

    /**
     * Uji validasi bahwa nomor HP wajib numeric dan 10-13 digit.
     */
    public function test_pendaftaran_gagal_jika_nomor_hp_tidak_valid(): void
    {
        Storage::fake('public');

        $payload = [
            'nama' => 'Bima Gilang',
            'email' => 'bima@student.kampus.ac.id',
            'nomor_hp' => '08123', // kurang dari 10 digit
            'semester' => 4,
            'ipk' => 3.50,
            'pilihan_beasiswa' => 'Beasiswa PPTI',
            'berkas' => UploadedFile::fake()->create('dokumen.pdf', 500, 'application/pdf'),
        ];

        $response = $this->from(route('beasiswa.create'))->post(route('beasiswa.store'), $payload);

        $response->assertSessionHasErrors(['nomor_hp']);
        $this->assertDatabaseCount('beasiswa_registrations', 0);
    }

    /**
     * Uji skenario sukses: Data lengkap, IPK >= 3.00, berkas valid.
     */
    public function test_pendaftaran_berhasil_disimpan_dan_berkas_terunggah(): void
    {
        Storage::fake('public');

        $payload = [
            'nama' => 'Bima Gilang Ramadhan',
            'email' => 'bima.gilang@student.kampus.ac.id',
            'nomor_hp' => '081234567890',
            'semester' => 5,
            'ipk' => 3.75,
            'pilihan_beasiswa' => 'Beasiswa PPTI',
            'berkas' => UploadedFile::fake()->create('transkrip_nilai.pdf', 800, 'application/pdf'),
        ];

        $response = $this->post(route('beasiswa.store'), $payload);

        $response->assertRedirect(route('beasiswa.hasil'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('beasiswa_registrations', [
            'nama' => 'Bima Gilang Ramadhan',
            'email' => 'bima.gilang@student.kampus.ac.id',
            'semester' => 5,
            'pilihan_beasiswa' => 'Beasiswa PPTI',
            'status_ajuan' => 'Belum diverifikasi', // Default status
        ]);

        $registration = BeasiswaRegistration::where('email', 'bima.gilang@student.kampus.ac.id')->first();
        $this->assertNotNull($registration);
        $this->assertNotNull($registration->berkas);
        Storage::disk('public')->assertExists($registration->berkas);
    }

    /**
     * Uji fitur pencarian nama pendaftar pada halaman publik (/hasil) dan akses halaman detail penerimaan.
     */
    public function test_pencarian_nama_dan_halaman_detail_penerimaan_publik(): void
    {
        $reg = BeasiswaRegistration::create([
            'nama' => 'Bimasena Gilang Ramadhan',
            'email' => 'bimasena@student.kampus.ac.id',
            'nomor_hp' => '081234567891',
            'semester' => 6,
            'ipk' => 3.80,
            'pilihan_beasiswa' => 'Beasiswa PPTI',
            'berkas' => 'berkas_beasiswa/dummy.pdf',
            'status_ajuan' => 'Belum diverifikasi',
        ]);

        // Uji pencarian "Bimasena"
        $responseSearch = $this->get(route('beasiswa.hasil', ['search' => 'Bimasena']));
        $responseSearch->assertStatus(200);
        $responseSearch->assertSee('Bimasena Gilang Ramadhan');
        $responseSearch->assertSee(route('beasiswa.detail', $reg->id));

        // Uji akses halaman detail penerimaan (read-only untuk user biasa)
        $responseDetail = $this->get(route('beasiswa.detail', $reg->id));
        $responseDetail->assertStatus(200);
        $responseDetail->assertSee('Detail Penerimaan Beasiswa');
        $responseDetail->assertSee('Bimasena Gilang Ramadhan');
        $responseDetail->assertSee('Pending');
        // Pastikan tidak ada form pengubah status untuk user biasa
        $responseDetail->assertDontSee('name="status_ajuan"', false);
    }

    /**
     * Uji alur autentikasi administrator dan pembatasan hak akses guest.
     */
    public function test_autentikasi_admin_dan_dashboard_manajemen(): void
    {
        // 1. Guest dilarang mengakses dashboard admin
        $responseGuest = $this->get(route('admin.dashboard'));
        $responseGuest->assertRedirect(route('admin.login'));

        // 2. Akses halaman login admin
        $responseLogin = $this->get(route('admin.login'));
        $responseLogin->assertStatus(200);
        $responseLogin->assertSee('Login Administrator');

        // 3. Login berhasil menggunakan akun demo
        $responseSubmit = $this->post(route('admin.login.submit'), [
            'login' => 'admin@kampus.ac.id',
            'password' => 'admin123',
        ]);
        $responseSubmit->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();

        // 4. Buka dashboard admin dan pastikan tabel tampil
        $responseDashboard = $this->get(route('admin.dashboard'));
        $responseDashboard->assertStatus(200);
        $responseDashboard->assertSee('Panel Verifikasi &amp; Rekapitulasi Beasiswa', false);
        $responseDashboard->assertSee('Tabel Rekapitulasi &amp; Pengubahan Status Ajuan', false);

        // 5. Admin dapat memperbarui status ajuan pendaftar
        $reg = BeasiswaRegistration::create([
            'nama' => 'Siswa Uji BNSP',
            'email' => 'siswa@student.kampus.ac.id',
            'nomor_hp' => '081298765432',
            'semester' => 4,
            'ipk' => 3.55,
            'pilihan_beasiswa' => 'Beasiswa PBTI',
            'berkas' => 'berkas_beasiswa/dummy.pdf',
            'status_ajuan' => 'Belum diverifikasi',
        ]);

        $responsePatch = $this->patch(route('admin.status.update', $reg->id), [
            'status_ajuan' => 'Terverifikasi',
        ]);
        $responsePatch->assertRedirect(route('admin.dashboard'));
        $this->assertDatabaseHas('beasiswa_registrations', [
            'id' => $reg->id,
            'status_ajuan' => 'Terverifikasi',
        ]);

        // 6. Admin logout (dialihkan ke halaman login admin)
        $responseLogout = $this->post(route('admin.logout'));
        $responseLogout->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }
}
