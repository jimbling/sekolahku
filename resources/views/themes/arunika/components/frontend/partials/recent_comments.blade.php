<div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
    <!-- Section Header -->
    <div class="text-center mb-16" data-aos="fade-up" data-aos-delay="100">
        <span class="inline-block mb-4 text-sm font-semibold tracking-wider text-blue-600 uppercase">Diskusi
            Terkini</span>
        <h2 class="text-4xl font-bold text-gray-900 mb-4">
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-500 to-teal-500">Komentar
                Terbaru</span>
        </h2>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
            Mari saling terhubung dan berbagi pandangan yang bermanfaat dalam komunitas kami.
        </p>
    </div>

    <!-- Comments Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" data-aos="fade-up" data-aos-delay="200">
        @if (!empty($comments))
            @if (isset($comments['error']))
                <!-- Error State -->
                <div class="col-span-full" data-aos="zoom-in">
                    <div class="text-center p-8 rounded-xl bg-white shadow-lg border border-red-100">
                        <div class="inline-flex items-center justify-center w-24 h-24 bg-red-50 rounded-full mb-6">
                            <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Data Tidak Ditemukan</h3>
                        <p class="text-gray-600">{{ $comments['error'] }}</p>
                    </div>
                </div>
            @else
                <!-- Comments List -->
                @foreach ($comments as $comment)
                    <div class="group" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 + 300 }}">
                        <div
                            class="h-full flex flex-col bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-200 overflow-hidden transform group-hover:-translate-y-1">
                            <!-- Comment Header -->
                            <div class="px-6 py-5 bg-gradient-to-r from-blue-100 to-teal-100 border-b border-gray-200">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-12 h-12 rounded-full bg-white border-2 border-white shadow-sm flex items-center justify-center text-blue-600 font-bold bg-gradient-to-r from-blue-50 to-teal-50">
                                            {{ substr($comment['author']['name'], 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 truncate">
                                            {{ $comment['author']['name'] }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ \Carbon\Carbon::parse($comment['createdAt'])->locale('id')->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Comment Body -->
                            <div class="p-6 flex-grow bg-white">
                                <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed">
                                    {{ strip_tags($comment['message']) }}
                                </div>
                            </div>

                            <!-- Comment Footer -->
                            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2 text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                            </path>
                                        </svg>
                                        <span class="text-xs font-medium">Berkomentar pada:</span>
                                    </div>
                                    <a href="{{ $comment['thread']['link'] }}"
                                        class="text-xs font-medium text-blue-600 hover:text-blue-800 truncate max-w-xs hover:underline"
                                        title="{{ $comment['thread']['title'] }}">
                                        {{ Str::limit($comment['thread']['title'], 40) }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        @else
            <!-- Empty State -->
            <div class="col-span-full" data-aos="fade-up">
                <div class="text-center p-12 bg-white rounded-xl shadow-md border border-gray-200">
                    <div
                        class="mx-auto w-48 h-48 bg-gray-50 rounded-full flex items-center justify-center mb-6 border-2 border-dashed border-gray-300">
                        <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Komentar</h3>
                    <p class="text-gray-600 max-w-md mx-auto">Jadilah yang pertama memberikan komentar dan memulai
                        diskusi menarik</p>
                </div>
            </div>
        @endif
    </div>
</div>
