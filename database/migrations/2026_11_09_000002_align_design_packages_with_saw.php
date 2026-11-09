<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;

/**
 * Menyelaraskan data paket desain dan definisi kriteria SAW dengan rumus kecocokan rentang
 * (rentang anggaran/luas berurutan tanpa tumpang tindih, skor Basic sesuai rubrik).
 * Memanggil SawSeeder yang idempotent: paket diperbarui menurut nama, bobot kriteria tidak ditimpa.
 */
return new class extends Migration {
    public function up(): void
    {
        Artisan::call('db:seed', ['--class' => 'SawSeeder', '--force' => true]);
    }

    public function down(): void
    {
        // Data tidak dikembalikan otomatis.
    }
};
