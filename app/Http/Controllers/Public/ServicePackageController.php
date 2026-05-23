<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ServicePackage;

class ServicePackageController extends Controller
{
    public function index()
    {
        $packages = ServicePackage::query()
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('public.our-services.index', compact('packages'));
    }
}
