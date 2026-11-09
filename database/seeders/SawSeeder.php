<?php
namespace Database\Seeders;

use App\Models\DesignPackage;
use Illuminate\Database\Seeder;

class SawSeeder extends Seeder
{
    public function run(): void
    {
        // Kriteria didefinisikan satu kali di SawCriteriaSeeder (idempotent).
        $this->call(SawCriteriaSeeder::class);

        // ── Paket Desain (Alternatif SAW) ─────────────────────
        $packages = [
            [
                'name'            => 'Paket Basic',
                'category'        => 'Desain Rumah',
                'budget_min'      => 150000000,
                'budget_max'      => 250000000,
                'area_min'        => 36,
                'area_max'        => 90,
                'duration_months' => 3,
                'feature_score'   => 4.0,
                'material_score'  => 4.0,
                'price_start'     => 150000000,
                'description'     => 'Paket desain rumah tipe ekonomis dengan material standar dan desain minimalis sederhana.',
                'includes'        => 'Denah 2D · Tampak depan · RAB dasar · Konsultasi 2x',
                'is_active'       => true,
            ],
            [
                'name'            => 'Paket Standard',
                'category'        => 'Desain Rumah',
                'budget_min'      => 250000000,
                'budget_max'      => 450000000,
                'area_min'        => 90,
                'area_max'        => 150,
                'duration_months' => 5,
                'feature_score'   => 6.0,
                'material_score'  => 6.0,
                'price_start'     => 250000000,
                'description'     => 'Paket desain rumah standar dengan material mid-range dan desain modern minimalis.',
                'includes'        => 'Denah 2D & 3D · Tampak 4 sisi · RAB lengkap · Konsultasi 5x · Pengawasan',
                'is_active'       => true,
            ],
            [
                'name'            => 'Paket Premium',
                'category'        => 'Desain Rumah',
                'budget_min'      => 450000000,
                'budget_max'      => 800000000,
                'area_min'        => 150,
                'area_max'        => 250,
                'duration_months' => 7,
                'feature_score'   => 8.0,
                'material_score'  => 8.0,
                'price_start'     => 450000000,
                'description'     => 'Paket desain rumah premium dengan material berkualitas tinggi dan desain eksklusif.',
                'includes'        => 'Denah 2D & 3D · Animasi 3D · RAB detail · Konsultasi unlimited · Pengawasan penuh · Interior dasar',
                'is_active'       => true,
            ],
            [
                'name'            => 'Paket Luxury',
                'category'        => 'Desain Rumah',
                'budget_min'      => 800000000,
                'budget_max'      => 2000000000,
                'area_min'        => 250,
                'area_max'        => 500,
                'duration_months' => 10,
                'feature_score'   => 9.5,
                'material_score'  => 9.5,
                'price_start'     => 800000000,
                'description'     => 'Paket desain rumah mewah dengan material premium impor dan konsep desain eksklusif.',
                'includes'        => 'Full 2D & 3D · VR Tour · RAB komprehensif · Tim arsitek dedicated · Interior full · Smart home plan',
                'is_active'       => true,
            ],
            [
                'name'            => 'Paket Custom',
                'category'        => 'Desain Rumah',
                'budget_min'      => 500000000,
                'budget_max'      => 5000000000,
                'area_min'        => 100,
                'area_max'        => 2000,
                'duration_months' => 12,
                'feature_score'   => 10.0,
                'material_score'  => 10.0,
                'price_start'     => 500000000,
                'description'     => 'Paket fully custom sesuai permintaan spesifik klien. Semua kebutuhan terpenuhi.',
                'includes'        => 'Semua fitur Luxury · Custom request unlimited · Dedicated project manager · Garansi revisi unlimited',
                'is_active'       => true,
            ],
        ];

        foreach ($packages as $p) {
            DesignPackage::updateOrCreate(['name' => $p['name']], $p);
        }
    }
}
