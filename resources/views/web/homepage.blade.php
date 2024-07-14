<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Home Page')</title>
    @vite('resources/css/app.css')
    <style>
        /* Custom styles for the dropdown */
        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .card:hover {
            transform: scale(1.05);
        }
    </style>

</head>

<body class="bg-gray-100">



    <!-- Sticky Menu Section -->
    @include('components.frontend.partials.nav')


    <!-- Header Section (Carousel) -->
    <header class="relative bg-gradient-to-r from-blue-500 via-teal-500 to-green-500 text-white py-16">
        <div class="container mx-auto px-4">
            <!-- Content Wrapper -->
            <div class="flex flex-col md:flex-row items-center justify-between">
                <!-- Left Side (Title and Description) -->
                <div class="flex-">
                    <!-- New Welcome Box -->
                    <div class="bg-gray-200 text-blue-800 p-2 rounded-lg mb-2 max-w-xs mx-auto md:mx-0">
                        <p class="text-lg font-semibold text-center">Selamat Datang di Website</p>
                    </div>

                    <h1 class="text-6xl md:text-6xl font-bold leading-tight mb-4">
                        {{ get_setting('school_name') }}
                    </h1>
                    <p class="text-2xl md:text-1xl leading-tight mb-4 italic">
                        {{ get_setting('tagline') }}
                    </p>

                </div>

                <!-- Right Side (Optional Image or Extra Content) -->
                <div class="flex-1 mt-8 md:mt-0">
                    <img src="{{ asset('storage/images/settings/' . get_setting('header')) }}" alt="Hero Image"
                        class="h-auto max-w-md mx-auto" />
                </div>
            </div>
        </div>
    </header>




    <!-- Another Features Section -->
    <section id="feature3" class="py-">

        @include('components.frontend.partials.stat')

        @include('components.frontend.partials.sambutan')
        <!-- Features Section -->
        <section id="news" class="py-10 bg-gray-100" data-aos="fade-up">
            <div class="container mx-auto px-4">
                <div class="mt-10 grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
                    @foreach ($posts as $post)
                        <div class="card-wrapper">
                            <div class="card bg-base-100 shadow-xl" data-aos="fade-up" data-aos-duration="500">
                                <figure>
                                    <img src="{{ $post->image_url ? $post->image_url : 'https://sdnkedungrejo.sch.id/media_library/posts/large/1cbbd844f30269b93c243779a6bac373.jpg' }}"
                                        alt="{{ $post->title }}" class="w-full h-48 object-cover" />
                                </figure>
                                <div class="card-body">
                                    <h2 class="card-title">
                                        <a
                                            href="{{ route('posts.show', ['id' => $post->id, 'slug' => $post->slug]) }}">{{ $post->title }}</a>
                                        @if ($post->category->isNotEmpty())
                                            <div class="badge badge-secondary ml-2">{{ $post->category->first()->name }}
                                            </div>
                                        @endif
                                    </h2>
                                    <p>{{ $post->excerpt }}</p>
                                    <div class="card-actions flex justify-between items-center">
                                        <div class="badge badge-outline">
                                            <time datetime="{{ $post->created_at->format('Y-m-d') }}">
                                                {{ $post->created_at->format('M d, Y') }}
                                            </time>
                                        </div>
                                        <a href="{{ route('posts.show', ['id' => $post->id, 'slug' => $post->slug]) }}"
                                            class="text-sm text-white bg-blue-500 rounded-lg py-2 px-4 mt-2">
                                            Selengkapnya &rarr;
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Footer -->
        @include('components.frontend.partials.recent_comments')




    </section>

    <!-- Footer -->
    @include('components.frontend.partials.footer')



</body>

</html>
