<div class="sticky top-0 bg-white py-2 shadow-xl z-40 h-16 ">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 ">
        <div class="flex items-center justify-between h-full">
            <!-- Logo atau gambar header -->
            <a href="/" class="flex items-center">
                <img src="{{ asset('storage/images/settings/' . get_setting('nav_image')) }}" alt="Website Sekolah"
                    class="h-12 object-contain" />
            </a>

            <!-- Wrapper for centered menu -->
            <div class="flex-1 flex justify-center items-center">
                <!-- Desktop Menu -->
                <div class="hidden lg:flex lg:gap-x-4 items-center">
                    @foreach ($parentMenus as $menu)
                        @if (isset($allMenus[$menu->id]) && $allMenus[$menu->id]->isNotEmpty())
                            <div class="relative group">
                                <button type="button"
                                    class="relative flex items-center gap-x-1 text-gray-900 hover:text-blue-800 px-2 py-2 rounded-md text-xl font-medium"
                                    aria-expanded="false">
                                    {{ $menu->title }}
                                    <svg class="h-5 w-5 flex-none text-gray-400 group-hover:text-gray-600"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span
                                        class="absolute bottom-0 left-0 right-0 h-0.5 bg-transparent transition-all duration-300 group-hover:bg-blue-900 group-hover:w-full group-hover:scale-x-100 transform origin-left scale-x-0"></span>
                                </button>
                                <div
                                    class="absolute left-0 mt-2 hidden w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 group-focus-within:block">
                                    <div class="py-1">
                                        @foreach ($allMenus[$menu->id] as $child)
                                            <a href="{{ $child->url }}" target="{{ $child->menu_target }}"
                                                class="block px-4 py-2 text-gray-700  hover:bg-gray-100 hover:text-blue-800">{{ $child->title }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="{{ $menu->url }}" target="{{ $menu->menu_target }}"
                                class="relative text-gray-900 hover:text-blue-800 px-2 py-2 rounded-md text-xl font-medium group">
                                {{ $menu->title }}
                                <span
                                    class="absolute bottom-0 left-0 right-0 h-0.5 bg-transparent transition-all duration-300 group-hover:bg-blue-900 group-hover:w-full group-hover:scale-x-100 transform origin-left scale-x-0"></span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>


            <!-- Hamburger Menu Button -->
            <div class="lg:hidden flex items-center relative z-50">
                <button id="hamburger-menu" type="button" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Login button for desktop -->
            <a href="{{ route('login') }}"
                class="hidden lg:inline border border-transparent text-blue-500 px-2 py-2 rounded-md text-sm font-medium transition-colors duration-300 hover:bg-blue-500 hover:text-white hover:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
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

    <!-- Mobile Menu -->
    <div id="mobile-menu"
        class="lg:hidden fixed inset-0 bg-white bg-opacity-80 backdrop-blur-sm z-40 transform -translate-x-full transition-transform">
        <div class="flex flex-col p-4">
            @foreach ($parentMenus as $menu)
                @if (isset($allMenus[$menu->id]) && $allMenus[$menu->id]->isNotEmpty())
                    <div class="relative mb-2">
                        <button type="button"
                            class="flex items-center gap-x-1 text-gray-900 hover:bg-blue-500 hover:text-white px-3 py-2 rounded-md text-xl font-medium"
                            aria-expanded="false">
                            {{ $menu->title }}
                            <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div
                            class="dropdown-menu absolute left-0 mt-2 hidden w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                            <div class="py-1">
                                @foreach ($allMenus[$menu->id] as $child)
                                    <a href="{{ $child->url }}" target="{{ $child->menu_target }}"
                                        class="block px-4 py-2 text-gray-700 hover:bg-blue-100 hover:text-gray-900">{{ $child->title }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ $menu->url }}" target="{{ $menu->menu_target }}"
                        class="text-gray-900 hover:bg-blue-500 hover:text-white px-3 py-2 rounded-md text-xl font-medium">{{ $menu->title }}</a>
                @endif
            @endforeach
            <!-- Login button for mobile -->
            <a href="{{ route('login') }}"
                class="mt-4 border border-transparent text-blue-500 px-4 py-2 rounded-md text-sm font-medium transition-colors duration-300 hover:bg-blue-500 hover:text-white hover:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
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
