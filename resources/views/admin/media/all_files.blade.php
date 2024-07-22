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
                                    <h3 class="card-title">Daftar File Unduhan</h3>
                                </div>
                                <div class="col-md-4 text-right">
                                    <!-- Tombol Tambah -->
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                        data-target="#addFile">
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
                            <table id="files-table" class="table table-sm  table-striped table-hover"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center"><input type="checkbox" id="select-all"></th>
                                        <th>NAMA FILES</th>
                                        <th>KATEGORI</th>
                                        <th>UKURAN</th>
                                        <th>TYPE</th>
                                        <th>DI UNDUH</th>
                                        <th>STATUS FILE</th>
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
<div class="modal fade" data-backdrop="static" id="addFile" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data File Unduhan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('files.store') }}" method="post" id="formTambahFile" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Input untuk nama file -->
                    <div class="form-group row">
                        <label for="file_nama" class="col-sm-4 col-form-label">Nama File</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" placeholder="Tambahkan nama file...."
                                name="file_nama" id="file_nama" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="file_keterangan" class="col-sm-4 col-form-label">Keterangan</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" placeholder="Tambahkan keterangan file...."
                                name="file_keterangan" id="file_keterangan" required>
                        </div>
                    </div>

                    <!-- Input untuk kategori file -->
                    <div class="form-group row">
                        <label for="file_kategori" class="col-sm-4 col-form-label">Kategori</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="file_kategori" id="file_kategori" required>
                                <option value="">Pilih Kategori File</option>
                                @foreach ($kategori as $daftar_kategori)
                                    <option value="{{ $daftar_kategori->id }}">{{ $daftar_kategori->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Input untuk upload file -->
                    <div class="form-group row">
                        <label for="file" class="col-sm-4 col-form-label">Upload File</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="file" name="file" id="file" required>
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




<!-- Modal Edit Kategori -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data File Unduhan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editFiles">
                @csrf
                @method('PUT')
                <input type="hidden" id="editId" name="id">
                <div class="modal-body">
                    <!-- Input untuk nama file -->
                    <div class="form-group row">
                        <label for="file_nama" class="col-sm-4 col-form-label">Nama File</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" placeholder="Tambahkan nama file...."
                                name="file_nama" id="edit_file_nama" required>
                        </div>
                    </div>

                    <!-- Input untuk keterangan file -->
                    <div class="form-group row">
                        <label for="file_keterangan" class="col-sm-4 col-form-label">Keterangan</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" placeholder="Tambahkan keterangan file...."
                                name="file_keterangan" id="edit_file_keterangan" required>
                        </div>
                    </div>

                    <!-- Input untuk kategori file -->
                    <div class="form-group row">
                        <label for="file_kategori" class="col-sm-4 col-form-label">Kategori</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="file_kategori" id="edit_file_kategori" required>
                                <option value="">Pilih Kategori File</option>
                                @foreach ($kategori as $daftar_kategori)
                                    <option value="{{ $daftar_kategori->id }}">{{ $daftar_kategori->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Input untuk status file -->
                    <div class="form-group row">
                        <label for="file_status" class="col-sm-4 col-form-label">Status File</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="file_status" id="edit_file_status" required>
                                <option value="public">Public</option>
                                <option value="private">Private</option>
                            </select>
                        </div>
                    </div>

                    <!-- Menampilkan nama file yang ada -->
                    <div class="form-group row">
                        <label for="existing_file_name" class="col-sm-4 col-form-label">Nama File Saat Ini</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" id="existing_file_name" disabled>
                        </div>
                    </div>

                    <!-- Input untuk upload file baru -->
                    <div class="form-group row">
                        <label for="file" class="col-sm-4 col-form-label">Upload File Baru</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="file" name="file" id="edit_file">
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
{{-- <script src="{{ asset('lte/dist/js/backend/tags.js') }}"></script> --}}
<script>
    $('#files-table').on('click', '.delete-btn', function() {
        var filesId = $(this).data('id');
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
                    url: `/files/${filesId}`,
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
    // Helper function untuk mengonversi ukuran file
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    $(document).ready(function() {

        // Ambil base URL dari meta tag
        const baseUrl = $('meta[name="base-url"]').attr('content');

        // Inisialisasi DataTables
        $('#files-table').DataTable({
            processing: false,
            serverSide: true,
            responsive: true,
            ordering: false,

            ajax: {
                url: `${baseUrl}/files/data`, // Gunakan base URL untuk membangun URL rute
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
                    data: 'file_title',
                    name: 'file_title'
                },
                {
                    // Kolom Kategori
                    data: 'category_name',
                    name: 'category_name'
                },
                {
                    // Kolom Ukuran File
                    data: 'file_size',
                    name: 'file_size',
                    render: function(data, type, full, meta) {
                        return formatFileSize(
                            data); // Panggil helper function untuk mengonversi ukuran file
                    }
                },
                {
                    // Kolom Ekstensi File
                    data: 'file_ext',
                    name: 'file_ext'
                },
                {
                    // Kolom Jumlah Download
                    data: 'file_counter',
                    name: 'file_counter'
                },
                {
                    // Kolom Jumlah Download
                    data: 'file_status',
                    name: 'file_status'
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
                            url: '/files/delete-selected',
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
                // Jika tidak ada checkbox yang dipilih
                Swal.fire(
                    'Info',
                    'Pilih setidaknya satu File untuk dihapus.',
                    'info'
                )
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Tampilkan modal edit ketika tombol edit diklik
        $('#files-table').on('click', '.edit-btn', function() {
            var id = $(this).data('id');

            // Ambil data GTK berdasarkan ID menggunakan AJAX
            $.ajax({
                url: '/files/' + id + '/fetch',
                type: 'GET',
                success: function(response) {
                    $('#editId').val(response.id);
                    $('#edit_file_nama').val(response.file_title);
                    $('#edit_file_keterangan').val(response.file_description);
                    $('#edit_file_kategori').val(response.file_kategori);
                    $('#existing_file_name').val(response.file_name);
                    $('#edit_file_status').val(response.file_status);


                    $('#editModal').modal('show');
                },
                error: function(xhr) {
                    console.log('Error:', xhr);
                }
            });
        });

        // Submit form edit GTK
        $('#editFiles').submit(function(e) {
            e.preventDefault();

            var id = $('#editId').val();
            var formData = new FormData(this);

            // Kirim permintaan AJAX untuk menyimpan perubahan
            $.ajax({
                url: '/files/' + id + '/update',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#editModal').modal('hide');
                    $('#files-table').DataTable().ajax.reload();
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

        // Fungsi untuk menampilkan pesan toastr
        function showToastr(message, type) {
            toastr[type](message, 'Sukses');
        }

        // Ajax request untuk menangani respons JSON
        $(document).on('submit', '#formTambahFile', function(e) {
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
                    // Tampilkan pesan toastr
                    showToastr(response.success, 'success');

                    // Redirect ke halaman yang ditentukan
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
