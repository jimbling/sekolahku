@extends('themes.' . getActiveTheme() . '.app_statis')

@section('title', 'Visi, Misi & Tujuan Sekolah')

@section('hero')
    <div class="relative bg-slate-900 text-white overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-gray-900 to-teal-900 opacity-90"></div>
        <div class="absolute inset-0 bg-[url('/path/to/your/subtle-dots-pattern.svg')] opacity-5"></div>

        <div class="container mx-auto px-6 py-20 md:py-28 relative z-10">
            <div class="max-w-4xl mx-auto text-center" data-aos="fade-up" data-aos-duration="800">

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight mb-4">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-white to-teal-300">
                        @yield('title')
                    </span>
                </h1>

                <p class="text-lg md:text-xl text-slate-300 max-w-3xl mx-auto">
                    {{ get_page_subtitle(View::getSections()['title'] ?? 'Membentuk Masa Depan Gemilang Melalui Pendidikan Berkualitas') }}
                </p>

                <div class="mt-12 group" role="button"
                    onclick="document.getElementById('content-start').scrollIntoView({ behavior: 'smooth' });">
                    <div class="flex flex-col items-center justify-center animate-bounce">
                        <span class="text-sm mb-2 opacity-70">Lihat Detail</span>
                        <svg class="h-6 w-6 text-teal-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')

    <div id="content-start" class="bg-gray-50 py-16 sm:py-24 rounded-xl shadow-lg">
        <div class="container mx-auto max-w-4xl px-4">

            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Landasan & Arah Tujuan Sekolah</h2>
                <p class="mt-4 text-lg text-gray-600">Komitmen kami dalam menciptakan lingkungan belajar yang inspiratif,
                    berkarakter, dan berprestasi tertuang dalam visi, misi, dan tujuan sekolah.</p>
            </div>

            <div x-data="{ open: 'visi' }" class="space-y-4" data-aos="fade-up" data-aos-delay="200">

                <div class="bg-white rounded-xl shadow-lg transition-all duration-300 hover:shadow-2xl overflow-hidden">
                    <button @click="open = open === 'visi' ? '' : 'visi'"
                        class="w-full flex justify-between items-center p-6 text-left">
                        <div class="flex items-center">
                            <div
                                class="flex-shrink-0 h-12 w-12 rounded-full bg-teal-100 flex items-center justify-center mr-5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                                </svg>

                            </div>
                            <h3 class="text-2xl font-semibold text-gray-800">VISI</h3>
                        </div>
                        <svg x-bind:class="{ 'rotate-180': open === 'visi' }"
                            class="w-6 h-6 text-gray-500 transform transition-transform duration-300"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 'visi'" x-collapse class="px-6 pb-6 pt-0">
                        <p class="text-lg font-medium text-teal-800 italic bg-teal-50 p-4 rounded-lg mb-6">"Beriman,
                            kreatif, berprestasi, berkarakter, dan berbudaya"</p>
                        <h4 class="text-lg font-semibold text-gray-700 mb-3">Indikator Ketercapaian:</h4>
                        <ul class="space-y-3 pl-2">
                            @foreach (['Beriman dan bertakwa kepada Tuhan Yang Maha Esa', 'Kreatif dalam memelihara dan memanfaatkan lingkungan', 'Berprestasi dalam bidang akademik dan nonakademik', 'Memiliki kepribadian yang luhur', 'Berperilaku sesuai nilai-nilai luhur budaya Yogyakarta'] as $indikator)
                                <li class="flex items-start">
                                    <svg class="h-5 w-5 text-teal-500 mt-1 mr-3 flex-shrink-0" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-gray-600">{{ $indikator }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg transition-all duration-300 hover:shadow-2xl overflow-hidden">
                    <button @click="open = open === 'misi' ? '' : 'misi'"
                        class="w-full flex justify-between items-center p-6 text-left">
                        <div class="flex items-center">
                            <div
                                class="flex-shrink-0 h-12 w-12 rounded-full bg-sky-100 flex items-center justify-center mr-5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                </svg>

                            </div>
                            <h3 class="text-2xl font-semibold text-gray-800">MISI</h3>
                        </div>
                        <svg x-bind:class="{ 'rotate-180': open === 'misi' }"
                            class="w-6 h-6 text-gray-500 transform transition-transform duration-300"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 'misi'" x-collapse class="px-6 pb-6 pt-0">
                        <ol class="space-y-4">
                            @php
                                $misi = [
                                    'Menumbuhkembangkan penghayatan dan pengamalan ajaran agama',
                                    'Melaksanakan pembelajaran yang berorientasi pada keterampilan abad 21',
                                    'Melaksanakan pembinaan intensif untuk mencapai prestasi akademik dan non akademik',
                                    'Menumbuhkembangkan keterampilan memanfaatkan Teknologi Informasi dan Komunikasi',
                                    'Menumbuhkembangkan rasa cinta seni dan keterampilan',
                                    'Membudayakan lima nilai utama karakter',
                                    'Mengembangkan pembelajaran berwawasan lingkungan hidup dan berbasis budaya',
                                    'Mengembangkan pembelajaran untuk membentuk Profil Pelajar Pancasila',
                                ];
                            @endphp
                            @foreach ($misi as $index => $item)
                                <li class="flex items-start">
                                    <span
                                        class="flex-shrink-0 h-8 w-8 rounded-full bg-sky-600 text-white flex items-center justify-center font-bold text-sm mr-4">{{ $index + 1 }}</span>
                                    <p class="text-gray-600 pt-1">{{ $item }}</p>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg transition-all duration-300 hover:shadow-2xl overflow-hidden">
                    <button @click="open = open === 'tujuan' ? '' : 'tujuan'"
                        class="w-full flex justify-between items-center p-6 text-left">
                        <div class="flex items-center">
                            <div
                                class="flex-shrink-0 h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center mr-5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
                                </svg>

                            </div>
                            <h3 class="text-2xl font-semibold text-gray-800">TUJUAN SEKOLAH</h3>
                        </div>
                        <svg x-bind:class="{ 'rotate-180': open === 'tujuan' }"
                            class="w-6 h-6 text-gray-500 transform transition-transform duration-300"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 'tujuan'" x-collapse class="px-6 pb-6 pt-0">
                        <h4 class="text-lg font-semibold text-gray-700 mb-4">Tujuan Jangka Panjang (4 Tahun):</h4>
                        <div class="space-y-4">
                            @php
                                $tujuan = [
                                    'Meningkatnya lulusan yang khatam Alqur\'an dan hafal surat-surat pendek Alqur\'an',
                                    'Meningkatnya lulusan yang dapat memahami tata cara sholat dan melaksanakan shalat wajib',
                                    'Meningkatnya nilai rata-rata ujian dan kompetensi literasi numerasi',
                                    'Terwujudnya prestasi akademik dan nonakademik di tingkat kecamatan dan kabupaten',
                                    'Meningkatnya keterampilan di bidang teknologi informasi, komunikasi, seni dan life skill',
                                    'Tumbuhnya nilai-nilai karakter dan terwujudnya lingkungan sekolah yang nyaman dengan konsep 7K',
                                ];
                            @endphp
                            @foreach ($tujuan as $item)
                                <div class="flex items-start p-4 bg-gray-50 rounded-lg">
                                    <svg class="h-6 w-6 text-indigo-500 mr-4 mt-1 flex-shrink-0"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <p class="text-gray-600">{{ $item }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>



        </div>
    </div>
@endsection
