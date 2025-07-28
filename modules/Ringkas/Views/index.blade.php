<x-header>{{ $judul ?? 'Ringkas' }}</x-header>
<div class="content-wrapper">
    <x-breadcrumb>{{ $judul ?? 'Ringkas' }}</x-breadcrumb>
    <section class="content">
        <div class="container-fluid">
            <!-- Explanation Section - Collapsible -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card card-info card-outline collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-link mr-2"></i> Apa itu Ringkas?
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body" style="display: none;">
                            <p>
                                <strong>Ringkas</strong> adalah fitur untuk membuat URL panjang menjadi lebih pendek,
                                mudah diingat, dan tetap bermakna.
                                Berbeda dengan layanan short URL yang biasanya menghasilkan kode acak, Ringkas
                                memungkinkan Anda
                                membuat <em>slug</em> yang deskriptif sesuai kebutuhan.
                            </p>

                            <h5 class="text-primary mt-3"><i class="fas fa-cogs mr-1"></i> Bagaimana formatnya?</h5>
                            <div class="alert alert-light border">
                                <code>{{ clean_url(get_setting('website')) }}/ringkas/{slug-yang-dibuat}</code>
                            </div>

                            <h5 class="text-primary mt-3"><i class="fas fa-lightbulb mr-1"></i> Contoh:</h5>
                            <ul>
                                <li>URL Asli: <br>
                                    <code>https://contoh.com/produk/1234567890/laptop-gaming-terbaru-2023</code>
                                </li>
                                <li>Ringkas URL: <br>
                                    <code>{{ clean_url(get_setting('website')) }}/ringkas/laptop-gaming</code>
                                </li>
                            </ul>

                            <h5 class="text-primary mt-3"><i class="fas fa-star mr-1"></i> Kenapa menggunakan Ringkas?
                            </h5>
                            <ul class="mb-0">
                                <li><strong>Mudah diingat</strong> – URL lebih singkat dan deskriptif.</li>
                                <li><strong>Lebih rapi</strong> – Membuat link panjang terlihat profesional.</li>
                                <li><strong>Bisa dilacak</strong> – Mengetahui jumlah klik atau kunjungan.</li>
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
                <!-- Kolom Kiri: Daftar Link -->
                <div class="col-md-8">
                    <div class="mb-3">
                        <input type="text" id="searchInput" class="form-control"
                            placeholder="Cari berdasarkan slug, URL, atau deskripsi...">
                    </div>
                    <div id="ringkasList" class="list-group list-group-flush mb-4"></div>
                    <div id="paginationLinks" class="d-flex justify-content-center"></div>


                </div>

                <!-- Kolom Kanan: Form Tambah/Edit Link -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title" id="formTitle">Tambah Tautan Baru</h3>
                        </div>
                        <div class="card-body">
                            <form id="formRingkas">
                                <input type="hidden" id="form-id" name="id">
                                <div class="form-group">
                                    <label for="form-url">URL Panjang</label>
                                    <input type="url" class="form-control" id="form-url" name="original_url"
                                        required placeholder="https://">
                                </div>
                                <div class="form-group">
                                    <label for="form-slug">Custom Slug/Url Ringkas</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="form-slug" name="slug"
                                            placeholder="contoh: link-saya">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="form-description">Deskripsi (opsional)</label>
                                    <textarea class="form-control" id="form-description" name="description" rows="2"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                                <button type="button" class="btn btn-default btn-block mt-2" id="btnCancelEdit"
                                    style="display: none;">
                                    <i class="fas fa-times"></i> Batal Edit
                                </button>
                            </form>
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
    const WEBSITE_BASE_URL = "{{ rtrim(get_setting('website'), '/') }}";
</script>

<script>
    // Setup CSRF
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let searchQuery = '';

    function renderCard(item) {
        item.full_url = `${WEBSITE_BASE_URL}/ringkas/${item.slug}`;
        const displayUrl = `${WEBSITE_BASE_URL.replace(/^https?:\/\//, '')}/ringkas/${item.slug}`;
        const isActive = parseInt(item.is_active) === 1;

        return `
<div class="card card-ringkas mb-3 ${isActive ? '' : 'card-inactive'}">
    <div class="card-body p-3 d-flex flex-column">
        <div class="d-flex justify-content-between align-items-start">
            <div class="flex-grow-1 mr-3 overflow-hidden">
                <div class="d-flex align-items-center mb-1 flex-wrap">
                    <!-- URL display -->
                    <a href="${item.full_url}" target="_blank" class="slug-link text-truncate d-inline-block mr-2" style="max-width: 100%">
                        ${displayUrl}
                    </a>
                   

                    <!-- Desktop badge -->
                    <span class="badge badge-${isActive ? 'success' : 'secondary'} badge-pill flex-shrink-0 d-none d-md-inline-flex">
                        ${item.hit_count} <i class="fas fa-eye"></i>
                    </span>
                </div>
                <div class="original-url text-truncate" title="${item.original_url}">
                    <i class="fas fa-link mr-1"></i>
                    ${item.original_url.length > 40 ? item.original_url.substring(0, 40) + '…' : item.original_url}
                </div>
            </div>

            <!-- Desktop Actions -->
            <div class="d-none d-md-flex align-items-center">
                <button class="btn btn-sm btn-outline-primary mr-2 copy-btn" 
                        data-url="${item.full_url}" 
                        title="Salin URL">
                    <i class="fas fa-copy"></i>
                </button>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                        <i class="fas fa-cog"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <button class="dropdown-item btnEdit" 
                                data-id="${item.id}"
                                data-slug="${item.slug}"
                                data-url="${item.original_url}"
                                data-description="${item.description}">
                            <i class="fas fa-edit mr-2"></i>Edit
                        </button>
                        <button class="dropdown-item btnToggleStatus"
                                data-id="${item.id}"
                                data-status="${isActive ? 1 : 0}">
                            <i class="fas fa-power-off mr-2"></i>
                            ${isActive ? 'Nonaktifkan' : 'Aktifkan'}
                        </button>
                        <div class="dropdown-divider"></div>
                        <form method="POST" class="deleteForm" action="/admin/ringkas/${item.id}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="dropdown-item text-danger" type="submit">
                                <i class="fas fa-trash mr-2"></i>Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="card-footer text-muted small">
                <i class="far fa-clock"></i> ${item.created_at}
            </div>
            <div class="d-flex d-md-none align-items-center">
                <!-- Mobile badge -->
                <span class="badge badge-${isActive ? 'success' : 'secondary'} badge-pill mr-2">
                    ${item.hit_count} <i class="fas fa-eye"></i>
                </span>
                <button class="btn btn-sm btn-outline-primary mr-2 copy-btn" 
                        data-url="${item.full_url}" 
                        title="Salin URL">
                    <i class="fas fa-copy"></i>
                </button>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <button class="dropdown-item btnEdit" 
                                data-id="${item.id}"
                                data-slug="${item.slug}"
                                data-url="${item.original_url}"
                                data-description="${item.description}">
                            <i class="fas fa-edit mr-2"></i>Edit
                        </button>
                        <button class="dropdown-item btnToggleStatus"
                                data-id="${item.id}"
                                data-status="${isActive ? 1 : 0}">
                            <i class="fas fa-power-off mr-2"></i>
                            ${isActive ? 'Nonaktifkan' : 'Aktifkan'}
                        </button>
                        <div class="dropdown-divider"></div>
                        <form method="POST" class="deleteForm" action="/admin/ringkas/${item.id}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="dropdown-item text-danger" type="submit">
                                <i class="fas fa-trash mr-2"></i>Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>`;
    }





    // Fungsi reset form
    function resetForm() {
        $('#form-id').val('');
        $('#form-url').val('');
        $('#form-slug').val('');
        $('#form-description').val('');
        $('#formTitle').text('Tambah Tautan Baru');
        $('#btnCancelEdit').hide();
    }

    function renderPagination(pagination) {
        let html = `<nav><ul class="pagination">`;

        const current = pagination.current_page;
        const last = pagination.last_page;

        // Previous
        html += `
        <li class="page-item ${!pagination.prev_page_url ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="${current - 1}">‹</a>
        </li>`;

        // Page numbers (simple range logic)
        const range = 2; // Number of pages to show before/after current
        for (let i = Math.max(1, current - range); i <= Math.min(last, current + range); i++) {
            html += `
            <li class="page-item ${i === current ? 'active' : ''}">
                <a class="page-link" href="#" data-page="${i}">${i}</a>
            </li>`;
        }

        // Next
        html += `
        <li class="page-item ${!pagination.next_page_url ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="${current + 1}">›</a>
        </li>`;

        html += `</ul></nav>`;
        return html;
    }

    function getStats() {
        $.get('{{ route('ringkas.stats') }}', function(res) {
            $('#totalLinks').text(res.totalLinks.toLocaleString());
            $('#totalHits').text(res.totalHits.toLocaleString());
            $('#activeLinks').text(res.activeLinks.toLocaleString());
        });
    }


    // Load data dengan pencarian
    function loadRingkasList(page = 1) {
        $.get('{{ route('ringkas.data') }}', {
            page: page,
            q: searchQuery
        }, function(res) {
            const container = $('#ringkasList');
            const pagin = $('#paginationLinks');
            container.empty();
            res.data.forEach(item => container.append(renderCard(item)));
            pagin.html(renderPagination(res.pagination));
        });
    }

    // Event pencarian
    $('#searchInput').on('input', function() {
        searchQuery = $(this).val();
        loadRingkasList(1);
    });

    // Handle pagination clicks
    $(document).on('click', '#paginationLinks .page-link', function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        if (page) {
            loadRingkasList(page);
        }
    });


    // Saat dokumen siap
    $(document).ready(function() {
        loadRingkasList();
        getStats();

        // Tombol Tambah Baru
        $('.btn-add').click(function() {
            resetForm();
            $('html, body').animate({
                scrollTop: $(".card-title:contains('Tambah Tautan Baru')").offset().top
            }, 500);
        });

        // Tombol Batal Edit
        $('#btnCancelEdit').click(function() {
            resetForm();
        });

        // Event: Submit form (Tambah/Edit)
        $('#formRingkas').submit(function(e) {
            e.preventDefault();
            const id = $('#form-id').val();
            const url = id ? `/admin/ringkas/${id}` : `{{ route('ringkas.store') }}`;
            const method = id ? 'PUT' : 'POST';
            const formData = $(this).serialize() + (id ? '&_method=PUT' : '');

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(res) {
                    toastr.success(res.message);
                    resetForm();
                    loadRingkasList();
                    getStats();
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON.errors;
                    for (const key in errors) {
                        toastr.error(errors[key][0]);
                    }
                }
            });
        });

        // Edit Link
        $(document).on('click', '.btnEdit', function() {
            $('#form-id').val($(this).data('id'));
            $('#form-url').val($(this).data('url'));
            $('#form-slug').val($(this).data('slug'));
            $('#form-description').val($(this).data('description'));
            $('#formTitle').text('Edit Tautan');
            $('#btnCancelEdit').show();

            $('html, body').animate({
                scrollTop: $(".card-title:contains('Edit Tautan')").offset().top
            }, 500);
        });

        // Fungsi Copy URL
        $(document).on('click', '.copy-btn', function(e) {
            e.preventDefault();
            const urlToCopy = $(this).data('url');

            // Buat elemen input sementara
            const tempInput = document.createElement('input');
            tempInput.value = urlToCopy;
            document.body.appendChild(tempInput);

            // Select dan copy text
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);

            // Beri feedback ke user
            const originalIcon = $(this).html();
            $(this).html('<i class="fas fa-check"></i>');
            $(this).removeClass('btn-outline-primary').addClass('btn-success');
            toastr.success('URL berhasil disalin!');

            // Kembalikan icon setelah 1 detik
            setTimeout(() => {
                $(this).html(originalIcon);
                $(this).removeClass('btn-success').addClass('btn-outline-primary');
            }, 1000);
        });

        // Hapus data
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
                            loadRingkasList();
                            getStats();
                        },
                        error: function() {
                            toastr.error('Gagal menghapus data.');
                        }
                    });
                }
            });
        });

        // Toggle status aktif/nonaktif
        $(document).on('click', '.btnToggleStatus', function() {
            const id = $(this).data('id');
            const currentStatus = $(this).data('status');

            Swal.fire({
                title: 'Ubah status link?',
                text: `Kamu akan ${currentStatus ? 'menonaktifkan' : 'mengaktifkan'} link ini.`,
                icon: 'question',
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
                            loadRingkasList();
                            getStats();
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
