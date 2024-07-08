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
                                    <a href="{{ route('admin.pages.create') }}" class="btn btn-sm btn-primary">
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
                            <table id="pages-table" class="table table-sm table-bordered table-striped table-hover"
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

<div class="modal fade" id="detailPagesModal" tabindex="-1" role="dialog" aria-labelledby="detailPostModalLabel"
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
                <div id="pagesContent"></div>
            </div>
        </div>
    </div>
</div>



<x-footer></x-footer>

<script>
    $(document).ready(function() {
        var table = $('#pages-table').DataTable({
            processing: false,
            serverSide: true,
            ordering: false,
            responsive: true,
            ajax: '{{ route('admin.pages.data') }}',
            columns: [{
                    // Kolom No
                    data: null,
                    render: function(data, type, full, meta) {
                        return meta.row +
                            1; // Menggunakan meta.row untuk mendapatkan nomor urut
                    },
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
                {
                    // Kolom checkbox
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
                    // Kolom Judul
                    data: 'title',
                    name: 'title'
                },
                {
                    // Kolom Author
                    data: 'author.name',
                    name: 'author.name'
                },
                {
                    // Kolom Status
                    data: 'status',
                    name: 'status',
                    render: function(data, type, full, meta) {
                        return data === 'Publish' ?
                            '<span class="badge bg-success">Publish</span>' :
                            '<span class="badge bg-secondary">Draft</span>';
                    }
                },
                {
                    // Kolom Published At
                    data: 'published_at',
                    name: 'published_at'
                },
                {
                    // Kolom Aksi
                    data: null,
                    render: function(data, type, full, meta) {
                        return `
                        <div class="action-buttons">
                           <a href="/blog/pages/create/${data.id}" class="btn btn-primary btn-xs edit-btn mt-1"><i class='fas fa-edit'></i></a>
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
                // Tambahkan kelas CSS untuk kolom No dan checkbox
                $(row).find('td:eq(0)').addClass('text-center'); // Kolom No
                $(row).find('td:eq(1)').addClass('text-center'); // Kolom checkbox
                $(row).find('.row-select').data('id', data
                    .id); // Menyimpan ID dalam data attribute pada checkbox
            },
            rowCallback: function(row, data) {
                // Tambahkan event listener untuk checkbox pada setiap baris
                $(row).find('.row-select').on('change', function() {
                    if ($(this).prop('checked')) {
                        // Lakukan sesuatu ketika checkbox dicentang
                    } else {
                        // Lakukan sesuatu ketika checkbox tidak dicentang
                    }
                });
            }
        });

        // Event listener untuk checkbox "Select All"
        $('#select-all').on('change', function() {
            var isChecked = $(this).prop('checked');
            $('.row-select').prop('checked', isChecked);
        });

        // Event listener untuk klik tombol "Edit Tanggal"


        // Simpan perubahan ketika tombol "Simpan Perubahan" diklik
        $(document).on('click', '.edit-published-btn', function() {
            var postId = $(this).data('id');

            // Tampilkan modal
            $('#editPublishedModal').modal('show');

            // Tampilkan indikator loading
            $('#loadingIndicator').show();
            $('#published_at').hide();

            // Ambil data published_at dari server
            $.get('/blog/pages/' + postId + '/published_at', function(response) {
                // Sembunyikan indikator loading setelah data diterima
                $('#loadingIndicator').hide();
                $('#published_at').show();

                // Set nilai published_at ke dalam input modal
                if (response.published_at) {
                    $('#published_at').val(response.published_at);
                } else {
                    toastr.error('Gagal mengambil data tanggal publikasi.');
                }
            }).fail(function() {
                // Jika gagal, sembunyikan indikator loading dan tampilkan pesan error
                $('#loadingIndicator').hide();
                toastr.error(
                    'Terjadi kesalahan saat mengambil data tanggal publikasi.');
            });

            // Simpan perubahan ketika tombol "Simpan Perubahan" diklik
            $('#updatePublishedBtn').off('click').on('click', function() {
                var publishedAt = $('#published_at').val();
                var token = '{{ csrf_token() }}';

                $.ajax({
                    url: '/blog/pages/update-published/' + postId,
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





        // Event listener untuk submit form edit tanggal
        $('#editPublishedForm').on('submit', function(e) {
            e.preventDefault();

            var postId = $('#post_id').val();
            var publishedAt = $('#published_at').val();
            var token = '{{ csrf_token() }}';

            // Kirim permintaan AJAX untuk memperbarui tanggal published_at
            $.ajax({
                url: '/blog/pages/update-published/' + postId,
                type: 'POST',
                data: {
                    _token: token,
                    published_at: publishedAt
                },
                success: function(response) {
                    // Tampilkan pesan sukses, tutup modal, dan perbarui DataTable
                    toastr.success('Tanggal publikasi berhasil diperbarui.');
                    $('#editPublishedModal').modal('hide');
                    table.ajax.reload();
                },
                error: function(xhr) {
                    // Tampilkan pesan error jika terjadi kesalahan
                    toastr.error('Terjadi kesalahan saat memperbarui tanggal publikasi.');
                }
            });
        });

        $(document).on('click', '.detail-btn', function() {
            var postId = $(this).data('id');
            $('#detailPagesModal').modal('show');

            // Ambil data konten dari server
            $.get('/blog/pages/' + postId + '/content', function(response) {
                $('#pagesContent').html(response.content);
            });
        });

    });
</script>


<script>
    $('#pages-table').on('click', '.delete-btn', function() {
        var postId = $(this).data('id');
        var token = '{{ csrf_token() }}';
        console.log(postId)
        // Konfirmasi dengan SweetAlert
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
                // Jika konfirmasi, lakukan permintaan AJAX untuk menghapus data
                $.ajax({
                    url: `/blog/pages/${postId}`,
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
                                // Reload halaman setelah SweetAlert sukses muncul
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
        // Event handler untuk tombol "Hapus" di atas tabel
        $('#delete-selected').on('click', function() {
            var selectedIds = []; // Array untuk menyimpan ID yang dipilih

            // Loop untuk mendapatkan ID dari checkbox yang dipilih
            $('.row-select:checked').each(function() {
                selectedIds.push($(this).data('id'));
            });

            // Jika tidak ada checkbox yang dipilih
            if (selectedIds.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih setidaknya satu postingan',
                    text: 'Anda harus memilih minimal satu postingan untuk dihapus.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            var token = '{{ csrf_token() }}';

            // Konfirmasi dengan SweetAlert
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
                    // Jika konfirmasi, lakukan permintaan AJAX untuk menghapus data
                    $.ajax({
                        url: '{{ route('admin.pages.deleteSelected') }}', // Ganti dengan route yang sesuai
                        type: 'DELETE',
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
                                    // Reload halaman setelah SweetAlert sukses muncul
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    'Terjadi kesalahan saat menghapus postingan.',
                                    'error'
                                )
                            }
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'Terjadi kesalahan saat menghapus postingan.',
                                'error'
                            )
                        }
                    });
                }
            });
        });
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
    {{ Session::forget('success') }} <!-- Hapus session flash success setelah ditampilkan -->
@endif
