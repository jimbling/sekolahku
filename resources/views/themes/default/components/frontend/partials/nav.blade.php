<div id="header" class="sticky-header sticky top-0 bg-white py-2 shadow-xl z-40 h-16">
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
                <div class="hidden lg:flex lg:gap-x-2 items-center">
                    @foreach ($parentMenus as $menu)
                        @php
                            // Penanganan khusus untuk URL home
                            $menuUrl = $menu->url === '/' ? '/' : trim($menu->url, '/');
                            $currentUrl = trim(request()->path(), '/');

                            $isActiveParent = $menuUrl === $currentUrl || (empty($currentUrl) && $menuUrl === '/');

                            $hasChildren = isset($allMenus[$menu->id]) && $allMenus[$menu->id]->isNotEmpty();
                            $isActiveChild = false;

                            if ($hasChildren) {
                                foreach ($allMenus[$menu->id] as $child) {
                                    $childUrl = trim($child->url, '/');
                                    if ($childUrl === $currentUrl) {
                                        $isActiveChild = true;
                                        break;
                                    }
                                }
                            }

                            $parentClass =
                                $isActiveParent || $isActiveChild
                                    ? 'text-white bg-gradient-to-r from-blue-600 to-blue-500 shadow-lg hover:shadow-blue-500/30'
                                    : 'text-gray-700 hover:text-blue-600 hover:bg-blue-50';
                        @endphp

                        @if ($hasChildren)
                            <div class="relative group">
                                <button type="button"
                                    class="flex items-center gap-x-1 px-4 py-3 rounded-lg text-lg font-medium transition-all duration-300 {{ $parentClass }}">
                                    {{ $menu->title }}
                                    <svg class="h-4 w-4 flex-none transition-transform duration-200 group-hover:rotate-180
                            {{ $isActiveParent || $isActiveChild ? 'text-blue-200' : 'text-gray-400' }}"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <div
                                    class="absolute left-0 mt-1 w-56 origin-top-right scale-0 opacity-0
                        transition-all duration-200 group-hover:scale-100 group-hover:opacity-100 z-50">
                                    <div class="rounded-xl bg-white p-2 shadow-xl ring-1 ring-black ring-opacity-5">
                                        @foreach ($allMenus[$menu->id] as $child)
                                            @php
                                                $childUrl = trim($child->url, '/');
                                                $isChildActive = $childUrl === $currentUrl;
                                            @endphp
                                            <a href="{{ $child->url }}" target="{{ $child->menu_target }}"
                                                class="block px-4 py-3 rounded-lg text-gray-700 transition-all duration-200
                                    {{ $isChildActive ? 'bg-blue-50 text-blue-600 font-medium' : 'hover:bg-gray-50 hover:text-blue-600' }}">
                                                <div class="flex items-center">
                                                    <span
                                                        class="mr-3 h-1.5 w-1.5 rounded-full bg-blue-600
                                            {{ $isChildActive ? 'opacity-100' : 'opacity-0' }}"></span>
                                                    {{ $child->title }}
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="{{ $menu->url }}" target="{{ $menu->menu_target }}"
                                class="relative px-4 py-3 rounded-lg text-lg font-medium transition-all duration-300 {{ $parentClass }}">
                                {{ $menu->title }}
                                @if (!$isActiveParent && !$isActiveChild)
                                    <span
                                        class="absolute bottom-1.5 left-1/2 h-0.5 w-0 bg-blue-600
                            transition-all duration-300 group-hover:left-4 group-hover:w-[calc(100%-2rem)]"></span>
                                @endif
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- <div class="flex-1 flex justify-center items-center">
                <!-- Desktop Menu -->
                <div class="hidden lg:flex lg:gap-x-4 items-center">
                    @foreach ($parentMenus as $menu)
                        @php
                            $isActiveParent = request()->url() == url($menu->url);
                            $hasChildren = isset($allMenus[$menu->id]) && $allMenus[$menu->id]->isNotEmpty();
                            $isActiveChild = false;

                            if ($hasChildren) {
                                foreach ($allMenus[$menu->id] as $child) {
                                    if (request()->url() == url($child->url)) {
                                        $isActiveChild = true;
                                        break;
                                    }
                                }
                            }
                        @endphp

                        @if ($hasChildren)
                            <div class="dropdown relative group">
                                <button tabindex="0" type="button"
                                    class="relative flex items-center gap-x-1 px-2 py-2 rounded-md text-xl font-medium
                            {{ $isActiveParent || $isActiveChild ? 'text-blue-800 font-semibold' : 'text-gray-900 hover:text-blue-800' }}">
                                    {{ $menu->title }}
                                    <svg class="h-5 w-5 flex-none text-gray-400 group-hover:text-gray-600"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <ul tabindex="0"
                                    class="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow absolute left-0 mt-2">
                                    @foreach ($allMenus[$menu->id] as $child)
                                        <li>
                                            <a href="{{ $child->url }}" target="{{ $child->menu_target }}"
                                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-blue-800
                                        {{ request()->url() == url($child->url) ? 'bg-gray-200 text-blue-800 font-semibold' : '' }}">
                                                {{ $child->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <a href="{{ $menu->url }}" target="{{ $menu->menu_target }}"
                                class="relative px-2 py-2 rounded-md text-xl font-medium group
                        {{ $isActiveParent ? 'text-blue-800 font-semibold' : 'text-gray-900 hover:text-blue-800' }}">
                                {{ $menu->title }}
                                <span
                                    class="absolute bottom-0 left-0 right-0 h-0.5 bg-transparent transition-all duration-300 group-hover:bg-blue-900 group-hover:w-full group-hover:scale-x-100 transform origin-left scale-x-0"></span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div> --}}



            <!-- Hamburger Menu Button -->
            <div class="lg:hidden flex items-center relative z-50">
                <button id="hamburger-menu" type="button" class="text-gray-500 hover:text-gray-700 focus:outline-none"
                    aria-label="Toggle navigation menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Login button for desktop -->
            {{-- <a href="{{ route('login') }}"
                class="hidden lg:inline border border-transparent text-blue-800 px-2 py-2 rounded-md text-sm font-medium transition-colors duration-300 hover:bg-blue-500 hover:text-white hover:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="w-6 h-6 inline-block mr-2">
                    <path fill-rule="evenodd"
                        d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                        clip-rule="evenodd" />
                </svg>
                <span>Login</span>
            </a> --}}
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu"
        class="lg:hidden fixed inset-0 bg-white bg-opacity-80 backdrop-blur-sm z-40 transform -translate-x-full transition-transform">
        <div class="flex flex-col p-4">
            @foreach ($parentMenus as $menu)
                @if (isset($allMenus[$menu->id]) && $allMenus[$menu->id]->isNotEmpty())
                    <details class="dropdown relative mb-2">
                        <summary tabindex="0"
                            class="flex items-center gap-x-1 text-gray-900 hover:bg-blue-500 hover:text-white px-3 py-2 rounded-md text-xl font-medium cursor-pointer">
                            {{ $menu->title }}
                            <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                    clip-rule="evenodd" />
                            </svg>
                        </summary>
                        <ul tabindex="0"
                            class="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow mt-1">
                            @foreach ($allMenus[$menu->id] as $child)
                                <li>
                                    <a href="{{ $child->url }}" target="{{ $child->menu_target }}"
                                        class="block px-4 py-2 text-gray-700 hover:bg-blue-100 hover:text-gray-900">{{ $child->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </details>
                @else
                    <a href="{{ $menu->url }}" target="{{ $menu->menu_target }}"
                        class="text-gray-900 hover:bg-blue-500 hover:text-white px-3 py-2 rounded-md text-xl font-medium">{{ $menu->title }}</a>
                @endif
            @endforeach
            <!-- Login button for mobile -->
            {{-- <a href="{{ route('login') }}"
                class="mt-4 border border-transparent text-blue-800 px-4 py-2 rounded-md text-sm font-medium transition-colors duration-300 hover:bg-blue-500 hover:text-white hover:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="w-6 h-6 inline-block mr-2">
                    <path fill-rule="evenodd"
                        d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                        clip-rule="evenodd" />
                </svg>
                <span>Login</span>
            </a> --}}
        </div>
    </div>


</div>
