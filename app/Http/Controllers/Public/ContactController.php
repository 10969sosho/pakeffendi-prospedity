<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Mail\InquiryMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('public.contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'required|string|max:20',
            'property_number' => 'nullable|string|max:255',
            'note' => 'required|string',
        ]);

        // Send email
        try {
            Mail::to(config('mail.from.address'))->send(new InquiryMail($validated));
            
            return back()->with('success', 'Terima kasih! Pesan Anda telah terkirim. Kami akan menghubungi Anda segera.');
        } catch (\Exception $e) {
            return back()->with('error', 'Maaf, terjadi kesalahan saat mengirim pesan. Silakan coba lagi.')->withInput();
        }
    }
}
