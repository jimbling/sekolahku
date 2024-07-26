@include('components.frontend.partials.header')

<body class="bg-gray-100">
    <!-- Preloader Section -->
    @php
        $showPreloader = get_setting('preloader') === 'true'; // Mengambil nilai preloader dari database
    @endphp

    @if ($showPreloader)
        @include('components.frontend.partials.preloader')
    @endif

    <!-- Top Nav Section -->
    @include('components.frontend.partials.top-nav')

    <!-- Nav Menu Section -->
    @include('components.frontend.partials.nav')

    <!-- Header Section -->
    <header
        class="header-section relative bg-gradient-to-r from-blue-500 via-teal-500 to-green-500 text-white py-8 md:py-16">
        <div class="container mx-auto px-4">
            <!-- Content Wrapper -->
            <div class="flex flex-col md:flex-row items-center justify-between">
                <!-- Left Side (Title and Description) -->
                <div class="flex-1 text-center md:text-left">
                    <!-- New Welcome Box -->
                    <div
                        class="bg-gray-200 text-blue-800 p-2 rounded-lg mb-4 max-w-xs mx-auto md:mx-0 animate__animated animate__fadeInDown">
                        <p class="text-lg font-semibold text-center">Selamat Datang di Website</p>
                    </div>

                    <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-4 animate__animated animate__fadeInLeft">
                        {{ get_setting('school_name') }}
                    </h1>
                    <p class="text-lg md:text-2xl leading-tight mb-4 italic animate__animated animate__fadeInUp">
                        {{ get_setting('tagline') }}
                    </p>

                    <div class="w-full max-w-xl mx-auto md:mx-0 mt-6 animate__animated animate__fadeInUp">
                        <form action="{{ route('search.results') }}" method="GET" class="flex items-center">
                            <div class="relative w-full">
                                <input type="text" name="keywords" value="{{ request()->input('search') }}"
                                    placeholder="Cari berita di sini..."
                                    class="w-full h-12 px-4 py-2 pr-20 rounded-lg border-0 focus:outline-none focus:ring-2 focus:ring-blue-400 text-gray-900 placeholder-gray-500">
                                <button type="submit"
                                    class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-lg transition duration-300 hover:shadow-xl active:bg-blue-800 active:scale-95">
                                    Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right Side (Optional Image or Extra Content) -->
                <div class="flex-1 mt-8 md:mt-0 animate__animated animate__fadeIn">
                    <img src="{{ asset('storage/images/settings/' . get_setting('header')) }}" alt="Hero Image"
                        class="w-full h-auto max-w-md mx-auto" />
                </div>
            </div>
        </div>
    </header>

    <!-- Another Features Section -->
    <section id="feature3" class="py-6">

        @include('components.frontend.partials.stat')

        @include('components.frontend.partials.sambutan')

        <!-- Berita -->
        <section id="news" class="bg-gray-100" data-aos="fade-up">
            <div class="container mx-auto px-4">
                <div class="mt-10 grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
                    @foreach ($posts as $post)
                        <div class="card-wrapper">
                            <div class="card bg-base-100 shadow-xl" data-aos="fade-up" data-aos-duration="500">
                                <figure class="w-full h-48 object-cover mb-6">
                                    @if ($post->image)
                                        <img src="{{ Storage::url('uploads/posts/' . $post->image) }}"
                                            alt="{{ $post->title }}" class="w-full h-full object-cover rounded-lg" />
                                    @else
                                        <div
                                            class="bg-gray-200 w-full h-full flex items-center justify-center rounded-lg">
                                            <img src="{{ Storage::url('images/settings/' . get_setting('logo')) }}"
                                                alt="No Image Available" class="h-24">
                                        </div>
                                    @endif
                                </figure>
                                <div class="card-body p-4">
                                    <h2 class="card-title text-lg font-semibold">
                                        <a
                                            href="{{ route('posts.show', ['id' => $post->id, 'slug' => $post->slug]) }}">{{ $post->title }}</a>
                                        @if ($post->category->isNotEmpty())
                                            <div class="badge badge-secondary ml-2">
                                                {{ $post->category->first()->name }}
                                            </div>
                                        @endif
                                    </h2>
                                    <p class="text-sm">{{ $post->excerpt }}</p>
                                    <div class="card-actions flex justify-between items-center mt-4">
                                        <div class="badge badge-outline">
                                            <time datetime="{{ $post->created_at->format('Y-m-d') }}">
                                                {{ $post->created_at->format('M d, Y') }}
                                            </time>
                                        </div>
                                        <a href="{{ route('posts.show', ['id' => $post->id, 'slug' => $post->slug]) }}"
                                            class="text-sm text-white bg-blue-500 rounded-lg py-2 px-4">
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

        <!-- Recent Komentar Disqus -->
        @include('components.frontend.partials.recent_comments')

    </section>

    <!-- Footer -->
    @include('components.frontend.partials.footer')

</body>

</html>
