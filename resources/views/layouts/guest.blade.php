<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .gradient-bg {
                background: linear-gradient(135deg, #6b73ff 0%, #000dff 100%);
            }
            .input-focus-effect:focus {
                box-shadow: 0 0 0 3px rgba(107, 115, 255, 0.2);
            }
            .transition-all {
                transition: all 0.3s ease;
            }
            .hover-scale:hover {
                transform: translateY(-2px);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-50 dark:bg-gray-900">
            <!-- Logo/Header Section -->
            <div class="text-center mb-8">
                <div class="w-20 h-20 mx-auto mb-4 rounded-full gradient-bg flex items-center justify-center shadow-lg">
                    <i class="fas fa-lock text-white text-3xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Welcome Back</h1>
                <p class="text-gray-600 dark:text-gray-300 mt-2">Sign in to your account to continue</p>
            </div>
            <!-- Login Form Container -->
            <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white dark:bg-gray-800 shadow-xl overflow-hidden sm:rounded-lg transition-all hover:shadow-2xl">
                {{ $slot }}
                <!-- Social Login Options -->
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                        </div>
                    </div>
                </div>
                <!-- Footer Links -->
            </div>
            <!-- Copyright Notice -->
        </div>
    </body>
</html>
