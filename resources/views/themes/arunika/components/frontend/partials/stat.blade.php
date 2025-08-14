<!-- Stats Cards for Desktop (sudah kamu punya, tidak diubah) -->
<div class="container mx-auto px-2 -mt-42 relative z-20 hidden md:block" data-aos="fade-down">
    <div class="flex bg- justify-center -mt-32 relative z-20 max-w-5xl mx-auto">
        <div
            class="bg-purple-glossy text-white p-8 flex flex-col sm:flex-row items-center justify-between gap-6 w-full max-w-5xl transition-all duration-300">

            <!-- Left Content -->
            <div class="text-left max-w-sm">
                <h2 class="text-2xl sm:text-3xl font-bold mb-2">{{ get_setting('school_name') }}</h2>
                <p class="text-sm sm:text-base">{{ get_setting('tagline') }}</p>
            </div>

            <!-- Right Content (3 items) -->
            <div class="flex flex-wrap justify-center sm:justify-end gap-4">
                <!-- Facebook Card -->
                <a href="{{ get_setting('facebook') }}" target="_blank"
                    class="bg-transparent rounded-xl px-6 py-4 text-center cursor-pointer w-40 hover:bg-white/5 transition duration-300"
                    data-aos="zoom-in" data-aos-delay="100">
                    <div class="flex justify-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 36" fill="url(#a)" height="40"
                            width="40">
                            <defs>
                                <linearGradient x1="50%" x2="50%" y1="97.078%" y2="0%"
                                    id="a">
                                    <stop offset="0%" stop-color="#0062E0" />
                                    <stop offset="100%" stop-color="#19AFFF" />
                                </linearGradient>
                            </defs>
                            <path
                                d="M15 35.8C6.5 34.3 0 26.9 0 18 0 8.1 8.1 0 18 0s18 8.1 18 18c0 8.9-6.5 16.3-15 17.8l-1-.8h-4l-1 .8z" />
                            <path fill="#FFF"
                                d="m25 23 .8-5H21v-3.5c0-1.4.5-2.5 2.7-2.5H26V7.4c-1.3-.2-2.7-.4-4-.4-4.1 0-7 2.5-7 7v4h-4.5v5H15v12.7c1 .2 2 .3 3 .3s2-.1 3-.3V23h4z" />
                        </svg>
                    </div>
                    <span class="block font-semibold text-white text-sm mb-1">Facebook</span>
                    <span class="text-xs text-white/80">Kunjungi →</span>
                </a>


                <!-- YouTube Card -->
                <a href="{{ get_setting('youtube') }}" target="_blank"
                    class="bg-grad-career rounded-2xl px-6 py-5 text-center cursor-pointer w-40 shadow-xl hover:shadow-2xl transition-all duration-300 scale-105"
                    data-aos="zoom-in" data-aos-delay="200">
                    <div class="flex justify-center mb-2">
                        <svg viewBox="0 0 256 180" width="40" height="28" xmlns="http://www.w3.org/2000/svg"
                            preserveAspectRatio="xMidYMid">
                            <path
                                d="M250.346 28.075A32.18 32.18 0 0 0 227.69 5.418C207.824 0 127.87 0 127.87 0S47.912.164 28.046 5.582A32.18 32.18 0 0 0 5.39 28.24c-6.009 35.298-8.34 89.084.165 122.97a32.18 32.18 0 0 0 22.656 22.657c19.866 5.418 99.822 5.418 99.822 5.418s79.955 0 99.82-5.418a32.18 32.18 0 0 0 22.657-22.657c6.338-35.348 8.291-89.1-.164-123.134Z"
                                fill="red" />
                            <path fill="#FFF" d="m102.421 128.06 66.328-38.418-66.328-38.418z" />
                        </svg>
                    </div>
                    <h4 class="font-semibold text-white text-sm mb-1">YouTube</h4>
                    <span class="text-xs text-white/80">Kunjungi →</span>
                </a>

                <!-- Instagram Card -->
                <a href="{{ get_setting('instagram') }}" target="_blank"
                    class="bg-transparent rounded-xl px-6 py-4 text-center cursor-pointer w-40 hover:bg-white/5 transition duration-300"
                    data-aos="zoom-in" data-aos-delay="300">
                    <div class="flex justify-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                            preserveAspectRatio="xMidYMid" viewBox="0 0 256 256">
                            <path fill="#fff"
                                d="M128 23.064c34.177 0 38.225.13 51.722.745 12.48.57 19.258 2.655 23.769 4.408 5.974 2.322 10.238 5.096 14.717 9.575 4.48 4.479 7.253 8.743 9.575 14.717 1.753 4.511 3.838 11.289 4.408 23.768.615 13.498.745 17.546.745 51.723 0 34.178-.13 38.226-.745 51.723-.57 12.48-2.655 19.257-4.408 23.768-2.322 5.974-5.096 10.239-9.575 14.718-4.479 4.479-8.743 7.253-14.717 9.574-4.511 1.753-11.289 3.839-23.769 4.408-13.495.616-17.543.746-51.722.746-34.18 0-38.228-.13-51.723-.746-12.48-.57-19.257-2.655-23.768-4.408-5.974-2.321-10.239-5.095-14.718-9.574-4.479-4.48-7.253-8.744-9.574-14.718-1.753-4.51-3.839-11.288-4.408-23.768-.616-13.497-.746-17.545-.746-51.723 0-34.177.13-38.225.746-51.722.57-12.48 2.655-19.258 4.408-23.769 2.321-5.974 5.095-10.238 9.574-14.717 4.48-4.48 8.744-7.253 14.718-9.575 4.51-1.753 11.288-3.838 23.768-4.408 13.497-.615 17.545-.745 51.723-.745M128 0C93.237 0 88.878.147 75.226.77c-13.625.622-22.93 2.786-31.071 5.95-8.418 3.271-15.556 7.648-22.672 14.764C14.367 28.6 9.991 35.738 6.72 44.155 3.555 52.297 1.392 61.602.77 75.226.147 88.878 0 93.237 0 128c0 34.763.147 39.122.77 52.774.622 13.625 2.785 22.93 5.95 31.071 3.27 8.417 7.647 15.556 14.763 22.672 7.116 7.116 14.254 11.492 22.672 14.763 8.142 3.165 17.446 5.328 31.07 5.95 13.653.623 18.012.77 52.775.77s39.122-.147 52.774-.77c13.624-.622 22.929-2.785 31.07-5.95 8.418-3.27 15.556-7.647 22.672-14.763 7.116-7.116 11.493-14.254 14.764-22.672 3.164-8.142 5.328-17.446 5.95-31.07.623-13.653.77-18.012.77-52.775s-.147-39.122-.77-52.774c-.622-13.624-2.786-22.929-5.95-31.07-3.271-8.418-7.648-15.556-14.764-22.672C227.4 14.368 220.262 9.99 211.845 6.72c-8.142-3.164-17.447-5.328-31.071-5.95C167.122.147 162.763 0 128 0Zm0 62.27C91.698 62.27 62.27 91.7 62.27 128c0 36.302 29.428 65.73 65.73 65.73 36.301 0 65.73-29.428 65.73-65.73 0-36.301-29.429-65.73-65.73-65.73Zm0 108.397c-23.564 0-42.667-19.103-42.667-42.667S104.436 85.333 128 85.333s42.667 19.103 42.667 42.667-19.103 42.667-42.667 42.667Zm83.686-110.994c0 8.484-6.876 15.36-15.36 15.36-8.483 0-15.36-6.876-15.36-15.36 0-8.483 6.877-15.36 15.36-15.36 8.484 0 15.36 6.877 15.36 15.36Z" />
                        </svg>
                    </div>
                    <h4 class="font-semibold text-white text-sm mb-1">Instagram</h4>
                    <span class="text-xs text-white/80">Kunjungi →</span>
                </a>
            </div>

        </div>
    </div>
</div>


<!-- Stats Cards for Mobile - Compact 4 Columns -->
<div class="container mx-auto md:hidden mt-custom-neg-60 px-4 relative z-20">
    <div class="bg-grad-main text-white rounded-2xl shadow-2xl max-w-md mx-auto p-4 overflow-hidden relative"
        data-aos="fade-up" data-aos-duration="800">

        <!-- Background decorative elements -->
        <div class="absolute -top-20 -right-20 w-40 h-40 rounded-full bg-purple-700/20 blur-xl" data-aos="zoom-in"
            data-aos-delay="200"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 rounded-full bg-indigo-600/20 blur-xl" data-aos="zoom-in"
            data-aos-delay="300"></div>

        <!-- Header -->
        <div class="text-center mb-3 relative z-10" data-aos="fade-down" data-aos-delay="100">
            <h2 class="text-xl font-bold mb-1">{{ get_setting('school_name') }}</h2>
            <p class="text-xs text-white/80">{{ get_setting('tagline') }}</p>
        </div>

        <!-- 4 Column Compact Stats -->
        <div class="grid grid-cols-4 gap-2 text-center text-xs relative z-10" data-aos="zoom-in" data-aos-delay="200">
            <!-- Siswa -->
            <div class="p-2 bg-white/5 rounded-lg hover:bg-white/10 transition-all duration-300">
                <x-heroicon-o-user-group class="w-5 h-5 mx-auto mb-1 text-white" />
                <div class="font-semibold text-sm">{{ $jumlahSiswaAktif }}</div>
                <div class="text-white/70 text-[10px]">Siswa</div>
            </div>
            <!-- GTK -->
            <div class="p-2 bg-white/5 rounded-lg hover:bg-white/10 transition-all duration-300">
                <x-heroicon-o-academic-cap class="w-5 h-5 mx-auto mb-1 text-amber-300" />
                <div class="font-semibold text-sm">{{ $jumlahGtk }}</div>
                <div class="text-white/70 text-[10px]">GTK</div>
            </div>
            <!-- Alumni -->
            <div class="p-2 bg-white/5 rounded-lg hover:bg-white/10 transition-all duration-300">
                <x-heroicon-o-user class="w-5 h-5 mx-auto mb-1 text-white" />
                <div class="font-semibold text-sm">{{ $jumlahAlumni }}</div>
                <div class="text-white/70 text-[10px]">Alumni</div>
            </div>
            <!-- Prestasi -->
            <div class="p-2 bg-white/5 rounded-lg hover:bg-white/10 transition-all duration-300">
                <x-heroicon-o-star class="w-5 h-5 mx-auto mb-1 text-yellow-300" />
                <div class="font-semibold text-sm">100+</div>
                <div class="text-white/70 text-[10px]">Prestasi</div>
            </div>
        </div>
    </div>
</div>
