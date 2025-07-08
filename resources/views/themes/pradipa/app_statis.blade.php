@include('themes.' . getActiveTheme() . '.components.frontend.partials.header')

<body class="bg-gray-100 text-gray-800">
    @php
        $showPreloader = filter_var(get_setting('preloader'), FILTER_VALIDATE_BOOLEAN);
    @endphp

    @if ($showPreloader)
        @include('themes.' . getActiveTheme() . '.components.frontend.partials.preloader')
    @endif

    <!-- Nav Menu Section -->
    @include('themes.' . getActiveTheme() . '.components.frontend.partials.nav')

    <!-- Hero Section (Carousel) -->
    @yield('hero')



    <!-- Main Content - Full Width Single Column -->
    <div class="relative z-60 container mx-auto px-4 -mt-10 md:-mt-8 lg:-mt-12">
        <section id="main" class="py-6">
            @yield('content')
        </section>
    </div>

    <!-- Bagian Footer -->
    @include('themes.' . getActiveTheme() . '.components.frontend.partials.footer')
    @stack('scripts')
</body>

</html>
