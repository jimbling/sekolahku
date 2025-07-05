@extends('themes.' . getActiveTheme() . '.app')
@section('title', 'Galeri Foto')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 ">
        <div class="bg-white shadow-xl rounded-lg overflow-hidden p-5">

            <!-- Form Pencarian -->
            <div class="w-full max-w-6xl mx-auto mb-8">
                <form id="form-search" action="{{ route('web.cari.albums') }}" method="GET" class="flex items-center">
                    <div class="relative w-full">
                        <input type="text" name="keywords" value="{{ request()->input('keywords') }}"
                            placeholder="Cari album foto..."
                            class="w-full h-14 px-4 py-2 pr-28 rounded-lg border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 text-gray-900 placeholder-gray-500">
                        <button type="submit"
                            class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-blue-500 hover:bg-blue-900 text-white font-semibold py-2 px-4 rounded-lg shadow-lg transition duration-300 hover:shadow-xl active:bg-blue-800 active:scale-95 border-2 border-gray-300">
                            Cari
                        </button>
                        @if (Route::currentRouteName() == 'web.cari.albums')
                            <a href="{{ route('albums.index') }}"
                                class="absolute top-1/2 right-20 transform -translate-y-1/2 bg-orange-500 hover:bg-orange-700 text-white font-semibold py-2 px-4 rounded-lg shadow-lg transition duration-300 hover:shadow-xl active:bg-gray-600 active:scale-95 border-2 border-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-6">
                                    <path fill-rule="evenodd"
                                        d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($albums as $album)
                    @php
                        $coverPhotoPath = $album->cover_photo
                            ? asset('storage/' . $album->cover_photo)
                            : asset('path/to/placeholder-image.jpg');
                    @endphp

                    <div
                        class="group relative overflow-hidden rounded-xl shadow-lg transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 border-2 border-blue-100">
                        <!-- Thumbnail Image -->
                        <div class="h-64 overflow-hidden relative">
                            <img src="{{ $coverPhotoPath }}" alt="{{ $album->name }}"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">

                            <!-- Overlay dengan efek glassmorphism -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6 backdrop-blur-sm">
                                <div
                                    class="transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                    <h3 class="text-white text-xl font-bold mb-2 drop-shadow-lg">{{ $album->name }}</h3>
                                    <p class="text-gray-100 text-sm mb-4 line-clamp-2 drop-shadow-md">
                                        {{ $album->description }}</p>
                                    <button data-album-id="{{ $album->id }}"
                                        class="show-photos bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg text-sm font-medium transition-all duration-200 shadow-lg hover:shadow-blue-500/50 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Lihat Album
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Card -->
                        <div class="p-4 bg-white border-t border-gray-100">
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ \Carbon\Carbon::parse($album->created_at)->translatedFormat('d F Y') }}
                                </span>
                                <span
                                    class="text-xs font-semibold text-blue-600 bg-blue-100 py-1 px-2 rounded-full flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $album->images_count }} Foto
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if (!$albums->isEmpty())
                <div class="mt-8 flex justify-center">
                    <nav class="inline-flex rounded-md shadow">
                        @if ($albums->currentPage() > 1)
                            <a href="{{ $albums->previousPageUrl() }}"
                                class="px-3 py-2 rounded-l-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Previous</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        @endif

                        @foreach ($albums->getUrlRange(1, $albums->lastPage()) as $page => $url)
                            <a href="{{ $url }}"
                                class="{{ $page == $albums->currentPage() ? 'bg-blue-500 text-white' : 'bg-white text-gray-500 hover:bg-gray-50' }} px-4 py-2 border-t border-b border-gray-300">
                                {{ $page }}
                            </a>
                        @endforeach

                        @if ($albums->hasMorePages())
                            <a href="{{ $albums->nextPageUrl() }}"
                                class="px-3 py-2 rounded-r-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Next</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        @endif
                    </nav>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Foto yang Diimprovisasi -->
    <div id="photo-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center  px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-black opacity-75"></div>
            </div>

            <!-- Modal content - Pusatkan vertikal dan horizontal -->
            <div
                class="inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full mx-auto">
                <div class="relative">
                    <!-- Tombol close - Warna merah tebal -->
                    <button id="modal-close"
                        class="absolute top-4 right-4 z-10 bg-red-600 hover:bg-red-700 text-white rounded-full p-2 focus:outline-none transition-colors shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <!-- Navigation buttons - Warna biru dengan shadow -->
                    <button id="prev-photo"
                        class="absolute left-4 top-1/2 transform -translate-y-1/2 z-10 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-3 focus:outline-none transition-colors shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>

                    <button id="next-photo"
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 z-10 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-3 focus:outline-none transition-colors shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <!-- Foto container dengan padding atas -->
                    <div id="photo-container"
                        class="w-full h-96 sm:h-[32rem] bg-gray-100 flex items-center justify-center pt-6">
                        <img id="current-photo" src="" alt=""
                            class="max-w-full max-h-full object-contain">
                    </div>

                    <!-- Info foto -->
                    <div class="bg-white p-4 border-t border-gray-200">
                        <h3 id="photo-title" class="text-lg font-medium text-gray-900"></h3>
                        <p id="photo-description" class="text-gray-500 mt-1"></p>
                        <div class="mt-2 flex justify-between items-center">
                            <span id="photo-index" class="text-sm text-gray-500"></span>
                            <span id="photo-date" class="text-sm text-gray-500"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentAlbumPhotos = [];
            let currentPhotoIndex = 0;
            const modal = document.getElementById('photo-modal');
            const photoContainer = document.getElementById('photo-container');
            const currentPhoto = document.getElementById('current-photo');
            const photoTitle = document.getElementById('photo-title');
            const photoDescription = document.getElementById('photo-description');
            const photoIndex = document.getElementById('photo-index');
            const photoDate = document.getElementById('photo-date');

            // Event listeners untuk tombol album
            document.querySelectorAll('.show-photos').forEach(button => {
                button.addEventListener('click', function() {
                    const albumId = this.getAttribute('data-album-id');
                    loadAlbumPhotos(albumId);
                });
            });

            // Fungsi untuk memuat foto album
            function loadAlbumPhotos(albumId) {
                fetch(`/album/${albumId}/photos`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.photos && data.photos.length > 0) {
                            currentAlbumPhotos = data.photos;
                            currentPhotoIndex = 0;
                            showPhoto(currentPhotoIndex);
                            modal.classList.remove('hidden');
                            document.body.classList.add('overflow-hidden');
                        } else {
                            alert('Album ini belum memiliki foto.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal memuat foto album.');
                    });
            }

            // Fungsi untuk menampilkan foto dengan animasi
            function showPhoto(index) {
                if (currentAlbumPhotos.length === 0 || index < 0 || index >= currentAlbumPhotos.length) return;

                // Animasi fade out
                photoContainer.classList.add('opacity-0');

                setTimeout(() => {
                    const photo = currentAlbumPhotos[index];
                    currentPhoto.src = photo.path;
                    currentPhoto.alt = photo.caption || 'Foto album';
                    currentPhoto.onload = () => {
                        // Animasi fade in setelah gambar dimuat
                        photoContainer.classList.remove('opacity-0');
                    };

                    photoTitle.textContent = photo.caption || 'Tanpa judul';
                    photoDescription.textContent = photo.description || '';
                    photoIndex.textContent = `Foto ${index + 1} dari ${currentAlbumPhotos.length}`;
                    photoDate.textContent = new Date(photo.created_at).toLocaleDateString('id-ID', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });

                    currentPhotoIndex = index;
                }, 200);
            }
            // Event listeners untuk navigasi foto
            document.getElementById('prev-photo').addEventListener('click', function() {
                if (currentPhotoIndex > 0) {
                    showPhoto(currentPhotoIndex - 1);
                } else {
                    showPhoto(currentAlbumPhotos.length - 1); // Loop ke foto terakhir
                }
            });

            document.getElementById('next-photo').addEventListener('click', function() {
                if (currentPhotoIndex < currentAlbumPhotos.length - 1) {
                    showPhoto(currentPhotoIndex + 1);
                } else {
                    showPhoto(0); // Loop ke foto pertama
                }
            });

            // Event listener untuk menutup modal
            document.getElementById('modal-close').addEventListener('click', function() {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            });

            // Tutup modal saat mengklik di luar konten
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            });

            // Navigasi dengan keyboard
            document.addEventListener('keydown', function(e) {
                if (!modal.classList.contains('hidden')) {
                    if (e.key === 'ArrowLeft') {
                        document.getElementById('prev-photo').click();
                    } else if (e.key === 'ArrowRight') {
                        document.getElementById('next-photo').click();
                    } else if (e.key === 'Escape') {
                        document.getElementById('modal-close').click();
                    }
                }
            });
        });
    </script>
@endpush
