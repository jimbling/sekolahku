<div class="py-16 relative overflow-hidden bg-gradient-to-br from-white via-gray-50 to-gray-100">
    <!-- Background pattern (very subtle) -->
    <div class="absolute inset-0 opacity-10">
        <div
            class="absolute top-0 left-0 w-full h-full bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiBmaWxsPSJub25lIiBzdHJva2U9IiMyNzNFNDciIHN0cm9rZS1vcGFjaXR5PSIwLjIiIHN0cm9rZS13aWR0aD0iMSI+PHBhdGggZD0iTTAgMGg0MHY0MEgweiIvPjwvc3ZnPg==')]">
        </div>
    </div>

    <div class="container mx-auto px-4 relative">
        {{-- Section Header --}}
        <header class="text-center mb-12" data-aos="fade-down">
            <h2 class="text-4xl font-bold mb-3 text-gray-800">Artikel & Berita</h2>
            <p class="text-lg text-gray-600 max-w-xl mx-auto">Ikuti update terbaru seputar kegiatan dan informasi sekolah
            </p>
            <div class="mt-4 mx-auto w-24 h-1 bg-gradient-to-r from-teal-400 to-emerald-400 rounded-full"></div>
        </header>

        {{-- Carousel --}}
        <div class="focus-carousel" data-aos="fade-up" data-aos-delay="200">
            @foreach ($posts as $post)
                <div class="px-4"> {{-- Increased padding --}}
                    <div
                        class="focus-item bg-white rounded-xl shadow-lg transition-all duration-300 h-full flex flex-col overflow-hidden border border-gray-100 min-h-[350px] max-w-[4000px] mx-auto">

                        {{-- Added min-height --}}
                        {{-- Gambar --}}
                        <div class="h-56 overflow-hidden relative"> {{-- Increased height --}}
                            @if ($post->image)
                                <img src="{{ Storage::url('uploads/posts/' . $post->image) }}" alt="{{ $post->title }}"
                                    class="w-full h-full object-cover transition-transform duration-500">
                            @else
                                <div
                                    class="bg-gradient-to-br from-gray-100 to-gray-200 w-full h-full flex items-center justify-center">
                                    <img src="{{ Storage::url('images/settings/' . get_setting('logo')) }}"
                                        alt="No Image Available" loading="lazy" class="h-24 opacity-70">
                                </div>
                            @endif
                            <div
                                class="absolute bottom-0 left-0 w-full h-20 bg-gradient-to-t from-black/40 to-transparent">
                            </div> {{-- Increased gradient height --}}
                            <div class="absolute bottom-4 left-4 right-4"> {{-- Increased spacing --}}
                                <span
                                    class="inline-block px-3 py-1.5 bg-white/90 backdrop-blur-sm text-sm font-medium rounded-full text-gray-800">
                                    {{-- Larger text --}}
                                    @if ($post->category->isNotEmpty())
                                        {{ $post->category->first()->name }}
                                    @else
                                        Berita
                                    @endif
                                </span>
                            </div>
                        </div>

                        {{-- Konten --}}
                        <div class="p-6 flex-grow flex flex-col"> {{-- Increased padding --}}
                            <div class="flex-grow">
                                <span class="text-sm text-gray-500">{{ $post->published_at_indo }}</span>
                                {{-- Larger text --}}
                                <h3 class="font-semibold text-lg mb-3 leading-snug mt-2"> {{-- Increased size and spacing --}}
                                    <a href="{{ route('posts.show', ['id' => $post->id, 'slug' => $post->slug]) }}"
                                        class="hover:text-teal-600 text-gray-800">
                                        {{ Str::limit($post->title, 50) }}
                                    </a>
                                </h3>
                                <p class="text-base text-gray-600 line-clamp-3 mb-4">{{ $post->excerpt }}</p>
                                {{-- Larger text and more lines --}}
                            </div>
                            <div class="mt-auto">
                                <a href="{{ route('posts.show', ['id' => $post->id, 'slug' => $post->slug]) }}"
                                    class="inline-flex items-center text-teal-600 hover:text-teal-800 text-sm font-medium group">
                                    Selengkapnya
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 ml-1 transform group-hover:translate-x-1 transition-transform"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Navigation Controls - Desktop Layout --}}
        <div class="hidden md:flex justify-center items-center gap-6 mt-8" data-aos="fade-up" data-aos-delay="250">
            <button
                class="carousel-prev px-4 py-2 bg-white text-teal-600 rounded-full shadow-md hover:bg-teal-50 transition-all duration-300 flex items-center justify-center border border-gray-200 hover:border-teal-300 group">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 mr-1 group-hover:-translate-x-1 transition-transform" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span>Sebelumnya</span>
            </button>

            <a href="/berita"
                class="px-6 py-3 text-white bg-gradient-to-r from-teal-500 to-emerald-600 rounded-full shadow-lg hover:shadow-xl hover:from-teal-600 hover:to-emerald-700 transition-all duration-300 font-medium">
                Lihat Semua Berita
            </a>

            <button
                class="carousel-next px-4 py-2 bg-white text-teal-600 rounded-full shadow-md hover:bg-teal-50 transition-all duration-300 flex items-center justify-center border border-gray-200 hover:border-teal-300 group">
                <span>Selanjutnya</span>
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 ml-1 group-hover:translate-x-1 transition-transform" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>

        {{-- Navigation Controls - Mobile Layout --}}
        <div class="md:hidden flex flex-col items-center gap-4 mt-8" data-aos="fade-up" data-aos-delay="250">
            <div class="flex justify-center gap-4 w-full">
                <button
                    class="carousel-prev px-4 py-2 bg-white text-teal-600 rounded-full shadow-md hover:bg-teal-50 transition-all duration-300 flex items-center justify-center border border-gray-200 hover:border-teal-300 group flex-1 max-w-[160px]">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 mr-1 group-hover:-translate-x-1 transition-transform" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Sebelumnya</span>
                </button>

                <button
                    class="carousel-next px-4 py-2 bg-white text-teal-600 rounded-full shadow-md hover:bg-teal-50 transition-all duration-300 flex items-center justify-center border border-gray-200 hover:border-teal-300 group flex-1 max-w-[160px]">
                    <span>Selanjutnya</span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 ml-1 group-hover:translate-x-1 transition-transform" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

            <a href="/berita"
                class="w-full max-w-[280px] px-6 py-3 text-white bg-gradient-to-r from-teal-500 to-emerald-600 rounded-full shadow-lg hover:shadow-xl hover:from-teal-600 hover:to-emerald-700 transition-all duration-300 font-medium text-center">
                Lihat Semua Berita
            </a>
        </div>
    </div>
</div>



@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const carousel = $('.focus-carousel').slick({
                centerMode: true,
                centerPadding: '10px',
                slidesToShow: 3,
                autoplay: true,
                autoplaySpeed: 3000,
                focusOnSelect: true,
                dots: true,
                arrows: false,
                speed: 800,
                responsive: [{
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 2,
                            centerMode: true,
                            centerPadding: '10px'
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                            centerMode: true,
                            centerPadding: '10px'
                        }
                    }
                ]
            });


            $('.carousel-prev').click(function() {
                carousel.slick('slickPrev');
            });
            $('.carousel-next').click(function() {
                carousel.slick('slickNext');
            });
        });
    </script>
@endpush
