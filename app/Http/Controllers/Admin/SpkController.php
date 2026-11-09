<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DesignPackage;
use App\Models\SawCriteria;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/** Pengelolaan data master SPK: paket desain (alternatif) dan bobot kriteria. */
class SpkController extends Controller
{
    // ── Paket desain ─────────────────────────────────────────
    public function packages()
    {
        return view('admin.spk.packages', ['packages' => DesignPackage::orderBy('price_start')->get()]);
    }

    public function createPackage()
    {
        return view('admin.spk.package-form', ['package' => new DesignPackage(['is_active' => true, 'category' => 'Desain Rumah'])]);
    }

    public function storePackage(Request $request)
    {
        DesignPackage::create($this->validatedPackage($request));
        return redirect()->route('admin.spk.packages')->with('success', 'Paket desain berhasil ditambahkan.');
    }

    public function editPackage(DesignPackage $package)
    {
        return view('admin.spk.package-form', compact('package'));
    }

    public function updatePackage(Request $request, DesignPackage $package)
    {
        $package->update($this->validatedPackage($request));
        return redirect()->route('admin.spk.packages')->with('success', 'Paket desain berhasil diperbarui.');
    }

    public function togglePackage(DesignPackage $package)
    {
        $package->update(['is_active' => ! $package->is_active]);
        return back()->with('success', 'Status paket diperbarui.');
    }

    public function destroyPackage(DesignPackage $package)
    {
        $package->delete();   // riwayat SPK: recommended_package_id otomatis NULL
        return back()->with('success', 'Paket desain dihapus.');
    }

    private function validatedPackage(Request $request): array
    {
        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'category'        => 'required|string|max:255',
            'budget_min'      => 'required|numeric|min:0',
            'budget_max'      => 'required|numeric|gte:budget_min',
            'area_min'        => 'required|integer|min:0',
            'area_max'        => 'required|integer|gte:area_min',
            'duration_months' => 'required|integer|min:1|max:60',
            'feature_score'   => 'required|numeric|min:1|max:10',
            'material_score'  => 'required|numeric|min:1|max:10',
            'price_start'     => 'required|numeric|min:0',
            'description'     => 'nullable|string',
            'includes'        => 'nullable|string',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        return $data;
    }

    // ── Kriteria ─────────────────────────────────────────────
    public function criteria()
    {
        return view('admin.spk.criteria', ['criteria' => SawCriteria::orderBy('code')->get()]);
    }

    public function updateCriteria(Request $request)
    {
        $request->validate([
            'criteria'            => 'required|array',
            'criteria.*.weight'   => 'required|numeric|min:0|max:100',
        ]);

        $rows   = SawCriteria::all()->keyBy('id');
        $input  = $request->input('criteria', []);
        $total  = 0;
        foreach ($rows as $id => $row) {
            $active = isset($input[$id]['is_active']);
            if ($active) {
                $total += (float) ($input[$id]['weight'] ?? 0);
            }
        }
        if (abs($total - 100) > 0.01) {
            throw ValidationException::withMessages([
                'criteria' => 'Total bobot kriteria aktif harus tepat 100% (saat ini ' . round($total, 2) . '%).',
            ]);
        }

        foreach ($rows as $id => $row) {
            $row->update([
                'weight'    => $input[$id]['weight'] ?? $row->weight,
                'is_active' => isset($input[$id]['is_active']),
            ]);
        }

        return back()->with('success', 'Bobot kriteria berhasil disimpan.');
    }
}
