@php
    $sliderPhotos = $sliders->take(4); // Ambil 4 foto pertama dari sliders
@endphp

<section
    class="relative bg-gradient-to-br from-teal-900 via-teal-800 to-teal-700 text-white overflow-hidden py-8 md:py-12"
    data-aos="fade-in">
    <!-- Background glow effects -->
    <div class="absolute -top-20 -left-20 w-72 h-72 bg-teal-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"
        data-aos="fade-in" data-aos-delay="200">
    </div>
    <div class="absolute -bottom-40 right-0 w-96 h-96 bg-emerald-400 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-4000"
        data-aos="fade-in" data-aos-delay="400">
    </div>

    <div class="container mx-auto px-4 flex flex-col md:flex-row items-start md:items-center gap-8 relative z-10">
        <!-- Left: Text Content -->
        <div class="md:w-1/2 space-y-6">
            <div class="bg-white/10 backdrop-blur-md text-sm px-4 py-2 rounded-full mb-4 inline-block shadow-lg border border-white/10 hover:bg-white/20 transition-all duration-300 transform hover:-translate-y-1 cursor-pointer"
                data-aos="fade-up" data-aos-delay="100" onclick="openUrgentModal()">
                <div class="flex items-center gap-2">
                    <span class="relative flex h-3 w-3">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                    </span>
                    @if (!empty($urgentInfo) && !empty($urgentInfo->title))
                        <span class="line-clamp-1">{{ $urgentInfo->title }}</span>
                    @else
                        <span class="italic text-gray-300">Tidak ada informasi penting saat ini.</span>
                    @endif
                </div>
            </div>


            <!-- Modal Container -->







            <h1 class="py-4 text-4xl md:text-5xl lg:text-6xl font-bold leading-tight" data-aos="fade-up"
                data-aos-delay="200">
                Selamat Datang di<br>
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-cyan-100 via-teal-300 to-emerald-100">
                    {{ get_setting('school_name') }}
                </span>
            </h1>

            <p class="text-lg md:text-xl text-white/90 max-w-lg mt-4" data-aos="fade-up" data-aos-delay="300">
                {{ get_setting('tagline') }}
            </p>

            <div class="flex flex-wrap gap-4" data-aos="fade-up" data-aos-delay="400">
                <a href="#"
                    class="group inline-flex items-center px-6 py-3 text-sm font-medium rounded-full bg-white text-teal-800 hover:bg-teal-100 transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-1">
                    <span>Visi & Misi</span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="ml-2 h-4 w-4 transform group-hover:translate-x-1 transition-transform" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
                <a href="#"
                    class="group inline-flex items-center px-6 py-3 text-sm font-medium rounded-full bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-1">
                    <span>Penerimaan Siswa Baru</span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="ml-2 h-4 w-4 transform group-hover:translate-x-1 transition-transform" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Right: Grid Foto dari Sliders -->
        <div class="grid grid-cols-2 gap-4 md:w-1/2 relative" data-aos="fade-left" data-aos-delay="500">
            @foreach ($sliderPhotos as $index => $slider)
                <div class="relative overflow-hidden rounded-2xl shadow-2xl group transition-all duration-500 hover:z-10 hover:scale-105"
                    data-aos="zoom-in" data-aos-delay="{{ 600 + $index * 100 }}">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent z-10"></div>
                    <img src="{{ Storage::url($slider->path) }}" alt="{{ $slider->caption }}"
                        class="w-full h-32 md:h-48 lg:h-56 object-cover object-center transition-all duration-700 group-hover:scale-110">
                    <div
                        class="absolute bottom-0 left-0 p-4 z-20 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <p class="text-white font-medium text-sm">{{ $slider->caption }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="container mx-auto mt-16 px-4 relative z-10" data-aos="fade-up" data-aos-delay="700">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach ($statistikSekolah as $index => $stat)
                <div class="bg-white/10 backdrop-blur-lg border border-white/10 rounded-2xl p-6 text-center shadow-xl hover:shadow-teal-500/10 hover:bg-white/20 transition-all duration-300 hover:-translate-y-2"
                    data-aos="fade-up" data-aos-delay="{{ 400 + $index * 100 }}">
                    <p
                        class="text-3xl md:text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-white to-emerald-200">
                        {{ $stat['value'] }}
                    </p>
                    <p class="text-sm text-white/80 mt-1">{{ $stat['label'] }}</p>
                    <div class="mt-3 h-1 bg-gradient-to-r from-teal-400 to-emerald-400 rounded-full"></div>
                </div>
            @endforeach
        </div>
    </div>


    <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none">
        <svg class="relative block w-full h-46 md:h-40" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"
            preserveAspectRatio="none">
            <path fill="#f9fafb" d="M0,160 C240,280 720,40 1440,160 L1440,320 L0,320 Z"></path>
        </svg>
    </div>




</section>
@push('modals')
    <div id="urgentModal"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm">
        <!-- Modal Content -->
        <div id="urgentModalContent"
            class="bg-white rounded-2xl shadow-xl w-full max-w-xl p-6 relative overflow-hidden transform transition-all duration-300 opacity-0 scale-95">

            <!-- Close Button -->
            <button onclick="closeUrgentModal()" class="absolute top-3 right-3 text-gray-400 hover:text-red-500 transition">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Title -->
            <h2 class="text-xl font-semibold text-red-700 mb-2">
                {{ $urgentInfo->title ?? 'Judul Tidak Tersedia' }}
            </h2>

            <!-- Message Content -->
            <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">
                {!! nl2br(e($urgentInfo->message ?? 'Tidak ada informasi penting saat ini.')) !!}
            </p>

            <!-- End Date Info -->
            @if (!empty($urgentInfo->end_date))
                <div class="mt-4 text-right text-sm text-gray-400 italic">
                    Berlaku sampai {{ \Carbon\Carbon::parse($urgentInfo->end_date)->translatedFormat('d F Y') }}
                </div>
            @endif
        </div>
    </div>
@endpush


@push('scripts')
    <script>
        function openUrgentModal() {
            const modal = document.getElementById('urgentModal');
            const content = document.getElementById('urgentModalContent');

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            setTimeout(() => {
                content.classList.remove('opacity-0', 'scale-95');
                content.classList.add('opacity-100', 'scale-100');
            }, 10);
        }

        function closeUrgentModal() {
            const modal = document.getElementById('urgentModal');
            const content = document.getElementById('urgentModalContent');

            content.classList.remove('opacity-100', 'scale-100');
            content.classList.add('opacity-0', 'scale-95');

            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 300);
        }

        // Optional: Click outside to close
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('urgentModal');
            const content = document.getElementById('urgentModalContent');
            if (e.target === modal) {
                closeUrgentModal();
            }
        });
    </script>
@endpush
