@include('themes.' . getActiveTheme() . '.components.frontend.partials.header')

<body class="bg-gradient-to-br from-gray-50 to-gray-100 text-gray-800">
    <!-- Top Navigation -->
    @php
        $showPreloader = get_setting('preloader') === 'true';
    @endphp

    @if ($showPreloader)
        @include('themes.' . getActiveTheme() . '.components.frontend.partials.preloader')
    @endif

    @include('themes.' . getActiveTheme() . '.components.frontend.partials.nav')



    <!-- Modern Carousel with Overlapping Stats -->
    <div class="relative">

        <!-- Carousel -->
        <div class="relative overflow-hidden h-96 md:h-[32rem]" data-aos="fade">
            <div class="header-carousel relative h-full z-10">
                @foreach ($sliders as $slider)
                    <div class="carousel-item absolute inset-0 transition-opacity duration-500 opacity-0">
                        <img data-lazy="{{ Storage::url($slider->path) }}" alt="{{ $slider->caption }}"
                            class="w-full h-full object-cover" />
                        <div
                            class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-black/90 to-transparent z-10 pointer-events-none">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        @include('themes.' . getActiveTheme() . '.components.frontend.partials.stat')

    </div>



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

        <!-- Recent Komentar  dan Section berikutnya -->
        <section class="pt-10 pb-20 bg-gradient-to-b from-blue-50 via-white to-white relative z-20">
            <div class="container mx-auto px-4" data-aos="fade-up" data-aos-anchor-placement="top-bottom"
                data-aos-delay="150">

                @if ($komentarEngine === 'disqus')
                    @includeIf(
                        'themes.' . getActiveTheme() . '.components.frontend.partials.recent_comments',
                        [
                            'comments' => $comments,
                        ]
                    )
                @elseif ($komentarEngine === 'native')
                    @includeIf(
                        'themes.' . getActiveTheme() . '.components.frontend.partials.recent_comments_native',
                        [
                            'comments' => $comments,
                        ]
                    )
                @endif



                <div class="mt-20"></div>

                @include('themes.' . getActiveTheme() . '.components.frontend.partials.slider_galeri_foto')

                <div class="mt-20"></div>

                @include('themes.' . getActiveTheme() . '.components.frontend.partials.hubungi-kami')
            </div>
        </section>
    </div>



    <!-- Footer -->
    @include('themes.' . getActiveTheme() . '.components.frontend.partials.footer')
    @stack('scripts')


</body>

</html>
