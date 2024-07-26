@extends('components.frontend.app_statis')

@section('title', 'Detail Video')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl rounded-lg overflow-hidden p-5">

            <header class="mb-8">
                <h1 class="text-xl font-bold tracking-tight text-gray-900">{{ $post->title }}</h1>

                <!-- Garis Pemisah dengan Gradien -->
                <div class="relative mt-4">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full h-1 bg-gradient-to-r from-blue-400 via-purple-500 to-pink-500"></div>
                    </div>
                </div>

                <div class="flex items-center gap-x-4 text-xs mt-8">
                    @php
                        use Carbon\Carbon;
                        $createdAt = Carbon::parse($post->created_at);
                        $formattedDate = $createdAt->translatedFormat('l, d F Y');
                    @endphp
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                        <path
                            d="M12.75 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM7.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8.25 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM9.75 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM10.5 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM12.75 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM14.25 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 13.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
                        <path fill-rule="evenodd"
                            d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z"
                            clip-rule="evenodd" />
                    </svg>

                    <time datetime="{{ $createdAt->format('Y-m-d') }}" class="text-gray-500">
                        {{ $formattedDate }}
                    </time>

                    @if ($post->author)
                        <div class="flex items-center gap-x-4 text-xs leading-6 text-gray-600">
                            <div><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-4 h-4">
                                    <path fill-rule="evenodd"
                                        d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                                        clip-rule="evenodd" />
                                </svg></div>
                            <div class="font-semibold text-gray-900 text-xs">
                                <a href="{{ route('profile', $post->author->id) }}">
                                    {{ $post->author->name }}
                                </a>
                            </div>
                            <div class="text-gray-600 text-xs"> {{ $post->author->role }}</div>
                            <div><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-4 h-4">
                                    <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                    <path fill-rule="evenodd"
                                        d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                        clip-rule="evenodd" />
                                </svg></div>
                            <div class="text-gray-600 text-xs">{{ $post->post_counter }}</div>
                        </div>
                    @else
                        <div class="flex items-center gap-x-4 text-xs leading-6 text-gray-600">
                            <div class="font-semibold text-gray-900">Unknown Author</div>
                            <div>•</div>
                            <div class="text-gray-600">Role Unknown</div>
                        </div>
                    @endif
                </div>
            </header>

            <!-- Cards for Video and Details -->
            <div class="flex flex-col lg:flex-row gap-4 mb-8">
                <!-- Video Embed Card -->
                <div class="flex-1 rounded-lg shadow-md">
                    <div class="relative rounded-xl overflow-hidden" style="padding-top: 56.25%;">
                        <iframe class="absolute inset-0 w-full h-full"
                            src="https://www.youtube.com/embed/{{ trim($post->content) }}" frameborder="0"
                            allowfullscreen></iframe>
                    </div>
                </div>

                <!-- Related Videos Card -->
                <div class="flex-1 bg-gray-100 p-4 rounded-xl shadow-md">
                    <h2 class="text-lg font-semibold mb-4">Video Lainnya</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($relatedPosts as $related)
                            <a href="{{ route('web.videos.detail', ['id' => $related->id, 'slug' => $related->slug]) }}"
                                class="block">
                                <div
                                    class="bg-gradient-to-r from-red-500 to-indigo-600 p-4 rounded-lg shadow-md hover:shadow-lg transform transition duration-300 hover:scale-105">
                                    <h3 class="text-white text-sm font-semibold truncate">{{ $related->title }}</h3>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="mt-4 flex justify-center">
                        <a href="{{ route('web.videos') }}"
                            class="inline-flex items-center bg-orange-500 p-2 rounded-lg shadow-md hover:shadow-lg transform transition duration-300 hover:scale-105 text-white focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>


            </div>

        </div>
    </div>
@endsection
