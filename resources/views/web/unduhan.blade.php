@extends('components.frontend.app_statis')

@section('title', 'Unduhan')

@section('content')

    <div class="container mx-auto">
        <div class="bg-white shadow-xl rounded-lg overflow-hidden p-5 mx-4 sm:mx-6 md:mx-8 lg:mx-10">
            <!-- Form Pencarian -->
            <div class="w-full max-w-6xl mx-auto mt-6">
                <form id="form-search" action="{{ route('web.cari.unduhan') }}" method="GET" class="flex items-center">
                    <div class="relative w-full">
                        <input type="text" name="keywords" value="{{ request()->input('keywords') }}"
                            placeholder="Cari di sini..."
                            class="w-full h-14 px-4 py-2 pr-28 rounded-lg border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 text-gray-900 placeholder-gray-500">
                        <button type="submit"
                            class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-blue-500 hover:bg-blue-900 text-white font-semibold py-2 px-4 rounded-lg shadow-lg transition duration-300 hover:shadow-xl active:bg-blue-800 active:scale-95 border-2 border-gray-300">
                            Cari
                        </button>
                        @if (Route::currentRouteName() == 'web.cari.unduhan')
                            <a href="{{ route('web.unduhan') }}"
                                class="absolute top-1/2 right-20 transform -translate-y-1/2 bg-orange-500 hover:bg-orange-700 text-white font-semibold py-2 px-4 rounded-lg shadow-lg transition duration-300 hover:shadow-xl active:bg-gray-600 active:scale-95 border-2 border-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-6">
                                    <path fill-rule="evenodd"
                                        d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z"
                                        clip-rule="evenodd" />
                                </svg>

                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Hasil Pencarian -->
            <div id="search-results" class="mt-8">
                @if ($files->isEmpty())
                    <div class="text-center text-3xl font-semibold text-gray-500">
                        <p>Pencarian <span class="text-red-500">{{ request()->input('keywords') }}</span> tidak ditemukan!
                        </p>
                        <img src="{{ asset('storage/images/illustrasi/not-found.png') }}" alt="Not Found Illustration"
                            class="mx-auto my-4 w-80 h-80 object-contain">
                    </div>
                @else
                    @foreach ($files as $file)
                        <div class="flex bg-base p-1 rounded-lg border border-gray-300 mb-4 items-center"
                            data-aos="fade-up">
                            <!-- Gambar Illustrasi -->
                            <div class="flex-shrink-0 mr-4 ml-4 hidden md:block">
                                <img src="{{ asset('storage/images/illustrasi/file-storage.png') }}" alt="Illustration"
                                    class="w-14 h-14 object-cover rounded-lg">
                            </div>
                            <!-- Konten hasil pencarian -->
                            <div class="flex-1">
                                <h3 class="text-md font-semibold text-gray-900">{{ $file->file_title }}</h3>
                                <p class="text-gray-700 mt-2">{{ $file->file_description }}</p>
                            </div>
                            <!-- Icon download dan badge -->
                            <div class="flex-shrink-0 flex flex-col items-center ml-4 mr-8">
                                <a href="{{ route('unduh.file', $file->id) }}" class="hover:text-blue-700 mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-10 h-10 text-gray-500 hover:text-blue-700">
                                        <path fill-rule="evenodd"
                                            d="M10.5 3.75a6 6 0 0 0-5.98 6.496A5.25 5.25 0 0 0 6.75 20.25H18a4.5 4.5 0 0 0 2.206-8.423 3.75 3.75 0 0 0-4.133-4.303A6.001 6.001 0 0 0 10.5 3.75Zm2.25 6a.75.75 0 0 0-1.5 0v4.94l-1.72-1.72a.75.75 0 0 0-1.06 1.06l3 3a.75.75 0 0 0 1.06 0l3-3a.75.75 0 1 0-1.06-1.06l-1.72 1.72V9.75Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <div class="flex space-x-2">
                                    <span
                                        class="text-xs bg-blue-100 text-blue-800 rounded-full px-2 py-1">{{ $file->formatted_size }}</span>
                                    <span
                                        class="text-xs bg-green-100 text-green-800 rounded-full px-2 py-1">{{ $file->file_counter }}
                                        unduhan</span>
                                    <span class="text-xs bg-purple-100 text-purple-800 rounded-full px-2 py-1">
                                        {{ \Carbon\Carbon::parse($file->created_at)->locale('id')->translatedFormat('j F Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{ $files->links() }}
                @endif
            </div>

        </div>
    </div>
@endsection
