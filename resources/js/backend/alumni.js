document.addEventListener('DOMContentLoaded', () => {

    const loadingSkeleton = document.getElementById('loading-skeleton');
    const cardsContainer = document.getElementById('pd-non-aktif');

    // Menampilkan data
    fetch('/pd/nonaktif', {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        // Ubah objek menjadi array jika diperlukan
        const dataArray = Array.isArray(data) ? data : Object.values(data);

        // Kelompokkan data berdasarkan id siswa
        const groupedData = {};

        dataArray.forEach(student => {
            if (!groupedData[student.id]) {
                groupedData[student.id] = { ...student, anggota_rombels: [] };
            }

            // Menambahkan rombel_id ke siswa
            if (student.anggota_rombels) {
                const anggotaRombels = Array.isArray(student.anggota_rombels) ? student.anggota_rombels : [student.anggota_rombels];
                groupedData[student.id].anggota_rombels.push(...anggotaRombels);
            }
        });

        // Menyembunyikan skeleton dan menampilkan card
        loadingSkeleton.classList.add('hidden');
        cardsContainer.classList.remove('hidden');

        cardsContainer.innerHTML = '';

        Object.values(groupedData).forEach((student, index) => {
            const uniqueRombels = [];
            student.anggota_rombels.forEach(anggotaRombel => {
                if (!uniqueRombels.find(r => r.id === anggotaRombel.id)) {
                    uniqueRombels.push(anggotaRombel);
                }
            });

            let card = document.createElement('div');
            const extractClassNumber = (name) => {
                const match = name.match(/Kelas (\d+)/);
                return match ? match[1] : name;
            };

            let classroomNames = student.is_active
                ? uniqueRombels.map(anggotaRombel => extractClassNumber(anggotaRombel.rombel.classroom.name)).join(', ')
                : 'Tidak Aktif';

            let photoUrl = student.photo ? `/storage/${student.photo}` : (student.gender === 'M' ? '/storage/images/illustrasi/male.png' : '/storage/images/illustrasi/female.png');

            const formatDate = (dateString) => {
                const options = { day: 'numeric', month: 'long', year: 'numeric' };
                return new Date(dateString).toLocaleDateString('id-ID', options);
            };

            let alumniStatus = student.is_alumni === 1
                ? `<span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Alumni</span>`
                : `<span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Tidak Aktif: ${student.reason || 'Tidak ada alasan'}</span>`;

            card.className = 'bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden flex flex-col';
            card.setAttribute('data-aos', 'fade-up');
            card.setAttribute('data-aos-delay', `${index * 100}`);
            card.innerHTML = `
                <div class="p-4 flex flex-1 items-start">
                    <div class="flex-shrink-0">
                        <img src="${photoUrl}" alt="${student.name}" class="w-24 h-42 object-cover rounded-md border border-gray-300">
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-lg font-semibold text-gray-900">${student.name}</h3>
                        <p class="mt-1 text-sm text-gray-500">No Induk Siswa: ${student.nis}</p>
                        <p class="mt-1 text-sm text-gray-500">Tanggal Keluar: ${formatDate(student.end_date)}</p>
                        <p class="mt-1 text-sm text-gray-500">Alasan Keluar: ${student.reason}</p>
                        <p class="mt-1 text-sm text-gray-500">Status: ${alumniStatus}</p>
                        <p class="mt-1 text-sm text-gray-500">Kelas: ${classroomNames}</p>
                    </div>
                </div>
            `;
            cardsContainer.appendChild(card);
        });
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
