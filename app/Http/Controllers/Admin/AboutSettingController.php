<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSetting;
use App\Models\InquiryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutSettingController extends Controller
{
    /**
     * Show the form for editing the about settings.
     */
    public function edit()
    {
        $setting = AboutSetting::first();
        $inquiryCategories = InquiryCategory::all();

        return view('admin.settings.about', compact('setting', 'inquiryCategories'));
    }

    /**
     * Update the about settings.
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'hero_background' => ['nullable', 'image', 'max:4096'], // 4MB
            'hero_title' => ['nullable', 'string', 'max:255'],
            'page_title' => ['nullable', 'string', 'max:255'],
            'page_description' => ['nullable', 'string'],
        ]);

        $setting = AboutSetting::first() ?? new AboutSetting();

        $setting->hero_title = $data['hero_title'] ?? null;
        $setting->page_title = $data['page_title'] ?? null;
        $setting->page_description = $data['page_description'] ?? null;

        if ($request->hasFile('hero_background')) {
            // Delete old file if exists
            if ($setting->hero_background) {
                Storage::disk('public')->delete($setting->hero_background);
            }

            $path = $request->file('hero_background')->store('about-us', 'public');
            $setting->hero_background = $path;
        }

        $setting->save();

        return redirect()
            ->route('admin.about-settings.edit')
            ->with('success', 'About Us settings updated successfully.');
    }
}
