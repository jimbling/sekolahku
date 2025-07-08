@extends('themes.' . getActiveTheme() . '.app_statis')
@section('title', 'Penerimaan Siswa Baru')

@section('hero')
    <!-- Modern Hero Section for New Student Admission -->
    <div class="relative bg-gradient-to-br from-[#0a3d3a] to-[#0e7669] text-white overflow-hidden">
        <!-- Abstract Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <!-- Student-themed decorative elements -->
            <div class="absolute top-1/4 left-1/4 w-32 h-32 rounded-full bg-white/5 blur-xl animate-float-slow"></div>
            <div class="absolute top-1/3 right-1/4 w-24 h-24 rounded-full bg-teal-300/10 blur-lg animate-float-delay"></div>

            <!-- School elements -->
            <div class="absolute bottom-1/4 right-1/3 w-40 h-40 opacity-10">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M12 4v16m8-8H4m13-5l-5 5m5 5l-5-5" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
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
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    <span class="text-sm font-medium tracking-wider">TAHUN AJARAN
                        {{ date('Y') }}/{{ date('Y') + 1 }}</span>
                </div>

                <!-- Main Title with gradient text -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight mb-4">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-white to-teal-100">Penerimaan Siswa
                        Baru</span>
                </h1>

                <!-- Subtitle -->
                <div class="relative inline-block">
                    <p class="text-lg sm:text-xl text-teal-100/90 max-w-3xl mx-auto">
                        Informasi Pendaftaran Peserta Didik Baru SD Negeri Kedungrejo
                    </p>
                    <span
                        class="absolute bottom-0 left-0 w-full h-0.5 bg-teal-300/50 scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                </div>

                <!-- Interactive scroll indicator -->
                <div class="mt-12 animate-bounce-slow">
                    <div class="flex flex-col items-center justify-center group">
                        <span class="text-sm mb-2 opacity-80 group-hover:opacity-100 transition-opacity">Lihat
                            Informasi</span>
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
    <div class="container mx-auto px-4 py-12 max-w-4xl">
        <!-- Main Information Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-12">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-[#0a3d3a] to-[#0e7669] p-6">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Sistem Penerimaan Murid Baru (SPMB)
                </h2>
            </div>

            <!-- Card Content -->
            <div class="p-6 md:p-8">
                <div class="prose prose-lg text-gray-700 max-w-none">
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                        <p class="text-blue-800 font-medium">
                            Pendaftaran Penerimaan Siswa Baru Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }} akan
                            diumumkan melalui:
                        </p>
                    </div>

                    <!-- Information Channels -->
                    <div class="grid md:grid-cols-3 gap-6 mb-8">
                        <!-- Website -->
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="bg-teal-100/20 p-3 rounded-full inline-flex mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-teal-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-gray-800 mb-1">Website Sekolah</h3>
                            <p class="text-sm text-gray-600">
                                <a href="{{ get_setting('website') }}"
                                    class="text-teal-600 hover:text-teal-800 transition-colors" target="_blank">
                                    {{ get_setting('website') }}
                                </a>
                            </p>
                        </div>

                        <!-- Social Media -->
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="bg-teal-100/20 p-3 rounded-full inline-flex mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-teal-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-gray-800 mb-1">Media Sosial</h3>
                            <p class="text-sm text-gray-600">
                                Facebook, Instagram, dan WhatsApp
                            </p>
                        </div>

                        <!-- Offline -->
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="bg-teal-100/20 p-3 rounded-full inline-flex mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-teal-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-gray-800 mb-1">Sekolah</h3>
                            <p class="text-sm text-gray-600">
                                Pengumuman di papan informasi sekolah
                            </p>
                        </div>
                    </div>

                    <!-- Registration Process -->
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                        <h3 class="font-bold text-gray-800 mb-2">Proses Pendaftaran Manual</h3>
                        <p class="text-gray-700">
                            Pendaftaran dilakukan secara manual dengan datang langsung ke sekolah dan membawa berkas
                            persyaratan. Informasi lengkap mengenai persyaratan akan diumumkan melalui channel di atas.
                        </p>
                    </div>

                    <!-- School Address -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="font-bold text-gray-800 mb-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-teal-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Lokasi Pendaftaran
                        </h3>
                        <p class="text-gray-700 mb-2">
                            {{ get_setting('school_name') }}<br>
                            {{ get_setting('sub_village') }}, RT {{ get_setting('rt') }}/RW {{ get_setting('rw') }}<br>
                            Kalurahan {{ get_setting('village') }}, Kapanewon {{ get_setting('sub_district') }}<br>
                            {{ get_setting('district') }}
                        </p>
                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode(get_setting('school_name') . ' ' . get_setting('sub_village') . ' ' . get_setting('village') . ' ' . get_setting('sub_district') . ' ' . get_setting('district')) }}"
                            target="_blank"
                            class="inline-flex items-center text-sm text-teal-600 hover:text-teal-800 mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                            Lihat di Peta
                        </a>
                    </div>

                    <!-- Contact Information -->
                    <div class="mt-6 bg-gray-50 p-6 rounded-lg">
                        <h3 class="font-bold text-gray-800 mb-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-teal-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            Kontak Panitia PPDB
                        </h3>
                        <p class="text-gray-700">
                            Telepon: {{ get_setting('phone') }}<br>
                            Email: {{ get_setting('email') }}<br>
                            Jam Kerja: Senin-Jumat, 07.30-14.00 WIB
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Important Notes -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-amber-500 to-amber-600 p-6">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Catatan Penting
                </h2>
            </div>
            <div class="p-6 md:p-8">
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-gray-700">
                                Informasi lengkap mengenai jadwal, persyaratan, dan prosedur pendaftaran akan diumumkan
                                mendekati masa pendaftaran.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-gray-700">
                                Pastikan untuk selalu memantau pengumuman resmi dari sekolah melalui channel yang telah
                                ditentukan.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-gray-700">
                                Pendaftaran hanya dilakukan secara langsung di sekolah dengan membawa berkas persyaratan
                                asli dan fotokopi.
                            </p>
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
    </style>
@endpush
