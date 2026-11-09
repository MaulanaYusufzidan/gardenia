<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::latest();

        if ($request->search) {
            $query->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('category', 'like', '%'.$request->search.'%');
        }

        $services = $query->paginate(15)->withQueryString();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.form', ['service' => new Service]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        Service::create($data);
        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.form', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $this->validated($request, $service);

        if ($request->hasFile('image')) {
            if ($service->image) Storage::disk('public')->delete($service->image);
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($data);
        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Service $service)
    {
        if ($service->image) Storage::disk('public')->delete($service->image);
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil dihapus.');
    }

    public function toggleActive(Service $service)
    {
        $service->update(['is_active' => !$service->is_active]);
        $status = $service->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Layanan berhasil {$status}.");
    }

    private function validated(Request $request, ?Service $service = null): array
    {
        return $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|string|max:100',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'kbli_code'   => 'nullable|string|max:20',
            'is_active'   => 'boolean',
            'image'       => 'nullable|image|max:2048',
        ]);
    }
}
