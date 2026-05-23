<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProperties = Property::count();
        $recentProperties = Property::latest()->take(5)->get();
        
        return view('admin.dashboard', compact('totalProperties', 'recentProperties'));
    }
}
