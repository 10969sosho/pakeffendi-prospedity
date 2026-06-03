<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Public\LandingPageController;
use App\Models\AdvisorGuide;
use App\Models\Property;

class SitemapController extends Controller
{
    public function index()
    {
        $properties = Property::where(function ($q) {
            $q->whereIn('property_status', ['AVAILABLE', 'SOLD', 'RENTED'])
                ->orWhereNull('property_status');
        })
            ->where(function ($q) {
                $q->whereNull('expired_date')
                    ->orWhere('expired_date', '>=', now()->toDateString());
            })
            ->whereNotNull('title')
            ->where('title', '!=', '')
            ->where(function ($q) {
                $q->whereHas('media', function ($mq) {
                    $mq->where('collection_name', 'photos');
                });
            })
            ->orderBy('updated_at', 'desc')
            ->get();

        $advisorGuides = AdvisorGuide::orderBy('updated_at', 'desc')->get();

        $landingPages = LandingPageController::getSitemapUrls();

        $content = view('sitemap', compact('properties', 'advisorGuides', 'landingPages'))->render();

        return response($content, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
        ]);
    }
}
