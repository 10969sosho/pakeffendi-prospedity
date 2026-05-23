<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSetting;
use App\Models\InquiryCategory;
use Illuminate\Http\Request;

class ContactSettingController extends Controller
{
    /**
     * Show the form for editing the contact settings.
     */
    public function edit()
    {
        $setting = ContactSetting::first();
        $inquiryCategories = InquiryCategory::all();
        return view('admin.settings.contact', compact('setting', 'inquiryCategories'));
    }

    /**
     * Update the contact settings.
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'contact_title' => ['nullable', 'string', 'max:255'],
            'contact_description' => ['nullable', 'string'],
        ]);

        $setting = ContactSetting::first() ?? new ContactSetting();

        $setting->contact_title = $data['contact_title'] ?? null;
        $setting->contact_description = $data['contact_description'] ?? null;
        $setting->save();

        return redirect()
            ->route('admin.contact-settings.edit')
            ->with('success', 'Contact settings updated successfully.');
    }
}
