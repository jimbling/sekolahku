<x-header>{{ $judul }}</x-header>
<div class="content-wrapper">
    <x-breadcrumb>{{ $judul }}</x-breadcrumb>

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h3 class="card-title">Daftar Pesan Masuk</h3>
                                </div>
                                <div class="col-md-4 text-right">

                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="messages-table" class="table table-sm table-striped table-hover"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pengirim</th>
                                        <th>Email</th>
                                        <th>Tanggal Kirim</th>
                                        <th>Action</th>
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
<x-footer></x-footer>

<script>
    $(function() {
        $('#messages-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.messages.data') }}',
            columns: [{
                    data: null,
                    name: 'index',
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data) {
                        return moment(data).format('DD MMMM YYYY - HH:mm [WIB]');
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            // Menambahkan rowCallback untuk mengubah warna baris
            rowCallback: function(row, data) {
                if (data.is_read == 0) {
                    $(row).addClass(
                        'table-danger'); // Menambah kelas Bootstrap untuk warna merah muda
                }
            }
        });
    });
</script>
