@extends('themes.' . getActiveTheme() . '.app_statis')
@section('title', 'Sarana dan Prasarana')

@section('hero')
    <!-- Modern Hero Section for Facilities -->
    <div class="relative bg-gradient-to-br from-[#0a3d3a] to-[#0e7669] text-white overflow-hidden">
        <!-- Abstract Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <!-- Facility-themed decorative elements -->
            <div class="absolute top-1/4 left-1/4 w-32 h-32 rounded-full bg-white/5 blur-xl animate-float-slow"></div>
            <div class="absolute top-1/3 right-1/4 w-24 h-24 rounded-full bg-teal-300/10 blur-lg animate-float-delay"></div>

            <!-- Building outline shapes -->
            <div class="absolute bottom-1/4 right-1/3 w-40 h-40 opacity-10">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-white">
                    <path
                        d="M3 21h18M5 21V10.85M19 21V10.85M9 21V17C9 16.4477 9.44772 16 10 16H14C14.5523 16 15 16.4477 15 17V21M12 7V3M12 7L15 4M12 7L9 4M3 10L12 3L21 10"
                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>

            <!-- Subtle grid pattern overlay -->
            <div class="absolute inset-0 bg-grid-white/[0.02]"></div>
        </div>

        <!-- Main Content Container -->
        <div class="container mx-auto px-6 py-8 md:py-12 lg:py-12 relative z-10">
            <div class="max-w-4xl mx-auto text-center" data-aos="fade-up" data-aos-duration="600">
                <!-- Animated badge -->
                <div
                    class="inline-flex items-center justify-center px-4 py-2 mb-6 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 animate-pulse">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span class="text-sm font-medium tracking-wider">FASILITAS SEKOLAH</span>
                </div>

                <!-- Main Title with gradient text -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight mb-4">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-white to-teal-100">Sarana &
                        Prasarana</span>
                </h1>

                <!-- Subtitle -->
                <div class="relative inline-block">
                    <p class="text-lg sm:text-xl text-teal-100/90 max-w-3xl mx-auto">
                        Fasilitas Pendidikan Modern untuk Mendukung Proses Belajar Mengajar
                    </p>
                    <span
                        class="absolute bottom-0 left-0 w-full h-0.5 bg-teal-300/50 scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                </div>

                <!-- Interactive scroll indicator -->
                <div class="mt-12 animate-bounce-slow">
                    <div class="flex flex-col items-center justify-center group">
                        <span class="text-sm mb-2 opacity-80 group-hover:opacity-100 transition-opacity">Jelajahi
                            Fasilitas</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:text-teal-300 transition-colors"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom gradient overlay -->
        <div
            class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-[#0a3d3a] to-transparent pointer-events-none">
        </div>
    </div>
@endsection

@section('content')
    <div class="container mx-auto px-4 py-12 max-w-6xl">
        <!-- Facilities Overview -->
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Fasilitas Unggulan SD Negeri Kedungrejo</h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Kami menyediakan berbagai sarana dan prasarana modern untuk menunjang kegiatan belajar mengajar yang optimal
                bagi seluruh siswa.
            </p>
        </div>

        <!-- Facilities Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            <!-- Classroom -->
            <div
                class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="h-48 bg-gradient-to-r from-blue-50 to-cyan-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-blue-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Ruang Kelas</h3>
                    <p class="text-gray-600">
                        Ruang kelas yang nyaman dan dilengkapi dengan fasilitas modern untuk mendukung proses belajar
                        mengajar yang efektif.
                    </p>
                    <div class="mt-4 flex items-center text-sm text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        12 Ruang Kelas
                    </div>
                </div>
            </div>

            <!-- Mushola -->
            <div
                class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="h-48 bg-gradient-to-r from-green-50 to-teal-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-green-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Mushola</h3>
                    <p class="text-gray-600">
                        Tempat ibadah yang nyaman dan representatif untuk menunjang kegiatan keagamaan siswa dan guru.
                    </p>
                    <div class="mt-4 flex items-center text-sm text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Terbuka untuk shalat 5 waktu
                    </div>
                </div>
            </div>

            <!-- Library -->
            <div
                class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="h-48 bg-gradient-to-r from-purple-50 to-indigo-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-purple-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Perpustakaan</h3>
                    <p class="text-gray-600">
                        Koleksi buku yang lengkap dan ruang baca yang nyaman untuk mendukung budaya literasi siswa.
                    </p>
                    <div class="mt-4 flex items-center text-sm text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        1,500+ Koleksi Buku
                    </div>
                </div>
            </div>

            <!-- Computer Lab -->
            <div
                class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="h-48 bg-gradient-to-r from-amber-50 to-orange-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-amber-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Ruang Komputer</h3>
                    <p class="text-gray-600">
                        Laboratorium komputer dengan perangkat terbaru untuk mendukung pembelajaran teknologi informasi.
                    </p>
                    <div class="mt-4 flex items-center text-sm text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                        </svg>
                        25 Unit Komputer
                    </div>
                </div>
            </div>

            <!-- Internet -->
            <div
                class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="h-48 bg-gradient-to-r from-red-50 to-pink-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-red-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Internet</h3>
                    <p class="text-gray-600">
                        Akses internet cepat untuk mendukung pembelajaran digital dan penelitian siswa.
                    </p>
                    <div class="mt-4 flex items-center text-sm text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                        </svg>
                        WiFi Area Sekolah
                    </div>
                </div>
            </div>

            <!-- Canteen -->
            <div
                class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="h-48 bg-gradient-to-r from-yellow-50 to-amber-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-yellow-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Kantin</h3>
                    <p class="text-gray-600">
                        Kantin sehat yang menyediakan makanan bergizi dengan harga terjangkau untuk siswa.
                    </p>
                    <div class="mt-4 flex items-center text-sm text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Buka Setiap Hari Sekolah
                    </div>
                </div>
            </div>

            <!-- Health Room -->
            <div
                class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="h-48 bg-gradient-to-r from-emerald-50 to-teal-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-emerald-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Ruang UKS</h3>
                    <p class="text-gray-600">
                        Unit Kesehatan Sekolah yang lengkap untuk penanganan pertama kesehatan siswa.
                    </p>
                    <div class="mt-4 flex items-center text-sm text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                        Dokter Piket Mingguan
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Facilities Section -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-[#0a3d3a] to-[#0e7669] p-6">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Fasilitas Pendukung Lainnya
                </h2>
            </div>
            <div class="p-6 md:p-8">
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                        <div class="bg-teal-100/20 p-2 rounded-lg mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">Lapangan Olahraga</h3>
                            <p class="text-sm text-gray-500">Lapangan serbaguna untuk basket, voli, dan futsal</p>
                        </div>
                    </div>

                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                        <div class="bg-teal-100/20 p-2 rounded-lg mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">Laboratorium IPA</h3>
                            <p class="text-sm text-gray-500">Peralatan praktikum sains lengkap</p>
                        </div>
                    </div>

                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                        <div class="bg-teal-100/20 p-2 rounded-lg mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">Aula Serbaguna</h3>
                            <p class="text-sm text-gray-500">Tempat kegiatan besar dan pertemuan</p>
                        </div>
                    </div>

                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                        <div class="bg-teal-100/20 p-2 rounded-lg mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">Parkir Aman</h3>
                            <p class="text-sm text-gray-500">Area parkir luas untuk guru dan tamu</p>
                        </div>
                    </div>

                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                        <div class="bg-teal-100/20 p-2 rounded-lg mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">Toilet Bersih</h3>
                            <p class="text-sm text-gray-500">Toilet terpisah dan terjaga kebersihannya</p>
                        </div>
                    </div>

                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                        <div class="bg-teal-100/20 p-2 rounded-lg mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">Green House</h3>
                            <p class="text-sm text-gray-500">Area pembelajaran lingkungan hidup</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Custom animations */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        @keyframes float-slow {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes float-delay {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        @keyframes bounce-slow {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-float-slow {
            animation: float-slow 8s ease-in-out infinite;
        }

        .animate-float-delay {
            animation: float-delay 7s ease-in-out 1s infinite;
        }

        .animate-bounce-slow {
            animation: bounce-slow 3s ease-in-out infinite;
        }

        /* Custom card hover effect */
        .hover-scale {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-scale:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
@endpush
