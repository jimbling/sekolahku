document.addEventListener('DOMContentLoaded', function () {
    const skeleton = document.getElementById('gtk-skeleton');
    const container = document.querySelector('#gtk-container');
    const paginationControls = document.querySelector('#pagination-controls');
    let currentPage = 1;

    function fetchGTKData(page) {
        if (isNaN(page) || page < 1) return;

        fetch(`/api/gtk?page=${page}`)
            .then(response => response.json())
            .then(data => {
                skeleton.style.display = 'none';
                container.innerHTML = '';

                data.data.forEach(gtk => {
                    const card = document.createElement('div');
                    card.className = 'gtk-card';
                    card.innerHTML = `
                        <div class="gtk-header">
                            <div class="gtk-avatar-wrapper">
                                <img src="${getPhotoUrl(gtk)}" alt="Foto GTK" class="gtk-avatar">
                            </div>
                        </div>
                        <div class="gtk-body">
                            <h2 class="gtk-name">${gtk.full_name}</h2>
                            <button class="gtk-detail-btn" data-modal-id="${gtk.id}">Lihat Detail</button>
                        </div>
                    `;
                    container.appendChild(card);
                });

                setupDetailButtons();
                updatePaginationControls(data);
            })
            .catch(console.error);
    }

    function getPhotoUrl(gtk) {
        if (gtk.photo) return '/storage/' + gtk.photo;
        if (gtk.gender === 'F') return '/storage/images/illustrasi/gtk-wanita.jpg';
        if (gtk.gender === 'M') return '/storage/images/illustrasi/gtk-pria.jpg';
        return 'https://via.placeholder.com/150';
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
                let modal = document.querySelector(`#modal-${id}`);
                if (!modal) {
                    modal = document.createElement('dialog');
                    modal.id = `modal-${id}`;
                    modal.className = 'gtk-modal';
                    modal.innerHTML = `
                        <div class="gtk-modal-box">
                            <div class="gtk-modal-body">
                                <button class="gtk-close-btn" formmethod="dialog">✕</button>
                                <h2 class="gtk-modal-title">${gtk.full_name}</h2>
                                <p><strong>Jenis Kelamin:</strong> ${gtk.gender === 'M' ? 'Pria' : 'Perempuan'}</p>
                                <p><strong>Status Induk:</strong> ${gtk.parent_school_status === 1 ? 'INDUK' : 'NON INDUK'}</p>
                                <p><strong>Status GTK:</strong> ${gtk.gtk_status}</p>
                            </div>
                            <div class="gtk-modal-image">
                                <img src="${getPhotoUrl(gtk)}" alt="Foto GTK">
                            </div>
                        </div>
                    `;
                    document.body.appendChild(modal);
                }
                modal.showModal();
            });
    }

    function updatePaginationControls(data) {
        paginationControls.innerHTML = '';

        const pagination = document.createElement('div');
        pagination.className = 'gtk-pagination';

        if (data.prev_page_url) {
            const prev = document.createElement('button');
            prev.className = 'gtk-pagination-btn';
            prev.textContent = '«';
            prev.onclick = () => fetchGTKData(data.current_page - 1);
            pagination.appendChild(prev);
        }

        const current = document.createElement('span');
        current.className = 'gtk-pagination-current';
        current.textContent = `Halaman ${data.current_page}`;
        pagination.appendChild(current);

        if (data.next_page_url) {
            const next = document.createElement('button');
            next.className = 'gtk-pagination-btn';
            next.textContent = '»';
            next.onclick = () => fetchGTKData(data.current_page + 1);
            pagination.appendChild(next);
        }

        paginationControls.appendChild(pagination);
    }

    fetchGTKData(currentPage);
});
