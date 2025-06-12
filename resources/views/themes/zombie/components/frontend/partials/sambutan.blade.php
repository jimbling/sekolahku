@php
    use Illuminate\Support\Str;
@endphp

<div class="relative mx-auto px-4 py-12 overflow-hidden ">
    <div class="max-w-7xl mx-auto">
        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Headmaster Welcome --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg overflow-hidden" data-aos="fade-right">
                <div class="p-6 md:p-8">
                    <div class="text-center mb-6">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-800">
                            <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-teal-500">
                                Sambutan Kepala Sekolah
                            </span>
                        </h2>
                        <div class="w-24 h-1 bg-gradient-to-r from-blue-400 to-teal-300 mx-auto mt-3 rounded-full"></div>
                    </div>

                    <div class="flex flex-col md:flex-row gap-6 items-center">
                        <div class="w-full md:w-1/3 flex-shrink-0">
                            <img src="{{ asset('storage/images/settings/' . get_setting('headmaster_photo')) }}"
                                alt="Foto Kepala Sekolah" loading="lazy"
                                class="w-full h-auto rounded-xl shadow-md object-cover border-4 border-white transform hover:scale-105 transition duration-300" />
                        </div>

                        <div class="w-full md:w-2/3">
                            <div class="prose prose-blue max-w-none text-gray-700">
                                {!! Str::limit($sambutan->content, 800, '...') !!}
                            </div>
                            <div class="mt-6 border-t pt-4">
                                <h3 class="text-xl font-bold text-gray-800">{{ get_setting('headmaster') }}</h3>
                                <p class="text-sm text-gray-500">Kepala Sekolah</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Urgent Info Sidebar --}}
            <div class="space-y-6">
                {{-- Urgent Announcement --}}
                @if (!empty($urgentInfo))
                    <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-5 shadow-sm" data-aos="fade-left"
                        data-aos-delay="100" data-aos-anchor=".lg\:col-span-2">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-red-800">{{ $urgentInfo->title ?? 'No Title' }}</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <p>{!! nl2br(e($urgentInfo->message ?? '')) !!}</p>
                                </div>
                                <div class="mt-3">
                                    @if (!empty($urgentInfo))
                                        <button onclick="openUrgentModal()"
                                            class="text-sm font-medium text-red-600 hover:text-red-500">
                                            Selengkapnya <span aria-hidden="true">&rarr;</span>
                                        </button>
                                        <div>
                                            <span class="text-xs text-red-400 italic">
                                                Berlaku sampai
                                                {{ \Carbon\Carbon::parse($urgentInfo->end_date)->translatedFormat('d M Y') }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-blue-50 border-l-4 border-blue-400 rounded-lg p-5 shadow-sm" data-aos="fade-left"
                        data-aos-delay="100" data-aos-anchor=".lg\:col-span-2">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-blue-800">Tidak Ada Informasi Penting</h3>
                                <div class="mt-2 text-sm text-blue-700">

                                </div>
                                @if ($lastUrgentStartDate)
                                    <div class="mt-3 text-xs text-gray-500 italic">
                                        Terakhir diperbarui:
                                        {{ \Carbon\Carbon::parse($lastUrgentStartDate)->translatedFormat('d F Y') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
                @if (!empty($urgentInfo))
                    <div id="urgentModal"
                        class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm">
                        <div id="urgentModalContent"
                            class="bg-white rounded-2xl shadow-xl w-full max-w-xl p-6 relative overflow-hidden transform transition-all duration-300 opacity-0 scale-95">

                            <button onclick="closeUrgentModal()"
                                class="absolute top-3 right-3 text-gray-400 hover:text-red-500 transition">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            <h2 class="text-xl font-semibold text-red-700 mb-2">
                                {{ $urgentInfo->title ?? 'Judul Tidak Tersedia' }}</h2>
                            <p class="text-sm text-gray-700 leading-relaxed">
                                {!! nl2br(e($urgentInfo->message ?? '')) !!}
                            </p>

                            @if (!empty($urgentInfo->end_date))
                                <div class="mt-4 text-right text-sm text-gray-400 italic">
                                    Berlaku sampai
                                    {{ \Carbon\Carbon::parse($urgentInfo->end_date)->translatedFormat('d F Y') }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                @push('scripts')
                    @if (!empty($urgentInfo))
                        <script>
                            function openUrgentModal() {
                                const modal = document.getElementById('urgentModal');
                                const modalContent = document.getElementById('urgentModalContent');

                                modal.classList.remove('hidden');
                                modal.classList.add('flex');

                                setTimeout(() => {
                                    modalContent.classList.remove('opacity-0', 'scale-95');
                                    modalContent.classList.add('opacity-100', 'scale-100');
                                }, 10);
                            }

                            function closeUrgentModal() {
                                const modal = document.getElementById('urgentModal');
                                const modalContent = document.getElementById('urgentModalContent');

                                modalContent.classList.remove('opacity-100', 'scale-100');
                                modalContent.classList.add('opacity-0', 'scale-95');

                                setTimeout(() => {
                                    modal.classList.remove('flex');
                                    modal.classList.add('hidden');
                                }, 300);
                            }

                            window.addEventListener('click', function(e) {
                                const modal = document.getElementById('urgentModal');
                                const content = document.getElementById('urgentModalContent');
                                if (e.target === modal) {
                                    closeUrgentModal();
                                }
                            });
                        </script>
                    @endif
                @endpush



                {{-- Latest Announcements --}}
                <div class="bg-white rounded-xl shadow-md overflow-hidden" data-aos="fade-up" data-aos-delay="200"
                    data-aos-anchor=".lg\:col-span-2">
                    <div class="bg-gradient-to-r from-blue-600 to-teal-500 px-5 py-3">
                        <h3 class="text-lg font-semibold text-white">Pengumuman Terkini</h3>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @if ($announcements->isNotEmpty())
                            @foreach ($announcements as $index => $announcement)
                                <div class="p-4 hover:bg-gray-50 transition duration-150" data-aos="fade-up"
                                    data-aos-delay="{{ 300 + $index * 50 }}" data-aos-anchor=".lg\:col-span-2">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
                                            </svg>

                                        </div>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">{{ $announcement->title }}
                                            </h4>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ \Carbon\Carbon::parse($announcement->publish_date)->translatedFormat('d F Y') }}
                                                -
                                                {{ \Carbon\Carbon::parse($announcement->expired_at)->translatedFormat('d F Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="p-4 text-center text-sm text-gray-500">
                                Tidak ada pengumuman aktif saat ini.
                            </div>
                        @endif

                    </div>
                    <div class="bg-gray-50 px-4 py-3 text-right">
                        <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                            Lihat semua pengumuman
                        </a>
                    </div>
                </div>

                {{-- Quick Links --}}
                @if ($quickLinks->count())
                    <div class="bg-white rounded-xl shadow-md overflow-hidden" data-aos="fade-up"
                        data-aos-delay="500" data-aos-anchor=".lg\:col-span-2">

                        <div class="bg-gradient-to-r from-blue-600 to-teal-500 px-5 py-3">
                            <h3 class="text-lg font-semibold text-white">Akses Cepat</h3>
                        </div>

                        <div class="grid grid-cols-2 gap-2 p-4">
                            @foreach ($quickLinks as $index => $link)
                                <a href="{{ $link->url }}"
                                    class="flex items-center justify-center p-3 rounded-lg transition-all duration-300 transform hover:-translate-y-1 hover:shadow-md group
                    bg-{{ $link->color }}-50 hover:bg-{{ $link->color }}-100"
                                    data-aos="zoom-in" data-aos-delay="{{ 550 + $index * 100 }}"
                                    data-aos-anchor=".lg\:col-span-2">

                                    {{-- SVG Icon --}}
                                    <span
                                        class="h-6 w-6 text-{{ $link->color }}-600 mr-2 transition-transform duration-300 ease-in-out group-hover:scale-110">
                                        {!! $link->icon !!}
                                    </span>

                                    {{-- Label --}}
                                    <span
                                        class="text-sm font-medium text-gray-700 transition-colors duration-300 group-hover:text-{{ $link->color }}-700">
                                        {{ $link->label }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif



            </div>
        </div>
    </div>
</div>
