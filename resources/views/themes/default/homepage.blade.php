@include('themes.' . getActiveTheme() . '.components.frontend.partials.header')

<body class="bg-gray-100">
    <!-- Preloader Section -->
    @php
        $showPreloader = filter_var(get_setting('preloader'), FILTER_VALIDATE_BOOLEAN);
    @endphp

    @if ($showPreloader)
        @include('themes.' . getActiveTheme() . '.components.frontend.partials.preloader')
    @endif

    <!-- Top Nav Section -->
    @include('themes.' . getActiveTheme() . '.components.frontend.partials.top-nav')

    <!-- Nav Menu Section -->
    @include('themes.' . getActiveTheme() . '.components.frontend.partials.nav')

    <!-- Header Section -->
    <header class="header-section relative text-white overflow-x-hidden ">
        <div class="relative w-full h-full">
            <div class="header-carousel relative w-full h-full">
                @foreach ($sliders as $slider)
                    <div class="relative w-full aspect-[3/1]">
                        <img data-lazy="{{ Storage::url($slider->path) }}" alt="{{ $slider->caption }}"
                            class="absolute inset-0 w-full h-full object-cover" />
                        <div
                            class="absolute bottom-0 left-0 right-0 bg-blue-100 bg-opacity-40 text-black p-4 text-center text-sm md:text-base">
                            <p>{{ $slider->caption }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </header>


    <!-- Another Features Section -->
    <section id="feature3" class="py-3">

        @include('themes.' . getActiveTheme() . '.components.frontend.partials.stat')

        @include('themes.' . getActiveTheme() . '.components.frontend.partials.sambutan')
        <!-- Berita -->
        <section id="news" class="bg-gray-100" data-aos="fade-up">
            <div class="container mx-auto px-4">
                <div class="text-center mb-8 py-8" data-aos="fade-down">
                    <h2 class="text-3xl font-bold">
                        <span class="text-gradient">Berita Terbaru</span>
                    </h2>
                </div>
                <div class="mt-10 grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
                    @foreach ($posts as $post)
                        <div class="card-wrapper">
                            <div class="card bg-base-100 shadow-xl" data-aos="fade-up" data-aos-duration="500">
                                <figure class="w-full h-48 object-cover mb-6">
                                    @if ($post->image)
                                        <img src="{{ Storage::url('uploads/posts/' . $post->image) }}"
                                            alt="{{ $post->title }}" class="w-full h-full object-cover rounded-lg"
                                            loading="lazy" width="500" height="300" />
                                    @else
                                        <div
                                            class="bg-gray-200 w-full h-full flex items-center justify-center rounded-lg">
                                            <img src="{{ Storage::url('images/settings/' . get_setting('logo')) }}"
                                                alt="No Image Available" loading="lazy" class="h-24">
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
                                            <time datetime="{{ $post->published_at->format('Y-m-d') }}">
                                                {{ $post->published_at_indo }}
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


        {{-- Slider Galeri Foto --}}
        @include('themes.' . getActiveTheme() . '.components.frontend.partials.slider_galeri_foto')

        <!-- Recent Komentar Disqus atau Native -->
        @if ($komentarEngine === 'disqus')
            @includeIf('themes.' . getActiveTheme() . '.components.frontend.partials.recent_comments', [
                'comments' => $comments,
            ])
        @elseif ($komentarEngine === 'native')
            @includeIf(
                'themes.' . getActiveTheme() . '.components.frontend.partials.recent_comments_native',
                [
                    'comments' => $comments,
                ]
            )
        @endif

    </section>

    <!-- Footer -->
    @include('themes.' . getActiveTheme() . '.components.frontend.partials.footer')
    @push('scripts')
        <script>
            window.addEventListener('load', () => {
                setTimeout(() => {
                    const preloader = document.querySelector('.preloader');
                    if (preloader) {
                        preloader.style.display = 'none';
                    }
                }, 800); // delay biar kelihatan dulu sebentar
            });
        </script>
    @endpush
    @stack('scripts')


</body>

</html>
