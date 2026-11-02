<?php
namespace Database\Seeders;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder {
    public function run(): void {
        $services = [
            [
                'name'        => 'Aktivitas Arsitektur',
                'category'    => 'Jasa',
                'kbli_code'   => '71101',
                'price'       => 50000000,
                'description' => 'Jasa perencanaan, perancangan, dan pengawasan arsitektur untuk berbagai jenis bangunan komersial maupun residensial.',
            ],
            [
                'name'        => 'Aktivitas Perancangan Khusus',
                'category'    => 'Jasa',
                'kbli_code'   => '74100',
                'price'       => 30000000,
                'description' => 'Jasa desain interior, desain grafis, dan perancangan khusus untuk ruang komersial dan hunian.',
            ],
            [
                'name'        => 'Dekorasi Eksterior',
                'category'    => 'Jasa',
                'kbli_code'   => '43305',
                'price'       => 25000000,
                'description' => 'Pekerjaan dekorasi eksterior bangunan termasuk fasad, ornamen, dan finishing eksterior berkualitas.',
            ],
            [
                'name'        => 'Perawatan dan Pemeliharaan Taman',
                'category'    => 'Jasa',
                'kbli_code'   => '81300',
                'price'       => 5000000,
                'description' => 'Jasa perawatan dan pemeliharaan taman, lansekap, dan ruang hijau untuk kawasan perumahan, perkantoran, dan komersial.',
            ],
        ];
        foreach ($services as $s) {
            Service::create(array_merge($s, ['is_active' => true]));
        }
    }
}
