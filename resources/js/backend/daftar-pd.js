// DAFTAR PESERTA DIDIK
document.addEventListener('DOMContentLoaded', () => {

    document.getElementById('filterButton').addEventListener('click', function() {
        let academicYear = document.getElementById('academic_year').value;
        let classroom = document.getElementById('classroom').value;

               fetch('/pd/filter', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Mengambil CSRF token dari meta tag
                },
                body: JSON.stringify({
                    academic_year: academicYear,
                    classroom: classroom
                })
            })
            .then(response => response.json())
            .then(data => {


                let cardsContainer = document.querySelector('#studentsCardsContainer');
                cardsContainer.innerHTML = '';


                let alertContainer = document.querySelector('#alertContainer');
                let alertMessage = document.querySelector('#alertMessage');

                let resultsFound = false;

                Object.values(data).forEach((student, index) => {
                    student.anggota_rombels.forEach(anggotaRombel => {
                        if ((!academicYear || anggotaRombel.rombel.academic_years_id == academicYear) &&
                            (!classroom || anggotaRombel.rombel.classroom_id == classroom)) {

                            resultsFound = true;

                            let card = document.createElement('div');

                            let classroomName = anggotaRombel.rombel.classroom.name;
                            let classroomNumber = classroomName.split(' ').pop();


                            let photoUrl;
                            if (student.photo) {
                                photoUrl = `/storage/${student.photo}`;
                            } else {
                                photoUrl = student.gender === 'M' ? '/storage/images/illustrasi/male.png' : '/storage/images/illustrasi/female.png'; // Gambar default dari folder storage
                            }


                            let genderLabel = student.gender === 'M' ? 'Laki-Laki' : 'Perempuan';

                            card.className = 'bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden flex flex-col'; // Flexbox dengan arah kolom
                            card.setAttribute('data-aos', 'fade-up');
                            card.setAttribute('data-aos-delay', `${index * 100}`);
                            card.innerHTML = `
                                <div class="p-4 flex flex-1 items-start"> <!-- Flex untuk konten -->
                                    <div class="flex-shrink-0">
                                        <img src="${photoUrl}" alt="${student.name}" class="w-24 h-42 object-cover rounded-md border border-gray-300">
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900">${student.name}</h3>
                                        <p class="mt-1 text-sm text-gray-500">No Induk Siswa: ${student.nis}</p>
                                        <p class="mt-2 text-sm text-gray-500">Tahun Pelajaran: ${anggotaRombel.rombel.academic_year.academic_year}</p>
                                        <p class="mt-1 text-sm text-gray-500">Kelas: ${classroomNumber}</p>
                                        <p class="mt-1 text-sm text-gray-500">Jenis Kelamin: ${genderLabel}</p> <!-- Label jenis kelamin -->
                                    </div>
                                </div>

                            `;
                            cardsContainer.appendChild(card);
                        }
                    });
                });


                // Menampilkan atau menyembunyikan alert berdasarkan hasil pencarian
                if (resultsFound) {
                    alertContainer.classList.add('hidden');
                } else {
                    alertMessage.textContent = 'Tidak ada hasil ditemukan.';
                    alertContainer.classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });

    // Event listener untuk tombol tutup alert
    document.getElementById('alertCloseButton').addEventListener('click', function() {
        document.getElementById('alertContainer').classList.add('hidden');
    });
});
