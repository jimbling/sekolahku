<div class="py-10 bg-gradient-to-br from-gray-50 to-gray-100 relative z-10">
    <div class="container mx-auto px-2 sm:px-6 lg:px-8">

        {{-- Section Header --}}
        <header class="text-center mb-16" data-aos="fade-down">
            <span
                class="inline-block px-3 py-1 text-sm font-semibold text-blue-600 bg-blue-50 rounded-full mb-4 animate-pulse">
                Update Terbaru
            </span>
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Berita dan Pengumuman</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Ikuti terus berita dan pengumuman terbaru kami</p>
            <div class="mt-8 mx-auto w-24 h-1 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full"></div>
        </header>

        @if ($posts->isEmpty())
            {{-- Empty State --}}
            <section
                class="bg-white rounded-2xl shadow-sm p-12 text-center border-2 border-dashed border-gray-200 hover:border-blue-200 transition-colors duration-300"
                data-aos="fade-up">
                <div class="max-w-md mx-auto">
                    <div class="mb-8">
                        <svg class="w-40 h-40 mx-auto text-gray-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Berita Tersedia</h3>
                    <p class="text-gray-500 mb-6">Saat ini tidak ada berita atau pengumuman yang tersedia. Silakan
                        periksa kembali nanti untuk update terbaru dari kami.</p>
                </div>
            </section>
        @else
            {{-- News Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-8">
                @foreach ($posts as $post)
                    <article
                        class="group relative bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-100 hover:border-blue-100 transform hover:-translate-y-1"
                        data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        {{-- Gambar --}}
                        <div class="relative h-60 overflow-hidden">
                            @if ($post->image)
                                <img src="{{ Storage::url('uploads/posts/' . $post->image) }}" alt="{{ $post->title }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                    loading="lazy" />
                            @else
                                <div class="bg-gray-200 w-full h-full flex items-center justify-center rounded-lg">
                                    <img src="{{ Storage::url('images/settings/' . get_setting('logo')) }}"
                                        alt="No Image Available" loading="lazy" class="h-24">
                                </div>
                            @endif
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                            <div class="absolute top-4 right-4">
                                <span
                                    class="px-3 py-1 text-xs font-semibold text-white bg-blue-500 rounded-full backdrop-blur-sm">
                                    @if ($post->category->isNotEmpty())
                                        {{ $post->category->first()->name }}
                                    @endif
                                </span>
                            </div>
                        </div>

                        {{-- Konten --}}
                        <div class="p-6">
                            <div class="flex items-center text-gray-500 text-sm mb-3">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <time
                                    datetime="{{ $post->published_at->format('Y-m-d') }}">{{ $post->published_at_indo }}</time>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3 leading-snug">
                                <a href="{{ route('posts.show', ['id' => $post->id, 'slug' => $post->slug]) }}"
                                    class="hover:text-blue-600 transition-colors">{{ $post->title }}</a>
                            </h3>
                            <p class="text-gray-600 mb-5 line-clamp-2">{{ $post->excerpt }}</p>
                            <div class="flex items-center justify-between">
                                <a href="{{ route('posts.show', ['id' => $post->id, 'slug' => $post->slug]) }}"
                                    class="text-blue-600 font-medium hover:text-blue-800 inline-flex items-center transition-colors">
                                    Selengkapnya
                                    <svg class="w-4 h-4 ml-2 -mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                                <div class="text-gray-400 text-sm">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    {{ $post->post_counter }} dilihat
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Tombol Lihat Semua --}}
            <div class="text-center mt-12" data-aos="fade-up" data-aos-delay="500">
                <a href="/berita"
                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-blue-600 hover:bg-blue-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Lihat semua Berita
                </a>
            </div>
        @endif
    </div>
</div>
