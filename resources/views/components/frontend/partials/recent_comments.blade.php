<section class="bg-base py-12" data-aos="fade-right">
    <div class="container mx-auto px-4">
        <div class="text-left mb-8">
            <h2 class="text-3xl font-bold">
                <span class="text-gradient">Komentar Terakhir</span>
            </h2>
            <p class="text-gradient-light">Mari saling terhubung dan kita akan selalu mendapatkan informasi
                terbaru serta berbagi pandangan yang bermanfaat.</p>

        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" data-aos="fade-up">
            @if (!empty($comments))
                @foreach ($comments as $comment)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col">
                        <div class="bg-gray-200 px-6 py-4">
                            <p class="text-sm text-gray-700">Komentar oleh</p>
                            <p class="font-semibold text-gray-900">{{ $comment['author']['name'] }}
                            <div class="text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($comment['createdAt'])->locale('id')->diffForHumans() }}
                            </div>
                        </div>
                        <div class="p-6 flex-grow">
                            <p class="text-gray-700">{{ strip_tags($comment['message']) }}</p>
                        </div>
                        <div class="px-6 py-4 bg-gray-100 text-sm text-gray-600 flex justify-between items-center">

                            <span class="truncate">
                                Berkomentar pada: <a href="{{ $comment['thread']['link'] }}"
                                    class="text-blue-500 hover:text-blue-700 truncate block max-w-full">{{ $comment['thread']['title'] }}</a>
                            </span>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-span-full text-center">
                    <p class="text-white">No recent comments available.</p>
                </div>
            @endif
        </div>

    </div>
</section>
