<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- ✅ Your Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/stylish.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Fixed Top Header -->
    <div class="mdrrmo-header" style="border: 2px solid #031273; margin-left: 0; width: 100%;">
        <h2 class="header-title">SILANG MDRRMO</h2>
    </div>

    <!-- Main content (with padding top to not hide under fixed header) -->
    <main class="main-content pt-24" style="margin-left: 0; width: 100%; display: flex; justify-content: center; align-items: center; min-height: calc(100vh - 100px); padding-top: 120px;">
        <div class="grid gap-6 p-6 rounded shadow mb-8" style="max-width: 600px; width: 100%; margin: 0 auto;">
            <div class="border p-4 rounded">
                <h3 class="section-title">Login</h3>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 text-sm font-medium text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="mb-4">
                        <div class="font-medium text-red-600">Whoops! Something went wrong.</div>
                        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email and Password with Logo -->
                    <div class="mb-4" style="display: flex; justify-content: space-between; align-items: center;">
                        <!-- LEFT SIDE - Form Fields -->
                        <div style="flex: 1; margin-right: 40px; max-width: 300px;">
                            <!-- Email Address -->
                            <div class="mb-4">
                                <label for="email" class="block mb-2">
                                    <i class="fas fa-envelope mr-2"></i>Email
                                </label>
                                <div class="relative">
                                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                                           class="border p-4 w-full rounded" 
                                           placeholder="Enter your email address"
                                           style="font-size: 16px; min-height: 45px; padding: 12px;">
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-4">
                                <label for="password" class="block mb-2">
                                    <i class="fas fa-lock mr-2"></i>Password
                                </label>
                                <div class="relative">
                                    <input id="password" type="password" name="password" required autocomplete="current-password" 
                                           class="border p-4 w-full rounded" 
                                           placeholder="Enter your password"
                                           style="font-size: 16px; min-height: 45px; padding: 12px;">
                                </div>
                            </div>
                        </div>
                        
                        <!-- CENTERED MDRRMO Logo -->
                        <div style="flex-shrink: 0; display: flex; justify-content: center; align-items: center;">
                            <img src="{{ asset('image/mdrrmologo.jpg') }}" alt="Municipal Seal" style="width: 180px; height: 180px; object-fit: cover; border-radius: 50%;">
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 flex items-center" href="{{ route('password.request') }}">
                                <i class="fas fa-key mr-2"></i>Forgot your password?
                            </a>
                        @endif
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="text-white px-4 py-2 rounded" style="width: 170px; background-color: #4338ca; border-radius: 25px; padding: 12px 24px;">
                            <i class="fas fa-sign-in-alt mr-2"></i> Log in
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
