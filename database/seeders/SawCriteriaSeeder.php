<?php

namespace Database\Seeders;

use App\Models\SawCriteria;
use Illuminate\Database\Seeder;

class SawCriteriaSeeder extends Seeder
{
    /**
     * Kriteria SAW (C1–C5) beserta definisi operasionalnya.
     *
     * Seeder ini idempotent dan tidak menimpa keputusan admin:
     * bila kriteria sudah ada, hanya definisi (nama, satuan, cara pengukuran, dst.)
     * yang diperbarui; bobot dan status aktif milik admin dibiarkan.
     */
    public function run(): void
    {
        foreach ($this->definitions() as $def) {
            $existing = SawCriteria::where('code', $def['code'])->first();

            if ($existing) {
                $existing->update(collect($def)->except(['weight', 'is_active'])->all());
            } else {
                SawCriteria::create($def);
            }
        }
    }

    /** @return array<int, array<string, mixed>> */
    private function definitions(): array
    {
        return [
            [
                'code'        => 'C1',
                'name'        => 'Kesesuaian Anggaran',
                'type'        => 'benefit',
                'weight'      => 30,
                'is_active'   => true,
                'unit'        => 'Indeks 0–1',
                'data_source' => 'Input klien dan rentang anggaran paket',
                'description' => 'Apakah anggaran klien berada dalam rentang anggaran paket, dan seberapa jauh bila di luar.',
                'measurement' => 'x = 1 bila anggaran klien berada dalam rentang anggaran paket (min sampai maks). '
                               . 'Di luar rentang, x = max(0, 1 − jarak ke batas terdekat ÷ batas terdekat). '
                               . 'Contoh: rentang Rp 250–450 juta, anggaran Rp 200 juta → x = 0,8.',
                'rationale'   => 'Anggaran adalah batasan paling mengikat dalam keputusan klien; paket yang tidak terjangkau '
                               . 'atau jauh di atas kebutuhan tidak layak direkomendasikan. Diberi bobot tertinggi.',
            ],
            [
                'code'        => 'C2',
                'name'        => 'Kesesuaian Luas Bangunan',
                'type'        => 'benefit',
                'weight'      => 25,
                'is_active'   => true,
                'unit'        => 'Indeks 0–1',
                'data_source' => 'Input klien dan rentang luas paket',
                'description' => 'Apakah luas bangunan klien berada dalam rentang luas paket, dan seberapa jauh bila di luar.',
                'measurement' => 'x = 1 bila luas bangunan klien berada dalam rentang luas paket (min sampai maks). '
                               . 'Di luar rentang, x = max(0, 1 − jarak ke batas terdekat ÷ batas terdekat). '
                               . 'Contoh: rentang 90–150 m², luas 60 m² → x = 0,67.',
                'rationale'   => 'Luas bangunan menentukan skala dan kompleksitas desain sehingga memengaruhi kelayakan paket, '
                               . 'namun lebih fleksibel dibanding anggaran. Diberi bobot tertinggi kedua.',
            ],
            [
                'code'        => 'C3',
                'name'        => 'Durasi Pengerjaan',
                'type'        => 'cost',
                'weight'      => 20,
                'is_active'   => true,
                'unit'        => 'Bulan',
                'data_source' => 'Data paket (durasi pengerjaan)',
                'description' => 'Lama pengerjaan paket sejak kontrak hingga serah terima desain.',
                'measurement' => 'x = durasi pengerjaan paket dalam bulan (bilangan bulat). Karena bertipe cost, durasi yang lebih singkat '
                               . 'mendapat nilai ternormalisasi lebih tinggi (r = durasi terkecil ÷ durasi paket).',
                'rationale'   => 'Waktu berpengaruh pada jadwal pembangunan klien, tetapi biasanya dapat dinegosiasikan. '
                               . 'Batas durasi dari klien diberlakukan terpisah sebagai kendala, bukan sebagai bobot.',
            ],
            [
                'code'        => 'C4',
                'name'        => 'Kelengkapan Fitur Desain',
                'type'        => 'benefit',
                'weight'      => 15,
                'is_active'   => true,
                'unit'        => 'Skor 1–10',
                'data_source' => 'Data paket (penilaian admin)',
                'description' => 'Kelengkapan dokumen dan layanan desain yang termasuk dalam paket.',
                'measurement' => 'Skor 1–10 berdasarkan rubrik kelengkapan deliverable: '
                               . '1–3 = dokumen dasar (denah 2D, tampak, RAB dasar); '
                               . '4–6 = menengah (2D & 3D, tampak 4 sisi, RAB lengkap, konsultasi & pengawasan berkala); '
                               . '7–8 = lanjut (animasi 3D, RAB detail, pengawasan penuh, interior dasar); '
                               . '9–10 = komprehensif (VR tour, interior penuh, tim dedicated, rencana smart home).',
                'rationale'   => 'Kelengkapan fitur menambah nilai layanan, tetapi bersifat pelengkap setelah kesesuaian '
                               . 'anggaran, luas, dan waktu terpenuhi.',
            ],
            [
                'code'        => 'C5',
                'name'        => 'Kualitas Material',
                'type'        => 'benefit',
                'weight'      => 10,
                'is_active'   => true,
                'unit'        => 'Skor 1–10',
                'data_source' => 'Data paket (penilaian admin)',
                'description' => 'Tingkat kualitas spesifikasi material yang direkomendasikan paket.',
                'measurement' => 'Skor 1–10 berdasarkan rubrik spesifikasi material: '
                               . '1–3 = standar ekonomis; 4–6 = menengah (mid-range); '
                               . '7–8 = berkualitas tinggi; 9–10 = premium / impor atau sesuai permintaan khusus.',
                'rationale'   => 'Kualitas material ikut menentukan hasil akhir bangunan, tetapi sebagian besar sudah tercermin '
                               . 'pada tingkat anggaran paket sehingga bobotnya paling kecil agar tidak terjadi penghitungan ganda.',
            ],
        ];
    }
}
