@include('themes.' . getActiveTheme() . '.components.frontend.partials.header')

<body class="bg-gray-100 text-gray-800">
    @php
        $showPreloader = get_setting('preloader') === 'true'; // Mengambil nilai preloader dari database
    @endphp

    @if ($showPreloader)
        @include('themes.' . getActiveTheme() . '.components.frontend.partials.preloader')
    @endif

    <!-- Nav Menu Section -->
    @include('themes.' . getActiveTheme() . '.components.frontend.partials.nav')

    <!-- Hero Section (Carousel) -->
    @stack('hero')


    <!-- Bagian Judul Konten -->
    <h2 class="text-3xl font-bold text-gray-500 text-center py-6 px-6">
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
    @include('themes.' . getActiveTheme() . '.components.frontend.partials.footer')
    @stack('scripts')
</body>

</html>
