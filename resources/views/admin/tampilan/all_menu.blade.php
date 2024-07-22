<x-header>{{ $judul }}</x-header>
<div class="content-wrapper">
    <x-breadcrumb>{{ $judul }}</x-breadcrumb>

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-4">

                    <div id="accordion">

                        <div class="card card-success">
                            <div class="card-header">
                                <h4 class="card-title w-100">
                                    <a class="d-block w-100" data-toggle="collapse" href="#collapseThree">
                                        TAUTAN
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseThree" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    <form action="{{ route('menus.store') }}" method="post" id="formTambahMenu">
                                        @csrf
                                        <div class="modal-body">

                                            <div class="form-group row">
                                                <label for="menus_nama_menu" class="col-sm-4 col-form-label">Nama
                                                    Link</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="text"
                                                        placeholder="Tambahkan nama link...." name="menus_nama"
                                                        id="menus_nama_menu" required>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label for="menus_tautan" class="col-sm-4 col-form-label">URL</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="text"
                                                        placeholder="Tambahkan url...." name="menus_tautan"
                                                        id="menus_tautan" required>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label for="menus_target" class="col-sm-4 col-form-label">Link
                                                    Target</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" name="menus_target" id="menus_target"
                                                        required>
                                                        <option value="">Pilih Link Target</option>
                                                        <option value="_blank">Blank</option>
                                                        <option value="_self">Self</option>
                                                        <option value="_top">Top</option>
                                                        <option value="_parent">Parent</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <button type="submit"
                                                class="btn btn-primary btn-sm float-right">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="card card-danger">
                            <div class="card-header">
                                <h4 class="card-title w-100">
                                    <a class="d-block w-100" data-toggle="collapse" href="#collapseTwo">
                                        HALAMAN
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    <form id="menuForm" method="POST" action="{{ route('menus.storeFromCheckbox') }}">
                                        @csrf

                                        <div class="form-group">
                                            @foreach ($posts as $post)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="posts[]"
                                                        value="{{ $post->id }}" data-title="{{ $post->title }}"
                                                        data-slug="{{ $post->slug }}"
                                                        id="postCheck{{ $post->id }}">
                                                    <label class="form-check-label" for="postCheck{{ $post->id }}">
                                                        {{ $post->title }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>

                                        <button type="submit" class="btn btn-sm btn-primary mt-3 float-right">Simpan
                                            Menu</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="card card-primary card-outline mb-4">
                            <div class="card-header">
                                <h4 class="text-center">Struktur Menu</h4>
                            </div>
                            <div class="card-body">
                                <ul id="menu-list" class="list-group">
                                    @foreach ($menus as $menu)
                                        @if ($menu->parent_id == null)
                                            <li class="list-group-item" data-id="{{ $menu->id }}">
                                                {{ $menu->title }}
                                                @if ($menu->children)
                                                    <ul class="list-group nested-menu">
                                                        @foreach ($menu->children as $child)
                                                            <li class="list-group-item" data-id="{{ $child->id }}">
                                                                {{ $child->title }}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                                <button id="save-order" class="btn btn-block btn-sm btn-primary mt-2">Simpan Struktur
                                    Menu</button>
                            </div>

                        </div>
                    </div>






                </div>

                <div class="col-md-8">
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h3 class="card-title">Daftar Menu</h3>
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
                            <table id="menu-table" class="table table-sm  table-striped table-hover"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center"><input type="checkbox" id="select-all"></th>
                                        <th>JUDUL</th>
                                        <th>URL</th>
                                        <th>STATUS</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>



            </div>
        </div>
    </section>
</div>




<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editMenu">
                @csrf
                @method('PUT')
                <input type="hidden" id="editId" name="id">
                <div class="modal-body">

                    <div class="form-group row">
                        <label for="edit_menu_nama" class="col-sm-4 col-form-label">Nama Link</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" placeholder="Tambahkan nama link...."
                                name="menus_nama" id="edit_menus_nama" required>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="edit_menus_tautan" class="col-sm-4 col-form-label">URL</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" placeholder="Tambahkan url...."
                                name="menus_tautan" id="edit_menus_tautan" required>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="edit_menus_target" class="col-sm-4 col-form-label">Link Target</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="menus_target" id="edit_menus_target" required>
                                <option value="">Pilih Link Target</option>
                                <option value="_blank">Blank</option>
                                <option value="_self">Self</option>
                                <option value="_top">Top</option>
                                <option value="_parent">Parent</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edit_status" class="col-sm-4 col-form-label">Link Target</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="menus_aktif" id="edit_menus_aktif" required>
                                <option value="">Pilih Status Menu</option>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
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
    $('#menu-table').on('click', '.delete-btn', function() {
        var menusId = $(this).data('id');
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
                    url: `/menu/${menusId}`,
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
                                'Terjadi kesalahan saat menghapus menu.',
                                'error'
                            )
                        }
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'Terjadi kesalahan saat menghapus menu.',
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

                        $('#formTambahMenu').submit(function(event) {
                                event.preventDefault();

                                $.ajax({
                                        url: $(this).attr('action'),
                                        type: 'POST',
                                        data: $(this).serialize(),
                                        success: function(response) {
                                            toastr.success(response.message);
                                            $('#addMenu').modal('hide');
                                            location.reload();
                                            error: function(xhr) {
                                                $.each(xhr.responseJSON.errors, function(key,
                                                    value) {
                                                    toastr.error(value);
                                                });
                                            }
                                        });
                                });
                        });
                });
</script>


<script>
    $(document).ready(function() {


        const baseUrl = $('meta[name="base-url"]').attr('content');


        $('#menu-table').DataTable({
            processing: false,
            serverSide: true,
            responsive: true,
            ordering: false,

            ajax: {
                url: `${baseUrl}/menu/data`,
            },
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

                    data: 'nama_menu',
                    name: 'nama_menu'
                },
                {

                    data: 'tautan',
                    name: 'tautan'
                },
                {
                    data: 'status',
                    name: 'status'
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
                            url: '/menu/delete-selected',
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
                                        'Terjadi kesalahan saat menghapus Menu.',
                                        'error'
                                    )
                                }
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Terjadi kesalahan saat menghapus Menu.',
                                    'error'
                                )
                            }
                        });
                    }
                });
            } else {

                Swal.fire(
                    'Info',
                    'Pilih setidaknya satu Menu untuk dihapus.',
                    'info'
                )
            }
        });
    });
</script>

<script>
    $(document).ready(function() {

        $('#menu-table').on('click', '.edit-btn', function() {
            var id = $(this).data('id');


            $.ajax({
                url: '/menu/' + id + '/fetch',
                type: 'GET',
                success: function(response) {
                    $('#editId').val(response.id);
                    $('#edit_menus_nama').val(response.nama_menu);
                    $('#edit_menus_tautan').val(response.tautan);
                    $('#edit_menus_target').val(response.target_menu);
                    $('#edit_menus_aktif').val(response.menu_aktif);


                    $('#editModal').modal('show');
                },
                error: function(xhr) {
                    console.log('Error:', xhr);
                }
            });
        });


        $('#editMenu').submit(function(e) {
            e.preventDefault();

            var id = $('#editId').val();
            var formData = new FormData(this);


            $.ajax({
                url: '/menu/' + id + '/update',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#editModal').modal('hide');
                    $('#menu-table').DataTable().ajax.reload();
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
