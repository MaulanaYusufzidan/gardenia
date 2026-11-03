<?php

namespace App\Http\Controllers;

use App\Models\DesignPackage;
use App\Models\SawCriteria;
use App\Models\SpkResult;
use App\Services\SawCalculator;
use Illuminate\Http\Request;
use InvalidArgumentException;

class SAWController extends Controller
{
    /** Pilihan konsep desain (disimpan sebagai brief untuk tim arsitek). */
    public const STYLES = [
        'minimalis'  => 'Minimalis Modern',
        'klasik'     => 'Klasik Elegan',
        'tropis'     => 'Tropis Kontemporer',
        'industrial' => 'Industrial Modern',
        'mediteran'  => 'Mediterania Resort',
        'bebas'      => 'Universal / Semua Gaya',
    ];

    public function __construct(private SawCalculator $saw)
    {
    }

    /** Form input. Mendukung ?from={token} untuk mengisi ulang dari hasil sebelumnya. */
    public function index(Request $request)
    {
        $criteria = SawCriteria::active()->orderBy('code')->get();
        $packages = DesignPackage::active()->orderBy('price_start')->get();

        $prefill = [];
        if ($request->filled('from')) {
            $previous = SpkResult::where('token', $request->query('from'))->first();
            if ($previous) {
                $prefill = [
                    'budget'           => (int) $previous->budget_input,
                    'area'             => $previous->area_input,
                    'duration_pref'    => $previous->duration_pref,
                    'style_preference' => $previous->style_preference,
                ];
            }
        }

        try {
            $weights = $criteria->isEmpty() ? [] : SawCalculator::effectiveWeights($criteria);
        } catch (InvalidArgumentException $e) {
            $weights = [];
        }

        return view('spk.index', [
            'criteria' => $criteria,
            'weights'  => $weights,
            'packages' => $packages,
            'prefill'  => $prefill,
            'styles'   => self::STYLES,
        ]);
    }

    /** Hitung → simpan → redirect ke hasil (Post-Redirect-Get): refresh tidak menggandakan riwayat. */
    public function calculate(Request $request)
    {
        $data = $request->validate([
            'budget'           => 'required|numeric|min:1000000|max:100000000000',
            'area'             => 'required|integer|min:20|max:5000',
            'duration_pref'    => 'nullable|integer|min:1|max:120',
            'style_preference' => 'nullable|in:' . implode(',', array_keys(self::STYLES)),
        ], [
            'budget.min' => 'Anggaran minimal Rp 1.000.000.',
            'budget.max' => 'Anggaran terlalu besar. Hubungi tim kami untuk proyek skala khusus.',
            'area.min'   => 'Luas bangunan minimal 20 m².',
            'area.max'   => 'Luas bangunan maksimal 5.000 m². Hubungi tim kami untuk proyek skala khusus.',
        ]);

        try {
            $calc = $this->saw->calculate(
                DesignPackage::active()->get(),
                SawCriteria::active()->get(),
                $data
            );
        } catch (InvalidArgumentException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        $ranking = $calc['ranking'];

        $result = SpkResult::create([
            'user_id'                => auth()->id(),
            'budget_input'           => $data['budget'],
            'area_input'             => $data['area'],
            'style_preference'       => $data['style_preference'] ?? null,
            'duration_pref'          => $data['duration_pref'] ?? null,
            'ranking_result'         => collect($ranking)->map(fn ($r) => [
                'rank'       => $r['rank'],
                'package_id' => $r['package']['id'],
                'name'       => $r['package']['name'],
                'score'      => round($r['score'], 6),
            ])->all(),
            'calculation'            => $calc,
            'recommended_package_id' => $ranking[0]['package']['id'] ?? null,
        ]);

        return redirect()->route('spk.show', $result);
    }

    /** Halaman hasil, diakses lewat token acak sehingga tamu pun bisa membukanya kembali. */
    public function show(SpkResult $result)
    {
        if (empty($result->calculation)) {
            return redirect()
                ->route('spk.index', ['from' => $result->token])
                ->with('error', 'Rincian perhitungan lama tidak tersimpan. Silakan hitung ulang dengan parameter yang sama.');
        }

        return view('spk.result', [
            'result'      => $result,
            'calc'        => $result->calculation,
            'styles'      => self::STYLES,
            'orderableIds' => DesignPackage::active()->pluck('id')->all(),
        ]);
    }

    public function history()
    {
        $histories = SpkResult::where('user_id', auth()->id())
            ->with('recommendedPackage')
            ->latest()
            ->paginate(10);

        return view('spk.history', ['histories' => $histories, 'styles' => self::STYLES]);
    }

    /** Masukkan paket SPK ke keranjang (layanan lain dipertahankan; hanya satu paket SPK per pesanan). */
    public function orderPackage(Request $request, DesignPackage $package)
    {
        abort_unless($package->is_active, 404);

        $cart = session()->get('cart', []);
        foreach (array_keys($cart) as $key) {
            if (str_starts_with((string) $key, 'spk_pkg_')) {
                unset($cart[$key]);
            }
        }
        $cart['spk_pkg_' . $package->id] = [
            'name'     => $package->name,
            'price'    => (float) $package->price_start,
            'quantity' => 1,
            'category' => 'Paket Desain SPK',
            'kbli'     => null,
        ];
        session()->put('cart', $cart);

        $notes  = null;
        $result = $request->filled('result')
            ? SpkResult::where('token', $request->input('result'))->first()
            : null;
        if ($result) {
            $parts = [
                'Dari rekomendasi SPK SAW: paket ' . $package->name,
                'Anggaran Rp ' . number_format($result->budget_input, 0, ',', '.'),
                'Luas ' . $result->area_input . ' m²',
            ];
            if ($result->duration_pref) {
                $parts[] = 'Target durasi maks. ' . $result->duration_pref . ' bulan';
            }
            if ($result->style_preference) {
                $parts[] = 'Konsep: ' . (self::STYLES[$result->style_preference] ?? $result->style_preference);
            }
            $notes = implode(' · ', $parts);
        }
        session()->put('checkout_prefill', ['notes' => $notes]);

        return redirect()->route('checkout.index')
            ->with('success', 'Paket "' . $package->name . '" ditambahkan. Lengkapi data checkout Anda.');
    }
}
