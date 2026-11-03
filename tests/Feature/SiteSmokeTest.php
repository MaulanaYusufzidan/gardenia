<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SiteSmokeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_public_pages_render(): void
    {
        foreach (['/', '/about', '/portfolio', '/contact', '/services', '/spk-rekomendasi', '/login', '/register', '/forgot-password'] as $u) {
            $this->get($u)->assertOk();
        }
        $this->get('/services/' . \App\Models\Service::first()->id)->assertOk();
    }

    private function makeOrder(User $u): Order
    {
        $o = Order::create(['user_id' => $u->id, 'order_number' => 'GSU-T-' . $u->id, 'project_name' => 'Rumah Budi',
            'project_address' => 'x', 'subtotal' => 100, 'tax' => 11, 'total' => 111, 'status' => 'pending']);
        $o->items()->create(['service_id' => null, 'name' => 'Paket', 'price' => 100, 'quantity' => 1, 'subtotal' => 100]);
        Payment::create(['order_id' => $o->id, 'payment_code' => 'PAY-T' . $u->id, 'method' => 'transfer',
            'stage' => 'dp', 'amount' => 33.3, 'status' => 'pending']);
        return $o;
    }

    public function test_user_pages_render(): void
    {
        $u = User::factory()->create();
        $o = $this->makeOrder($u);
        $this->actingAs($u);
        foreach (['/dashboard', '/cart', '/my-orders', "/my-orders/{$o->id}", '/profile'] as $url) {
            $this->get($url)->assertOk();
        }
        $this->get('/admin')->assertForbidden();
    }

    public function test_admin_pages_render_and_filters_combine(): void
    {
        $u = User::factory()->create(['name' => 'Budi']);
        $o = $this->makeOrder($u);
        $other = User::factory()->create(['name' => 'Budi Lain']);
        $o2 = $this->makeOrder($other); $o2->update(['status' => 'completed']);

        $admin = User::factory()->admin()->create();
        $this->actingAs($admin);
        foreach (['/admin', '/admin/orders', "/admin/orders/{$o->id}", '/admin/payments', '/admin/services', '/admin/users', "/admin/users/{$u->id}",
                  '/admin/payments/' . $o->payment->id] as $url) {
            $this->get($url)->assertOk();
        }
        // pencarian + status harus berlaku bersamaan (dulu status ditembus oleh orWhere)
        $this->get('/admin/orders?search=Budi&status=completed')->assertOk()
            ->assertSee('GSU-T-' . $other->id)->assertDontSee('GSU-T-' . $u->id);
    }

    public function test_payment_reject_then_reupload_and_verify_dp_creates_final(): void
    {
        Storage::fake('public');
        $u = User::factory()->create();
        $o = $this->makeOrder($u);
        $pay = $o->payment;

        $admin = User::factory()->admin()->create();
        $this->actingAs($admin)->patch("/admin/payments/{$pay->id}/reject");
        $this->assertSame('failed', $pay->fresh()->status);
        $this->actingAs($admin)->patch("/admin/payments/{$pay->id}/verify")->assertSessionHas('error');   // bukan pending

        $this->actingAs($u)->post("/payment/upload/{$o->id}", ['proof' => UploadedFile::fake()->image('b.jpg')])
            ->assertSessionHasNoErrors();
        $this->assertSame('pending', $pay->fresh()->status);

        $this->actingAs($admin)->patch("/admin/payments/{$pay->id}/verify");
        $this->assertSame('paid', $pay->fresh()->status);
        $this->assertSame(1, $o->payments()->where('stage', 'final')->count());
        $this->actingAs($admin)->patch("/admin/payments/{$pay->id}/verify");   // klik ganda tidak menggandakan
        $this->assertSame(1, $o->payments()->where('stage', 'final')->count());
    }

    public function test_cart_clear_requires_delete_method(): void
    {
        $this->actingAs(User::factory()->create());
        $this->get('/cart/clear')->assertStatus(405);
        $this->delete('/cart')->assertRedirect('/cart');
    }

    public function test_admin_spk_management(): void
    {
        $this->actingAs(User::factory()->admin()->create());
        foreach (['/admin/spk/packages', '/admin/spk/packages/create', '/admin/spk/criteria'] as $u) {
            $this->get($u)->assertOk();
        }
        $pkg = \App\Models\DesignPackage::first();
        $this->get("/admin/spk/packages/{$pkg->id}/edit")->assertOk();

        $payload = ['name' => 'Paket Baru', 'category' => 'Desain Rumah', 'budget_min' => 1e8, 'budget_max' => 5e7,
            'area_min' => 10, 'area_max' => 20, 'duration_months' => 2, 'feature_score' => 5, 'material_score' => 5, 'price_start' => 1e8];
        $this->post('/admin/spk/packages', $payload)->assertSessionHasErrors('budget_max');
        $payload['budget_max'] = 2e8;
        $this->post('/admin/spk/packages', $payload)->assertRedirect();
        $this->assertDatabaseHas('design_packages', ['name' => 'Paket Baru', 'is_active' => 0]);

        // total bobot harus 100
        $ids = \App\Models\SawCriteria::orderBy('code')->pluck('id', 'code');
        $bad = collect($ids)->map(fn ($id) => ['weight' => 10, 'is_active' => 1])->mapWithKeys(fn ($v, $k) => [$ids[$k] => $v])->all();
        $this->put('/admin/spk/criteria', ['criteria' => $bad])->assertSessionHasErrors('criteria');
        $good = [$ids['C1'] => ['weight' => 40, 'is_active' => 1], $ids['C2'] => ['weight' => 20, 'is_active' => 1],
                 $ids['C3'] => ['weight' => 20, 'is_active' => 1], $ids['C4'] => ['weight' => 10, 'is_active' => 1], $ids['C5'] => ['weight' => 10, 'is_active' => 1]];
        $this->put('/admin/spk/criteria', ['criteria' => $good])->assertSessionHasNoErrors();
        $this->assertEquals(40, \App\Models\SawCriteria::where('code', 'C1')->value('weight'));
    }
}
