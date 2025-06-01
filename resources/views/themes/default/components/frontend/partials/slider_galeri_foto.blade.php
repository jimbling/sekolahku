<section class="bg-base py-12" data-aos="fade">
    <div class="container mx-auto px-4">
        <div class="text-center mb-4">
            <h2 class="text-3xl font-bold">
                <span class="text-gradient">Galeri Foto</span>
            </h2>
        </div>

        <div class="slider center">
            @forelse ($galleryImages as $image)
                <div><img class="carousel-img" data-lazy="{{ asset('storage/' . $image->path) }}"
                        alt="{{ $image->caption }}">
                </div>
            @empty
                <div><img class="carousel-img" data_lazy="{{ '/storage/images/galeri-foto/1.jpg' }}" alt="Image 1">
                </div>
                <div><img class="carousel-img" data_lazy="{{ '/storage/images/galeri-foto/2.jpg' }}" alt="Image 2">
                </div>
                <div><img class="carousel-img" data_lazy="{{ '/storage/images/galeri-foto/3.jpg' }}" alt="Image 3">
                </div>
                <div><img class="carousel-img" data_lazy="{{ '/storage/images/galeri-foto/4.jpg' }}" alt="Image 4">
                </div>
                <div><img class="carousel-img" data_lazy="{{ '/storage/images/galeri-foto/5.jpg' }}" alt="Image 5">
                </div>
                <div><img class="carousel-img" data_lazy="{{ '/storage/images/galeri-foto/6.jpg' }}" alt="Image 6">
                </div>
                <div><img class="carousel-img" data_lazy="{{ '/storage/images/galeri-foto/7.jpg' }}" alt="Image 7">
                </div>
                <div><img class="carousel-img" data_lazy="{{ '/storage/images/galeri-foto/8.jpg' }}" alt="Image 8">
                </div>
                <div><img class="carousel-img" data_lazy="{{ '/storage/images/galeri-foto/9.jpg' }}" alt="Image 9">
                </div>
            @endforelse
        </div>
    </div>
</section>
