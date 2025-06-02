import './././bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import AOS from 'aos';
import 'aos/dist/aos.css';
import $ from 'jquery';
window.$ = $;
window.jQuery = $;

console.log('jQuery loaded:', !!window.$); // Harus menampilkan true

import 'slick-carousel/slick/slick.min.js';
import 'slick-carousel/slick/slick.css';
import 'slick-carousel/slick/slick-theme.css';


document.addEventListener('DOMContentLoaded', () => {
    $('.header-carousel').slick({
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear',
        autoplay: true,
        autoplaySpeed: 5000,
        lazyLoad: 'ondemand',
    });

    $('.slider').slick({
        centerMode: true,
        centerPadding: '0',
        slidesToShow: 3,
        infinite: true,
        focusOnSelect: true,
        lazyLoad: 'ondemand',
        autoplay: true,
        arrows: false,
    });

 // Inisialisasi AOS
 AOS.init({
    duration: 800,
    easing: 'ease-in-out',
    once: false,
});
// Refresh AOS after all elements have been loaded
window.addEventListener('load', function () {
    AOS.refresh();
});


    // Preloader
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

    // HAMBURGER MENU
    const hamburgerMenu = document.getElementById('hamburger-menu');
    const mobileMenu = document.getElementById('mobile-menu');
    if (hamburgerMenu) {
        hamburgerMenu.addEventListener('click', function() {
            mobileMenu.classList.toggle('-translate-x-full');
            mobileMenu.classList.toggle('translate-x-0');
        });
    }

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















