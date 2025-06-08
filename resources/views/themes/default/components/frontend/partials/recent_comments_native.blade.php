<section class="bg-base" data-aos="fade-right">
    <div class="container mx-auto px-4">
        <div class="text-left mb-8">
            <h2 class="text-3xl font-bold">
                <span class="text-gradient">Komentar Terbaru</span>
            </h2>
            <p class="text-gradient-light">
                Mari saling terhubung dan kita akan selalu mendapatkan informasi terbaru serta berbagi pandangan yang
                bermanfaat.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" data-aos="fade-up">
            @forelse ($comments as $comment)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col">
                    <div class="bg-gray-200 px-6 py-4">
                        <p class="text-sm text-gray-700">Komentar oleh</p>
                        <p class="font-semibold text-gray-900">
                            {{ $comment->user->name ?? ($comment->guest_name ?? 'Anonim') }}
                        </p>
                        <div class="text-sm text-gray-700">
                            {{ $comment->created_at->locale('id')->diffForHumans() }}
                        </div>
                    </div>
                    <div class="p-6 flex-grow">
                        <p class="text-gray-700">{{ strip_tags($comment->content) }}</p>
                    </div>
                    <div class="px-6 py-4 bg-gray-100 text-sm text-gray-600 flex justify-between items-center">
                        <span class="truncate">
                            Berkomentar pada:
                            @if ($comment->post)
                                <a href="{{ route('posts.show', ['id' => $comment->post->id, 'slug' => $comment->post->slug]) }}"
                                    class="text-blue-500 hover:text-blue-700 truncate block max-w-full">
                                    {{ $comment->post->title }}
                                </a>
                            @else
                                <span class="text-gray-400 italic">Postingan tidak ditemukan</span>
                            @endif
                        </span>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center">
                    <img src="{{ asset('storage/images/illustrasi/no-internet.png') }}" alt="No Comments" loading="lazy"
                        class="h-64 w-64 object-cover mx-auto mb-4">
                    <p class="text-gray-600 text-lg">Belum ada komentar tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
