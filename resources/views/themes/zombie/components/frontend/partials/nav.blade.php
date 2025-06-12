 <nav class="sticky-nav bg-blue-900 shadow-sm z-50 custom-nav-border">
     <div class="container mx-auto px-4 py-3">
         <div class="flex justify-between items-center">
             <!-- Logo -->
             <a href="/" class="flex items-center space-x-4 group">
                 <!-- Logo -->
                 <img src="{{ asset('storage/images/settings/' . get_setting('logo')) }}" alt="Logo Sekolah"
                     class="h-10 w-auto transition-all duration-300 group-hover:scale-105" />

                 <!-- Teks: Nama Sekolah & Slogan -->
                 <div class="flex flex-col leading-tight">
                     <span class="text-sm md:text-md font-bold text-blue-200">{{ get_setting('school_name') }}</span>

                 </div>
             </a>


             <!-- Main Menu -->
             <div class="hidden lg:flex items-center space-x-1">
                 @foreach ($parentMenus as $menu)
                     @if (isset($allMenus[$menu->id]) && $allMenus[$menu->id]->isNotEmpty())
                         <!-- Dropdown Menu -->
                         <div class="relative group" x-data="{ open: false }" @mouseenter="open = true"
                             @mouseleave="open = false">
                             <button
                                 class="flex items-center text-sm font-medium text-white hover:text-blue-200 px-4 py-2 rounded-md transition-all duration-200">
                                 {{ $menu->title }}
                                 <svg class="ml-2 w-4 h-4 transition-transform duration-200"
                                     :class="{ 'rotate-180': open }" fill="none" stroke="currentColor"
                                     stroke-width="2" viewBox="0 0 24 24">
                                     <path d="M19 9l-7 7-7-7" />
                                 </svg>
                             </button>

                             <div x-cloak x-show="open" x-transition
                                 class="absolute left-0 mt-2 w-56 max-h-96 overflow-y-auto bg-white rounded-md shadow-xl z-50 py-1 border border-blue-100">
                                 @foreach ($allMenus[$menu->id] as $child)
                                     <a href="{{ $child->url }}" target="{{ $child->menu_target }}"
                                         class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                                         {{ $child->title }}
                                     </a>
                                 @endforeach
                             </div>


                         </div>
                     @else
                         <!-- Single Menu Item -->
                         <a href="{{ $menu->url }}" target="{{ $menu->menu_target }}"
                             class="text-sm font-medium text-white hover:text-blue-200 px-4 py-2 rounded-md transition-all duration-200 relative">
                             {{ $menu->title }}
                             <span
                                 class="absolute bottom-1 left-1/2 transform -translate-x-1/2 w-5 h-0.5 bg-blue-200 rounded-full transition-all duration-300 opacity-0 group-hover:opacity-100"></span>
                         </a>
                     @endif
                 @endforeach
             </div>

             <!-- Right Side: Mobile toggle + Search -->
             <div class="flex items-center space-x-4">
                 <!-- Search Form -->
                 <form action="{{ route('search.results') }}" method="GET" class="hidden md:block">
                     <div class="relative">
                         <input type="text" name="keywords" value="{{ request()->input('search') }}"
                             placeholder="Cari..."
                             class="pl-4 pr-10 py-2 rounded-lg border-0 bg-blue-800 text-white placeholder-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm w-52 transition-all duration-200" />

                     </div>
                 </form>

                 <!-- Mobile Menu Button -->
                 <div class="lg:hidden flex items-center">
                     <button id="hamburger-menu" type="button"
                         class="text-gray-700 hover:text-blue-600 focus:outline-none"
                         aria-label="Toggle navigation menu">
                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                 d="M4 6h16M4 12h16M4 18h16"></path>
                         </svg>
                     </button>
                 </div>
             </div>
         </div>
     </div>
 </nav>



 <!-- Mobile Menu -->
 <div id="mobile-menu"
     class="lg:hidden fixed inset-0 bg-white/95 backdrop-blur-sm z-40 transform -translate-x-full transition-all duration-300 ease-in-out">
     <div class="container mx-auto px-4 py-6">
         <div class="flex justify-between items-center mb-6">
             <a href="/" class="flex items-center">
                 <img src="{{ asset('storage/images/settings/' . get_setting('nav_image')) }}" alt="Website Sekolah"
                     class="h-10" />
             </a>
             <button id="close-mobile-menu" type="button" class="text-gray-700 hover:text-blue-600"
                 aria-label="Tutup menu navigasi">
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
