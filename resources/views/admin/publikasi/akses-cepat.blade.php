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
                                    <h3 class="card-title">Akses Cepat</h3>
                                </div>
                                <div class="col-md-4 text-right">
                                    <!-- Tombol trigger modal -->
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                        data-target="#addAksesCepat">
                                        <i class="fas fa-plus"></i> Tambah
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="aksesCepatTable" class="table table-sm table-striped table-hover"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Label</th>
                                        <th>Url</th>
                                        <th>Ikon</th>
                                        <th>Warna</th>
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
<div class="modal fade" id="addAksesCepat" tabindex="-1" aria-labelledby="addAksesCepatLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAksesCepatLabel">Tambah Quick Link</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('admin.akses-cepat.store') }}" method="POST" id="formTambahAksesCepat">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="label">Judul Link</label>
                        <input class="form-control" type="text" name="label" id="label"
                            placeholder="Contoh: Dashboard, Data Siswa" required>
                    </div>

                    <div class="form-group">
                        <label for="url">URL Tujuan</label>
                        <input class="form-control" type="teks" name="url" id="url"
                            placeholder="Contoh: /admin/dashboard atau https://..." required>
                    </div>

                    <div class="form-group">
                        <label for="icon">Ikon SVG</label>
                        <input class="form-control" type="text" name="icon" id="icon"
                            placeholder="Contoh: <svg ...>...</svg>" required>
                        <small class="form-text text-muted">
                            Masukkan kode SVG mentah dari ikon yang ingin digunakan.
                            Kamu bisa menyalinnya dari:
                            <a href="https://heroicons.com" target="_blank"
                                rel="noopener noreferrer">https://heroicons.com</a>

                        </small>
                    </div>


                    <div class="form-group">
                        <label for="color">Warna (Tailwind)</label>
                        <select class="form-control" name="color" id="color" required>
                            <option value="">-- Pilih Warna --</option>
                            <option value="blue">Biru</option>
                            <option value="green">Hijau</option>
                            <option value="red">Merah</option>
                            <option value="yellow">Kuning</option>
                            <option value="purple">Ungu</option>
                            <option value="pink">Pink</option>
                            <option value="indigo">Indigo</option>
                            <option value="teal">Teal</option>
                            <option value="orange">Oranye</option>
                            <option value="sky">Sky</option>
                            <option value="emerald">Emerald</option>
                            <option value="cyan">Cyan</option>
                            <option value="rose">Rose</option>
                            <option value="lime">Lime</option>
                        </select>
                        <small class="form-text text-muted">
                            Hanya gunakan nama warna dasar Tailwind (tanpa angka gradasi).
                        </small>
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






<x-footer></x-footer>



<script>
    $(document).ready(function() {

        // Ambil base URL dari meta tag
        const baseUrl = $('meta[name="base-url"]').attr('content');

        // Inisialisasi DataTables
        $('#aksesCepatTable').DataTable({
            processing: false,
            serverSide: true,
            responsive: true,
            ordering: false,
            ajax: '{{ route('admin.publikasi.akses.cepat.data') }}',
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'label',
                    name: 'label'
                },
                {
                    data: 'url',
                    name: 'url'
                },

                {
                    data: 'icon',
                    name: 'icon',
                    render: function(data, type, row) {
                        return data; // SVG langsung dirender
                    }
                },
                {
                    data: 'color',
                    name: 'color',

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
    $('#aksesCepatTable').on('click', '.delete-btn', function() {
        var aksesCepatId = $(this).data('id');
        var token = '{{ csrf_token() }}';
        var deleteUrl = '{{ route('admin.akses-cepat.destroy', ':id') }}'.replace(':id', aksesCepatId);


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
                                'Terjadi kesalahan saat menghapus Akses Cepat.',
                                'error'
                            )
                        }
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'Terjadi kesalahan saat menghapus Akses Cepat.',
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

            $('#formTambahAksesCepat').submit(function(event) {
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
                        $('#addAksesCepat').modal('hide');
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
