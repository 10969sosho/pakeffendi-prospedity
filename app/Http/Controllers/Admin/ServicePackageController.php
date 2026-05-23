<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServicePackage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServicePackageController extends Controller
{
    public function index()
    {
        $packages = ServicePackage::query()
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.service-packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.service-packages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'normal_price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $maxOrder = ServicePackage::max('order') ?? 0;

        $slug = $this->generateUniqueSlug($validated['name']);

        ServicePackage::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'short_description' => $validated['short_description'] ?? null,
            'normal_price' => $validated['normal_price'],
            'discount_price' => $validated['discount_price'] ?? null,
            'is_active' => $request->has('is_active'),
            'order' => $maxOrder + 1,
        ]);

        return redirect()->route('admin.service-packages.index')
            ->with('success', 'Paket berhasil dibuat.');
    }

    public function edit(ServicePackage $servicePackage)
    {
        return view('admin.service-packages.edit', compact('servicePackage'));
    }

    public function update(Request $request, ServicePackage $servicePackage)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'normal_price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $slug = $servicePackage->slug;
        if ($servicePackage->name !== $validated['name']) {
            $slug = $this->generateUniqueSlug($validated['name'], $servicePackage->id);
        }

        $servicePackage->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'short_description' => $validated['short_description'] ?? null,
            'normal_price' => $validated['normal_price'],
            'discount_price' => $validated['discount_price'] ?? null,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.service-packages.index')
            ->with('success', 'Paket berhasil diupdate.');
    }

    public function destroy(ServicePackage $servicePackage)
    {
        $servicePackage->delete();

        return redirect()->route('admin.service-packages.index')
            ->with('success', 'Paket berhasil dihapus.');
    }

    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 2;

        while (ServicePackage::query()
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}
