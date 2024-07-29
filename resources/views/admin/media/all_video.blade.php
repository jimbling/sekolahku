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
                                    <h3 class="card-title">Daftar Galeri Video</h3>
                                </div>
                                <div class="col-md-4 text-right">
                                    <!-- Tombol Tambah -->
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                        data-target="#addVideos">
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
                            <table id="video-posts-table" class="table table-sm  table-striped table-hover"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center"><input type="checkbox" id="select-all"></th>
                                        <th>JUDUL VIDEO</th>
                                        <th>YOUTUBE VIDEO ID</th>
                                        <th>LINK YOUTUBE</th>
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
<div class="modal fade" data-backdrop="static" id="addVideos" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Video Dari Youtube</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('videos.store') }}" method="post" id="formTambahVideo">
                @csrf
                <div class="modal-body">
                    <!-- Input untuk nama file -->
                    <div class="form-group row">
                        <label for="post_title" class="col-sm-4 col-form-label">Judul Video</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" placeholder="Isikan judul video"
                                name="post_title" id="post_title" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="post_content" class="col-sm-4 col-form-label">Youtube Video ID</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" placeholder="Masukan youtube video id"
                                name="post_content" id="post_content" required>
                        </div>
                    </div>
                    <span>Masukkan youtube video ID, contoh : https://www.youtube.com/watch?v=<strong
                            style="color: red;">eN-Op7Mn2I4&t=578s</strong>
                        <p>ambil yang berwarna merah.
                    </span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>




<!-- Modal Edit Kategori -->
<div class="modal fade" id="editVideosModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data Video Youtube</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editVideos">
                @csrf
                @method('PUT')
                <input type="hidden" id="editId" name="id">
                <div class="modal-body">
                    <!-- Input untuk nama file -->
                    <div class="form-group row">
                        <label for="post_title" class="col-sm-4 col-form-label">Judul Video</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" placeholder="Isikan judul video"
                                name="post_title" id="editJudul" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="post_content" class="col-sm-4 col-form-label">Youtube Video ID</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" placeholder="Masukan youtube video id"
                                name="post_content" id="editUrl" required>
                        </div>
                    </div>
                    <span>Masukkan youtube video ID, contoh : https://www.youtube.com/watch?v=<strong
                            style="color: red;">eN-Op7Mn2I4&t=578s</strong>
                        <p>ambil yang berwarna merah.
                    </span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-sm btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<x-footer></x-footer>

<script>
    $('#video-posts-table').on('click', '.delete-btn', function() {
        var videosId = $(this).data('id');
        var token = '{{ csrf_token() }}';
        var deleteUrl = '{{ route('videos.destroy', ':id') }}'.replace(':id', videosId);

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
                                'Terjadi kesalahan saat menghapus video.',
                                'error'
                            )
                        }
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'Terjadi kesalahan saat menghapus video.',
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

        $('#video-posts-table').DataTable({
            processing: false,
            serverSide: true,
            responsive: true,
            ordering: false,

            ajax: '{{ route('files.videos.data') }}',
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
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'content',
                    name: 'content'
                },
                {

                    data: 'content',
                    name: 'content',
                    render: function(data, type, row) {

                        const youtubeUrl = 'https://www.youtube.com/watch?v=' + data;


                        return '<a href="' + youtubeUrl +
                            '" target="_blank" class="text-blue-500 hover:underline">Tonton Video</a>';
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                }
            ],
            order: [
                [1, 'asc']
            ]
        });


        $('#select-all').on('change', function() {
            var isChecked = $(this).prop('checked');
            $('.row-select').prop('checked', isChecked);
        });
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
                            url: '/videos/delete-selected',
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
                                        'Terjadi kesalahan saat menghapus File.',
                                        'error'
                                    )
                                }
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Terjadi kesalahan saat menghapus File.',
                                    'error'
                                )
                            }
                        });
                    }
                });
            } else {

                Swal.fire(
                    'Info',
                    'Pilih setidaknya satu Data Video untuk dihapus.',
                    'info'
                )
            }
        });
    });
</script>

<script>
    $(document).ready(function() {

        $('#video-posts-table').on('click', '.edit-btn', function() {
            var id = $(this).data('id');


            $.ajax({
                url: '/videos/' + id + '/fetch',
                type: 'GET',
                success: function(response) {
                    $('#editId').val(response.id);
                    $('#editJudul').val(response.title);
                    $('#editUrl').val(response.content);


                    $('#editVideosModal').modal('show');
                },
                error: function(xhr) {
                    console.log('Error:', xhr);
                }
            });
        });


        $('#editVideos').submit(function(e) {
            e.preventDefault();

            var id = $('#editId').val();
            var formData = new FormData(this);

            $.ajax({
                url: '/videos/' + id + '/update',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#editVideosModal').modal('hide');
                    $('#video-posts-table').DataTable().ajax.reload();
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


        $(document).on('submit', '#formTambahVideo', function(e) {
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

                    setTimeout(function() {
                            window.location.href = response.redirect;
                        },
                        2000
                    );
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
