@extends('components.frontend.app_statis')

@section('title', 'Galeri Foto')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl rounded-lg overflow-hidden p-5">

            <!-- Form Pencarian -->
            <div class="w-full max-w-6xl mx-auto">
                <form id="form-search" action="{{ route('web.cari.albums') }}" method="GET" class="flex items-center">
                    <div class="relative w-full">
                        <input type="text" name="keywords" value="{{ request()->input('keywords') }}"
                            placeholder="Cari di sini..."
                            class="w-full h-14 px-4 py-2 pr-28 rounded-lg border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 text-gray-900 placeholder-gray-500">
                        <button type="submit"
                            class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-blue-500 hover:bg-blue-900 text-white font-semibold py-2 px-4 rounded-lg shadow-lg transition duration-300 hover:shadow-xl active:bg-blue-800 active:scale-95 border-2 border-gray-300">
                            Cari
                        </button>
                        @if (Route::currentRouteName() == 'web.cari.albums')
                            <a href="{{ route('albums.index') }}"
                                class="absolute top-1/2 right-20 transform -translate-y-1/2 bg-orange-500 hover:bg-orange-700 text-white font-semibold py-2 px-4 rounded-lg shadow-lg transition duration-300 hover:shadow-xl active:bg-gray-600 active:scale-95 border-2 border-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-6">
                                    <path fill-rule="evenodd"
                                        d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div id="search-results-photos" class="mt-8">
                @if ($albums->isEmpty())
                    <div class="text-center text-3xl font-semibold text-gray-500">
                        <p>Pencarian Foto <span class="text-red-500">{{ request()->input('keywords') }}</span> tidak
                            ditemukan!</p>
                        <img src="{{ asset('storage/images/illustrasi/not-found.png') }}" alt="Not Found Illustration"
                            class="mx-auto my-4 w-80 h-80 object-contain">
                    </div>
                @else
                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 animate__animated animate__fadeIn">
                        @foreach ($albums as $index => $album)
                            @php
                                $placeholder = asset('path/to/placeholder-image.jpg');
                                $coverPhotoPath = $album->cover_photo
                                    ? asset('storage/' . $album->cover_photo)
                                    : $placeholder;

                                $borderColors = [
                                    'border-green-200-hover',
                                    'border-red-200-hover',
                                    'border-purple-200-hover',
                                    'border-blue-200-hover',
                                ];
                                $borderColor = $borderColors[$index % count($borderColors)];
                            @endphp
                            <div
                                class="bg-white rounded-lg overflow-hidden shadow-lg max-w-sm lg:max-w-md xl:max-w-lg border-4 {{ $borderColor }} transition-all duration-300 transform hover:scale-105 relative">
                                <!-- Thumbnail Image -->
                                <div class="relative">
                                    <img src="{{ $coverPhotoPath }}" alt="{{ $album->name }}" loading="lazy"
                                        class="w-full h-60 object-cover object-center">
                                    <div
                                        class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300 ease-in-out">
                                        <span class="text-white text-lg font-bold">
                                            <button data-album-id="{{ $album->id }}"
                                                class="show-photos mt-2 inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                                                Lihat Foto
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <h2 class="text-xl font-semibold mb-2">{{ $album->name }}</h2>
                                    <p class="text-gray-600 mb-6">{{ $album->description }}</p>
                                    <div
                                        class="absolute bottom-0 left-0 m-4 bg-gray-800 text-white text-sm py-1 px-2 rounded-full">
                                        {{ \Carbon\Carbon::parse($album->created_at)->translatedFormat('d F Y') }}
                                    </div>
                                    <div
                                        class="absolute bottom-0 right-0 m-4 bg-gray-800 text-white text-sm py-1 px-2 rounded-full">
                                        {{ $album->images_count }} Foto
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            @if (!$albums->isEmpty())
                <div class="mt-6 flex justify-center">
                    <div class="join">
                        @if ($albums->currentPage() > 1)
                            <a href="{{ $albums->previousPageUrl() }}" class="join-item btn">«</a>
                        @else
                            <span class="join-item btn btn-disabled">«</span>
                        @endif

                        @foreach ($albums->getUrlRange(1, $albums->lastPage()) as $page => $url)
                            @if ($page == $albums->currentPage())
                                <span class="join-item btn btn-active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="join-item btn">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($albums->hasMorePages())
                            <a href="{{ $albums->nextPageUrl() }}" class="join-item btn">»</a>
                        @else
                            <span class="join-item btn btn-disabled">»</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>

    </div>



    <!-- Modal HTML -->
    <div id="photo-modal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white p-4 rounded-3xl relative w-full max-w-3xl">
            <button id="modal-close" class="modal-close" aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="16" height="16"
                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M18 6L6 18" />
                    <path d="M6 6l12 12" />
                </svg>
            </button>
            <div class="photo-carousel slick-slider">
                <!-- Daftar foto akan dimuat di sini -->
            </div>
            <button class="slick-prev   text-gray-600 ">‹</button>
            <button class="slick-next   text-gray-600 ">›</button>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Carousel di modal
        document.querySelectorAll('.show-photos').forEach(button => {
            button.addEventListener('click', function() {
                const albumId = this.getAttribute('data-album-id');

                fetch(`/album/${albumId}/photos`)
                    .then(response => response.json())
                    .then(data => {
                        const carousel = document.querySelector('.photo-carousel');
                        const photos = data.photos || []; // Pastikan data.photos adalah array

                        if (photos.length === 0) {
                            carousel.innerHTML =
                                `<div class="text-center text-gray-500 py-8">Album ini belum memiliki foto.</div>`;
                        } else {
                            carousel.innerHTML = photos.map(photo => `
                        <div>
                           <img data-lazy="${photo.path}" alt="${photo.caption}" class="w-full h-auto object-cover">
                        </div>
                    `).join('');

                            // Hancurkan Slick Carousel jika sudah ada
                            if ($('.photo-carousel').hasClass('slick-initialized')) {
                                $('.photo-carousel').slick('unslick');
                            }

                            // Inisialisasi ulang Slick Carousel
                            $('.photo-carousel').slick({
                                infinite: false,
                                speed: 500,
                                fade: true,
                                cssEase: 'linear',
                                prevArrow: $('.slick-prev'),
                                nextArrow: $('.slick-next'),
                                lazyLoad: 'ondemand',
                            });
                        }

                        document.getElementById('photo-modal').classList.remove('hidden');
                    })
                    .catch(error => console.error('Error fetching photos:', error));
            });
        });

        document.getElementById('modal-close').addEventListener('click', function() {
            document.getElementById('photo-modal').classList.add('hidden');
        });
    </script>
    @if (!$albums->isEmpty())
        <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Album",
      "name": "{{ $albums->first()->name }}",
      "description": "{{ $albums->first()->description }}",
      "image": "{{ asset('storage/' . $albums->first()->cover_photo) }}"
    }
    </script>
    @endif
@endpush
