<x-header>{{ $judul }}</x-header>
<div class="content-wrapper">
    <x-breadcrumb>{{ $judul }}</x-breadcrumb>

    <section class="content">
        <div class="container-fluid py-1">



            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="card-title">Atur foto Album: <strong>{{ $album->name }}</strong></h5>
                        </div>
                        <div class="col-md-4 text-right">
                            <!-- Tombol Kembali -->
                            <a href="{{ route('admin.photos.all') }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-reply"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>



                <div class="card-body">
                    @if ($images->isEmpty())
                        <div class="custom-alert" role="alert">
                            Tidak ada foto untuk ditampilkan.
                        </div>
                    @else
                        <div class="row">
                            @foreach ($images as $image)
                                <div class="col-md-3 mb-4">
                                    <div class="card">
                                        <div class="card-img-top-wrapper"
                                            style="width: 100%; height: 200px; overflow: hidden; position: relative;">
                                            <img src="{{ asset('storage/' . $image->path) }}"
                                                alt="{{ $image->alt_text }}"
                                                style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0;">
                                        </div>

                                        <div class="card-body shadow-md">
                                            <div class="d-flex justify-content-between">
                                                <button type="button" class="btn btn-sm btn-info"
                                                    data-image="{{ asset('storage/' . $image->path) }}"
                                                    onclick="showPreview(this)">Lihat Foto</button>
                                                <form action="{{ route('admin.images.hapus', $image->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Hapus
                                                        Foto</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>

            <!-- Preview Area -->
            <div id="previewArea" class="preview-modal">
                <div class="preview-content">
                    <span class="close-btn" onclick="closePreview()">&times;</span>
                    <img id="previewImage" src="" alt="Preview" style="max-width: 100%; height: auto;">
                </div>
            </div>

        </div>

    </section>
</div>


<x-footer></x-footer>
<script>
    function showPreview(button) {
        var imageUrl = button.getAttribute('data-image');
        var previewImage = document.getElementById('previewImage');
        var previewArea = document.getElementById('previewArea');

        previewImage.src = imageUrl;
        previewArea.style.display = 'block';
    }

    function closePreview() {
        var previewArea = document.getElementById('previewArea');
        previewArea.style.display = 'none';
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fungsi untuk konfirmasi penghapusan
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Mencegah pengiriman formulir secara langsung
                const form = this;

                Swal.fire({
                    title: 'Konfirmasi Penghapusan',
                    text: "Apakah Anda yakin ingin menghapus gambar ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Mengirim formulir jika pengguna mengonfirmasi
                    }
                });
            });
        });

        // Menampilkan notifikasi sukses jika ada di session
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                showConfirmButton: true,
                timer: 3000
            });
        @endif
    });
</script>
