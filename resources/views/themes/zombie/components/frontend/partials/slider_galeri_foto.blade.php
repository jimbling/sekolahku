<div class="max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
    <!-- Left Column - Information -->
    <div class="space-y-6" data-aos="fade-right">
        <h2 class="text-3xl font-bold text-gray-900">
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-purple-600">
                Galeri Foto Sekolah
            </span>
        </h2>
        <p class="text-md text-gray-600">
            Dokumentasi kegiatan dan momen berharga di lingkungan sekolah kami. Setiap gambar menceritakan kisah
            unik tentang komunitas belajar kami.
        </p>
        <div class="flex space-x-4">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                {{ $totalPhotos }} Foto
            </span>
            <span
                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                {{ $totalAlbums }} Album
            </span>
        </div>
        <button
            class="mt-4 px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            Lihat Semua Galeri Foto
        </button>
    </div>

    <!-- Middle Column - Photo Display -->
    <div class="relative h-96" data-aos="fade-up">
        <div class="gallery-container relative w-full h-full">
            @forelse ($galleryImages as $index => $image)
                <div class="gallery-item absolute inset-0 transition-all duration-700 ease-[cubic-bezier(0.33,1,0.68,1)]"
                    data-index="{{ $index }}"
                    style="z-index: {{ $index === 0 ? 10 : $index }};
                                transform: {{ $index % 2 === 0 ? 'rotate(3deg)' : 'rotate(-5deg)' }};">
                    <img class="w-full h-full object-cover rounded-xl shadow-2xl border-4 border-white"
                        src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->caption }}" loading="lazy">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent rounded-xl flex items-end p-4 opacity-0 transition-opacity duration-300">
                        <div class="text-white">
                            <h3 class="font-bold">{{ $image->title ?? 'Momen Sekolah' }}</h3>
                            <p class="text-sm">{{ $image->caption ?? '' }}</p>
                        </div>
                    </div>
                </div>
            @empty
                @for ($i = 1; $i <= 6; $i++)
                    <div class="gallery-item absolute inset-0 transition-all duration-700 ease-[cubic-bezier(0.33,1,0.68,1)] flex justify-center items-center"
                        data-index="{{ $index }}"
                        style="z-index: {{ $index === 0 ? 10 : $index }};
            transform: {{ $index % 2 === 0 ? 'rotate(3deg)' : 'rotate(-5deg)' }};">

                        <div class="w-[300px] h-[300px] relative">
                            <img class="w-full h-full object-cover rounded-xl shadow-2xl border-4 border-white"
                                src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->caption }}"
                                loading="lazy">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent rounded-xl flex items-end p-4 opacity-0 transition-opacity duration-300">
                                <div class="text-white">
                                    <h3 class="font-bold">{{ $image->title ?? 'Momen Sekolah' }}</h3>
                                    <p class="text-sm">{{ $image->caption ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

        </div>
        @endfor
        @endforelse
    </div>
</div>

<!-- Right Column - Navigation -->
<div class="flex flex-col items-center space-y-8" data-aos="fade-left">
    <div class="text-center">
        <p class="text-gray-500 mb-2">Jelajahi Galeri</p>
        <h3 class="text-2xl font-semibold text-gray-800">Dokumentasi Kami</h3>
    </div>

    <div class="flex space-x-4">
        <button
            class="gallery-prev w-14 h-14 rounded-full bg-white shadow-lg flex items-center justify-center text-blue-600 hover:bg-blue-50 transition-all duration-300 transform hover:-translate-x-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <button
            class="gallery-next w-14 h-14 rounded-full bg-white shadow-lg flex items-center justify-center text-blue-600 hover:bg-blue-50 transition-all duration-300 transform hover:translate-x-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>

    <div class="text-center">
        <p class="text-gray-500">Foto <span class="gallery-counter font-bold text-blue-600">1</span>/<span
                class="gallery-total font-medium text-gray-600">{{ count($galleryImages) > 0 ? count($galleryImages) : 6 }}</span>
        </p>
    </div>
</div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const galleryItems = document.querySelectorAll('.gallery-item');
        const prevBtn = document.querySelector('.gallery-prev');
        const nextBtn = document.querySelector('.gallery-next');
        const counter = document.querySelector('.gallery-counter');
        const total = document.querySelector('.gallery-total');

        let currentIndex = 0;
        const totalItems = galleryItems.length;

        // Initialize gallery
        function initGallery() {
            galleryItems.forEach((item, index) => {
                if (index === 0) {
                    item.style.transform = 'rotate(0deg)';
                    item.querySelector('div').style.opacity = '1';
                } else {
                    item.style.transform = index % 2 === 0 ? 'rotate(8deg)' : 'rotate(-8deg)';
                    item.style.opacity = '0.7';
                    item.style.zIndex = totalItems - index;
                }
            });
        }

        // Update gallery display
        function updateGallery() {
            galleryItems.forEach((item, index) => {
                const itemIndex = parseInt(item.dataset.index);
                const newIndex = (itemIndex - currentIndex + totalItems) % totalItems;

                if (newIndex === 0) {
                    // Center item (focused)
                    item.style.transform = 'rotate(0deg)';
                    item.style.opacity = '1';
                    item.style.zIndex = '20';
                    item.querySelector('div').style.opacity = '1';
                } else if (newIndex === 1) {
                    // Next item (slightly rotated)
                    item.style.transform = (currentIndex % 2 === 0) ? 'rotate(8deg)' : 'rotate(-8deg)';
                    item.style.opacity = '0.9';
                    item.style.zIndex = '15';
                    item.querySelector('div').style.opacity = '0';
                } else {
                    // Other items (more rotated and faded)
                    const rotation = (currentIndex % 2 === 0) ? 'rotate(12deg)' : 'rotate(-12deg)';
                    item.style.transform = rotation;
                    item.style.opacity = '0';
                    item.style.zIndex = '5';
                    item.querySelector('div').style.opacity = '0';
                }

                // Animate the transition
                item.style.transition = 'all 0.7s cubic-bezier(0.33, 1, 0.68, 1)';
            });

            // Update counter
            counter.textContent = currentIndex + 1;
        }

        // Navigation functions
        function goToPrev() {
            currentIndex = (currentIndex - 1 + totalItems) % totalItems;
            updateGallery();
        }

        function goToNext() {
            currentIndex = (currentIndex + 1) % totalItems;
            updateGallery();
        }

        // Event listeners
        prevBtn.addEventListener('click', goToPrev);
        nextBtn.addEventListener('click', goToNext);

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft') goToPrev();
            if (e.key === 'ArrowRight') goToNext();
        });

        // Initialize
        initGallery();
    });
</script>
