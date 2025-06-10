<x-header>{{ $judul }}</x-header>
<div class="content-wrapper">
    <x-breadcrumb>{{ $judul }}</x-breadcrumb>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Widget</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 40%">Widget</th>
                                    <th>Tipe</th>
                                    <th>Status</th>
                                    <th>Posisi</th>
                                    <th style="width: 15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="widget-list">
                                @foreach ($widgets as $widget)
                                    <tr data-id="{{ $widget->id }}">
                                        <td>
                                            <strong>{{ $widget->title ?? $widget->name }}</strong><br>
                                            <small class="text-muted">{{ $widget->name }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $widget->type }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $widget->is_active ? 'success' : 'secondary' }}">
                                                {{ $widget->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>
                                        <td>{{ $widget->position }}</td>
                                        <td class="text-right">
                                            <button class="btn btn-sm btn-primary edit-widget"
                                                data-id="{{ $widget->id }}" data-name="{{ $widget->name }}"
                                                data-title="{{ $widget->title }}" data-type="{{ $widget->type }}"
                                                data-position="{{ $widget->position }}"
                                                data-active="{{ $widget->is_active }}"
                                                data-settings="{{ json_encode($widget->settings) }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-right">
                        <small class="text-muted">Total {{ count($widgets) }} widget</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="widgetModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form method="POST" id="widgetForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Widget</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="modal-name">Nama Unik</label>
                                        <input type="text" name="name" class="form-control" id="modal-name"
                                            placeholder="Nama unik widget">
                                        <small class="form-text text-muted">Digunakan untuk referensi kode</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="modal-title">Judul Tampilan</label>
                                        <input type="text" name="title" class="form-control" id="modal-title"
                                            placeholder="Judul yang ditampilkan">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="modal-position">Posisi</label>
                                        <input type="number" name="position" class="form-control" id="modal-position"
                                            placeholder="Urutan tampilan">
                                    </div>
                                </div>
                            </div>



                            <div class="form-group">
                                <label for="modal-settings">Pengaturan</label>
                                <div class="card">
                                    <div class="card-body p-0">
                                        <textarea name="settings" class="form-control" id="modal-settings" rows="2" style="font-family: monospace;"></textarea>
                                    </div>
                                    <div class="card-footer">
                                        <small class="text-muted">Format JSON. Sesuaikan dengan tipe widget.</small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="is_active" class="custom-control-input"
                                        id="modal-active">
                                    <label class="custom-control-label" for="modal-active">Aktifkan Widget</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                    class="fas fa-times"></i> Batal</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan
                                Perubahan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<x-footer></x-footer>


<script>
    $(document).ready(function() {
        // Initialize modal with data
        $('.edit-widget').on('click', function() {
            const data = $(this).data();
            const modal = $('#widgetModal');

            modal.find('#modal-name').val(data.name);
            modal.find('#modal-title').val(data.title);
            modal.find('#modal-type').val(data.type);
            modal.find('#modal-position').val(data.position);
            modal.find('#modal-active').prop('checked', data.active);

            // Format JSON settings with proper indentation
            try {
                const formattedSettings = JSON.stringify(JSON.parse(data.settings), null, 2);
                modal.find('#modal-settings').val(formattedSettings);
            } catch (e) {
                modal.find('#modal-settings').val(data.settings);
            }

            // Set form action URL
            const url = `/widgets/${data.id}`;
            modal.find('#widgetForm').attr('action', url);

            // Show modal
            modal.modal('show');
        });

        // Add syntax highlighting to JSON editor
        $('#modal-settings').on('focus', function() {
            $(this).addClass('bg-light');
        }).on('blur', function() {
            $(this).removeClass('bg-light');
        });
    });
</script>

<script>
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
</script>
