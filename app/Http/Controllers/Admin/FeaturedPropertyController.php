<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class FeaturedPropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $featuredProperties = Property::where('is_featured', true)
            ->orderBy('featured_order', 'asc')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('admin.featured-properties.index', compact('featuredProperties'));
    }

    /**
     * Update the order of the featured properties.
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:properties,id',
        ]);

        foreach ($request->order as $index => $id) {
            Property::where('id', $id)->update(['featured_order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from featured list.
     */
    public function destroy(Property $property)
    {
        // Check if property is actually featured to be safe, but not strictly necessary
        $property->update([
            'is_featured' => false,
            'featured_order' => null
        ]);

        return redirect()->back()->with('success', 'Property removed from featured list.');
    }
}
