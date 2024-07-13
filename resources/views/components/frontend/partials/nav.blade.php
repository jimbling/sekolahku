<div class="sticky top-0 bg-white py-2 shadow-md z-50 h-16">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-full"> <!-- Ubah h-16 ke h-full -->
            <h1 class="text-xl font-bold text-gray-800">Website Sekolah</h1>
            <div class="hidden lg:flex lg:gap-x-12">
                <a href="{{ route('web.home') }}"
                    class="text-gray-900 hover:bg-gray-200 px-3 py-2 rounded-md text-xl font-medium">Home</a>
                <a href="{{ route('web.hubungi_kami') }}"
                    class="text-gray-900 hover:bg-gray-200 px-3 py-2 rounded-md text-xl font-medium">Hubungi
                    Kami</a>
                <div class="relative">
                    <button type="button"
                        class="flex items-center gap-x-1 text-gray-900 hover:bg-gray-200 px-3 py-2 rounded-md text-xl font-medium"
                        aria-expanded="false">
                        Profile
                        <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div
                        class="absolute -left-8 top-full z-10 hidden mt-3 w-screen max-w-md overflow-hidden rounded-3xl bg-white shadow-lg ring-1 ring-gray-900/5">
                        <div class="p-4">
                            <div
                                class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm leading-6 hover:bg-gray-50">
                                <div
                                    class="flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                    <svg class="h-6 w-6 text-gray-600 group-hover:text-indigo-600" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                                    </svg>
                                </div>
                                <div class="flex-auto">
                                    <a href="#" class="block font-semibold text-gray-900">Analytics</a>
                                    <p class="mt-1 text-gray-600">Get a better understanding of your traffic</p>
                                </div>
                            </div>
                            <!-- Item tambahan di sini -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                <a href="{{ route('login') }}"
                    class="border border-transparent text-blue-500 px-4 py-2 rounded-md text-sm font-medium transition-colors duration-300 hover:bg-blue-500 hover:text-white hover:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-6 h-6 inline-block mr-2">
                        <path fill-rule="evenodd"
                            d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>Login</span>
                </a>
            </div>

        </div>
    </div>
</div>
