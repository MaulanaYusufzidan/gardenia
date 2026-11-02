<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gardenia.com'],
            [
                'name'     => 'Administrator',
                'email'    => 'admin@gardenia.com',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
                'is_active'=> true,
            ]
        );
        $this->command->info('Admin seeded: admin@gardenia.com / admin123');
    }
}
