<x-header>{{ $judul }}</x-header>
<div class="content-wrapper">
    <x-breadcrumb>{{ $judul }}</x-breadcrumb>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <p><strong>Pengirim:</strong> {{ $message->name }} ({{ $message->email }})</p>
                            <p><strong>Isi Pesan:</strong></p>
                            <p>{{ $message->message }}</p>


                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4>Balasan Pesan</h4>
                            @if ($message->replies->isEmpty())
                                <p>Anda belum membalas pesan ini.</p>
                            @else
                                @foreach ($message->replies as $reply)
                                    <div class="reply">
                                        <p><strong>{{ $reply->reply_by }}:</strong></p>
                                        <p>{{ $reply->reply }}</p>
                                        <p><small>{{ $reply->created_at->format('d M Y, H:i') }}</small></p>
                                        <hr>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="card-footer">
                            <form action="{{ route('admin.messages.reply', $message->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="reply">Kirim Balasan</label>
                                    <textarea name="reply" id="reply" class="form-control" rows="4"></textarea>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary"><i class='fas fa-paper-plane'></i>
                                    Kirim Balasan</button>
                                <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-warning"><i
                                        class='fas fa-reply-all'></i> Kembali ke Pesan
                                    Masuk</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<x-footer></x-footer>
<script>
    $(document).ready(function() {
        // Cek jika ada pesan sukses atau error dari session
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @elseif (session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        // Cek jika ada error validasi dari Laravel
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    });
</script>
