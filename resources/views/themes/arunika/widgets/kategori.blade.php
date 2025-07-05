<section id="sidebar-kanan" class="bg-base" data-aos="fade-out">
    <div class="container mx-auto text-center">
        <div class="bg-white shadow-lg rounded-lg p-6 mb-4 max-w-2xl mx-auto">
            <form action="{{ route('search.results') }}" method="GET" class="relative mb-4">
                <input type="text" name="keywords" value="{{ request()->input('search') }}"
                    placeholder="Cari berita..."
                    class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <button type="submit" class="absolute inset-y-0 right-0 flex items-center pr-3" aria-label="Submit">
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
