<?php

namespace App\Services;

use Illuminate\Support\Collection;
use InvalidArgumentException;

/**
 * Simple Additive Weighting (SAW) untuk rekomendasi paket desain.
 *
 * Alur perhitungan
 * ----------------
 * 1. Matriks keputusan X  : nilai x_ij tiap paket (alternatif) pada tiap kriteria.
 * 2. Normalisasi R        : benefit  r_ij = x_ij / max(x_j)
 *                           cost     r_ij = min(x_j) / x_ij
 * 3. Preferensi V         : V_i = Σ (w_j × r_ij)
 * 4. Ranking              : urut V_i menurun.
 *
 * Kriteria
 * --------
 *  C1  Kesesuaian anggaran  (benefit)  kedekatan anggaran klien ke titik tengah rentang paket
 *  C2  Kesesuaian luas      (benefit)  kedekatan luas klien ke titik tengah rentang paket
 *  C3  Durasi pengerjaan    (cost)     lama pengerjaan paket (bulan)
 *  C4  Fitur desain         (benefit)  skor 1–10
 *  C5  Kualitas material    (benefit)  skor 1–10
 *
 * Catatan desain
 * --------------
 * - Bobot dinormalisasi terhadap total bobot kriteria AKTIF, sehingga V_i selalu
 *   berada pada rentang 0–1 walaupun admin menonaktifkan kriteria atau total bobot ≠ 100.
 * - Tidak ada pembulatan di antara langkah perhitungan; pembulatan hanya untuk tampilan.
 * - "Batas durasi" dari klien diperlakukan sebagai kendala (constraint), bukan kriteria:
 *   paket yang melebihi batas diurutkan setelah paket yang memenuhi, dan diberi penanda.
 * - Kelas ini murni (tanpa akses database) agar mudah diuji.
 */
class SawCalculator
{
    /** Kecocokan (0–1) di bawah nilai ini dianggap rendah dan memicu peringatan. */
    public const LOW_FIT = 0.5;

    /** Kode kriteria yang dikenali mesin perhitungan. */
    public const CODES = ['C1', 'C2', 'C3', 'C4', 'C5'];

    /**
     * @param  Collection  $packages  koleksi DesignPackage (hanya yang aktif)
     * @param  Collection  $criteria  koleksi SawCriteria (hanya yang aktif)
     * @param  array       $input     budget, area, [duration_pref], [style_preference]
     *
     * @throws InvalidArgumentException bila data master belum lengkap
     */
    public function calculate(Collection $packages, Collection $criteria, array $input): array
    {
        $criteria = $criteria
            ->filter(fn ($c) => in_array($c->code, self::CODES, true))
            ->sortBy('code')
            ->values();

        if ($packages->isEmpty()) {
            throw new InvalidArgumentException('Belum ada paket desain aktif. Hubungi administrator.');
        }
        if ($criteria->isEmpty()) {
            throw new InvalidArgumentException('Belum ada kriteria SAW yang aktif. Hubungi administrator.');
        }

        $weights = self::effectiveWeights($criteria);   // [code => 0..1]

        $budget   = (float) $input['budget'];
        $area     = (float) $input['area'];
        $duration = isset($input['duration_pref']) && $input['duration_pref'] !== ''
            ? (int) $input['duration_pref']
            : null;

        // ── 1. Matriks keputusan X ──────────────────────────────────────
        $matrix = [];
        foreach ($packages as $pkg) {
            $matrix[$pkg->id] = [
                'C1' => self::closeness($budget, (float) $pkg->budget_min, (float) $pkg->budget_max),
                'C2' => self::closeness($area, (float) $pkg->area_min, (float) $pkg->area_max),
                'C3' => (float) $pkg->duration_months,
                'C4' => (float) $pkg->feature_score,
                'C5' => (float) $pkg->material_score,
            ];
        }

        // ── 2. Normalisasi R ────────────────────────────────────────────
        $normalized = [];
        foreach ($criteria as $c) {
            $column = array_column($matrix, $c->code);

            if ($c->type === 'cost') {
                $positives = array_filter($column, fn ($v) => $v > 0);
                $min       = $positives ? min($positives) : null;
                foreach ($matrix as $id => $row) {
                    $x = $row[$c->code];
                    $normalized[$id][$c->code] = ($min !== null && $x > 0) ? $min / $x : 0.0;
                }
            } else {
                $max = $column ? max($column) : 0.0;
                foreach ($matrix as $id => $row) {
                    $normalized[$id][$c->code] = $max > 0 ? $row[$c->code] / $max : 0.0;
                }
            }
        }

        // ── 3. Nilai preferensi V ───────────────────────────────────────
        $items = [];
        foreach ($packages as $pkg) {
            $weighted = [];
            $score    = 0.0;
            foreach ($criteria as $c) {
                $weighted[$c->code] = $weights[$c->code] * $normalized[$pkg->id][$c->code];
                $score += $weighted[$c->code];
            }

            $items[] = [
                'package'        => self::snapshot($pkg),
                'raw'            => $matrix[$pkg->id],
                'normalized'     => $normalized[$pkg->id],
                'weighted'       => $weighted,
                'score'          => $score,
                'meets_duration' => $duration === null ? null : $pkg->duration_months <= $duration,
                'budget_status'  => self::position($budget, (float) $pkg->budget_min, (float) $pkg->budget_max),
                'area_status'    => self::position($area, (float) $pkg->area_min, (float) $pkg->area_max),
            ];
        }

        // ── 4. Ranking (deterministik) ──────────────────────────────────
        usort($items, function ($a, $b) use ($duration) {
            if ($duration !== null && $a['meets_duration'] !== $b['meets_duration']) {
                return $a['meets_duration'] ? -1 : 1;           // yang memenuhi batas durasi lebih dulu
            }
            return [round($b['score'], 10), $b['raw']['C1'], $a['package']['id']]
               <=> [round($a['score'], 10), $a['raw']['C1'], $b['package']['id']];
        });
        foreach ($items as $i => &$item) {
            $item['rank'] = $i + 1;
        }
        unset($item);

        return [
            'criteria' => $criteria->map(fn ($c) => [
                'code'       => $c->code,
                'name'       => $c->name,
                'type'       => $c->type,
                'weight'     => (float) $c->weight,
                'weight_eff' => $weights[$c->code],
            ])->all(),
            'ranking'  => $items,
            'warnings' => $this->warnings($items, $packages, $budget, $area, $duration),
        ];
    }

    /**
     * Bobot efektif (0–1) = bobot / total bobot kriteria aktif.
     *
     * @return array<string,float>
     */
    public static function effectiveWeights(Collection $criteria): array
    {
        $total = (float) $criteria->sum(fn ($c) => (float) $c->weight);
        if ($total <= 0) {
            throw new InvalidArgumentException('Total bobot kriteria aktif harus lebih dari 0.');
        }

        return $criteria->mapWithKeys(fn ($c) => [$c->code => (float) $c->weight / $total])->all();
    }

    /**
     * Kedekatan nilai klien terhadap titik tengah rentang paket (0–1).
     * 1 = tepat di titik tengah; 0 = berjarak ≥ titik tengah itu sendiri.
     */
    public static function closeness(float $value, float $min, float $max): float
    {
        $mid = ($min + $max) / 2;

        return $mid > 0 ? max(0.0, 1 - abs($value - $mid) / $mid) : 0.0;
    }

    /** Posisi nilai klien terhadap rentang paket: below | within | above. */
    public static function position(float $value, float $min, float $max): string
    {
        return $value < $min ? 'below' : ($value > $max ? 'above' : 'within');
    }

    private static function snapshot($pkg): array
    {
        return [
            'id'              => $pkg->id,
            'name'            => $pkg->name,
            'category'        => $pkg->category,
            'description'     => $pkg->description,
            'includes'        => $pkg->includes,
            'budget_min'      => (float) $pkg->budget_min,
            'budget_max'      => (float) $pkg->budget_max,
            'area_min'        => (int) $pkg->area_min,
            'area_max'        => (int) $pkg->area_max,
            'duration_months' => (int) $pkg->duration_months,
            'feature_score'   => (float) $pkg->feature_score,
            'material_score'  => (float) $pkg->material_score,
            'price_start'     => (float) $pkg->price_start,
        ];
    }

    /**
     * Peringatan agar klien tidak salah membaca hasil. Nilai V bersifat RELATIF
     * (paket terbaik dibanding paket lain), bukan persentase kecocokan mutlak.
     *
     * @return string[]
     */
    private function warnings(array $items, Collection $packages, float $budget, float $area, ?int $duration): array
    {
        $rp = fn ($n) => 'Rp ' . number_format($n, 0, ',', '.');
        $w  = [];

        $minBudget = (float) $packages->min('budget_min');
        $maxBudget = (float) $packages->max('budget_max');
        $minArea   = (int) $packages->min('area_min');
        $maxArea   = (int) $packages->max('area_max');

        if ($budget < $minBudget) {
            $w[] = "Anggaran Anda ({$rp($budget)}) berada di bawah paket termurah ({$rp($minBudget)}). "
                 . 'Rekomendasi di bawah adalah paket yang paling mendekati, namun mungkin belum terjangkau.';
        } elseif ($budget > $maxBudget) {
            $w[] = "Anggaran Anda ({$rp($budget)}) melebihi rentang seluruh paket (maks. {$rp($maxBudget)}). "
                 . 'Disarankan berkonsultasi dengan tim kami untuk paket yang disesuaikan.';
        }

        if ($area < $minArea) {
            $w[] = "Luas {$area} m² lebih kecil dari cakupan seluruh paket (min. {$minArea} m²).";
        } elseif ($area > $maxArea) {
            $w[] = "Luas {$area} m² melebihi cakupan seluruh paket (maks. {$maxArea} m²). "
                 . 'Disarankan berkonsultasi dengan tim kami.';
        }

        if ($duration !== null && ! collect($items)->contains(fn ($i) => $i['meets_duration'])) {
            $w[] = "Tidak ada paket yang selesai dalam {$duration} bulan. Urutan tetap berdasarkan nilai SAW; "
                 . 'pertimbangkan memperlonggar target durasi.';
        }

        $top = $items[0] ?? null;
        if ($top && ($top['raw']['C1'] < self::LOW_FIT || $top['raw']['C2'] < self::LOW_FIT)) {
            $w[] = 'Paket teratas masih memiliki kecocokan anggaran/luas yang rendah terhadap kebutuhan Anda. '
                 . 'Nilai SAW bersifat relatif antar paket, bukan persentase kecocokan mutlak.';
        }

        return $w;
    }
}
