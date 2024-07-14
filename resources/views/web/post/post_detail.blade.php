@extends('components.frontend.app')

@section('title', $post->title)

@section('sidebar')
    @include('components.frontend.partials.sidebar')
@endsection
@section('content')
    <section id="post-detail" data-aos="fade-out">
        <div class="container mx-auto">
            <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md mb-4">
                <article class="max-w-4xl mx-full">
                    <header class="mb-6">
                        <h1 class="text-3xl sm:text-4xl font-bold tracking-tight text-gray-900">{{ $post->title }}</h1>
                        <div class="flex items-center gap-x-4 text-xs mt-2">
                            <time datetime="{{ $post->created_at->format('Y-m-d') }}"
                                class="text-gray-500">{{ $post->created_at->format('M d, Y') }}</time>
                            @foreach ($post->category as $category)
                                <a href="#"
                                    class="relative z-10 rounded-full bg-gray-50 px-3 py-1.5 font-medium text-gray-600 hover:bg-gray-100">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </header>
                    <div class="prose max-w-none mt-6">
                        {!! $post->content !!}
                    </div>
                    <footer class="mt-8">
                        @if ($post->author)
                            <div class="flex items-center gap-x-4 text-sm leading-6">
                                Dipost oleh
                                <div class="font-semibold text-gray-900">
                                    <a href="{{ route('profile', $post->author->id) }}">
                                        {{ $post->author->name }}
                                    </a>
                                </div>
                                <div class="text-gray-600"> {{ $post->author->role }}</div>
                                <div class="text-gray-600">Dilihat {{ $post->post_counter }} kali</div>
                            </div>
                        @else
                            <div class="flex items-center gap-x-4 text-sm leading-6">
                                <div class="font-semibold text-gray-900">Unknown Author</div>
                                <div class="text-gray-600">Role Unknown</div>

                            </div>
                        @endif



                    </footer>
                </article>


            </div>



        </div>


        @if ($post->komentar_status === 'open')
            <div class="container mx-auto">
                <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md mb-4">
                    <article class="max-w-4xl mx-full">


                        <div id="disqus_thread"></div>


                        </footer>
                    </article>

                </div>
            </div>
        @endif

    </section>
@endsection
