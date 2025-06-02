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

    <!-- News & Events Section -->
    <div class="py-10 bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <!-- Badge dengan animasi zoom in -->
                <span class="inline-block px-3 py-1 text-sm font-semibold text-blue-600 bg-blue-50 rounded-full mb-4"
                    data-aos="zoom-in" data-aos-delay="100" data-aos-easing="ease-out-cubic">
                    Update Terbaru
                </span>

                <!-- Judul dengan animasi fade up yang halus -->
                <h2 class="text-4xl font-bold text-gray-900 mb-4" data-aos="fade-up" data-aos-delay="200"
                    data-aos-duration="600" data-aos-easing="ease-out-back">
                    Berita dan Pengumuman
                </h2>

                <!-- Deskripsi dengan animasi bertahap -->
                <p class="text-xl text-gray-600 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="300"
                    data-aos-duration="500" data-aos-easing="ease-out-quad" data-aos-anchor-placement="top-bottom">
                    Ikuti terus berita dan pengumuman terbaru kami
                </p>

                <!-- Garis dekoratif yang animasinya mengembang -->
                <div class="mt-8 mx-auto w-24 h-1 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full"
                    data-aos="zoom-out" data-aos-delay="400" data-aos-duration="800" data-aos-easing="ease-out-expo">
                </div>
            </div>
            <!-- News Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($posts as $post)
                    <div class="group relative bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-100 hover:border-blue-100 transform hover:-translate-y-1"
                        data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <!-- Image with overlay effect -->
                        <div class="relative h-60 overflow-hidden">
                            @if ($post->image)
                                <img src="{{ Storage::url('uploads/posts/' . $post->image) }}" alt="{{ $post->title }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                    loading="lazy" />
                            @else
                                <div class="bg-gray-200 w-full h-full flex items-center justify-center rounded-lg">
                                    <img src="{{ Storage::url('images/settings/' . get_setting('logo')) }}"
                                        alt="No Image Available" loading="lazy" class="h-24">
                                </div>
                            @endif
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                            <div class="absolute top-4 right-4">
                                <span
                                    class="px-3 py-1 text-xs font-semibold text-white bg-blue-500 rounded-full backdrop-blur-sm">
                                    @if ($post->category->isNotEmpty())
                                        {{ $post->category->first()->name }}
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <div class="flex items-center text-gray-500 text-sm mb-3">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <time datetime="{{ $post->published_at->format('Y-m-d') }}">
                                    {{ $post->published_at_indo }}
                                </time>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3 leading-snug">
                                <a href="{{ route('posts.show', ['id' => $post->id, 'slug' => $post->slug]) }}"
                                    class="hover:text-blue-600 transition-colors">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <p class="text-gray-600 mb-5 line-clamp-2">{{ $post->excerpt }}</p>

                            <div class="flex items-center justify-between">
                                <a href="{{ route('posts.show', ['id' => $post->id, 'slug' => $post->slug]) }}"
                                    class="text-blue-600 font-medium hover:text-blue-800 inline-flex items-center transition-colors">
                                    Selengkapnya
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                                <div class="text-gray-400 text-sm">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    {{ rand(100, 500) }} dilihat
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- View All Button with sequenced animations -->
            <div class="text-center mt-12" data-aos="fade-up" data-aos-delay="500"
                data-aos-anchor-placement="top-bottom">
                <a href="/berita"
                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-blue-600 hover:bg-blue-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    data-aos="zoom-in" data-aos-delay="700" data-aos-easing="ease-out-back" data-aos-duration="500">
                    <span data-aos="fade-right" data-aos-delay="800">Lihat semua Berita</span>
                    <svg class="w-5 h-5 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        data-aos="fade-left" data-aos-delay="900" data-aos-duration="400">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Links Section -->
    <!-- Recent Komentar Disqus -->
    <section class="py-20 bg-gradient-to-b from-blue-50 via-white to-white" data-aos="fade-up">
        <div class="container mx-auto px-4">
            {{-- Recent Comments --}}
            @include('themes.' . getActiveTheme() . '.components.frontend.partials.recent_comments')
            {{-- Spacer antara komentar & galeri --}}
            <div class="mt-20"></div>
            {{-- Slider Galeri Foto --}}
            @include('themes.' . getActiveTheme() . '.components.frontend.partials.slider_galeri_foto')
            <div class="mt-20"></div>
            @include('themes.' . getActiveTheme() . '.components.frontend.partials.hubungi-kami')
        </div>
    </section>


    <!-- Footer -->
    @include('themes.' . getActiveTheme() . '.components.frontend.partials.footer')



</body>

</html>
