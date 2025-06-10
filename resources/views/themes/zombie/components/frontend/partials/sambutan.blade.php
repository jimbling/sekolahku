@php
    use Illuminate\Support\Str;
@endphp

<div class="relative mx-auto px-4 py-12 overflow-hidden bg-gradient-to-br from-gray-50 to-white">
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
                <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-5 shadow-sm" data-aos="fade-left"
                    data-aos-delay="100" data-aos-anchor=".lg\:col-span-2">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-red-800">Informasi Penting</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <p>Pendaftaran siswa baru tahun ajaran 2023/2024 dibuka mulai 1 Januari 2023.</p>
                            </div>
                            <div class="mt-3">
                                <a href="#" class="text-sm font-medium text-red-600 hover:text-red-500">
                                    Selengkapnya <span aria-hidden="true">&rarr;</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Latest Announcements --}}
                <div class="bg-white rounded-xl shadow-md overflow-hidden" data-aos="fade-up" data-aos-delay="200"
                    data-aos-anchor=".lg\:col-span-2">
                    <div class="bg-gradient-to-r from-blue-600 to-teal-500 px-5 py-3">
                        <h3 class="text-lg font-semibold text-white">Pengumuman Terkini</h3>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @foreach ([1, 2, 3] as $index => $announcement)
                            <div class="p-4 hover:bg-gray-50 transition duration-150" data-aos="fade-up"
                                data-aos-delay="{{ 300 + $index * 50 }}" data-aos-anchor=".lg\:col-span-2">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">Libur Semester Ganjil</h4>
                                        <p class="text-xs text-gray-500 mt-1">18 Desember 2022 - 2 Januari 2023</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="bg-gray-50 px-4 py-3 text-right">
                        <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                            Lihat semua pengumuman
                        </a>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div class="bg-white rounded-xl shadow-md overflow-hidden" data-aos="fade-up" data-aos-delay="500"
                    data-aos-anchor=".lg\:col-span-2">
                    <div class="bg-gradient-to-r from-blue-600 to-teal-500 px-5 py-3">
                        <h3 class="text-lg font-semibold text-white">Akses Cepat</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-2 p-4">
                        @foreach ([['icon' => 'blue', 'text' => 'PPDB', 'color' => 'blue'], ['icon' => 'teal', 'text' => 'E-Learning', 'color' => 'teal'], ['icon' => 'purple', 'text' => 'Kalender', 'color' => 'purple'], ['icon' => 'amber', 'text' => 'Beasiswa', 'color' => 'amber']] as $index => $link)
                            <a href="#"
                                class="flex items-center justify-center p-3 bg-{{ $link['color'] }}-50 rounded-lg hover:bg-{{ $link['color'] }}-100 transition duration-150"
                                data-aos="zoom-in" data-aos-delay="{{ 550 + $index * 100 }}"
                                data-aos-anchor=".lg\:col-span-2">
                                <svg class="h-5 w-5 text-{{ $link['color'] }}-600 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    @if ($link['icon'] == 'blue')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    @elseif($link['icon'] == 'teal')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    @elseif($link['icon'] == 'purple')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    @endif
                                </svg>
                                <span class="text-sm font-medium">{{ $link['text'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
