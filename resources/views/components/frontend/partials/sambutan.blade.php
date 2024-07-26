<div class="bg-base min-h-screen flex items-center justify-center px-4 sm:px-6 md:px-8 lg:px-12 overflow-x-hidden">
    <div data-aos="fade-right"
        class="flex flex-col md:flex-row items-center space-y-6 md:space-y-0 md:space-x-6 w-full max-w-screen-xl mx-auto">
        <img src="{{ asset('storage/images/settings/' . get_setting('headmaster_photo')) }}"
            class="max-w-sm rounded-lg shadow-2xl mx-auto" />
        <div class="text-center md:text-center w-full" data-aos="fade-left">
            <h1 class="text-2xl font-bold">Sambutan Kepala Sekolah</h1>
            <p class="py-6">
                {!! $sambutan->content !!}
            </p>
            <h1 class="text-2xs font-bold">{{ get_setting('headmaster') }}</h1>
        </div>
    </div>
</div>
