<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SaaS Admin Panel')</title>
    @vite(['resources/css/admin/base.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen font-sans text-gray-900">
    <div class="flex min-h-screen">
       @include('admin.layouts.includes._sidebar')
        <!-- Main content -->
        <div class="flex-1 flex flex-col">
            @include('admin.layouts.includes._header')            
            <!-- Content -->
            <main class="flex-1 p-6">
                @include('flash::message')
                @yield('content')
            </main>
            <!-- Footer -->
            <footer class="bg-white border-t py-4 mt-auto px-4 text-center text-xs text-gray-500">
                &copy; {{ date('Y') }} SaaS Admin Panel. All rights reserved.
            </footer>
        </div>
    </div>
</body>
</html>