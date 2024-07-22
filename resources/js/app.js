import './bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import AOS from 'aos';
import 'aos/dist/aos.css';



// DAFTAR PESERTA DIDIK
document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: false,
    });
});


// DAFTAR PESERTA DIDIK
document.addEventListener('DOMContentLoaded', () => {
    AOS.init();


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




// MENAMPILKAN DATA ALUMNI
document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: false,
    });

    // Mengambil data tanpa filter
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



        let cardsContainer = document.querySelector('#pd-non-aktif');
        cardsContainer.innerHTML = '';

        Object.values(groupedData).forEach((student, index) => {
            // Mengelompokkan rombel_id untuk siswa
            const uniqueRombels = [];
            student.anggota_rombels.forEach(anggotaRombel => {
                if (!uniqueRombels.find(r => r.id === anggotaRombel.id)) {
                    uniqueRombels.push(anggotaRombel);
                }
            });

            // Membuat card
            let card = document.createElement('div');

           // Menampilkan nomor kelas (misalnya "1" dari "Kelas 1")
           const extractClassNumber = (name) => {
            const match = name.match(/Kelas (\d+)/);
            return match ? match[1] : name;
        };

        let classroomNames = student.is_active
            ? uniqueRombels.map(anggotaRombel => extractClassNumber(anggotaRombel.rombel.classroom.name)).join(', ')
            : 'Tidak Aktif';

            let photoUrl = student.photo ? `/storage/${student.photo}` : (student.gender === 'M' ? '/storage/images/illustrasi/male.png' : '/storage/images/illustrasi/female.png');

            // Format tanggal dengan toLocaleDateString
            const formatDate = (dateString) => {
                const options = { day: 'numeric', month: 'long', year: 'numeric' };
                return new Date(dateString).toLocaleDateString('id-ID', options);
            };

            // Badge dan alasan berdasarkan is_alumni
            let alumniStatus = student.is_alumni === 1
                ? `<span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Alumni</span>`
                : `<span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Tidak Aktif: ${student.reason || 'Tidak ada alasan'}</span>`;

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

// Preloader
document.addEventListener("DOMContentLoaded", function () {
    const preloader = document.querySelector('.preloader');
    window.addEventListener('load', function () {
        preloader.classList.add('hidden'); // Sembunyikan preloader setelah semua konten dimuat
        document.querySelector('.content').classList.remove('hidden'); // Tampilkan konten
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const topNav = document.querySelector('.top-nav');
    const nav = document.querySelector('.nav');

    window.addEventListener('scroll', function () {
        const scrollTop = window.scrollY;

        if (scrollTop > 100) { // Ganti nilai dengan jarak scroll yang diinginkan
            topNav.classList.add('scrolled');
            nav.classList.add('scrolled-enter');
            nav.classList.remove('scrolled-exit');
        } else {
            topNav.classList.remove('scrolled');
            nav.classList.add('scrolled-exit');
            nav.classList.remove('scrolled-enter');
        }
    });
});














