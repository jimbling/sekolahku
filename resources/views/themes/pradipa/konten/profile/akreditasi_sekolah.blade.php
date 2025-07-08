@extends('themes.' . getActiveTheme() . '.app_statis')
@section('title', 'Akreditasi Sekolah')

@section('hero')
    <!-- Modern Hero Section for Accreditation -->
    <div class="relative bg-gradient-to-br from-[#0a3d3a] to-[#0e7669] text-white overflow-hidden">
        <!-- Abstract Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <!-- Certificate-like decorative elements -->
            <div class="absolute top-1/4 left-1/4 w-32 h-32 rounded-full bg-white/5 blur-xl animate-float-slow"></div>
            <div class="absolute top-1/3 right-1/4 w-24 h-24 rounded-full bg-teal-300/10 blur-lg animate-float-delay"></div>
            <div class="absolute bottom-1/4 right-1/3 w-40 h-40 rounded-full bg-white/10 blur-xl animate-float"></div>

            <!-- Seal/Stamp effect -->
            <div
                class="absolute -bottom-20 -left-20 w-64 h-64 bg-white/5 rounded-full border-8 border-white/10 animate-spin-slow">
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
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-amber-300" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-medium tracking-wider">PRESTASI SEKOLAH</span>
                </div>

                <!-- Main Title with gradient text -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight mb-4">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-white to-teal-100">Akreditasi
                        Sekolah</span>
                </h1>

                <!-- Subtitle -->
                <div class="relative inline-block">
                    <p class="text-lg sm:text-xl text-teal-100/90 max-w-3xl mx-auto">
                        Pengakuan Resmi atas Mutu Pendidikan di SD Negeri Kedungrejo
                    </p>
                    <span
                        class="absolute bottom-0 left-0 w-full h-0.5 bg-teal-300/50 scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                </div>

                <!-- Interactive scroll indicator -->
                <div class="mt-12 animate-bounce-slow">
                    <div class="flex flex-col items-center justify-center group">
                        <span class="text-sm mb-2 opacity-80 group-hover:opacity-100 transition-opacity">Lihat
                            Sertifikat</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:text-amber-300 transition-colors"
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
    <div class="container mx-auto px-4 max-w-5xl">
        <!-- Accreditation Overview -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-12">
            <!-- Section Header -->
            <div class="bg-gradient-to-r from-[#0a3d3a] to-[#0e7669] p-6">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Status Akreditasi Terkini
                </h2>
            </div>

            <!-- Content -->
            <div class="p-6 md:p-8">
                <div class="grid md:grid-cols-2 gap-8 items-center">
                    <!-- Accreditation Badge -->
                    <div class="flex justify-center">
                        <div class="relative">
                            <div
                                class="w-48 h-48 rounded-full bg-amber-500/10 flex items-center justify-center border-8 border-amber-500/20 animate-pulse-slow">
                                <div class="text-center">
                                    <span class="block text-5xl font-bold text-amber-600">A</span>
                                    <span class="block text-sm font-medium text-amber-700 uppercase mt-2">Unggul</span>
                                </div>
                            </div>
                            <div
                                class="absolute -inset-4 rounded-full border-2 border-amber-400/30 animate-ping-slow pointer-events-none">
                            </div>
                        </div>
                    </div>

                    <!-- Accreditation Details -->
                    <div>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="font-semibold text-gray-500 text-sm uppercase tracking-wider">Tanggal
                                        Visitasi</h3>
                                    <p class="text-lg text-gray-800">02-03 Agustus 2023</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="font-semibold text-gray-500 text-sm uppercase tracking-wider">Ditetapkan</h3>
                                    <p class="text-lg text-gray-800">10 Oktober 2022</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="font-semibold text-gray-500 text-sm uppercase tracking-wider">Berlaku Sampai
                                    </h3>
                                    <p class="text-lg text-gray-800">10 Oktober 2028</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="font-semibold text-gray-500 text-sm uppercase tracking-wider">Lembaga
                                        Penilai</h3>
                                    <p class="text-lg text-gray-800">BAN S/M DIY</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Certificate Section -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-12">
            <!-- Section Header -->
            <div class="bg-gradient-to-r from-amber-600 to-amber-500 p-6">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    Sertifikat Akreditasi
                </h2>
            </div>

            <!-- Certificate Image -->
            <div class="p-6 md:p-8">
                <div class="relative group">
                    <div class="relative overflow-hidden rounded-lg shadow-lg border-8 border-white bg-gray-50">
                        <img src="https://sdnkedungrejo.sch.id/storage/summernote/akreditasi-sekolah-1749464197.webp"
                            alt="Sertifikat Akreditasi SD Negeri Kedungrejo"
                            class="w-full h-auto object-contain transition-transform duration-500 group-hover:scale-105">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-6">
                            <span class="text-white text-sm">Sertifikat Akreditasi SD Negeri Kedungrejo</span>
                        </div>
                    </div>
                    <div
                        class="absolute -top-4 -right-4 bg-white rounded-full p-2 shadow-lg transform rotate-12 group-hover:rotate-0 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                        </svg>
                    </div>
                </div>

                <!-- Download Button -->
                <div class="mt-6 text-center">
                    <a href="https://sdnkedungrejo.sch.id/storage/summernote/akreditasi-sekolah-1749464197.webp"
                        download="Sertifikat-Akreditasi-SDN-Kedungrejo"
                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Unduh Sertifikat
                    </a>
                </div>
            </div>
        </div>

        <!-- Accreditation Meaning Section -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Section Header -->
            <div class="bg-gradient-to-r from-[#0a3d3a] to-[#0e7669] p-6">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Makna Akreditasi
                </h2>
            </div>

            <!-- Content -->
            <div class="p-6 md:p-8">
                <div class="prose prose-lg text-gray-700 max-w-none">
                    <p class="text-lg leading-relaxed">
                        Akreditasi <strong>peringkat A (Unggul)</strong> yang diraih oleh SD Negeri Kedungrejo menunjukkan
                        bahwa sekolah ini telah memenuhi standar mutu pendidikan yang ditetapkan oleh Badan Akreditasi
                        Nasional Sekolah/Madrasah (BAN S/M).
                    </p>

                    <div class="mt-6 grid md:grid-cols-2 gap-6">
                        <div class="bg-teal-50 p-6 rounded-lg border-l-4 border-teal-500">
                            <h3 class="text-lg font-semibold text-teal-800 mb-3">Apa Artinya?</h3>
                            <ul class="space-y-2">
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-teal-600 mt-1 mr-2 flex-shrink-0" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>Memenuhi 8 Standar Nasional Pendidikan</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-teal-600 mt-1 mr-2 flex-shrink-0" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>Memiliki sistem penjaminan mutu pendidikan</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-teal-600 mt-1 mr-2 flex-shrink-0" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>Layanan pendidikan yang berkualitas</span>
                                </li>
                            </ul>
                        </div>

                        <div class="bg-amber-50 p-6 rounded-lg border-l-4 border-amber-500">
                            <h3 class="text-lg font-semibold text-amber-800 mb-3">Manfaat untuk Siswa</h3>
                            <ul class="space-y-2">
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-amber-600 mt-1 mr-2 flex-shrink-0" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>Proses pembelajaran yang terstandar</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-amber-600 mt-1 mr-2 flex-shrink-0" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>Fasilitas pendidikan yang memadai</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-amber-600 mt-1 mr-2 flex-shrink-0" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>Pengakuan nasional atas ijazah</span>
                                </li>
                            </ul>
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

        @keyframes pulse-slow {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.8;
            }
        }

        @keyframes ping-slow {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            100% {
                transform: scale(1.2);
                opacity: 0;
            }
        }

        @keyframes spin-slow {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
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

        .animate-pulse-slow {
            animation: pulse-slow 3s ease-in-out infinite;
        }

        .animate-ping-slow {
            animation: ping-slow 3s ease-out infinite;
        }

        .animate-spin-slow {
            animation: spin-slow 60s linear infinite;
        }
    </style>
@endpush
