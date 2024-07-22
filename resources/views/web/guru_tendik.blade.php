@extends('components.frontend.app_statis')

@section('title', 'Direktori GTK')

@section('content')

    <div class="container mx-auto">
        <div class="bg-white shadow-xl rounded-lg overflow-hidden p-5 mx-4 sm:mx-6 md:mx-8 lg:mx-10">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                @foreach ($gtks as $gtk)
                    <div class="card bg-white shadow-md rounded-lg overflow-hidden relative">
                        <div
                            class="bg-gradient-to-r from-purple-300 via-pink-300 to-blue-300 h-20 flex justify-center items-end">
                            <div class="relative w-24 h-24 -mb-12">
                                <img src="{{ !empty($gtk->photo) ? asset('storage/' . $gtk->photo) : 'https://via.placeholder.com/400' }}"
                                    alt="Foto GTK"
                                    class="w-full h-full rounded-full object-cover border-4 border-white shadow-md">
                            </div>
                        </div>
                        <div class="pt-16 pb-6 px-4 bg-gray-100 rounded-b-lg flex flex-col items-center">
                            <h2 class="text-lg font-semibold mb-2 text-center">{{ $gtk->full_name }}</h2>
                            <button class="bg-purple-500 text-white py-2 px-4 rounded mt-2 w-full"
                                data-modal-target="#modal-{{ $gtk->id }}">
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                    <div id="modal-{{ $gtk->id }}"
                        class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg">
                            <h2 class="text-xl font-semibold mb-4">{{ $gtk->full_name }}</h2>
                            <p class="mb-1"><strong>Jenis Kelamin:</strong>
                                {{ $gtk->gender === 'M' ? 'Pria' : 'Perempuan' }}</p>
                            <p class="mb-1"><strong>Status Induk:</strong>
                                {{ $gtk->parent_school_status === 1 ? 'INDUK' : 'NON INDUK' }}</p>
                            <p class="mb-1"><strong>Status GTK:</strong> {{ $gtk->gtk_status }}</p>
                            <button class="bg-red-500 text-white py-2 px-4 rounded mt-4"
                                data-modal-close="#modal-{{ $gtk->id }}">
                                Tutup
                            </button>
                        </div>
                    </div>
                    <!-- Modal -->
                @endforeach
            </div>

            <!-- Pagination Links -->
            <div class="mt-8 flex justify-center">
                <div class="join">
                    @if ($gtks->onFirstPage())
                        <button class="join-item btn btn-disabled">&laquo;</button>
                    @else
                        <a href="{{ $gtks->previousPageUrl() }}" class="join-item btn">&laquo;</a>
                    @endif

                    @foreach ($gtks->getUrlRange(1, $gtks->lastPage()) as $page => $url)
                        <a href="{{ $url }}"
                            class="join-item btn {{ $page == $gtks->currentPage() ? 'btn-active' : '' }}">
                            {{ $page }}
                        </a>
                    @endforeach

                    @if ($gtks->hasMorePages())
                        <a href="{{ $gtks->nextPageUrl() }}" class="join-item btn">&raquo;</a>
                    @else
                        <button class="join-item btn btn-disabled">&raquo;</button>
                    @endif
                </div>
            </div>
        </div>
    </div>




@endsection
