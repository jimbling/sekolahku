<x-header>{{ $judul }}</x-header>
<div class="content-wrapper">
    <x-breadcrumb>{{ $judul }}</x-breadcrumb>

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h3 class="card-title">Daftar Posts</h3>
                                </div>
                                <div class="col-md-4 text-right">
                                    <!-- Tombol Tambah -->
                                    <a href="{{ route('admin.posts.create') }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus"></i> Tambah
                                    </a>
                                    <!-- Tombol Hapus -->
                                    <a href="#" class="btn btn-sm btn-danger ml-2" id="delete-selected">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="posts-table" class="table table-sm table-bordered table-striped table-hover"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center"><input type="checkbox" id="select-all"></th>
                                        <th>Judul</th>
                                        <th>Author</th>
                                        <th>Status</th>
                                        <th>Published At</th>
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

<div class="modal fade" id="editPublishedModal" tabindex="-1" role="dialog" aria-labelledby="editPublishedModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPublishedModalLabel">Edit Tanggal Publikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editPublishedForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="published_at">Tanggal Publikasi</label>
                        <input type="datetime-local" class="form-control" id="published_at" name="published_at">
                    </div>
                    <div id="loadingIndicator" class="text-center" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i> Memuat data...
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                        <i class='fas fa-times spaced-icon'></i> Batal</button>
                    <button type="button" class="btn btn-primary btn-sm" id="updatePublishedBtn"><i
                            class="fa fa-save spaced-icon"></i> Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="detailPostModal" tabindex="-1" role="dialog" aria-labelledby="detailPostModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailPostModalLabel">Detail Tulisan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="postContent"></div>
            </div>
        </div>
    </div>
</div>



<x-footer></x-footer>

<script>
    $(document).ready(function() {
        var table = $('#posts-table').DataTable({
            processing: false,
            serverSide: true,
            ordering: false,
            responsive: true,
            ajax: {
                url: routeVars.dataPostUrl,
            },
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
                    name: 'title',
                    render: function(data, type, full, meta) {
                        if (data.length > 80) {
                            return `<span title="${data}">${data.substring(0, 50)}...</span>`;
                        }
                        return `<span title="${data}">${data}</span>`;
                    }
                },
                {

                    data: 'author.name',
                    name: 'author.name'
                },
                {

                    data: 'status',
                    name: 'status',
                    render: function(data, type, full, meta) {
                        return data === 'Publish' ?
                            '<span class="badge bg-success">Publish</span>' :
                            '<span class="badge bg-secondary">Draft</span>';
                    }
                },
                {

                    data: 'published_at',
                    name: 'published_at'
                },
                {

                    data: null,
                    render: function(data, type, full, meta) {
                        return `
                        <div class="action-buttons">
                           <a href="/blog/posts/${data.id}/edit" class="btn btn-primary btn-xs edit-btn mt-1"><i class='fas fa-edit'></i></a>
                            <button class="btn btn-info btn-xs detail-btn mt-1" data-id="${data.id}"><i class='fa fa-eye'></i></button>
                            <button class="btn btn-warning btn-xs edit-published-btn mt-1" data-id="${data.id}"><i class='fas fa-calendar-alt'></i></button>
                            <button class="btn btn-danger btn-xs delete-btn mt-1" data-id="${data.id}"><i class='fas fa-trash-alt'></i></button>
                        </div>
                    `;
                    },
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                }
            ],
            createdRow: function(row, data, dataIndex) {

                $(row).find('td:eq(0)').addClass('text-center');
                $(row).find('td:eq(1)').addClass('text-center');
                $(row).find('.row-select').data('id', data
                    .id);
            },
            rowCallback: function(row, data) {

                $(row).find('.row-select').on('change', function() {
                    if ($(this).prop('checked')) {

                    } else {

                    }
                });
            }
        });


        $('#select-all').on('change', function() {
            var isChecked = $(this).prop('checked');
            $('.row-select').prop('checked', isChecked);
        });


        $(document).on('click', '.edit-published-btn', function() {
            var postId = $(this).data('id');

            $('#editPublishedModal').modal('show')
            $('#loadingIndicator').show();
            $('#published_at').hide();


            $.get('/blog/posts/' + postId + '/published_at', function(response) {

                $('#loadingIndicator').hide();
                $('#published_at').show();


                if (response.published_at) {
                    $('#published_at').val(response.published_at);
                } else {
                    toastr.error('Gagal mengambil data tanggal publikasi.');
                }
            }).fail(function() {

                $('#loadingIndicator').hide();
                toastr.error(
                    'Terjadi kesalahan saat mengambil data tanggal publikasi.');
            });


            $('#updatePublishedBtn').off('click').on('click', function() {
                var publishedAt = $('#published_at').val();
                var token = '{{ csrf_token() }}';

                $.ajax({
                    url: '/blog/posts/update-published/' + postId,
                    type: 'POST',
                    data: {
                        _token: token,
                        published_at: publishedAt
                    },
                    success: function(response) {
                        toastr.success(
                            'Tanggal publikasi berhasil diperbarui.'
                        );
                        $('#editPublishedModal').modal('hide');
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        toastr.error(
                            'Terjadi kesalahan saat memperbarui tanggal publikasi.'
                        );
                    }
                });
            });
        });





        $('#editPublishedForm').on('submit', function(e) {
            e.preventDefault();

            var postId = $('#post_id').val();
            var publishedAt = $('#published_at').val();
            var token = '{{ csrf_token() }}';


            $.ajax({
                url: '/blog/posts/update-published/' + postId,
                type: 'POST',
                data: {
                    _token: token,
                    published_at: publishedAt
                },
                success: function(response) {

                    toastr.success('Tanggal publikasi berhasil diperbarui.');
                    $('#editPublishedModal').modal('hide');
                    table.ajax.reload();
                },
                error: function(xhr) {

                    toastr.error('Terjadi kesalahan saat memperbarui tanggal publikasi.');
                }
            });
        });

        $(document).on('click', '.detail-btn', function() {
            var postId = $(this).data('id');
            $('#detailPostModal').modal('show');


            $.get('/blog/posts/' + postId + '/content', function(response) {
                $('#postContent').html(response.content);
            });
        });

    });
</script>


<script>
    $('#posts-table').on('click', '.delete-btn', function() {
        var postId = $(this).data('id');
        var token = '{{ csrf_token() }}';
        var deleteUrl = '{{ route('admin.posts.destroy', ':id') }}'.replace(':id', postId);

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
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'Terjadi kesalahan saat menghapus postingan.',
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
        $('#delete-selected').on('click', function() {
            var selectedIds = [];
            $('.row-select:checked').each(function() {
                selectedIds.push($(this).data('id'));
            });

            // Log id yang dipilih ke console
            console.log('ID yang dikirim:', selectedIds);

            if (selectedIds.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih setidaknya satu postingan',
                    text: 'Anda harus memilih minimal satu postingan untuk dihapus.',
                    confirmButtonText: 'OK',
                });
                return;
            }

            var token = '{{ csrf_token() }}';

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('admin.posts.deleteSelected') }}',
                        type: 'POST', // Gunakan POST
                        data: {
                            _token: token,
                            _method: 'DELETE', // Sertakan metode DELETE
                            ids: selectedIds, // Kirim array ID
                        },
                        success: function(response) {
                            if (response.type === 'success') {
                                Swal.fire('Dihapus!', response.message, 'success')
                                    .then(() => {
                                        window.location.reload();
                                    });
                            } else {
                                Swal.fire('Error!',
                                    'Terjadi kesalahan saat menghapus postingan.',
                                    'error');
                            }
                        },
                        error: function(xhr) {
                            Swal.fire('Error!',
                                'Terjadi kesalahan saat menghapus postingan.',
                                'error');
                        },
                    });
                }
            });
        });
        console.log('URL yang dikirim:', '{{ route('admin.posts.deleteSelected') }}');
    });
</script>

@if (Session::has('success'))
    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        toastr.success('{{ Session::get('success') }}');
    </script>
    {{ Session::forget('success') }}
@endif
