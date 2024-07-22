<x-header>{{ $judul }}</x-header>
<div class="content-wrapper">
    <x-breadcrumb>{{ $judul }}</x-breadcrumb>

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card card-danger card-outline">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h3 class="card-title">Daftar Peserta Didik Non Aktif</h3>
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
                            <table id="students-non-active" class="table table-sm  table-striped table-hover"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center"><input type="checkbox" id="select-all"></th>
                                        <th>NIS</th>
                                        <th>NAMA LENGKAP</th>
                                        <th>JK</th>
                                        <th>STATUS PD</th>
                                        <th>TGL KELUAR</th>
                                        <th>ALASAN KELUAR</th>
                                        <th>ALUMNI ?</th>
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




<x-footer></x-footer>

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
        $('#students-non-active').DataTable({
            processing: false,
            serverSide: true,
            responsive: true,
            ordering: false,

            ajax: {
                url: `${baseUrl}/students/data/non-active`, // Gunakan base URL untuk membangun URL rute
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

                    data: 'no_induk',
                    name: 'no_induk'
                },
                {

                    data: 'nama_lengkap',
                    name: 'nama_lengkap'
                },
                {

                    data: 'jenis_kelamin',
                    name: 'jenis_kelamin'
                },
                {

                    data: 'status',
                    name: 'status'
                },
                {

                    data: 'end_date',
                    name: 'end_date'
                },
                {

                    data: 'reason',
                    name: 'reason'
                },
                {

                    data: 'is_alumni',
                    name: 'is_alumni'
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
