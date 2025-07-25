<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">

            <nav class="bg-blue-700 text-white px-6 py-4 shadow-md">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <div class="text-xl font-bold tracking-wide">
            MDRRMO Admin
        </div>
        <ul class="flex space-x-6 text-sm font-medium">
            <li>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'underline' : 'hover:underline' }}">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.posting') }}" class="{{ request()->routeIs('admin.posting') ? 'underline' : 'hover:underline' }}">
                    Posts
                </a>
            </li>
            <li>
                <a href="#" class="hover:underline">
                    Settings
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="hover:underline">
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>


        <div class="min-h-screen bg-gray-100">


            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
