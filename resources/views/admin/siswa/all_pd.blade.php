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
                                    <h3 class="card-title">Daftar Peserta Didik Aktif</h3>
                                </div>
                                <div class="col-md-4 text-right">
                                    <!-- Tombol Tambah -->
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                        data-target="#addStudents">
                                        <i class="fas fa-plus"></i> Tambah
                                    </button>

                                    <!-- Tombol Import -->
                                    <a href="{{ route('admin.student.importForm') }}"
                                        class="btn btn-sm btn-success ml-2">
                                        <i class="fas fa-file-import"></i> Import
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <a href="#" class="btn btn-sm btn-danger ml-2" id="delete-selected">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <table id="students-table" class="table table-sm  table-striped table-hover"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center"><input type="checkbox" id="select-all"></th>
                                        <th>NIS</th>
                                        <th>NAMA LENGKAP</th>
                                        <th>JK</th>
                                        <th>STATUS PD</th>
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
<div class="modal fade" data-backdrop="static" id="addStudents" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Peserta Didik</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.students.store') }}" method="post" id="formTambahStudents"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="form-group row">
                        <label for="students_nama_siswa" class="col-sm-4 col-form-label">Nama Peserta Didik</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" placeholder="Isikan nama lengkap peserta didik"
                                name="students_name" id="students_nama_siswa" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="students_no_induk" class="col-sm-4 col-form-label">Nomor Induk Sekolah</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" placeholder="Tambahkan Nomor Induk Sekolah"
                                name="students_no_induk" id="students_no_induk" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="students_tempat_lahir" class="col-sm-4 col-form-label">Tempat Lahir</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" placeholder="Isikan tempat lahir "
                                name="students_tempat_lahir" id="students_tempat_lahir" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="students_tanggal_lahir" class="col-sm-4 col-form-label">Tanggal Lahir</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control datepicker" placeholder=""
                                name="students_tanggal_lahir" id="students_tanggal_lahir" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="students_email" class="col-sm-4 col-form-label">Email Aktif</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="email" placeholder="Isikan email yang aktif"
                                name="students_email" id="students_email" required>
                        </div>
                    </div>
                    <!-- Input untuk jenis kelamin -->
                    <div class="form-group row">
                        <label for="students_jk" class="col-sm-4 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="students_jk" id="students_jk" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="M">Laki-Laki</option>
                                <option value="F">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Input untuk status induk -->
                    <div class="form-group row">
                        <label for="students_keaktifan" class="col-sm-4 col-form-label">Status Peserta Didik</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="students_keaktifan" id="students_keaktifan" required>
                                <option value="">Pilih Status Keaktifan</option>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>

                    <!-- Input untuk upload foto GTK -->
                    <div class="form-group row">
                        <label for="students_foto" class="col-sm-4 col-form-label">Foto</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="file" name="students_foto" id="students_foto">
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
                <img id="photoModalImage" src="" alt="Foto Peserta Didik" class="img-fluid">
            </div>

        </div>
    </div>
</div>

<!-- Modal Edit Siswa -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="editModal" tabindex="-1"
    aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPesertaDidik">Edit Data Peserta Didik</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="editId" name="id">
                <div class="modal-body">

                    <div class="form-group row">
                        <label for="editNama" class="col-sm-4 col-form-label">Nama Peserta Didik</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text"
                                placeholder="Isikan nama lengkap peserta didik" name="students_name" id="editNama"
                                required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="editNis" class="col-sm-4 col-form-label">Nomor Induk Sekolah</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" placeholder="Tambahkan Nomor Induk Sekolah"
                                name="students_no_induk" id="editNis" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="editTempatLahir" class="col-sm-4 col-form-label">Tempat Lahir</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" placeholder="Isikan tempat lahir "
                                name="students_tempat_lahir" id="editTempatLahir" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="editTanggalLahir" class="col-sm-4 col-form-label">Tanggal Lahir</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control datepicker" placeholder=""
                                name="students_tanggal_lahir" id="editTanggalLahir" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="editEmail" class="col-sm-4 col-form-label">Email Aktif</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="email" placeholder="Isikan email yang aktif"
                                name="students_email" id="editEmail" required>
                        </div>
                    </div>
                    <!-- Input untuk jenis kelamin -->
                    <div class="form-group row">
                        <label for="editJk" class="col-sm-4 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="students_jk" id="editJk" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="M">Laki-Laki</option>
                                <option value="F">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Input untuk status induk -->
                    <div class="form-group row">
                        <label for="editKeaktifan" class="col-sm-4 col-form-label">Status Peserta Didik</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="students_keaktifan" id="editKeaktifan" required>
                                <option value="">Pilih Status Keaktifan</option>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>

                    <!-- Input untuk alasan tidak aktif -->
                    <div class="form-group row reason-field d-none">
                        <label for="editReason" class="col-sm-4 col-form-label">Alasan Tidak Aktif</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="students_reason" id="editReason">
                                <option value="">Pilih Alasan</option>
                                <option value="Lulus">Lulus</option>
                                <option value="Mutasi">Mutasi</option>
                                <option value="DO">Drop Out (DO)</option>
                                <option value="Meninggal">Meninggal Dunia</option>
                                <option value="Putus Sekolah">Putus Sekolah</option>
                            </select>
                        </div>
                    </div>

                    <!-- Input untuk tanggal keluar -->
                    <div class="form-group row end-date-field d-none">
                        <label for="editEndDate" class="col-sm-4 col-form-label">Tanggal Tidak Aktif</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control datepicker" name="students_end_date"
                                id="editEndDate">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="uploadPhoto" class="col-sm-4 col-form-label">Foto</label>
                        <div class="col-sm-8">
                            <!-- Preview foto yang sudah ada -->
                            <div id="photoContainer">
                                <img id="photoPreview" src="" alt="Preview Foto" class="img-fluid mb-2"
                                    style="max-width: 200px; height: auto;">
                            </div>

                            <!-- Tampilkan path foto saat ini (tidak terkirim ke server) -->
                            <small class="form-text text-muted">
                                Path foto saat ini: <span id="editPhotoPath">-</span>
                            </small>

                            <!-- Input untuk upload foto baru -->
                            <input class="form-control mt-2" type="file" name="students_foto" id="uploadPhoto">
                            <small class="form-text text-muted">Pilih gambar untuk mengganti foto.</small>
                        </div>
                    </div>

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
    $('#students-table').on('click', '.delete-btn', function() {
        var studentsId = $(this).data('id');
        var token = '{{ csrf_token() }}';
        var deleteUrl = '{{ route('admin.students.destroy', ':id') }}'.replace(':id', studentsId);

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
                                // Reload halaman setelah SweetAlert sukses muncul
                                window.location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'Terjadi kesalahan saat menghapus Peserta Didik.',
                                'error'
                            )
                        }
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'Terjadi kesalahan saat menghapus Peserta Didik.',
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

        // Menangani klik pada tombol "Lihat Foto"
        $(document).on('click', '.view-photo-btn', function() {
            var photoUrl = $(this).data('photo');
            $('#photoModalImage').attr('src', photoUrl);
            $('#photoModal').modal('show');
        });

        // Fungsi untuk validasi file gambar
        function validateFile(file) {
            const allowedExtensions = ['jpg', 'jpeg', 'png'];
            const maxSize = 500 * 1024; // 500KB

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

        $('#formTambahStudents').submit(function(event) {
            event.preventDefault();

            const fileInput = $('#students_foto')[0];
            const file = fileInput.files[0];
            const validation = validateFile(file);

            if (!validation.valid) {
                toastr.error(validation.message);
                return;
            }

            // Jika valid, kirim form via Ajax
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response
                            .success); // Menggunakan toastr untuk menampilkan pesan
                        setTimeout(function() {
                            // Reload halaman setelah 1 detik
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

        // Ambil base URL dari meta tag
        const baseUrl = $('meta[name="base-url"]').attr('content');

        // Inisialisasi DataTables
        $('#students-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ordering: false,

            ajax: {
                url: `${baseUrl}/admin/academic/students/data`, // Gunakan base URL untuk membangun URL rute
            },
            columns: [{
                    data: null,
                    render: function(data, type, full, meta) {
                        return meta.row + 1;
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
                    data: 'nis', // <-- gunakan nama kolom asli dari DB
                    name: 'nis'
                },
                {
                    data: 'name', // <-- name asli di DB
                    name: 'name',
                    render: function(data, type, full, meta) {
                        return full.nama_lengkap ?? data; // gunakan accessor jika tersedia
                    }
                },
                {
                    data: 'gender',
                    name: 'gender',
                    render: function(data, type, full, meta) {
                        return full.jenis_kelamin ?? data;
                    }
                },
                {
                    data: 'student_status_id',
                    name: 'student_status_id',
                    render: function(data, type, full, meta) {
                        return full.status ?? data;
                    }
                },
                {
                    data: 'email',
                    name: 'email',
                    render: function(data, type, full, meta) {
                        return full.email_aktif ?? data;
                    }
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
                            url: '/admin/academic/students/delete-selected',
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
                                        'Terjadi kesalahan saat menghapus Peserta Didik.',
                                        'error'
                                    )
                                }
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Terjadi kesalahan saat menghapus Peserta Didik.',
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
                    'Pilih setidaknya satu Peserta Didik untuk dihapus.',
                    'info'
                )
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Tampilkan modal edit ketika tombol edit diklik
        $('#students-table').on('click', '.edit-btn', function() {
            var id = $(this).data('id');

            // Ambil data GTK berdasarkan ID menggunakan AJAX
            $.ajax({
                url: '/admin/academic/students/' + id + '/fetch',
                type: 'GET',
                success: function(response) {
                    $('#editId').val(response.id);
                    $('#editNama').val(response.nama_lengkap);
                    $('#editJk').val(response.jenis_kelamin);
                    $('#editNis').val(response.no_induk);
                    $('#editTempatLahir').val(response.tempat_lahir);
                    $('#editTanggalLahir').val(response.tanggal_lahir);
                    $('#editKeaktifan').val(response.student_status_id).trigger(
                        'change'); // ✅ tambahkan trigger di sini
                    $('#editEmail').val(response.email);
                    $('#editPhoto').val(response.photo);
                    $('#editPhotoPath').text(response.photo ?? '-');

                    if (response.photo) {
                        $('#photoPreview').attr('src', '{{ asset('storage/') }}/' + response
                            .photo);
                    } else {
                        $('#photoPreview').attr('src', '');
                    }

                    $('#editModal').modal('show');
                },

                error: function(xhr) {
                    console.log('Error:', xhr);
                }
            });
        });

        // Submit form edit GTK
        $('#editForm').submit(function(e) {
            e.preventDefault();

            var id = $('#editId').val();
            var formData = new FormData(this);

            // Kirim permintaan AJAX untuk menyimpan perubahan
            $.ajax({
                url: '/admin/academic/students/' + id + '/update',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#editModal').modal('hide');
                    $('#students-table').DataTable().ajax.reload();
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

    $('#editKeaktifan').on('change', function() {
        if ($(this).val() == "0") {
            $('.reason-field').removeClass('d-none');
            $('.end-date-field').removeClass('d-none');
            $('#editReason, #editEndDate').prop('disabled', false).attr('required', true);
        } else {
            $('.reason-field').addClass('d-none');
            $('.end-date-field').addClass('d-none');
            $('#editReason, #editEndDate')
                .prop('disabled', true)
                .removeAttr('required')
                .val('');
        }
    });
</script>

@if (session('import_result'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const result = @json(session('import_result'));

            // Tampilkan pesan berhasil
            if (result.imported > 0) {
                toastr.success(result.message, 'Berhasil');
            }

            // Tampilkan pesan error per baris (jika ada)
            if (result.errors.length > 0) {
                result.errors.forEach(function(err) {
                    toastr.error(err, 'Gagal Import');
                });
            }
        });
    </script>
@endif
