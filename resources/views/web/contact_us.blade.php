@extends('components.frontend.app')

@section('title', 'Hubungi Kami')
@section('sidebar')
    @include('components.frontend.partials.sidebar')
@endsection
@section('content')

    <section id="map" class="bg-base">
        <div class="container mx-auto">
            <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md mb-4">
                <div class="relative overflow-hidden rounded-lg" style="padding-top: 30.25%;">
                    <iframe class="absolute inset-0 w-full h-60"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d415.47311961152815!2d110.13530259695493!3d-7.824844268503905!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7ae54a4db2df3f%3A0x3c5bafa8dc69ed1!2sSD%20Negeri%20Kedungrejo!5e0!3m2!1sid!2sid!4v1720599775698!5m2!1sid!2sid"
                        style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="py-2 px-4">
        <div class="container mx-auto">
            <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md mb-4">
                <div class="text-center">
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mt-4 mb-4 shadow-md"
                            role="alert">
                            <p class="font-bold">Success!</p>
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif
                </div>
                <form action="{{ route('messages.store') }}" method="POST" class="mt-4 md:mt-8">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8">
                        <input type="text" placeholder="Your Name"
                            class="p-4 border rounded-lg focus:outline-none focus:border-blue-500" name="name"
                            id="name">
                        <input type="email" placeholder="Your Email"
                            class="p-4 border rounded-lg focus:outline-none focus:border-blue-500" name="email"
                            id="email">
                    </div>
                    <textarea placeholder="Your Message" class="p-4 border rounded-lg mt-4 w-full focus:outline-none focus:border-blue-500"
                        name="message" id="message"></textarea>
                    <button type="submit"
                        class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg focus:outline-none">Send
                        Message</button>
                </form>
            </div>
        </div>
    </section>

    <section id="search" class="py-2 px-4">
        <div class="container mx-auto">
            <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-4 text-center">Cari Data Berdasarkan NISN</h2>
                <form id="searchForm" onsubmit="submitForm(event)">
                    <div class="mb-4">
                        <label for="nisn" class="block text-sm font-medium text-gray-700">Masukkan NISN:</label>
                        <input type="text" id="nisn" name="nisn" required
                            class="input input-bordered input-primary w-full mt-1 block">
                    </div>
                    <button type="submit" class="btn btn-primary w-full py-2 px-4 text-sm font-medium">
                        Cari
                    </button>
                </form>

                <div id="result" class="mt-6"></div>
            </div>
        </div>


    </section>



@endsection
