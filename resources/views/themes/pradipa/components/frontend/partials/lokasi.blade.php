<section class="bg-gradient-to-b from-[#03B5AA] via-[#ebf7f5] to-gray-50 py-8 ">

    <div class="container mx-auto px-4">
        <div class="flex justify-center">
            <div class="relative w-full max-w-6xl" data-aos="fade-up">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Kolom Kiri -->
                    <div class="md:col-span-1">
                        <div
                            class="card bg-white shadow-xl rounded-2xl p-6 transition-all duration-300 hover:shadow-2xl hover:ring-2 hover:ring-blue-100 hover:glow-blue">
                            <h2 class="text-2xl font-semibold mb-6 text-gray-800">Informasi Kontak</h2>

                            <div class="space-y-4">
                                <!-- Alamat -->
                                <div class="flex items-start gap-4 group">
                                    <div
                                        class="mt-1 p-2 rounded-full bg-blue-50 group-hover:bg-blue-100 transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-700">Alamat</h3>
                                        <p class="text-gray-600 hover:text-gray-800 transition-colors duration-200">
                                            {{ get_setting('sub_village') }}
                                            {{ get_setting('rt') }}/{{ get_setting('rw') }},<br>
                                            Kel: {{ get_setting('village') }}, Kec: {{ get_setting('sub_district') }},
                                            Kab: {{ get_setting('district') }}, <br>
                                            {{ get_setting('province') }} {{ get_setting('Negara') }}
                                            {{ get_setting('postal_code') }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Telepon -->
                                <div class="flex items-start gap-4 group">
                                    <div
                                        class="mt-1 p-2 rounded-full bg-blue-50 group-hover:bg-blue-100 transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-700">Telepon</h3>
                                        <a href="tel:0274513515"
                                            class="text-gray-600 hover:text-blue-600 transition-colors duration-200">
                                            {{ get_setting('phone') }}
                                        </a>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="flex items-start gap-4 group">
                                    <div
                                        class="mt-1 p-2 rounded-full bg-blue-50 group-hover:bg-blue-100 transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-700">Email</h3>
                                        <a href="mailto:{{ get_setting('email') }}"
                                            class="text-gray-600 hover:text-blue-600 transition-colors duration-200">
                                            {{ get_setting('email') }}
                                        </a>
                                    </div>
                                </div>


                            </div>

                            <!-- Tombol Lihat di Google Maps -->
                            <div class="mt-6 pt-4 border-t border-gray-100">
                                <div class="flex justify-center">
                                    <a href="https://www.google.com/maps?q={{ get_setting('map_lat') }},{{ get_setting('map_lng') }}"
                                        target="_blank"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 text-sm md:text-base font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 rounded-lg transition duration-200 shadow hover:shadow-md focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                        </svg>

                                        Lihat di Google Maps
                                    </a>
                                </div>
                            </div>



                        </div>

                    </div>


                    <!-- Card Google Maps (Kanan) -->
                    <div class="md:col-span-2">
                        <div class="card w-full h-[400px] bg-white shadow-xl rounded-2xl overflow-hidden transition-all duration-300 hover:shadow-2xl hover:ring-2 hover:ring-blue-100 hover:glow-blue"
                            id="mapid">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>


@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const lat = {{ get_setting('map_lat', -7.8248) }};
            const lng = {{ get_setting('map_lng', 110.1352) }};
            const schoolName = @json(get_setting('school_name', 'Lokasi Kami')); // aman untuk teks

            const map = L.map('mapid').setView([lat, lng], 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
            }).addTo(map);

            L.marker([lat, lng]).addTo(map)
                .bindPopup(schoolName)
                .openPopup();
        });
    </script>
@endpush
