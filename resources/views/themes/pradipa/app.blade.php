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

    <div class="relative bg-gradient-to-r from-[#0d5c52] to-[#1b7b74] text-white overflow-hidden">
        <!-- Background decorative elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -bottom-20 -right-20 w-40 h-40 rounded-full bg-teal-400/10 blur-xl animate-float-slow">
            </div>
            <div class="absolute -top-20 -left-20 w-60 h-60 rounded-full bg-teal-300/10 blur-xl animate-float"></div>
            <div class="absolute top-1/4 -right-10 w-32 h-32 rounded-full bg-white/5 blur-lg animate-float-delay"></div>
        </div>

        <div class="container mx-auto px-4 sm:px-6 py-6 md:py-8 lg:py-16 relative z-10" data-aos="zoom-in-up"
            data-aos-duration="400">
            @if (Route::currentRouteName() == 'posts.show')
                <!-- Mobile-optimized breadcrumb for post detail -->
                <div class="flex flex-col space-y-3 md:flex-row md:items-center md:justify-between md:space-y-0 mb-4 md:mb-6 text-sm"
                    data-aos="zoom-in" data-aos-delay="400">
                    <!-- Breadcrumb - stacked on mobile -->
                    <nav aria-label="Breadcrumb" class="flex-1 min-w-0">
                        <ol class="flex flex-wrap items-center gap-x-2 gap-y-1 truncate">
                            <li class="flex items-center">
                                <a href="{{ route('web.home') }}" class="hover:underline flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    <span class="truncate">Home</span>
                                </a>
                                <svg class="flex-shrink-0 fill-current w-3 h-3 mx-2 text-white/70" viewBox="0 0 24 24">
                                    <path d="M9 18l6-6-6-6"></path>
                                </svg>
                            </li>
                            <li class="flex items-center truncate">
                                <a href="{{ route('category.posts', ['slug' => $category->slug]) }}"
                                    class="hover:underline truncate">
                                    {{ $category->name }}
                                </a>
                                <svg class="flex-shrink-0 fill-current w-3 h-3 mx-2 text-white/70" viewBox="0 0 24 24">
                                    <path d="M9 18l6-6-6-6"></path>
                                </svg>
                            </li>
                            <li class="truncate">
                                <span class="font-semibold truncate">{{ $post->title }}</span>
                            </li>
                        </ol>
                    </nav>

                    <!-- Back button - full width on mobile -->
                    <div class="md:mt-0 flex-shrink-0 hover:scale-105">
                        <a href="{{ route('index.berita') }}"
                            class="inline-flex items-center justify-center w-full md:w-auto px-4 py-2 rounded-full bg-white/20 hover:bg-white/30 text-white text-sm font-medium backdrop-blur-sm transition-all duration-300 hover:shadow-md hover:shadow-teal-500/20 active:scale-95">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                            <span class="whitespace-nowrap">Kembali ke Indeks</span>
                        </a>
                    </div>
                </div>
            @else
                <!-- Page title section - centered layout -->
                <div class="text-center px-2 sm:px-0" data-aos="zoom-in" data-aos-delay="300">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight tracking-tight">
                        @yield('title')
                    </h1>
                    <p class="mt-3 sm:mt-4 text-white/80 text-base sm:text-lg max-w-3xl mx-auto">
                        {{ get_page_subtitle(View::getSections()['title'] ?? '') }}
                    </p>

                    @if ((View::getSections()['title'] ?? '') === 'Indeks Berita')
                        <!-- Search bar - full width on mobile, centered on desktop -->
                        <div class="mt-6 sm:mt-8 flex justify-center" data-aos="fade-up" data-aos-delay="500">
                            <form action="{{ route('search.results') }}" method="GET"
                                class="w-full max-w-2xl lg:max-w-3xl">
                                <div class="relative">
                                    <input type="text" name="keywords" value="{{ request()->input('search') }}"
                                        autocomplete="off" placeholder="Cari berita atau informasi..."
                                        class="w-full py-3 sm:py-4 px-5 sm:px-6 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all duration-300 hover:bg-white/15 hover:shadow-lg hover:shadow-teal-500/10 text-sm sm:text-base">
                                    <button type="submit"
                                        class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/30 backdrop-blur-sm p-2 sm:p-3 rounded-full transition-all duration-300 hover:shadow-md hover:shadow-teal-500/20 active:scale-90">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Bottom gradient overlay -->
        <div
            class="absolute bottom-0 left-0 right-0 h-12 bg-gradient-to-t from-white/10 to-transparent pointer-events-none">
        </div>

    </div>



    <!-- Main Content - Full Width Single Column -->
    <div class="relative z-60 container mx-auto px-4 -mt-10 md:-mt-8 lg:-mt-12">
        <section id="main" class="py-6">
            @yield('content')
        </section>
    </div>


    <!-- Footer -->
    @include('themes.' . getActiveTheme() . '.components.frontend.partials.footer')

    @stack('scripts')
</body>

</html>
