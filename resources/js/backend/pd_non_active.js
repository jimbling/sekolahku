document.addEventListener('DOMContentLoaded', () => {
    const loadingSkeleton = document.getElementById('loading-skeleton');
    const cardsContainer = document.getElementById('pd-non-aktif');
    const noDataAlert = document.getElementById('no-data-alert');

    fetch('/pd/nonaktif', { method: 'GET', headers: { 'Accept': 'application/json' } })
        .then(response => response.json())
        .then(data => {
            const dataArray = Array.isArray(data) ? data : Object.values(data);
            const groupedData = {};

            dataArray.forEach(student => {
                if (!groupedData[student.id]) {
                    groupedData[student.id] = { ...student, anggota_rombels: [] };
                }
                if (student.anggota_rombels) {
                    const anggotaRombels = Array.isArray(student.anggota_rombels) ? student.anggota_rombels : [student.anggota_rombels];
                    groupedData[student.id].anggota_rombels.push(...anggotaRombels);
                }
            });

            loadingSkeleton.classList.add('hidden');

            if (Object.keys(groupedData).length === 0) {
                noDataAlert.classList.remove('hidden');
            } else {
                noDataAlert.classList.add('hidden');
                cardsContainer.classList.remove('hidden');
                cardsContainer.innerHTML = '';

                Object.values(groupedData).forEach((student, index) => {
                    const uniqueRombels = [];
                    student.anggota_rombels.forEach(romb => {
                        if (!uniqueRombels.find(r => r.id === romb.id)) {
                            uniqueRombels.push(romb);
                        }
                    });

                    const formatDate = (dateString) => {
                        return new Date(dateString).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                    };

                    const photoUrl = student.photo ? `/storage/${student.photo}` : 
                        (student.gender === 'M' ? '/storage/images/illustrasi/male.png' : '/storage/images/illustrasi/female.png');

                    const alumniStatus = student.is_alumni === 1
                        ? `<span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Alumni</span>`
                        : `<span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Tidak Aktif</span>`;

                    const reason = student.reason || 'Tidak ada alasan';

                    let card = document.createElement('div');
                    card.className = `
                        bg-white border border-gray-100 rounded-2xl shadow-md hover:shadow-xl 
                        transition transform hover:-translate-y-1 duration-300 overflow-hidden flex flex-col`;

                    card.innerHTML = `
                        <div class="p-5 flex items-start">
                            <img src="${photoUrl}" alt="${student.name}" 
                                class="w-24 h-28 object-cover rounded-lg border border-gray-200 shadow-sm">
                            <div class="ml-4 flex-1">
                                <h3 class="text-lg font-semibold text-gray-900">${student.name}</h3>
                                <p class="text-sm text-gray-500">No Induk: <span class="font-medium">${student.nis}</span></p>
                                <p class="text-sm text-gray-500">Tanggal Keluar: <span class="font-medium">${formatDate(student.end_date)}</span></p>
                                <p class="text-sm text-gray-500">Alasan: <span class="font-medium">${reason}</span></p>
                                <div class="mt-2 space-x-2">
                                    ${alumniStatus}
                                    <span class="px-2 py-1 text-xs font-medium bg-orange-100 text-orange-700 rounded-full">
                                        Tahun: ${student.tahun_lulus}
                                    </span>
                                </div>
                               <p class="mt-2 text-sm text-gray-500 truncate max-w-[200px]"> ${student.email}</p>
                            </div>
                        </div>
                    `;
                    cardsContainer.appendChild(card);
                });
            }
        })
        .catch(error => console.error('Error:', error));
});
