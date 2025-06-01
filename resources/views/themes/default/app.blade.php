<!-- Bagian Header -->
@include('themes.' . getActiveTheme() . '.components.frontend.partials.header')


<body class="bg-gray-100">
    @php
        $showPreloader = get_setting('preloader') === 'true';
    @endphp

    @if ($showPreloader)
        @include('themes.' . getActiveTheme() . '.components.frontend.partials.preloader')
    @endif

    <!-- Top Nav Section -->
    @include('themes.' . getActiveTheme() . '.components.frontend.partials.top-nav')

    <!-- Nav Menu Section -->
    @include('themes.' . getActiveTheme() . '.components.frontend.partials.nav')

    <!-- Hero Section (Carousel) -->
    @stack('hero')

    <h2 class="text-lg font-bold text-gray-500 text-center py-6 px-4 md:px-6">
        <span class="relative">
            @if (Route::currentRouteName() == 'posts.show')
                <nav aria-label="Breadcrumb" class="inline-block md:w-auto mx-auto">
                    <div class="bg-white shadow-lg rounded-2xl p-4 inline-block">
                        <ol class="list-none p-0 inline-flex items-center space-x-2 text-sm">
                            <li class="flex items-center">
                                <a href="{{ route('web.home') }}" class="text-blue-600 hover:underline">Home</a>
                                <svg class="fill-current w-3 h-3 mx-2 text-gray-400" viewBox="0 0 24 24">
                                    <path d="M9 18l6-6-6-6"></path>
                                </svg>
                            </li>
                            <li class="flex items-center">
                                <a href="{{ route('category.posts', ['slug' => $category->slug]) }}"
                                    class="text-blue-600 hover:underline">{{ $category->name }}</a>
                                <svg class="fill-current w-3 h-3 mx-2 text-gray-400" viewBox="0 0 24 24">
                                    <path d="M9 18l6-6-6-6"></path>
                                </svg>
                            </li>
                            <li>
                                <span class="breadcrumb-title text-gray-500">{{ $post->title }}</span>
                            </li>
                        </ol>
                    </div>
                </nav>
            @else
                <h2 class="text-3xl font-bold text-gray-500 text-center w-full">
                    <span class="relative inline-block">
                        @yield('title')
                        <span
                            class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-3 h-1 w-16 bg-blue-800"></span>
                    </span>
                </h2>
            @endif
        </span>
    </h2>


    <!-- Another Features Section -->
    <div class="container mx-auto">



        <section id="main" class="min-h-screen flex flex-col md:flex-row mx-0 md:mx-4">

            <!-- Left Section -->
            <div class="w-full md:w-3/4 p-4">
                @yield('content')
                <!-- Left side content here -->
            </div>

            <!-- Right Section -->
            <div class="w-full md:w-1/3 p-4">
                @yield('sidebar')
            </div>

        </section>
    </div>
    <!-- Footer -->
    @include('themes.' . getActiveTheme() . '.components.frontend.partials.footer')
    @stack('scripts')
</body>

</html>
