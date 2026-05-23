<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OurService;
use Illuminate\Http\Request;

class OurServiceController extends Controller
{
    public function index()
    {
        $services = OurService::orderBy('order')->orderBy('created_at', 'desc')->get();
        return view('admin.our-services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.our-services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'reference_url' => 'nullable|url',
            'is_active' => 'boolean',
        ]);

        // Set order to last + 1
        $maxOrder = OurService::max('order') ?? 0;
        $validated['order'] = $maxOrder + 1;
        $validated['is_active'] = $request->has('is_active');

        OurService::create($validated);

        return redirect()->route('admin.our-services.index')
            ->with('success', 'Service created successfully.');
    }

    public function edit(OurService $ourService)
    {
        return view('admin.our-services.edit', compact('ourService'));
    }

    public function update(Request $request, OurService $ourService)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'reference_url' => 'nullable|url',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $ourService->update($validated);

        return redirect()->route('admin.our-services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(OurService $ourService)
    {
        $ourService->delete();

        return redirect()->route('admin.our-services.index')
            ->with('success', 'Service deleted successfully.');
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:our_services,id',
        ]);

        foreach ($request->order as $index => $id) {
            OurService::where('id', $id)->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}
