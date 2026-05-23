<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PicProfile;
use Illuminate\Http\Request;

class PicProfileController extends Controller
{
    public function index()
    {
        $picProfiles = PicProfile::latest()->paginate(10);
        return view('admin.pic-profiles.index', compact('picProfiles'));
    }

    public function create()
    {
        return view('admin.pic-profiles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ref_number' => 'required|string|unique:pic_profiles,ref_number|max:255',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'whatsapp_number' => 'nullable|string|max:20',
        ]);

        PicProfile::create($validated);

        return redirect()->route('admin.pic-profiles.index')
            ->with('success', 'PIC Profile created successfully.');
    }

    public function edit(PicProfile $picProfile)
    {
        return view('admin.pic-profiles.edit', compact('picProfile'));
    }

    public function update(Request $request, PicProfile $picProfile)
    {
        $validated = $request->validate([
            'ref_number' => 'required|string|max:255|unique:pic_profiles,ref_number,' . $picProfile->id,
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'whatsapp_number' => 'nullable|string|max:20',
        ]);

        $picProfile->update($validated);

        return redirect()->route('admin.pic-profiles.index')
            ->with('success', 'PIC Profile updated successfully.');
    }

    public function destroy(PicProfile $picProfile)
    {
        $picProfile->delete();

        return redirect()->route('admin.pic-profiles.index')
            ->with('success', 'PIC Profile deleted successfully.');
    }
}
