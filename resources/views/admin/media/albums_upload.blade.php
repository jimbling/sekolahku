<x-header>{{ $judul }}</x-header>
<div class="content-wrapper">
    <x-breadcrumb>{{ $judul }}</x-breadcrumb>

    <section class="content">
        <div class="container-fluid py-1">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="card-title mb-0">Tambah foto untuk album: <strong>{{ $album->name }}</strong></h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('albums.upload.store', $album->id) }}" method="POST" id="upload-form"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="caption">Caption</label>
                                    <input type="text" name="caption" id="caption" class="form-control"
                                        placeholder="Masukkan caption">
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="alt_text">Alt Text</label>
                                    <input type="text" name="alt_text" id="alt_text" class="form-control"
                                        placeholder="Masukkan alt text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <div class="form-group">
                                    <label for="files">Foto</label>
                                    <div id="dropzone" class="dropzone dz-clickable">
                                        <div class="dz-message">Drag & Drop gambar di sini atau klik untuk memilih</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class='fas fa-cloud-upload-alt'></i> Unggah
                            Foto</button>
                        <a href="{{ route('photos.all') }}" class="btn btn-warning float-right">
                            <i class="fas fa-reply"></i> Kembali
                        </a>
                    </form>
                </div>
            </div>
        </div>



    </section>



</div>
<x-footer></x-footer>

<script>
    Dropzone.autoDiscover = false;

    const dropzone = new Dropzone('#dropzone', {
        url: "{{ route('albums.upload.store', $album->id) }}",
        addRemoveLinks: true,
        maxFilesize: 2, // Max file size in MB
        acceptedFiles: 'image/*',
        params: {
            _token: '{{ csrf_token() }}'
        },
        init: function() {
            this.on("addedfile", function(file) {
                // Optionally handle file added event
            });
            this.on("error", function(file, response) {
                // Optionally handle errors
            });
        }
    });

    // Override the default Dropzone behavior
    document.getElementById('upload-form').addEventListener('submit', function(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin mengupload gambar?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Upload!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Mengupload...',
                    text: 'Tunggu sebentar, sedang mengupload gambar.',
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                let formData = new FormData(this);

                Dropzone.forElement('#dropzone').getAcceptedFiles().forEach(function(file) {
                    formData.append('files[]', file);
                });

                fetch("{{ route('albums.upload.store', $album->id) }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(response => response.json()).then(data => {
                    Swal.fire({
                        title: 'Sukses!',
                        text: 'Gambar berhasil diupload.',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = "{{ route('photos.all') }}";
                    });
                }).catch(error => {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat mengupload gambar.',
                        icon: 'error'
                    });
                });
            }
        });
    });
</script>
