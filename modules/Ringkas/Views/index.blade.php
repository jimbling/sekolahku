<x-header>{{ $judul ?? 'Ringkas' }}</x-header>
<div class="content-wrapper">
    <x-breadcrumb>{{ $judul ?? 'Ringkas' }}</x-breadcrumb>
    <section class="content">
        <div class="container-fluid">
            <!-- Explanation Section - Collapsible -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card card-info card-outline collapsed-card"> <!-- Tambah class collapsed-card -->
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-info-circle mr-2"></i>Apa itu Ringkas?
                                <button type="button" class="btn btn-tool float-right" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i> <!-- Ganti icon jadi plus -->
                                </button>
                            </h3>
                        </div>
                        <div class="card-body" style="display: none;"> <!-- Tambah style display:none -->
                            <p>Ringkas adalah fitur untuk membuat URL tujuan lebih mudah dibaca dan diingat. Berbeda
                                dengan short URL yang menghasilkan link acak yang pendek, Ringkas memungkinkan Anda
                                membuat link yang lebih deskriptif.</p>
                            <p>Format Ringkas URL:</p>
                            <div class="alert alert-light">
                                <code>{{ clean_url(get_setting('website')) }}/ringkas/{slug-yang-dibuat}</code>
                            </div>
                            <p>Contoh:</p>
                            <ul>
                                <li>URL Asli:
                                    <code>https://contoh.com/produk/1234567890/laptop-gaming-terbaru-2023</code>
                                </li>
                                <li>Ringkas URL:
                                    <code>{{ clean_url(get_setting('website')) }}/ringkas/laptop-gaming</code>
                                </li>
                            </ul>
                            <p>Fitur ini berguna untuk:</p>
                            <ul>
                                <li>Membuat link yang lebih mudah diingat</li>
                                <li>Memperpendek URL panjang tanpa kehilangan makna</li>
                                <li>Melacak jumlah kunjungan ke link tersebut</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card stat-card bg-gradient-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="stat-title">TOTAL LINK</h6>
                                    <h3 id="totalLinks" class="stat-value">{{ number_format($totalLinks ?? 0) }}</h3>
                                </div>
                                <div class="stat-icon">
                                    <i class="fas fa-link"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stat-card bg-gradient-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="stat-title">TOTAL KUNJUNGAN</h6>
                                    <h3 id="totalHits" class="stat-value">{{ number_format($totalHits ?? 0) }}</h3>
                                </div>
                                <div class="stat-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stat-card bg-gradient-info">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="stat-title">LINK AKTIF</h6>
                                    <h3 id="activeLinks" class="stat-value">{{ number_format($activeLinks ?? 0) }}</h3>
                                </div>
                                <div class="stat-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">

                    <!-- Main Card -->
                    <div class="card card-modern">
                        <div class="card-header bg-white border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title m-0">
                                    <i class="fas fa-share-alt mr-2"></i>Ringkas URL
                                </h3>
                                <button class="btn btn-primary btn-add" data-toggle="modal" data-target="#modalTambah">
                                    <i class="fas fa-plus mr-1"></i> Link Baru
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <!-- Search and Filter -->
                            <table id="ringkasTable" class="table class="table table-sm table-striped table-hover
                                table-responsive-lg" style="width:100%" text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Ringkas URL</th>
                                        <th>URL Asli</th>
                                        <th>Aktif</th>
                                        <th>Hit</th>
                                        <th>Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<x-footer />

@include('ringkas::partials._modal')

<style>
    /* Modern Card Styling */
    .card-modern {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .stat-card {
        border: none;
        border-radius: 8px;
        color: white;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-title {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.9;
        margin-bottom: 5px;
    }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0;
    }

    .stat-icon {
        font-size: 2.5rem;
        opacity: 0.3;
    }

    /* URL List Styling */
    .url-list {
        min-height: 400px;
    }

    .url-item {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f1f1f1;
        transition: background-color 0.2s;
    }

    .url-item:hover {
        background-color: #f9f9f9;
    }

    .url-short {
        font-weight: 600;
        color: #2c3e50;
    }

    .url-original {
        color: #7f8c8d;
        font-size: 0.9rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .url-meta {
        font-size: 0.8rem;
        color: #95a5a6;
    }

    .badge-hit {
        background-color: #e3f2fd;
        color: #1976d2;
    }

    /* Button Styling */
    .btn-add {
        border-radius: 50px;
        padding: 0.375rem 1.25rem;
        font-weight: 500;
        box-shadow: 0 2px 10px rgba(0, 123, 255, 0.3);
    }

    .btn-action {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin: 0 2px;
    }

    /* Input Styling */
    .input-group-modern .input-group-text {
        border-right: none;
        background-color: white;
    }

    .input-group-modern .form-control {
        border-left: none;
    }

    /* Loading Animation */
    .loading-content {
        color: #7f8c8d;
    }

    /* Toggle Switch */
    .switch {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 22px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #28a745;
    }

    input:checked+.slider:before {
        transform: translateX(22px);
    }
</style>



<script>
    // Setup CSRF
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Variabel global
    let table; // Untuk instance DataTable
    let pollingInterval; // Untuk polling

    // Fungsi ambil statistik
    function fetchStats() {
        $.get('{{ route('ringkas.stats') }}', function(data) {
            $('#totalLinks').text(data.totalLinks.toLocaleString());
            $('#totalHits').text(data.totalHits.toLocaleString());
            $('#activeLinks').text(data.activeLinks.toLocaleString());
        }).fail(function() {
            console.warn('Gagal memuat statistik');
        });
    }

    // Fungsi refresh DataTable + Statistik
    function refreshData() {
        if (table) {
            table.ajax.reload(function() {
                $('[data-toggle="tooltip"]').tooltip(); // tooltip setelah reload
            }, false);
        }
        fetchStats();
    }

    // POLLING saat tab aktif
    function startPolling() {
        refreshData(); // Jalankan awal
        pollingInterval = setInterval(refreshData, 30000); // setiap 30 detik
    }

    function stopPolling() {
        clearInterval(pollingInterval);
    }

    // Cek tab aktif/tidak
    document.addEventListener('visibilitychange', function() {
        if (document.visibilityState === 'visible') {
            startPolling();
        } else {
            stopPolling();
        }
    });

    // Jalankan saat tab aktif pertama kali
    if (document.visibilityState === 'visible') {
        startPolling();
    }

    // ======================== //
    // Mulai saat halaman siap //
    // ======================== //
    $(document).ready(function() {

        // Inisialisasi DataTable sekali
        table = $('#ringkasTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('ringkas.data') }}',
            columns: [{
                    data: 'slug',
                    name: 'slug'
                },
                {
                    data: 'original_url',
                    name: 'original_url'
                },
                {
                    data: 'is_active',
                    name: 'is_active',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'hit_count',
                    name: 'hit_count'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false
                }
            ],
            drawCallback: function() {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

        // Copy URL
        $(document).on('click', '.copy-btn', function(e) {
            e.preventDefault();
            const text = $(this).data('url');

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(() => {
                    toastr.success('URL berhasil disalin!');
                }).catch(() => {
                    toastr.error('Gagal menyalin URL');
                });
            } else {
                let tempInput = $("<input>");
                $("body").append(tempInput);
                tempInput.val(text).select();
                document.execCommand("copy");
                tempInput.remove();
                toastr.success('URL berhasil disalin (fallback)!');
            }
        });

        // Modal tambah
        $('[data-target="#modalTambah"]').click(function() {
            $('#modalTitle').text('Tambah Link');
            $('#formRingkas')[0].reset();
            $('#form-id').val('');
        });

        // Modal edit
        $(document).on('click', '.btnEdit', function() {
            $('#modalTitle').text('Edit Link');
            $('#form-id').val($(this).data('id'));
            $('#form-slug').val($(this).data('slug'));
            $('#form-url').val($(this).data('url'));
            $('#form-description').val($(this).data('description'));
            $('#modalTambah').modal('show');
        });

        // Submit form tambah/edit
        $('#formRingkas').submit(function(e) {
            e.preventDefault();
            const id = $('#form-id').val();
            const url = id ? `/admin/ringkas/${id}` : `{{ route('ringkas.store') }}`;
            const formData = $(this).serialize() + (id ? '&_method=PUT' : '');

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(res) {
                    toastr.success(res.message);
                    $('#modalTambah').modal('hide');
                    refreshData(); // setelah simpan, reload data
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON.errors;
                    for (const key in errors) {
                        toastr.error(errors[key][0]);
                    }
                }
            });
        });

        // Hapus link
        $(document).on('submit', 'form.deleteForm', function(e) {
            e.preventDefault();
            const form = $(this);

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Data yang dihapus tidak bisa dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: form.attr('action'),
                        type: 'POST',
                        data: form.serialize(),
                        success: function(res) {
                            toastr.success(res.message);
                            refreshData();
                        },
                        error: function() {
                            toastr.error('Gagal menghapus data.');
                        }
                    });
                }
            });
        });

        // Toggle status aktif/tidak
        $('#ringkasTable').on('click', '.btnToggleStatus', function() {
            const id = $(this).data('id');
            const currentStatus = $(this).data('status');
            const statusText = currentStatus ? 'nonaktifkan' : 'aktifkan';

            Swal.fire({
                title: 'Yakin?',
                text: `Kamu akan ${statusText} link ini.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/ringkas/${id}/status`,
                        type: 'POST',
                        data: {
                            is_active: currentStatus ? 0 : 1
                        },
                        success: function(res) {
                            toastr.success(res.message);
                            refreshData();
                        },
                        error: function() {
                            toastr.error('Gagal mengubah status.');
                        }
                    });
                }
            });
        });
    });
</script>
