{{-- @extends('components.frontend.app_statis') --}}
@extends('themes.' . getActiveTheme() . '.app')

@section('title', 'Direktori PD Non Aktif')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 ">
        <!-- Notification Container -->
        <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2 w-80"></div>

        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-indigo-600 to-blue-500 rounded-2xl p-6 mb-8 text-white shadow-lg">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="mb-6 md:mb-0">
                    <h1 class="text-3xl font-bold mb-2">Alumni Network</h1>
                    <p class="opacity-90 max-w-lg">Temukan dan terhubung dengan alumni {{ get_setting('school_name') }}
                        lainnya. Jalin jaringan profesional dan kenangan masa sekolah.</p>
                </div>
                <button id="open-modal"
                    class="btn bg-white text-indigo-600 hover:bg-indigo-50 font-semibold rounded-lg px-6 py-3 shadow-md transition flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                            clip-rule="evenodd" />
                    </svg>
                    Daftar Sebagai Alumni
                </button>
            </div>
        </div>

        <!-- Search and Filter Bar -->
        <div class="bg-white rounded-xl shadow-md p-4 mb-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="relative w-full sm:w-96">
                <input type="text" id="search-alumni" placeholder="Cari alumni berdasarkan nama..."
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <div class="absolute left-3 top-2.5 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <select id="filter-year" class="select select-bordered">
                    <option value="">Semua Tahun</option>
                    @for ($year = date('Y'); $year >= 2021; $year--)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
                <button id="contact-admin" class="btn bg-indigo-100 text-indigo-600 hover:bg-indigo-200 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                    </svg>
                    Hubungi Admin
                </button>
            </div>
        </div>

        <!-- Skeleton Loader -->
        <div id="loading-skeleton" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @for ($i = 0; $i < 4; $i++)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden animate-pulse">
                    <div class="p-6 flex flex-col md:flex-row gap-6">

                        <!-- Foto skeleton -->
                        <div class="flex-shrink-0 w-full md:w-40 h-48 rounded-xl bg-gray-300"></div>

                        <!-- Info skeleton -->
                        <div class="flex-1 space-y-4">
                            <!-- Nama -->
                            <div class="h-6 bg-gray-300 rounded w-2/3"></div>

                            <!-- Status badge -->
                            <div class="h-5 bg-gray-200 rounded w-20"></div>

                            <!-- NIS -->
                            <div class="h-4 bg-gray-300 rounded w-1/2"></div>

                            <!-- Grid detail -->
                            <div class="space-y-3 mt-3">
                                <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                                <div class="h-4 bg-gray-200 rounded w-2/3"></div>
                            </div>

                            <!-- Footer -->
                            <div class="h-4 bg-gray-300 rounded w-1/3 mt-4"></div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>


        <!-- Empty State -->
        <div id="no-data-alert" class="hidden bg-white rounded-xl shadow-sm p-8 text-center">
            <div class="mx-auto w-48 h-48 text-gray-400 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-xl font-medium text-gray-700 mb-2">Tidak Ada Data Alumni</h3>
            <p class="text-gray-500 mb-6">Belum ada alumni yang terdaftar atau data tidak ditemukan.</p>
            <button id="open-modal" class="btn bg-indigo-600 text-white hover:bg-indigo-700">
                Jadilah yang Pertama Mendaftar
            </button>
        </div>

        <!-- Alumni Cards Container -->
        <div id="pd-non-aktif" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 hidden"></div>
    </div>

    <!-- Alumni Modal -->
    <div id="alumni-modal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden transition-opacity duration-300">
        <div class="bg-white rounded-2xl shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white p-6 border-b flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Formulir Data Alumni</h2>
                <button id="modal-close" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="alumni-form" action="{{ route('alumni.store') }}" method="post" enctype="multipart/form-data"
                class="p-6 space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Photo Upload -->
                    <div class="md:col-span-2 flex flex-col items-center">
                        <div class="relative mb-4">
                            <div
                                class="w-32 h-32 rounded-full bg-gray-100 border-2 border-dashed border-gray-300 overflow-hidden flex items-center justify-center">
                                <img id="photo-preview" src="/storage/images/illustrasi/user-default.png" alt="Preview"
                                    class="w-full h-full object-cover hidden">
                                <span id="upload-text" class="text-gray-400 text-sm">Upload Foto</span>
                            </div>
                            <label for="photo" class="absolute inset-0 cursor-pointer"></label>
                            <input type="file" id="photo" name="alumni_foto" accept="image/*" class="hidden">
                        </div>
                    </div>

                    <!-- Personal Info -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
                        <input type="text" id="name" name="alumni_nama" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Tahun Lulus *</label>
                        <input type="number" id="year" name="alumni_tahun_lulus" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="place_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Tempat
                            Lahir</label>
                        <input type="text" id="place_of_birth" name="alumni_tempat_lahir"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                            Lahir</label>
                        <input type="date" id="date_of_birth" name="alumni_tanggal_lahir"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Aktif *</label>
                        <input type="email" id="email" name="alumni_email" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Handphone</label>
                        <input type="text" id="phone" name="alumni_phone"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                        <select id="gender" name="alumni_jk"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="M">Laki-Laki</option>
                            <option value="F">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <input type="text" id="address" name="alumni_alamat"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                </div>
                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button type="button" id="modal-close"
                        class="btn bg-gray-200 text-gray-700 hover:bg-gray-300 px-6 py-2 rounded-lg">
                        Batal
                    </button>
                    <button type="submit"
                        class="btn bg-indigo-600 text-white hover:bg-indigo-700 px-6 py-2 rounded-lg flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        Kirim Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Contact Admin Modal -->
    <div id="contact-admin-modal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full mx-4">
            <div class="p-6 border-b">
                <h3 class="text-lg font-medium text-gray-900">Hubungi Admin Sekolah</h3>
            </div>
            <form id="contact-form" class="p-6 space-y-4">
                <div>
                    <label for="contact-name" class="block text-sm font-medium text-gray-700 mb-1">Nama Anda</label>
                    <input type="text" id="contact-name" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="contact-email" class="block text-sm font-medium text-gray-700 mb-1">Email Anda</label>
                    <input type="email" id="contact-email" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="contact-subject" class="block text-sm font-medium text-gray-700 mb-1">Subjek</label>
                    <select id="contact-subject"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="Informasi Alumni">Meminta Informasi Alumni</option>
                        <option value="Update Data">Memperbarui Data Alumni</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div>
                    <label for="contact-message" class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                    <textarea id="contact-message" rows="4" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
            </form>
            <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                <button type="button" id="close-contact-modal"
                    class="btn bg-gray-200 text-gray-700 hover:bg-gray-300 px-4 py-2 rounded-lg">
                    Batal
                </button>
                <button type="button" id="send-contact-message"
                    class="btn bg-indigo-600 text-white hover:bg-indigo-700 px-4 py-2 rounded-lg">
                    Kirim Pesan
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Modal functionality
            const openModalBtn = document.getElementById('open-modal');
            const alumniModal = document.getElementById('alumni-modal');
            const closeModalBtns = document.querySelectorAll(
                '#modal-close, #modal-header-close, #modal-footer-close');

            openModalBtn.addEventListener('click', () => {
                alumniModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });

            closeModalBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    alumniModal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                });
            });

            // Photo preview
            const photoInput = document.getElementById('photo');
            const photoPreview = document.getElementById('photo-preview');
            const uploadText = document.getElementById('upload-text');

            photoInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        photoPreview.src = event.target.result;
                        photoPreview.classList.remove('hidden');
                        uploadText.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Contact admin modal
            const contactAdminBtn = document.getElementById('contact-admin');
            const contactAdminModal = document.getElementById('contact-admin-modal');
            const closeContactModalBtn = document.getElementById('close-contact-modal');

            contactAdminBtn.addEventListener('click', () => {
                contactAdminModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });

            closeContactModalBtn.addEventListener('click', () => {
                contactAdminModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            });

            // Send contact message
            const sendContactBtn = document.getElementById('send-contact-message');
            sendContactBtn.addEventListener('click', () => {
                const name = document.getElementById('contact-name').value;
                const email = document.getElementById('contact-email').value;
                const subject = document.getElementById('contact-subject').value;
                const message = document.getElementById('contact-message').value;

                fetch('/kirim-pesan', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            name,
                            email,
                            subject,
                            message
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            showToast('Pesan telah dikirim ke admin sekolah', 'success');
                            contactAdminModal.classList.add('hidden');
                            document.body.style.overflow = 'auto';
                            document.getElementById('contact-form').reset();
                        } else {
                            showToast('Terjadi kesalahan saat mengirim pesan', 'error');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        showToast('Gagal mengirim pesan', 'error');
                    });
            });


            // Toast notification
            function showToast(message, type = 'info') {
                const toastContainer = document.getElementById('toast-container');
                const toast = document.createElement('div');
                toast.className =
                    `toast ${type} flex items-center justify-between p-4 rounded-lg shadow-lg transform translate-x-full opacity-0 transition-all duration-300`;

                let icon = '';
                let bgColor = '';

                switch (type) {
                    case 'success':
                        icon =
                            '<svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>';
                        bgColor = 'bg-green-100 text-green-700';
                        break;
                    case 'error':
                        icon =
                            '<svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>';
                        bgColor = 'bg-red-100 text-red-700';
                        break;
                    default:
                        icon =
                            '<svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd"/></svg>';
                        bgColor = 'bg-blue-100 text-blue-700';
                }

                toast.innerHTML = `
            <div class="flex items-center">
                ${icon}
                <span>${message}</span>
            </div>
            <button class="ml-4 text-${type}-600 hover:text-${type}-800">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        `;

                toast.className =
                    `toast flex items-center justify-between p-4 rounded-lg shadow-lg transform translate-x-full opacity-0 transition-all duration-300 ${bgColor}`;

                toastContainer.appendChild(toast);

                // Trigger reflow to enable animation
                setTimeout(() => {
                    toast.classList.remove('translate-x-full', 'opacity-0');
                    toast.classList.add('translate-x-0', 'opacity-100');
                }, 10);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    toast.classList.add('translate-x-full', 'opacity-0');
                    setTimeout(() => toast.remove(), 300);
                }, 5000);

                // Manual close
                toast.querySelector('button').addEventListener('click', () => {
                    toast.classList.add('translate-x-full', 'opacity-0');
                    setTimeout(() => toast.remove(), 300);
                });
            }

            // Load alumni data
            const loadingSkeleton = document.getElementById('loading-skeleton');
            const cardsContainer = document.getElementById('pd-non-aktif');
            const noDataAlert = document.getElementById('no-data-alert');
            const searchInput = document.getElementById('search-alumni');
            const filterYear = document.getElementById('filter-year');

            function fetchAlumniData(searchTerm = '', year = '') {
                loadingSkeleton.classList.remove('hidden');
                cardsContainer.classList.add('hidden');
                noDataAlert.classList.add('hidden');

                let url = '/pd/nonaktif';
                if (searchTerm || year) {
                    url += `?search=${encodeURIComponent(searchTerm)}&year=${year}`;
                }

                fetch(url, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        const dataArray = Array.isArray(data) ? data : Object.values(data);
                        const groupedData = {};

                        dataArray.forEach(student => {
                            if (!groupedData[student.id]) {
                                groupedData[student.id] = {
                                    ...student,
                                    anggota_rombels: []
                                };
                            }
                            if (student.anggota_rombels) {
                                const anggotaRombels = Array.isArray(student.anggota_rombels) ? student
                                    .anggota_rombels : [student.anggota_rombels];
                                groupedData[student.id].anggota_rombels.push(...anggotaRombels);
                            }
                        });

                        loadingSkeleton.classList.add('hidden');

                        if (Object.keys(groupedData).length === 0) {
                            noDataAlert.classList.remove('hidden');
                        } else {
                            noDataAlert.classList.add('hidden');
                            cardsContainer.classList.remove('hidden');
                            renderAlumniCards(Object.values(groupedData));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        loadingSkeleton.classList.add('hidden');
                        noDataAlert.classList.remove('hidden');
                        showToast('Gagal memuat data alumni', 'error');
                    });
            }

            function renderAlumniCards(alumniData) {
                cardsContainer.innerHTML = '';

                const formatDate = (dateString) => {
                    if (!dateString) return '-';
                    return new Date(dateString).toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                };

                // ✅ Tambahkan grid di container utama
                cardsContainer.className = 'grid grid-cols-1 md:grid-cols-2 gap-6';

                alumniData.forEach(student => {
                    const photoUrl = student.photo ? student.photo :
                        (student.gender === 'M' ? '/storage/images/illustrasi/male.png' :
                            '/storage/images/illustrasi/female.png');

                    const alumniStatus = student.is_alumni === 1 ?
                        `<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">Alumni</span>` :
                        `<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Tidak Aktif</span>`;

                    const reason = student.reason || 'Tidak ada informasi';

                    // ✅ Badge warna untuk reason
                    let reasonBadge = '';
                    switch (reason) {
                        case 'Lulus':
                            reasonBadge = 'bg-green-100 text-green-800';
                            break;
                        case 'Mutasi':
                            reasonBadge = 'bg-blue-100 text-blue-800';
                            break;
                        case 'DO':
                            reasonBadge = 'bg-red-100 text-red-800';
                            break;
                        case 'Meninggal':
                            reasonBadge = 'bg-gray-200 text-gray-700 font-semibold';
                            break;
                        case 'Putus Sekolah':
                            reasonBadge = 'bg-orange-100 text-orange-800';
                            break;
                        default:
                            reasonBadge = 'bg-gray-100 text-gray-600';
                    }

                    // ✅ Card lebih besar & lapang
                    const card = document.createElement('div');
                    card.className =
                        'bg-white rounded-2xl shadow-md border border-gray-200 overflow-hidden hover:shadow-lg transition-transform duration-300 hover:-translate-y-1';

                    card.innerHTML = `
            <div class="p-6 flex flex-col md:flex-row gap-6">
                <!-- Foto siswa -->
                <div class="flex-shrink-0 w-full md:w-40 h-48 rounded-xl border border-gray-200 bg-gray-50 overflow-hidden shadow-sm">
                    <img src="${photoUrl}" alt="${student.name}" 
                         class="w-full h-full object-cover object-center" 
                         onerror="this.src='https://via.placeholder.com/160x192?text=No+Photo'" />
                </div>

                <!-- Info utama -->
                <div class="flex-1 space-y-4">
                   <div class="relative">
    <h3 class="text-2xl font-bold text-gray-800 pr-28">
        ${student.name}
    </h3>
    <div class="absolute top-0 right-0">
        ${alumniStatus}
    </div>
</div>

                    <!-- NIS -->
                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-blue-50 border border-blue-100">
                        <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="text-sm font-medium text-blue-700">${student.nis || 'NIS tidak tersedia'}</span>
                    </div>

                    <!-- Grid detail -->
                    <div class="grid grid-cols-1 gap-3">
                        <div class="flex items-center p-2 bg-gray-50 rounded-lg">
                            <div class="p-2 bg-white rounded-md shadow-sm mr-3">
                                <svg class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Tahun Lulus</p>
                                <p class="font-medium text-gray-800">${student.tahun_lulus || 'Belum lulus'}</p>
                            </div>
                        </div>

                        <div class="flex items-center p-2 bg-gray-50 rounded-lg">
                            <div class="p-2 bg-white rounded-md shadow-sm mr-3">
                                <svg class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Email</p>
                                <p class="font-medium text-gray-800 truncate max-w-[200px]" title="${student.email}">
                                ${student.email || 'Tidak tersedia'}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3 pt-3 border-t border-gray-100">
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="flex-shrink-0 mr-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>${formatDate(student.end_date)}</span>
                        </div>
                        <div class="px-3 py-1 rounded-full text-sm font-medium ${reasonBadge}">
                            ${reason}
                        </div>
                    </div>
                </div>
            </div>
        `;

                    cardsContainer.appendChild(card);
                });
            }


            // Initial load
            fetchAlumniData();

            // Search functionality
            let searchTimeout;
            searchInput.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    fetchAlumniData(e.target.value, filterYear.value);
                }, 500);
            });

            // Filter by year
            filterYear.addEventListener('change', (e) => {
                fetchAlumniData(searchInput.value, e.target.value);
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        .btn {
            transition: all 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .toast {
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .toast.success {
            background-color: #f0fdf4;
            color: #166534;
        }

        .toast.error {
            background-color: #fef2f2;
            color: #991b1b;
        }

        .toast.info {
            background-color: #eff6ff;
            color: #1e40af;
        }
    </style>
@endpush
