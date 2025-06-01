<x-header>{{ $judul }}</x-header>
<div class="content-wrapper">
    <x-breadcrumb>{{ $judul }}</x-breadcrumb>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h3 class="card-title">Tautan</h3>
                                </div>
                                <div class="col-md-4 text-right">

                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                        data-target="#addTema">
                                        <i class="fas fa-plus"></i> Tambah
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="temaTable" class="table table-sm table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Tema</th>
                                        <th>Folder</th>
                                        <th>Tampilan</th>
                                        <th>Deskripsi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data akan dimuat oleh DataTables -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

</div>


<!-- Modal Upload Tema -->
<div class="modal fade" id="addTema" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload Tema Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('tema.upload.store') }}" method="post" id="formUploadTema"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label for="theme_name">Nama Tema (unik)</label>
                        <input type="text" name="theme_name" id="theme_name" class="form-control"
                            placeholder="contoh: dark-theme" required>
                    </div>

                    <div class="form-group">
                        <label for="display_name">Nama Tampilan</label>
                        <input type="text" name="display_name" id="display_name" class="form-control"
                            placeholder="contoh: Tema Gelap" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Deskripsi</label>
                        <textarea name="description" id="description" class="form-control" rows="3" placeholder="Deskripsikan tema..."></textarea>
                    </div>

                    <div class="form-group">
                        <label for="zip_file">Upload File Tema (.zip)</label>
                        <input type="file" name="theme_file" id="theme_file" class="form-control-file" accept=".zip"
                            required>

                        <small class="form-text text-muted">Hanya file .zip yang berisi tema yang valid.</small>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary btn-sm">Upload Tema</button>
                </div>
            </form>
        </div>
    </div>
</div>



<x-footer></x-footer>

<script src="{{ asset('lte/dist/js/backend/tema.js') }}"></script>

<script>
    $('#temaTable').on('click', '.delete-btn', function() {
        var temaId = $(this).data('id');
        var token = '{{ csrf_token() }}';
        var deleteUrl = '{{ route('tema.destroy', ':id') }}'.replace(':id', temaId);

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak akan dapat mengembalikan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {

                Swal.fire({
                    title: 'Sedang memproses...',
                    text: 'Mohon menunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: deleteUrl,
                    type: 'DELETE',
                    data: {
                        _token: token
                    },
                    success: function(response) {
                        Swal.close();
                        Swal.fire(
                            'Dihapus!',
                            response.message || 'Tema berhasil dihapus.',
                            'success'
                        ).then(() => {
                            // Reload datatable atau halaman
                            $('#temaTable').DataTable().ajax.reload();
                            // Kalau tidak pakai datatable, bisa pakai:
                            // window.location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.close();
                        let errorMsg = 'Terjadi kesalahan saat menghapus tema.';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMsg = xhr.responseJSON.error;
                        }
                        Swal.fire(
                            'Error!',
                            errorMsg,
                            'error'
                        );
                    }
                });
            }
        });
    });
</script>


<script>
    $(document).ready(function() {
        @if (Session::has('toastr'))
            let toastrData = {!! json_encode(Session::get('toastr')) !!};
            toastr.options = {
                progressBar: true,
                positionClass: 'toast-top-right',
                showDuration: 300,
                hideDuration: 1000,
                timeOut: 5000,
                extendedTimeOut: 1000,
                preventDuplicates: true,
                closeButton: true,
            };
            toastr[toastrData.type](toastrData.message);
        @endif


        $(document).ready(function() {

            $('#formUploadTema').submit(function(event) {
                event.preventDefault();

                let formData = new FormData(this); // <== penting

                let loadingToastr = toastr.info('Sedang memproses...',
                    'Mohon menunggu sebentar', {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        tapToDismiss: false,
                    });

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        toastr.success(response.message);
                        $('#addTema').modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        toastr.clear(); // Hapus loading toastr
                        if (xhr.responseJSON?.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                toastr.error(value);
                            });
                        } else {
                            toastr.error("Terjadi kesalahan saat mengupload tema.");
                        }
                    }
                });
            });

        });
    });
</script>
