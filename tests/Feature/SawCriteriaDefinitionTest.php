<?php

namespace Tests\Feature;

use App\Models\SawCriteria;
use App\Models\SpkResult;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SawCriteriaDefinitionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_every_criterion_has_a_complete_operational_definition(): void
    {
        $this->assertSame(['C1', 'C2', 'C3', 'C4', 'C5'], SawCriteria::orderBy('code')->pluck('code')->all());

        foreach (SawCriteria::all() as $c) {
            $this->assertNotEmpty($c->unit, "{$c->code} tanpa satuan");
            $this->assertNotEmpty($c->data_source, "{$c->code} tanpa sumber data");
            $this->assertNotEmpty($c->measurement, "{$c->code} tanpa cara pengukuran");
            $this->assertNotEmpty($c->rationale, "{$c->code} tanpa dasar bobot");
        }

        $this->assertSame('cost', SawCriteria::where('code', 'C3')->value('type'));
        $this->assertEquals(100, SawCriteria::active()->sum('weight'));
    }

    public function test_reseeding_keeps_admin_weights_but_refreshes_definitions(): void
    {
        SawCriteria::where('code', 'C1')->update(['weight' => 40, 'measurement' => 'usang']);
        SawCriteria::where('code', 'C2')->update(['weight' => 20, 'is_active' => false]);

        $this->seed(DatabaseSeeder::class);

        $c1 = SawCriteria::where('code', 'C1')->first();
        $this->assertEquals(40, $c1->weight);
        $this->assertStringContainsString('titik tengah', $c1->measurement);
        $this->assertFalse(SawCriteria::where('code', 'C2')->first()->is_active);
        $this->assertSame(5, SawCriteria::count());
    }

    public function test_definitions_are_visible_to_admin_client_form_and_result(): void
    {
        $this->get('/spk-rekomendasi')->assertOk()->assertSee('Kelengkapan Fitur Desain')->assertSee('Skor 1–10');

        $this->post('/spk-rekomendasi/calculate', ['budget' => 350000000, 'area' => 100]);
        $this->get(route('spk.show', SpkResult::firstOrFail()))
            ->assertOk()->assertSee('Definisi Kriteria')->assertSee('titik tengah');

        $this->actingAs(User::factory()->admin()->create());
        $this->get('/admin/spk/criteria')->assertOk()
            ->assertSee('Definisi Operasional')->assertSee('Dasar bobot')->assertSee('rubrik');
    }
}
