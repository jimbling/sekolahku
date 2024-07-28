@extends('components.frontend.app_statis')

@section('title', 'Direktori PD Non Aktif')

@section('content')

    <div class="container mx-auto">
        <div class="bg-white shadow-xl rounded-lg overflow-hidden p-16 mx-4 sm:mx-6 md:mx-8 lg:mx-10">
            <!-- Skeleton Loader -->
            <div id="loading-skeleton" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <!-- Skeleton Card -->
                @for ($i = 0; $i < 3; $i++)
                    <div class="bg-gray-200 relative overflow-hidden rounded-lg p-4">
                        <div class="h-24 bg-gray-300 rounded mb-4 shimmer"></div>
                        <div class="h-4 bg-gray-300 rounded mb-2 shimmer"></div>
                        <div class="h-4 bg-gray-300 rounded mb-2 shimmer"></div>
                        <div class="h-4 bg-gray-300 rounded shimmer"></div>
                    </div>
                @endfor
            </div>

            <!-- Alert for empty data -->
            <div id="no-data-alert"
                class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative text-center"
                role="alert">
                <strong class="font-bold block">Data Tidak Ditemukan!</strong>
                <span class="block">Tidak ada data yang tersedia untuk ditampilkan.</span>
            </div>

            <div id="pd-non-aktif" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 hidden">
                <!-- Cards will be injected here -->
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    @vite('resources/js/backend/pd_non_active.js')
@endpush
