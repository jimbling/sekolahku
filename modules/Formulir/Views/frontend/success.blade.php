<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('storage/images/settings/' . get_setting('favicon')) }}" type="image/x-icon">
    <title>{{ $form->title }} - Submission Confirmation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        .confirmation-icon {
            width: 80px;
            height: 80px;
        }

        .glow-card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
        }

        .glow-card:hover {
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.2), 0 8px 10px -6px rgba(59, 130, 246, 0.1);
            transform: translateY(-2px);
        }

        .footer-link {
            transition: color 0.2s ease;
        }

        .footer-link:hover {
            color: #3b82f6;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col bg-gradient-to-br from-blue-50/20 to-white">
    <main class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8">
            <div class="text-center">
                <!-- Animated checkmark icon -->
                <div
                    class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-green-100/80 mb-6 animate__animated animate__bounceIn backdrop-blur-sm">
                    <svg class="confirmation-icon text-green-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Terima Kasih!</h1>
                <p class="text-lg text-gray-600 mb-6">Formulir Anda telah berhasil dikirim.</p>

                <div
                    class="glow-card bg-white p-6 rounded-xl border border-gray-100/60 text-left max-w-md mx-auto backdrop-blur-sm">
                    <div class="relative">
                        <h2 class="font-semibold text-gray-900 mb-1 text-lg">{{ $form->title }}</h2>
                        <p class="text-sm text-gray-500 flex items-center">
                            <svg class="w-4 h-4 mr-1.5 text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span>Dikirim pada: {{ $response->created_at->format('d F Y, H:i') }}</span>
                        </p>
                        <div
                            class="absolute -inset-2 rounded-xl bg-blue-50/40 -z-10 opacity-0 group-hover:opacity-100 blur-md transition-opacity duration-300">
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ get_setting('website') ?? '/' }}"
                        class="inline-flex items-center px-5 py-2.5 text-sm font-medium rounded-lg text-white bg-gradient-to-br from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-green-300 shadow-sm transition-all duration-200">
                        Website Sekolah
                        <svg class="ml-2 -mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </main>

    <footer class="py-6 border-t border-gray-100/60 mt-auto">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="mb-2">
                <a href="{{ get_setting('website') ?? '/' }}"
                    class="footer-link text-gray-700 font-medium hover:text-blue-600">
                    {{ get_setting('school_name') }}
                </a>
                <span class="text-gray-400 mx-2">•</span>
                <span class="text-gray-500">
                    {{ get_setting('sub_village') }}, {{ get_setting('village') }}, {{ get_setting('district') }}
                </span>
            </div>
            <p class="text-gray-500 text-sm">
                Dibuat dengan <span class="text-red-400">♥</span> oleh {{ config('app.name') }}
                <span class="text-gray-400 mx-2">•</span>
                © 2024-{{ date('Y') }} Hak Cipta Dilindungi
            </p>
        </div>
    </footer>
</body>

</html>
