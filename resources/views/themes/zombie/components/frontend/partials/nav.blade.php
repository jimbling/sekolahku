<div id="header"
    class="sticky-header sticky top-0 bg-white/80 backdrop-blur-sm border-b border-gray-100 py-2 z-50 h-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-full">
            <!-- Logo -->
            <a href="/" class="flex items-center group">
                <img src="{{ asset('storage/images/settings/' . get_setting('nav_image')) }}" alt="Website Sekolah"
                    class="h-10 transition-all duration-300 group-hover:scale-105" />
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-1">
                @foreach ($parentMenus as $menu)
                    @if (isset($allMenus[$menu->id]) && $allMenus[$menu->id]->isNotEmpty())
                        <div class="relative group" x-data="{ open: false }" @mouseenter="open = true"
                            @mouseleave="open = false">
                            <button type="button"
                                class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200
                                {{ request()->url() === $menu->url ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:text-blue-600 hover:bg-blue-50' }}">
                                {{ $menu->title }}
                                <svg class="w-4 h-4 ml-1 transition-transform duration-200"
                                    :class="{ 'rotate-180': open }" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 translate-y-1"
                                class="absolute left-0 z-10 mt-2 w-56 origin-top-left rounded-xl bg-white shadow-lg ring-1 ring-gray-900/5 focus:outline-none">
                                @foreach ($allMenus[$menu->id] as $child)
                                    <a href="{{ $child->url }}" target="{{ $child->menu_target }}"
                                        class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg mx-1 my-0.5
                                        {{ request()->url() === $child->url ? 'bg-blue-50 text-blue-600' : '' }}">
                                        {{ $child->title }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ $menu->url }}" target="{{ $menu->menu_target }}"
                            class="px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 relative
                            {{ request()->url() === $menu->url ? 'text-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                            {{ $menu->title }}
                            <span
                                class="absolute bottom-1 left-1/2 transform -translate-x-1/2 w-5 h-0.5 bg-blue-600 rounded-full transition-all duration-300
                                {{ request()->url() === $menu->url ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }}"></span>
                        </a>
                    @endif
                @endforeach
            </div>

            <!-- Mobile Menu Button -->
            <div class="lg:hidden flex items-center">
                <button id="hamburger-menu" type="button" class="text-gray-700 hover:text-blue-600 focus:outline-none"
                    aria-label="Toggle navigation menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu"
        class="lg:hidden fixed inset-0 bg-white/95 backdrop-blur-sm z-40 transform -translate-x-full transition-all duration-300 ease-in-out">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center mb-6">
                <a href="/" class="flex items-center">
                    <img src="{{ asset('storage/images/settings/' . get_setting('nav_image')) }}" alt="Website Sekolah"
                        class="h-10" />
                </a>
                <button id="close-mobile-menu" type="button" class="text-gray-700 hover:text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <nav class="flex flex-col space-y-2">
                @foreach ($parentMenus as $menu)
                    @if (isset($allMenus[$menu->id]) && $allMenus[$menu->id]->isNotEmpty())
                        <div class="accordion-group">
                            <button type="button"
                                class="flex items-center justify-between w-full px-4 py-3 text-base font-medium text-gray-900 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                                {{ $menu->title }}
                                <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div class="hidden pl-4 mt-1 space-y-1">
                                @foreach ($allMenus[$menu->id] as $child)
                                    <a href="{{ $child->url }}" target="{{ $child->menu_target }}"
                                        class="block px-4 py-2.5 text-sm text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200
                                        {{ request()->url() === $child->url ? 'bg-blue-50 text-blue-600' : '' }}">
                                        {{ $child->title }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ $menu->url }}" target="{{ $menu->menu_target }}"
                            class="block px-4 py-3 text-base font-medium rounded-lg transition-colors duration-200
                            {{ request()->url() === $menu->url ? 'bg-blue-50 text-blue-600' : 'text-gray-900 hover:bg-blue-50 hover:text-blue-600' }}">
                            {{ $menu->title }}
                        </a>
                    @endif
                @endforeach
            </nav>
        </div>
    </div>
</div>

<script>
    // Mobile menu toggle functionality
    document.getElementById('hamburger-menu').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.remove('-translate-x-full');
        document.body.classList.add('overflow-hidden');
    });

    document.getElementById('close-mobile-menu').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.add('-translate-x-full');
        document.body.classList.remove('overflow-hidden');
    });

    // Accordion functionality for mobile menu
    document.querySelectorAll('.accordion-group button').forEach(button => {
        button.addEventListener('click', () => {
            const content = button.nextElementSibling;
            const isExpanded = content.classList.contains('hidden');

            // Close all other accordions
            document.querySelectorAll('.accordion-group div').forEach(item => {
                if (item !== content) {
                    item.classList.add('hidden');
                    item.previousElementSibling.querySelector('svg').classList.remove(
                        'rotate-180');
                }
            });

            // Toggle current accordion
            if (isExpanded) {
                content.classList.remove('hidden');
                button.querySelector('svg').classList.add('rotate-180');
            } else {
                content.classList.add('hidden');
                button.querySelector('svg').classList.remove('rotate-180');
            }
        });
    });
</script>
