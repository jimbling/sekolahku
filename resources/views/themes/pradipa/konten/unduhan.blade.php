@extends('themes.' . getActiveTheme() . '.app')

@section('title', 'Unduhan')

@section('content')
    <div class="container mx-auto max-w-4xl px-4">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden p-4 md:p-6">
            <!-- Modern Search Form -->
            <form id="form-search" action="{{ route('web.cari.unduhan') }}" method="GET" class="mb-6 md:mb-8">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 md:pl-4 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="keywords" value="{{ request()->input('keywords') }}"
                        placeholder="Cari dokumen, file, atau unduhan..."
                        class="w-full h-12 md:h-14 pl-10 md:pl-12 pr-28 md:pr-32 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-gray-900 placeholder-gray-400 transition-all duration-300 shadow-sm hover:shadow-md focus:shadow-lg focus:shadow-blue-200/50">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-1 md:pr-2 gap-1">
                        @if (Route::currentRouteName() == 'web.cari.unduhan')
                            <a href="{{ route('web.unduhan') }}"
                                class="flex items-center justify-center h-8 md:h-10 w-8 md:w-10 text-gray-600 hover:text-white hover:bg-gray-400 rounded-lg transition-colors duration-200"
                                title="Reset pencarian">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-4 md:w-5 h-4 md:h-5">
                                    <path fill-rule="evenodd"
                                        d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        @endif
                        <button type="submit"
                            class="h-8 md:h-10 px-4 md:px-6 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-all duration-300 shadow hover:shadow-lg hover:shadow-blue-400/30 focus:ring-2 focus:ring-blue-300 text-sm md:text-base">
                            Cari
                        </button>
                    </div>
                </div>
            </form>

            <!-- Search Results -->
            <div id="search-results">
                @if ($files->isEmpty())
                    <div class="text-center py-8 md:py-12" data-aos="fade-up">
                        <div class="max-w-md mx-auto">
                            <img src="{{ asset('storage/images/illustrasi/not-found.png') }}" alt="Not Found Illustration"
                                loading="lazy" class="mx-auto w-48 md:w-64 h-48 md:h-64 object-contain">
                            <h3 class="mt-4 md:mt-6 text-lg md:text-xl font-semibold text-gray-700">Hasil tidak ditemukan
                            </h3>
                            <p class="mt-2 text-sm md:text-base text-gray-500">Pencarian "<span
                                    class="text-blue-600 font-medium">{{ request()->input('keywords') }}</span>" tidak
                                memberikan hasil.</p>
                            <a href="{{ route('web.unduhan') }}"
                                class="mt-3 md:mt-4 inline-flex items-center text-blue-600 hover:text-blue-800 text-sm md:text-base">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5 mr-1"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                                Kembali ke semua unduhan
                            </a>
                        </div>
                    </div>
                @else
                    <div class="grid gap-3 md:gap-4">
                        @foreach ($files as $file)
                            <div class="group flex flex-col md:flex-row bg-white p-4 md:p-5 rounded-xl border border-gray-100 hover:border-blue-100 shadow-sm hover:shadow-md transition-all duration-300"
                                data-aos="fade-up">
                                <!-- Mobile Download Button (visible only on mobile) -->
                                <div class="md:hidden flex justify-between items-start mb-3">
                                    <a href="{{ route('unduh.file', $file->id) }}"
                                        class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors duration-200 tooltip"
                                        data-tip="Unduh file ini">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="w-5 h-5">
                                            <path fill-rule="evenodd"
                                                d="M10.5 3.75a6 6 0 00-5.98 6.496A5.25 5.25 0 006.75 20.25H18a4.5 4.5 0 002.206-8.423 3.75 3.75 0 00-4.133-4.303A6.001 6.001 0 0010.5 3.75zm2.25 6a.75.75 0 00-1.5 0v4.94l-1.72-1.72a.75.75 0 00-1.06 1.06l3 3a.75.75 0 001.06 0l3-3a.75.75 0 10-1.06-1.06l-1.72 1.72V9.75z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                    <!-- File size (mobile only) -->
                                    <span class="text-xs text-gray-500">
                                        {{ $file->formatted_size }}
                                    </span>
                                </div>

                                <!-- File Icon (hidden on mobile) -->
                                <div
                                    class="hidden md:flex flex-shrink-0 mb-4 md:mb-0 md:mr-6 items-center justify-center w-16 h-16 bg-blue-50 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-8 h-8 text-blue-500">
                                        <path fill-rule="evenodd"
                                            d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625zM7.5 15a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 017.5 15zm.75 2.25a.75.75 0 000 1.5H12a.75.75 0 000-1.5H8.25z"
                                            clip-rule="evenodd" />
                                        <path
                                            d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z" />
                                    </svg>
                                </div>

                                <!-- File Content -->
                                <div class="flex-1 min-w-0">
                                    <h3
                                        class="text-base md:text-lg font-semibold text-gray-800 group-hover:text-blue-600 transition-colors mb-1">
                                        {{ $file->file_title }}
                                    </h3>
                                    <p class="text-sm md:text-base text-gray-600 mb-2 md:mb-3">{{ $file->file_description }}
                                    </p>

                                    <!-- File Meta -->
                                    <div class="flex flex-wrap gap-2 text-xs md:text-sm">
                                        <span
                                            class="hidden md:inline-flex items-center px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $file->formatted_size }}
                                        </span>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-green-100 text-green-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path
                                                    d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                            </svg>
                                            {{ $file->file_counter }} unduhan
                                        </span>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-purple-100 text-purple-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ \Carbon\Carbon::parse($file->created_at)->locale('id')->translatedFormat('j F Y') }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Download Button (hidden on mobile) -->
                                <div class="hidden md:flex flex-shrink-0 mt-4 md:mt-0 md:ml-4 items-center">
                                    <a href="{{ route('unduh.file', $file->id) }}"
                                        class="flex items-center justify-center w-12 h-12 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors duration-200 tooltip"
                                        data-tip="Unduh file ini">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="w-6 h-6">
                                            <path fill-rule="evenodd"
                                                d="M10.5 3.75a6 6 0 00-5.98 6.496A5.25 5.25 0 006.75 20.25H18a4.5 4.5 0 002.206-8.423 3.75 3.75 0 00-4.133-4.303A6.001 6.001 0 0010.5 3.75zm2.25 6a.75.75 0 00-1.5 0v4.94l-1.72-1.72a.75.75 0 00-1.06 1.06l3 3a.75.75 0 001.06 0l3-3a.75.75 0 10-1.06-1.06l-1.72 1.72V9.75z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </div>

                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6 md:mt-8">
                        {{ $files->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
