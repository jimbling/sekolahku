@extends('themes.' . getActiveTheme() . '.app_statis')

@section('title', 'Direktori GTK')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl rounded-xl overflow-hidden p-6">

            <!-- 🔍 Search & Filter -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <div class="relative w-full md:w-1/3">
                    <input id="gtk-search" type="text" placeholder="Cari GTK (nama)"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 pl-11 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3.5 top-3.5 text-gray-400"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <div class="relative w-full md:w-auto">
                    <select id="gtk-filter"
                        class="appearance-none w-full border border-gray-200 rounded-xl px-4 py-3 pl-4 pr-10 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white shadow-sm hover:border-gray-300 transition-all duration-200">
                        <option value="">Semua Status</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Non-Aktif">Non Aktif</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- 🦴 Skeleton Loader -->
            <div id="gtk-skeleton" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @for ($i = 0; $i < 8; $i++)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden animate-pulse">
                        <div class="bg-gradient-to-r from-gray-100 to-gray-200 h-32 flex justify-center items-end relative">
                            <div class="absolute -bottom-12 w-24 h-24 bg-gray-300 rounded-full border-4 border-white"></div>
                        </div>
                        <div class="pt-16 pb-6 px-4 bg-white rounded-b-xl flex flex-col items-center">
                            <div class="w-40 h-5 bg-gray-300 rounded-full mb-3"></div>
                            <div class="w-32 h-4 bg-gray-200 rounded-full mb-4"></div>
                            <div class="flex space-x-2">
                                <div class="w-20 h-8 bg-gray-200 rounded-lg"></div>
                                <div class="w-20 h-8 bg-gray-200 rounded-lg"></div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            <!-- GTK Cards -->
            <div id="gtk-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <!-- JS append cards here -->
                <!-- Sample card structure -->
                <div class="gtk-card-template hidden">
                    <div
                        class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <!-- Header with photo -->
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-32 flex justify-center items-end relative">
                            <div
                                class="absolute -bottom-12 w-24 h-24 rounded-full border-4 border-white overflow-hidden shadow-md">
                                <img src="" alt="Profile Photo" class="w-full h-full object-cover" id="card-photo">
                            </div>
                        </div>

                        <!-- Card body -->
                        <div class="pt-16 pb-6 px-4 bg-white rounded-b-xl flex flex-col items-center">
                            <!-- Name -->
                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-1" id="card-name">Nama GTK</h3>

                            <!-- Position -->
                            <p class="text-sm text-gray-500 text-center mb-4" id="card-position">Jabatan</p>

                            <!-- Status badge -->
                            <span class="px-3 py-1 rounded-full text-xs font-medium mb-4" id="card-status-badge">
                                <span id="card-status">Status</span>
                            </span>

                            <!-- Action buttons -->
                            <div class="flex space-x-2 w-full justify-center">
                                <button
                                    class="detail-btn px-4 py-2 bg-blue-50 text-blue-600 rounded-lg text-sm font-medium hover:bg-blue-100 transition-colors">
                                    Detail
                                </button>
                                <button
                                    class="contact-btn px-4 py-2 bg-gray-50 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-100 transition-colors">
                                    Kontak
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div id="pagination-controls" class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-sm text-gray-600">
                    Menampilkan <span id="pagination-from">0</span> - <span id="pagination-to">0</span> dari <span
                        id="pagination-total">0</span> data
                </div>
                <div class="flex items-center space-x-1">
                    <button id="pagination-prev"
                        class="p-2 rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <div class="flex items-center space-x-1">
                        <!-- Page numbers will be inserted here -->
                    </div>
                    <button id="pagination-next"
                        class="p-2 rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Custom styling for status badges */
        .status-active {
            background-color: #EFF6FF;
            color: #3B82F6;
        }

        .status-inactive {
            background-color: #FEF2F2;
            color: #EF4444;
        }

        /* Smooth transitions */
        .transition-smooth {
            transition: all 0.3s ease;
        }

        /* Skeleton shimmer effect */
        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        .skeleton-shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        /* Pagination active state */
        .page-item.active .page-link {
            background-color: #3B82F6;
            color: white;
            border-color: #3B82F6;
        }

        .page-link {
            padding: 0.5rem 0.75rem;
            border: 1px solid #D1D5DB;
            color: #4B5563;
            border-radius: 0.375rem;
            margin: 0 0.15rem;
        }

        .page-link:hover {
            background-color: #F3F4F6;
        }
    </style>
@endpush

@push('scripts')
    @vite('resources/js/backend/gtk.js')
@endpush
