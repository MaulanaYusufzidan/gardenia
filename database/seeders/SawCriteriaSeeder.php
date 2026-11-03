<?php

namespace Database\Seeders;

use App\Models\SawCriteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SawCriteriaSeeder extends Seeder
{
    /**
     * Seed kriteria SAW (C1–C5) sesuai bobot yang dipakai di
     * SAWController & halaman spk.index.
     */
    public function run(): void
    {
        $criterias = [
            [
                'code'        => 'C1',
                'name'        => 'Kesesuaian Anggaran',
                'weight'      => 30,
                'type'        => 'benefit',
                'description' => 'Kecocokan budget klien dengan rentang harga paket.',
                'is_active'   => true,
            ],
            [
                'code'        => 'C2',
                'name'        => 'Kesesuaian Luas Bangunan',
                'weight'      => 25,
                'type'        => 'benefit',
                'description' => 'Kecocokan luas bangunan yang diinginkan dengan rentang luas paket.',
                'is_active'   => true,
            ],
            [
                'code'        => 'C3',
                'name'        => 'Durasi Pengerjaan',
                'weight'      => 20,
                'type'        => 'cost',
                'description' => 'Lama waktu pengerjaan paket — semakin singkat semakin baik.',
                'is_active'   => true,
            ],
            [
                'code'        => 'C4',
                'name'        => 'Fitur Desain',
                'weight'      => 15,
                'type'        => 'benefit',
                'description' => 'Kelengkapan gambar kerja dan fitur desain paket.',
                'is_active'   => true,
            ],
            [
                'code'        => 'C5',
                'name'        => 'Kualitas Material',
                'weight'      => 10,
                'type'        => 'benefit',
                'description' => 'Skor kualitas spesifikasi material yang digunakan.',
                'is_active'   => true,
            ],
        ];

        foreach ($criterias as $criteria) {
            SawCriteria::updateOrCreate(
                ['code' => $criteria['code']],
                $criteria
            );
        }
    }
}