<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Definisi operasional kriteria SAW: satuan, sumber data, cara pengukuran,
 * dan dasar penentuan bobot, agar perhitungan dapat dipertanggungjawabkan.
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::table('saw_criteria', function (Blueprint $table) {
            $table->string('unit', 40)->nullable()->after('type');
            $table->string('data_source', 60)->nullable()->after('unit');
            $table->text('measurement')->nullable()->after('data_source');
            $table->text('rationale')->nullable()->after('measurement');
        });
    }

    public function down(): void
    {
        Schema::table('saw_criteria', function (Blueprint $table) {
            $table->dropColumn(['unit', 'data_source', 'measurement', 'rationale']);
        });
    }
};
