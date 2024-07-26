import './bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import AOS from 'aos';
import 'aos/dist/aos.css';


document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: false,
    });
});

// Preloader
document.addEventListener("DOMContentLoaded", function () {
    const preloader = document.querySelector('.preloader');
    const content = document.querySelector('.content');


    if (preloader) {
        window.addEventListener('load', function () {
            preloader.classList.add('hidden');
            if (content) {
                content.classList.remove('hidden');
            }
        });
    }
});

// HAMBURGER MENU
document.addEventListener('DOMContentLoaded', function() {
    const hamburgerMenu = document.getElementById('hamburger-menu');
    const mobileMenu = document.getElementById('mobile-menu');


    hamburgerMenu.addEventListener('click', function() {
        if (mobileMenu.classList.contains('-translate-x-full')) {
            mobileMenu.classList.remove('-translate-x-full');
            mobileMenu.classList.add('translate-x-0');
        } else {
            mobileMenu.classList.remove('translate-x-0');
            mobileMenu.classList.add('-translate-x-full');
        }
    });


    document.querySelectorAll('#mobile-menu .relative > button').forEach(button => {
        button.addEventListener('click', function() {
            const dropdown = this.nextElementSibling;
            dropdown.classList.toggle('hidden');
        });
    });


    document.addEventListener('click', function(event) {
        if (!event.target.closest('#mobile-menu')) {
            document.querySelectorAll('#mobile-menu .dropdown-menu').forEach(dropdown => {
                dropdown.classList.add('hidden');
            });
        }
    });
});














