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
    @stack('hero')


    <!-- Bagian Judul Konten -->
    <div class="relative bg-[#0d4d46] text-white overflow-hidden">
        <div class="container mx-auto py-4 px-2 md:py-8 lg:py-16  relative z-10" data-aos="zoom-in"
            data-aos-duration="600">
            @if (Route::currentRouteName() == 'posts.show')
                <!-- Breadcrumb untuk halaman post detail -->
                <nav aria-label="Breadcrumb" class="mb-4 text-sm" data-aos="fade-down" data-aos-delay="200">
                    <ol class="flex flex-wrap items-center space-x-2">
                        <li class="flex items-center">
                            <a href="{{ route('web.home') }}" class="hover:underline">Home</a>
                            <svg class="fill-current w-3 h-3 mx-2 text-white/70" viewBox="0 0 24 24">
                                <path d="M9 18l6-6-6-6"></path>
                            </svg>
                        </li>
                        <li class="flex items-center">
                            <a href="{{ route('category.posts', ['slug' => $category->slug]) }}"
                                class="hover:underline">
                                {{ $category->name }}
                            </a>
                            <svg class="fill-current w-3 h-3 mx-2 text-white/70" viewBox="0 0 24 24">
                                <path d="M9 18l6-6-6-6"></path>
                            </svg>
                        </li>
                        <li>
                            <span class="font-semibold">{{ $post->title }}</span>
                        </li>
                    </ol>
                </nav>
            @else
                <!-- Judul Halaman Umum -->
                <div class="text-center" data-aos="zoom-in" data-aos-delay="300">
                    <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold leading-tight">
                        @yield('title')
                    </h1>
                    <p class="mt-2 text-white/80 text-base md:text-lg">
                        {{ get_page_subtitle(View::getSections()['title'] ?? '') }}
                    </p>
                </div>
            @endif
        </div>

        <!-- Background Blur Dekoratif -->
        <div class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-white/10 to-transparent"></div>
        <div class="absolute -bottom-20 -right-20 w-40 h-40 rounded-full bg-teal-400/10 blur-xl"></div>
        <div class="absolute -top-20 -left-20 w-60 h-60 rounded-full bg-teal-300/10 blur-xl"></div>
    </div>


    <!-- Bagian Konten Inti -->
    <div class="relative z-20  container mx-auto">
        <section id="main" class="min-h-screen flex flex-col md:flex-row py-3 rounded-4xl">

            @yield('content')

        </section>
    </div>

    <!-- Bagian Footer -->
    @include('themes.' . getActiveTheme() . '.components.frontend.partials.footer')
    @stack('scripts')
</body>

</html>
