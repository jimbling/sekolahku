document.addEventListener('DOMContentLoaded', function() {
    const skeleton = document.getElementById('gtk-skeleton');
    const container = document.getElementById('gtk-container');
    const paginationControls = document.getElementById('pagination-controls');
    const searchInput = document.getElementById('gtk-search');
    const statusFilter = document.getElementById('gtk-filter');
    let currentPage = 1;
    let currentSearch = '';
    let currentStatus = '';

    function fetchGTKData(page = 1, search = '', status = '') {
        if (isNaN(page) || page < 1) return;

        let url = `/api/gtk?page=${page}`;
        if (search) url += `&search=${encodeURIComponent(search)}`;
        if (status) url += `&status=${encodeURIComponent(status)}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                skeleton.style.display = 'none';
                container.innerHTML = '';

                if (data.data.length === 0) {
    container.innerHTML = `
        <div class="col-span-full py-12 text-center">
            <div class="mx-auto w-24 h-24 text-gray-400 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-700">Tidak ada data ditemukan</h3>
            <p class="mt-1 text-gray-500">Coba gunakan kata kunci atau filter yang berbeda</p>
        </div>
    `;
    paginationControls.innerHTML = '';  // <== Ini penting
    return;
}


                data.data.forEach(gtk => {
                    const isActive = gtk.gtk_status === 'Aktif';
                    const card = document.createElement('div');
                    card.className = `bg-white rounded-lg overflow-hidden shadow-sm transition-all duration-300 hover:shadow-md hover:-translate-y-1 ${!isActive ? 'opacity-80' : ''}`;
                    
                    card.innerHTML = `
                    <div class="relative">
                        <div class="${isActive ? 'bg-gradient-to-r from-blue-50 to-blue-100' : 'bg-gradient-to-r from-gray-100 to-gray-200'} h-32 flex justify-center items-end relative">
                            <div class="absolute top-2 right-2">
                                <span class="${isActive ? 'bg-green-500 text-white' : 'bg-gray-400 text-gray-800'} text-xs px-2 py-1 rounded-full font-medium">
                                    ${gtk.gtk_status}
                                </span>
                            </div>
                            <img src="${getPhotoUrl(gtk)}" alt="Foto ${gtk.full_name}" 
                                class="absolute -bottom-12 w-24 h-24 rounded-full object-cover border-4 border-white shadow-md">
                        </div>
                    </div>
                    <div class="pt-16 pb-6 px-4 text-center space-y-2">
                        <h3 class="text-lg font-semibold ${isActive ? 'text-gray-800' : 'text-gray-500'}">${gtk.full_name}</h3>
                        <p class="text-sm ${isActive ? 'text-blue-600' : 'text-gray-400'}">${gtk.jabatan || 'GTK'}</p>
                        <div class="mt-4 flex justify-center gap-2">
                            <button class="px-4 py-2 ${isActive ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-400 hover:bg-gray-500'} text-white text-sm font-medium rounded-full transition-all duration-200 transform hover:scale-105 active:scale-95"
                                data-modal-id="${gtk.id}">
                                Lihat Detail
                            </button>
                           
                        </div>
                    </div>
                `;
                    container.appendChild(card);
                });

                setupDetailButtons();
                updatePaginationControls(data);
            })
            .catch(error => {
                console.error('Error:', error);
                container.innerHTML = `
                <div class="col-span-full py-12 text-center">
                    <div class="mx-auto w-24 h-24 text-red-400 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-700">Terjadi kesalahan</h3>
                    <p class="mt-1 text-gray-500">Gagal memuat data GTK. Silakan coba lagi.</p>
                    <button onclick="fetchGTKData(currentPage, currentSearch, currentStatus)" 
                        class="mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors duration-200">
                        Muat Ulang
                    </button>
                </div>
            `;
            });
    }

    function getPhotoUrl(gtk) {
        if (gtk.photo) return '/storage/' + gtk.photo;
        if (gtk.gender === 'F') return '/storage/images/illustrasi/gtk-wanita.jpg';
        if (gtk.gender === 'M') return '/storage/images/illustrasi/gtk-pria.jpg';
        return 'https://ui-avatars.com/api/?name=' + encodeURIComponent(gtk.full_name) +
            '&background=random';
    }

    function setupDetailButtons() {
        const buttons = document.querySelectorAll('[data-modal-id]');
        buttons.forEach(button => {
            button.addEventListener('click', () => fetchGTKDetail(button.dataset.modalId));
        });
    }

    function fetchGTKDetail(id) {
        fetch(`/api/gtk/${id}`)
            .then(response => response.json())
            .then(gtk => {
                const isActive = gtk.gtk_status === 'Aktif';
                let modal = document.querySelector(`#modal-${id}`);
                if (!modal) {
                    modal = document.createElement('dialog');
                    modal.id = `modal-${id}`;
                    modal.className =
                        'fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm p-4 opacity-0 invisible transition-opacity duration-300';
                    modal.innerHTML = `
                    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-95">
                        <div class="relative">
                            <button class="absolute top-4 right-4 z-10 w-8 h-8 rounded-full bg-white shadow-md flex items-center justify-center text-gray-500 hover:text-gray-700 transition-colors duration-200"
                                onclick="this.closest('dialog').close()">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div class="grid md:grid-cols-2 gap-8 p-6">
                                <div class="space-y-6">
                                    <div class="flex items-center space-x-4">
                                        <img src="${getPhotoUrl(gtk)}" alt="Foto ${gtk.full_name}" 
                                            class="w-24 h-24 rounded-full object-cover border-4 ${isActive ? 'border-blue-100' : 'border-gray-200'} shadow-md">
                                        <div>
                                            <h2 class="text-2xl font-bold ${isActive ? 'text-gray-800' : 'text-gray-500'}">${gtk.full_name}</h2>
                                            <p class="${isActive ? 'text-blue-600' : 'text-gray-400'} font-medium">${gtk.jabatan || 'GTK'} • ${gtk.gtk_status}</p>
                                           
                                        </div>
                                    </div>
                                    <div class="space-y-4">
                                        <div class="border-t border-gray-100 pt-4">
                                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Informasi Pribadi</h3>
                                            <div class="space-y-3">
                                                <div class="flex">
                                                    <span class="w-32 text-gray-500">Jenis Kelamin</span>
                                                    <span class="text-gray-700">${gtk.gender === 'M' ? 'Laki-laki' : 'Perempuan'}</span>
                                                </div>
                                                <div class="flex">
                                                    <span class="w-32 text-gray-500">Status</span>
                                                    <span class="${isActive ? 'text-green-600' : 'text-gray-500'} font-medium">${gtk.gtk_status}</span>
                                                </div>
                                                <div class="flex">
                                                    <span class="w-32 text-gray-500">Status Induk</span>
                                                    <span class="text-gray-700">${gtk.parent_school_status === 1 ? 'INDUK' : 'NON INDUK'}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-6 flex flex-col items-center justify-center">
                                    <img src="${getPhotoUrl(gtk)}" alt="Foto ${gtk.full_name}" 
                                        class="max-h-64 rounded-lg object-cover shadow-sm mb-4">
                                    <div class="text-center">
                                        <div class="inline-flex items-center px-4 py-2 rounded-full ${isActive ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'}">
                                            <span class="text-sm font-medium">Status: ${gtk.gtk_status}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                    document.body.appendChild(modal);
                }

                // Show modal with animation
                modal.showModal();
                setTimeout(() => {
                    modal.classList.remove('opacity-0', 'invisible');
                    modal.querySelector('div').classList.remove('scale-95');
                }, 10);

                // Close modal handler
                modal.addEventListener('close', () => {
                    modal.classList.add('opacity-0', 'invisible');
                    modal.querySelector('div').classList.add('scale-95');
                });
            })
            .catch(error => {
                console.error('Error fetching GTK detail:', error);
                alert('Gagal memuat detail GTK. Silakan coba lagi.');
            });
    }

    function updatePaginationControls(data) {
        paginationControls.innerHTML = '';

        const pagination = document.createElement('div');
        pagination.className = 'flex items-center space-x-2';

        // Previous button
        if (data.prev_page_url) {
            const prev = document.createElement('button');
            prev.className =
                'w-10 h-10 flex items-center justify-center rounded-full bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors duration-200';
            prev.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
        `;
            prev.onclick = () => fetchGTKData(data.current_page - 1, currentSearch, currentStatus);
            pagination.appendChild(prev);
        }

        // Page numbers
        const startPage = Math.max(1, data.current_page - 2);
        const endPage = Math.min(data.last_page, data.current_page + 2);

        for (let i = startPage; i <= endPage; i++) {
            const pageBtn = document.createElement('button');
            pageBtn.className =
                `w-10 h-10 flex items-center justify-center rounded-full transition-colors duration-200 ${i === data.current_page ? 'bg-blue-600 text-white' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50'}`;
            pageBtn.textContent = i;
            pageBtn.onclick = () => fetchGTKData(i, currentSearch, currentStatus);
            pagination.appendChild(pageBtn);
        }

        // Next button
        if (data.next_page_url) {
            const next = document.createElement('button');
            next.className =
                'w-10 h-10 flex items-center justify-center rounded-full bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors duration-200';
            next.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
        `;
            next.onclick = () => fetchGTKData(data.current_page + 1, currentSearch, currentStatus);
            pagination.appendChild(next);
        }

        // Info text
        const info = document.createElement('div');
        info.className = 'text-sm text-gray-500 ml-4';
        info.textContent = `Menampilkan ${data.from || 0}-${data.to || 0} dari ${data.total} GTK`;

        paginationControls.appendChild(info);
        paginationControls.appendChild(pagination);
    }

    // Search functionality
   let searchTimeout;
searchInput.addEventListener('input', (e) => {
    clearTimeout(searchTimeout);
    currentSearch = e.target.value.trim();
    
    // Tampilkan skeleton loader saat pencarian dimulai
    skeleton.style.display = 'grid';
    container.innerHTML = '';
    
    searchTimeout = setTimeout(() => {
        fetchGTKData(1, currentSearch, currentStatus);
    }, 800); // Waktu debounce diperpanjang menjadi 800ms
});

    // Filter functionality
    statusFilter.addEventListener('change', () => {
        currentStatus = statusFilter.value;
        fetchGTKData(1, currentSearch, currentStatus);
    });

    // Initial load
    fetchGTKData(currentPage);
});