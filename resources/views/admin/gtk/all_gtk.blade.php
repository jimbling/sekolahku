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
                                    <h3 class="card-title">Daftar Guru dan Tenaga Kependidikan</h3>
                                </div>
                                <div class="col-md-4 text-right">

                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                        data-target="#addGtk">
                                        <i class="fas fa-plus"></i> Tambah
                                    </button>

                                    <a href="#" class="btn btn-sm btn-danger ml-2" id="delete-selected">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="gtk-table" class="table table-sm  table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center"><input type="checkbox" id="select-all"></th>
                                        <th>NAMA</th>
                                        <th>JK</th>
                                        <th>STATUS INDUK</th>
                                        <th>STATUS GTK</th>
                                        <th>EMAIL</th>
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
<div class="modal fade" data-backdrop="static" id="addGtk" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data GTK</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('gtk.store') }}" method="post" id="formTambahGtk" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="form-group row">
                        <label for="gtk_nama_gtk" class="col-sm-4 col-form-label">Nama GTK</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" placeholder="Tambahkan nama GTK...."
                                name="gtk_name" id="gtk_nama_gtk" required>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="gtk_jk" class="col-sm-4 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="gtk_jk" id="gtk_jk" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="M">Laki-Laki</option>
                                <option value="F">Perempuan</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="gtk_status_induk" class="col-sm-4 col-form-label">Status Induk</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="gtk_status_induk" id="gtk_status_induk" required>
                                <option value="">Pilih Status Induk</option>
                                <option value="1">INDUK</option>
                                <option value="0">NON Induk</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="gtk_keaktifan" class="col-sm-4 col-form-label">Status GTK</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="gtk_keaktifan" id="gtk_keaktifan" required>
                                <option value="">Pilih Status Keaktifan</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Mutasi">Mutasi</option>
                                <option value="Pensiun">Pensiun</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="gtk_email" class="col-sm-4 col-form-label">Email GTK</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="email" placeholder="Tambahkan email GTK...."
                                name="gtk_email" id="gtk_email" required>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="gtk_foto" class="col-sm-4 col-form-label">Foto</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="file" name="gtk_foto" id="gtk_foto">
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

<!-- Modal untuk menampilkan foto -->
<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="photoModalImage" src="" alt="Foto GTK" class="img-fluid">
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data GTK</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="editId" name="id">
                    <!-- Input untuk nama GTK -->
                    <div class="form-group row">
                        <label for="gtk_nama_gtk" class="col-sm-4 col-form-label">Nama GTK</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" placeholder="Tambahkan nama GTK...."
                                name="gtk_name" id="editName" required>
                        </div>
                    </div>

                    <!-- Input untuk jenis kelamin -->
                    <div class="form-group row">
                        <label for="gtk_jk" class="col-sm-4 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="gtk_jk" id="editJk" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="M">Laki-Laki</option>
                                <option value="F">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Input untuk status induk -->
                    <div class="form-group row">
                        <label for="gtk_status_induk" class="col-sm-4 col-form-label">Status Induk</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="gtk_status_induk" id="editInduk" required>
                                <option value="">Pilih Status Induk</option>
                                <option value="1">INDUK</option>
                                <option value="0">NON Induk</option>
                            </select>
                        </div>
                    </div>

                    <!-- Input untuk status GTK -->
                    <div class="form-group row">
                        <label for="gtk_keaktifan" class="col-sm-4 col-form-label">Status GTK</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="gtk_keaktifan" id="editAktif" required>
                                <option value="">Pilih Status Keaktifan</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Mutasi">Mutasi</option>
                                <option value="Pensiun">Pensiun</option>
                            </select>
                        </div>
                    </div>

                    <!-- Input untuk email GTK -->
                    <div class="form-group row">
                        <label for="gtk_email" class="col-sm-4 col-form-label">Email GTK</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="email" placeholder="Tambahkan email GTK...."
                                name="gtk_email" id="editEmail" required>
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
                            <input class="form-control" type="text" id="editPhoto" name="photo" readonly>
                            <small class="form-text text-muted">Path foto yang ada saat ini.</small>
                            <input class="form-control mt-2" type="file" name="gtk_foto" id="uploadPhoto">
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
    $('#gtk-table').on('click', '.delete-btn', function() {
        var gtksId = $(this).data('id');
        var token = '{{ csrf_token() }}';
        var deleteUrl = '{{ route('gtk.destroy', ':id') }}'.replace(':id', gtksId);

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


        $(document).on('click', '.view-photo-btn', function() {
            var photoUrl = $(this).data('photo');
            $('#photoModalImage').attr('src', photoUrl);
            $('#photoModal').modal('show');
        });


        function validateFile(file) {
            const allowedExtensions = ['jpg', 'jpeg', 'png'];
            const maxSize = 500 * 1024;

            if (!file) return {
                valid: true,
                message: ''
            };

            const extension = file.name.split('.').pop().toLowerCase();
            if (!allowedExtensions.includes(extension)) {
                return {
                    valid: false,
                    message: 'Foto hanya file dengan ekstensi jpg, jpeg, png yang diperbolehkan.'
                };
            }

            if (file.size > maxSize) {
                return {
                    valid: false,
                    message: 'Ukuran file tidak boleh lebih dari 500KB.'
                };
            }

            return {
                valid: true,
                message: ''
            };
        }

        $('#formTambahGtk').submit(function(event) {
            event.preventDefault();

            const fileInput = $('#gtk_foto')[0];
            const file = fileInput.files[0];
            const validation = validateFile(file);

            if (!validation.valid) {
                toastr.error(validation.message);
                return;
            }


            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response
                            .success);
                        setTimeout(function() {

                            location.reload();
                        }, 1000);
                    }
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
        const baseUrl = $('meta[name="base-url"]').attr('content');
        $('#gtk-table').DataTable({
            processing: false,
            serverSide: true,
            responsive: true,
            ordering: false,

            ajax: '{{ route('gtk.data') }}',
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

                    data: 'full_name',
                    name: 'full_name'
                },
                {

                    data: 'gender',
                    name: 'gender'
                },
                {

                    data: 'parent_school_status',
                    name: 'parent_school_status'
                },
                {

                    data: 'gtk_status',
                    name: 'gtk_status'
                },
                {

                    data: 'email',
                    name: 'email'
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
                            url: '/gtk/delete-selected',
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
                                        'Terjadi kesalahan saat menghapus GTK.',
                                        'error'
                                    )
                                }
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Terjadi kesalahan saat menghapus GTK.',
                                    'error'
                                )
                            }
                        });
                    }
                });
            } else {

                Swal.fire(
                    'Info',
                    'Pilih setidaknya satu GTK untuk dihapus.',
                    'info'
                )
            }
        });
    });
</script>

<script>
    $(document).ready(function() {

        $('#gtk-table').on('click', '.edit-btn', function() {
            var id = $(this).data('id');

            $.ajax({
                url: '/gtk/' + id + '/fetch',
                type: 'GET',
                success: function(response) {
                    $('#editId').val(response.id);
                    $('#editName').val(response.full_name);
                    $('#editJk').val(response.gender);
                    $('#editInduk').val(response.parent_school_status);
                    $('#editAktif').val(response.gtk_status);
                    $('#editEmail').val(response.email);
                    $('#editPhoto').val(response.photo);


                    if (response.photo) {
                        $('#photoPreview').attr('src', '{{ asset('storage/') }}/' + response
                            .photo);
                    } else {
                        $('#photoPreview').attr('src',
                            '');
                    }

                    $('#editModal').modal('show');
                },
                error: function(xhr) {
                    console.log('Error:', xhr);
                }
            });
        });


        $('#editForm').submit(function(e) {
            e.preventDefault();

            var id = $('#editId').val();
            var formData = new FormData(this);


            $.ajax({
                url: '/gtk/' + id + '/update',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#editModal').modal('hide');
                    $('#gtk-table').DataTable().ajax.reload();
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
