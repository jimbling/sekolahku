@include('themes.' . getActiveTheme() . '.components.frontend.partials.header')

<body class="min-h-screen text-gray-900">
    <section class="content">
        <div class="container-fluid">

            {{-- Header Bar --}}
            <header class="bg-white shadow-md sticky top-0 z-10">


                <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">


                    {{-- Kiri: Judul & Status --}}
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('formulir.index') }}" class="text-gray-700 hover:text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                        </a>

                        <span class="text-lg font-semibold">Form Builder</span>

                        {{-- Indikator Status --}}
                        <span
                            class="text-sm px-2 py-1 rounded-full font-medium
        {{ $form->is_active ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $form->is_active ? 'Published' : 'Draft' }}
                        </span>
                    </div>


                    {{-- Kanan: Tombol Publikasi + Preview --}}
                    <div class="flex items-center space-x-3">


                        <!-- Tombol Kembali -->
                        <div class="relative group">
                            <a href="{{ url()->previous() }}"
                                class="inline-flex items-center px-2 py-1.5 text-sm font-medium text-gray-700 hover:text-indigo-600 rounded-lg transition border border-gray-300 hover:border-indigo-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 19.5L8.25 12l7.5-7.5" />
                                </svg>
                                <span class="ml-1">Kembali</span>
                            </a>
                            <div
                                class="absolute left-1/2 top-full mt-2 -translate-x-1/2 scale-0 group-hover:scale-100 transition-all duration-150
        bg-gray-800 text-white text-xs rounded py-1 px-2 whitespace-nowrap shadow-md z-50">
                                Kembali ke halaman sebelumnya
                                <div class="absolute w-2 h-2 bg-gray-800 rotate-45 -top-1 left-1/2 -translate-x-1/2">
                                </div>
                            </div>
                        </div>



                    </div>

            </header>

            <!-- Mount Vue Component Here -->
            <div id="analytics-app" data-form='@json($form)'
                data-endpoint="{{ route('formulir.analytics.json', $form->uuid) }}">
            </div>
        </div>
    </section>


    <script type="module" src="{{ asset('modules/Formulir/public/js/analisis.js') }}"></script>


</body>

</html>
