<!-- Stats Cards for Desktop (sudah kamu punya, tidak diubah) -->
<div class="container mx-auto px-2 -mt-32 relative z-20 hidden md:block" data-aos="fade-down">
    <div class="flex bg- justify-center -mt-32 relative z-20 max-w-5xl mx-auto">
        <div
            class="bg-purple-glossy text-white p-8 flex flex-col sm:flex-row items-center justify-between gap-6 w-full max-w-5xl transition-all duration-300">

            <!-- Left Content -->
            <div class="text-left max-w-sm">
                <h2 class="text-2xl sm:text-3xl font-bold mb-2">{{ get_setting('school_name') }}</h2>
                <p class="text-sm sm:text-base">{{ get_setting('tagline') }}</p>
            </div>

            <!-- Right Content (3 items) -->
            <div class="flex flex-wrap justify-center sm:justify-end gap-4">
                <!-- Cards seperti sebelumnya -->
                <div class="bg-transparent rounded-xl px-6 py-4 text-center cursor-pointer w-40 hover:bg-white/5 transition duration-300"
                    data-aos="zoom-in" data-aos-delay="100">
                    <div class="flex justify-center mb-2">
                        <x-heroicon-o-light-bulb class="w-8 h-8 text-yellow-300" />
                    </div>
                    <h4 class="font-semibold text-white text-sm mb-1">Creative Thinking</h4>
                    <span class="text-xs text-white/80">Learn more →</span>
                </div>

                <div class="bg-grad-career rounded-2xl px-6 py-5 text-center cursor-pointer w-40 shadow-xl hover:shadow-2xl transition-all duration-300 scale-105"
                    data-aos="zoom-in" data-aos-delay="200">
                    <div class="flex justify-center mb-2">
                        <x-heroicon-o-briefcase class="w-8 h-8 icon-yellow" />
                    </div>
                    <h4 class="font-semibold text-white text-sm mb-1">Career Planning</h4>
                    <span class="text-xs text-white/80">Learn more →</span>
                </div>


                <div class="bg-transparent rounded-xl px-6 py-4 text-center cursor-pointer w-40 hover:bg-white/5 transition duration-300"
                    data-aos="zoom-in" data-aos-delay="300">
                    <div class="flex justify-center mb-2">
                        <x-heroicon-o-megaphone class="w-8 h-8 text-yellow-300" />
                    </div>
                    <h4 class="font-semibold text-white text-sm mb-1">Public Speaking</h4>
                    <span class="text-xs text-white/80">Learn more →</span>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Stats Cards for Mobile - Compact 4 Columns -->
<div class="container mx-auto md:hidden mt-custom-neg-60 px-4 relative z-20">
    <div class="bg-grad-main text-white rounded-2xl shadow-2xl max-w-md mx-auto p-4 overflow-hidden relative"
        data-aos="fade-up" data-aos-duration="800">

        <!-- Background decorative elements -->
        <div class="absolute -top-20 -right-20 w-40 h-40 rounded-full bg-purple-700/20 blur-xl" data-aos="zoom-in"
            data-aos-delay="200"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 rounded-full bg-indigo-600/20 blur-xl" data-aos="zoom-in"
            data-aos-delay="300"></div>

        <!-- Header -->
        <div class="text-center mb-3 relative z-10" data-aos="fade-down" data-aos-delay="100">
            <h2 class="text-xl font-bold mb-1">{{ get_setting('school_name') }}</h2>
            <p class="text-xs text-white/80">{{ get_setting('tagline') }}</p>
        </div>

        <!-- 4 Column Compact Stats -->
        <div class="grid grid-cols-4 gap-2 text-center text-xs relative z-10" data-aos="zoom-in" data-aos-delay="200">
            <!-- Siswa -->
            <div class="p-2 bg-white/5 rounded-lg hover:bg-white/10 transition-all duration-300">
                <x-heroicon-o-user-group class="w-5 h-5 mx-auto mb-1 text-white" />
                <div class="font-semibold text-sm">60</div>
                <div class="text-white/70 text-[10px]">Siswa</div>
            </div>
            <!-- GTK -->
            <div class="p-2 bg-white/5 rounded-lg hover:bg-white/10 transition-all duration-300">
                <x-heroicon-o-academic-cap class="w-5 h-5 mx-auto mb-1 text-amber-300" />
                <div class="font-semibold text-sm">12</div>
                <div class="text-white/70 text-[10px]">GTK</div>
            </div>
            <!-- Alumni -->
            <div class="p-2 bg-white/5 rounded-lg hover:bg-white/10 transition-all duration-300">
                <x-heroicon-o-user class="w-5 h-5 mx-auto mb-1 text-white" />
                <div class="font-semibold text-sm">50</div>
                <div class="text-white/70 text-[10px]">Alumni</div>
            </div>
            <!-- Prestasi -->
            <div class="p-2 bg-white/5 rounded-lg hover:bg-white/10 transition-all duration-300">
                <x-heroicon-o-star class="w-5 h-5 mx-auto mb-1 text-yellow-300" />
                <div class="font-semibold text-sm">100+</div>
                <div class="text-white/70 text-[10px]">Prestasi</div>
            </div>
        </div>
    </div>
</div>
