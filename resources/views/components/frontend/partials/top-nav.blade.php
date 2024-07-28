<div class="top-nav transition-navbar">
    <section class="top-nav bg-blue-400 text-white px-16 py-1 flex flex-col md:flex-row justify-between items-center">
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
