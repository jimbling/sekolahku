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
                                    <h3 class="card-title">Tautan</h3>
                                </div>
                                <div class="col-md-4 text-right">

                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                        data-target="#addTautan">
                                        <i class="fas fa-plus"></i> Tambah
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="tautanTable" class="table table-sm table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>URL</th>
                                        <th>Keterangan</th>
                                        <th>Target</th>
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
<div class="modal fade" id="addTautan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Tautan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.tautan.tambah') }}" method="post" id="formTambahTautan">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label for="tautan_url">URL</label>
                        <input class="form-control" type="text" placeholder="Masukkan url lengkap dari https://"
                            name="tautan_url" id="tautan_url">
                    </div>


                    <div class="form-group">
                        <label for="tautan_keterangan">Keterangan</label>
                        <input class="form-control" placeholder="Tambahkan keterangan...." name="tautan_name"
                            id="tautan_name" rows="3">
                    </div>
                    <div class="form-group">
                        <label for="tautan_target">Target</label>
                        <select class="form-control" id="tautan_target" name="tautan_target" required>
                            <option value="_blank">blank</option>
                            <option value="_self">self</option>
                            <option value="_parent">parent</option>
                            <option value="_top">top</option>
                        </select>
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


<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="editId" name="id">
                    <div class="form-group">
                        <label for="edit_tautan_url">URL</label>
                        <input class="form-control" type="text" placeholder="Masukkan url lengkap dari https://"
                            name="edit_tautan_url" id="edit_tautan_url">
                    </div>


                    <div class="form-group">
                        <label for="edit_tautan_name">Keterangan</label>
                        <input class="form-control" placeholder="Tambahkan keterangan...." name="edit_tautan_name"
                            id="edit_tautan_name" rows="3">
                    </div>
                    <div class="form-group">
                        <label for="edit_tautan_target">Target</label>
                        <select class="form-control" id="edit_tautan_target" name="edit_tautan_target" required>
                            <option value="_blank">blank</option>
                            <option value="_self">self</option>
                            <option value="_parent">parent</option>
                            <option value="_top">top</option>
                        </select>
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

<script src="{{ asset('lte/dist/js/backend/tautan.js') }}"></script>

<script>
    $('#tautanTable').on('click', '.delete-btn', function() {
        var tautanId = $(this).data('id');
        var token = '{{ csrf_token() }}';
        var deleteUrl = '{{ route('admin.tautan.destroy', ':id') }}'.replace(':id', tautanId);

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
                                $('#tautanTable').DataTable().ajax.reload(null,
                                    false);
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
        // Tampilkan toastr dari session (misal dari redirect)
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

        // Tangani submit form tambah tautan
        $('#formTambahTautan').submit(function(event) {
            event.preventDefault();

            // Tampilkan loading toastr
            toastr.info('Sedang memproses...', 'Mohon menunggu sebentar', {
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
                    toastr.clear(); // Hapus loading
                    toastr.success(response.message);
                    $('#addTautan').modal('hide');

                    // Reset form
                    $('#formTambahTautan')[0].reset();

                    // Reload DataTable
                    $('#tautanTable').DataTable().ajax.reload(null, false);
                },
                error: function(xhr) {
                    toastr.clear(); // Hapus loading
                    if (xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            toastr.error(value);
                        });
                    } else {
                        toastr.error('Terjadi kesalahan saat menambahkan tautan.');
                    }
                }
            });
        });
    });
</script>
