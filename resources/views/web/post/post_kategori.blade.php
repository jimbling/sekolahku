@extends('components.frontend.app')

@section('title', $category->name)

@section('sidebar')
    @include('components.frontend.partials.sidebar')
@endsection
@section('content')
    <section id="post-detail" data-aos="fade-out">
        <div class="container mx-auto rounded-lg">
            <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">

                <section id="category-posts" class="bg-base">


                    <h1 class="text-2xl font-bold mb-4">Kategori: #{{ $category->name }}</h1>
                    <div class="relative mb-8">
                        <div class="h-1 bg-gray-300 w-full absolute top-0 left-0"></div>
                        <div class="h-1 bg-blue-800 w-1/3 absolute top-0 left-0"></div>
                    </div>
                    @if ($posts->count() > 0)
                        <div class="space-y-4">
                            @foreach ($posts as $post)
                                <a href="{{ route('posts.show', ['id' => $post->id, 'slug' => $post->slug]) }}"
                                    class="block bg-gray-100 p-4 rounded-lg shadow hover:shadow-lg transition duration-300 flex items-start space-x-4">
                                    <!-- Thumbnail -->
                                    <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}"
                                        class="w-20 h-20 object-cover rounded-lg">
                                    <div class="flex-1">
                                        <h3 class="text-md font-semibold mb-1 text-blue-600">{{ $post->title }}
                                        </h3>
                                        <p class="text-sm text-red-500">Dibaca {{ $post->post_counter }} kali</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-lg text-gray-600">Belum ada postingan di kategori ini.</p>
                    @endif


                </section>

            </div>
        </div>
    </section>
@endsection
