{{-- @extends('components.frontend.app') --}}
@extends('themes.' . getActiveTheme() . '.app')

@section('title', $searchQuery)

@section('sidebar')
    {{-- @include('components.frontend.partials.sidebar') --}}
    @include('themes.' . getActiveTheme() . '.components.frontend.partials.sidebar')
@endsection

@section('content')
    <section id="post-detail" data-aos="fade-out">
        <div class="container mx-auto rounded-lg">
            <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
                <section id="category-posts" class="bg-base">
                    <h1 class="text-2xl font-bold mb-4">Pencarian: #{{ $searchQuery }}</h1>
                    <div class="relative mb-8">
                        <div class="h-1 bg-gray-300 w-full absolute top-0 left-0"></div>
                        <div class="h-1 bg-blue-800 w-1/3 absolute top-0 left-0"></div>
                    </div>
                    <div class="space-y-6 text-left">
                        @forelse ($posts as $post)
                            <div
                                class="bg-green-50 p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                                <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $post->title }}</h2>
                                <p class="text-gray-700 mb-4">{{ $post->excerpt }}</p>
                                <a href="{{ route('posts.show', ['id' => $post->id, 'slug' => $post->slug]) }}"
                                    class="inline-block px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300">Baca
                                    selengkapnya</a>
                            </div>
                        @empty
                            <div class="bg-yellow-100 p-6 rounded-lg shadow-md text-center">
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">Tidak ada postingan yang ditemukan</h3>
                                <p class="text-gray-600">Cobalah mencari dengan kata kunci yang berbeda.</p>
                            </div>
                        @endforelse
                    </div>


                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $posts->links() }} <!-- Menampilkan pagination default -->
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection
