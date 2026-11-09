<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthAdminLayoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_auth_pages_use_the_brand_logo_and_indonesian_copy(): void
    {
        $this->get('/login')->assertOk()
            ->assertSee('images/logo/gardenia-logo.png', false)
            ->assertSee('Selamat datang kembali')
            ->assertSee('Lupa kata sandi?');

        $this->get('/register')->assertOk()->assertSee('Buat akun baru');
        $this->get('/forgot-password')->assertOk()->assertSee('Kirim Tautan Reset');
    }

    public function test_failed_login_shows_indonesian_message(): void
    {
        User::factory()->create(['email' => 'a@example.com']);

        $this->from('/login')->post('/login', ['email' => 'a@example.com', 'password' => 'salah-banget'])
            ->assertRedirect('/login')
            ->assertSessionHasErrors(['email' => 'Email atau kata sandi tidak sesuai dengan data kami.']);
    }

    public function test_admin_layout_shows_logo_and_user_menu(): void
    {
        $this->seed(DatabaseSeeder::class);
        $admin = User::factory()->admin()->create(['name' => 'Rina Admin']);

        $this->actingAs($admin)->get('/admin')->assertOk()
            ->assertSee('images/logo/gardenia-logo.png', false)
            ->assertSee('Panel Admin')
            ->assertSee('Selamat datang, Rina')
            ->assertSee('Keluar');
    }
}
