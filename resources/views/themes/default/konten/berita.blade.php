{{-- @extends('components.frontend.app') --}}
@extends('themes.' . getActiveTheme() . '.app')

@section('title', 'Indeks Berita')
@section('sidebar')
    {{-- @include('components.frontend.partials.sidebar') --}}
    @include('themes.' . getActiveTheme() . '.components.frontend.partials.sidebar')
@endsection
@section('content')

    <section id="indeks-berita" class="bg-gray-100">
        <div class="container mx-auto">
            <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg mb-8">
                <div class="space-y-4"> <!-- Mengurangi jarak antar postingan -->
                    @forelse ($posts as $post)
                        <div class="bg-blue-50 p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-2 relative overflow-hidden"
                            data-aos="fade-up">
                            <!-- Badge -->
                            <div
                                class="absolute top-0 right-0 mt-2 mr-2 bg-red-500 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-md z-30">
                                {{ \Carbon\Carbon::parse($post->published_at)->translatedFormat('l, d M Y') }}
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                @if ($post->image)
                                    <div class="relative overflow-hidden rounded-lg mt-4 mb-4">
                                        <img src="{{ Storage::url('uploads/posts/' . $post->image) }}"
                                            alt="{{ $post->title }}" loading="lazy"
                                            class="object-cover w-full h-48 lg:h-60 rounded-lg transition-transform duration-300 ease-in-out transform hover:scale-105 z-90">
                                    </div>
                                @else
                                    <div class="bg-gray-200 w-full h-full flex items-center justify-center rounded-lg">
                                        <img src="{{ Storage::url('images/settings/' . get_setting('logo')) }}"
                                            alt="No Image Available" loading="lazy" class="h-24">
                                    </div>
                                @endif
                                <div class="flex flex-col justify-center">
                                    <h2
                                        class="text-xl font-semibold text-gray-800 mb-2 mt-2 hover:text-blue-600 transition-colors duration-300">
                                        {{ $post->title }}</h2>
                                    <p class="text-gray-700 mb-4">{{ $post->excerpt }}</p>
                                    <a href="{{ route('posts.show', ['id' => $post->id, 'slug' => $post->slug]) }}"
                                        class="inline-flex items-center justify-center px-6 py-3 bg-blue-500 text-white rounded-md shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 transition-transform transform hover:scale-105 active:scale-95 text-base sm:text-sm md:text-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M10 6l6 6-6 6"></path>
                                        </svg>
                                        <span class="text-center">
                                            <span class="hidden md:inline">Baca Selengkapnya</span>
                                            <span class="md:hidden">Selengkapnya</span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>

                    @empty
                        <div class="bg-yellow-100 p-6 rounded-lg shadow-md text-center">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Tidak ada postingan yang ditemukan</h3>
                            <p class="text-gray-600">Cobalah mencari dengan kata kunci yang berbeda.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-6 flex justify-center">
                    <!-- Pagination -->
                    <div class="join">
                        <!-- Previous Button -->
                        @if ($posts->onFirstPage())
                            <span class="join-item btn btn-square opacity-50 cursor-not-allowed">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M15.293 17.293a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L13.414 12l2.879 2.879a1 1 0 010 1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        @else
                            <a href="{{ $posts->previousPageUrl() }}" class="join-item btn btn-square">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M15.293 17.293a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L13.414 12l2.879 2.879a1 1 0 010 1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        @endif

                        <!-- Page Numbers -->
                        @for ($i = 1; $i <= $posts->lastPage(); $i++)
                            @if ($i == $posts->currentPage())
                                <span class="join-item btn btn-square bg-blue-500 text-white">{{ $i }}</span>
                            @else
                                <a href="{{ $posts->url($i) }}" class="join-item btn btn-square">{{ $i }}</a>
                            @endif
                        @endfor

                        <!-- Next Button -->
                        @if ($posts->hasMorePages())
                            <a href="{{ $posts->nextPageUrl() }}" class="join-item btn btn-square">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M8.707 17.293a1 1 0 001.414 0l4-4a1 1 0 000-1.414l-4-4a1 1 0 00-1.414 1.414L11.586 12l-2.879 2.879a1 1 0 000 1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        @else
                            <span class="join-item btn btn-square opacity-50 cursor-not-allowed">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M8.707 17.293a1 1 0 001.414 0l4-4a1 1 0 000-1.414l-4-4a1 1 0 00-1.414 1.414L11.586 12l-2.879 2.879a1 1 0 000 1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </section>



@endsection
