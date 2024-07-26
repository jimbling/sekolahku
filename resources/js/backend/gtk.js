document.addEventListener('DOMContentLoaded', function() {
    const skeleton = document.getElementById('gtk-skeleton');
    const container = document.querySelector('#gtk-container');
    const paginationControls = document.querySelector('#pagination-controls');
    let currentPage = 1;

    function fetchGTKData(page) {
        if (isNaN(page) || page < 1) {
            console.error('Invalid page number');
            return;
        }

        fetch(`/api/gtk?page=${page}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (skeleton) {
                    skeleton.style.display = 'none';
                }

                container.innerHTML = '';
                data.data.forEach(gtk => {
                    const card = document.createElement('div');
                    card.className = 'card bg-white shadow-md rounded-lg overflow-hidden relative';
                    card.innerHTML = `
                        <div class="bg-gradient-to-r from-purple-300 via-pink-300 to-blue-300 h-20 flex justify-center items-end" data-aos="fade-in">
                            <div class="relative w-24 h-24 -mb-12">
                                <img src="${gtk.photo ? '/storage/' + gtk.photo : 'https://via.placeholder.com/400'}"
                                    alt="Foto GTK"
                                    class="w-full h-full rounded-full object-cover border-4 border-white shadow-md">
                            </div>
                        </div>
                        <div class="pt-16 pb-6 px-4 bg-gray-100 rounded-b-lg flex flex-col items-center">
                            <h2 class="text-lg font-semibold mb-2 text-center">${gtk.full_name}</h2>
                            <button class="bg-purple-500 text-white py-2 px-4 rounded mt-2 w-full" data-modal-id="${gtk.id}">
                                Lihat Detail
                            </button>
                        </div>
                    `;
                    container.appendChild(card);
                });

                updatePaginationControls(data);

                // Initialize modals
                const modalButtons = document.querySelectorAll('[data-modal-id]');
                modalButtons.forEach(button => {
                    button.addEventListener('click', () => {
                        const id = button.dataset.modalId;
                        fetchGTKDetail(id);
                    });
                });
            })
            .catch(error => {
                console.error('Error:', error);
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
                    modal.className = 'modal';
                    modal.innerHTML = `
                        <div class="modal-box flex">
                            <div class="modal-content flex-1 p-4">
                                <form method="dialog">
                                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                </form>
                                <h2 class="text-xl font-semibold mb-4">${gtk.full_name}</h2>
                                <p class="mb-1"><strong>Jenis Kelamin:</strong> ${gtk.gender === 'M' ? 'Pria' : 'Perempuan'}</p>
                                <p class="mb-1"><strong>Status Induk:</strong> ${gtk.parent_school_status === 1 ? 'INDUK' : 'NON INDUK'}</p>
                                <p class="mb-1"><strong>Status GTK:</strong> ${gtk.gtk_status}</p>
                            </div>
                            <div class="modal-image flex-1 p-4">
                                <img src="${gtk.photo ? '/storage/' + gtk.photo : 'https://via.placeholder.com/150'}"
                                     alt="Foto GTK"
                                     class="w-full h-auto object-cover rounded-lg shadow-md max-w-xs">
                            </div>
                        </div>
                    `;
                    document.body.appendChild(modal);
                } else {
                    modal.querySelector('.modal-content').innerHTML = `
                        <form method="dialog">
                            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                        </form>
                        <h2 class="text-xl font-semibold mb-4">${gtk.full_name}</h2>
                        <p class="mb-1"><strong>Jenis Kelamin:</strong> ${gtk.gender === 'M' ? 'Pria' : 'Perempuan'}</p>
                        <p class="mb-1"><strong>Status Induk:</strong> ${gtk.parent_school_status === 1 ? 'INDUK' : 'NON INDUK'}</p>
                        <p class="mb-1"><strong>Status GTK:</strong> ${gtk.gtk_status}</p>
                    `;
                    modal.querySelector('.modal-image img').src = gtk.photo ? '/storage/' + gtk.photo : 'https://via.placeholder.com/150';
                }

                modal.showModal();

                const closeModalButtons = document.querySelectorAll('button[formmethod="dialog"]');
                closeModalButtons.forEach(button => {
                    button.addEventListener('click', () => {
                        const modal = button.closest('dialog');
                        if (modal) {
                            modal.close();
                        }
                    });
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }



    function updatePaginationControls(data) {
        // Clear previous pagination controls
        paginationControls.innerHTML = '';

        const paginationContainer = document.createElement('div');
        paginationContainer.className = 'join';

        // Previous Button
        if (data.prev_page_url) {
            const prevButton = document.createElement('button');
            prevButton.className = 'join-item btn';
            prevButton.textContent = '«'; // or you can use 'Previous'
            prevButton.addEventListener('click', (event) => {
                event.preventDefault();
                fetchGTKData(data.current_page - 1);
            });
            paginationContainer.appendChild(prevButton);
        }

        // Page Buttons
        const pageButton = document.createElement('button');
        pageButton.className = `join-item btn`;
        pageButton.textContent = `Page ${data.current_page}`;
        paginationContainer.appendChild(pageButton);

        // Next Button
        if (data.next_page_url) {
            const nextButton = document.createElement('button');
            nextButton.className = 'join-item btn';
            nextButton.textContent = '»'; // or you can use 'Next'
            nextButton.addEventListener('click', (event) => {
                event.preventDefault();
                fetchGTKData(data.current_page + 1);
            });
            paginationContainer.appendChild(nextButton);
        }

        paginationControls.appendChild(paginationContainer);
    }





    fetchGTKData(currentPage);
});
