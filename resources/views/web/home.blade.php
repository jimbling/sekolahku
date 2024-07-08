@extends('components.frontend.app')

@section('title', 'Home Page')

@section('content')


    <section id="news" class="py-20 bg-gray-100">

        <div class="bg-white py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:mx-0">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">From the blog</h2>
                    <p class="mt-2 text-lg leading-8 text-gray-600">Learn how to grow your business with our expert advice.
                    </p>
                </div>
                <div
                    class="mx-auto mt-10 grid max-w-2xl grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-16 border-t border-gray-200 pt-10 sm:mt-16 sm:pt-16 lg:mx-0 lg:max-w-none">
                    @foreach ($posts as $post)
                        <article class="flex max-w-xl flex-col items-start justify-between">
                            <div class="flex items-center gap-x-4 text-xs">
                                <time datetime="{{ $post->created_at->format('Y-m-d') }}"
                                    class="text-gray-500">{{ $post->created_at->format('M d, Y') }}</time>
                                @if ($post->category->isNotEmpty())
                                    <a href="#"
                                        class="relative z-10 rounded-full bg-gray-50 px-3 py-1.5 font-medium text-gray-600 hover:bg-gray-100">
                                        {{ $post->category->first()->name }}
                                    </a>
                                @endif
                            </div>
                            <div class="group relative">
                                <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                                    <a href="{{ route('posts.show', ['id' => $post->id, 'slug' => $post->slug]) }}">
                                        <span class="absolute inset-0"></span>
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                <p class="mt-5 line-clamp-3 text-sm leading-6 text-gray-600">{{ $post->excerpt }}</p>
                            </div>
                            <div class="relative mt-8 flex items-center gap-x-4">
                                {{-- Cek apakah ada penulis (author) --}}
                                @if ($post->author)
                                    <div class="text-sm leading-6">
                                        <p class="font-semibold text-gray-900">
                                            <a href="{{ route('profile', $post->author->id) }}">
                                                {{ $post->author->name }}
                                            </a>
                                        </p>
                                        <p class="text-gray-600">{{ $post->author->role }}</p>
                                    </div>
                                @else
                                    <div class="text-sm leading-6">
                                        <p class="font-semibold text-gray-900">Unknown Author</p>
                                        <p class="text-gray-600">Role Unknown</p>
                                    </div>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>

            </div>
        </div>


    </section>

    <section id="about" class="py-20 bg-blue-600 text-white" data-aos="fade-left">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold">About Us</h2>
            <p class="mt-4">We are dedicated to providing the best solutions for modern web development.</p>
        </div>
    </section>

    <section id="contact" class="py-20 bg-gray-100" data-aos="fade-up">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold">Hubungi Kami</h2>
            <form action="#" method="POST" class="mt-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <input type="text" placeholder="Your Name" class="p-4 border rounded-lg">
                    <input type="email" placeholder="Your Email" class="p-4 border rounded-lg">
                </div>
                <textarea placeholder="Your Message" class="p-4 border rounded-lg mt-4 w-full"></textarea>
                <button type="submit" class="mt-4 bg-blue-600 text-white px-6 py-2 rounded-lg">Send Message</button>
            </form>
        </div>
    </section>
@endsection
