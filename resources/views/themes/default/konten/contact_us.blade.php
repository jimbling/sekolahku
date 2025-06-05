{{-- @extends('components.frontend.app') --}}
@extends('themes.' . getActiveTheme() . '.app')

@section('title', 'Hubungi Kami')
@section('sidebar')
    {{-- @include('components.frontend.partials.sidebar') --}}
    @include('themes.' . getActiveTheme() . '.components.frontend.partials.sidebar')
@endsection
@section('content')

    <section id="maps">
        <div class="container mx-auto">

            <div class="max-w-full mx-auto bg-white p-6 rounded-lg shadow-md">
                <div class="text-left">
                    <h2 class="text-xl font-bold mb-4">Lokasi</h2>
                </div>
                <div class="relative mb-8">
                    <div class="h-1 bg-gray-300 w-full absolute top-0 left-0"></div>
                    <div class="h-1 bg-blue-800 w-1/3 absolute top-0 left-0"></div>
                </div>
                <div class="relative overflow-hidden rounded-lg" style="padding-top: 42.25%;">
                    <iframe class="absolute inset-0 w-full h-full"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d415.47311961152815!2d110.13530259695493!3d-7.824844268503905!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7ae54a4db2df3f%3A0x3c5bafa8dc69ed1!2sSD%20Negeri%20Kedungrejo!5e0!3m2!1sid!2sid!4v1720599775698!5m2!1sid!2sid"
                        style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </section>

    <section id="alamat_lengkap" class="py-8">
        <div class="container mx-auto">
            <div class="max-w-full mx-auto bg-white p-6 rounded-lg shadow-md">
                <div class="text-left">
                    <h2 class="text-xl font-bold mb-4">Alamat Lengkap</h2>
                    <div class="relative mb-8">
                        <div class="h-1 bg-gray-300 w-full absolute top-0 left-0"></div>
                        <div class="h-1 bg-blue-800 w-1/4 absolute top-0 left-0"></div>
                    </div>
                    <div class="text-gray-600">
                        <p class="mb-2 text-lg font-semibold">{{ get_setting('school_name') }}</p>
                        <p class="mb-4">{{ get_setting('sub_village') }} RT {{ get_setting('rt') }} RW
                            {{ get_setting('rw') }},<br>
                            Kalurahan: {{ get_setting('village') }}, Kecamatan: {{ get_setting('sub_district') }},
                            Kabupaten/Kota: {{ get_setting('district') }}, Kode Pos : {{ get_setting('postal_code') }} <br>
                            Provinsi Daerah Istimewa Yogyakarta, Indonesia
                        </p>
                        <p class="mb-2 text-lg font-semibold">Telepon:</p>
                        <p class="mb-4">{{ get_setting('phone') }}</p>
                        <p class="mb-2 text-lg font-semibold">Email:</p>
                        <p class="mb-4">{{ get_setting('email') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="contact">
        <div class="container mx-auto">
            <div class="max-w-full mx-auto bg-white p-6 rounded-lg shadow-md mb-4">
                <div class="text-left">
                    <h2 class="text-xl font-bold mb-4">Pesan</h2>
                    <div class="relative mb-8">
                        <div class="h-1 bg-gray-300 w-full absolute top-0 left-0"></div>
                        <div class="h-1 bg-blue-800 w-1/3 absolute top-0 left-0"></div>
                    </div>
                    <p class="text-gray-700 mb-4">Gunakan formulir di bawah ini untuk mengirimkan pertanyaan, komentar, atau
                        umpan balik. Kami akan merespons secepat mungkin.</p>


                </div>
                <form action="{{ route('messages.store') }}" method="POST" class="mt-4 md:mt-8">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8">
                        <input type="text" placeholder="Isikan nama"
                            class="p-4 border rounded-lg focus:outline-none focus:border-blue-500" name="name"
                            id="name">
                        <input type="email" placeholder="Isikan email"
                            class="p-4 border rounded-lg focus:outline-none focus:border-blue-500" name="email"
                            id="email">
                    </div>
                    <textarea placeholder="Tambahkan Pesan"
                        class="p-4 border rounded-lg mt-4 w-full focus:outline-none focus:border-blue-500" name="message" id="message"></textarea>
                    <button type="submit"
                        class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg focus:outline-none">Kirim
                        Pesan</button>
                </form>
            </div>
        </div>
    </section>



    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition.duration.300ms
            class="fixed bottom-4 right-4 flex items-center space-x-3 bg-green-600 text-white px-4 py-3 rounded-lg shadow-lg z-50">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            <span class="text-sm font-medium">{{ session('success') }} Pesan anda telah terkirim, cek email yang anda isi.
                Balasan akan dikirim ke email tersebut.</span>
        </div>
    @endif



@endsection
