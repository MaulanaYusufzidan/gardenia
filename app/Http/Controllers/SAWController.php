<?php
namespace App\Http\Controllers;

use App\Models\DesignPackage;
use App\Models\SawCriteria;
use App\Models\SpkResult;
use Illuminate\Http\Request;

class SAWController extends Controller
{
    /**
     * Halaman form input SPK
     */
    public function index()
    {
        return view('spk.index');
    }

    /**
     * Proses kalkulasi SAW dan tampilkan hasil ranking
     */
    public function calculate(Request $request)
    {
        $request->validate([
            'budget'           => 'required|numeric|min:1000000',
            'area'             => 'required|integer|min:20',
            'style_preference' => 'nullable|string',
            'duration_pref'    => 'nullable|integer|min:1',
        ]);

        // 1. Ambil semua paket aktif dan kriteria aktif
        $packages  = DesignPackage::where('is_active', true)->get();
        $criterias = SawCriteria::where('is_active', true)->get();

        if ($packages->isEmpty()) {
            return back()->with('error', 'Belum ada data paket desain tersedia. Hubungi administrator.');
        }

        // 2. Bangun matriks keputusan
        $matrix = [];
        foreach ($packages as $pkg) {
            $matrix[$pkg->id] = $this->buildDecisionVector($pkg, $request);
        }

        // 3. Normalisasi matriks
        //    benefit: r_ij = x_ij / max(x_j)
        //    cost:    r_ij = min(x_j) / x_ij
        $normalized = $this->normalize($matrix, $criterias);

        // 4. Hitung skor akhir V_i = Σ (w_j × r_ij)
        $scores = $this->calculateScores($normalized, $criterias);

        // 5. Ranking: sort descending berdasarkan skor
        arsort($scores);
        $ranking = [];
        $rank    = 1;
        foreach ($scores as $pkgId => $score) {
            $pkg       = $packages->firstWhere('id', $pkgId);
            $ranking[] = [
                'rank'       => $rank++,
                'package'    => $pkg,
                'score'      => round($score, 4),
                'score_pct'  => round($score * 100, 2),
                'normalized' => $normalized[$pkgId] ?? [],
                'raw'        => $matrix[$pkgId] ?? [],
            ];
        }

        // 6. Simpan histori hasil SPK (user login optional)
        $topId = $ranking[0]['package']->id ?? null;
        SpkResult::create([
            'user_id'                => auth()->id(),
            'budget_input'           => $request->budget,
            'area_input'             => $request->area,
            'style_preference'       => $request->style_preference,
            'duration_pref'          => $request->duration_pref,
            'ranking_result'         => collect($ranking)->map(fn($r) => [
                'rank'       => $r['rank'],
                'package_id' => $r['package']->id,
                'name'       => $r['package']->name,
                'score'      => $r['score'],
            ])->toArray(),
            'recommended_package_id' => $topId,
        ]);

        return view('spk.result', [
            'ranking'   => $ranking,
            'criterias' => $criterias,
            'input'     => $request->all(),
            'matrix'    => $matrix,
        ]);
    }

    // ─────────────────────────────────────────────────────────
    // PRIVATE HELPER METHODS
    // ─────────────────────────────────────────────────────────

    /**
     * Bangun vektor nilai paket berdasarkan input klien
     * Menghasilkan nilai mentah (x_ij) untuk tiap kriteria C1–C5
     */
    private function buildDecisionVector(DesignPackage $pkg, Request $req): array
    {
        $budget   = (float) $req->budget;
        $area     = (int)   $req->area;

        // C1 — Budget match (benefit)
        // Nilai = seberapa cocok budget klien dengan range paket (0–1)
        $budgetMid   = ($pkg->budget_min + $pkg->budget_max) / 2;
        $budgetMatch = ($budgetMid > 0)
            ? max(0, 1 - abs($budget - $budgetMid) / max($budgetMid, 1))
            : 0;

        // C2 — Luas bangunan match (benefit)
        // Nilai = seberapa cocok luas yg diinginkan dengan range paket (0–1)
        $areaMid   = ($pkg->area_min + $pkg->area_max) / 2;
        $areaMatch = ($areaMid > 0)
            ? max(0, 1 - abs($area - $areaMid) / max($areaMid, 1))
            : 0;

        // C3 — Durasi pengerjaan (cost): nilai = bulan pengerjaan
        $durationVal = $pkg->duration_months;

        // C4 — Skor fitur desain (benefit): skala 1–10
        $featureVal  = (float) $pkg->feature_score;

        // C5 — Kualitas material (benefit): skala 1–10
        $materialVal = (float) $pkg->material_score;

        return [
            'C1' => round($budgetMatch,   4),
            'C2' => round($areaMatch,     4),
            'C3' => round($durationVal,   4),
            'C4' => round($featureVal,    4),
            'C5' => round($materialVal,   4),
        ];
    }

    /**
     * Normalisasi matriks keputusan
     *
     * benefit: r_ij = x_ij / max(x_j)
     * cost:    r_ij = min(x_j) / x_ij
     */
    private function normalize(array $matrix, $criterias): array
    {
        $normalized = [];

        foreach ($criterias as $c) {
            $code   = $c->code;
            $values = array_map(fn($vec) => $vec[$code] ?? 0, $matrix);

            $maxVal = max($values) ?: 1;
            $minVal = min(array_filter($values, fn($v) => $v > 0)) ?: 1;

            foreach ($matrix as $pkgId => $vec) {
                $raw = $vec[$code] ?? 0;

                if ($c->type === 'benefit') {
                    $normalized[$pkgId][$code] = $maxVal > 0
                        ? round($raw / $maxVal, 4)
                        : 0;
                } else {
                    // cost criterion
                    $normalized[$pkgId][$code] = $raw > 0
                        ? round($minVal / $raw, 4)
                        : 0;
                }
            }
        }

        return $normalized;
    }

    /**
     * Hitung skor akhir setiap alternatif
     * V_i = Σ (w_j × r_ij)
     */
    private function calculateScores(array $normalized, $criterias): array
    {
        $scores = [];

        foreach ($normalized as $pkgId => $vec) {
            $total = 0;
            foreach ($criterias as $c) {
                $w      = (float) $c->weight / 100; // konversi persen ke desimal
                $r      = $vec[$c->code] ?? 0;
                $total += $w * $r;
            }
            $scores[$pkgId] = round($total, 6);
        }

        return $scores;
    }

    /**
     * Halaman histori kalkulasi SPK (perlu login)
     */
    public function history()
    {
        $histories = SpkResult::where('user_id', auth()->id())
                              ->with('recommendedPackage')
                              ->latest()
                              ->paginate(10);

        return view('spk.history', compact('histories'));
    }

    /**
     * Tambahkan paket desain hasil SPK ke keranjang dan redirect ke checkout
     */
    public function orderPackage(\App\Models\DesignPackage $package)
    {
        // Kosongkan cart lama, ganti dengan paket pilihan SPK
        $cart = [
            'spk_pkg_' . $package->id => [
                'name'     => '📐 ' . $package->name,
                'price'    => (float) $package->price_start,
                'quantity' => 1,
                'category' => 'Paket Desain SPK',
                'kbli'     => '-',
            ]
        ];
        session()->put('cart', $cart);

        return redirect()->route('checkout.index')
               ->with('success', 'Paket "' . $package->name . '" berhasil ditambahkan. Lengkapi data checkout Anda.');
    }
}
