<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Flash messages for Toastr (read by app.js) -->
    <meta name="flash-success" content="{{ session('success') }}">
    <meta name="flash-error" content="{{ session('error') }}">
    <meta name="flash-warning" content="{{ session('warning') }}">
    <meta name="flash-info" content="{{ session('info') }}">

    <title>{{ config('app.name', 'POS System') }} - Admin</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700&display=swap" rel="stylesheet">

    <!-- Compiled CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/filter-layout.css') }}">


    <!-- Alpine.js for interactive components -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- POS System Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="bg-gray-50 font-sans">
    <div class="min-h-screen bg-gray-50" x-data="{ reportsOpen: false, sidebarOpen: true }" @toggle-sidebar.window="sidebarOpen = !sidebarOpen">
        <!-- Sidebar Component -->
        @include('layouts.partials.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden transition-all duration-300 ease-in-out md:ml-0 min-h-screen main-content" :class="sidebarOpen ? 'md:ml-64' : 'md:ml-16'">
            <!-- Navbar Component -->
            @include('layouts.partials.navbar')

            <!-- Page Content -->
            <main class="flex-1 overflow-auto p-6 pb-24 md:pb-6">
                @yield('content')
            </main>

            <!-- Desktop Footer -->
            @include('layouts.partials.desktop-footer')
        </div>

        <!-- Mobile Footer Sidebar -->
        @include('layouts.partials.mobile-footer-sidebar')

        <!-- Profile Modal -->
        @include('auth.profile')
    </div>
</body>
</html>
