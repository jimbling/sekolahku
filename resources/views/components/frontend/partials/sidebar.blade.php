@php
    $currentUrl = request()->path(); // Mendapatkan path dari URL saat ini
@endphp


<section id="sidebar-kanan" class="bg-base" data-aos="fade-out">
    <div class="container mx-auto text-center">
        <div class="bg-white shadow-lg rounded-lg p-6 mb-4 max-w-2xl mx-auto">
            <form action="{{ route('search.results') }}" method="GET" class="relative mb-4">
                <input type="text" name="keywords" value="{{ request()->input('search') }}"
                    placeholder="Cari berita..."
                    class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <button type="submit" class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 hover:text-indigo-500"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M12.9 14.32a8 8 0 111.42-1.42l4.24 4.24-1.42 1.42-4.24-4.24zm-4.9-9.32a6 6 0 100 12 6 6 0 000-12z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </form>
            <div>
                <h2 class="text-lg text-left font-semibold mb-2">KATEGORI</h2>
                <div class="relative mb-8">
                    <div class="h-1 bg-gray-300 w-full absolute top-0 left-0"></div>
                    <div class="h-1 bg-blue-800 w-1/3 absolute top-0 left-0"></div>
                </div>
                <div class="space-y-4 text-left">
                    @foreach ($categories as $category)
                        <a href="{{ route('category.posts', ['slug' => $category->slug]) }}"
                            class="{{ $category->colorClass }} p-4 rounded-lg shadow hover:shadow-lg transition duration-300 flex items-center space-x-3 block">
                            <!-- Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="w-6 h-6 text-yellow-600">
                                <path
                                    d="M19.5 21a3 3 0 0 0 3-3v-4.5a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3V18a3 3 0 0 0 3 3h15ZM1.5 10.146V6a3 3 0 0 1 3-3h5.379a2.25 2.25 0 0 1 1.59.659l2.122 2.121c.14.141.331.22.53.22H19.5a3 3 0 0 1 3 3v1.146A4.483 4.483 0 0 0 19.5 9h-15a4.483 4.483 0 0 0-3 1.146Z" />
                            </svg>
                            <div>
                                <span class="text-md font-semibold">{{ $category->name }}</span>
                                <span class="text-sm text-gray-600">({{ $category->posts_count }})</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>







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
                                    alt="Thumbnail" class="w-20 h-20 object-cover rounded-lg">
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





{{-- <section id="announcements" class="py- bg-base" data-aos="fade-out">
    <div class="container mx-auto text-center">
        <!-- Announcement Card -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-4 max-w-2xl mx-auto">
            <h2 class="text-3xl font-bold mb-4">Pengumuman</h2>
            <div class="relative mb-8">
                <div class="h-1 bg-gray-300 w-full absolute top-0 left-0"></div>
                <div class="h-1 bg-blue-800 w-1/3 absolute top-0 left-0"></div>
            </div>
            <!-- Announcement Item -->
            <div class="flex items-start mb-6 border-b border-gray-300 pb-4">
                <!-- Icon -->
                <div class="flex-shrink-0 mr-4">
                    <svg class="w-8 h-8 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z" />
                    </svg>
                </div>

                <!-- Content -->
                <div class="flex-1">
                    <h3 class="text-xl font-semibold mb-1">Pengumuman Judul</h3>
                    <p class="text-sm text-gray-600">Tanggal: 13 Juli 2024</p>
                </div>
            </div>

            <!-- Add more announcement items here -->

            <!-- Button to view more announcements -->
            <button onclick="window.location.href='/pengumuman';"
                class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg focus:outline-none transition">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd"
                        d="M15.75 2.25H21a.75.75 0 0 1 .75.75v5.25a.75.75 0 0 1-1.5 0V4.81L8.03 17.03a.75.75 0 0 1-1.06-1.06L19.19 3.75h-3.44a.75.75 0 0 1 0-1.5Zm-10.5 4.5a1.5 1.5 0 0 0-1.5 1.5v10.5a1.5 1.5 0 0 0 1.5 1.5h10.5a1.5 1.5 0 0 0 1.5-1.5V10.5a.75.75 0 0 1 1.5 0v8.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V8.25a3 3 0 0 1 3-3h8.25a.75.75 0 0 1 0 1.5H5.25Z"
                        clip-rule="evenodd" />
                </svg>

                Selengkapnya
            </button>
        </div>
    </div>
</section> --}}

{{-- <section id="sidebar" class="py- bg-white rounded-lg" data-aos="fade-out">
    <div class="container mx-auto text-center">
        <div class="bg-white shadow-md rounded-lg p-6 mb-4">
            <div class="flex justify-center">
                <img src="{{ asset('storage/images/settings/' . get_setting('headmaster_photo')) }}"
                    class="max-w-sm rounded-lg shadow-2xl" />
            </div>
            <div class="max-w-md mx-auto">
                <h1 class="text-2xl font-bold">Sambutan Kepala Sekolah</h1>
                <p class="py-6 text-left overflow-hidden max-h-24"
                    style="display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical;">
                    Assalamu'alaikum Wr. Wb.

                    Di masa sekarang penyampaian informasi tidak terbatas hanya pada surat, namun juga media sosial juga
                    sangat berpengaruh. Untuk itu, SD Negeri Kedungrejo telah merilis website resmi SD Negeri Kedungrejo
                    Kapanewon Pengasih. Dengan adanya website ini, semoga informasi-informasi dapat dengan mudah
                    diakses.
                    Kegiatan-kegiatan yang dilaksanakan di SD Negeri Kedungrejo juga dapat diketahui oleh publik yang
                    lebih luas lagi.

                    Wassalamu'alaikum Wr. Wb.
                </p>
                <h1 class="text-xs font-bold">{{ get_setting('headmaster') }}</h1>
            </div>
        </div>
    </div>
</section> --}}
