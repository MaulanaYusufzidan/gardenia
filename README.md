# CV. Gardenia Setia Utama — Web & SPK Rekomendasi Paket Desain (SAW)

Laravel 9 · PHP ≥ 8.0.2 · MySQL

## Instalasi
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
Kode: `app/Services/SawCalculator.php` (murni, tanpa DB, ada unit test).

| Kode | Kriteria | Tipe | Nilai x_ij | Bobot awal |
|---|---|---|---|---|
| C1 | Kesesuaian anggaran | benefit | `max(0, 1 − |anggaran − titik tengah rentang paket| / titik tengah)` | 30% |
| C2 | Kesesuaian luas | benefit | rumus yang sama untuk luas | 25% |
| C3 | Durasi pengerjaan | cost | durasi paket (bulan) | 20% |
| C4 | Fitur desain | benefit | skor 1–10 | 15% |
| C5 | Kualitas material | benefit | skor 1–10 | 10% |

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
