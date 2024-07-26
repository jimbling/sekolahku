<div class="top-nav transition-navbar">
    <section class="top-nav bg-blue-400 text-white px-16 py-1 flex flex-col md:flex-row justify-between items-center">
        <!-- Left Section: School Name -->
        <div class="hidden md:flex flex-1 md:flex-none text-left">
            <span class="font-semibold">{{ get_setting('school_name') }}</span>
        </div>
        <!-- Right Section: Address and Email -->
        <div class="hidden md:flex flex-1 md:flex-none text-right space-x-4">
            <span>Alamat Sekolah</span>
            <span>Email: <a href="mailto:info@sekolah.com" class="underline">info@sekolah.com</a></span>
        </div>
        <!-- Mobile Content: Centered Text -->
        <div class="md:hidden flex flex-col items-center justify-center">
            <span>Website Pendidikan</span>
        </div>
    </section>
</div>
