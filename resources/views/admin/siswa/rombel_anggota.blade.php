<x-header>{{ $judul }}</x-header>
<div class="content-wrapper">
    <x-breadcrumb>{{ $judul }}</x-breadcrumb>

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="row float-right">

                                <div class="col-md-12 ">
                                    <button type="button" class="btn btn-sm btn-warning" id="atur-sebagai-alumni">
                                        <i class="fas fa-user-graduate"></i> ATUR SEBAGAI ALUMNI
                                    </button>
                                    <a href="#" class="btn btn-sm btn-info ml-2" id="move-to-classroom">
                                        <i class="fas fa-sign-out-alt"></i> PINDAH KE KELAS TUJUAN
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="filters mb-3">
                                <div class="form-group row">
                                    <label for="filter-select" class="col-md-4 col-form-label">Pilih Kelas Asal</label>
                                    <div class="col-md-8">
                                        <select id="filter-select" class="form-control select2">
                                            <option value="all">Tampilkan Semua</option>
                                            <option value="unregistered">Belum Diatur</option>
                                            @foreach ($data_kelas as $classroom)
                                                <option value="classroom-{{ $classroom->id }}">{{ $classroom->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div id="academic-year-select-container" style="display: none;">
                                <div class="form-group row">
                                    <label for="academic-year-select" class="col-md-4 col-form-label">Tahun
                                        Pelajaran</label>
                                    <div class="col-md-8">
                                        <select id="academic-year-select" class="form-control select2">
                                            @foreach ($tahun_pelajaran as $year)
                                                <option value="{{ $year->id }}">{{ $year->academic_year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <table id="anggota-rombels-table" class="table table-sm table-striped table-hover"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center"><input type="checkbox" id="select-all"></th>
                                        <th class="text-center">NO</th>
                                        <th>NIS</th>
                                        <th>NAMA SISWA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data akan dimasukkan oleh DataTables -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-md-8">

                                </div>
                                <div class="col-md-4 text-right">
                                    <!-- Tombol Hapus -->
                                    <a href="#" class="btn btn-sm btn-danger ml-2" id="delete-selected">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="kelas_tujuan mb-3">
                                <div class="form-group row">
                                    <label for="kelas_tujuan" class="col-md-4 col-form-label">Pilih Kelas
                                        Tujuan</label>
                                    <div class="col-md-8">
                                        <select id="kelas_tujuan" class="form-control select2">
                                            @foreach ($data_kelas as $classroom)
                                                <option value="classroom-{{ $classroom->id }}">{{ $classroom->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div id="tahun_ajaran_tujuan_container">
                                <div class="form-group row">
                                    <label for="tahun_ajaran_tujuan" class="col-md-4 col-form-label">Tahun
                                        Pelajaran</label>
                                    <div class="col-md-8">
                                        <select id="tahun_ajaran_tujuan" class="form-control select2">
                                            @foreach ($tahun_pelajaran as $year)
                                                <option value="{{ $year->id }}">{{ $year->academic_year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <table id="anggota-rombels-tujuan" class="table table-sm table-striped table-hover"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center"><input type="checkbox" id="select-all-tujuan"></th>
                                        <th class="text-center">NO</th>
                                        <th>NIS</th>
                                        <th>NAMA SISWA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data akan dimasukkan oleh DataTables -->
                                    <div class="form-group" style="display: none;">
                                        <label for="rombel_id_display">Rombel ID:</label>
                                        <div id="rombel-id-display">Belum ada rombel_id</div>
                                    </div>
                                </tbody>
                            </table>
                        </div>



                    </div>
                </div>



            </div>


        </div>
    </section>

</div>




<x-footer></x-footer>






<script>
    $(document).ready(function() {
        const baseUrl = $('meta[name="base-url"]').attr('content');

        function loadTable(filter, classroomId, academicYearId) {
            if ($.fn.DataTable.isDataTable('#anggota-rombels-table')) {
                $('#anggota-rombels-table').DataTable().clear().destroy();
            }

            $('#anggota-rombels-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                searching: false,
                ordering: false,
                lengthChange: false,
                ajax: {
                    url: `${baseUrl}/rombels/students/data`,
                    data: function(d) {
                        d.filter = filter;
                        d.classroom_id = classroomId;
                        d.academic_year_id = academicYearId;
                    }
                },
                columns: [{
                        data: 'id',
                        render: function(data, type, full, meta) {
                            return '<input type="checkbox" class="row-select" data-id="' +
                                data + '">';
                        },
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: null,
                        render: function(data, type, full, meta) {
                            return meta.row + 1;
                        },
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'nis',
                        name: 'nis'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                ],
                order: [
                    [1, 'asc']
                ]
            });
        }

        // Muat tabel dengan filter default
        loadTable('all', null, null);

        $('#filter-select').change(function() {
            var selectedFilter = $(this).val();
            var classroomId = null;
            var academicYearId = $('#academic-year-select').val();

            if (selectedFilter.startsWith('classroom-')) {
                classroomId = selectedFilter.split('-')[1]; // Ambil ID kelas dari value
                $('#academic-year-select-container').show();
            } else {
                $('#academic-year-select-container').hide();
            }

            loadTable(selectedFilter, classroomId, academicYearId);
        });

        $('#academic-year-select').change(function() {
            var selectedFilter = $('#filter-select').val();
            var classroomId = null;
            if (selectedFilter.startsWith('classroom-')) {
                classroomId = selectedFilter.split('-')[1]; // Ambil ID kelas dari value
            }
            var academicYearId = $(this).val();

            loadTable(selectedFilter, classroomId, academicYearId);
        });

        // Checkbox select-all untuk konteks ini
        $('#select-all').on('change', function() {
            var isChecked = $(this).prop('checked');
            $('#anggota-rombels-table .row-select').prop('checked', isChecked);
        });
    });
</script>





<script>
    $(document).ready(function() {
        const baseUrl = $('meta[name="base-url"]').attr('content');

        // Event listener untuk tombol Hapus Terpilih
        $('#delete-selected').on('click', function() {
            var selectedIds = [];
            $('#anggota-rombels-tujuan .row-select:checked').each(function() {
                selectedIds.push($(this).data('id'));
            });

            console.log("ID yang akan dihapus:", selectedIds); // Tambahkan log ID yang akan dihapus

            if (selectedIds.length > 0) {
                var token = '{{ csrf_token() }}';

                // Konfirmasi dengan SweetAlert
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dipilih akan dihapus!",
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
                            url: `${baseUrl}/anggota/delete-selected`,
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
                                        'Terjadi kesalahan saat menghapus data.',
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Terjadi kesalahan saat menghapus data.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            } else {
                // Jika tidak ada checkbox yang dipilih
                Swal.fire(
                    'Info',
                    'Pilih setidaknya satu data untuk dihapus.',
                    'info'
                );
            }
        });

        // Function to load table data
        function loadTable(filter, classroomId, academicYearId) {
            if ($.fn.DataTable.isDataTable('#anggota-rombels-tujuan')) {
                $('#anggota-rombels-tujuan').DataTable().clear().destroy();
            }
            console.log("Loading table with parameters:", {
                classroom_id: classroomId,
                academic_year_id: academicYearId
            });
            $('#anggota-rombels-tujuan').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                searching: false,
                ordering: false,
                lengthChange: false,
                ajax: {
                    url: `${baseUrl}/rombels/anggota/data`,
                    data: function(d) {
                        d.classroom_id = classroomId || null;
                        d.academic_year_id = academicYearId || null;
                    }
                },
                columns: [{
                        data: 'anggota_rombel_id', // Update with the correct ID field
                        render: function(data, type, full, meta) {
                            return '<input type="checkbox" class="row-select" data-id="' +
                                data + '">';
                        },
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: null,
                        render: function(data, type, full, meta) {
                            return meta.row + 1;
                        },
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'nis',
                        name: 'nis'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    }
                ],
                order: [
                    [1, 'asc']
                ]
            });
        }

        // Function to get Rombel ID
        function getRombelId(classroomId, academicYearId) {
            $.ajax({
                url: `${baseUrl}/rombels/rombel-id`,
                method: 'GET',
                data: {
                    classroom_id: classroomId,
                    academic_year_id: academicYearId
                },
                success: function(response) {
                    console.log("Rombel ID:", response.rombel_id);
                    // Tampilkan rombel_id di body card
                    $('#rombel-id-display').text(response.rombel_id ? response.rombel_id :
                        'Tidak ada rombel_id');
                },
                error: function(xhr) {
                    console.error("Error fetching rombel_id:", xhr.responseText);
                }
            });
        }

        // Event listener untuk perubahan pada kelas dan tahun ajaran
        $('#kelas_tujuan').change(function() {
            var selectedClassroomId = $(this).val().split('-')[1] || null;
            var selectedAcademicYearId = $('#tahun_ajaran_tujuan').val() || null;
            loadTable(null, selectedClassroomId, selectedAcademicYearId);
            getRombelId(selectedClassroomId, selectedAcademicYearId);
        });

        $('#tahun_ajaran_tujuan').change(function() {
            var selectedClassroomId = $('#kelas_tujuan').val().split('-')[1] || null;
            var selectedAcademicYearId = $(this).val() || null;
            loadTable(null, selectedClassroomId, selectedAcademicYearId);
            getRombelId(selectedClassroomId, selectedAcademicYearId);
        });

        // Checkbox select-all untuk konteks ini
        $('#select-all-tujuan').on('change', function() {
            var isChecked = $(this).prop('checked');
            $('#anggota-rombels-tujuan .row-select').prop('checked', isChecked);
        });
    });
</script>





<script>
    $(document).ready(function() {
        const baseUrl = $('meta[name="base-url"]').attr('content');

        $('#atur-sebagai-alumni').click(function() {
            var selectedIds = $('.row-select:checked').map(function() {
                return $(this).data('id');
            }).get();

            if (selectedIds.length === 0) {
                Swal.fire('Peringatan', 'Pilih siswa yang ingin diatur sebagai alumni.', 'warning');
                return;
            }

            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin mengatur siswa yang dipilih sebagai alumni?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, atur sebagai alumni',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `${baseUrl}/students/mark-as-alumni`,
                        type: 'POST',
                        data: {
                            ids: selectedIds,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Sukses',
                                    'Siswa berhasil diatur sebagai alumni.',
                                    'success');
                                $('#anggota-rombels-table').DataTable().ajax
                                    .reload();
                            } else {
                                Swal.fire('Error', 'Terjadi kesalahan: ' + response
                                    .errors, 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error',
                                'Terjadi kesalahan saat menghubungi server.',
                                'error');
                        }
                    });
                }
            });
        });
    });
</script>


<script>
    $(document).ready(function() {
        const baseUrl = $('meta[name="base-url"]').attr('content');

        $('#move-to-classroom').click(function(e) {
            e.preventDefault(); // Mencegah aksi default link

            // Ambil rombel_id dari tampilan
            var rombelId = $('#rombel-id-display').text();
            if (rombelId === 'Tidak ada rombel_id') {
                toastr.error('Rombel belum tersedia. Silahkan tambahkan data Rombel terlebih dahulu.');
                return;
            }

            // Ambil student_id dari checkbox yang dipilih
            var selectedStudentIds = [];
            $('.row-select:checked').each(function() {
                selectedStudentIds.push($(this).data('id'));
            });

            if (selectedStudentIds.length === 0) {
                toastr.warning('Tidak ada siswa yang dipilih.');
                return;
            }

            // Kirim data ke endpoint untuk disimpan
            $.ajax({
                url: `${baseUrl}/rombels/anggota/store`,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    rombel_id: rombelId,
                    student_ids: selectedStudentIds
                },
                success: function(response) {
                    toastr.success('Data berhasil dipindahkan ke kelas tujuan.');
                    // Opsional: Refresh tabel atau tampilan jika perlu
                    $('#anggota-rombels-tujuan').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    console.error("Error saving data:", xhr.responseText);
                    toastr.error('Terjadi kesalahan saat memindahkan data.');
                }
            });
        });
    });
</script>
