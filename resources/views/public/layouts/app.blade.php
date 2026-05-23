<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BALI Properties')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @php
        // Ensure proper URL generation for assets
        $cssPath = asset('css/app.css');
        $jsPath = asset('js/app.js');
        
        // Add cache busting if file exists
        $cssVersion = file_exists(public_path('css/app.css')) ? filemtime(public_path('css/app.css')) : time();
        $jsVersion = file_exists(public_path('js/app.js')) ? filemtime(public_path('js/app.js')) : time();
    @endphp
    <link rel="stylesheet" href="{{ $cssPath }}?v={{ $cssVersion }}">
    <script src="{{ $jsPath }}?v={{ $jsVersion }}"></script>
    <style>
        /* Top Bar */
        .topbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 40px;
            background: #96A480;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            z-index: 99999;
        }

        /* Navbar */
        .navbar {
            position: fixed;
            top: 40px; /* turun 40px karena topbar */
            left: 0;
            right: 0;
            background: #96A480;
            color: white;
            transition: transform 0.25s ease, opacity 0.25s ease;
            z-index: 9999;
            will-change: transform, opacity;
        }

        /* Hide state: navbar geser ke atas tapi topbar tetap */
        .navbar.hide {
            transform: translateY(-100%);
            opacity: 0;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: calc(100% + 0.5rem);
            left: 50%;
            transform: translateX(-50%);
            background-color: #96A480;
            min-width: 250px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.2s ease-in-out;
            pointer-events: none;
            padding-top: 0.5rem;
        }
        .dropdown-menu.show {
            display: block;
            opacity: 1;
            pointer-events: auto;
        }
        .dropdown-menu a {
            display: block;
            padding: 0.75rem 1.5rem;
            color: white;
            text-decoration: none;
            transition: background-color 0.2s;
        }
        .dropdown-menu a:hover {
            background-color: #7A8A6A;
        }
        
        /* Nested dropdown (submenu) */
        .dropdown-item {
            position: relative;
        }
        .dropdown-item > a {
            display: block;
            padding: 0.75rem 1.5rem;
            color: white;
            text-decoration: none;
            transition: background-color 0.2s;
        }
        .dropdown-item > a:hover {
            background-color: #7A8A6A;
        }
        .dropdown-item.has-submenu > a::after {
            content: '›';
            float: right;
            font-size: 1.2em;
            margin-left: 1rem;
        }
        .dropdown-submenu {
            display: none;
            position: absolute;
            left: 100%;
            top: 0;
            background-color: #96A480;
            min-width: 200px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1001;
            opacity: 0;
            transition: opacity 0.2s ease-in-out;
            pointer-events: none;
            padding-top: 0.5rem;
            margin-left: 0.5rem;
        }
        .dropdown-item:hover .dropdown-submenu {
            display: block;
            opacity: 1;
            pointer-events: auto;
        }
        .dropdown-submenu a {
            display: block;
            padding: 0.75rem 1.5rem;
            color: white;
            text-decoration: none;
            transition: background-color 0.2s;
        }
        .dropdown-submenu a:hover {
            background-color: #7A8A6A;
        }
        /* Third level submenu */
        .dropdown-submenu-item {
            position: relative;
        }
        .dropdown-submenu-item > a::after {
            content: '›';
            float: right;
            font-size: 1.2em;
            margin-left: 1rem;
        }
        .dropdown-subsubmenu {
            display: none;
            position: absolute;
            left: 100%;
            top: 0;
            background-color: #96A480;
            min-width: 200px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1002;
            opacity: 0;
            transition: opacity 0.2s ease-in-out;
            pointer-events: none;
            padding-top: 0.5rem;
            margin-left: 0.5rem;
        }
        .dropdown-submenu-item:hover .dropdown-subsubmenu {
            display: block;
            opacity: 1;
            pointer-events: auto;
        }
        .dropdown-subsubmenu a {
            display: block;
            padding: 0.75rem 1.5rem;
            color: white;
            text-decoration: none;
            transition: background-color 0.2s;
        }
        .dropdown-subsubmenu a:hover {
            background-color: #7A8A6A;
        }
        
        /* Add invisible bridge to prevent gap between trigger and menu */
        .dropdown::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            height: 0.5rem;
            background: transparent;
            z-index: 999;
        }

        /* Padding untuk main content; untuk home kita biarkan 0 agar hero bisa menempel ke navbar */
        main {
            padding-top: 0;
            margin-top: 0;
        }
        
        /* Ensure all sections have proper spacing from navbar */
        section {
            margin-top: 0;
        }
        
        /* First section in content should have extra top margin */
        main > section:first-child {
            margin-top: 0;
        }

        /* Footer Noise Background */
        .bg-noise-svg {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- TOP BAR - Desktop -->
    <div class="topbar desktop-topbar">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-full">
                <!-- Left: Social Icons -->
                <div class="flex items-center space-x-4">
                    @if($homeSetting && $homeSetting->facebook_url)
                    <a href="{{ $homeSetting->facebook_url }}" target="_blank" class="text-white hover:text-gray-300 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    @endif
                    
                    @if($homeSetting && $homeSetting->instagram_url)
                    <a href="{{ $homeSetting->instagram_url }}" target="_blank" class="text-white hover:text-gray-300 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    @endif
                    
                    @if($homeSetting && $homeSetting->tiktok_url)
                    <a href="{{ $homeSetting->tiktok_url }}" target="_blank" class="text-white hover:text-gray-300 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                        </svg>
                    </a>
                    @endif

                    @if($homeSetting && $homeSetting->whatsapp_url)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $homeSetting->whatsapp_url) }}" target="_blank" class="text-white hover:text-gray-300 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                    </a>
                    @endif
                </div>

                <!-- Right: Actions & Language -->
                <div class="flex items-center space-x-4 text-sm text-white">
                    <!-- Links Removed -->
                </div>
            </div>
            </div>
        </div>
    </div>

    <!-- MOBILE TOP BAR - Simple with Hamburger -->
    <div class="mobile-topbar">
        <div class="w-full px-4 flex items-center justify-between h-full">
            <!-- Hamburger Menu Button -->
            <button id="mobile-menu-toggle" class="text-white p-2 hover:bg-[#7A8A6A] rounded transition-colors" onclick="toggleMobileMenu()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <div class="flex-1 flex items-center justify-center">
                @if($homeSetting && $homeSetting->hero_logo)
                    <div class="mobile-topbar-brand flex flex-col items-center justify-center leading-none">
                        <img src="{{ asset('storage/' . $homeSetting->hero_logo) }}" alt="Logo" class="mobile-topbar-logo w-auto object-contain" loading="lazy" decoding="async">
                        <div class="mobile-topbar-title text-white font-bold">{{ ($homeSetting && $homeSetting->navbar_title) ? $homeSetting->navbar_title : 'PROSPEDITY' }}</div>
                    </div>
                @else
                    <div class="text-white text-sm font-bold">{{ ($homeSetting && $homeSetting->navbar_title) ? $homeSetting->navbar_title : 'PROSPEDITY' }}</div>
                @endif
            </div>
            <!-- Spacer -->
            <div class="w-10"></div>
        </div>
    </div>

    <!-- Mobile Sidebar Menu -->
    <div id="mobile-sidebar" class="mobile-sidebar">
        <div class="mobile-sidebar-overlay" onclick="toggleMobileMenu()"></div>
        <div class="mobile-sidebar-content">
            <div class="mobile-sidebar-header">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-white">
                        <div class="text-xl font-bold tracking-wide">{{ ($homeSetting && $homeSetting->navbar_title) ? $homeSetting->navbar_title : 'PROSPEDITY' }}</div>
                        <div class="text-xs mt-1">{{ ($homeSetting && $homeSetting->navbar_description) ? $homeSetting->navbar_description : 'Prospedity Digital Properties' }}</div>
                    </div>
                    <button onclick="toggleMobileMenu()" class="text-white hover:text-gray-300 p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <nav class="mobile-sidebar-nav">
                <a href="{{ route('home') }}" class="mobile-nav-item {{ request()->routeIs('home') ? 'active' : '' }}" onclick="toggleMobileMenu()">
                    HOME
                </a>
                <div class="mobile-nav-dropdown">
                    <button class="mobile-nav-item mobile-nav-toggle" onclick="toggleMobileSubmenu(this)">
                        PROPERTIES
                        <svg class="w-4 h-4 ml-1 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="mobile-nav-submenu">
                        @forelse($propertyCategories ?? [] as $category)
                            <div class="mobile-nav-submenu-item">
                                <a href="{{ route('home', ['property_type' => $category['type']]) }}" class="mobile-nav-item" onclick="toggleMobileMenu()">{{ $category['label'] }}</a>
                                @if(!empty($category['categories']))
                                    <div class="mobile-nav-submenu-level2">
                                        @foreach($category['categories'] ?? [] as $catKey => $catLabel)
                                            <a href="{{ route('home', ['property_type' => $category['type'], 'property_category' => $catKey]) }}" class="mobile-nav-item" onclick="toggleMobileMenu()">{{ $catLabel }}</a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @empty
                            <a href="{{ route('home') }}" class="mobile-nav-item" onclick="toggleMobileMenu()">ALL PROPERTIES</a>
                        @endforelse
                    </div>
                </div>
                <a href="{{ route('advisor-guide') }}" class="mobile-nav-item {{ request()->routeIs('advisor-guide*') ? 'active' : '' }}" onclick="toggleMobileMenu()">
                    ADVISOR GUIDE
                </a>
                <a href="{{ route('featured-properties') }}" class="mobile-nav-item {{ request()->routeIs('featured-properties') ? 'active' : '' }}" onclick="toggleMobileMenu()">
                    FEATURED PROPERTIES
                </a>
                <a href="{{ route('successful-properties') }}" class="mobile-nav-item {{ request()->routeIs('successful-properties') ? 'active' : '' }}" onclick="toggleMobileMenu()">
                    SUCCESSFUL PROPERTIES
                </a>
                <a href="{{ route('our-services') }}" class="mobile-nav-item {{ request()->routeIs('our-services') ? 'active' : '' }}" onclick="toggleMobileMenu()">
                    OUR SERVICE
                </a>
                <a href="{{ route('about-us') }}" class="mobile-nav-item {{ request()->routeIs('about-us') ? 'active' : '' }}" onclick="toggleMobileMenu()">
                    CONTACT US
                </a>
            </nav>
        </div>
    </div>

    <!-- NAVBAR -->
    <nav class="navbar" id="navbar">
        <!-- Logo Area -->
        <div class="logo-area py-4 border-b border-gray-700">
            <div class="w-full px-4 sm:px-6 lg:px-8">
                <div class="flex justify-center">
                    <a href="{{ route('home') }}" class="text-center">
                        <!-- Logo Icon - Geometric Diamond Shapes -->
                        <div class="flex justify-center items-center mb-2 space-x-1">
                            @if($homeSetting && $homeSetting->hero_logo)
                                <img src="{{ asset('storage/' . $homeSetting->hero_logo) }}" alt="Logo" class="h-32 object-contain">
                            @else
                                <svg class="w-8 h-8 text-white transform rotate-45" fill="currentColor" viewBox="0 0 24 24">
                                    <rect x="8" y="8" width="8" height="8"/>
                                </svg>
                                <svg class="w-10 h-10 text-white transform rotate-45" fill="currentColor" viewBox="0 0 24 24">
                                    <rect x="7" y="7" width="10" height="10"/>
                                </svg>
                                <svg class="w-8 h-8 text-white transform rotate-45" fill="currentColor" viewBox="0 0 24 24">
                                    <rect x="8" y="8" width="8" height="8"/>
                                </svg>
                            @endif
                        </div>
                        <!-- Logo Text -->
                        <div class="text-white">
                            <div class="text-2xl font-bold tracking-wide">{{ ($homeSetting && $homeSetting->navbar_title) ? $homeSetting->navbar_title : 'PROSPEDITY' }}</div>
                            <div class="text-sm mt-1">{{ ($homeSetting && $homeSetting->navbar_description) ? $homeSetting->navbar_description : 'Prospedity Digital Properties' }}</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Navigation Bar -->
        <div class="border-t border-gray-700">
            <div class="w-full px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-center space-x-6 h-12">
                    <a href="{{ route('home') }}" class="text-white uppercase text-sm font-medium hover:text-gray-300 transition-colors">HOME</a>
                    <div class="dropdown relative">
                        <a href="#" class="text-white uppercase text-sm font-medium hover:text-gray-300 transition-colors flex items-center">
                            PROPERTIES
                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </a>
                        <div class="dropdown-menu">
                            @forelse($propertyCategories ?? [] as $category)
                                <div class="dropdown-item has-submenu">
                                    <a href="{{ route('home', ['property_type' => $category['type']]) }}">{{ $category['label'] }}</a>
                                    <div class="dropdown-submenu">
                                        @foreach($category['categories'] ?? [] as $catKey => $catLabel)
                                            <div class="dropdown-submenu-item">
                                                <a href="{{ route('home', ['property_type' => $category['type'], 'property_category' => $catKey]) }}">{{ $catLabel }}</a>
                                                <div class="dropdown-subsubmenu">
                                                    @foreach($category['locations'] ?? [] as $location)
                                                        <a href="{{ route('home', ['property_type' => $category['type'], 'property_category' => $catKey, 'location' => $location['city']]) }}">
                                                            {{ $location['city'] }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @empty
                                <div class="dropdown-item">
                                    <a href="{{ route('home') }}">ALL PROPERTIES</a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <a href="{{ route('advisor-guide') }}" class="text-white uppercase text-sm font-medium hover:text-gray-300 transition-colors {{ request()->routeIs('advisor-guide*') ? 'text-gray-300' : '' }}">ADVISOR GUIDE</a>
                    <a href="{{ route('featured-properties') }}" class="text-white uppercase text-sm font-medium hover:text-gray-300 transition-colors {{ request()->routeIs('featured-properties') ? 'text-gray-300' : '' }}">
                        FEATURED PROPERTIES
                    </a>
                    <a href="{{ route('successful-properties') }}" class="text-white uppercase text-sm font-medium hover:text-gray-300 transition-colors">SUCCESSFUL PROPERTIES</a>
                    <a href="{{ route('our-services') }}" class="text-white uppercase text-sm font-medium hover:text-gray-300 transition-colors {{ request()->routeIs('our-services') ? 'text-gray-300' : '' }}">OUR SERVICE</a>
                    <a href="{{ route('about-us') }}" class="text-white uppercase text-sm font-medium hover:text-gray-300 transition-colors {{ request()->routeIs('about-us') ? 'text-gray-300' : '' }}">CONTACT US</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <!-- Filter Banner Section -->
        @if(isset($filterInfo) && (request()->has('property_type') || request()->has('location') || request()->has('property_status') || request()->has('search_type')))
            @php
                $propertyType = $filterInfo['property_type'] ?? null;
                $location = $filterInfo['location'] ?? null;
                $propertyStatus = $filterInfo['property_status'] ?? null;
                $searchType = $filterInfo['search_type'] ?? 'sale';
                $totalCount = $filterInfo['total_count'] ?? 0;
                
                // Map property types to Indonesian
                $typeMap = [
                    'villas' => 'Villa',
                    'apartments' => 'Apartemen',
                    'houses' => 'Rumah',
                    'land' => 'Tanah'
                ];
                
                // Map property status to Indonesian
                $statusMap = [
                    'monthly' => 'Bulanan',
                    'yearly' => 'Tahunan',
                    'freehold' => 'Freehold',
                    'leasehold' => 'Leasehold'
                ];
                
                // Build title based on filters
                $titleParts = [];
                
                if ($searchType === 'rental') {
                    if ($propertyType) {
                        $typeLabel = $typeMap[$propertyType] ?? ucfirst($propertyType);
                        if ($propertyStatus === 'monthly') {
                            $titleParts[] = $typeLabel . ' & Rumah Disewakan Bulanan';
                        } elseif ($propertyStatus === 'yearly') {
                            $titleParts[] = $typeLabel . ' & Rumah Disewakan Tahunan';
                        } else {
                            $titleParts[] = $typeLabel . ' & Rumah Disewakan';
                        }
                    } else {
                        if ($propertyStatus === 'monthly') {
                            $titleParts[] = 'Villa & Rumah Disewakan Bulanan';
                        } elseif ($propertyStatus === 'yearly') {
                            $titleParts[] = 'Villa & Rumah Disewakan Tahunan';
                        } else {
                            $titleParts[] = 'Villa & Rumah Disewakan';
                        }
                    }
                } else {
                    if ($propertyType) {
                        $typeLabel = $typeMap[$propertyType] ?? ucfirst($propertyType);
                        $titleParts[] = $typeLabel . ' Dijual';
                    } else {
                        $titleParts[] = 'Properti Dijual';
                    }
                }
                
                if ($location) {
                    $titleParts[] = 'di ' . ucwords($location);
                }
                
                $title = implode(' ', $titleParts);
                
                // Build subtitle
                $subtitleParts = [];
                $subtitleParts[] = $totalCount . '+';
                
                if ($propertyType) {
                    $typeLabel = $typeMap[$propertyType] ?? ucfirst($propertyType);
                    $subtitleParts[] = $typeLabel . ' & Rumah';
                } else {
                    $subtitleParts[] = 'Villa & Rumah';
                }
                
                if ($location) {
                    $subtitleParts[] = 'di ' . ucwords($location);
                }
                
                if ($searchType === 'rental') {
                    if ($propertyStatus === 'monthly') {
                        $subtitleParts[] = 'Tersedia untuk Disewakan Bulanan';
                    } elseif ($propertyStatus === 'yearly') {
                        $subtitleParts[] = 'Tersedia untuk Disewakan Tahunan';
                    } else {
                        $subtitleParts[] = 'Tersedia untuk Disewakan';
                    }
                } else {
                    $subtitleParts[] = 'Tersedia untuk Dijual';
                }
                
                $subtitle = implode(' ', $subtitleParts);
            @endphp
            
            @php
                $heroBackground = ($homeSetting && $homeSetting->hero_background) 
                    ? asset('storage/' . $homeSetting->hero_background) 
                    : null;
            @endphp
            <section class="relative h-96 bg-cover bg-center -mt-[180px]" @if($heroBackground) style="background-image: url('{{ $heroBackground }}');" @else style="background-color: #96A480;" @endif>
                <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                <div class="relative h-full flex flex-col items-center justify-center text-center px-4">
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 uppercase tracking-wide">
                        {{ $title }}
                    </h1>
                    <p class="text-base md:text-lg text-white mb-8 max-w-4xl">
                        {{ $subtitle }}
                    </p>
                    <div class="animate-bounce mt-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </section>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="relative text-gray-100 mt-16 font-light overflow-hidden">
        <!-- Gradient Background with Noise -->
        <div class="absolute inset-0 bg-gradient-to-br from-[#96A480] via-[#7A8C65] to-[#566845] z-0"></div>
        <div class="absolute inset-0 opacity-[0.03] z-0 pointer-events-none bg-noise-svg"></div>
        
        <!-- Content -->
        <div class="relative z-10 max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 py-20">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-12 lg:gap-16">
                
                <!-- Brand Section (4 cols) -->
                <div class="md:col-span-4 space-y-6">
                    <div>
                        <h3 class="text-white text-3xl md:text-4xl font-bold tracking-widest uppercase font-serif">PROSPEDITY</h3>
                        <p class="text-xs text-white/60 tracking-[0.2em] uppercase mt-1">Digital Properties Bali</p>
                    </div>
                    <p class="text-sm leading-relaxed text-gray-100/90 font-light max-w-sm">
                        Curating exceptional villas and investment properties in Bali's most sought-after locations. Experience the art of tropical living.
                    </p>
                    
                    <!-- CTA Button -->
                    <div class="pt-4">
                        @if($homeSetting && $homeSetting->whatsapp_url)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $homeSetting->whatsapp_url) }}" target="_blank" class="inline-flex items-center space-x-2 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/30 text-white px-6 py-3 rounded-full transition-all duration-300 group hover:shadow-[0_0_20px_rgba(255,255,255,0.15)]">
                                <span class="text-sm font-medium tracking-wide">Talk to Our Advisor</span>
                                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                        @else
                            <a href="{{ route('contact-us') }}" class="inline-flex items-center space-x-2 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/30 text-white px-6 py-3 rounded-full transition-all duration-300 group hover:shadow-[0_0_20px_rgba(255,255,255,0.15)]">
                                <span class="text-sm font-medium tracking-wide">Talk to Our Advisor</span>
                                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Quick Links (3 cols) -->
                <div class="md:col-span-3 md:pl-8">
                    <h4 class="text-white text-xs font-bold uppercase tracking-[0.15em] mb-8 text-white/80">Discover</h4>
                    <ul class="space-y-4">
                        <li><a href="{{ route('home') }}" class="text-sm text-gray-200 hover:text-white transition-all duration-300 hover:tracking-wide flex items-center group"><span class="w-0 overflow-hidden group-hover:w-3 transition-all duration-300 h-px bg-white mr-0 group-hover:mr-2"></span>Home</a></li>
                        <li><a href="{{ route('home') }}" class="text-sm text-gray-200 hover:text-white transition-all duration-300 hover:tracking-wide flex items-center group"><span class="w-0 overflow-hidden group-hover:w-3 transition-all duration-300 h-px bg-white mr-0 group-hover:mr-2"></span>Properties</a></li>
                        <li><a href="{{ route('home', ['property_tag' => 'featured']) }}" class="text-sm text-gray-200 hover:text-white transition-all duration-300 hover:tracking-wide flex items-center group"><span class="w-0 overflow-hidden group-hover:w-3 transition-all duration-300 h-px bg-white mr-0 group-hover:mr-2"></span>Featured</a></li>
                        <li><a href="{{ route('successful-properties') }}" class="text-sm text-gray-200 hover:text-white transition-all duration-300 hover:tracking-wide flex items-center group"><span class="w-0 overflow-hidden group-hover:w-3 transition-all duration-300 h-px bg-white mr-0 group-hover:mr-2"></span>Successful Cases</a></li>
                        <li><a href="{{ route('advisor-guide') }}" class="text-sm text-gray-200 hover:text-white transition-all duration-300 hover:tracking-wide flex items-center group"><span class="w-0 overflow-hidden group-hover:w-3 transition-all duration-300 h-px bg-white mr-0 group-hover:mr-2"></span>Advisor Guide</a></li>
                    </ul>
                </div>

                <!-- Contact & Social (5 cols) -->
                <div class="md:col-span-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                        <!-- Contact Info -->
                        <div>
                            <h4 class="text-white text-xs font-bold uppercase tracking-[0.15em] mb-8 text-white/80">Contact</h4>
                            <ul class="space-y-6">
                                @if($homeSetting && $homeSetting->email)
                                <li>
                                    <a href="mailto:{{ $homeSetting->email }}" class="group block">
                                        <span class="text-xs text-white/50 uppercase tracking-wider block mb-1 group-hover:text-white/80 transition-colors">Email Us</span>
                                        <span class="text-sm text-white border-b border-transparent group-hover:border-white/40 pb-0.5 transition-all">{{ $homeSetting->email }}</span>
                                    </a>
                                </li>
                                @endif
                                
                                @if($homeSetting && $homeSetting->whatsapp_url)
                                <li>
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $homeSetting->whatsapp_url) }}" target="_blank" class="group block">
                                        <span class="text-xs text-white/50 uppercase tracking-wider block mb-1 group-hover:text-white/80 transition-colors">WhatsApp</span>
                                        <span class="text-sm text-white border-b border-transparent group-hover:border-white/40 pb-0.5 transition-all">Chat Now</span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>

                        <!-- Social Icons -->
                        <div>
                            <h4 class="text-white text-xs font-bold uppercase tracking-[0.15em] mb-8 text-white/80">Follow Us</h4>
                            <div class="flex flex-wrap gap-4">
                                @if($homeSetting && $homeSetting->instagram_url)
                                <a href="{{ $homeSetting->instagram_url }}" target="_blank" class="w-12 h-12 flex items-center justify-center rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white hover:bg-white hover:text-[#566845] hover:scale-110 hover:shadow-[0_0_15px_rgba(255,255,255,0.3)] transition-all duration-300 group" aria-label="Instagram">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </a>
                                @endif

                                @if($homeSetting && $homeSetting->facebook_url)
                                <a href="{{ $homeSetting->facebook_url }}" target="_blank" class="w-12 h-12 flex items-center justify-center rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white hover:bg-white hover:text-[#566845] hover:scale-110 hover:shadow-[0_0_15px_rgba(255,255,255,0.3)] transition-all duration-300 group" aria-label="Facebook">
                                    <span class="font-bold text-lg">f</span>
                                </a>
                                @endif

                                @if($homeSetting && $homeSetting->tiktok_url)
                                <a href="{{ $homeSetting->tiktok_url }}" target="_blank" class="w-12 h-12 flex items-center justify-center rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white hover:bg-white hover:text-[#566845] hover:scale-110 hover:shadow-[0_0_15px_rgba(255,255,255,0.3)] transition-all duration-300 group" aria-label="TikTok">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-white/10 mt-16 pt-8 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0 text-xs text-white/40 tracking-wider font-light">
                <p>&copy; {{ date('Y') }} Prospedity Digital Properties. All rights reserved.</p>
                <div class="flex space-x-6">
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- WhatsApp Floating Button -->
    @if($homeSetting && $homeSetting->whatsapp_url)
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $homeSetting->whatsapp_url) }}" target="_blank" class="fixed bottom-6 right-6 z-50 bg-green-500 hover:bg-green-600 text-white rounded-full p-4 shadow-lg transition-all duration-300 hover:scale-110 flex items-center justify-center">
        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
        </svg>
    </a>
    @endif

    <script>
        // Desktop Navbar Hide/Show Animation (only on desktop)
        let lastScroll = 0;
        const navbar = document.getElementById("navbar");

        function shouldHideNavbar() {
            return window.innerWidth >= 768; // md breakpoint
        }

        window.addEventListener("scroll", () => {
            // Only run navbar animation on desktop
            if (!shouldHideNavbar() || !navbar) return;
            
            const current = window.scrollY;

            // Navbar hanya muncul kembali ketika benar-benar di paling atas (<= 10px)
            if (current <= 10) {
                navbar.classList.remove("hide"); // benar-benar di atas → show
            } else if (current > lastScroll && current > 80) {
                navbar.classList.add("hide");   // scroll down → hide
            }
            // Jika scroll up tapi belum di atas, tetap hide

            lastScroll = current;
        });

        // Mobile Menu Toggle
        function toggleMobileMenu() {
            const sidebar = document.getElementById('mobile-sidebar');
            const body = document.body;
            
            if (sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
                body.style.overflow = '';
            } else {
                sidebar.classList.add('open');
                body.style.overflow = 'hidden';
            }
        }

        // Mobile Submenu Toggle
        function toggleMobileSubmenu(button) {
            const submenu = button.nextElementSibling;
            const icon = button.querySelector('svg');
            
            if (submenu) {
                submenu.classList.toggle('open');
                icon.classList.toggle('rotate-180');
            }
        }

        // Close mobile menu on window resize to desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                const sidebar = document.getElementById('mobile-sidebar');
                if (sidebar) {
                    sidebar.classList.remove('open');
                    document.body.style.overflow = '';
                }
            }
        });

        // Improved dropdown menu behavior - handles all dropdowns including nested
        (function() {
            const dropdowns = document.querySelectorAll('.dropdown');
            
            dropdowns.forEach(function(dropdown) {
                const dropdownMenu = dropdown.querySelector('.dropdown-menu');
                if (!dropdownMenu) return;
                
                let hideTimeout;
                let showTimeout;

                function showMenu() {
                    clearTimeout(hideTimeout);
                    clearTimeout(showTimeout);
                    // Show immediately for better responsiveness
                    dropdownMenu.classList.add('show');
                }

                function hideMenu() {
                    clearTimeout(showTimeout);
                    hideTimeout = setTimeout(() => {
                        dropdownMenu.classList.remove('show');
                    }, 300); // Longer delay before hiding to prevent flickering when moving mouse
                }

                // Show on hover
                dropdown.addEventListener('mouseenter', showMenu);
                dropdownMenu.addEventListener('mouseenter', showMenu);

                // Hide when mouse leaves
                dropdown.addEventListener('mouseleave', hideMenu);
                dropdownMenu.addEventListener('mouseleave', hideMenu);
            });
        })();
    </script>
</body>
</html>
