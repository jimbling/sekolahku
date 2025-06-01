{{-- @extends('components.frontend.app_statis') --}}
@extends('themes.' . getActiveTheme() . '.app_statis')


@section('title', 'Direktori GTK')

@section('content')

    <div class="container mx-auto">
        <div class="bg-white shadow-xl rounded-lg overflow-hidden p-5 mx-4 sm:mx-6 md:mx-8 lg:mx-10">
            <!-- Skeleton Loader -->
            <div id="gtk-skeleton" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                <!-- Tampilkan skeleton loader untuk 6 card -->
                @for ($i = 0; $i < 6; $i++)
                    <div class="card bg-white shadow-md rounded-lg overflow-hidden animate-pulse">
                        <div class="bg-gradient-to-r from-gray-200 to-gray-300 h-20 flex justify-center items-end">
                            <div class="relative w-24 h-24 -mb-12 bg-gray-300 rounded-full"></div>
                        </div>
                        <div class="pt-16 pb-6 px-4 bg-gray-100 rounded-b-lg flex flex-col items-center">
                            <div class="w-32 h-6 bg-gray-300 rounded mb-2"></div>
                            <div class="w-24 h-6 bg-gray-300 rounded"></div>
                        </div>
                    </div>
                @endfor
            </div>

            <!-- GTK Cards Container -->
            <div id="gtk-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                <!-- Cards will be appended here by JavaScript -->
            </div>

            <!-- Pagination Links -->

            <div id="pagination-controls" class="mt-4 flex justify-center">
                <!-- Pagination links will be dynamically added here -->
            </div>

        </div>
    </div>




@endsection

@push('scripts')
    @vite('resources/js/backend/gtk.js')
@endpush
