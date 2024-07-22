@extends('components.frontend.app')

@section('title', $post->title)

@section('sidebar')
    @include('components.frontend.partials.sidebar')
@endsection

@section('content')
    <section id="post-detail" class="bg-gray-100">
        <div class="container mx-auto">
            <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg mb-8">
                <!-- Post Image -->
                @if ($post->image)
                    <div class="relative overflow-hidden rounded-lg">
                        <div class="aspect-w-2 aspect-h-1">
                            <img src="{{ Storage::url('uploads/posts/' . $post->image) }}" alt="{{ $post->title }}"
                                class="object-cover w-full h-full rounded-lg">
                        </div>
                    </div>
                @endif

                <!-- Post Title and Meta -->
                <header class="mb-6">
                    <h1 class="text-2xl sm:text-2xl font-bold tracking-tight text-gray-900">{{ $post->title }}</h1>
                    <div class="flex items-center gap-x-4 text-sm mt-2">
                        <time datetime="{{ $post->created_at->format('Y-m-d') }}" class="text-gray-500">
                            {{ $post->created_at->format('M d, Y') }}
                        </time>
                        @foreach ($post->category as $category)
                            <a href="#"
                                class="relative z-10 rounded-full bg-gray-50 px-3 py-1.5 font-medium text-gray-600 hover:bg-gray-100">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </header>

                <!-- Post Content -->
                <div class="prose max-w-none mt-6">
                    {!! $post->content !!}
                </div>

                <!-- Post Footer -->
                <footer class="mt-8 border-t border-gray-200 pt-4">
                    @if ($post->author)
                        <div class="flex items-center gap-x-4 text-sm leading-6 text-gray-600">
                            Dipost oleh
                            <div class="font-semibold text-gray-900">
                                <a href="{{ route('profile', $post->author->id) }}">
                                    {{ $post->author->name }}
                                </a>
                            </div>
                            <div>•</div>
                            <div class="text-gray-600"> {{ $post->author->role }}</div>
                            <div>•</div>
                            <div class="text-gray-600">Dilihat {{ $post->post_counter }} kali</div>
                        </div>
                    @else
                        <div class="flex items-center gap-x-4 text-sm leading-6 text-gray-600">
                            <div class="font-semibold text-gray-900">Unknown Author</div>
                            <div>•</div>
                            <div class="text-gray-600">Role Unknown</div>
                        </div>
                    @endif
                </footer>
            </div>
        </div>

        <!-- Disqus Comments -->
        @if ($post->komentar_status === 'open')
            <div class="container mx-auto">
                <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg mb-8">
                    <article class="prose max-w-none">
                        <div id="disqus_thread"></div>
                    </article>
                </div>
            </div>
        @endif
    </section>
@endsection
