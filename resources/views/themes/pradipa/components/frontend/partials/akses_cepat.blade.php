@php
    $gridCols = $quickLinks->count();
@endphp



@if ($gridCols)
    <section class="bg-gradient-to-b from-[#028c84] to-[#03B5AA] text-white py-20">
        <div class="container mx-auto px-4 text-center" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-bold mb-4 font-sans">Akses Cepat</h2>
            <p class="text-xl mb-12 max-w-2xl mx-auto opacity-90">Temukan layanan utama kami dengan cepat dan mudah</p>

            <div class="w-full flex justify-center">
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-{{ min(4, $gridCols) }} gap-8 w-full max-w-5xl px-4">
                    @foreach ($quickLinks as $index => $link)
                        <a href="{{ $link->url }}"
                            class="group relative bg-white/10 backdrop-blur-sm rounded-2xl overflow-hidden shadow-2xl hover:shadow-xl transition-all duration-300 p-8 flex flex-col items-center text-center border border-white/20 hover:border-white/30 hover:-translate-y-2 hover:scale-[1.02]"
                            data-aos="fade-up" data-aos-delay="{{ 100 * $index }}">
                            <div
                                class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                            <div
                                class="relative z-10 bg-white/20 rounded-full p-4 mb-6 group-hover:bg-white/30 transition-colors duration-300">
                                <span class="w-8 h-8 text-white">{!! $link->icon !!}</span>
                            </div>
                            <h3 class="relative z-10 text-xl font-bold mb-2 group-hover:text-white/90">
                                {{ $link->label }}
                            </h3>
                            <p class="relative z-10 text-sm text-white/80 group-hover:text-white">
                                {{ $link->description ?? 'Pelajari lebih lanjut' }}
                            </p>
                            <div
                                class="absolute bottom-0 left-0 right-0 h-1 bg-transparent group-hover:bg-white/30 transition-all duration-500">
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
