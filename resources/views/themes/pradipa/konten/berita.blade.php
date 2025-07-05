@extends('themes.' . getActiveTheme() . '.app')

@section('title', 'Indeks Berita')
@section('sidebar')
    @include('themes.' . getActiveTheme() . '.components.frontend.partials.sidebar')
@endsection

@section('content')
    <div class="container mx-auto ">
        <!-- Grid Layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($posts as $post)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-blue-100"
                    data-aos="fade-up" data-aos-duration="600" data-aos-easing="ease-out-cubic">

                    <!-- Clickable Image Container -->
                    <a href="{{ route('posts.show', ['id' => $post->id, 'slug' => $post->slug]) }}"
                        class="block relative h-48 w-full overflow-hidden group">
                        @if ($post->image)
                            <img src="{{ Storage::url('uploads/posts/' . $post->image) }}" alt="{{ $post->title }}"
                                loading="lazy"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                <img src="{{ Storage::url('images/settings/' . get_setting('logo')) }}"
                                    alt="No Image Available" loading="lazy" class="h-16 opacity-70">
                            </div>
                        @endif
                        <!-- Date Badge -->
                        <div
                            class="absolute bottom-3 left-3 bg-white/90 text-gray-800 text-xs font-medium px-3 py-1 rounded-full shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                            {{ \Carbon\Carbon::parse($post->published_at)->translatedFormat('d M Y') }}
                        </div>
                        <!-- Overlay Effect -->
                        <div class="absolute inset-0 bg-black/5 group-hover:bg-black/10 transition-colors duration-300">
                        </div>
                    </a>

                    <!-- Content Container -->
                    <div class="p-5">
                        <!-- Title -->
                        <h3 class="text-lg font-semibold text-gray-800 mb-3 group">
                            <a href="{{ route('posts.show', ['id' => $post->id, 'slug' => $post->slug]) }}"
                                class="relative inline-block transition-colors duration-200 hover:text-[#0d5c52]">
                                <span class="relative">
                                    {{ $post->title }}
                                    <span
                                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#0d5c52] transition-all duration-300 group-hover:w-full"></span>
                                </span>
                            </a>
                        </h3>

                        <!-- Excerpt -->
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            {{ $post->excerpt }}
                        </p>

                        <!-- Read More Button -->
                        <a href="{{ route('posts.show', ['id' => $post->id, 'slug' => $post->slug]) }}"
                            class="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm font-medium transition-all duration-200 group">
                            Baca Selengkapnya
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 ml-1 transform group-hover:translate-x-1 transition-transform duration-200"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg" data-aos="fade-up"
                    data-aos-duration="400">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Tidak ada postingan yang ditemukan. Cobalah mencari dengan kata kunci yang berbeda.
                            </p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($posts->hasPages())
            <div class="mt-10 flex justify-center" data-aos="fade-up" data-aos-duration="500" data-aos-delay="100">
                <nav class="flex items-center space-x-1">
                    <!-- Previous Button -->
                    @if ($posts->onFirstPage())
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-md bg-gray-100 text-gray-400 cursor-not-allowed">
                            &laquo;
                        </span>
                    @else
                        <a href="{{ $posts->previousPageUrl() }}"
                            class="inline-flex items-center px-3 py-1 rounded-md bg-gray-100 text-gray-700 hover:bg-blue-600 hover:text-white transition-colors duration-200">
                            &laquo;
                        </a>
                    @endif

                    <!-- Page Numbers -->
                    @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                        @if ($page == $posts->currentPage())
                            <span class="inline-flex items-center px-3 py-1 rounded-md bg-blue-600 text-white shadow-sm">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                                class="inline-flex items-center px-3 py-1 rounded-md bg-gray-100 text-gray-700 hover:bg-blue-100 hover:text-blue-600 transition-colors duration-200">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    <!-- Next Button -->
                    @if ($posts->hasMorePages())
                        <a href="{{ $posts->nextPageUrl() }}"
                            class="inline-flex items-center px-3 py-1 rounded-md bg-gray-100 text-gray-700 hover:bg-blue-600 hover:text-white transition-colors duration-200">
                            &raquo;
                        </a>
                    @else
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-md bg-gray-100 text-gray-400 cursor-not-allowed">
                            &raquo;
                        </span>
                    @endif
                </nav>
            </div>
        @endif
    </div>

    <!-- Initialize AOS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 600,
                easing: 'ease-out-cubic',
                once: true,
                offset: 120,
                delay: 100
            });
        });
    </script>
@endsection
