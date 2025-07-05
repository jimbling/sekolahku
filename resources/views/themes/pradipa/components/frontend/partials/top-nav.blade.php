<div class="top-nav transition-navbar">
    <section class="top-nav bg-blue-800 text-white px-16 py-1 flex flex-col md:flex-row justify-between items-center">
        <!-- Left Section: School Name -->
        <div class="hidden md:flex flex-1 md:flex-none text-left">
            <span class="font-semibold">{{ get_setting('school_name') }}</span>
        </div>
        <!-- Right Section: Address and Email -->
        <div class="hidden md:flex flex-1 md:flex-none text-right space-x-4">
            <span class="font-semibold">{{ get_setting('sub_village') }},
                {{ get_setting('rt') }}/{{ get_setting('rw') }},
                {{ get_setting('village') }},
                {{ get_setting('sub_district') }},
                {{ get_setting('district') }},
                {{ get_setting('postal_code') }}</span>
        </div>
        <!-- Mobile Content: Centered Text -->
        <div class="md:hidden flex flex-col items-center justify-center">
            <span class="font-semibold">Website Pendidikan</span>
        </div>
    </section>
</div>


{{-- <div class="bg-dark text-white py-2 px-4">
    <div class="container mx-auto flex justify-between items-center">
        <div class="flex space-x-4 text-sm">
            <a href="#" class="hover:text-accent"><i class="fas fa-phone-alt mr-1"></i> (021) 1234-5678</a>
            <a href="#" class="hover:text-accent"><i class="fas fa-envelope mr-1"></i>
                info@prestigeacademy.edu</a>
        </div>
        <div class="flex space-x-3">
            <a href="#" class="hover:text-accent"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="hover:text-accent"><i class="fab fa-instagram"></i></a>
            <a href="#" class="hover:text-accent"><i class="fab fa-youtube"></i></a>
            <a href="#" class="hover:text-accent"><i class="fab fa-twitter"></i></a>
        </div>
    </div>
</div> --}}
