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
                                    <h3 class="card-title">Pengumuman</h3>
                                </div>
                                <div class="col-md-4 text-right">
                                    <!-- Tombol trigger modal -->
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                        data-target="#addPengumuman">
                                        <i class="fas fa-plus"></i> Tambah
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="pengumumanTable" class="table table-sm table-striped table-hover"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Isi Pengumuman</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Berakhir</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data akan dimuat oleh DataTables -->
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
<div class="modal fade" id="addPengumuman" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Informasi Mendesak</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('admin.pengumuman.store') }}" method="POST" id="formTambahPengumuman">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Judul</label>
                        <input class="form-control" type="text" name="title" id="title"
                            placeholder="Judul informasi" required>
                    </div>

                    <div class="form-group">
                        <label for="message">Pesan</label>
                        <textarea class="form-control" name="content" id="content" rows="3" placeholder="Isi pesan informasi..."
                            required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="start_date">Tanggal Mulai (opsional)</label>
                        <input class="form-control" type="date" name="publish_date" id="publish_date">
                    </div>

                    <div class="form-group">
                        <label for="end_date">Tanggal Berakhir (opsional)</label>
                        <input class="form-control" type="date" name="expired_at" id="expired_at">
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


<!-- Modal Edit Informasi -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Informasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="editId" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editTitle">Judul</label>
                        <input type="text" class="form-control" id="editTitle" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="editMessage">Pesan</label>
                        <textarea class="form-control" id="editContent" name="content" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="editStartDate">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="editPublishDate" name="publish_date">
                    </div>
                    <div class="form-group">
                        <label for="editEndDate">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="editExpiredAt" name="expired_at">
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
    $(document).ready(function() {

        // Ambil base URL dari meta tag
        const baseUrl = $('meta[name="base-url"]').attr('content');

        // Inisialisasi DataTables
        $('#pengumumanTable').DataTable({
            processing: false,
            serverSide: true,
            responsive: true,
            ordering: false,
            ajax: '{{ route('admin.publikasi.pengumuman.data') }}',
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'content',
                    name: 'content'
                },

                {
                    data: 'publish_date',
                    name: 'publish_date',

                },
                {
                    data: 'expired_at',
                    name: 'expired_at',

                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            order: [
                [1, 'asc']
            ]
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Tombol edit diklik
        $('#pengumumanTable').on('click', '.edit-btn', function() {
            var id = $(this).data('id');

            // Ambil data berdasarkan ID
            $.ajax({
                url: '/publikasi/pengumuman/' + id + '/fetch',
                type: 'GET',
                success: function(response) {
                    $('#editId').val(response.id);
                    $('#editTitle').val(response.title);
                    $('#editContent').val(response.content);
                    $('#editPublishDate').val(response.publish_date);
                    $('#editExpiredAt').val(response.expired_at);
                    $('#editModal').modal('show');
                },
                error: function(xhr) {
                    toastr.error('Gagal mengambil data.');
                }
            });
        });

        // Submit form update
        $('#editForm').submit(function(e) {
            e.preventDefault();
            var id = $('#editId').val();

            let formData = {
                _token: $('input[name=_token]').val(),
                _method: 'PUT',
                title: $('#editTitle').val(),
                content: $('#editContent').val(),
                publish_date: $('#editPublishDate').val(),
                expired_at: $('#editExpiredAt').val(),

            };

            $.ajax({
                url: '/publikasi/pengumuman/' + id,
                type: 'POST', // Tetap pakai POST karena method spoofing via _method
                data: formData,
                success: function(response) {
                    $('#editModal').modal('hide');
                    $('#pengumumanTable').DataTable().ajax.reload();
                    toastr.success(response.message);
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            toastr.error(value);
                        });
                    } else {
                        toastr.error('Terjadi kesalahan saat memperbarui.');
                    }
                }
            });
        });
    });
</script>

<script>
    $('#pengumumanTable').on('click', '.delete-btn', function() {
        var pengumumanId = $(this).data('id');
        var token = '{{ csrf_token() }}';
        var deleteUrl = '{{ route('admin.pengumuman.destroy', ':id') }}'.replace(':id', pengumumanId);


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

                // Show SweetAlert2 loading spinner
                Swal.fire({
                    title: 'Sedang memproses...',
                    text: 'Mohon menunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });

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
                                'Terjadi kesalahan saat menghapus Pengumuman.',
                                'error'
                            )
                        }
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'Terjadi kesalahan saat menghapus Pengumuman.',
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


        $(document).ready(function() {

            $('#formTambahPengumuman').submit(function(event) {
                event.preventDefault();

                // Show toastr loading spinner
                let loadingToastr = toastr.info('Sedang memproses...',
                    'Mohon menunggu sebentar', {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        tapToDismiss: false,
                    });

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        toastr.success(response.message);
                        $('#addPengumuman').modal('hide');
                        location.reload();
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
