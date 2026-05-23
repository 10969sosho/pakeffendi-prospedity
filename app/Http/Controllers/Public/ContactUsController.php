<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Mail\InquiryMail;
use App\Models\Inquiry;
use App\Models\ContactSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    public function index()
    {
        $contactSetting = ContactSetting::first();
        return view('public.contact', compact('contactSetting'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'property_number' => 'nullable|string|max:255',
            'note' => 'required|string',
        ]);

        // Create inquiry (inquiry_number will be auto-generated)
        $inquiry = Inquiry::create($validated);

        try {
            $toAddress = config('contact.to_address');
            $toName = config('contact.to_name');

            $data = array_merge($validated, [
                'inquiry_number' => $inquiry->inquiry_number,
            ]);

            $mailable = (new InquiryMail($data))->replyTo($validated['email'], $validated['name']);
            Mail::to($toAddress, $toName)->send($mailable);

            return redirect()->back()
                ->with('success', 'Thank you for your inquiry! We will contact you soon.');
        } catch (\Throwable $e) {
            return redirect()->back()
                ->with('error', 'Maaf, terjadi kesalahan saat mengirim pesan. Silakan coba lagi.')
                ->withInput();
        }
    }
}
