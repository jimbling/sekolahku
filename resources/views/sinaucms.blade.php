<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sinau CMS - Platform Digital untuk Sekolah Dasar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #4F46E5;
            --secondary: #10B981;
            --dark: #1F2937;
            --light: #F9FAFB;
            --accent: #FBBF24;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light);
            color: var(--dark);
        }

        .gradient-bg {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .nav-link {
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: var(--primary);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .feature-icon {
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1);
            color: var(--primary);
        }

        .floating {
            animation: floating 6s ease-in-out infinite;
        }

        @keyframes floating {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }

            100% {
                transform: translateY(0px);
            }
        }
    </style>
</head>

<body>
    <!-- Preloader -->
    <div class="preloader fixed inset-0 bg-white z-50 flex items-center justify-center">
        <div class="animate-pulse flex flex-col items-center">
            <div class="bg-primary p-4 rounded-xl mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <div class="text-2xl font-bold text-primary">Sinau<span class="text-secondary">CMS</span></div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content hidden">
        <!-- Navigation -->
        <nav class="bg-white/90 backdrop-blur-md shadow-sm sticky top-0 z-40 transition-all duration-300"
            id="navbar">
            <div class="container mx-auto px-6 py-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <a href="#" class="flex items-center">
                            <div class="bg-primary p-2 rounded-lg mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <span class="text-2xl font-bold text-primary">Sinau<span
                                    class="text-secondary">CMS</span></span>
                        </a>
                    </div>

                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#fitur" class="nav-link text-gray-600 hover:text-primary font-medium">Fitur</a>
                        <a href="#layanan" class="nav-link text-gray-600 hover:text-primary font-medium">Layanan</a>
                        <a href="#siesde" class="nav-link text-gray-600 hover:text-primary font-medium">SIESDE</a>
                        <a href="#harga" class="nav-link text-gray-600 hover:text-primary font-medium">Harga</a>
                        <a href="#testimoni" class="nav-link text-gray-600 hover:text-primary font-medium">Testimoni</a>
                    </div>

                    <div class="flex items-center space-x-4">
                        <a href="#demo"
                            class="hidden md:block px-5 py-2 bg-gradient-to-r from-primary to-purple-600 text-white rounded-lg font-medium hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                            Request Demo
                        </a>
                        <button id="hamburger-menu" class="md:hidden text-gray-600 focus:outline-none">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div id="mobile-menu"
            class="fixed inset-y-0 right-0 w-64 bg-white shadow-lg transform translate-x-full md:hidden transition-transform duration-300 ease-in-out z-50">
            <div class="flex flex-col h-full p-6">
                <div class="flex justify-between items-center mb-8">
                    <a href="#" class="flex items-center">
                        <div class="bg-primary p-2 rounded-lg mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-primary">Sinau<span class="text-secondary">CMS</span></span>
                    </a>
                    <button id="close-menu" class="text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <nav class="flex-1">
                    <a href="#fitur"
                        class="block py-3 px-4 rounded-lg hover:bg-gray-100 text-gray-700 font-medium">Fitur</a>
                    <a href="#layanan"
                        class="block py-3 px-4 rounded-lg hover:bg-gray-100 text-gray-700 font-medium">Layanan</a>
                    <a href="#siesde"
                        class="block py-3 px-4 rounded-lg hover:bg-gray-100 text-gray-700 font-medium">SIESDE</a>
                    <a href="#harga"
                        class="block py-3 px-4 rounded-lg hover:bg-gray-100 text-gray-700 font-medium">Harga</a>
                    <a href="#testimoni"
                        class="block py-3 px-4 rounded-lg hover:bg-gray-100 text-gray-700 font-medium">Testimoni</a>
                </nav>

                <div class="pt-4 border-t border-gray-200">
                    <a href="#demo"
                        class="block w-full text-center px-5 py-2 bg-gradient-to-r from-primary to-purple-600 text-white rounded-lg font-medium hover:shadow-lg transition-all duration-300">
                        Request Demo
                    </a>
                </div>
            </div>
        </div>

        <!-- Hero Section -->
        <section class="gradient-bg text-white overflow-hidden">
            <div class="container mx-auto px-6 py-20 md:py-28 relative">
                <!-- Floating elements -->
                <div class="absolute top-20 left-10 w-16 h-16 rounded-full bg-white/10 backdrop-blur-sm floating"
                    style="animation-delay: 0s;"></div>
                <div class="absolute bottom-1/4 right-20 w-24 h-24 rounded-full bg-white/5 backdrop-blur-sm floating"
                    style="animation-delay: 1s;"></div>
                <div class="absolute top-1/3 right-1/4 w-12 h-12 rounded-full bg-white/15 backdrop-blur-sm floating"
                    style="animation-delay: 2s;"></div>

                <div class="flex flex-col md:flex-row items-center relative z-10">
                    <div class="md:w-1/2 mb-12 md:mb-0" data-aos="fade-right">
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                            Transformasi Digital <br> <span
                                class="bg-clip-text text-transparent bg-gradient-to-r from-accent to-white">Sekolah
                                Dasar</span>
                        </h1>
                        <p class="text-lg md:text-xl mb-8 opacity-90 max-w-lg">
                            Solusi lengkap untuk website sekolah dan sistem informasi siswa digital (SIESDE) dengan
                            teknologi modern.
                        </p>
                        <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                            <a href="#demo"
                                class="px-6 py-3 bg-white text-primary font-medium rounded-lg hover:shadow-lg hover:bg-white/95 transition-all duration-300 transform hover:-translate-y-1 text-center">
                                Coba Demo Gratis <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                            <a href="#layanan"
                                class="px-6 py-3 border-2 border-white text-white font-medium rounded-lg hover:bg-white/10 transition-all duration-300 transform hover:-translate-y-1 text-center">
                                <i class="fas fa-play-circle mr-2"></i> Lihat Video
                            </a>
                        </div>

                        <div class="mt-10 flex items-center">
                            <div class="flex -space-x-2">
                                <img src="https://randomuser.me/api/portraits/women/44.jpg"
                                    class="w-10 h-10 rounded-full border-2 border-white" alt="User">
                                <img src="https://randomuser.me/api/portraits/men/32.jpg"
                                    class="w-10 h-10 rounded-full border-2 border-white" alt="User">
                                <img src="https://randomuser.me/api/portraits/women/68.jpg"
                                    class="w-10 h-10 rounded-full border-2 border-white" alt="User">
                            </div>
                            <div class="ml-4">
                                <div class="flex items-center">
                                    <div class="flex text-yellow-400">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <span class="ml-2 text-sm">5.0 (200+ reviews)</span>
                                </div>
                                <p class="text-sm mt-1">Digunakan oleh 150+ sekolah di Indonesia</p>
                            </div>
                        </div>
                    </div>

                    <div class="md:w-1/2 flex justify-center" data-aos="fade-left">
                        <div class="relative max-w-md">
                            <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-3 shadow-2xl overflow-hidden">
                                <img src="https://via.placeholder.com/500x350" alt="Dashboard Sinau CMS"
                                    class="rounded-xl border-2 border-white/30 w-full h-auto">
                            </div>
                            <div
                                class="absolute -bottom-6 -left-6 bg-white text-dark p-4 rounded-lg shadow-lg z-20 transform hover:scale-105 transition-all duration-300">
                                <div class="flex items-center">
                                    <div class="bg-secondary p-2 rounded-lg mr-3">
                                        <i class="fas fa-qrcode text-white"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold">Verifikasi QR</div>
                                        <div class="text-xs text-gray-500">Dokumen Siswa</div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="absolute -top-6 -right-6 bg-white text-dark p-4 rounded-lg shadow-lg z-20 transform hover:scale-105 transition-all duration-300">
                                <div class="flex items-center">
                                    <div class="bg-primary p-2 rounded-lg mr-3">
                                        <i class="fas fa-laptop-code text-white"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold">Website Sekolah</div>
                                        <div class="text-xs text-gray-500">Responsif & Modern</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Trusted By -->
        <section class="py-12 bg-white">
            <div class="container mx-auto px-6">
                <p class="text-center text-gray-500 mb-8">Dipercaya oleh sekolah-sekolah ternama</p>
                <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16">
                    <div class="h-10 grayscale opacity-60 hover:grayscale-0 hover:opacity-100 transition duration-300">
                        <img src="https://via.placeholder.com/120x40" alt="Sekolah Dasar" class="h-full">
                    </div>
                    <div class="h-10 grayscale opacity-60 hover:grayscale-0 hover:opacity-100 transition duration-300">
                        <img src="https://via.placeholder.com/120x40" alt="Sekolah Dasar" class="h-full">
                    </div>
                    <div class="h-10 grayscale opacity-60 hover:grayscale-0 hover:opacity-100 transition duration-300">
                        <img src="https://via.placeholder.com/120x40" alt="Sekolah Dasar" class="h-full">
                    </div>
                    <div class="h-10 grayscale opacity-60 hover:grayscale-0 hover:opacity-100 transition duration-300">
                        <img src="https://via.placeholder.com/120x40" alt="Sekolah Dasar" class="h-full">
                    </div>
                    <div class="h-10 grayscale opacity-60 hover:grayscale-0 hover:opacity-100 transition duration-300">
                        <img src="https://via.placeholder.com/120x40" alt="Sekolah Dasar" class="h-full">
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="fitur" class="py-16 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16" data-aos="fade-up">
                    <span
                        class="inline-block bg-primary/10 text-primary px-4 py-1 rounded-full text-sm font-medium mb-4">Fitur
                        Unggulan</span>
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Apa yang Membuat Kami Berbeda?</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">Sinau CMS menyediakan solusi digital yang dirancang
                        khusus untuk kebutuhan sekolah dasar dengan teknologi terkini.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-xl shadow-sm card-hover" data-aos="fade-up"
                        data-aos-delay="100">
                        <div
                            class="bg-primary/10 text-primary w-14 h-14 rounded-xl flex items-center justify-center mb-6 feature-icon">
                            <i class="fas fa-bolt text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">Teknologi Modern</h3>
                        <p class="text-gray-600">Dibangun dengan Laravel dan Tailwind CSS untuk performa optimal dan
                            tampilan yang responsif di semua perangkat.</p>
                    </div>

                    <div class="bg-white p-8 rounded-xl shadow-sm card-hover" data-aos="fade-up"
                        data-aos-delay="200">
                        <div
                            class="bg-secondary/10 text-secondary w-14 h-14 rounded-xl flex items-center justify-center mb-6 feature-icon">
                            <i class="fas fa-qrcode text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">Verifikasi QR Code</h3>
                        <p class="text-gray-600">Fitur verifikasi dokumen dengan QR Code untuk memastikan keaslian data
                            siswa dan kemudahan validasi.</p>
                    </div>

                    <div class="bg-white p-8 rounded-xl shadow-sm card-hover" data-aos="fade-up"
                        data-aos-delay="300">
                        <div
                            class="bg-purple-500/10 text-purple-600 w-14 h-14 rounded-xl flex items-center justify-center mb-6 feature-icon">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">Multi Login</h3>
                        <p class="text-gray-600">Dukungan multi user dengan hak akses berbeda untuk admin, guru, dan
                            staf sekolah.</p>
                    </div>

                    <div class="bg-white p-8 rounded-xl shadow-sm card-hover" data-aos="fade-up"
                        data-aos-delay="100">
                        <div
                            class="bg-yellow-500/10 text-yellow-600 w-14 h-14 rounded-xl flex items-center justify-center mb-6 feature-icon">
                            <i class="fas fa-mobile-alt text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">Responsif Mobile</h3>
                        <p class="text-gray-600">Tampilan yang optimal baik di desktop, tablet, maupun smartphone untuk
                            akses di mana saja.</p>
                    </div>

                    <div class="bg-white p-8 rounded-xl shadow-sm card-hover" data-aos="fade-up"
                        data-aos-delay="200">
                        <div
                            class="bg-red-500/10 text-red-600 w-14 h-14 rounded-xl flex items-center justify-center mb-6 feature-icon">
                            <i class="fas fa-shield-alt text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">Keamanan Data</h3>
                        <p class="text-gray-600">Sistem keamanan berlapis untuk melindungi data sensitif sekolah dan
                            siswa.</p>
                    </div>

                    <div class="bg-white p-8 rounded-xl shadow-sm card-hover" data-aos="fade-up"
                        data-aos-delay="300">
                        <div
                            class="bg-green-500/10 text-green-600 w-14 h-14 rounded-xl flex items-center justify-center mb-6 feature-icon">
                            <i class="fas fa-headset text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">Dukungan 24/7</h3>
                        <p class="text-gray-600">Tim support siap membantu kapan saja Anda membutuhkan bantuan teknis.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="layanan" class="py-16 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16" data-aos="fade-up">
                    <span
                        class="inline-block bg-primary/10 text-primary px-4 py-1 rounded-full text-sm font-medium mb-4">Layanan
                        Kami</span>
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Solusi Digital untuk Sekolah Anda</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">Kami menyediakan layanan lengkap untuk transformasi
                        digital sekolah dasar Anda.</p>
                </div>

                <!-- Website Sekolah -->
                <div class="flex flex-col lg:flex-row items-center bg-gradient-to-r from-primary/5 to-purple-50 rounded-2xl overflow-hidden mb-12"
                    data-aos="fade-right">
                    <div class="lg:w-1/2 p-8 lg:p-12">
                        <span
                            class="inline-block bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-medium mb-4">Website
                            Sekolah</span>
                        <h3 class="text-2xl md:text-3xl font-bold mb-4">Website Profesional untuk Sekolah</h3>
                        <p class="text-gray-600 mb-6">Dibangun dengan Laravel dan Tailwind CSS, website sekolah yang
                            modern, cepat, dan mudah dikelola oleh staf sekolah.</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                            <div class="flex items-start">
                                <div class="bg-primary/10 text-primary p-2 rounded-lg mr-3">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span class="text-gray-700">Tampilan responsif</span>
                            </div>
                            <div class="flex items-start">
                                <div class="bg-primary/10 text-primary p-2 rounded-lg mr-3">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span class="text-gray-700">Sistem manajemen konten</span>
                            </div>
                            <div class="flex items-start">
                                <div class="bg-primary/10 text-primary p-2 rounded-lg mr-3">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span class="text-gray-700">Integrasi media sosial</span>
                            </div>
                            <div class="flex items-start">
                                <div class="bg-primary/10 text-primary p-2 rounded-lg mr-3">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span class="text-gray-700">Galeri foto & video</span>
                            </div>
                        </div>

                        <a href="#demo"
                            class="inline-flex items-center px-6 py-3 bg-primary text-white rounded-lg font-medium hover:bg-primary/90 transition-all duration-300 transform hover:-translate-y-1">
                            Pesan Sekarang <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                    <div class="lg:w-1/2 h-full">
                        <div class="relative h-full min-h-80">
                            <div class="absolute inset-0 bg-gradient-to-r from-primary to-purple-600 opacity-20"></div>
                            <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                                alt="Website Sekolah" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                <!-- SIESDE -->
                <div class="flex flex-col lg:flex-row-reverse items-center bg-gradient-to-l from-secondary/5 to-green-50 rounded-2xl overflow-hidden"
                    data-aos="fade-left">
                    <div class="lg:w-1/2 p-8 lg:p-12">
                        <span
                            class="inline-block bg-secondary/10 text-secondary px-3 py-1 rounded-full text-sm font-medium mb-4">SIESDE</span>
                        <h3 class="text-2xl md:text-3xl font-bold mb-4">Sistem Buku Induk Digital</h3>
                        <p class="text-gray-600 mb-6">Solusi digital untuk mengelola data siswa dengan fitur verifikasi
                            dokumen menggunakan QR Code dan multi user access.</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                            <div class="flex items-start">
                                <div class="bg-secondary/10 text-secondary p-2 rounded-lg mr-3">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span class="text-gray-700">Verifikasi QR Code</span>
                            </div>
                            <div class="flex items-start">
                                <div class="bg-secondary/10 text-secondary p-2 rounded-lg mr-3">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span class="text-gray-700">Multi level user</span>
                            </div>
                            <div class="flex items-start">
                                <div class="bg-secondary/10 text-secondary p-2 rounded-lg mr-3">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span class="text-gray-700">Pencarian cepat</span>
                            </div>
                            <div class="flex items-start">
                                <div class="bg-secondary/10 text-secondary p-2 rounded-lg mr-3">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span class="text-gray-700">Ekspor data laporan</span>
                            </div>
                        </div>

                        <a href="#demo"
                            class="inline-flex items-center px-6 py-3 bg-secondary text-white rounded-lg font-medium hover:bg-secondary/90 transition-all duration-300 transform hover:-translate-y-1">
                            Pesan Sekarang <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                    <div class="lg:w-1/2 h-full">
                        <div class="relative h-full min-h-80">
                            <div class="absolute inset-0 bg-gradient-to-l from-secondary to-green-500 opacity-20">
                            </div>
                            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                                alt="SIESDE" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SIESDE Focus Section -->
        <section id="siesde" class="py-16 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16" data-aos="fade-up">
                    <span
                        class="inline-block bg-secondary/10 text-secondary px-4 py-1 rounded-full text-sm font-medium mb-4">SIESDE</span>
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Sistem Informasi Elektronik Sekolah Dasar</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">Transformasi buku induk konvensional menjadi sistem
                        digital yang canggih.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <div class="space-y-8" data-aos="fade-right">
                        <div class="flex">
                            <div class="bg-secondary/10 text-secondary p-3 rounded-xl mr-4">
                                <i class="fas fa-qrcode text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold mb-2">Verifikasi Dokumen dengan QR Code</h3>
                                <p class="text-gray-600">Setiap dokumen siswa dilengkapi dengan QR Code unik untuk
                                    memverifikasi keaslian data dengan mudah menggunakan smartphone.</p>
                            </div>
                        </div>

                        <div class="flex">
                            <div class="bg-primary/10 text-primary p-3 rounded-xl mr-4">
                                <i class="fas fa-users-cog text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold mb-2">Multi Level User Access</h3>
                                <p class="text-gray-600">Hak akses berbeda untuk Kepala Sekolah, Admin, Guru, dan Staf
                                    sesuai dengan kebutuhan dan tanggung jawab masing-masing.</p>
                            </div>
                        </div>

                        <div class="flex">
                            <div class="bg-purple-500/10 text-purple-600 p-3 rounded-xl mr-4">
                                <i class="fas fa-search text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold mb-2">Pencarian Data Cepat</h3>
                                <p class="text-gray-600">Temukan data siswa dalam hitungan detik dengan sistem
                                    pencarian yang dioptimalkan untuk ribuan data.</p>
                            </div>
                        </div>
                    </div>

                    <div class="relative" data-aos="fade-left">
                        <div class="bg-white p-2 rounded-xl shadow-lg">
                            <img src="https://via.placeholder.com/600x400" alt="SIESDE Interface"
                                class="rounded-lg w-full">
                        </div>
                        <div
                            class="absolute -bottom-6 -right-6 bg-white p-4 rounded-xl shadow-lg border border-gray-100">
                            <div class="flex items-center">
                                <div class="bg-secondary p-3 rounded-lg mr-3">
                                    <i class="fas fa-mobile-alt text-white text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold">Akses Mobile</h4>
                                    <p class="text-gray-500 text-sm">Tersedia untuk smartphone</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing Section -->
        <section id="harga" class="py-16 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16" data-aos="fade-up">
                    <span
                        class="inline-block bg-primary/10 text-primary px-4 py-1 rounded-full text-sm font-medium mb-4">Harga</span>
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Paket Layanan Kami</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">Pilih paket yang sesuai dengan kebutuhan sekolah Anda.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                    <!-- Website Package -->
                    <div class="bg-white rounded-xl p-8 shadow-md border border-gray-100 hover:border-primary/30 transition-all duration-300 card-hover"
                        data-aos="fade-up" data-aos-delay="100">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="text-2xl font-bold mb-2">Website Sekolah</h3>
                                <p class="text-gray-600">Solusi website profesional</p>
                            </div>
                            <div class="bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-medium">Populer
                            </div>
                        </div>
                        <div class="text-4xl font-bold mb-6">Rp 5<span class="text-xl text-gray-500">.000.000</span>
                        </div>
                        <p class="text-gray-500 text-sm mb-6">Sekali bayar, termasuk domain & hosting 1 tahun</p>

                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center">
                                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Desain modern & responsif
                            </li>
                            <li class="flex items-center">
                                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Sistem manajemen konten
                            </li>
                            <li class="flex items-center">
                                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Galeri foto & video
                            </li>
                            <li class="flex items-center">
                                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Integrasi media sosial
                            </li>
                        </ul>
                        <a href="#contact"
                            class="block w-full bg-primary text-white text-center py-3 rounded-lg font-medium hover:bg-primary/90 transition-all duration-300 transform hover:-translate-y-1">Pesan
                            Sekarang</a>
                    </div>

                    <!-- SIESDE Package -->
                    <div class="bg-white rounded-xl p-8 shadow-md border border-gray-100 hover:border-secondary/30 transition-all duration-300 card-hover"
                        data-aos="fade-up" data-aos-delay="200">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="text-2xl font-bold mb-2">SIESDE</h3>
                                <p class="text-gray-600">Buku induk digital</p>
                            </div>
                            <div class="bg-secondary/10 text-secondary px-3 py-1 rounded-full text-sm font-medium">
                                Lengkap</div>
                        </div>
                        <div class="text-4xl font-bold mb-6">Rp 7<span class="text-xl text-gray-500">.500.000</span>
                        </div>
                        <p class="text-gray-500 text-sm mb-6">Sekali bayar, termasuk pelatihan</p>

                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center">
                                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Sistem buku induk digital
                            </li>
                            <li class="flex items-center">
                                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Verifikasi QR Code
                            </li>
                            <li class="flex items-center">
                                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Multi level user
                            </li>
                            <li class="flex items-center">
                                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Ekspor data laporan
                            </li>
                        </ul>
                        <a href="#contact"
                            class="block w-full bg-secondary text-white text-center py-3 rounded-lg font-medium hover:bg-secondary/90 transition-all duration-300 transform hover:-translate-y-1">Pesan
                            Sekarang</a>
                    </div>
                </div>

                <div class="text-center mt-12" data-aos="fade-up">
                    <p class="text-gray-600 mb-6">Butuh solusi khusus untuk sekolah Anda?</p>
                    <a href="#contact"
                        class="inline-flex items-center px-6 py-3 border-2 border-primary text-primary rounded-lg font-medium hover:bg-primary/5 transition-all duration-300">
                        <i class="fas fa-envelope mr-2"></i> Hubungi Kami
                    </a>
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section id="testimoni" class="py-16 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16" data-aos="fade-up">
                    <span
                        class="inline-block bg-primary/10 text-primary px-4 py-1 rounded-full text-sm font-medium mb-4">Testimoni</span>
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Apa Kata Klien Kami</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">Sekolah-sekolah yang telah menggunakan Sinau CMS.</p>
                </div>

                <div class="slider" data-aos="fade-up">
                    <div class="px-4">
                        <div class="bg-white p-8 rounded-xl shadow-sm">
                            <div class="flex items-center mb-4">
                                <div class="text-yellow-400 flex">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <p class="text-gray-600 mb-6">"Website sekolah kami menjadi lebih profesional dan mudah
                                dikelola setelah beralih ke Sinau CMS. Timnya sangat responsif dan membantu dalam setiap
                                tahap implementasi."</p>
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full bg-gray-300 mr-4 overflow-hidden">
                                    <img src="https://randomuser.me/api/portraits/women/46.jpg" alt="Testimonial"
                                        class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h4 class="font-semibold">Ibu Siti</h4>
                                    <p class="text-gray-500 text-sm">Kepala Sekolah SDN 01</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4">
                        <div class="bg-white p-8 rounded-xl shadow-sm">
                            <div class="flex items-center mb-4">
                                <div class="text-yellow-400 flex">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <p class="text-gray-600 mb-6">"SIESDE sangat membantu dalam mengelola data siswa. Fitur
                                verifikasi QR Code-nya memudahkan kami memvalidasi dokumen siswa dan mengurangi beban
                                administrasi."</p>
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full bg-gray-300 mr-4 overflow-hidden">
                                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Testimonial"
                                        class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h4 class="font-semibold">Bapak Agus</h4>
                                    <p class="text-gray-500 text-sm">Admin SD Muhammadiyah 05</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4">
                        <div class="bg-white p-8 rounded-xl shadow-sm">
                            <div class="flex items-center mb-4">
                                <div class="text-yellow-400 flex">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                            </div>
                            <p class="text-gray-600 mb-6">"Pelatihan yang diberikan sangat membantu staf kami yang
                                kurang melek teknologi. Sekarang kami bisa mengupdate website sekolah sendiri tanpa
                                kesulitan."</p>
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full bg-gray-300 mr-4 overflow-hidden">
                                    <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Testimonial"
                                        class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h4 class="font-semibold">Ibu Rina</h4>
                                    <p class="text-gray-500 text-sm">Guru SD Kristen 02</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4">
                        <div class="bg-white p-8 rounded-xl shadow-sm">
                            <div class="flex items-center mb-4">
                                <div class="text-yellow-400 flex">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <p class="text-gray-600 mb-6">"Dukungan teknis dari Sinau CMS sangat baik. Setiap ada
                                masalah, mereka merespons dengan cepat dan membantu menyelesaikannya."</p>
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full bg-gray-300 mr-4 overflow-hidden">
                                    <img src="https://randomuser.me/api/portraits/men/54.jpg" alt="Testimonial"
                                        class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h4 class="font-semibold">Bapak Budi</h4>
                                    <p class="text-gray-500 text-sm">Operator SD Islam Terpadu</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section id="demo" class="py-16 gradient-bg text-white">
            <div class="container mx-auto px-6 text-center">
                <div class="max-w-3xl mx-auto" data-aos="fade-up">
                    <h2 class="text-3xl md:text-4xl font-bold mb-6">Siap Transformasi Sekolah Anda?</h2>
                    <p class="text-xl mb-8 opacity-90">Jadwalkan demo gratis dan lihat bagaimana Sinau CMS dapat
                        membantu sekolah Anda menjadi lebih digital.</p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="#contact"
                            class="px-8 py-3 bg-white text-primary font-medium rounded-lg hover:shadow-lg hover:bg-white/95 transition-all duration-300 transform hover:-translate-y-1">
                            Jadwalkan Demo <i class="fas fa-calendar-alt ml-2"></i>
                        </a>
                        <a href="https://wa.me/6281234567890"
                            class="px-8 py-3 border-2 border-white text-white font-medium rounded-lg hover:bg-white/10 transition-all duration-300 transform hover:-translate-y-1">
                            <i class="fab fa-whatsapp mr-2"></i> Chat WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-16 bg-white">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div data-aos="fade-right">
                        <h2 class="text-3xl md:text-4xl font-bold mb-6">Hubungi Kami</h2>
                        <p class="text-gray-600 mb-8">Punya pertanyaan tentang produk kami? Tim support kami siap
                            membantu Anda.</p>

                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="bg-primary/10 text-primary p-3 rounded-lg mr-4">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold mb-1">Email</h4>
                                    <p class="text-gray-600">hello@sinaucms.id</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="bg-secondary/10 text-secondary p-3 rounded-lg mr-4">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold mb-1">Telepon</h4>
                                    <p class="text-gray-600">(021) 1234-5678</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="bg-purple-500/10 text-purple-600 p-3 rounded-lg mr-4">
                                    <i class="fab fa-whatsapp"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold mb-1">WhatsApp</h4>
                                    <p class="text-gray-600">0812-3456-7890</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="bg-yellow-500/10 text-yellow-600 p-3 rounded-lg mr-4">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold mb-1">Alamat</h4>
                                    <p class="text-gray-600">Jl. Pendidikan No. 123, Jakarta Selatan, Indonesia</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div data-aos="fade-left">
                        <div class="bg-gray-50 p-8 rounded-xl shadow-sm">
                            <h3 class="text-2xl font-bold mb-6">Kirim Pesan</h3>
                            <form>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <label for="name"
                                            class="block text-gray-700 font-medium mb-2">Nama</label>
                                        <input type="text" id="name"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                    <div>
                                        <label for="email"
                                            class="block text-gray-700 font-medium mb-2">Email</label>
                                        <input type="email" id="email"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                </div>
                                <div class="mb-6">
                                    <label for="subject" class="block text-gray-700 font-medium mb-2">Subjek</label>
                                    <input type="text" id="subject"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                                <div class="mb-6">
                                    <label for="message" class="block text-gray-700 font-medium mb-2">Pesan</label>
                                    <textarea id="message" rows="4"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                                </div>
                                <button type="submit"
                                    class="w-full bg-primary text-white py-3 rounded-lg font-medium hover:bg-primary/90 transition-all duration-300 transform hover:-translate-y-1">
                                    Kirim Pesan <i class="fas fa-paper-plane ml-2"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-dark text-white py-12">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <div class="flex items-center mb-6">
                            <div class="bg-primary p-2 rounded-lg mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div class="text-2xl font-bold text-white">Sinau<span class="text-secondary">CMS</span>
                            </div>
                        </div>
                        <p class="text-gray-400 mb-4">Platform digital untuk sekolah dasar dengan teknologi modern dan
                            fitur lengkap.</p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-white transition">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-semibold mb-4">Layanan</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-white transition">Website
                                    Sekolah</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition">SIESDE</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition">Pelatihan</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition">Dukungan
                                    Teknis</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-lg font-semibold mb-4">Perusahaan</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-white transition">Tentang Kami</a>
                            </li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition">Tim</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition">Karir</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition">Blog</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-lg font-semibold mb-4">Legal</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-white transition">Kebijakan
                                    Privasi</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition">Syarat &
                                    Ketentuan</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition">Kebijakan
                                    Cookie</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition">FAQ</a></li>
                        </ul>
                    </div>
                </div>

                <div
                    class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 mb-4 md:mb-0">© 2023 Sinau CMS. All rights reserved.</p>
                    <div class="flex space-x-6">
                        <a href="#" class="text-gray-400 hover:text-white transition">Terms</a>
                        <a href="#" class="text-gray-400 hover:text-white transition">Privacy</a>
                        <a href="#" class="text-gray-400 hover:text-white transition">Cookies</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Mobile menu toggle
        const hamburgerMenu = document.getElementById('hamburger-menu');
        const mobileMenu = document.getElementById('mobile-menu');
        const closeMenu = document.getElementById('close-menu');

        hamburgerMenu.addEventListener('click', function() {
            mobileMenu.classList.remove('translate-x-full');
            mobileMenu.classList.add('translate-x-0');
        });

        closeMenu.addEventListener('click', function() {
            mobileMenu.classList.remove('translate-x-0');
            mobileMenu.classList.add('translate-x-full');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('#mobile-menu') && !event.target.closest('#hamburger-menu')) {
                mobileMenu.classList.remove('translate-x-0');
                mobileMenu.classList.add('translate-x-full');
            }
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('shadow-lg');
                navbar.classList.add('py-2');
                navbar.classList.remove('py-3');
            } else {
                navbar.classList.remove('shadow-lg');
                navbar.classList.remove('py-2');
                navbar.classList.add('py-3');
            }
        });
    </script>
</body>

</html>
