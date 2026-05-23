<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AdvisorGuide;

class BaliGuideController extends Controller
{
    public function index()
    {
        $guides = AdvisorGuide::where('is_active', true)
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->get();

        return view('public.advisor-guide.index', [
            'title' => 'Advisor Guide - PROSPEDITY',
            'guides' => $guides,
        ]);
    }

    public function show(AdvisorGuide $advisorGuide)
    {
        abort_unless($advisorGuide->is_active, 404);

        return view('public.advisor-guide.show', [
            'title' => $advisorGuide->title.' - PROSPEDITY',
            'guide' => $advisorGuide,
        ]);
    }

    public function villaSaleGuide()
    {
        return view('public.bali-guide.villa-sale-guide', [
            'title' => 'Bali Villa Sale Guide | PROSPEDITY',
        ]);
    }

    public function locationGuide()
    {
        return view('public.bali-guide.location-guide', [
            'title' => 'Bali Location Guide | PROSPEDITY',
        ]);
    }

    public function marketInsights()
    {
        return view('public.bali-guide.market-insights', [
            'title' => 'Bali Real Estate Market Insights | PROSPEDITY',
        ]);
    }
}
