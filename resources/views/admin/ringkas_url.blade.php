<x-header>{{ $judul }}</x-header>
<div class="content-wrapper">
    <x-breadcrumb>{{ $judul }}</x-breadcrumb>

    <section class="content">
        <div class="container-fluid">

            <div class="custom-alert" role="alert">
                <div class="alert-title">Fitur Tautan Ramah</div>
                <div class="alert-message">
                    Untuk menggunakan fitur tautan ramah, Anda perlu membuat subdomain khusus untuk URL ramah Anda.
                    <br>
                    Contoh subdomain yang dapat digunakan adalah: <strong>ringkas.jimbling.my.id</strong>. <br>
                    Dengan menggunakan subdomain ini, tautan yang dihasilkan akan menjadi:
                    <strong>ringkas.jimbling.my.id/ContohTautan</strong>.
                    <br>
                    Fitur ini dirancang untuk mempermudah pembacaan tautan, bukan untuk memperpendek tautan seperti
                    layanan bit.ly.
                    Meskipun URL yang dihasilkan menggunakan subdomain custom, tautannya tetap mudah dibaca dan
                    dimengerti.
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h3 class="card-title">Daftar Tautan Ramah</h3>
                                </div>
                                <div class="col-md-4 text-right">
                                    <!-- Tombol Tambah -->
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                        data-target="#addTautanRingkas">
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
                            <table id="urls-table" class="table table-sm  table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center"><input type="checkbox" id="select-all"></th>
                                        <th>JUDUL</th>
                                        <th>TAUTAN ASLI</th>
                                        <th>TAUTAN RAMAH</th>
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
<div class="modal fade" id="addTautanRingkas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Tautan Ringkas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('shorten.url') }}" method="post" id="formTambahTautanRingkas">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_url_modal">Judul Tautan</label>
                        <input class="form-control" type="text" placeholder="Isikan tautan asli" name="nama_url"
                            id="nama_url_modal" required>
                    </div>
                    <div class="form-group">
                        <label for="url_asli_modal">Tautan Asli</label>
                        <textarea class="form-control" placeholder="Tambahkan judul tautan...." name="url_asli" id="url_asli_modal"
                            rows="3"></textarea>
                    </div>
                    <!-- Hapus input url_ringkas dari sini -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Edit Kategori -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Tautan Ringkas</h5>
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
                        <label for="editNamaUrl">Judul Tautan</label>
                        <input class="form-control" type="text" placeholder="Isikan judul tautan" name="nama_url"
                            id="editNamaUrl" required>
                    </div>
                    <div class="form-group">
                        <label for="editUrlAsli_modal">Tautan Asli</label>
                        <textarea class="form-control" placeholder="Tambahkan tautan asli...." name="url_asli" id="editUrlAsli"
                            rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="editUrlRingkas">Tautan Ringkas</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">https://ringkas.sdnkedungrejo.sch.id/</span>
                            </div>
                            <input type="text" class="form-control"placeholder="Isikan judul tautan"
                                name="url_asli" id="editUrlRingkas">
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

        $('#formTambahTautanRingkas').submit(function(event) {
            event.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#addTautanRingkas').modal('hide');
                        // Refresh tabel atau bagian lain jika diperlukan
                        location.reload(); // Opsional, jika ingin refresh halaman
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
        $('#urls-table').DataTable({
            "processing": true,
            serverSide: true,
            responsive: true,
            ordering: false,

            ajax: '{{ route('urls.data') }}',
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

                    data: 'nama_url',
                    name: 'nama_url'
                },
                {
                    data: 'url_asli',
                    name: 'url_asli',
                    render: function(data, type, full, meta) {
                        const maxLength = 50; // Batas panjang karakter
                        if (data.length > maxLength) {
                            return data.substr(0, maxLength) +
                                '...'; // Memotong teks dan menambahkan ellipsis
                        } else {
                            return data;
                        }
                    }
                },
                {
                    data: 'url_ringkas',
                    name: 'url_ringkas',
                    render: function(data, type, full, meta) {
                        const baseUrl =
                            'https://ringkas.sdnkedungrejo.sch.id'; // Base URL yang benar
                        const fullUrl = baseUrl + '/' + data;

                        // Menampilkan "https://ringkas..." dengan url_ringkas sebagai badge
                        const displayedUrl = `
            <span>${baseUrl.replace('.sdnkedungrejo.sch.id', '...')}</span>
            <span class="badge badge-success">${data}</span>`;

                        return `
            <span>${displayedUrl}</span>
            <button class="btn btn-xs btn-outline-info copy-url ml-2" data-url="${fullUrl}" title="Copy URL">
                <i class="fas fa-copy"></i>
            </button>
        `;
                    },
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
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

        // Event listener untuk tombol salin
        $('#urls-table').on('click', '.copy-url', function() {
            const url = $(this).data('url');

            if (navigator.clipboard && navigator.clipboard.writeText) {
                // Menggunakan clipboard API jika didukung
                navigator.clipboard.writeText(url).then(function() {
                    // Menampilkan toastR setelah URL disalin
                    toastr.success('Tautan telah disalin');
                }, function(err) {
                    toastr.error('Gagal menyalin tautan');
                });
            } else {
                // Fallback untuk browser yang tidak mendukung clipboard API
                const textarea = document.createElement('textarea');
                textarea.value = url;
                document.body.appendChild(textarea);
                textarea.select();
                try {
                    document.execCommand('copy');
                    toastr.success('Tautan telah disalin');
                } catch (err) {
                    toastr.error('Gagal menyalin tautan');
                }
                document.body.removeChild(textarea);
            }
        });

    });

    $('#select-all').on('change', function() {
        var isChecked = $(this).prop('checked');
        $('.row-select').prop('checked', isChecked);
    });
</script>

<script>
    $('#urls-table').on('click', '.delete-btn', function() {
        var urlsId = $(this).data('id');
        var token = '{{ csrf_token() }}';
        var deleteUrl = '{{ route('urls.destroy', ':id') }}'.replace(':id', urlsId);

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
                            url: '/urls/delete-selected',
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
                                        'Terjadi kesalahan saat menghapus Tautan Ringkas.',
                                        'error'
                                    )
                                }
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Terjadi kesalahan saat menghapus Tautan Ringkas.',
                                    'error'
                                )
                            }
                        });
                    }
                });
            } else {

                Swal.fire(
                    'Info',
                    'Pilih setidaknya satu Tautan Ringkas untuk dihapus.',
                    'info'
                )
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Tampilkan modal edit ketika tombol edit diklik
        $('#urls-table').on('click', '.edit-btn', function() {
            var id = $(this).data('id');

            // Ambil data kategori berdasarkan ID menggunakan AJAX
            $.ajax({
                url: '/urls/' + id + '/fetch',
                type: 'GET',
                success: function(response) {
                    $('#editId').val(response.id);
                    $('#editNamaUrl').val(response.nama_url);
                    $('#editUrlAsli').val(response.url_asli);
                    $('#editUrlRingkas').val(response.url_ringkas);
                    $('#editModal').modal('show');
                },
                error: function(xhr) {
                    console.log('Error:', xhr);
                }
            });
        });

        // Submit form edit kategori
        $('#editForm').submit(function(e) {
            e.preventDefault();

            var id = $('#editId').val();
            var formData = {
                nama_url: $('#editNamaUrl').val(),
                url_asli: $('#editUrlAsli').val(),
                url_ringkas: $('#editUrlRingkas').val(),
                _token: $('input[name=_token]').val(), // Pastikan token CSRF disertakan
            };

            // Kirim permintaan AJAX untuk menyimpan perubahan
            $.ajax({
                url: '/urls/' + id + '/update',
                type: 'PUT',
                data: formData,
                success: function(response) {
                    $('#editModal').modal('hide');
                    $('#urls-table').DataTable().ajax.reload();
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
