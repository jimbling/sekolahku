@extends('themes.' . getActiveTheme() . '.app_statis')
@section('title', 'Identitas Sekolah')

@section('hero')
    <!-- Modern Hero Section with Interactive Elements -->
    <div class="relative bg-gradient-to-br from-[#0a3d3a] to-[#0e7669] text-white overflow-hidden">
        <!-- Abstract Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <!-- Floating circles with different animations -->
            <div class="absolute top-1/4 left-1/4 w-32 h-32 rounded-full bg-teal-300/10 blur-xl animate-float-slow"></div>
            <div class="absolute top-1/3 right-1/4 w-24 h-24 rounded-full bg-white/5 blur-lg animate-float-delay"></div>
            <div class="absolute bottom-1/4 right-1/3 w-40 h-40 rounded-full bg-teal-400/10 blur-xl animate-float"></div>

            <!-- Geometric shapes -->
            <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-teal-500/5 rotate-45 rounded-2xl"></div>
            <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/3 rotate-12 rounded-lg"></div>

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
                    <span class="text-sm font-medium">Profil Institusi</span>
                </div>

                <!-- Main Title with gradient text -->
                <h1
                    class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight mb-4 bg-clip-text text-transparent bg-gradient-to-r from-white to-teal-100">
                    Identitas Sekolah
                </h1>

                <!-- Subtitle with animated underline -->
                <div class="relative inline-block">
                    <p class="text-lg sm:text-xl text-teal-100/90 max-w-3xl mx-auto">
                        Profil lengkap {{ get_setting('school_name') }}
                    </p>
                    <span
                        class="absolute bottom-0 left-0 w-full h-0.5 bg-teal-300/50 scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                </div>

                <!-- Interactive scroll indicator -->
                <div class="mt-12 animate-bounce">
                    <div class="flex flex-col items-center justify-center">
                        <span class="text-sm mb-2 opacity-80">Scroll untuk melanjutkan</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom gradient overlay -->
        <div
            class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-[#0a3d3a]/80 to-transparent pointer-events-none">
        </div>
    </div>
@endsection

@section('content')
    <div class="container mx-auto max-w-4xl px-4 py-12">
        <!-- School Profile Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-[#0a3d3a] to-[#0e7669] p-6">
                <div class="flex items-center">
                    <div class="bg-white/10 p-3 rounded-lg backdrop-blur-sm mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">{{ get_setting('school_name') }}</h2>
                        <p class="text-teal-100/90">NPSN: {{ get_setting('npsn') }}</p>
                    </div>
                </div>
            </div>

            <!-- Card Content -->
            <div class="p-6 md:p-8">
                <!-- School Identity Grid -->
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Basic Information -->
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="bg-teal-100/20 p-2 rounded-lg mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-500 text-sm uppercase tracking-wider">Kepala Sekolah</h3>
                                <p class="text-lg font-medium text-gray-800">{{ get_setting('headmaster') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-teal-100/20 p-2 rounded-lg mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-500 text-sm uppercase tracking-wider">Kontak</h3>
                                <p class="text-lg font-medium text-gray-800">{{ get_setting('phone') }}</p>
                                <p class="text-gray-600">Fax: {{ get_setting('fax') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-teal-100/20 p-2 rounded-lg mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-500 text-sm uppercase tracking-wider">Email & Website
                                </h3>
                                <p class="text-lg font-medium text-gray-800">{{ get_setting('email') }}</p>
                                <p class="text-teal-600 hover:text-teal-800 transition-colors">
                                    <a href="{{ get_setting('website') }}" target="_blank">{{ get_setting('website') }}</a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="bg-teal-100/20 p-2 rounded-lg mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-500 text-sm uppercase tracking-wider">Alamat Lengkap
                                </h3>
                                <p class="text-gray-800">
                                    {{ get_setting('sub_village') }}, RT {{ get_setting('rt') }}/RW
                                    {{ get_setting('rw') }}<br>
                                    Dusun {{ get_setting('sub_village') }}<br>
                                    Kalurahan {{ get_setting('village') }}<br>
                                    Kapanewon {{ get_setting('sub_district') }}<br>
                                    {{ get_setting('district') }}<br>
                                    Kode Pos: {{ get_setting('postal_code') }}
                                </p>
                            </div>
                        </div>

                        <!-- Map Link -->
                        <div class="mt-6">
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode(get_setting('school_name') . ' ' . get_setting('sub_village') . ' ' . get_setting('village') . ' ' . get_setting('sub_district') . ' ' . get_setting('district')) }}"
                                target="_blank"
                                class="inline-flex items-center px-4 py-2 border border-teal-600 text-teal-600 rounded-lg hover:bg-teal-600 hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                </svg>
                                Lihat di Peta
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="mt-12 pt-8 border-t border-gray-100">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-teal-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Informasi Tambahan
                    </h3>

                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-500 text-sm uppercase tracking-wider">Status Sekolah</h4>
                            <p class="text-lg font-medium text-gray-800">Negeri</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-500 text-sm uppercase tracking-wider">Akreditasi</h4>
                            <p class="text-lg font-medium text-gray-800">A (Unggul)</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-500 text-sm uppercase tracking-wider">Tahun Berdiri</h4>
                            <p class="text-lg font-medium text-gray-800">1960</p>
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

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-float-slow {
            animation: float-slow 8s ease-in-out infinite;
        }

        .animate-float-delay {
            animation: float-delay 7s ease-in-out 1s infinite;
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
