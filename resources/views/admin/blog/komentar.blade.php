<x-header>{{ $judul }}</x-header>
<div class="content-wrapper">
    <x-breadcrumb>{{ $judul }}</x-breadcrumb>

    <section class="content">
        <div class="container-fluid">


            <!-- Control Panel -->
            <div class="card card-outline card-primary mb-4">
                <div class="card-header">
                    <h3 class="card-title">Kontrol Komentar</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <input type="text" id="comment-search" class="form-control" placeholder="Cari komentar...">
                            <div class="input-group-append">
                                <button class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-2">
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-outline-secondary active" data-filter="all">Semua</button>
                        <button type="button" class="btn btn-outline-success" data-filter="approved">Disetujui</button>
                        <button type="button" class="btn btn-outline-warning" data-filter="pending">Pending</button>
                        <button type="button" class="btn btn-outline-danger" data-filter="rejected">Ditolak</button>
                        <button type="button" class="btn btn-outline-dark" data-filter="trashed">Arsip</button>
                    </div>
                    <span class="badge badge-light ml-2" id="comment-count">{{ $comments->total() }} komentar</span>
                </div>
            </div>

            <!-- Comments List -->
            <div id="comments-container">
                @foreach ($comments as $comment)
                    <div class="card comment-card mb-3"
                        data-status="{{ $comment->trashed() ? 'trashed' : $comment->status ?? 'pending' }}"
                        data-id="{{ $comment->id }}">
                        <div class="card-header">
                            <div class="user-info">
                                <div class="user-avatar">
                                    @if (isset($comment->user))
                                        <img src="{{ $comment->user->avatar_url ?? asset('images/default-avatar.png') }}"
                                            alt="Avatar">
                                    @else
                                        <span
                                            class="avatar-initial">{{ strtoupper(substr($comment->guest_name, 0, 1)) }}</span>
                                    @endif
                                </div>
                                <div class="user-meta">
                                    <strong>{{ $comment->guest_name ?? $comment->user->name }}</strong>
                                    <small>{{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            <div class="comment-status">
                                <span
                                    class="badge
                                @if ($comment->trashed()) bg-dark
                                @elseif($comment->status === 'approved') bg-success
                                @elseif($comment->status === 'rejected') bg-danger
                                @else bg-warning @endif">
                                    {{ $comment->trashed() ? 'Diarsipkan' : $comment->status ?? 'Menunggu' }}
                                </span>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="comment-post-title mb-2">
                                <strong>Untuk postingan:</strong>
                                @if ($comment->post)
                                    <a href="{{ route('posts.show', ['id' => $comment->post->id, 'slug' => $comment->post->slug]) }}"
                                        target="_blank">
                                        {{ $comment->post->title }}
                                    </a>
                                @else
                                    <span class="text-muted">[Post tidak ditemukan]</span>
                                @endif
                            </div>

                            <div class="comment-content">
                                <p>{{ $comment->content }}</p>
                            </div>

                            <!-- Comment Actions -->
                            <div class="comment-actions mt-3">
                                <button class="btn btn-sm btn-outline-primary toggle-reply">
                                    <i class="fas fa-reply"></i> Balas
                                </button>

                                <div class="action-buttons">
                                    @if ($comment->trashed())
                                        <form class="d-inline"
                                            action="{{ route('blog.komentar.restore', $comment->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-undo"></i> Pulihkan
                                            </button>
                                        </form>
                                    @else
                                        @if ($comment->status !== 'approved')
                                            <form class="d-inline"
                                                action="{{ route('blog.komentar.approve', $comment->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT') {{-- penting --}}
                                                <button type="submit" class="btn btn-sm btn-outline-success">
                                                    <i class="fas fa-check"></i> Setujui
                                                </button>
                                            </form>
                                        @endif

                                        @if ($comment->status !== 'rejected')
                                            <form class="d-inline"
                                                action="{{ route('blog.komentar.reject', $comment->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-times"></i> Tolak
                                                </button>
                                            </form>
                                        @endif


                                        <form class="d-inline"
                                            action="{{ route('blog.komentar.destroy', $comment->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-archive"></i> Arsipkan
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            <!-- Reply Form -->
                            <div class="reply-form mt-3" style="display:none;">
                                <form action="{{ route('blog.komentar.reply', $comment->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <textarea name="content" rows="2" class="form-control" placeholder="Tulis balasan Anda..." required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fas fa-paper-plane"></i> Kirim Balasan
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary cancel-reply">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Replies Section -->
                            @if ($comment->replies->count() > 0)
                                <div class="replies-section mt-3">
                                    <div class="replies-header">
                                        <h6><i class="fas fa-comments"></i> Balasan ({{ $comment->replies->count() }})
                                        </h6>
                                    </div>
                                    <div class="replies-list">
                                        @foreach ($comment->replies as $reply)
                                            <div class="reply-item">
                                                <div class="user-info">
                                                    <div class="user-avatar small">
                                                        @if (isset($reply->user))
                                                            <img src="{{ $reply->user->avatar_url ?? asset('images/default-avatar.png') }}"
                                                                alt="Avatar">
                                                        @else
                                                            <span
                                                                class="avatar-initial">{{ strtoupper(substr($reply->guest_name, 0, 1)) }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="user-meta">
                                                        <strong>{{ $reply->guest_name ?? $reply->user->name }}</strong>
                                                        <small>{{ $reply->created_at->diffForHumans() }}</small>
                                                    </div>
                                                </div>
                                                <div class="reply-content">
                                                    <p>{{ $reply->content }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $comments->links() }}
            </div>
        </div>
    </section>
</div>
<x-footer></x-footer>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter comments
        document.querySelectorAll('[data-filter]').forEach(btn => {
            btn.addEventListener('click', function() {
                const filter = this.dataset.filter;

                // Update active button
                document.querySelectorAll('[data-filter]').forEach(b => {
                    b.classList.remove('active');
                });
                this.classList.add('active');

                // Filter comments
                document.querySelectorAll('.comment-card').forEach(card => {
                    if (filter === 'all') {
                        card.style.display = '';
                    } else {
                        card.style.display = card.dataset.status === filter ? '' :
                            'none';
                    }
                });

                // Update count
                const visibleCount = document.querySelectorAll('.comment-card[style=""]')
                    .length;
                document.getElementById('comment-count').textContent =
                    `${visibleCount} komentar`;
            });
        });

        // Search functionality
        document.getElementById('comment-search').addEventListener('input', function() {
            const term = this.value.toLowerCase();

            document.querySelectorAll('.comment-card').forEach(card => {
                const content = card.querySelector('.comment-content p').textContent
                    .toLowerCase();
                const author = card.querySelector('.user-meta strong').textContent
                    .toLowerCase();

                if (content.includes(term) || author.includes(term)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Toggle reply form
        document.querySelectorAll('.toggle-reply').forEach(btn => {
            btn.addEventListener('click', function() {
                const form = this.closest('.comment-actions').nextElementSibling;
                form.style.display = form.style.display === 'none' ? 'block' : 'none';
            });
        });

        // Cancel reply
        document.querySelectorAll('.cancel-reply').forEach(btn => {
            btn.addEventListener('click', function() {
                this.closest('.reply-form').style.display = 'none';
            });
        });
    });
</script>
