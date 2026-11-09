<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ServiceSeeder::class,
            SawSeeder::class,      // kriteria + paket desain SPK
            AdminSeeder::class,
        ]);
    }
}
