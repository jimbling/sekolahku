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

                                </div>
                                <div class="col-md-4 text-right">
                                    <!-- Tombol Tambah -->
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                        data-target="#addTahunAjarans">
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
                            <table id="tahun-ajarans-table" class="table table-sm  table-striped table-hover"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th class="text-center"><input type="checkbox" id="select-all"></th>
                                        <th>TAHUN PELAJARAN</th>
                                        <th>SEMESTER</th>
                                        <th>STATUS</th>
                                        <th class="text-center">AKSI</th>
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

<div class="modal fade" data-backdrop="static" id="addTahunAjarans" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Tahun Ajaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('academic.years.store') }}" method="post" id="formAddTahunAjarans">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="tahun_ajarans_name" class="col-sm-4 col-form-label">Tahun Ajaran</label>
                        <div class="col-md-8">
                            <input class="form-control" type="text"
                                placeholder="Pisahkan dengan (-), contoh: 2024-2025" name="tahun_ajarans_name"
                                id="tahun_ajarans_name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tahun_ajarans_semester" class="col-sm-4 col-form-label">Kelas</label>
                        <div class="col-md-8">
                            <select name="tahun_ajarans_semester" id="tahun_ajarans_semester"
                                class="form-control select2">
                                <option value="">Pilih Semester</option>
                                <option value="genap">Semester Genap</option>
                                <option value="ganjil">Semester Ganjil</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tahun_ajarans_is_active" class="col-sm-4 col-form-label">Semester Aktif?</label>
                        <div class="col-md-8">
                            <select name="tahun_ajarans_is_active" id="tahun_ajarans_is_active"
                                class="form-control select2">
                                <option value="">Pilih Semester</option>
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
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


<div class="modal fade" id="editAcademicYears" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAcademicYears">Edit Data Tahun Ajaran</h5>
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
                        <label for="tahun_ajarans_name" class="col-sm-4 col-form-label">Tahun Ajaran</label>
                        <div class="col-md-8">
                            <input class="form-control" type="text"
                                placeholder="Pisahkan dengan (-), contoh: 2024-2025" name="tahun_ajarans_name"
                                id="editTahunAjaran">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tahun_ajarans_semester" class="col-sm-4 col-form-label">Kelas</label>
                        <div class="col-md-8">
                            <select name="tahun_ajarans_semester" id="editSemester" class="form-control select2">
                                <option value="">Pilih Semester</option>
                                <option value="genap">Semester Genap</option>
                                <option value="ganjil">Semester Ganjil</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tahun_ajarans_is_active" class="col-sm-4 col-form-label">Semester Aktif?</label>
                        <div class="col-md-8">
                            <select name="tahun_ajarans_is_active" id="editStatusSemester"
                                class="form-control select2">
                                <option value="">Pilih Semester</option>
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
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
    $('#tahun-ajarans-table').on('click', '.delete-btn', function() {
        var tahunAjaranId = $(this).data('id');
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
                    url: `/academic/academic_years/${tahunAjaranId}`,
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
                                'Terjadi kesalahan saat menghapus Kelas.',
                                'error'
                            )
                        }
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'Terjadi kesalahan saat menghapus Kelas.',
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
        $('#formAddTahunAjarans').submit(function(event) {
            event.preventDefault();

            // Kirim form via Ajax
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    toastr.success(response.success); // Menampilkan pesan toastr sukses
                    setTimeout(function() {
                        location.reload(); // Reload halaman setelah 1 detik
                    }, 1000);
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            toastr.error(value); // Menampilkan pesan error toastr
                        });
                    } else {
                        toastr.error(
                            'Terjadi kesalahan saat menyimpan data.'
                        ); // Pesan default jika error selain validasi
                    }
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
        $('#tahun-ajarans-table').DataTable({
            processing: false,
            serverSide: true,
            responsive: true,
            ordering: false,

            ajax: {
                url: `${baseUrl}/academic/academic_years/data`, // Gunakan base URL untuk membangun URL rute
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
                    data: 'tahun_ajaran',
                    name: 'tahun_ajaran'
                },
                {
                    // Kolom Judul
                    data: 'semester',
                    name: 'semester'
                },
                {
                    // Kolom Judul
                    data: 'status_semester',
                    name: 'status_semester'
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
                            url: '/academic/academic_years/delete-selected',
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
                                        'Terjadi kesalahan saat menghapus Kelas.',
                                        'error'
                                    )
                                }
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Terjadi kesalahan saat menghapus Tahun Ajaran.',
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
                    'Pilih setidaknya satu Data Tahun Ajaran untuk dihapus.',
                    'info'
                )
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Tampilkan modal edit ketika tombol edit diklik
        $('#tahun-ajarans-table').on('click', '.edit-btn', function() {
            var id = $(this).data('id');

            // Ambil data kelas berdasarkan ID menggunakan AJAX
            $.ajax({
                url: '/academic/academic_years/' + id + '/fetch',
                type: 'GET',
                success: function(response) {
                    $('#editId').val(response.id);
                    $('#editTahunAjaran').val(response.academic_year).trigger('change');
                    $('#editSemester').val(response.semester).trigger('change');

                    // Mengonversi status_semester dari string menjadi angka yang sesuai
                    var currentSemesterValue = response.current_semester == 'Aktif' ? '1' :
                        '0';
                    $('#editStatusSemester').val(currentSemesterValue).trigger('change');

                    $('#editAcademicYears').modal('show');
                },
                error: function(xhr) {
                    console.log('Error:', xhr);
                }
            });
        });

        // Submit form edit kelas
        $('#editForm').submit(function(e) {
            e.preventDefault();

            var id = $('#editId').val();
            var formData = new FormData(this);

            // Kirim permintaan AJAX untuk menyimpan perubahan
            $.ajax({
                url: '/academic/academic_years/' + id +
                    '/update', // Sesuaikan dengan endpoint yang benar
                type: 'POST', // Sesuaikan dengan metode yang benar (bisa juga PUT)
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#editAcademicYears').modal('hide');
                    $('#tahun-ajarans-table').DataTable().ajax.reload();
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
