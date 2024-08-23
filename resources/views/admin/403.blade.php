@include('components.frontend.partials.header')

<body>
    <section class="bg-white dark:bg-gray-900 ">
        <div class="container flex items-center justify-center min-h-screen px-6 py-12 mx-auto">
            <div class="w-full ">
                <div class="flex flex-col items-center max-w-lg mx-auto text-center">
                    <p class="text-sm font-medium text-blue-500 dark:text-blue-400">403 FORBIDDEN</p>
                    <h1 class="mt-3 text-2xl font-semibold text-gray-800 dark:text-white md:text-3xl">Maaf, Anda tidak
                        memiliki izin untuk mengakses halaman ini
                    </h1>
                    <p class="mt-4 text-gray-500 dark:text-gray-400">Sepertinya Anda mencoba mengakses halaman yang tidak
                        diizinkan berdasarkan hak akses Anda. Silakan kembali ke halaman utama atau hubungi admin jika
                        Anda memerlukan bantuan lebih lanjut.</p>

                    <div
                        class="flex flex-wrap items-center justify-between w-full mt-6 gap-3 sm:gap-x-3 sm:justify-center">
                        <a href="/dashboard"
                            class="flex items-center justify-center w-full sm:w-auto px-5 py-2 text-sm text-gray-600 transition-colors duration-200 bg-white border rounded-lg dark:text-gray-200 gap-x-2 dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:border-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5 rtl:rotate-180">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
                            </svg>
                            <span>Kembali</span>
                        </a>

                        <a href="/"
                            class="w-full sm:w-auto px-5 py-2 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg sm:shrink-0 hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600">
                            Website Sekolah
                        </a>
                    </div>
                </div>

                <div class="grid w-full max-w-6xl grid-cols-1 gap-8 mx-auto mt-8 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="p-6 rounded-lg bg-blue-50 dark:bg-gray-800">
                        <span class="text-gray-500 dark:text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                        </span>

                        <h3 class="mt-6 font-medium text-gray-700 dark:text-gray-200 ">Dokumentasi</h3>

                        <p class="mt-2 text-gray-500 dark:text-gray-400 ">Petunjuk dan tutorial CMS Sinau.</p>

                        <a href="https://www.sinaucms.web.id"
                            class="inline-flex items-center mt-4 text-sm text-blue-500 gap-x-2 dark:text-blue-400 hover:underline">
                            <span>Mulai baca</span>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5 rtl:rotate-180">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                            </svg>
                        </a>
                    </div>

                    <div class="p-6 rounded-lg bg-blue-50 dark:bg-gray-800">
                        <span class="text-gray-500 dark:text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                        </span>

                        <h3 class="mt-6 font-medium text-gray-700 dark:text-gray-200 ">Website CMS Sinau</h3>

                        <p class="mt-2 text-gray-500 dark:text-gray-400 ">Baca berita terbaru tentang CMS Sinau.</p>

                        <a href="https://www.sinaucms.web.id"
                            class="inline-flex items-center mt-4 text-sm text-blue-500 gap-x-2 dark:text-blue-400 hover:underline">
                            <span>Lihat berita terbaru</span>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5 rtl:rotate-180">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                            </svg>
                        </a>
                    </div>

                    <div class="p-6 rounded-lg bg-blue-50 dark:bg-gray-800">
                        <span class="text-gray-500 dark:text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 01-.923 1.785A5.969 5.969 0 006 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337z" />
                            </svg>
                        </span>

                        <h3 class="mt-6 font-medium text-gray-700 dark:text-gray-200 ">Hubungi Kami</h3>

                        <p class="mt-2 text-gray-500 dark:text-gray-400 ">Ada pertanyaan lebih lanjut?</p>

                        <a href="https://www.sinaucms.web.id"
                            class="inline-flex items-center mt-4 text-sm text-blue-500 gap-x-2 dark:text-blue-400 hover:underline">
                            <span>Silahkan hubungi tim CMS Sinau</span>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5 rtl:rotate-180">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
