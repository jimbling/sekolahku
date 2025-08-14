@extends('themes.' . getActiveTheme() . '.app')

@section('title', 'Direktori GTK')

@section('content')
    <div class="container mx-auto px-4 sm:px-6">
        <!-- Search and Filter Section -->
        <div class="mb-8" data-aos="fade-up" data-aos-delay="100">
            <div class="bg-white rounded-xl shadow-sm p-4">
                <div class="flex flex-col md:flex-row md:items-center gap-4">
                    <div class="flex-1 relative">
                        <input type="text" placeholder="Cari GTK (Nama/NIP)..."
                            class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                            id="gtk-search">
                        <svg class="absolute left-3 top-3.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <select
                        class="px-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white"
                        id="gtk-filter">
                        <option value="">Semua Status</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Non-Aktif">Non-Aktif</option>
                        <option value="Mutasi">Mutasi</option>
                        <option value="Pensiun">Pensiun</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Content Container -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <!-- Skeleton Loader -->
            <div id="gtk-skeleton" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                @for ($i = 0; $i < 6; $i++)
                    <div
                        class="bg-white rounded-lg border border-gray-100 overflow-hidden shadow-sm transition-all duration-300 hover:shadow-md animate-pulse">
                        <div class="bg-gradient-to-r from-gray-100 to-gray-50 h-32 flex justify-center items-end relative">
                            <div class="absolute -bottom-12 w-24 h-24 rounded-full bg-gray-200 border-4 border-white"></div>
                        </div>
                        <div class="pt-16 pb-6 px-4 text-center space-y-2">
                            <div class="h-5 bg-gray-200 rounded w-3/4 mx-auto"></div>
                            <div class="h-4 bg-gray-200 rounded w-1/2 mx-auto"></div>
                            <div class="h-8 bg-gray-200 rounded-full w-3/4 mx-auto mt-4"></div>
                        </div>
                    </div>
                @endfor
            </div>

            <!-- GTK Cards Container -->
            <div id="gtk-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-6"></div>

            <!-- Pagination Controls -->
            <div id="pagination-controls" class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                <!-- Content will be dynamically added here -->
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/backend/gtk.js')
@endpush
