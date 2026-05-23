<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\OurService;
use App\Models\AboutSetting;
use App\Models\InquiryCategory;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index()
    {
        $services = OurService::where('is_active', true)->orderBy('order')->get();
        $aboutSetting = AboutSetting::first();
        $inquiryCategories = InquiryCategory::all();
        
        return view('public.about-us.index', [
            'title' => 'Our Services - PROSPEDITY',
            'services' => $services,
            'aboutSetting' => $aboutSetting,
            'inquiryCategories' => $inquiryCategories
        ]);
    }

    public function villaRentals()
    {
        return view('public.about-us.villa-rentals', [
            'title' => 'Villa Rentals | PROSPEDITY'
        ]);
    }

    public function villaSales()
    {
        return view('public.about-us.villa-sales', [
            'title' => 'Villa Sales | PROSPEDITY'
        ]);
    }

    public function landSales()
    {
        return view('public.about-us.land-sales', [
            'title' => 'Land Sales | PROSPEDITY'
        ]);
    }

    public function notaryLawServices()
    {
        return view('public.about-us.notary-law-services', [
            'title' => 'Notary and Law Services | PROSPEDITY'
        ]);
    }

    public function managementConstruction()
    {
        return view('public.about-us.management-construction', [
            'title' => 'Management & Construction | PROSPEDITY'
        ]);
    }

    public function companyPresentation()
    {
        return view('public.about-us.company-presentation', [
            'title' => 'Company Presentation | PROSPEDITY'
        ]);
    }

    public function blog()
    {
        return view('public.about-us.blog', [
            'title' => 'Blog | PROSPEDITY'
        ]);
    }

    public function faq()
    {
        return view('public.about-us.faq', [
            'title' => 'FAQ | PROSPEDITY'
        ]);
    }
}

