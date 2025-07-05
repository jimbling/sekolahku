@if (!str_starts_with($currentUrl, 'pages/'))
    <section id="artikel-populer" class="bg-base" data-aos="fade-out">
        <div class="container mx-auto text-center">
            <div class="bg-white shadow-lg rounded-lg p-6 mb-4 max-w-2xl mx-auto">
                <div>
                    <h2 class="text-lg text-left font-semibold mb-2">ARTIKEL POPULER</h2>
                    <div class="relative mb-8">
                        <div class="h-1 bg-gray-300 w-full absolute top-0 left-0"></div>
                        <div class="h-1 bg-blue-800 w-1/3 absolute top-0 left-0"></div>
                    </div>
                    <div class="space-y-4 text-left">
                        @foreach ($popularArticles as $article)
                            <a href="{{ route('posts.show', ['id' => $article->id, 'slug' => $article->slug]) }}"
                                class="block bg-orange-100 p-4 rounded-lg shadow hover:shadow-lg transition duration-300 flex items-start space-x-4">
                                <!-- Thumbnail -->
                                <img src="{{ $article->image ? Storage::url('uploads/posts/' . $article->image) : 'https://via.placeholder.com/80' }}"
                                    alt="Thumbnail" loading="lazy" class="w-20 h-20 object-cover rounded-lg">
                                <div class="flex-1">
                                    <h3 class="text-md font-semibold mb-1 text-blue-600">{{ $article->title }}</h3>
                                    <p class="text-sm text-red-500">Dibaca {{ $article->post_counter }} kali</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
