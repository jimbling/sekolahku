// DAFTAR PESERTA DIDIK
document.addEventListener('DOMContentLoaded', () => {
    const filterButton = document.getElementById('filterButton');
    const buttonText = document.getElementById('filterButtonText');
    const spinner = document.getElementById('loadingSpinner');
    const searchIcon = document.getElementById('searchIcon');
    const alertContainer = document.getElementById('alertContainer');
    const alertMessage = document.getElementById('alertMessage');
    const cardsContainer = document.getElementById('studentsCardsContainer');

    filterButton.addEventListener('click', function () {
        let academicYear = document.getElementById('academic_year').value;
        let classroom = document.getElementById('classroom').value;

        // Tampilkan loading spinner
        filterButton.disabled = true;
        buttonText.textContent = 'Memuat...';
        spinner.classList.remove('hidden');
        searchIcon.classList.add('hidden');

        fetch('/pd/filter', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                academic_year: academicYear,
                classroom: classroom
            })
        })
        .then(response => response.json())
        .then(data => {
            cardsContainer.innerHTML = '';
            let resultsFound = false;

            Object.values(data).forEach((student, index) => {
                student.anggota_rombels.forEach(anggotaRombel => {
                    if ((!academicYear || anggotaRombel.rombel.academic_years_id == academicYear) &&
                        (!classroom || anggotaRombel.rombel.classroom_id == classroom)) {

                        resultsFound = true;

                        let card = document.createElement('div');
                        let classroomName = anggotaRombel.rombel.classroom.name;
                        let classroomNumber = classroomName.split(' ').pop();

                        let photoUrl = student.photo
                            ? `/storage/${student.photo}`
                            : (student.gender === 'M'
                                ? '/storage/images/illustrasi/male.png'
                                : '/storage/images/illustrasi/female.png');

                        let genderLabel = student.gender === 'M' ? 'Laki-Laki' : 'Perempuan';

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
                                    <p class="mt-2 text-sm text-gray-500">Tahun Pelajaran: ${anggotaRombel.rombel.academic_year.academic_year}</p>
                                    <p class="mt-1 text-sm text-gray-500">Kelas: ${classroomNumber}</p>
                                    <p class="mt-1 text-sm text-gray-500">Jenis Kelamin: ${genderLabel}</p>
                                </div>
                            </div>
                        `;
                        cardsContainer.appendChild(card);
                    }
                });
            });

            if (resultsFound) {
                alertContainer.classList.add('hidden');
            } else {
                alertMessage.textContent = 'Tidak ada hasil ditemukan.';
                alertContainer.classList.remove('hidden');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alertMessage.textContent = 'Terjadi kesalahan saat memuat data.';
            alertContainer.classList.remove('hidden');
        })
        .finally(() => {
            // Sembunyikan spinner, aktifkan tombol kembali
            filterButton.disabled = false;
            buttonText.textContent = 'Tampilkan';
            spinner.classList.add('hidden');
            searchIcon.classList.remove('hidden');
        });
    });

    // Tutup alert
    document.getElementById('alertCloseButton').addEventListener('click', function () {
        alertContainer.classList.add('hidden');
    });
});
