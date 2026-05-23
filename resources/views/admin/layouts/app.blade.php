<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'Laravel') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {}
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-[#96A480] shadow-xl fixed top-0 left-0 h-screen">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center justify-center h-16 border-b border-[#7A8A6A]">
                    <div class="flex items-center space-x-3">
                        <!-- Logo placeholder -->
                        <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center text-white font-bold text-lg">
                            P
                        </div>
                        <!-- Brand text -->
                        <div>
                            <div class="text-xl font-bold tracking-wide text-white">PROSPEDITY</div>
                            <div class="text-xs text-white/80">Admin Panel</div>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-[#7A8A6A] shadow-lg' : 'hover:bg-[#7A8A6A]' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    <a href="{{ route('admin.properties.index') }}" class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-200 {{ request()->routeIs('admin.properties.index') || request()->routeIs('admin.properties.show') || request()->routeIs('admin.properties.edit') ? 'bg-[#7A8A6A] shadow-lg' : 'hover:bg-[#7A8A6A]' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <span class="font-medium">Properties</span>
                    </a>

                    <a href="{{ route('admin.transactions.index') }}" class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-200 {{ request()->routeIs('admin.transactions.*') ? 'bg-[#7A8A6A] shadow-lg' : 'hover:bg-[#7A8A6A]' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        <span class="font-medium">Transactions</span>
                    </a>

                    <a href="{{ route('admin.featured-properties.index') }}" class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-200 {{ request()->routeIs('admin.featured-properties.*') ? 'bg-[#7A8A6A] shadow-lg' : 'hover:bg-[#7A8A6A]' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                        <span class="font-medium">Featured Properties</span>
                    </a>

                    <a href="{{ route('admin.properties.create') }}" class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-200 hover:bg-[#7A8A6A]">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span class="font-medium">Add Property</span>
                    </a>

                    <a href="{{ route('admin.properties.successful') }}" class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-200 {{ request()->routeIs('admin.properties.successful') ? 'bg-[#7A8A6A] shadow-lg' : 'hover:bg-[#7A8A6A]' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium">Successful Properties</span>
                    </a>

                    <a href="{{ route('admin.tags.index') }}" class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-200 {{ request()->routeIs('admin.tags.*') ? 'bg-[#7A8A6A] shadow-lg' : 'hover:bg-[#7A8A6A]' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        <span class="font-medium">Property Tags</span>
                    </a>

                    <a href="{{ route('admin.inquiries.index') }}" class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-200 {{ request()->routeIs('admin.inquiries.*') ? 'bg-[#7A8A6A] shadow-lg' : 'hover:bg-[#7A8A6A]' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="font-medium">Inquiries</span>
                    </a>

                    <a href="{{ route('admin.activity-logs.index') }}" class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-200 {{ request()->routeIs('admin.activity-logs.*') ? 'bg-[#7A8A6A] shadow-lg' : 'hover:bg-[#7A8A6A]' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <span class="font-medium">Activity Logs</span>
                    </a>

                    <!-- Master Data Section -->
                    <div class="mt-4 pt-4 border-t border-white/20">
                        <p class="px-4 text-xs font-semibold text-white/70 uppercase tracking-wide mb-2">
                            Master Data
                        </p>
                    </div>

                    <a href="{{ route('admin.property-types.index') }}" class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-200 {{ request()->routeIs('admin.property-types.*') ? 'bg-[#7A8A6A] shadow-lg' : 'hover:bg-[#7A8A6A]' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span class="font-medium">Property Types</span>
                    </a>

                    <a href="{{ route('admin.pic-profiles.index') }}" class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-200 {{ request()->routeIs('admin.pic-profiles.*') ? 'bg-[#7A8A6A] shadow-lg' : 'hover:bg-[#7A8A6A]' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="font-medium">PIC Profiles</span>
                    </a>

                    <!-- CMS Section -->
                    <div class="mt-4 pt-4 border-t border-white/20">
                        <p class="px-4 text-xs font-semibold text-white/70 uppercase tracking-wide mb-2">
                            CMS
                        </p>
                    </div>

                    <a href="{{ route('admin.home-settings.edit') }}" class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-200 {{ request()->routeIs('admin.home-settings.*') ? 'bg-[#7A8A6A] shadow-lg' : 'hover:bg-[#7A8A6A]' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span class="font-medium">Home Settings</span>
                    </a>

                    <a href="{{ route('admin.about-settings.edit') }}" class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-200 {{ request()->routeIs('admin.about-settings.*') ? 'bg-[#7A8A6A] shadow-lg' : 'hover:bg-[#7A8A6A]' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium">Contact Us Settings</span>
                    </a>

                    <a href="{{ route('admin.advisor-guides.index') }}" class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-200 {{ request()->routeIs('admin.advisor-guides.*') ? 'bg-[#7A8A6A] shadow-lg' : 'hover:bg-[#7A8A6A]' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 4H8a2 2 0 00-2 2v12l3-3h7a2 2 0 002-2V6a2 2 0 00-2-2z"></path>
                        </svg>
                        <span class="font-medium">Advisor Guide</span>
                    </a>

                    <a href="{{ route('admin.our-services.index') }}" class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-200 {{ request()->routeIs('admin.our-services.*') ? 'bg-[#7A8A6A] shadow-lg' : 'hover:bg-[#7A8A6A]' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span class="font-medium">Our Services</span>
                    </a>

                    <a href="{{ route('admin.service-packages.index') }}" class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-200 {{ request()->routeIs('admin.service-packages.*') ? 'bg-[#7A8A6A] shadow-lg' : 'hover:bg-[#7A8A6A]' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0l-8 8-8-8m16 0H4"></path>
                        </svg>
                        <span class="font-medium">Service Packages</span>
                    </a>

                    <a href="{{ route('admin.sales-orders.index') }}" class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-200 {{ request()->routeIs('admin.sales-orders.*') ? 'bg-[#7A8A6A] shadow-lg' : 'hover:bg-[#7A8A6A]' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m-7 4h8a2 2 0 002-2V6a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        <span class="font-medium">Sales Orders</span>
                    </a>

                    <a href="{{ route('admin.bank-accounts.index') }}" class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-200 {{ request()->routeIs('admin.bank-accounts.*') ? 'bg-[#7A8A6A] shadow-lg' : 'hover:bg-[#7A8A6A]' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m3 0h6M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z"></path>
                        </svg>
                        <span class="font-medium">Nomor Rekening</span>
                    </a>

                    @if(auth()->user()->isSuperAdmin())
                        <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-[#7A8A6A] shadow-lg' : 'hover:bg-[#7A8A6A]' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <span class="font-medium">Create User</span>
                        </a>
                    @endif
                </nav>

                <!-- User Section -->
                <div class="p-4 border-t border-[#7A8A6A]">
                    <div class="flex items-center px-4 py-3 bg-[#7A8A6A] rounded-lg">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center">
                                <span class="text-white font-bold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-400">{{ auth()->user()->email }}</p>
                            <p class="text-xs text-white/70 mt-1">
                                @if(auth()->user()->isSuperAdmin())
                                    <span class="px-2 py-0.5 bg-purple-600 text-white rounded text-xs font-semibold">Super Admin</span>
                                @else
                                    <span class="px-2 py-0.5 bg-white/15 text-white rounded text-xs font-semibold">Admin</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('admin.logout') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-[#7A8A6A] hover:bg-[#6B7A5F] text-white rounded-lg transition-colors duration-200 font-medium">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-h-screen ml-64">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">
                            @yield('title', 'Dashboard')
                        </h2>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-600">
                            {{ now()->format('l, F d, Y') }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6">
                @if(session('success'))
                    <div class="mb-4 bg-[#96A480] text-white px-6 py-4 rounded-lg shadow-md flex items-center" role="alert">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-md flex items-center" role="alert">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-md" role="alert">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium">Validation Errors</span>
                        </div>
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
