<section class="py-16">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-32 relative">
            <div class="absolute -top-6 -left-6 w-32 h-32 bg-teal-100 rounded-full blur-3xl opacity-30 animate-pulse">
            </div>
            <div
                class="absolute -bottom-6 -right-6 w-32 h-32 bg-blue-100 rounded-full blur-3xl opacity-30 animate-pulse delay-1000">
            </div>

            <h2 class="text-4xl md:text-5xl font-bold relative z-10 text-teal-800" data-aos="fade-up">
                Sambutan Kepala Sekolah
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-teal-400 to-blue-500 mx-auto mt-4 rounded-full" data-aos="fade-up"
                data-aos-delay="100"></div>
        </div>

        <!-- Card Sambutan -->
        <div class="flex justify-center" data-aos="fade-up" data-aos-delay="200">
            <div
                class="relative group bg-white rounded-3xl shadow-xl px-8 sm:px-10 md:px-14 pt-28 pb-20 text-center max-w-5xl w-full border-2 border-teal-400 transition-transform duration-300 hover:scale-[1.015] hover:shadow-teal-200">

                <!-- Glow Hover Dekorasi -->
                <div
                    class="absolute inset-0 rounded-3xl bg-teal-100 opacity-0 group-hover:opacity-20 blur-2xl transition duration-300 z-0">
                </div>

                <!-- Foto Kepala Sekolah -->
                <div class="absolute -top-24 left-1/2 transform -translate-x-1/2 z-20 group">
                    <div
                        class="relative w-48 h-48 sm:w-52 sm:h-52 rounded-full border-8 border-white shadow-2xl overflow-hidden bg-white group-hover:scale-105 transition duration-300">
                        <!-- Glow di belakang foto -->
                        <div
                            class="absolute inset-0 bg-teal-300 opacity-0 group-hover:opacity-30 blur-xl transition duration-300 scale-110 z-0">
                        </div>
                        <img src="{{ asset('storage/images/settings/' . get_setting('headmaster_photo')) }}"
                            alt="Foto Kepala Sekolah"
                            class="w-full h-full object-cover object-center relative z-10 rounded-full">
                    </div>
                </div>

                <!-- Isi Sambutan -->
                <div class="relative z-10">
                    <!-- Kutipan SVG besar di kanan bawah -->
                    <div
                        class="absolute -bottom-10 right-0 text-[8rem] leading-none text-teal-100 font-serif opacity-20 select-none pointer-events-none">
                        &rdquo;
                    </div>

                    <div
                        class="prose max-w-none text-left text-gray-700 mx-auto prose-lg lg:prose-xl leading-relaxed mb-20">
                        {!! $sambutan->content !!}
                    </div>
                </div>

                <!-- Footer Penutup -->
                <div
                    class="mt-2 border-t pt-6 border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4 relative z-10">
                    <div class="text-center sm:text-left">
                        <p class="text-xl font-bold text-gray-800">{{ get_setting('headmaster') }}</p>
                        <p class="text-sm text-gray-500">Kepala {{ get_setting('school_name') }}</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
