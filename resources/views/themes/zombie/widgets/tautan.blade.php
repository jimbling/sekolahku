<section id="tautan" class="bg-base" data-aos="fade-out">
    <div class="container mx-auto text-center">
        <div class="bg-white shadow-lg rounded-lg p-6 mb-4 max-w-2xl mx-auto">
            <div>
                <h2 class="text-lg text-left font-semibold mb-2">TAUTAN</h2>
                <div class="relative mb-8">
                    <div class="h-1 bg-gray-300 w-full absolute top-0 left-0"></div>
                    <div class="h-1 bg-blue-800 w-1/3 absolute top-0 left-0"></div>
                </div>

                <div class="space-y-2 text-left">
                    @foreach ($tautan as $index => $link)
                        <a href="{{ $link->link_url }}" target="{{ $link->link_target }}"
                            class="{{ $cardColors[$index % count($cardColors)] }} p-2 rounded-lg shadow hover:shadow-lg transition duration-300 flex items-center space-x-3 block">
                            <!-- Icon Link -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-700" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M10.59 13.41a1 1 0 0 0 1.41 0l5-5a1 1 0 0 0-1.41-1.41l-5 5a1 1 0 0 0 0 1.41zm10.31-4.72a6 6 0 0 0-8.49 0l-1.36 1.36a1 1 0 0 0 1.41 1.41l1.36-1.36a4 4 0 0 1 5.66 5.66l-2.5 2.5a4 4 0 0 1-5.66-5.66 1 1 0 0 0-1.41-1.41 6 6 0 0 0 8.49 8.49l2.5-2.5a6 6 0 0 0 0-8.49z" />
                            </svg>
                            <div>
                                <span class="text-md font-semibold">{{ $link->link_title }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
