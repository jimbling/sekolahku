{{-- @extends('components.frontend.app_statis') --}}
@extends('themes.' . getActiveTheme() . '.app_statis')

@section('title', 'Direktori PD Non Aktif')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Alert Banner with Modal Trigger -->
        <div id="toast-container" class="toast-container"></div>

        <div class="bg-white shadow-xl rounded-lg overflow-hidden p-4 sm:p-6 md:p-8 lg:p-10">
            <div role="alert"
                class="alert shadow-md bg-blue-100 border-t-4 border-blue-500 text-blue-700 px-4 py-3 rounded relative mb-6 flex flex-col sm:flex-row items-center justify-between">
                <div class="flex items-center space-x-4 mb-4 sm:mb-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path
                            d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002c-.114.06-.227.119-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.173v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z" />
                        <path
                            d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286.921.304 1.83.634 2.726.99v1.27a1.5 1.5 0 0 0-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.66a6.727 6.727 0 0 0 .551-1.607 1.5 1.5 0 0 0 .14-2.67v-.645a48.549 48.549 0 0 1 3.44 1.667 2.25 2.25 0 0 0 2.12 0Z" />
                        <path
                            d="M4.462 19.462c.42-.419.753-.89 1-1.395.453.214.902.435 1.347.662a6.742 6.742 0 0 1-1.286 1.794.75.75 0 0 1-1.06-1.06Z" />
                    </svg>

                    <div class="hidden sm:block">
                        <h3 class="font-semibold text-lg">Apakah Anda Alumni {{ get_setting('school_name') }}?</h3>
                        <p class="text-sm">Jika ya, silakan klik tombol di samping untuk mengisi formulir data Alumni.</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <button id="open-modal" class="btn btn-wide btn-sm btn-primary">Isi Formulir Alumni</button>
                </div>
            </div>

            <!-- Skeleton Loader -->
            <div id="loading-skeleton" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6 md:gap-8">
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

            <div id="pd-non-aktif" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6 md:gap-8 hidden">
                <!-- Cards will be injected here -->
            </div>
        </div>
    </div>




    <!-- Modal for Alumni Input -->
    <div id="alumni-modal"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden transition-opacity duration-300">
        <div
            class="bg-white rounded-lg shadow-lg max-w-4xl w-full mx-4 sm:mx-6 lg:mx-8 p-6 overflow-y-auto max-h-full transition-transform duration-300 transform scale-95">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Formulir Data Alumni</h2>
                <button type="button" id="modal-header-close" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <form id="alumni-form" action="{{ route('alumni.store') }}" method="post" enctype="multipart/form-data"
                class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-gray-700">Nama Lengkap</label>
                        <input type="text" id="name" name="alumni_nama" placeholder="Isikan nama lengkap alumni"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                            required>
                    </div>
                    <!-- Tahun Lulus -->
                    <div>
                        <label for="year" class="block text-gray-700">Tahun Lulus</label>
                        <input type="number" id="year" name="alumni_tahun_lulus" placeholder="Isikan tahun lulus"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                            required>
                    </div>
                    <!-- Tempat Lahir -->
                    <div>
                        <label for="place_of_birth" class="block text-gray-700">Tempat Lahir</label>
                        <input type="text" id="place_of_birth" name="alumni_tempat_lahir"
                            placeholder="Isikan tempat lahir"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    </div>
                    <!-- Tanggal Lahir -->
                    <div>
                        <label for="date_of_birth" class="block text-gray-700">Tanggal Lahir</label>
                        <input type="date" id="date_of_birth" name="alumni_tanggal_lahir"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    </div>
                    <!-- Email Aktif -->
                    <div>
                        <label for="email" class="block text-gray-700">Email Aktif</label>
                        <input type="email" id="email" name="alumni_email" placeholder="Isikan email yang aktif"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    </div>
                    <!-- Nomor Handphone -->
                    <div>
                        <label for="phone" class="block text-gray-700">Nomor Handphone</label>
                        <input type="text" id="phone" name="alumni_phone" placeholder="Isikan nomor handphone"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    </div>
                    <!-- Jenis Kelamin -->
                    <div>
                        <label for="gender" class="block text-gray-700">Jenis Kelamin</label>
                        <select id="gender" name="alumni_jk"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="M">Laki-Laki</option>
                            <option value="F">Perempuan</option>
                        </select>
                    </div>
                    <!-- Alamat -->
                    <div>
                        <label for="address" class="block text-gray-700">Alamat</label>
                        <input type="text" id="address" name="alumni_alamat" placeholder="Isikan alamat"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    </div>
                    <!-- Foto -->
                    <div>
                        <label for="photo" class="block text-gray-700">Foto</label>
                        <input type="file" id="photo" name="alumni_foto"
                            class="mt-1 block w-full file-input file-input-bordered file-input-md max-w-xs">

                    </div>
                </div>
                <div class="flex justify-end space-x-4 mt-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Kirim
                        Data</button>
                    <button type="button" id="modal-footer-close"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">Tutup</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/backend/pd_non_active.js')
    <script>
        const modal = document.getElementById('alumni-modal');
        const modalContent = modal.querySelector('div');

        document.getElementById('open-modal').addEventListener('click', () => {
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-95');
            }, 10);
        });

        document.getElementById('modal-header-close').addEventListener('click', () => {
            modal.classList.add('opacity-0');
            modalContent.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        });

        document.getElementById('modal-footer-close').addEventListener('click', () => {
            modal.classList.add('opacity-0');
            modalContent.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        });
    </script>
    <script>
        function showToast(message, type) {
            const toast = document.createElement('div');
            toast.classList.add('toast', `toast-${type}`);
            toast.innerHTML = `
                <div class="flex items-center">
                    <span class="toast-icon">
                        ${type === 'success' ? '✅' : '❌'}
                    </span>
                    <span>${message}</span>
                </div>
            `;

            document.getElementById('toast-container').appendChild(toast);

            // Show the toast with animation
            setTimeout(() => toast.classList.add('show'), 100);

            // Hide the toast automatically after 5 seconds
            setTimeout(() => hideToast(toast), 5000);
        }

        function hideToast(toast) {
            toast.classList.add('hide');
            setTimeout(() => toast.remove(), 500); // Match the duration of the hide animation
        }

        // Show toast if session messages are present
        @if (session('success'))
            document.addEventListener('DOMContentLoaded', function() {
                showToast("{{ session('success') }}", 'success');
            });
        @endif

        @if (session('error'))
            document.addEventListener('DOMContentLoaded', function() {
                showToast("{{ session('error') }}", 'error');
            });
        @endif
    </script>
@endpush
