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
                                    <h3 class="card-title">Daftar Tags</h3>
                                </div>
                                <div class="col-md-4 text-right">
                                    <!-- Tombol Tambah -->
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                        data-target="#addTags">
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
                            <table id="tags-table" class="table table-sm  table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center"><input type="checkbox" id="select-all"></th>
                                        <th>TAG</th>
                                        <th>SLUG</th>
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
<div class="modal fade" id="addTags" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/tags/create" method="post" id="formTambahTag">
                @csrf
                <div class="modal-body">
                    <!-- Input untuk nama kategori -->
                    <div class="form-group">
                        <label for="tag_name_modal">Nama Tags</label>
                        <input class="form-control" type="text" placeholder="Tambahkan tag...." name="tag_name"
                            id="tag_name_modal" required>
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

<x-footer></x-footer>
{{-- <script src="{{ asset('lte/dist/js/backend/tags.js') }}"></script> --}}
<script>
    $('#tags-table').on('click', '.delete-btn', function() {
        var tagsId = $(this).data('id');
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
                    url: `/tags/${tagsId}`,
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

        // Fungsi Ajax untuk menangani validasi dan menampilkan pesan error
        $(document).ready(function() {
            // Fungsi Ajax untuk menangani validasi dan menampilkan pesan error
            $('#formTambahTag').submit(function(event) {
                event.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        toastr.success(response.message);
                        $('#addTag').modal('hide');
                        location.reload(); // Reload halaman setelah sukses
                    },
                    error: function(xhr) {
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            toastr.error(value);
                        });
                    }
                });
            });
        });
    });
</script>

<script>
    $(document).ready(function() {

        // Ambil base URL dari meta tag
        const baseUrl = $('meta[name="base-url"]').attr('content');

        // Inisialisasi DataTables
        $('#tags-table').DataTable({
            processing: false,
            serverSide: true,
            responsive: true,
            ordering: false,
            ajax: {
                url: `${baseUrl}/data-tags`, // Gunakan base URL untuk membangun URL rute
            },
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
                    data: 'name',
                    name: 'name'
                },
                {
                    // Kolom Author
                    data: 'slug',
                    name: 'slug'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
            ],
            order: [
                [1, 'asc']
            ]
        });
    });
    // Event listener untuk checkbox "Select All"
    $('#select-all').on('change', function() {
        var isChecked = $(this).prop('checked');
        $('.row-select').prop('checked', isChecked);
    });
</script>

<script>
    $(document).ready(function() {
        // Event listener untuk tombol Hapus Terpilih
        $('#delete-selected').on('click', function() {
            var selectedIds = [];
            $('.row-select:checked').each(function() {
                selectedIds.push($(this).data('id'));
            });

            if (selectedIds.length > 0) {
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
                        // Jika konfirmasi, lakukan permintaan AJAX untuk menghapus data terpilih
                        $.ajax({
                            url: '/tags/delete-selected',
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
                                        // Reload halaman setelah SweetAlert sukses muncul
                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'Terjadi kesalahan saat menghapus tags.',
                                        'error'
                                    )
                                }
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Terjadi kesalahan saat menghapus tags.',
                                    'error'
                                )
                            }
                        });
                    }
                });
            } else {
                // Jika tidak ada checkbox yang dipilih
                Swal.fire(
                    'Info',
                    'Pilih setidaknya satu tags untuk dihapus.',
                    'info'
                )
            }
        });
    });
</script>
