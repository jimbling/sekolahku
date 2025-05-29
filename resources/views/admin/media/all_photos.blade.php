<x-header>{{ $judul }}</x-header>
<div class="content-wrapper">
    <x-breadcrumb>{{ $judul }}</x-breadcrumb>

    <section class="content">
        <div class="container-fluid">
            <div class="custom-alert" role="alert">
                Sebelum mengunggah foto untuk Galeri, silahkan persiapkan foto dengan ukuran 800x600 pixel, agar
                hasilnya
                rapi. Bisa memanfaatkan tools online seperti <a class="strong" href="https://bulkresizephotos.com/id">Bulk
                    Resize</a> , <a class="strong" href="https://www.canva.com/id_id/">Canva</a>, dan sejenisnya.
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h3 class="card-title">Daftar Galeri Foto</h3>
                                </div>
                                <div class="col-md-4 text-right">
                                    <!-- Tombol Tambah -->
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                        data-target="#addAlbum">
                                        <i class="fas fa-plus"></i> Tambah
                                    </button>
                                    <!-- Tombol Hapus -->
                                    <a href="#" class="btn btn-sm btn-danger ml-2" id="delete-selected">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="albums-table" class="table table-sm  table-striped table-hover"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center"><input type="checkbox" id="select-all"></th>
                                        <th>NAMA ALBUM</th>
                                        <th>KETERANGAN</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data akan dimasukkan oleh DataTables -->
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>

</div>

<!-- Modal -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="addAlbum" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Album</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('albums.store') }}" method="post" id="formTambahAlbum"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Input untuk nama file -->
                    <div class="form-group row">
                        <label for="photos_album" class="col-sm-4 col-form-label">Nama Album</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" placeholder="Tambahkan nama album...."
                                name="photos_album" id="photos_album">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="photos_keterangan" class="col-sm-4 col-form-label">Keterangan</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" placeholder="Tambahkan keterangan album...." name="photos_keterangan"
                                id="photos_keterangan"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="cover_photo" class="col-sm-4 col-form-label">Foto Sampul (opsional)</label>
                        <div class="col-sm-8">
                            <input type="file" class="form-control" name="cover_photo" id="cover_photo">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" data-backdrop="static" data-keyboard="false" id="editAlbumsModal" tabindex="-1"
    aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data File Unduhan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editAlbum">
                @csrf
                @method('PUT')
                <input type="hidden" id="editId" name="id">
                <div class="modal-body">
                    <!-- Input untuk nama file -->
                    <div class="form-group row">
                        <label for="photos_album" class="col-sm-4 col-form-label">Nama Album</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" placeholder="Tambahkan nama album...."
                                name="photos_album" id="photos_album_edit">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="photos_keterangan" class="col-sm-4 col-form-label">Keterangan</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" placeholder="Tambahkan keterangan album...." name="photos_keterangan"
                                id="photos_keterangan_edit"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="editPhoto" class="col-sm-4 col-form-label">Foto</label>
                        <div class="col-sm-8">
                            <!-- Menampilkan foto yang sudah ada -->
                            <div id="photoContainer">
                                <img id="photoPreview" src="" alt="Preview Foto" class="img-fluid mb-2"
                                    style="max-width: 100%; height: auto;">
                            </div>
                            <input class="form-control" type="text" id="editPhoto" name="cover_photo" readonly>
                            <small class="form-text text-muted">Path foto yang ada saat ini.</small>
                            <input class="form-control mt-2" type="file" name="cover_photo" id="uploadPhoto">
                            <small class="form-text text-muted">Pilih gambar untuk mengganti foto.</small>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>



<x-footer></x-footer>

<script>
    $('#albums-table').on('click', '.delete-btn', function() {
        var albumsId = $(this).data('id');
        var token = '{{ csrf_token() }}';
        var deleteUrl = '{{ route('albums.destroy', ':id') }}'.replace(':id', albumsId);


        Swal.fire({
            title: 'Hapus Album?',
            text: "Foto yang terkait akan ikut dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: deleteUrl,
                    type: 'DELETE',
                    data: {
                        _token: token
                    },
                    success: function(response) {
                        if (response.type === 'success') {
                            Swal.fire(
                                'Dihapus!',
                                response.message,
                                'success'
                            ).then(() => {

                                window.location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'Terjadi kesalahan saat menghapus kategori.',
                                'error'
                            )
                        }
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'Terjadi kesalahan saat menghapus kategori.',
                            'error'
                        )
                    }
                });
            }
        });
    });
</script>



<script>
    $(document).ready(function() {
        const baseUrl = $('meta[name="base-url"]').attr('content');
        $('#albums-table').DataTable({
            processing: false,
            serverSide: true,
            responsive: true,
            ordering: false,

            ajax: '{{ route('albums.data') }}',
            columns: [{

                    data: null,
                    render: function(data, type, full, meta) {
                        return meta.row +
                            1;
                    },
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
                {

                    data: 'id',
                    render: function(data, type, full, meta) {
                        return '<input type="checkbox" class="row-select" data-id="' + data +
                            '">';
                    },
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
                {

                    data: 'name',
                    name: 'name'
                },
                {

                    data: 'description',
                    name: 'description'
                },

                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-right'
                },
            ],
            order: [
                [1, 'asc']
            ]
        });
    });


    $('#select-all').on('change', function() {
        var isChecked = $(this).prop('checked');
        $('.row-select').prop('checked', isChecked);
    });
</script>

<script>
    $(document).ready(function() {

        $('#delete-selected').on('click', function() {
            var selectedIds = [];
            $('.row-select:checked').each(function() {
                selectedIds.push($(this).data('id'));
            });

            if (selectedIds.length > 0) {
                var token = '{{ csrf_token() }}';


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

                        $.ajax({
                            url: '/photos/albums/delete-selected',
                            type: 'POST',
                            data: {
                                _token: token,
                                ids: selectedIds
                            },
                            success: function(response) {
                                if (response.type === 'success') {
                                    Swal.fire(
                                        'Dihapus!',
                                        response.message,
                                        'success'
                                    ).then(() => {

                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'Terjadi kesalahan saat menghapus Album.',
                                        'error'
                                    )
                                }
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Terjadi kesalahan saat menghapus Album.',
                                    'error'
                                )
                            }
                        });
                    }
                });
            } else {

                Swal.fire(
                    'Info',
                    'Pilih setidaknya satu Album untuk dihapus.',
                    'info'
                )
            }
        });
    });
</script>

<script>
    $(document).ready(function() {

        $('#albums-table').on('click', '.edit-btn', function() {
            var id = $(this).data('id');
            $.ajax({
                url: '/photos/albums/' + id + '/fetch',
                type: 'GET',
                success: function(response) {
                    $('#editId').val(response.id);
                    $('#photos_album_edit').val(response.name);
                    $('#photos_keterangan_edit').val(response.description);
                    $('#editPhoto').val(response.cover_photo);


                    if (response.cover_photo) {
                        $('#photoPreview').attr('src',
                            '{{ asset('storage/') }}/' + response
                            .cover_photo);
                    } else {
                        $('#photoPreview').attr('src',
                            '');
                    }
                    $('#editAlbumsModal').modal('show');
                },
                error: function(xhr) {
                    console.log('Error:', xhr);
                }
            });
        });


        $('#editAlbum').submit(function(e) {
            e.preventDefault();

            var id = $('#editId').val();
            var formData = new FormData(this);
            $.ajax({
                url: '/photos/albums/' + id + '/update',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#editAlbumsModal').modal('hide');
                    $('#albums-table').DataTable().ajax.reload();
                    toastr.success(response.message);
                },
                error: function(xhr) {
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        toastr.error(value);
                    });
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function showToastr(message, type) {
            toastr[type](message, 'Sukses');
        }

        $(document).on('submit', '#formTambahAlbum', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var url = $(this).attr('action');

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {

                    showToastr(response.success, 'success');


                    window.location.href = response.redirect;
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    if (errors) {
                        toastr.error(errors.join('<br>'), 'Error');
                    }
                }
            });
        });

    });
</script>
