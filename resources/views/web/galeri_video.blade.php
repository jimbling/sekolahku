@extends('components.frontend.app_statis')

@section('title', 'Galeri Video')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl rounded-lg overflow-hidden p-5">
            <!-- Form Pencarian -->
            <div class="w-full max-w-6xl mx-auto mt-6">
                <form id="form-search" action="{{ route('web.cari.videos') }}" method="GET" class="flex items-center">
                    <div class="relative w-full">
                        <input type="text" name="keywords" value="{{ request()->input('keywords') }}"
                            placeholder="Cari di sini..."
                            class="w-full h-14 px-4 py-2 pr-28 rounded-lg border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 text-gray-900 placeholder-gray-500">
                        <button type="submit"
                            class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-blue-500 hover:bg-blue-900 text-white font-semibold py-2 px-4 rounded-lg shadow-lg transition duration-300 hover:shadow-xl active:bg-blue-800 active:scale-95 border-2 border-gray-300">
                            Cari
                        </button>
                        @if (Route::currentRouteName() == 'web.cari.videos')
                            <a href="{{ route('web.videos') }}"
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

            <!-- Hasil Pencarian -->
            <div id="search-results-videos" class="mt-8">
                @if ($posts->isEmpty())
                    <div class="text-center text-3xl font-semibold text-gray-500">
                        <p>Pencarian Video <span class="text-red-500">{{ request()->input('keywords') }}</span> tidak
                            ditemukan!</p>
                        <img src="{{ asset('storage/images/illustrasi/not-found.png') }}" alt="Not Found Illustration"
                            class="mx-auto my-4 w-80 h-80 object-contain">
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 animate__animated animate__fadeIn">
                        @foreach ($posts as $post_video)
                            @php
                                // Mengambil YouTube ID dari kolom content
                                $youtubeId = trim($post_video->content); // Trim untuk menghapus spasi yang tidak diinginkan
                                $thumbnailUrl = "https://img.youtube.com/vi/$youtubeId/sddefault.jpg";
                                $fallbackThumbnailUrl = "https://img.youtube.com/vi/$youtubeId/hqdefault.jpg"; // Thumbnail cadangan
                                $videoUrl = route('web.videos.detail', [
                                    'id' => $post_video->id,
                                    'slug' => $post_video->slug,
                                ]);
                            @endphp
                            <div class="bg-white border border-gray-300 rounded-lg shadow-lg overflow-hidden transform transition-transform duration-300 hover:scale-105 hover:shadow-2xl hover:border-gray-400"
                                data-aos="fade-up">
                                <!-- Thumbnail Video -->
                                <a href="{{ $videoUrl }}" target="_self">
                                    <div class="relative">
                                        <img src="{{ $thumbnailUrl }}" alt="Video Thumbnail"
                                            class="w-full h-50 object-cover"
                                            onerror="this.onerror=null; this.src='{{ asset('storage/images/illustrasi/no-internet.png') }}';">
                                    </div>
                                </a>
                                <!-- Konten hasil pencarian -->
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $post_video->title }}</h3>
                                    <!-- Tanggal -->
                                    <span class="block mt-4 text-xs bg-purple-100 text-purple-800 rounded-full px-2 py-1">
                                        {{ \Carbon\Carbon::parse($post_video->created_at)->locale('id')->translatedFormat('j F Y') }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>



            <div class="mt-6 flex justify-center">
                <div class="join">
                    @if ($posts->currentPage() > 1)
                        <a href="{{ $posts->previousPageUrl() }}" class="join-item btn">«</a>
                    @else
                        <span class="join-item btn btn-disabled">«</span>
                    @endif

                    @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                        @if ($page == $posts->currentPage())
                            <span class="join-item btn btn-active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="join-item btn">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($posts->hasMorePages())
                        <a href="{{ $posts->nextPageUrl() }}" class="join-item btn">»</a>
                    @else
                        <span class="join-item btn btn-disabled">»</span>
                    @endif
                </div>
            </div>
        </div>

    </div>

@endsection
