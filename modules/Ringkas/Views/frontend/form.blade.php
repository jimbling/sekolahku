<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @hasSection('title')
            @yield('title') | {{ $schoolName }}
        @else
            {{ $judul }} | {{ $schoolName }} - {{ get_setting('sub_district') }} {{ get_setting('district') }}
        @endif
    </title>
    <link rel="icon" href="{{ asset('storage/images/settings/' . get_setting('favicon')) }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        secondary: {
                            500: '#8b5cf6',
                            600: '#7c3aed',
                        }
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #bae6fd 100%);
        }

        .card-hover {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .input-focus {
            transition: all 0.3s ease;
        }

        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.2);
        }

        .btn-hover {
            transition: all 0.3s ease;
        }

        .btn-hover:hover {
            transform: translateY(-1px);
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .wave {
            animation: wave 8s linear infinite;
        }

        @keyframes wave {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .floating {
            animation: floating 6s ease-in-out infinite;
        }

        @keyframes floating {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }
    </style>
</head>

<body class="gradient-bg min-h-screen">


    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-y-0 left-0 w-1/2 bg-primary-100"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4 animate__animated animate__fadeIn">
                    <span class="text-primary-600">Ringkasin</span> URL Panjang Anda
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto animate__animated animate__fadeIn animate__delay-1s">
                    Ubah tautan panjang menjadi pendek, mudah diingat, dan siap dibagikan dalam hitungan detik.
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Features Section -->
            <div class="md:col-span-1 space-y-6">
                <div class="bg-white rounded-xl shadow-sm p-6 card-hover">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 bg-primary-100 p-3 rounded-lg">
                            <i class="fas fa-link text-primary-600 text-xl"></i>
                        </div>
                        <h3 class="ml-3 text-lg font-medium text-gray-800">Apa itu Ringkas?</h3>
                    </div>
                    <p class="text-gray-600">
                        Ringkas adalah layanan pemendek URL yang memungkinkan Anda mengubah tautan panjang menjadi
                        pendek dan mudah dibagikan.
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 card-hover">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 bg-purple-100 p-3 rounded-lg">
                            <i class="fas fa-chart-line text-secondary-600 text-xl"></i>
                        </div>
                        <h3 class="ml-3 text-lg font-medium text-gray-800">Analitik Lanjutan</h3>
                    </div>
                    <p class="text-gray-600 mb-3">
                        Dengan login, Anda bisa melacak jumlah klik, lokasi pengunjung, dan data penting lainnya.
                    </p>
                    <a href="{{ url('/login') }}"
                        class="inline-flex items-center text-sm font-medium text-primary-600 hover:text-primary-700">
                        Login untuk mengelola <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>


            </div>

            <!-- Form Section -->
            <div class="md:col-span-2">
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-6 sm:p-8">
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">Buat Link Ringkas</h2>
                            <p class="text-gray-600">Isi form berikut untuk memendekkan URL Anda</p>
                        </div>

                        <!-- Success Message -->
                        <div id="success-message"
                            class="hidden bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 transition-all duration-300 animate__animated animate__fadeIn">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                <span id="success-text"></span>
                                <button id="copy-btn"
                                    class="ml-auto text-sm bg-green-100 hover:bg-green-200 px-3 py-1 rounded-md btn-hover">
                                    <i class="fas fa-copy mr-1"></i> Salin
                                </button>
                            </div>
                            <div class="mt-2 flex items-center text-sm" id="short-url-container">
                                <a id="short-url" href="#" target="_blank"
                                    class="text-green-600 hover:underline font-medium"></a>
                                <span id="copy-success" class="ml-2 text-green-600 hidden text-xs">
                                    <i class="fas fa-check mr-1"></i>Tersalin!
                                </span>
                            </div>
                        </div>

                        <!-- Error Message -->
                        <div id="error-message"
                            class="hidden bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 transition-all duration-300 animate__animated animate__fadeIn">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <span id="error-text"></span>
                            </div>
                        </div>

                        <form id="shorten-form" class="space-y-5">
                            <!-- Original URL -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">URL Asli <span
                                        class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-link text-gray-400"></i>
                                    </div>
                                    <input type="url" id="original_url" name="original_url"
                                        class="input-focus w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                                        placeholder="https://contoh.com/artikel/panjang-sekali" required>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 hidden"
                                        id="url-loading">
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </div>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Masukkan URL lengkap dengan https://</p>
                                <p class="text-red-500 text-sm mt-1 hidden" id="original_url_error"></p>
                            </div>

                            <!-- Custom Slug -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Custom Url
                                    (Opsional)</label>
                                <div class="flex">

                                    <input type="text" id="slug" name="slug"
                                        class="input-focus flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500"
                                        placeholder="contoh-link" pattern="[a-zA-Z0-9\-]+"
                                        title="Hanya huruf, angka, dan tanda hubung (-) diperbolehkan">
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Hanya huruf, angka, dan tanda hubung (-)</p>
                                <p class="text-red-500 text-sm mt-1 hidden" id="slug_error"></p>
                            </div>

                            <!-- Description -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi
                                    (Opsional)</label>
                                <textarea id="description" name="description" rows="2"
                                    class="input-focus w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                                    placeholder="Deskripsi singkat tentang link ini"></textarea>
                                <p class="text-red-500 text-sm mt-1 hidden" id="description_error"></p>
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-2">
                                <button type="submit" id="submit-btn"
                                    class="btn-hover  w-full bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white font-medium py-3 px-4 rounded-lg transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 flex items-center justify-center shadow-md">
                                    <span id="btn-text">Buat Link Ringkas</span>
                                    <span id="btn-loading" class="hidden ml-2">
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Footer -->
    <footer class="bg-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex justify-center md:order-2 space-x-6">
                    <a href="#" class="text-gray-400 hover:text-gray-500">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-gray-500">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-gray-500">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
                <div class="mt-8 md:mt-0 md:order-1">
                    <p class="text-center text-base text-gray-400">
                        &copy; 2023 Pendekin.link. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('shorten-form');
            const submitBtn = document.getElementById('submit-btn');
            const btnText = document.getElementById('btn-text');
            const btnLoading = document.getElementById('btn-loading');
            const successMessage = document.getElementById('success-message');
            const successText = document.getElementById('success-text');
            const errorMessage = document.getElementById('error-message');
            const errorText = document.getElementById('error-text');
            const originalUrlInput = document.getElementById('original_url');

            // Jika ada pesan sukses dari server (redirect dengan session)
            @if (session('success'))
                showSuccessMessage("{{ session('success') }}", "{{ session('short_url') }}");
            @endif

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Reset state
                submitBtn.disabled = true;
                btnText.textContent = 'Memproses...';
                btnLoading.classList.remove('hidden');
                successMessage.classList.add('hidden');
                errorMessage.classList.add('hidden');
                clearFieldErrors();

                const formData = new FormData(form);

                fetch("{{ url('/ringkas/form/buat') }}", {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: formData
                    })
                    .then(async response => {
                        if (!response.ok) {
                            // Deteksi 429
                            if (response.status === 429) {
                                throw {
                                    status: 429,
                                    message: 'Terlalu banyak permintaan. Coba beberapa saat lagi.'
                                };
                            }

                            // Coba ambil error dari JSON jika tersedia
                            let errorJson;
                            try {
                                errorJson = await response.json();
                            } catch {
                                throw {
                                    status: response.status,
                                    message: 'Terjadi kesalahan tidak terduga.'
                                };
                            }

                            throw errorJson;
                        }

                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            showSuccessMessage(data.message, data.short_url);
                            form.reset();

                            successMessage.classList.add('animate__tada');
                            setTimeout(() => {
                                successMessage.classList.remove('animate__tada');
                            }, 1000);
                        } else {
                            showError(data.message);
                            if (data.errors) {
                                for (const [field, message] of Object.entries(data.errors)) {
                                    const errorElement = document.getElementById(`${field}_error`);
                                    if (errorElement) {
                                        errorElement.textContent = message;
                                        errorElement.classList.remove('hidden');
                                    }
                                }
                            }
                        }
                    })
                    .catch(error => {
                        let message = 'Terjadi kesalahan. Silakan coba lagi.';

                        if (error?.status === 429) {
                            message = error.message;
                        } else if (error?.message) {
                            message = error.message;
                        }

                        showError(message);
                        console.error('Error:', error);
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        btnText.textContent = 'Buat Link Ringkas';
                        btnLoading.classList.add('hidden');
                        submitBtn.classList.remove('animate__animated', 'animate__pulse');
                    });
            });


            // Validasi URL saat keluar dari input
            originalUrlInput.addEventListener('blur', function() {
                const url = this.value.trim();
                const errorElement = document.getElementById('original_url_error');
                if (url && !isValidUrl(url)) {
                    errorElement.textContent = 'Masukkan URL yang valid (contoh: https://example.com)';
                    errorElement.classList.remove('hidden');
                } else {
                    errorElement.classList.add('hidden');
                }
            });

            // Klik tombol salin
            const copyBtn = document.getElementById('copy-btn');
            copyBtn?.addEventListener('click', function() {
                const shortUrl = document.getElementById('short-url');
                const url = shortUrl?.textContent || '';
                if (!url) return;

                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(url).then(() => {
                        const copySuccess = document.getElementById('copy-success');
                        copySuccess.classList.remove('hidden');
                        copySuccess.classList.add('animate__animated', 'animate__fadeIn');
                        setTimeout(() => {
                            copySuccess.classList.add('hidden');
                            copySuccess.classList.remove('animate__animated',
                                'animate__fadeIn');
                        }, 2000);
                    }).catch(err => {
                        console.error('Gagal menyalin:', err);
                        alert('Tidak dapat menyalin. Silakan salin manual.');
                    });
                } else {
                    // Fallback: salin manual menggunakan input temporer
                    const textarea = document.createElement('textarea');
                    textarea.value = url;
                    document.body.appendChild(textarea);
                    textarea.select();
                    try {
                        document.execCommand('copy');
                        const copySuccess = document.getElementById('copy-success');
                        copySuccess.classList.remove('hidden');
                        copySuccess.classList.add('animate__animated', 'animate__fadeIn');
                        setTimeout(() => {
                            copySuccess.classList.add('hidden');
                            copySuccess.classList.remove('animate__animated', 'animate__fadeIn');
                        }, 2000);
                    } catch (err) {
                        alert('Browser tidak mendukung salin otomatis. Silakan salin manual.');
                    }
                    document.body.removeChild(textarea);
                }
            });

            // Menampilkan pesan sukses
            function showSuccessMessage(message, url) {
                const shortUrl = document.getElementById('short-url');
                successText.textContent = message;
                shortUrl.textContent = url;
                shortUrl.href = url;
                successMessage.classList.remove('hidden');
                successMessage.classList.add('animate__animated', 'animate__fadeIn');
                successMessage.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            }

            // Menampilkan pesan error
            function showError(message) {
                errorText.textContent = message;
                errorMessage.classList.remove('hidden');
                errorMessage.classList.add('animate__animated', 'animate__fadeIn');
                errorMessage.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            }

            // Hapus error field sebelumnya
            function clearFieldErrors() {
                const fields = ['original_url', 'slug', 'description'];
                fields.forEach(field => {
                    const errorElement = document.getElementById(`${field}_error`);
                    if (errorElement) {
                        errorElement.classList.add('hidden');
                        errorElement.textContent = '';
                    }
                });
            }

            // Validasi URL menggunakan try-catch URL
            function isValidUrl(string) {
                try {
                    new URL(string);
                    return true;
                } catch (_) {
                    return false;
                }
            }
        });
    </script>
</body>

</html>
