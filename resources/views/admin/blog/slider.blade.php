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
                                    <h3 class="card-title">Gambar Slide</h3>
                                </div>
                                <div class="col-md-4 text-right">

                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                        data-target="#addSlider">
                                        <i class="fas fa-plus"></i> Tambah
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="custom-alert">
                                <div class="alert-message">Persiapkan gambar yang ingin digunakan sebagai slider dengan
                                    resolusi 1.282 x 481 pixels, agar
                                    tampilan tetap
                                    proporsional!</div>
                            </div>
                            <table id="slidersTable" class="table table-sm table-striped table-hover"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Caption</th>
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
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="addSlider" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Gambar Slide</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('sliders.tambah') }}" method="post" id="formTambahSlider"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="sliders_caption">Caption</label>
                        <input class="form-control" type="text" placeholder="Masukkan keterangan gambar"
                            name="sliders_caption" id="sliders_caption">
                    </div>

                    <div class="form-group">
                        <label for="sliders_photo">Gambar</label>
                        <input class="form-control" type="file" name="sliders_photo" id="sliders_photo">
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



<div class="modal fade" data-backdrop="static" data-keyboard="false" id="editModal" tabindex="-1"
    aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Gambar Slide</h5>
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
                        <label for="sliders_caption">Caption</label>
                        <input class="form-control" type="text" placeholder="Masukkan keterangan gambar"
                            name="sliders_caption" id="sliders_captionEdit">
                    </div>
                    <div id="photoContainer">
                        <img id="photoPreview" src="" alt="Preview Foto" class="img-fluid mb-2"
                            style="max-width: 100%; height: auto;">
                    </div>
                    <div class="form-group">
                        <label for="sliders_photo">Gambar</label>
                        <input class="form-control" type="file" name="sliders_photo" id="sliders_photoEdit">
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

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="viewImageModal" tabindex="-1"
    aria-labelledby="viewImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewImageModalLabel">Lihat Gambar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="" alt="Gambar" class="img-fluid">
            </div>
        </div>
    </div>
</div>
<x-footer></x-footer>

<script>
    $(document).ready(function() {
        $('#slidersTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ordering: false,
            ajax: {
                url: '{{ route('admin.sliders.data') }}',
                dataSrc: 'data'
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
                    data: 'caption',
                    name: 'caption'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                }
            ],
            order: [
                [1, 'asc']
            ]
        });

        // Handle view button click
        $('#slidersTable').on('click', '.view-btn', function() {
            var imagePath = $(this).data('path');
            var imageUrl = '{{ asset('storage') }}/' + imagePath;

            $('#viewImageModal').find('.modal-body img').attr('src', imageUrl);
            $('#viewImageModal').modal('show');
        });
    });
</script>

<script>
    $('#slidersTable').on('click', '.delete-btn', function() {
        var slidersId = $(this).data('id');
        var token = '{{ csrf_token() }}';
        var deleteUrl = '{{ route('admin.sliders.destroy', ':id') }}'.replace(':id', slidersId);

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

        $('#formTambahSlider').submit(function(event) {
            event.preventDefault();

            // Create a FormData object
            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false, // Prevent jQuery from automatically transforming the data into a query string
                contentType: false, // Prevent jQuery from automatically setting content type header
                success: function(response) {
                    toastr.success(response.message);
                    $('#addSlider').modal('hide');
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
</script>

<script>
    $(document).ready(function() {

        $('#slidersTable').on('click', '.edit-btn', function() {
            var id = $(this).data('id');

            $.ajax({
                url: '/blog/gambar_slide/' + id + '/fetch',
                type: 'GET',
                success: function(response) {
                    $('#editId').val(response.id);
                    $('#sliders_captionEdit').val(response.caption);
                    $('#sliders_photosEdit').val(response.path);



                    if (response.path) {
                        $('#photoPreview').attr('src', '/storage/' + response.path);
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


        $('#editForm').submit(function(e) {
            e.preventDefault();

            var id = $('#editId').val();
            var formData = new FormData(this);


            $.ajax({
                url: '/blog/gambar_slide/' + id + '/update',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#editModal').modal('hide');
                    $('#slidersTable').DataTable().ajax.reload();
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
