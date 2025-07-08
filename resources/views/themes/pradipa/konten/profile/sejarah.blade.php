@extends('themes.' . getActiveTheme() . '.app_statis')
@section('title', 'Sejarah Sekolah')

@section('hero')
    <!-- Modern Hero Section with Historical Theme -->
    <div class="relative bg-gradient-to-br from-[#2c5e5b] to-[#1a423f] text-white overflow-hidden">
        <!-- Vintage Paper Texture Background -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiBwYXR0ZXJuVW5pdHM9InVzZXJTcGFjZU9uVXNlIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCI+PHBhdGggZD0iTTAgMGgxMDB2MTAwSDB6IiBmaWxsPSJub25lIi8+PHBhdGggZD0iTTAgMGgxMHYxMDBIMHoiIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4wMiIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNwYXR0ZXJuKSIvPjwvc3ZnPg==')] opacity-10">
            </div>

            <!-- Decorative historical elements -->
            <div class="absolute top-1/4 left-1/4 w-32 h-32 rounded-full bg-amber-200/5 blur-xl animate-float-slow"></div>
            <div class="absolute bottom-1/3 right-1/4 w-24 h-24 rounded-full bg-white/5 blur-lg animate-float-delay"></div>

            <!-- Vintage ink splatter effect -->
            <div
                class="absolute bottom-0 right-0 w-64 h-64 opacity-5 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyMDAgMjAwIj48cGF0aCBkPSJNNDAgMTIwQzYwIDE0MCA4MCAxNDAgMTAwIDEyMEMxMjAgMTAwIDE0MCAxNDAgMTYwIDEyMEMxODAgMTAwIDE4MCA2MCAxNjAgNDBDMTQwIDIwIDEyMCAzMCAxMDAgNTBDODAgMzAgNjAgMTAgNDAgMTBDMjAgMTAgMCAzMCAwIDcwQzAgMTEwIDIwIDEwMCA0MCAxMjBaIiBmaWxsPSIjMDAwIi8+PC9zdmc+')] bg-no-repeat bg-contain">
            </div>
        </div>

        <!-- Main Content Container -->
        <div class="container mx-auto px-6 py-12 md:py-16 lg:py-20 relative z-10">
            <div class="max-w-4xl mx-auto text-center" data-aos="fade-up" data-aos-duration="600">
                <!-- Historical badge -->
                <div
                    class="inline-flex items-center justify-center px-4 py-2 mb-6 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 animate-pulse">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-amber-300" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-medium tracking-wider">KILAS BALIK SEJARAH</span>
                </div>

                <!-- Main Title -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight mb-4">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-white to-amber-200">Sejarah SDN
                        Kedungrejo</span>
                </h1>

                <!-- Subtitle -->
                <p class="text-lg sm:text-xl text-teal-100/90 max-w-3xl mx-auto mb-8">
                    Jejak Perjalanan Pendidikan dari Masa ke Masa
                </p>

                <!-- Scroll indicator with historical theme -->
                <div class="mt-8 animate-bounce-slow">
                    <div class="flex flex-col items-center justify-center group">
                        <span class="text-sm mb-2 opacity-80 group-hover:opacity-100 transition-opacity">Telusuri Sejarah
                            Kami</span>
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
            class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-[#1a423f] to-transparent pointer-events-none">
        </div>
    </div>
@endsection

@section('content')
    <div class="container mx-auto px-4 max-w-5xl">
        <!-- Main History Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-12 transition-all duration-300 hover:shadow-xl">
            <!-- Section Header -->
            <div class="bg-gradient-to-r from-[#2c5e5b] to-[#1a423f] p-6">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Asal Usul SDN Kedungrejo
                </h2>
            </div>

            <!-- Content -->
            <div class="p-6 md:p-8">
                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Historical Image -->
                    <div class="md:w-1/2">
                        <div class="relative rounded-lg overflow-hidden shadow-md border-4 border-white">
                            <img src="https://sdnkedungrejo.sch.id/storage/summernote/sejarah-1749462856.webp"
                                alt="Gedung SDN Kedungrejo"
                                class="w-full h-auto object-cover transition-transform duration-500 hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-4 bg-black/50 text-white text-sm">
                                SDN Kedungrejo - Berdiri Atas Gotong Royong Masyarakat
                            </div>
                        </div>
                    </div>

                    <!-- Historical Text -->
                    <div class="md:w-1/2">
                        <div class="prose prose-lg text-gray-700 max-w-none">
                            <p class="text-lg leading-relaxed mb-4">
                                <span class="font-semibold text-[#2c5e5b]">SD Negeri Kedungrejo</span> adalah sekolah dasar
                                yang terletak di Dusun Kedungtangkil, Karangsari, Pengasih, Kulon Progo. Sekolah ini
                                merupakan buah dari semangat gotong royong warga masyarakat sekitar tahun 1960-an yang
                                bertekad memberikan pendidikan yang layak untuk anak cucu mereka.
                            </p>
                            <p class="text-lg leading-relaxed mb-4">
                                Saat ini, SDN Kedungrejo telah menempati gedung baru yang letaknya tidak jauh dari gedung
                                lama, hanya berbeda RT. Perpindahan ini dilakukan karena status tanah di lokasi lama masih
                                berupa tanah sewa.
                            </p>
                            <p class="text-lg leading-relaxed">
                                Gedung baru SD Negeri Kedungrejo dibangun di atas tanah yang telah dihibahkan oleh Bapak
                                Imron Rosidi TP. Sekolah ini kini memiliki fasilitas, sarana, dan prasarana yang cukup
                                memadai, meliputi:
                            </p>
                            <ul class="mt-4 space-y-2">
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-[#2c5e5b] mt-1 mr-2 flex-shrink-0" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>Ruang Perpustakaan</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-[#2c5e5b] mt-1 mr-2 flex-shrink-0" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>Mushola</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-[#2c5e5b] mt-1 mr-2 flex-shrink-0" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>Ruang Komputer</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-[#2c5e5b] mt-1 mr-2 flex-shrink-0" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>Tenaga Pendidik yang Kompeten</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Relocation History Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-12 transition-all duration-300 hover:shadow-xl">
            <!-- Section Header -->
            <div class="bg-gradient-to-r from-amber-700 to-amber-600 p-6">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Kilas Balik Relokasi Gedung Baru
                </h2>
            </div>

            <!-- Content -->
            <div class="p-6 md:p-8">
                <div class="flex flex-col md:flex-row-reverse gap-8">
                    <!-- Relocation Image -->
                    <div class="md:w-1/2">
                        <div class="relative rounded-lg overflow-hidden shadow-md border-4 border-white">
                            <img src="https://sdnkedungrejo.sch.id/storage/summernote/sejarah-1749462907.webp"
                                alt="Pelepasan Tanah Hibah untuk SDN Kedungrejo"
                                class="w-full h-auto object-cover transition-transform duration-500 hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-4 bg-black/50 text-white text-sm">
                                Pelepasan Tanah Hibah oleh Bapak Imron Rosidi TP - 17 Januari 2017
                            </div>
                        </div>
                        <div class="mt-4 text-sm text-gray-500 italic">
                            Sumber: DISDIKPORA - Pelepasan Tanah Hibah Untuk Relokasi SDN Kedungrejo Pengasih
                            (kulonprogokab.go.id)
                        </div>
                    </div>

                    <!-- Relocation Text -->
                    <div class="md:w-1/2">
                        <div class="prose prose-lg text-gray-700 max-w-none">
                            <h3 class="text-xl font-semibold text-amber-700 mb-4">Pelepasan Tanah Hibah Untuk Relokasi SDN
                                Kedungrejo Pengasih</h3>
                            <p class="text-lg leading-relaxed mb-4">
                                Pada hari Selasa, 17 Januari 2017, bertempat di Kantor Pertanahan Kabupaten Kulon Progo,
                                telah terlaksana acara pelepasan hak atas tanah oleh Bapak Imron Rosidi Tri Putranto
                                (seorang polisi) yang beralamat di Kedungtangkil RT. 063 RW 028, Karangsari, Pengasih.
                            </p>
                            <p class="text-lg leading-relaxed mb-4">
                                Acara pelepasan hak tanah ini disaksikan oleh:
                            </p>
                            <ul class="mb-4 space-y-2">
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-amber-600 mt-1 mr-2 flex-shrink-0" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span><strong>Muhammad Fadhil, S.H., M.Hum.</strong> - Kepala Kantor Pertanahan
                                        Kabupaten Kulon Progo</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-amber-600 mt-1 mr-2 flex-shrink-0" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span><strong>Drs. Sumarsana, M.Si.</strong> - Kepala Dinas Pendidikan Pemuda dan
                                        Olahraga Kabupaten Kulon Progo</span>
                                </li>
                            </ul>
                            <p class="text-lg leading-relaxed mb-4">
                                Bapak Imron Rosidi Tri Putranto telah menyerahkan secara cuma-cuma hak tanah seluas 1.366 m²
                                berdasarkan Surat Pernyataan Penyerahan/Hibah yang dibuat tanggal 28 Desember 2015. Tanah
                                ini diperuntukkan bagi layanan pendidikan, khususnya relokasi SDN Kedungrejo Pengasih.
                            </p>
                            <p class="text-lg leading-relaxed">
                                Jarak antara lokasi relokasi dengan SD sebelumnya hanya sejauh 150 meter, memudahkan proses
                                peralihan tanpa mengganggu aktivitas belajar mengajar.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl">
            <!-- Section Header -->
            <div class="bg-gradient-to-r from-[#2c5e5b] to-[#1a423f] p-6">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Garis Waktu SDN Kedungrejo
                </h2>
            </div>

            <!-- Timeline Content -->
            <div class="p-6 md:p-8">
                <div class="relative">
                    <!-- Timeline line -->
                    <div class="absolute left-5 top-0 bottom-0 w-0.5 bg-gray-200 ml-[15px] hidden md:block"></div>

                    <!-- Timeline items -->
                    <div class="space-y-8">
                        <!-- 1960s -->
                        <div class="relative pl-12 md:pl-0">
                            <div class="md:flex items-start">
                                <div
                                    class="hidden md:flex flex-shrink-0 h-12 w-12 rounded-full bg-amber-600 items-center justify-center mr-6 text-white font-bold text-lg">
                                    1960</div>
                                <div class="bg-gray-50 p-6 rounded-xl border border-gray-100 flex-1">
                                    <h3 class="text-xl font-bold text-[#2c5e5b] mb-2">Masa Pendirian</h3>
                                    <p class="text-gray-700">
                                        SDN Kedungrejo didirikan atas dasar gotong royong warga masyarakat Dusun
                                        Kedungtangkil, Karangsari, Pengasih, demi memberikan pendidikan yang layak untuk
                                        generasi penerus.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- 2015 -->
                        <div class="relative pl-12 md:pl-0">
                            <div class="md:flex items-start">
                                <div
                                    class="hidden md:flex flex-shrink-0 h-12 w-12 rounded-full bg-amber-600 items-center justify-center mr-6 text-white font-bold text-lg">
                                    2015</div>
                                <div class="bg-gray-50 p-6 rounded-xl border border-gray-100 flex-1">
                                    <h3 class="text-xl font-bold text-[#2c5e5b] mb-2">Hibah Tanah</h3>
                                    <p class="text-gray-700">
                                        Tanggal 28 Desember 2015, Bapak Imron Rosidi TP membuat Surat Pernyataan
                                        Penyerahan/Hibah tanah seluas 1.366 m² untuk relokasi SDN Kedungrejo.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- 2017 -->
                        <div class="relative pl-12 md:pl-0">
                            <div class="md:flex items-start">
                                <div
                                    class="hidden md:flex flex-shrink-0 h-12 w-12 rounded-full bg-amber-600 items-center justify-center mr-6 text-white font-bold text-lg">
                                    2017</div>
                                <div class="bg-gray-50 p-6 rounded-xl border border-gray-100 flex-1">
                                    <h3 class="text-xl font-bold text-[#2c5e5b] mb-2">Pelepasan Hak Tanah</h3>
                                    <p class="text-gray-700">
                                        Pada 17 Januari 2017, dilaksanakan acara pelepasan hak tanah di Kantor Pertanahan
                                        Kabupaten Kulon Progo, menandai dimulainya pembangunan gedung baru SDN Kedungrejo.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Present -->
                        <div class="relative pl-12 md:pl-0">
                            <div class="md:flex items-start">
                                <div
                                    class="hidden md:flex flex-shrink-0 h-12 w-12 rounded-full bg-amber-600 items-center justify-center mr-6 text-white font-bold text-lg">
                                    Kini</div>
                                <div class="bg-gray-50 p-6 rounded-xl border border-gray-100 flex-1">
                                    <h3 class="text-xl font-bold text-[#2c5e5b] mb-2">SDN Kedungrejo Modern</h3>
                                    <p class="text-gray-700">
                                        SDN Kedungrejo kini telah menempati gedung baru dengan fasilitas lengkap, siap
                                        memberikan pendidikan berkualitas untuk generasi penerus bangsa.
                                    </p>
                                </div>
                            </div>
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

        /* Vintage paper effect */
        .vintage-paper {
            background-color: #f5f5f0;
            background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.05) 1px, transparent 1px),
                linear-gradient(to right, rgba(0, 0, 0, 0.05) 1px, transparent 1px);
            background-size: 20px 20px;
        }

        /* Custom prose styling */
        .prose ul {
            list-style-type: none;
            padding-left: 0;
        }

        .prose li {
            position: relative;
            padding-left: 1.75em;
        }
    </style>
@endpush
