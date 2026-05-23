<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PropertyTypeController extends Controller
{
    public function index()
    {
        $types = PropertyType::latest()->get();
        return view('admin.property-types.index', compact('types'));
    }

    public function create()
    {
        return view('admin.property-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:property_types',
            'description' => 'nullable|string',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        PropertyType::create($validated);

        return redirect()->route('admin.property-types.index')->with('success', 'Property Type created successfully.');
    }

    public function edit(PropertyType $propertyType)
    {
        return view('admin.property-types.edit', compact('propertyType'));
    }

    public function update(Request $request, PropertyType $propertyType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:property_types,slug,' . $propertyType->id,
            'description' => 'nullable|string',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $propertyType->update($validated);

        return redirect()->route('admin.property-types.index')->with('success', 'Property Type updated successfully.');
    }

    public function destroy(PropertyType $propertyType)
    {
        if ($propertyType->properties()->exists()) {
             return back()->with('error', 'Cannot delete this type because it is used by properties.');
        }
        
        $propertyType->delete();

        return redirect()->route('admin.property-types.index')->with('success', 'Property Type deleted successfully.');
    }
}
