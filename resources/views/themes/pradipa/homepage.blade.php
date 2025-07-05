@include('themes.' . getActiveTheme() . '.components.frontend.partials.header')

<body class="bg-gray-50 text-gray-800">
    <!-- Top Navigation -->
    @php
        $showPreloader = filter_var(get_setting('preloader'), FILTER_VALIDATE_BOOLEAN);
    @endphp




    @if ($showPreloader)
        @include('themes.' . getActiveTheme() . '.components.frontend.partials.preloader')
    @endif

    @include('themes.' . getActiveTheme() . '.components.frontend.partials.nav')

    @include('themes.' . getActiveTheme() . '.components.frontend.partials.hero')

    <!-- Sambutan Section -->
    <div class="py-12 pt-10">

        <div class="container mx-auto px-4">
            @include('themes.' . getActiveTheme() . '.components.frontend.partials.sambutan')
        </div>
    </div>

    <div class="relative">
        <!-- Berita homepage -->
        @include('themes.' . getActiveTheme() . '.components.frontend.partials.berita-homepage')

        <!-- Gradient Transition Bridge -->
        @include('themes.' . getActiveTheme() . '.components.frontend.partials.transisi-gradient')

        <section class="pt-10 pb-20 bg-gradient-to-b from-blue-50 via-white to-blue-5 relative z-20">
            <div class="container mx-auto px-4" data-aos="fade-up" data-aos-anchor-placement="top-bottom"
                data-aos-delay="150">


                @include('themes.' . getActiveTheme() . '.components.frontend.partials.profile_video')

            </div>
        </section>

        @include('themes.' . getActiveTheme() . '.components.frontend.partials.akses_cepat')

        @include('themes.' . getActiveTheme() . '.components.frontend.partials.lokasi')
    </div>


    @stack('modals')
    <!-- Footer -->

    @include('themes.' . getActiveTheme() . '.components.frontend.partials.footer')
    @stack('scripts')


</body>

</html>
