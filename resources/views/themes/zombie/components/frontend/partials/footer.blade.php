<footer class="footer-gradient-purple text-white pt-16 pb-8 px-4 sm:px-6 lg:px-8">
    <!-- Main Footer Content -->
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
        <!-- Logo and Description -->
        <div class="space-y-6" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-center space-x-2">
                <img src="{{ Storage::url('images/settings/' . get_setting('logo')) }}"
                    alt="{{ get_setting('school_name') }}" class="h-12">
                <span
                    class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-teal-400">
                    {{ get_setting('school_name') }}
                </span>
            </div>
            <p class="text-gray-400 leading-relaxed">
                {{ get_setting('tagline') }}
            </p>
            <div class="flex space-x-4">
                <a href="{{ get_setting('facebook') }}"
                    class="text-gray-400 hover:text-blue-500 transition-colors duration-300" aria-label="Facebook">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" />
                    </svg>
                </a>
                <a href="{{ get_setting('instagram') }}"
                    class="text-gray-400 hover:text-pink-500 transition-colors duration-300" aria-label="Instagram">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                    </svg>
                </a>
                <a href="{{ get_setting('youtube') }}"
                    class="text-gray-400 hover:text-red-500 transition-colors duration-300" aria-label="YouTube">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Quick Links -->
        <div data-aos="fade-up" data-aos-delay="200">
            <h3
                class="text-lg font-bold text-white mb-6 relative pb-2 after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-12 after:bg-gradient-to-r after:from-blue-400 after:to-teal-400">
                Menu Cepat
            </h3>
            <ul class="space-y-3">
                <li><a href="/"
                        class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Beranda</a></li>
                <li><a href="/pages/tentang-kami"
                        class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Profil Sekolah</a></li>
                <li><a href="/berita"
                        class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        Berita & Artikel</a></li>
                <li><a href="/unduhan"
                        class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Dokumen & Unduhan</a></li>
            </ul>
        </div>

        <!-- Contact Info -->
        <div data-aos="fade-up" data-aos-delay="300">
            <h3
                class="text-lg font-bold text-white mb-6 relative pb-2 after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-12 after:bg-gradient-to-r after:from-blue-400 after:to-teal-400">
                Kontak Kami
            </h3>
            <ul class="space-y-4">
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-blue-400 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <div>
                        <span class="block text-gray-400 text-sm">Alamat</span>
                        <span class="text-white">{{ get_setting('sub_village') }}, {{ get_setting('village') }},
                            {{ get_setting('district') }}</span>
                    </div>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-blue-400 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <div>
                        <span class="block text-gray-400 text-sm">Email</span>
                        <a href="mailto:{{ get_setting('email') }}"
                            class="text-white hover:text-blue-400 transition-colors duration-300">{{ get_setting('email') }}</a>
                    </div>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-blue-400 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <div>
                        <span class="block text-gray-400 text-sm">Telepon</span>
                        <a href="tel:{{ get_setting('phone') }}"
                            class="text-white hover:text-blue-400 transition-colors duration-300">{{ get_setting('phone') }}</a>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Newsletter -->
        <div data-aos="fade-up" data-aos-delay="400">
            <h3
                class="text-lg font-bold text-white mb-6 relative pb-2 after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-12 after:bg-gradient-to-r after:from-blue-400 after:to-teal-400">
                Newsletter
            </h3>
            <p class="text-gray-400 mb-4">Dapatkan update terbaru langsung ke email Anda</p>
            <form action="{{ route('subscribe') }}" method="POST" class="space-y-3">
                @csrf
                <div class="relative">
                    <input type="email" name="email" placeholder="Alamat email Anda" required
                        class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-white placeholder-gray-500">
                    <button type="submit"
                        class="absolute right-2 top-2 bg-gradient-to-r from-blue-500 to-teal-500 text-white px-4 py-1 rounded-md hover:opacity-90 transition-opacity duration-300">
                        Subscribe
                    </button>
                </div>
                <p class="text-xs text-gray-500">Kami tidak akan membagikan email Anda ke pihak lain</p>
            </form>
        </div>
    </div>

    <!-- Copyright Section -->
    <div
        class="max-w-7xl mx-auto mt-16 pt-8 border-t border-gray-800 flex flex-col md:flex-row justify-between items-center">
        <div class="text-gray-500 text-sm mb-4 md:mb-0">
            &copy;Sinau</a></span>
        </div> {{ date('Y') }} {{ get_setting('school_name') }}. Tema {{ getActiveThemeName() }} by <a
            href="https://sinaucms.web.id/" class="text-blue-400 hover:underline">CMS Sinau</a>
    </div>
    <div class="flex items-center space-x-4">

        <div class="flex items-center text-sm text-gray-500">
            <span>dibuat dengan sepenuh</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                class="w-4 h-4 mx-1 text-pink-500">
                <path
                    d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 0 0 1-.704 0l-.003-.001Z" />
            </svg>
            <span>by <a href="https://sinaucms.web.id/" class="text-blue-400 hover:underline">CMS

        </div>
    </div>
</footer>









<script>
    document.addEventListener('DOMContentLoaded', function() {
        try {
            var disqus_config = function() {
                this.page.url = "{{ url()->current() }}"; // PAGE URL
                this.page.identifier = "{{ $post->id ?? 'generic_identifier' }}"; // PAGE IDENTIFIER
            };

            (function() {
                var d = document,
                    s = d.createElement('script');
                var shortname_disqus = "{{ get_setting('shortname_disqus') }}";
                s.src =
                    `https://${shortname_disqus}.disqus.com/embed.js`; // GET SHORTNAME_DISQUS FROM DATABASE
                s.setAttribute('data-timestamp', +new Date());
                s.onload = function() {
                    // Hide the error message if Disqus loaded successfully
                    document.getElementById('disqus_error').classList.add('hidden');
                };
                s.onerror = function() {
                    // Show error message if Disqus failed to load
                    document.getElementById('disqus_error').classList.remove('hidden');
                };
                (d.head || d.body).appendChild(s);
            })();
        } catch (e) {
            console.log('Disqus loading error:', e);
        }
    });
</script>

<script>
    function showToast(message) {
        const toast = document.getElementById('toast');
        const toastMessage = document.getElementById('toast-message');

        toastMessage.textContent = message;
        toast.classList.remove('hidden');
        toast.classList.add('show');

        // Automatically hide toast after 5 seconds
        setTimeout(() => {
            toast.classList.remove('show');
            toast.classList.add('hide');
            setTimeout(() => toast.classList.add('hidden'), 500);
        }, 5000); // Toast will be shown for 5 seconds
    }

    // Show toast if session 'success' message is present
    @if (session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            showToast('{{ session('success') }}');
        });
    @endif
</script>
