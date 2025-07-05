{{-- @extends('components.frontend.app_statis') --}}
@extends('themes.' . getActiveTheme() . '.app_statis')

@section('title', 'Komite Sekolah')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl rounded-lg overflow-hidden p-5">






            <!-- Diagram Struktrur Organisasi -->
            <div class="flex flex-col items-center space-y-8">
                <!-- Ketua -->
                <div class="flex flex-col items-center text-center group">
                    <div class="bg-gradient-to-r from-blue-500 to-teal-500 rounded-lg p-6 max-w-xs shadow-lg">
                        <img src="https://placehold.co/400" alt="Ketua Komite"
                            class="rounded-full mx-auto w-24 h-24 mb-4 border-4 border-white">
                        <h3 class="text-xl font-semibold text-white">Ketua Komite</h3>
                        <p class="text-sm text-gray-100">Nama Ketua</p>
                    </div>
                    <div class="flex items-center space-x-4 mt-6">
                        <div class="w-32 h-1 bg-teal-500"></div>
                    </div>
                </div>

                <!-- Wakil Ketua dan Sekretaris dalam 1 Baris -->
                <div class="flex flex-wrap items-center justify-center gap-12">
                    <!-- Wakil Ketua -->
                    <div class="flex flex-col items-center text-center group">
                        <div class="bg-white shadow-lg rounded-lg p-6 max-w-xs">
                            <img src="https://placehold.co/400" alt="Wakil Ketua"
                                class="rounded-full mx-auto w-24 h-24 mb-4 border-4 border-gray-500">
                            <h3 class="text-xl font-semibold text-gray-800">Wakil Ketua</h3>
                            <p class="text-sm text-gray-600">Nama Wakil Ketua</p>
                        </div>
                    </div>

                    <!-- Sekretaris -->
                    <div class="flex flex-col items-center text-center group">
                        <div class="bg-white shadow-lg rounded-lg p-6 max-w-xs">
                            <img src="https://placehold.co/400" alt="Sekretaris"
                                class="rounded-full mx-auto w-24 h-24 mb-4 border-4 border-gray-500">
                            <h3 class="text-xl font-semibold text-gray-800">Sekretaris</h3>
                            <p class="text-sm text-gray-600">Nama Sekretaris</p>
                        </div>
                    </div>
                </div>

                <!-- Bendahara dan Anggota Komite -->
                <div class="flex flex-wrap items-center justify-center gap-8">

                    <!-- Anggota Komite -->
                    <div class="flex flex-wrap items-center justify-center gap-12">
                        <!-- Anggota 1 -->
                        <div class="flex flex-col items-center text-center group">
                            <div class="bg-white shadow-lg rounded-lg p-6 max-w-xs">
                                <img src="https://placehold.co/400" alt="Anggota Komite 1"
                                    class="rounded-full mx-auto w-24 h-24 mb-4 border-4 border-gray-500">
                                <h3 class="text-xl font-semibold text-gray-800">Anggota Komite 1</h3>
                                <p class="text-sm text-gray-600">Nama Anggota 1</p>
                            </div>
                        </div>

                        <!-- Anggota 2 -->
                        <div class="flex flex-col items-center text-center group">
                            <div class="bg-white shadow-lg rounded-lg p-6 max-w-xs">
                                <img src="https://placehold.co/400" alt="Anggota Komite 2"
                                    class="rounded-full mx-auto w-24 h-24 mb-4 border-4 border-gray-500">
                                <h3 class="text-xl font-semibold text-gray-800">Anggota Komite 2</h3>
                                <p class="text-sm text-gray-600">Nama Anggota 2</p>
                            </div>
                        </div>

                        <!-- Anggota 3 -->
                        <div class="flex flex-col items-center text-center group">
                            <div class="bg-white shadow-lg rounded-lg p-6 max-w-xs">
                                <img src="https://placehold.co/400" alt="Anggota Komite 3"
                                    class="rounded-full mx-auto w-24 h-24 mb-4 border-4 border-gray-500">
                                <h3 class="text-xl font-semibold text-gray-800">Anggota Komite 3</h3>
                                <p class="text-sm text-gray-600">Nama Anggota 3</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>





        </div>
    </div>
@endsection
