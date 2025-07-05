<div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
    <!-- Section Header -->
    <div class="text-center mb-16" data-aos="fade-up" data-aos-delay="100">
        <span class="inline-block mb-4 text-sm font-semibold tracking-wider text-teal-600 uppercase">Profile
            Sekolah</span>
        <h2 class="text-4xl font-bold text-gray-900 mb-4">
            Video Profil Sekolah
        </h2>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
            Mengenal lebih dekat {{ get_setting('school_name') }} melalui video profile kami.
        </p>
    </div>

    <!-- Video Container -->
    <div class="group relative max-w-4xl mx-auto" data-aos="fade-up" data-aos-delay="150">
        <!-- Decorative Elements -->
        <div
            class="absolute -inset-4 rounded-2xl bg-gradient-to-r from-teal-400 to-emerald-400 opacity-0 group-hover:opacity-20 blur-lg transition-all duration-500 pointer-events-none">
        </div>
        <div
            class="absolute -top-5 -right-5 w-16 h-16 bg-teal-100 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none">
        </div>
        <div
            class="absolute -bottom-5 -left-5 w-16 h-16 bg-emerald-100 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none">
        </div>

        <!-- YouTube Embed Container -->
        <div
            class="relative pt-[56.25%] rounded-xl overflow-hidden shadow-2xl bg-black border-2 border-transparent group-hover:border-teal-400 transition-all duration-300">
            <!-- Thumbnail (Fallback) -->
            <img id="video-thumbnail" src="https://img.youtube.com/vi/4c7uks9bh_4/maxresdefault.jpg"
                alt="Video Profil Sekolah"
                class="absolute inset-0 w-full h-full object-cover cursor-pointer transition-opacity duration-300 group-hover:opacity-90">

            <!-- Embed Iframe (Hidden until clicked) -->
            <iframe id="video-embed" class="absolute inset-0 w-full h-full hidden" src="" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>

            <!-- Play Button (Hidden when video playing) -->
            <button id="play-button"
                class="absolute inset-0 flex items-center justify-center w-full h-full transition-opacity duration-300">
                <div
                    class="w-20 h-20 bg-gradient-to-br from-teal-500 to-emerald-600 rounded-full flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300 shadow-xl">
                    <svg class="w-8 h-8 text-white ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </button>
        </div>

        <!-- Video Info -->
        <div class="mt-6 p-6 bg-white rounded-lg shadow-md border border-gray-100">
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Profil Resmi {{ get_setting('school_name') }}</h3>
            <p class="text-gray-600 mb-4">Video lengkap tentang fasilitas, program unggulan, dan kegiatan siswa kami.
            </p>

            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <!-- YouTube Channel -->
                    <a href="https://youtube.com" target="_blank" class="flex items-center group">
                        <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-200 border-2 border-white shadow-sm">
                            <img src="https://yt3.googleusercontent.com/ytc/APkrFKZWeMCsx4Q9e_Hm6nhOOUQ3fv96QGUXiMr1-pPP=s176-c-k-c0x00ffffff-no-rj"
                                alt="YouTube Channel" class="w-full h-full object-cover">
                        </div>
                        <span class="ml-3 text-gray-700 group-hover:text-teal-600 transition-colors">Channel
                            Sekolah</span>
                    </a>

                    <!-- Duration -->
                    <span class="flex items-center text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        5:32 menit
                    </span>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-3">
                    <a href="https://www.youtube.com/watch?v=4c7uks9bh_4" target="_blank"
                        class="flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors text-gray-800 hover:text-teal-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        Buka di YouTube
                    </a>
                    <button
                        class="p-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors text-gray-800 hover:text-teal-700"
                        onclick="shareVideo()">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        // Fungsi untuk memuat embed YouTube saat tombol play diklik
        document.getElementById('play-button').addEventListener('click', function() {
            const thumbnail = document.getElementById('video-thumbnail');
            const embed = document.getElementById('video-embed');
            const playButton = document.getElementById('play-button');

            // Animasi transisi
            thumbnail.style.opacity = '0';
            playButton.style.opacity = '0';

            setTimeout(() => {
                thumbnail.style.display = 'none';
                playButton.style.display = 'none';
                embed.style.display = 'block';
                embed.src = `https://www.youtube.com/embed/4c7uks9bh_4?autoplay=1&rel=0&modestbranding=1`;
            }, 300);
        });

        // Fungsi untuk berbagi video
        function shareVideo() {
            if (navigator.share) {
                navigator.share({
                    title: 'Profil Sekolah {{ get_setting('school_name') }}',
                    text: 'Tonton video profil sekolah kami',
                    url: 'https://www.youtube.com/watch?v=4c7uks9bh_4'
                }).catch(console.error);
            } else {
                // Fallback untuk browser yang tidak mendukung Web Share API
                const dummy = document.createElement('input');
                document.body.appendChild(dummy);
                dummy.value = 'https://www.youtube.com/watch?v=4c7uks9bh_4';
                dummy.select();
                document.execCommand('copy');
                document.body.removeChild(dummy);
                alert('Link video telah disalin ke clipboard!');
            }
        }
    </script>
@endpush
