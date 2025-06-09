@php
    use Illuminate\Support\Str;
@endphp

<div class="relative mx-auto px-4 overflow-hidden">
    {{-- Konten Utama --}}
    <div class="relative z-10">
        <div class="text-center mb-8" data-aos="fade-down">
            <h2 class="text-3xl font-bold">
                <span class="text-gradient">Sambutan Kepala Sekolah</span>
            </h2>
        </div>

        <div data-aos="fade-right"
            class="flex flex-col md:flex-row items-center space-y-6 md:space-y-0 md:space-x-6 w-full max-w-screen-xl mx-auto">
            <img src="{{ asset('storage/images/settings/' . get_setting('headmaster_photo')) }}" alt="Foto Kepala Sekolah"
                loading="lazy" class="headmaster-photo" />

            <div class="text-center md:text-left w-full" data-aos="fade-left">
                <p>
                    {!! Str::limit($sambutan->content, 800, '...') !!}
                </p>
                <h1 class="text-2xs font-bold">{{ get_setting('headmaster') }}</h1>
            </div>
        </div>
    </div>
</div>
