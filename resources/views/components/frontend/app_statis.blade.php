<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Home Page')</title>
    @vite('resources/css/app.css')
    <style>
        /* Custom styles for the dropdown */
        .dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>

</head>

<body class="bg-gray-100">

    <!-- Bagian Menu Navbar Atas -->
    @include('components.frontend.partials.nav')

    <!-- Hero Section (Carousel) -->
    @stack('hero')


    <!-- Bagian Judul Konten -->
    <h2 class="text-3xl font-bold text-gray-500 text-center py-3">
        <span class="relative">
            @yield('title')
            <span
                class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-3 h-1 w-16 bg-blue-800"></span>
        </span>
    </h2>

    <!-- Bagian Konten Inti -->
    <section id="main" class="min-h-screen flex flex-col md:flex-row py-3 rounded-4xl">

        @yield('content')

    </section>

    <!-- Bagian Footer -->
    @include('components.frontend.partials.footer')

</body>

</html>
