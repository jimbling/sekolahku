<x-header>{{ $judul }}</x-header>
<div class="content-wrapper">
    <x-breadcrumb>{{ $judul }}</x-breadcrumb>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-puzzle-piece mr-2"></i>
                        Daftar Modul Aplikasi
                    </h3>
                    <div class="card-tools">
                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#uploadModuleModal">
                            <i class="fas fa-upload mr-1"></i> Upload Modul
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="width: 25%">Nama Modul</th>
                                    <th style="width: 10%">Alias</th>
                                    <th style="width: 10%">Versi</th>
                                    <th style="width: 25%">Deskripsi</th>
                                    <th style="width: 15%">Status</th>
                                    <th style="width: 15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($modules as $modul)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="mr-3">
                                                    <i class="fas fa-box text-primary fa-lg"></i>
                                                </div>
                                                <div>
                                                    <strong>{{ $modul->name }}</strong>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ $modul->alias }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-light">{{ $modul->version }}</span>
                                        </td>
                                        <td>{{ $modul->description }}</td>
                                        <td>
                                            <form action="{{ route('admin.modules.toggle', $modul) }}" method="POST"
                                                class="toggle-form">
                                                @csrf
                                                @method('PATCH')
                                                <button type="button"
                                                    class="btn btn-sm btn-toggle-status {{ $modul->enabled ? 'btn-success' : 'btn-secondary' }}">
                                                    <i
                                                        class="fas {{ $modul->enabled ? 'fa-toggle-on' : 'fa-toggle-off' }} mr-1"></i>
                                                    {{ $modul->enabled ? 'Aktif' : 'Nonaktif' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-danger btn-delete-module"
                                                data-module-id="{{ $modul->id }}"
                                                data-module-name="{{ $modul->name }}">
                                                <i class="fas fa-trash-alt mr-1"></i> Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($modules->isEmpty())
                    <div class="card-body text-center py-5">
                        <i class="fas fa-puzzle-piece fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Belum ada modul terpasang</h4>
                        <p class="text-muted">Upload modul pertama Anda untuk memulai</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Upload Module Modal -->
    <div class="modal fade" id="uploadModuleModal" tabindex="-1" role="dialog"
        aria-labelledby="uploadModuleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="uploadModuleModalLabel">
                        <i class="fas fa-upload mr-2"></i>Upload Modul Baru
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="moduleUploadForm" action="{{ route('admin.modules.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            Modul harus berupa file ZIP yang berisi struktur direktori yang valid dan file module.json
                        </div>

                        <div class="form-group">
                            <label for="module_zip">File Modul (.zip)</label>
                            <div class="custom-file">
                                <input type="file" name="module_zip" class="custom-file-input" id="module_zip"
                                    required accept=".zip">
                                <label class="custom-file-label" for="module_zip" id="fileLabel">Pilih file
                                    modul...</label>
                            </div>
                            <small class="form-text text-muted" id="fileSizeInfo"></small>
                        </div>

                        <div class="upload-instructions border p-3 mt-3 rounded">
                            <h6><i class="fas fa-question-circle mr-2"></i>Struktur Modul yang Valid</h6>
                            <pre class="mb-0">
modules/
└── your-module/
    ├── module.json
    ├── routes/
    ├── resources/
    └── ...</pre>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload mr-1"></i> Upload & Install
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<x-footer />






<script>
    $(document).ready(function() {
        // Toggle module status with SweetAlert confirmation
        $('.btn-toggle-status').click(function(e) {
            e.preventDefault();
            const button = $(this);
            const form = button.closest('form');
            const moduleName = button.closest('tr').find('td:first strong').text();
            const isActive = button.hasClass('btn-success');

            Swal.fire({
                title: 'Konfirmasi Perubahan Status',
                text: `Anda yakin ingin ${isActive ? 'menonaktifkan' : 'mengaktifkan'} modul ${moduleName}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Ubah Status!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: form.attr('action'),
                        type: 'PATCH',
                        data: form.serialize(),
                        success: function(response) {
                            if (response.success) {
                                // Update button appearance
                                if (response.enabled) {
                                    button.removeClass('btn-secondary').addClass(
                                        'btn-success');
                                    button.html(
                                        '<i class="fas fa-toggle-on mr-1"></i> Aktif'
                                    );
                                } else {
                                    button.removeClass('btn-success').addClass(
                                        'btn-secondary');
                                    button.html(
                                        '<i class="fas fa-toggle-off mr-1"></i> Nonaktif'
                                    );
                                }

                                Swal.fire(
                                    'Berhasil!',
                                    response.message,
                                    'success'
                                );
                            }
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Gagal!',
                                xhr.responseJSON?.message ||
                                'Terjadi kesalahan saat mengubah status modul.',
                                'error'
                            );
                        }
                    });
                }
            });
        });

        // Delete module with SweetAlert confirmation
        $('.btn-delete-module').click(function() {
            const button = $(this);
            const moduleId = button.data('module-id');
            const moduleName = button.data('module-name');

            Swal.fire({
                title: 'Hapus Modul?',
                html: `Anda yakin ingin menghapus modul <strong>${moduleName}</strong>?<br><small class="text-danger">Aksi ini tidak dapat dibatalkan!</small>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan loading swal
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Mohon tunggu sebentar.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: `/admin/modules/${moduleId}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Terhapus!',
                                    text: response.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload(); // reload halaman
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Gagal!',
                                xhr.responseJSON?.message ||
                                'Terjadi kesalahan saat menghapus modul.',
                                'error'
                            );
                        }
                    });
                }
            });
        });


        // Handle module upload form
        $(document).ready(function() {
            // Menampilkan nama file yang dipilih
            $('#module_zip').on('change', function() {
                const fileName = $(this).val().split('\\').pop();
                const fileSize = this.files[0] ? (this.files[0].size / 1024 / 1024).toFixed(2) :
                    0;

                $('#fileLabel').text(fileName || 'Pilih file modul...');
                $('#fileSizeInfo').text(fileName ? `Ukuran file: ${fileSize} MB` : '');
            });

            // Handle form submission
            $('#moduleUploadForm').submit(function(e) {
                e.preventDefault();
                const form = $(this);
                const formData = new FormData(form[0]);
                const submitBtn = form.find('button[type="submit"]');

                // Disable submit button during upload
                submitBtn.prop('disabled', true);
                submitBtn.html('<i class="fas fa-spinner fa-spin mr-1"></i> Mengupload...');

                Swal.fire({
                    title: 'Mengupload Modul',
                    html: 'Sedang memproses modul, harap tunggu...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                        $.ajax({
                            url: form.attr('action'),
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                Swal.fire(
                                    'Berhasil!',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                let errorMessage = xhr.responseJSON
                                    ?.message ||
                                    'Terjadi kesalahan saat mengupload modul.';

                                // Jika validasi gagal, tampilkan error detail
                                if (xhr.status === 422 && xhr
                                    .responseJSON.errors) {
                                    errorMessage = Object.values(xhr
                                        .responseJSON.errors).join(
                                        '<br>');
                                }

                                Swal.fire(
                                    'Gagal!',
                                    errorMessage,
                                    'error'
                                );
                            },
                            complete: function() {
                                submitBtn.prop('disabled', false);
                                submitBtn.html(
                                    '<i class="fas fa-upload mr-1"></i> Upload & Install'
                                );
                            }
                        });
                    }
                });
            });
        });
    });
</script>
