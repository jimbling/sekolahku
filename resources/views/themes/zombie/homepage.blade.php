@include('themes.' . getActiveTheme() . '.components.frontend.partials.header')

<body class="bg-gray-50">
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
                            class="absolute bottom-0 left-0 right-0 h-64 bg-gradient-to-t from-black/90 to-transparent z-10 pointer-events-none">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Stats Cards (Small & Centered on Desktop) -->
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap justify-center gap-6 -mt-32 relative z-20 max-w-6xl mx-auto">
                <!-- Card Component -->
                @php
                    $cards = [
                        [
                            'icon' => 'academic-cap',
                            'color' => 'blue',
                            'value' => '98%',
                            'label' => 'Peserta Didik',
                            'link' => 'Learn more →',
                        ],
                        [
                            'icon' => 'star',
                            'color' => 'green',
                            'value' => '120+',
                            'label' => 'Guru dan Tendik',
                        ],
                        [
                            'icon' => 'users',
                            'color' => 'purple',
                            'value' => '50:1',
                            'label' => 'Ekstrakurikuler',
                        ],
                        [
                            'icon' => 'book-open',
                            'color' => 'orange',
                            'value' => '100+',
                            'label' => 'Alumni',
                        ],
                    ];
                @endphp

                @foreach ($cards as $index => $card)
                    <div class="bg-white w-full sm:w-[12rem] rounded-xl shadow-2xl p-4 text-center border border-gray-100
               hover:shadow-[0_12px_30px_rgba(0,0,0,0.2)] transition-all duration-300 hover:-translate-y-1"
                        data-aos="fade-up" data-aos-delay="{{ $index * 150 }}">
                        <div
                            class="bg-{{ $card['color'] }}-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                            <x-dynamic-component :component="'heroicon-o-' . $card['icon']" class="w-6 h-6 text-{{ $card['color'] }}-600" />
                        </div>

                        <h3 class="text-3xl font-bold text-gray-800 mb-2">{{ $card['value'] }}</h3>
                        <p class="text-gray-600">{{ $card['label'] }}</p>

                    </div>
                @endforeach

            </div>
        </div>
    </div>


    <!-- Sambutan Section -->
    <div class="py-12">
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
