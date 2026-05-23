<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeSettingController extends Controller
{
    /**
     * Show the form for editing the home settings.
     */
    public function edit()
    {
        $setting = HomeSetting::first();

        return view('admin.settings.home', compact('setting'));
    }

    /**
     * Update the home settings.
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'hero_title' => ['nullable', 'string', 'max:255'],
            'hero_subtitle' => ['nullable', 'string'],
            'hero_background' => ['nullable', 'image', 'max:4096'], // 4MB
            'hero_logo' => ['nullable', 'image', 'max:2048'], // 2MB
            'navbar_title' => ['nullable', 'string', 'max:255'],
            'navbar_description' => ['nullable', 'string'],
            'facebook_url' => ['nullable', 'string', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'string', 'url', 'max:255'],
            'whatsapp_url' => ['nullable', 'string', 'max:255'], // Allow phone numbers
            'tiktok_url' => ['nullable', 'string', 'url', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'contact_title' => ['nullable', 'string', 'max:255'],
            'contact_description' => ['nullable', 'string'],
        ]);

        $setting = HomeSetting::first() ?? new HomeSetting();

        $setting->hero_title = $data['hero_title'] ?? null;
        $setting->hero_subtitle = $data['hero_subtitle'] ?? null;
        $setting->navbar_title = $data['navbar_title'] ?? null;
        $setting->navbar_description = $data['navbar_description'] ?? null;
        $setting->facebook_url = $data['facebook_url'] ?? null;
        $setting->instagram_url = $data['instagram_url'] ?? null;
        $setting->whatsapp_url = $data['whatsapp_url'] ?? null;
        $setting->tiktok_url = $data['tiktok_url'] ?? null;
        $setting->email = $data['email'] ?? null;
        $setting->contact_title = $data['contact_title'] ?? null;
        $setting->contact_description = $data['contact_description'] ?? null;

        if ($request->hasFile('hero_background')) {
            // Delete old file if exists
            if ($setting->hero_background) {
                Storage::disk('public')->delete($setting->hero_background);
            }

            $path = $request->file('hero_background')->store('home', 'public');
            $setting->hero_background = $path;
        }

        if ($request->hasFile('hero_logo')) {
            // Delete old file if exists
            if ($setting->hero_logo) {
                Storage::disk('public')->delete($setting->hero_logo);
            }

            $path = $request->file('hero_logo')->store('home', 'public');
            $setting->hero_logo = $path;
        }

        $setting->save();

        return redirect()
            ->route('admin.home-settings.edit')
            ->with('success', 'Home settings updated successfully.');
    }
}

