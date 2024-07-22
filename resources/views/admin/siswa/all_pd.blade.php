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
            <form action="{{ route('students.store') }}" method="post" id="formTambahStudents"
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
                <img id="photoModalImage" src="" alt="Foto GTK" class="img-fluid">
            </div>

        </div>
    </div>
</div>

<!-- Modal Edit Kategori -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
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

                    <div class="form-group row">
                        <label for="editPhoto" class="col-sm-4 col-form-label">Foto</label>
                        <div class="col-sm-8">
                            <!-- Menampilkan foto yang sudah ada -->
                            <div id="photoContainer">
                                <img id="photoPreview" src="" alt="Preview Foto" class="img-fluid mb-2"
                                    style="max-width: 200px; height: auto;">
                            </div>
                            <input class="form-control" type="text" id="editPhoto" name="students_foto" readonly>
                            <small class="form-text text-muted">Path foto yang ada saat ini.</small>
                            <input class="form-control mt-2" type="file" name="students_foto" id="uploadPhoto">
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
{{-- <script src="{{ asset('lte/dist/js/backend/tags.js') }}"></script> --}}
<script>
    $('#students-table').on('click', '.delete-btn', function() {
        var studentsId = $(this).data('id');
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
                    url: `/students/${studentsId}`,
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
            processing: false,
            serverSide: true,
            responsive: true,
            ordering: false,

            ajax: {
                url: `${baseUrl}/students/data`, // Gunakan base URL untuk membangun URL rute
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
                    data: 'no_induk',
                    name: 'no_induk'
                },
                {
                    // Kolom Author
                    data: 'nama_lengkap',
                    name: 'nama_lengkap'
                },
                {
                    // Kolom Author
                    data: 'jenis_kelamin',
                    name: 'jenis_kelamin'
                },
                {
                    // Kolom Author
                    data: 'status',
                    name: 'status'
                },
                {
                    // Kolom Author
                    data: 'email_aktif',
                    name: 'email_aktif'
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
                            url: '/students/delete-selected',
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
                url: '/students/' + id + '/fetch',
                type: 'GET',
                success: function(response) {
                    $('#editId').val(response.id);
                    $('#editNama').val(response.nama_lengkap);
                    $('#editJk').val(response.jenis_kelamin);
                    $('#editNis').val(response.no_induk);
                    $('#editTempatLahir').val(response.tempat_lahir);
                    $('#editTanggalLahir').val(response.tanggal_lahir);
                    // Pemetaan nilai dari database ke teks yang ditampilkan
                    if (response.status == 1) {
                        $('#editKeaktifan').val('1'); // Memilih opsi "Aktif"
                    } else {
                        $('#editKeaktifan').val('0'); // Memilih opsi "Tidak Aktif"
                    }
                    $('#editEmail').val(response.email);
                    $('#editPhoto').val(response.photo);

                    // Tampilkan preview foto yang ada
                    if (response.photo) {
                        $('#photoPreview').attr('src', '{{ asset('storage/') }}/' + response
                            .photo);
                    } else {
                        $('#photoPreview').attr('src',
                            ''); // Kosongkan preview jika tidak ada foto
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
                url: '/students/' + id + '/update',
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
</script>
