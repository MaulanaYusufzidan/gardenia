# CV. Gardenia Setia Utama — Web & SPK Rekomendasi Paket Desain (SAW)

Laravel 12 · PHP 8.2+ (diuji target PHP 8.4) · Composer 2.x · MySQL

## Instalasi
Ekstensi PHP yang dibutuhkan: `mbstring`, `openssl`, `pdo_mysql`, `fileinfo`, `tokenizer`, `xml`, `ctype`, `curl`.
```bash
composer install
cp .env.example .env && php artisan key:generate   # lalu isi DB_* dan ADMIN_PASSWORD
php artisan migrate --seed          # aman dijalankan berulang (seeder idempotent)
php artisan storage:link
npm install && npm run build
php artisan serve
```
Admin: `admin@gardenia.com` dengan password dari `ADMIN_PASSWORD` (default `admin123` hanya untuk lokal — wajib diganti).
Panel SPK admin: **Paket Desain** dan **Kriteria & Bobot** di sidebar.

## Cara kerja SPK (Simple Additive Weighting)
Kode: `app/Services/SawCalculator.php` (murni, tanpa DB, ada unit test). Definisi kriteria disimpan di tabel `saw_criteria`
(seeder: `database/seeders/SawCriteriaSeeder.php`) dan ditampilkan di panel admin, form SPK, serta halaman hasil.

**Alternatif:** paket desain aktif. **Data klien:** anggaran, luas bangunan, batas durasi (opsional).

| Kode | Kriteria | Jenis | Satuan | Sumber data | Cara pengukuran (x_ij) | Bobot awal |
|---|---|---|---|---|---|---|
| C1 | Kesesuaian Anggaran | Benefit | Indeks 0–1 | Input klien × rentang anggaran paket | `max(0, 1 − \|B − M\| / M)`, M = titik tengah rentang anggaran paket | 30% |
| C2 | Kesesuaian Luas Bangunan | Benefit | Indeks 0–1 | Input klien × rentang luas paket | rumus yang sama untuk luas (m²) | 25% |
| C3 | Durasi Pengerjaan | Cost | Bulan | Data paket | durasi pengerjaan paket | 20% |
| C4 | Kelengkapan Fitur Desain | Benefit | Skor 1–10 | Data paket (penilaian admin) | rubrik kelengkapan deliverable | 15% |
| C5 | Kualitas Material | Benefit | Skor 1–10 | Data paket (penilaian admin) | rubrik spesifikasi material | 10% |

**Rubrik skor C4 & C5** (agar penilaian konsisten antar paket): 1–3 dasar/ekonomis · 4–6 menengah · 7–8 tinggi · 9–10 komprehensif/premium.
Rincian rubrik dan alasan penentuan bobot tiap kriteria ada di halaman admin **Kriteria & Bobot**.

**Dasar bobot:** urutan prioritas anggaran → luas → durasi → fitur → material. Anggaran paling mengikat; kualitas material
paling kecil karena sudah sebagian tercermin pada tingkat anggaran paket (menghindari penghitungan ganda). Bobot dapat diubah admin
(total aktif harus 100%) dan **tidak ditimpa** saat `db:seed` dijalankan ulang; hanya definisi kriteria yang diperbarui.

Normalisasi: benefit `r = x / max(x)`, cost `r = min(x) / x`. Preferensi `V = Σ w·r`.

- Bobot dinormalisasi terhadap total kriteria **aktif**, sehingga V selalu 0–1.
- **Batas durasi** dari klien adalah kendala: paket yang melebihi diurutkan setelah yang memenuhi.
- **Konsep desain** tidak memengaruhi nilai (tidak ada data gaya per paket); dicatat sebagai brief di catatan checkout.
- V bersifat **relatif antar paket**, bukan persentase kecocokan. Sistem memberi peringatan bila input di luar cakupan paket.
- Hasil disimpan lengkap (snapshot) dan dibuka lewat `/spk-rekomendasi/hasil/{token}`.

## Test
```bash
php vendor/bin/phpunit      # memakai SQLite in-memory, tidak menyentuh database Anda
```

## Catatan upgrade (Laravel 9 → 12, PHP 8.4)
- Struktur aplikasi memakai gaya Laravel 11+: middleware, alias `admin`, redirect auth, dan rate limiter dikonfigurasi di `bootstrap/app.php` dan `AppServiceProvider`. `Http/Kernel`, `Console/Kernel`, `Exceptions/Handler`, dan provider lama sudah dihapus.
- Sanctum 3 → 4, PHPUnit 9 → 11, Collision 6 → 8. `laravel/breeze` dan `spatie/laravel-ignition` dihapus dari dependensi (scaffold Breeze sudah ada di kode; Ignition sudah bawaan framework).
- `.env` lama tetap kompatibel: cache/session default `file`, queue `sync`, tabel reset password tetap `password_resets`. `CACHE_DRIVER` lama tetap terbaca; nama baru `CACHE_STORE`.
- Dari upgrade pertama: hapus `vendor/` dan `bootstrap/cache/*.php` bila ada, lalu `composer update` (lock file lama dihapus karena untuk Laravel 9).
