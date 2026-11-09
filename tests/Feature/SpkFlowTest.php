<?php

namespace Tests\Feature;

use App\Models\DesignPackage;
use App\Models\Order;
use App\Models\SpkResult;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpkFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_seeding_is_complete_and_idempotent(): void
    {
        $this->seed(DatabaseSeeder::class);   // kedua kali tidak boleh error / menggandakan
        $this->assertSame(5, DesignPackage::count());
        $this->assertSame(5, \App\Models\SawCriteria::count());
        $this->assertSame(1, User::where('role', 'admin')->count());
        $this->assertSame(4, \App\Models\Service::count());
    }

    public function test_form_shows_all_criteria_summing_100(): void
    {
        $this->get('/spk-rekomendasi')->assertOk()
            ->assertSee('Kesesuaian Anggaran')->assertSee('100%');
    }

    public function test_calculate_redirects_and_refresh_does_not_duplicate(): void
    {
        $res = $this->post('/spk-rekomendasi/calculate', ['budget' => 350000000, 'area' => 100]);
        $result = SpkResult::firstOrFail();
        $res->assertRedirect(route('spk.show', $result));

        $this->get(route('spk.show', $result))->assertOk()->assertSee('Paket Standard');
        $this->get(route('spk.show', $result))->assertOk();
        $this->assertSame(1, SpkResult::count());
        $this->assertSame('Paket Standard', $result->recommendedPackage->name);
    }

    public function test_result_page_shows_budget_criterion_in_matrix(): void
    {
        $this->post('/spk-rekomendasi/calculate', ['budget' => 350000000, 'area' => 100]);
        $this->get(route('spk.show', SpkResult::first()))->assertSee('Kesesuaian Anggaran');
    }

    public function test_validation(): void
    {
        $this->post('/spk-rekomendasi/calculate', ['budget' => 5, 'area' => 1])
            ->assertSessionHasErrors(['budget', 'area']);
        $this->post('/spk-rekomendasi/calculate', ['budget' => 3e8, 'area' => 100, 'style_preference' => 'xx'])
            ->assertSessionHasErrors('style_preference');
    }

    public function test_calculate_without_data_gives_friendly_error(): void
    {
        DesignPackage::query()->delete();
        $this->post('/spk-rekomendasi/calculate', ['budget' => 3e8, 'area' => 100])
            ->assertSessionHas('error');
    }

    public function test_guest_login_link_returns_to_result_after_login(): void
    {
        $this->post('/spk-rekomendasi/calculate', ['budget' => 350000000, 'area' => 100]);
        $result = SpkResult::first();
        $user = User::factory()->create();

        $this->get('/login?next=' . urlencode(route('spk.show', $result)))->assertOk();
        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect(route('spk.show', $result));
    }

    public function test_open_redirect_is_rejected(): void
    {
        $this->get('/login?next=' . urlencode('https://evil.example/x'));
        $user = User::factory()->create();
        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect('/dashboard');
    }

    public function test_history_requires_login_and_links_results(): void
    {
        $this->get('/spk-rekomendasi/history')->assertRedirect('/login');
        $user = User::factory()->create();
        $this->actingAs($user)->post('/spk-rekomendasi/calculate', ['budget' => 350000000, 'area' => 100]);
        $this->actingAs($user)->get('/spk-rekomendasi/history')->assertOk()->assertSee('Lihat Hasil');
        $this->get('/spk-rekomendasi?from=' . SpkResult::first()->token)->assertOk()->assertSee('350000000');
    }

    public function test_order_package_keeps_services_and_creates_order(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $service = \App\Models\Service::first();
        $this->post('/cart/add', ['service_id' => $service->id]);

        $this->post('/spk-rekomendasi/calculate', ['budget' => 350000000, 'area' => 100, 'style_preference' => 'tropis']);
        $result = SpkResult::first();
        $pkg = $result->recommendedPackage;

        $this->post(route('spk.orderPackage', $pkg), ['result' => $result->token])
            ->assertRedirect(route('checkout.index'));
        $this->assertCount(2, session('cart'));    // layanan lama tidak hilang

        $this->get('/checkout')->assertOk()->assertSee('Tropis Kontemporer');

        $this->post('/checkout', [
            'project_name' => 'Rumah Uji', 'project_address' => 'Jl. Uji 1',
            'payment_method' => 'transfer', 'payment_plan' => 'dp',
        ])->assertRedirect();

        $order = Order::with('items', 'payment')->firstOrFail();
        $this->assertCount(2, $order->items);
        $this->assertNull($order->items->firstWhere('name', $pkg->name)->service_id);
        $this->assertEqualsWithDelta($order->total * 0.3, $order->payment->amount, 0.01);
        $this->assertNull(session('cart'));
    }

    public function test_second_spk_package_replaces_first(): void
    {
        $this->actingAs(User::factory()->create());
        [$a, $b] = DesignPackage::take(2)->get();
        $this->post(route('spk.orderPackage', $a));
        $this->post(route('spk.orderPackage', $b));
        $this->assertCount(1, session('cart'));
    }

    public function test_inactive_package_cannot_be_ordered(): void
    {
        $this->actingAs(User::factory()->create());
        $p = DesignPackage::first(); $p->update(['is_active' => false]);
        $this->post(route('spk.orderPackage', $p))->assertNotFound();
    }
}
