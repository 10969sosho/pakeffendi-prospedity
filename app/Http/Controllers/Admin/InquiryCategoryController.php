<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InquiryCategory;
use Illuminate\Http\Request;

class InquiryCategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        InquiryCategory::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.contact-settings.edit')->with('success', 'Inquiry Category added successfully.');
    }

    public function destroy(InquiryCategory $inquiryCategory)
    {
        $inquiryCategory->delete();
        return redirect()->route('admin.contact-settings.edit')->with('success', 'Inquiry Category deleted successfully.');
    }
}
