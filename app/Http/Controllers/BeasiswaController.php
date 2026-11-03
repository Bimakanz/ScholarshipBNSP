<?php

namespace App\Http\Controllers;

/**
 * Controller: BeasiswaController
 *
 * Deskripsi: Controller utama yang mengelola logika bisnis sistem pendaftaran beasiswa online.
 *            Menangani penampilan informasi beasiswa, rendering formulir pendaftaran interaktif,
 *            proses upload berkas ke storage public, penyimpanan data ke database,
 *            serta penampilan rekapitulasi data pendaftar beserta statistik dan grafik.
 * Initial State: Permintaan HTTP dari klien belum diproses.
 * Final State: Data tersimpan, berkas terunggah, atau tampilan view berhasil di-render ke browser.
 *
 * Author: Sena
 * Tanggal: 29 Oktober 2026
 * Versi: 1.0.0
 * Unit Kompetensi: J.620100.005.02, J.620100.010.01, J.620100.015.01, J.620100.016.01, J.620100.017.02, J.620100.019.02
 */

use App\Http\Requests\StoreBeasiswaRequest;
use App\Models\BeasiswaRegistration;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BeasiswaController extends Controller
{
    /**
     * Konstanta nilai simulasi IPK sesuai standar spesifikasi BNSP (FR.IA.02 Butir 5).
     * Digunakan sebagai nilai acuan otomatis sistem ketika halaman pendaftaran diakses.
     */
    public const IPK_TINGGI = 3.40;

    public const IPK_RENDAH = 2.90;

    /**
     * Menampilkan halaman informasi pilihan beasiswa.
     *
     * Deskripsi: Menampilkan katalog beasiswa yang tersedia beserta syarat, ketentuan,
     *            dan kuota penerima untuk calon pendaftar.
     * Initial State: Pengguna mengakses rute '/' atau '/beasiswa'.
     * Final State: View 'beasiswa.index' berhasil di-render dengan daftar beasiswa.
     * Author: Sena
     */
    public function index(): View
    {
        // Hitung sisa waktu pendaftaran menuju deadline 16 Januari 2027
        $deadline = Carbon::parse('2027-01-16')->startOfDay();
        $today = now()->startOfDay();
        $sisaHari = $today->lessThanOrEqualTo($deadline) ? (int) $today->diffInDays($deadline) : 0;

        // Data beasiswa kampus yang tersedia untuk ditampilkan pada Card UI
        $daftarBeasiswa = [
            [
                'id' => 'ppti',
                'nama' => 'Beasiswa PPTI',
                'judul_lengkap' => 'Beasiswa Akademik (PPTI)',
                'kategori' => 'Program Pendidikan Teknik Informatika',
                'deskripsi' => 'Program beasiswa unggulan bidang Teknik Informatika yang ditujukan bagi talenta muda berprestasi akademik dalam pengembangan perangkat lunak, sistem komputasi cerdas, dan rekayasa data.',
                'batas_pendaftaran' => '16 Januari 2027',
                'sisa_hari' => $sisaHari,
                'ipk_minimal' => '3.00',
                'kuota' => '50 Mahasiswa',
                'cakupan' => [
                    'Bebas Biaya Pendidikan & Pelatihan IT 100% hingga lulus',
                    'Uang saku bulanan dan fasilitas laptop perkuliahan',
                    'Peluang karir langsung di bidang rekayasa perangkat lunak & IT',
                ],
                'syarat_berkas' => [
                    'Scan Kartu Tanda Mahasiswa (KTM) aktif',
                    'Transkrip Nilai / KHS semester terakhir',
                    'Portofolio projek / sertifikat kejuaraan IT (PDF / ZIP)',
                ],
                'badge' => 'Beasiswa Akademik',
                'badge_color' => 'bg-blue-50 text-blue-800 border-blue-200',
                'accent_color' => 'border-blue-600',
                'icon' => 'code',
            ],
            [
                'id' => 'pbti',
                'nama' => 'Beasiswa PBTI',
                'judul_lengkap' => 'Beasiswa Non-Akademik / Prestasi Bisnis & TI (PBTI)',
                'kategori' => 'Program Pendidikan Bisnis & Teknologi Informasi',
                'deskripsi' => 'Program beasiswa terpadu yang memadukan keahlian analitika bisnis modern dengan penerapan teknologi informasi mutakhir untuk mencetak profesional andal di era digital.',
                'batas_pendaftaran' => '16 Januari 2027',
                'sisa_hari' => $sisaHari,
                'ipk_minimal' => '3.00',
                'kuota' => '35 Mahasiswa',
                'cakupan' => [
                    'Bebas Biaya Kuliah & Program Bisnis Digital 100%',
                    'Uang saku bulanan dan subsidi sertifikasi profesional',
                    'Peluang karir terjamin di industri perbankan & korporasi teknologi',
                ],
                'syarat_berkas' => [
                    'Scan Kartu Tanda Mahasiswa (KTM) aktif',
                    'Transkrip Nilai semester terakhir',
                    'Surat motivasi / sertifikat minat bakat / portofolio (PDF / JPG / ZIP)',
                ],
                'badge' => 'Beasiswa Non-Akademik & Bisnis',
                'badge_color' => 'bg-indigo-50 text-indigo-800 border-indigo-200',
                'accent_color' => 'border-indigo-600',
                'icon' => 'briefcase',
            ],
        ];

        return view('beasiswa.index', compact('daftarBeasiswa'));
    }

    /**
     * Menampilkan halaman formulir pendaftaran beasiswa.
     *
     * Deskripsi: Menampilkan form interaktif dengan kontrol otomatisasi nilai IPK,
     *            kondisional aktif/non-aktif elemen, serta auto-focus kursor.
     * Initial State: Pengguna mengakses rute '/daftar'.
     * Final State: View 'beasiswa.daftar' berhasil di-render dengan komponen form siap input.
     * Author: Sena
     */
    public function create(Request $request): View
    {
        // Nilai default beasiswa yang dipilih jika diarahkan dari kartu beasiswa
        $selectedBeasiswa = $request->query('pilihan', '');

        // Nilai IPK: Mendukung query param (?ipk=3.40 atau ?ipk=2.90) untuk kemudahan demonstrasi asesmen BNSP,
        // atau digenerate secara acak realistis saat refresh halaman dengan peluang mendapatkan IPK memenuhi syarat (>= 3.00)
        // maupun peluang mendapatkan IPK di bawah standar (< 3.00) untuk menguji kedua kondisi sistem.
        $queryIpk = $request->query('ipk');
        if ($queryIpk !== null && is_numeric($queryIpk)) {
            $simulatedIpk = number_format((float) $queryIpk, 2, '.', '');
        } elseif (old('ipk')) {
            $simulatedIpk = old('ipk');
        } else {
            // Peluang 35% mendapatkan IPK di bawah standar (< 3.00) rentang 2.40 s.d. 2.95
            // Peluang 65% mendapatkan IPK memenuhi standar (>= 3.00) rentang 3.05 s.d. 3.95
            if (mt_rand(1, 100) <= 35) {
                $randomIpk = mt_rand(240, 295) / 100;
            } else {
                $randomIpk = mt_rand(305, 395) / 100;
            }
            $simulatedIpk = number_format($randomIpk, 2, '.', '');
        }

        // Data opsi dropdown semester (1 s.d. 8 untuk jenjang S1)
        $semesterOptions = [];
        for ($i = 1; $i <= 8; $i++) {
            $semesterOptions[] = [
                'value' => (string) $i,
                'title' => 'Semester '.$i,
                'subtitle' => 'Tingkat '.ceil($i / 2).' (Tahun ke-'.ceil($i / 2).')',
            ];
        }

        // Data opsi dropdown program beasiswa kampus
        $beasiswaOptions = [
            [
                'value' => 'Beasiswa PPTI',
                'title' => 'Beasiswa Akademik (PPTI)',
                'subtitle' => 'Program Pendidikan Teknik Informatika',
                'icon' => 'code',
            ],
            [
                'value' => 'Beasiswa PBTI',
                'title' => 'Beasiswa Non-Akademik / Prestasi (PBTI)',
                'subtitle' => 'Program Pendidikan Bisnis & Teknologi Informasi',
                'icon' => 'briefcase',
            ],
        ];

        return view('beasiswa.daftar', compact('selectedBeasiswa', 'simulatedIpk', 'semesterOptions', 'beasiswaOptions'));
    }

    /**
     * Menyimpan data pendaftaran beasiswa baru ke database dan mengunggah berkas.
     *
     * Deskripsi: Menerima HTTP POST request tervalidasi dari StoreBeasiswaRequest,
     *            menangani proses unggah berkas fisik ke disk 'public',
     *            dan melakukan transaksi penyimpanan data dengan blok try-catch.
     * Initial State: Form pendaftaran disubmit oleh pengguna.
     * Final State: Data tersimpan di database dan berkas berada di storage, kemudian diarahkan ke '/hasil'.
     * Author: Sena
     */
    public function store(StoreBeasiswaRequest $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $berkasPath = null;

            // Proses upload berkas ke storage public
            if ($request->hasFile('berkas')) {
                $file = $request->file('berkas');
                // Menggunakan penamaan aman: waktu_namaasli
                $filename = time().'_'.preg_replace('/[^a-zA-Z0-9_\.\-]/', '_', $file->getClientOriginalName());
                $berkasPath = $file->storeAs('berkas_beasiswa', $filename, 'public');
            }

            // Simpan record pendaftaran ke database
            $registration = BeasiswaRegistration::create([
                'nama' => trim($request->input('nama')),
                'email' => strtolower(trim($request->input('email'))),
                'nomor_hp' => trim($request->input('nomor_hp')),
                'semester' => (int) $request->input('semester'),
                'ipk' => (float) $request->input('ipk'),
                'pilihan_beasiswa' => $request->input('pilihan_beasiswa'),
                'berkas' => $berkasPath,
                'status_ajuan' => 'Belum diverifikasi', // Default status sesuai standar BNSP
            ]);

            DB::commit();

            return redirect()
                ->route('beasiswa.hasil')
                ->with('success', 'Selamat! Pendaftaran beasiswa atas nama '.$registration->nama.' berhasil dikirimkan.');
        } catch (\Throwable $th) {
            DB::rollBack();

            // Hapus berkas jika sudah terlanjur terunggah tetapi query database gagal
            if (! empty($berkasPath) && Storage::disk('public')->exists($berkasPath)) {
                Storage::disk('public')->delete($berkasPath);
            }

            Log::error('Kesalahan pendaftaran beasiswa: '.$th->getMessage(), [
                'trace' => $th->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem saat menyimpan data pendaftaran: '.$th->getMessage());
        }
    }

    /**
     * Menampilkan halaman pencarian hasil dan rekapitulasi data pendaftar beasiswa (Publik / Mahasiswa).
     *
     * Deskripsi: Merender halaman pencarian terpusat (search box di tengah) yang aman dan berstatus read-only.
     *            Mahasiswa mencari namanya untuk melihat kartu hasil dan membuka halaman detail penerimaan.
     * Initial State: Pengguna publik mengakses rute '/hasil'.
     * Final State: View 'beasiswa.hasil' berhasil di-render dengan kontrol input pencarian nama.
     * Author: Sena
     */
    public function hasil(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        // Hanya tampilkan pendaftar jika ada input pencarian nama (tidak menampilkan nama orang lain secara publik)
        if ($search !== '') {
            $pendaftar = BeasiswaRegistration::where('nama', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $pendaftar = collect();
        }

        $totalPendaftar = BeasiswaRegistration::count();

        return view('beasiswa.hasil', [
            'pendaftar' => $pendaftar,
            'search' => $search,
            'totalPendaftar' => $totalPendaftar,
            'hasSearched' => ($search !== ''),
        ]);
    }

    /**
     * Menampilkan halaman detail penerimaan beasiswa (Read-only untuk Mahasiswa / Publik).
     *
     * Deskripsi: Menampilkan status ajuan ('Belum diverifikasi', 'Terverifikasi', atau 'Ditolak')
     *            serta rincian data pendaftaran mahasiswa secara transparan tanpa opsi pengubahan data.
     * Initial State: Pengguna mengklik nama/link pada hasil pencarian '/hasil'.
     * Final State: View 'beasiswa.detail_penerimaan' berhasil ditampilkan.
     * Author: Sena
     */
    public function detailPenerimaan(int $id): View
    {
        $registration = BeasiswaRegistration::findOrFail($id);

        return view('beasiswa.detail_penerimaan', compact('registration'));
    }

    /**
     * Mengunduh file berkas persyaratan pendaftar secara aman.
     *
     * Deskripsi: Memeriksa eksistensi file pada storage public dan melakukan download.
     * Initial State: Pengguna mengklik tombol download berkas pada tabel rekapitulasi.
     * Final State: Browser mengunduh file berkas atau menampilkan pesan error jika tidak ditemukan.
     * Author: Sena
     */
    public function downloadBerkas(int $id): BinaryFileResponse|RedirectResponse
    {
        $registration = BeasiswaRegistration::findOrFail($id);

        if (empty($registration->berkas) || ! Storage::disk('public')->exists($registration->berkas)) {
            return redirect()
                ->route('beasiswa.hasil')
                ->with('error', 'File berkas tidak ditemukan pada server penyimpanan.');
        }

        $filePath = Storage::disk('public')->path($registration->berkas);
        $downloadName = 'Berkas_'.preg_replace('/[^a-zA-Z0-9_\-]/', '_', $registration->nama).'.'.$registration->berkas_extension;

        return response()->download($filePath, $downloadName);
    }
}
