<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('spk_results', function (Blueprint $table) {
            $table->uuid('token')->nullable()->unique()->after('id');
            // Snapshot lengkap perhitungan (kriteria, bobot, matriks, ranking, peringatan)
            // agar hasil bisa dibuka ulang persis seperti saat dihitung,
            // walaupun admin kemudian mengubah paket/bobot.
            $table->json('calculation')->nullable()->after('ranking_result');
        });

        // Beri token pada riwayat lama.
        DB::table('spk_results')->whereNull('token')->orderBy('id')->each(function ($row) {
            DB::table('spk_results')->where('id', $row->id)->update(['token' => (string) Str::uuid()]);
        });
    }

    public function down(): void
    {
        Schema::table('spk_results', function (Blueprint $table) {
            $table->dropUnique(['token']);
            $table->dropColumn(['token', 'calculation']);
        });
    }
};
