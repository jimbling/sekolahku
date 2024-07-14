import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import AOS from 'aos';
import 'aos/dist/aos.css';

// Inisialisasi AOS
document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
        duration: 800, // Durasi animasi
        easing: 'ease-in-out', // Jenis easing
        once: false,
    });
});


