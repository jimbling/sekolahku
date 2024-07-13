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

<body class="bg-white">
    <!-- Sticky Menu Section -->
    @include('components.frontend.partials.nav')

    <!-- Hero Section (Carousel) -->
    @stack('hero')


    <!-- Another Features Section -->
    <section id="main" class="min-h-screen flex flex-col md:flex-row">

        <!-- Left Section -->
        <div class="w-full md:w-3/4 p-4">
            @yield('content')
            <!-- Left side content here -->
        </div>

        <!-- Right Section -->
        <div class="w-full md:w-1/4 p-4">
            @yield('sidebar')
            <!-- Right side content here -->
        </div>
    </section>

    <!-- Footer -->
    @include('components.frontend.partials.footer')
</body>

</html>
