<x-header>{{ $judul ?? 'Formulir' }}</x-header>
<div class="content-wrapper">
    <x-breadcrumb>{{ $judul ?? 'Formulir' }}</x-breadcrumb>
    <section class="content">
        <div class="container-fluid">
            <!-- Baris Atas: Google Auth Kiri, Tombol Tambah Kanan -->
            <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap">

                <!-- Kiri: Google Auth -->
                <div class="mb-2 mb-md-0">
                    @if (Auth::user() && Auth::user()->google_id)
                        <div class="d-flex align-items-center bg-white border rounded shadow-sm px-3 py-2">
                            <img src="{{ Auth::user()->avatar }}" alt="Avatar" class="rounded-circle mr-2" width="32"
                                height="32">
                            <div class="mr-3 text-left">
                                <small class="d-block font-weight-bold text-dark mb-0">
                                    {{ Auth::user()->name }}
                                </small>
                                <small class="text-muted">{{ Auth::user()->email }}</small>
                            </div>
                            <span class="badge badge-success px-2 py-1 mr-2">
                                <i class="fab fa-google mr-1"></i> Terhubung
                            </span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn btn-sm btn-outline-secondary shadow-sm" type="submit">
                                    <i class="fas fa-sign-out-alt mr-1"></i> Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="https://auth.sinaucms.web.id/google/redirect?redirect={{ urlencode(route('google.auth.callback')) }}"
                            class="btn btn-outline-danger shadow-sm d-flex align-items-center px-4 py-2">
                            <i class="fab fa-google mr-2 fa-lg"></i>
                            <span>Login dengan Google</span>
                        </a>
                    @endif
                </div>

                <!-- Kanan: Tombol Tambah Formulir -->
                <div>
                    <button type="button" class="btn btn-primary btn-lg shadow-sm" data-toggle="modal"
                        data-target="#createFormModal">
                        <i class="fas fa-plus-circle mr-2"></i> Buat Formulir Baru
                    </button>
                </div>

            </div>


            <!-- Modal Create Form -->
            <div class="modal fade" id="createFormModal" tabindex="-1" role="dialog"
                aria-labelledby="createFormModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content border-0 shadow-lg">
                        <form id="createForm" action="{{ route('formulir.store') }}" method="POST">
                            @csrf
                            <div class="modal-header bg-gradient-primary text-white">
                                <h5 class="modal-title" id="createFormModalLabel">Formulir Baru</h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="title">Judul Formulir <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" required
                                        placeholder="Contoh: Form Pendaftaran Anggota">
                                </div>

                                <div class="form-group mt-3">
                                    <label for="description">Deskripsi (Opsional)</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi singkat tentang formulir ini"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer border-top-0">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <span class="btn-text">
                                        <i class="fas fa-save mr-1"></i> Simpan & Kelola
                                    </span>
                                    <span class="btn-loading d-none">
                                        <i class="fas fa-spinner fa-spin mr-1"></i> Sedang diproses...
                                    </span>
                                </button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Daftar Formulir -->
            <div id="form-list">
                @include('formulir::partials._list')
            </div>

        </div>
    </section>
</div>
<x-footer />

<script>
    function renderSkeletonLoading(count = 4) {
        let skeletons = '';
        for (let i = 0; i < count; i++) {
            skeletons += `
        <div class="skeleton-card">
            <div class="skeleton-header"></div>
            <div class="skeleton-body">
                <div class="skeleton-line" style="width: 60%"></div>
                <div class="skeleton-line" style="width: 90%"></div>
                <div class="skeleton-line" style="width: 40%"></div>
                <div class="skeleton-footer">
                    <div class="skeleton-button"></div>
                    <div class="skeleton-button"></div>
                </div>
            </div>
        </div>`;
        }

        return `<div class="skeleton-loader">${skeletons}</div>`;
    }

    $(document).ready(function() {
        const $submitBtn = $('#submitBtn');
        const $spinner = $submitBtn.find('.spinner-border');
        const $btnText = $submitBtn.find('.btn-text');
        const $btnLoading = $submitBtn.find('.btn-loading');

        $('#createForm').on('submit', function(e) {
            e.preventDefault();

            // Aktifkan loading
            $submitBtn.prop('disabled', true);
            $spinner.removeClass('d-none');
            $btnText.addClass('d-none');
            $btnLoading.removeClass('d-none');

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#createFormModal').modal('hide');
                    toastr.success('Formulir berhasil dibuat!');
                    $('#createForm')[0].reset();

                    // Refresh list
                    $('#form-list').html(renderSkeletonLoading(4));
                    fetch('{{ route('formulir.refreshList') }}')
                        .then(res => res.text())
                        .then(html => {
                            $('#form-list').html(html);
                        });
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON.message || 'Gagal membuat formulir');
                },
                complete: function() {
                    // Reset tombol
                    $submitBtn.prop('disabled', false);
                    $spinner.addClass('d-none');
                    $btnText.removeClass('d-none');
                    $btnLoading.addClass('d-none');
                }
            });
        });

        $('#createFormModal').on('hidden.bs.modal', function() {
            $('#createForm')[0].reset();

            // Reset tombol jika modal ditutup manual
            $submitBtn.prop('disabled', false);
            $spinner.addClass('d-none');
            $btnText.removeClass('d-none');
            $btnLoading.addClass('d-none');
        });
    });



    function confirmDelete(url, rowId = null) {
        Swal.fire({
            title: 'Hapus Formulir?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.type === 'success') {
                            toastr.success(data.message);

                            // Hapus elemen
                            if (rowId) {
                                const row = document.getElementById(rowId);
                                if (row) row.remove();
                            }

                            // Cek apakah masih ada card tersisa
                            const remaining = document.querySelectorAll('#form-list [id^="form-card-"]');
                            if (remaining.length === 0) {
                                // Semua formulir sudah dihapus → render ulang dari server
                                $('#form-list').html(renderSkeletonLoading(4));
                                fetch('{{ route('formulir.refreshList') }}')
                                    .then(res => res.text())
                                    .then(html => {
                                        $('#form-list').html(html);
                                    });
                            }

                        } else {
                            toastr.error(data.message || 'Gagal menghapus formulir.');
                        }
                    })
                    .catch(() => {
                        toastr.error('Terjadi kesalahan saat menghapus.');
                    });
            }
        });
    }
</script>


<script>
    // Handle Sinkronisasi
    document.querySelectorAll('.sync-google-sheet-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Sinkronkan Google Sheet?',
                text: "Data akan diperbarui di Google Sheet.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Sinkronkan!',
                cancelButtonText: 'Batal',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return new Promise(resolve => {
                        form.submit();
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            });
        });
    });

    // Handle Hubungkan
    document.querySelectorAll('.connect-google-sheet-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Hubungkan ke Google Sheet?',
                text: "Formulir akan tersambung ke Spreadsheet Google.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hubungkan!',
                cancelButtonText: 'Batal',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return new Promise(resolve => {
                        form.submit();
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            });
        });
    });

    // Tampilkan pesan sukses jika ada dari session
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 2500,
            showConfirmButton: false
        });
    @endif
</script>

<script>
    function copyToClipboard(text) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(function() {
                toastr.success('Link berhasil disalin!');
            }).catch(function() {
                toastr.error('Gagal menyalin link!');
            });
        } else {
            const textarea = document.createElement("textarea");
            textarea.value = text;
            textarea.style.position = "fixed";
            textarea.style.opacity = 0;
            document.body.appendChild(textarea);
            textarea.focus();
            textarea.select();

            try {
                document.execCommand('copy');
                toastr.success('Link berhasil disalin!');
            } catch (err) {
                toastr.error('Gagal menyalin link!');
            }

            document.body.removeChild(textarea);
        }
    }
</script>
