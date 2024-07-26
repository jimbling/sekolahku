  <!-- Bagian Header -->
  @include('components.frontend.partials.header')

  <body class="bg-gray-100">
      @php
          $showPreloader = get_setting('preloader') === 'true'; // Mengambil nilai preloader dari database
      @endphp

      @if ($showPreloader)
          @include('components.frontend.partials.preloader')
      @endif
      @include('components.frontend.partials.top-nav')
      @include('components.frontend.partials.nav')

      <!-- Hero Section (Carousel) -->
      @stack('hero')

      <h2 class="text-lg font-bold text-gray-500 text-center py-6 px-6">
          <span class="relative">
              @if (Route::currentRouteName() == 'posts.show')
                  <nav aria-label="Breadcrumb" class="inline-block">
                      <div class="bg-white shadow-lg rounded-2xl p-4">
                          <ol class="list-none p-0 inline-flex items-center space-x-2 text-sm">
                              <li class="flex items-center">
                                  <a href="{{ route('web.home') }}" class="text-blue-600 hover:underline">Home</a>
                                  <svg class="fill-current w-3 h-3 mx-2 text-gray-400" viewBox="0 0 24 24">
                                      <path d="M9 18l6-6-6-6"></path>
                                  </svg>
                              </li>
                              <li class="flex items-center">
                                  <a href="{{ route('category.posts', ['slug' => $category->slug]) }}"
                                      class="text-blue-600 hover:underline">{{ $category->name }}</a>
                                  <svg class="fill-current w-3 h-3 mx-2 text-gray-400" viewBox="0 0 24 24">
                                      <path d="M9 18l6-6-6-6"></path>
                                  </svg>
                              </li>
                              <li>
                                  <span class="text-gray-500">{{ $post->title }}</span>
                              </li>
                          </ol>
                      </div>
                  @else
                      <h2 class="text-3xl font-bold text-gray-500 text-center">
                          <span class="relative">
                              @yield('title')
                              <span
                                  class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-3 h-1 w-16 bg-blue-800"></span>
                          </span>
                      </h2>
              @endif
              @if (Route::currentRouteName() == 'posts.show')
              @endif
          </span>
      </h2>



      <!-- Another Features Section -->
      <div class="container mx-auto">
          <section id="main" class="min-h-screen flex flex-col md:flex-row mx-4">

              <!-- Left Section -->
              <div class="w-full md:w-3/4 p-4">
                  @yield('content')
                  <!-- Left side content here -->
              </div>

              <!-- Right Section -->
              <div class="w-full md:w-1/3 p-4">
                  @yield('sidebar')

              </div>

          </section>
      </div>
      <!-- Footer -->
      @include('components.frontend.partials.footer')
  </body>

  </html>
