<section id="sidebar" class="py-2 bg-base" data-aos="fade-up">
    <div class="container mx-auto text-center">
        <div class="bg-base shadow-md rounded-lg p-6 mb-4">
            <div class="flex justify-center">
                <img src="{{ asset('storage/images/settings/' . get_setting('headmaster_photo')) }}"
                    class="max-w-sm rounded-lg shadow-2xl" data-aos="slide-right" data-aos-delay="200" />
            </div>
            <div class="max-w-md mx-auto">
                <h1 class="text-2xl font-bold">Sambutan Kepala Sekolah</h1>
                <p class="py-6 text-left overflow-hidden max-h-24"
                    style="display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical;">
                    Assalamu'alaikum Wr. Wb.

                    Di masa sekarang penyampaian informasi tidak terbatas hanya pada surat, namun juga media sosial juga
                    sangat berpengaruh. Untuk itu, SD Negeri Kedungrejo telah merilis website resmi SD Negeri Kedungrejo
                    Kapanewon Pengasih. Dengan adanya website ini, semoga informasi-informasi dapat dengan mudah
                    diakses.
                    Kegiatan-kegiatan yang dilaksanakan di SD Negeri Kedungrejo juga dapat diketahui oleh publik yang
                    lebih luas lagi.

                    Wassalamu'alaikum Wr. Wb.
                </p>
                <h1 class="text-xs font-bold">{{ get_setting('headmaster') }}</h1>
            </div>
        </div>
    </div>
</section>

<section id="announcements" class="py-8 bg-base" data-aos="fade-up">
    <div class="container mx-auto text-center">
        <!-- Announcement Card -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-4 max-w-2xl mx-auto">
            <h2 class="text-3xl font-bold mb-4">Pengumuman</h2>

            <!-- Announcement Item -->
            <div class="flex items-start mb-6 border-b border-gray-300 pb-4">
                <!-- Icon -->
                <div class="flex-shrink-0 mr-4">
                    <svg class="w-8 h-8 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z" />
                    </svg>
                </div>

                <!-- Content -->
                <div class="flex-1">
                    <h3 class="text-xl font-semibold mb-1">Pengumuman Judul</h3>
                    <p class="text-sm text-gray-600">Tanggal: 13 Juli 2024</p>
                </div>
            </div>

            <!-- Add more announcement items here -->

            <!-- Button to view more announcements -->
            <button onclick="window.location.href='/pengumuman';"
                class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg focus:outline-none transition">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd"
                        d="M15.75 2.25H21a.75.75 0 0 1 .75.75v5.25a.75.75 0 0 1-1.5 0V4.81L8.03 17.03a.75.75 0 0 1-1.06-1.06L19.19 3.75h-3.44a.75.75 0 0 1 0-1.5Zm-10.5 4.5a1.5 1.5 0 0 0-1.5 1.5v10.5a1.5 1.5 0 0 0 1.5 1.5h10.5a1.5 1.5 0 0 0 1.5-1.5V10.5a.75.75 0 0 1 1.5 0v8.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V8.25a3 3 0 0 1 3-3h8.25a.75.75 0 0 1 0 1.5H5.25Z"
                        clip-rule="evenodd" />
                </svg>

                Selengkapnya
            </button>
        </div>
    </div>
</section>
