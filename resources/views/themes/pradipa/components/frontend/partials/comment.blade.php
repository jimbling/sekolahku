@php
    $author = $comment->user ? $comment->user->name : $comment->guest_name;
    $level = $level ?? 0;
    $marginLeft = min($level * 4, 16); // Limit maximum indentation
@endphp

<div class="relative" style="margin-left: {{ $marginLeft }}px">
    <div class="flex space-x-3 mb-4 group">
        {{-- Avatar --}}
        <div class="flex-shrink-0">
            <div
                class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center text-blue-600 font-medium">
                {{ substr($author, 0, 1) }}
            </div>
        </div>

        {{-- Comment Content --}}
        <div class="flex-1 min-w-0">
            <div
                class="bg-white p-4 rounded-xl shadow-xs border border-gray-100 hover:border-blue-100 transition-all duration-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-medium text-gray-900">{{ $author }}</p>
                        <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                    </div>
                    <button
                        class="reply-button text-sm text-blue-600 hover:text-blue-800 transition-colors duration-200 opacity-0 group-hover:opacity-100"
                        data-comment-id="{{ $comment->id }}">
                        Balas
                    </button>
                </div>
                <div class="mt-2 text-gray-700 prose prose-sm max-w-none">
                    {!! nl2br(e($comment->content)) !!}
                </div>
            </div>

            {{-- Reply Form (Hidden by default) --}}
            <div id="reply-form-{{ $comment->id }}" class="hidden mt-3 ml-10 animate-fadeIn">
                <form action="{{ route('comments.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $comment->post_id }}">
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">

                    @guest
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <input type="text" name="guest_name"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    placeholder="Nama Anda" required>
                            </div>
                            <div>
                                <input type="email" name="guest_email"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    placeholder="Email Anda" required>
                            </div>
                        </div>
                    @endguest

                    <div>
                        <textarea name="content" rows="2"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                            placeholder="Tulis balasan..." required></textarea>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="this.closest('.hidden').classList.add('hidden')"
                            class="px-3 py-1 text-sm text-gray-600 hover:text-gray-800 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-1 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                            Kirim Balasan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Replies --}}
    @if ($comment->replies->isNotEmpty())
        <div class="space-y-4 border-l-2 border-gray-100 pl-4 ml-10">
            @foreach ($comment->replies as $reply)
                @include('themes.' . getActiveTheme() . '.components.frontend.partials.comment', [
                    'comment' => $reply,
                    'level' => $level + 1,
                ])
            @endforeach
        </div>
    @endif
</div>
