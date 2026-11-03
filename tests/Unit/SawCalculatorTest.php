<?php

namespace Tests\Unit;

use App\Services\SawCalculator;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class SawCalculatorTest extends TestCase
{
    private function pkg(int $id, array $o = []): object
    {
        return (object) array_merge([
            'id' => $id, 'name' => "P$id", 'category' => 'x', 'description' => '', 'includes' => '',
            'budget_min' => 100, 'budget_max' => 300, 'area_min' => 50, 'area_max' => 150,
            'duration_months' => 4, 'feature_score' => 5, 'material_score' => 5, 'price_start' => 100,
        ], $o);
    }

    private function crit(): Collection
    {
        return collect([
            (object) ['code' => 'C1', 'name' => 'a', 'type' => 'benefit', 'weight' => 30],
            (object) ['code' => 'C2', 'name' => 'b', 'type' => 'benefit', 'weight' => 25],
            (object) ['code' => 'C3', 'name' => 'c', 'type' => 'cost',    'weight' => 20],
            (object) ['code' => 'C4', 'name' => 'd', 'type' => 'benefit', 'weight' => 15],
            (object) ['code' => 'C5', 'name' => 'e', 'type' => 'benefit', 'weight' => 10],
        ]);
    }

    public function test_hand_computed_example(): void
    {
        // A: mid anggaran 200, B: mid 400. Klien: 200 m=100.
        $a = $this->pkg(1, ['budget_min' => 100, 'budget_max' => 300, 'area_min' => 50, 'area_max' => 150,
                            'duration_months' => 2, 'feature_score' => 4, 'material_score' => 4]);
        $b = $this->pkg(2, ['budget_min' => 300, 'budget_max' => 500, 'area_min' => 100, 'area_max' => 300,
                            'duration_months' => 4, 'feature_score' => 8, 'material_score' => 8]);

        $r = (new SawCalculator)->calculate(collect([$a, $b]), $this->crit(), ['budget' => 200, 'area' => 100]);

        // A: C1=1, C2=1, B: C1=1-200/400=.5, C2=1-100/200=.5
        // r A: 1,1,(2/2)=1,.5,.5 -> .3+.25+.2+.075+.05 = .875
        // r B: .5,.5,.5,1,1       -> .15+.125+.1+.15+.1 = .625
        $this->assertSame(1, $r['ranking'][0]['package']['id']);
        $this->assertEqualsWithDelta(0.875, $r['ranking'][0]['score'], 1e-9);
        $this->assertEqualsWithDelta(0.625, $r['ranking'][1]['score'], 1e-9);
    }

    public function test_weights_are_normalized_when_not_100(): void
    {
        $c = $this->crit()->map(fn ($x) => (object) array_merge((array) $x, ['weight' => $x->weight * 2]));
        $r = (new SawCalculator)->calculate(collect([$this->pkg(1)]), $c, ['budget' => 200, 'area' => 100]);
        $this->assertEqualsWithDelta(1.0, $r['ranking'][0]['score'], 1e-9);   // satu-satunya paket = ideal
    }

    public function test_inactive_criterion_does_not_break_score_range(): void
    {
        $c = $this->crit()->reject(fn ($x) => $x->code === 'C1')->values();
        $r = (new SawCalculator)->calculate(collect([$this->pkg(1), $this->pkg(2)]), $c, ['budget' => 200, 'area' => 100]);
        foreach ($r['ranking'] as $i) {
            
            $this->assertTrue($i["score"] <= 1.0 + 1e-9);
        }
    }

    public function test_duration_limit_ranks_meeting_packages_first(): void
    {
        $fast = $this->pkg(1, ['duration_months' => 3, 'feature_score' => 1, 'material_score' => 1,
                               'budget_min' => 10, 'budget_max' => 20, 'area_min' => 10, 'area_max' => 20]);
        $slow = $this->pkg(2, ['duration_months' => 9, 'feature_score' => 10, 'material_score' => 10]);
        $r = (new SawCalculator)->calculate(collect([$fast, $slow]), $this->crit(),
            ['budget' => 200, 'area' => 100, 'duration_pref' => 5]);
        $this->assertSame(1, $r['ranking'][0]['package']['id']);
        $this->assertTrue($r['ranking'][0]['meets_duration']);
        $this->assertFalse($r['ranking'][1]['meets_duration']);
    }

    public function test_all_zero_fit_does_not_crash(): void
    {
        $r = (new SawCalculator)->calculate(collect([$this->pkg(1), $this->pkg(2)]), $this->crit(),
            ['budget' => 1000000, 'area' => 5000]);
        $this->assertCount(2, $r['ranking']);
        $this->assertNotEmpty($r['warnings']);
    }

    public function test_deterministic_tie_break_by_id(): void
    {
        $r = (new SawCalculator)->calculate(collect([$this->pkg(2), $this->pkg(1)]), $this->crit(), ['budget' => 200, 'area' => 100]);
        $this->assertSame([1, 2], array_column(array_column($r['ranking'], 'package'), 'id'));
    }

    public function test_warns_when_budget_below_cheapest(): void
    {
        $r = (new SawCalculator)->calculate(collect([$this->pkg(1)]), $this->crit(), ['budget' => 10, 'area' => 100]);
        $this->assertStringContainsString('di bawah paket termurah', implode(' ', $r['warnings']));
    }

    public function test_requires_packages_and_criteria(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new SawCalculator)->calculate(collect(), $this->crit(), ['budget' => 1, 'area' => 1]);
    }
}
