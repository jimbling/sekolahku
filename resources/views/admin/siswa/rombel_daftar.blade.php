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
                                        data-target="#addRombels">
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
                            <table id="rombels-table" class="table table-sm  table-striped table-hover"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center"><input type="checkbox" id="select-all"></th>
                                        <th>TAHUN PELAJARAN</th>
                                        <th>KELAS</th>
                                        <th>WALI KELAS</th>
                                        <th>ANGGOTA ROMBEL</th>
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

<div class="modal fade" data-backdrop="static" id="addRombels" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRombels">Tambah Data Kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.rombongan_belajar.store') }}" method="POST" id="formTambahRombels">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="tahun_ajaran">Tahun Ajaran</label>
                            <select name="tahun_ajaran" id="tahun_ajaran" class="form-control select2">
                                <option value="">Pilih Tahun Ajaran</option>
                                @foreach ($academicYears as $academicYear)
                                    <option value="{{ $academicYear->id }}">{{ $academicYear->academic_year }}</option>
                                @endforeach
                            </select>
                            @error('tahun_ajaran')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="kelas">Kelas</label>
                            <select name="kelas" id="kelas" class="form-control select2">
                                <option value="">Pilih Kelas</option>
                                @foreach ($classrooms as $classroom)
                                    <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                                @endforeach
                            </select>
                            @error('kelas')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="wali_kelas">Wali Kelas</label>
                            <select name="wali_kelas" id="wali_kelas" class="form-control select2">
                                <option value="">Pilih Wali Kelas</option>
                                @foreach ($gtks as $gtk)
                                    <option value="{{ $gtk->id }}">{{ $gtk->full_name }}</option>
                                @endforeach
                            </select>
                            @error('wali_kelas')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
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


<div class="modal fade" id="editRombels" data-backdrop="static" tabindex="-1" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRombels">Edit Data Rombongan Belajar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="editId" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="tahun_ajaran">Tahun Ajaran</label>
                            <select name="tahun_ajaran" id="editTahunAjaran" class="form-control select2">
                                <option value="">Pilih Tahun Ajaran</option>
                                @foreach ($academicYears as $academicYear)
                                    <option value="{{ $academicYear->id }}">{{ $academicYear->academic_year }}
                                    </option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-md-6 form-group">
                            <label for="kelas">Kelas</label>
                            <select name="kelas" id="editKelas" class="form-control select2">
                                <option value="">Pilih Kelas</option>
                                @foreach ($classrooms as $classroom)
                                    <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="wali_kelas">Wali Kelas</label>
                            <select name="wali_kelas" id="editWaliKelas" class="form-control select2">
                                <option value="">Pilih Wali Kelas</option>
                                @foreach ($gtks as $gtk)
                                    <option value="{{ $gtk->id }}">{{ $gtk->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<x-footer></x-footer>

<script>
    $('#rombels-table').on('click', '.delete-btn', function() {
        var rombelsId = $(this).data('id');
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
                    url: `/admin/academic/rombels/${rombelsId}`,
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
                                'Terjadi kesalahan saat menghapus Rombongan Belajar.',
                                'error'
                            )
                        }
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'Terjadi kesalahan saat menghapus Rombongan Belajar.',
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
        $('#formTambahRombels').submit(function(event) {
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
                        );
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
        $('#rombels-table').DataTable({
            processing: false,
            serverSide: true,
            responsive: true,
            ordering: false,

            ajax: {
                url: `${baseUrl}/admin/academic/rombels/data`, // Gunakan base URL untuk membangun URL rute
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
                    data: 'kelas',
                    name: 'kelas'
                },
                {
                    // Kolom Judul
                    data: 'wali_kelas',
                    name: 'wali_kelas'
                },

                {
                    // Kolom Judul
                    data: 'jumlah_anggota',
                    name: 'jumlah_anggota'
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
                            url: '/admin/academic/rombels/delete-selected',
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
                                    'Terjadi kesalahan saat menghapus Data Rombongan Belajar.',
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
                    'Pilih setidaknya satu Data Rombongan Belajar untuk dihapus.',
                    'info'
                )
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Tampilkan modal edit ketika tombol edit diklik
        $('#rombels-table').on('click', '.edit-btn', function() {
            var id = $(this).data('id');

            // Ambil data kelas berdasarkan ID menggunakan AJAX
            $.ajax({
                url: '/admin/academic/rombels/' + id + '/fetch',
                type: 'GET',
                success: function(response) {
                    $('#editId').val(response.id);

                    // Mengisi nilai select dengan data dari response
                    $('#editTahunAjaran').val(response.academic_years_id).trigger('change');
                    $('#editKelas').val(response.classroom_id).trigger('change');
                    $('#editWaliKelas').val(response.gtks_id).trigger('change');

                    $('#editRombels').modal('show');
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
                url: '/admin/academic/rombels/' + id +
                    '/update',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#editRombels').modal('hide');
                    $('#rombels-table').DataTable().ajax.reload();
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
