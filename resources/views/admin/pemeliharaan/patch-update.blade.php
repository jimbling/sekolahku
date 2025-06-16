<x-header>{{ $judul }}</x-header>

<div class="content-wrapper">
    <x-breadcrumb>{{ $judul }}</x-breadcrumb>

    <section class="content">
        <div class="container-fluid">




            <div class="row">
                <div class="col-md-12">
                    <div class="card card-warning card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-sync-alt mr-2"></i>Cek Pembaruan
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <button id="checkUpdateBtn" class="btn btn-warning btn-lg">
                                    <i class="fas fa-sync-alt mr-2"></i> Cek Pembaruan Sekarang
                                </button>
                                <div class="mt-3">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle mr-1"></i> Sistem akan mengecek versi terbaru dari
                                        server
                                    </small>
                                </div>
                            </div>

                            <div id="updateResult" class="mt-4"></div>
                        </div>
                    </div>
                </div>
                <!-- Upload Patch Card -->
                <div class="col-md-6">


                    <div class="card card-primary card-outline">
                        <div class="card-header border-bottom-0">
                            <h3 class="card-title">
                                <i class="fas fa-cloud-upload-alt mr-2"></i>Upload File Patch
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body pt-0">
                            @if (!$isRegistered)
                                <div class="alert alert-warning alert-dismissible fade show">
                                    <h5><i class="icon fas fa-exclamation-circle"></i> Sistem Belum Terdaftar!</h5>
                                    <p>Silakan daftarkan domain terlebih dahulu sebelum melakukan pembaruan sistem.</p>
                                    <div class="text-right">
                                        <a href="{{ route('school.register') }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-user-plus mr-1"></i> Daftarkan Sekarang
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <form id="formUploadPatch" action="{{ route('patch.upload') }}" method="POST"
                                enctype="multipart/form-data" class="mt-3">
                                @csrf

                                <div class="form-group">
                                    <label for="patch_file" class="font-weight-bold">
                                        <i class="fas fa-file-archive mr-1"></i> File Patch (ZIP)
                                    </label>
                                    <div class="custom-file">
                                        <input type="file" name="patch_file" class="custom-file-input"
                                            id="patchFileInput" accept=".zip" {{ !$isRegistered ? 'disabled' : '' }}
                                            required>
                                        <label class="custom-file-label" for="patchFileInput" data-browse="Pilih File">
                                            Pilih file .zip
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">
                                        Ukuran maksimal: 50MB. Pastikan file sesuai dengan versi saat ini.
                                    </small>
                                </div>

                                <div class="text-center mt-4">
                                    <button type="button" id="btnUploadPatch" class="btn btn-lg btn-success px-4"
                                        {{ !$isRegistered ? 'disabled' : '' }}>
                                        <i class="fas fa-upload mr-2"></i> Upload & Install Patch
                                    </button>
                                </div>
                            </form>
                        </div>

                        @if ($isRegistered)
                            <div class="card-footer bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle mr-1"></i> Pastikan backup data sebelum menginstall
                                        patch
                                    </small>
                                    <small class="text-right">
                                        <i class="fas fa-history mr-1"></i> Terakhir update:
                                        {{ $versi?->applied_at ? \Carbon\Carbon::parse($versi->applied_at)->timezone('Asia/Jakarta')->format('d M Y, H:i') : '-' }}
                                    </small>

                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Version Info & History -->
                <div class="col-md-6">
                    <!-- Current Version -->
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-code-branch mr-2"></i>Versi Saat Ini
                            </h3>
                        </div>
                        <div class="card-body">
                            @if ($isRegistered)
                                <div class="text-center mb-3">
                                    <div class="version-badge">
                                        {{ $versi->version ?? '0.0.0' }}
                                    </div>
                                </div>

                                <div class="changelog-box">
                                    <h5 class="font-weight-bold mb-3">Catatan Perubahan:</h5>
                                    <div class="changelog-content">
                                        {!! $versi->changelog ? nl2br(e($versi->changelog)) : '<p class="text-muted">Tidak ada catatan perubahan.</p>' !!}
                                    </div>
                                </div>

                                <div class="version-meta mt-3">
                                    <div class="d-flex justify-content-between">
                                        <span>
                                            <i class="fas fa-calendar-alt mr-1"></i>
                                            {{ $versi?->applied_at ? \Carbon\Carbon::parse($versi->applied_at)->format('d M Y') : '-' }}
                                        </span>
                                        <span>
                                            <i class="fas fa-clock mr-1"></i>
                                            {{ $versi?->applied_at ? \Carbon\Carbon::parse($versi->applied_at)->format('H:i') : '-' }}
                                        </span>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-exclamation-triangle fa-2x text-warning mb-3"></i>
                                    <h5 class="text-muted">Sistem Belum Terdaftar</h5>
                                    <p class="text-muted">Versi saat ini tidak tersedia</p>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

                <div class="col-md-12">
                    <!-- Patch History -->
                    <div class="card card-secondary card-outline mt-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-history mr-2"></i>Riwayat Patch
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th width="100px">Versi</th>
                                            <th>Nama Patch</th>
                                            <th width="100px">Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($riwayat as $patch)
                                            <tr>
                                                <td class="font-weight-bold text-primary">{{ $patch->version }}</td>
                                                <td>
                                                    <div class="font-weight-bold">{{ $patch->name }}</div>
                                                    <small
                                                        class="text-muted">{{ Str::limit($patch->description, 50) }}</small>
                                                </td>
                                                <td>
                                                    <small
                                                        class="text-muted">{{ $patch->installed_at->format('d M Y') }}</small>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center py-4 text-muted">
                                                    <i class="fas fa-info-circle mr-1"></i> Belum ada patch yang
                                                    terpasang
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if (count($riwayat) > 0)
                            <div class="card-footer text-right py-2">
                                <small class="text-muted">
                                    Menampilkan {{ count($riwayat) }} dari {{ count($riwayat) }} patch
                                </small>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

<x-footer></x-footer>

<script>
    document.getElementById('checkUpdateBtn').addEventListener('click', function() {
        const btn = this;
        const originalText = btn.innerHTML;

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mengecek...';

        const resultDiv = document.getElementById('updateResult');
        resultDiv.innerHTML =
            '<div class="text-center py-2"><i class="fas fa-spinner fa-spin mr-2"></i> Memeriksa pembaruan...</div>';

        fetch('{{ route('patch.check') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(async response => {
                if (!response.ok) {
                    let errorMessage = 'Terjadi kesalahan saat memeriksa pembaruan.';
                    if (response.status === 429) {
                        errorMessage = 'Terlalu banyak permintaan. Coba lagi nanti.';
                    } else if (response.status === 500) {
                        errorMessage = 'Gagal menghubungi server pembaruan.';
                    } else if (response.status === 400) {
                        const res = await response.json();
                        errorMessage = res.error || 'Permintaan tidak valid.';
                    }
                    throw new Error(errorMessage);
                }
                return response.json();
            })
            .then(data => {
                if (data.updateInfo) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pembaruan Tersedia',
                        text: 'Ada versi baru yang tersedia. Ingin lihat detailnya?',
                        confirmButtonText: 'Tampilkan'
                    }).then(result => {
                        if (result.isConfirmed) {
                            resultDiv.innerHTML = `
                    <div class="alert alert-success alert-dismissible mt-3">
                        <h5><i class="icon fas fa-check-circle"></i> Pembaruan Tersedia!</h5>
                        <div class="update-info-box p-3 mt-3 mb-2 bg-light rounded">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge badge-primary">Versi ${data.updateInfo.version}</span>
                                <small class="text-muted">${new Date().toLocaleDateString()}</small>
                            </div>
                            <h5 class="font-weight-bold">${data.updateInfo.name}</h5>
                            <p class="mb-2">${data.updateInfo.description || 'Tidak ada deskripsi'}</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted">
                                    <i class="fas fa-database mr-1"></i> Ukuran: ${data.updateInfo.size || 'N/A'}
                                </small>
                                <a href="${data.updateInfo.file_url}" class="btn btn-sm btn-primary" download>
                                    <i class="fas fa-download mr-1"></i> Download
                                </a>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <button class="btn btn-default btn-sm" onclick="location.reload()">
                                <i class="fas fa-redo mr-1"></i> Refresh Halaman
                            </button>
                        </div>
                    </div>
                `;
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Tidak Ada Pembaruan',
                        text: data.message || 'Anda sudah menggunakan versi terbaru.',
                        confirmButtonText: 'OK'
                    });

                    resultDiv.innerHTML = '';
                }
            })

            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Memeriksa',
                    text: error.message,
                    confirmButtonText: 'OK'
                });

                resultDiv.innerHTML = '';
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
    });
</script>



<style>
    .update-info-box {
        border-left: 4px solid #28a745;
    }

    #checkUpdateBtn {
        min-width: 200px;
        transition: all 0.3s;
    }

    #checkUpdateBtn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    #checkUpdateBtn:disabled {
        transform: none;
        box-shadow: none;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnUpload = document.getElementById('btnUploadPatch');
        const formUpload = document.getElementById('formUploadPatch');

        if (btnUpload) {
            btnUpload.addEventListener('click', function() {
                console.log('Tombol Upload & Install diklik');

                const fileInput = document.getElementById('patchFileInput');

                if (!fileInput.files.length) {
                    console.log('Tidak ada file dipilih');
                    Swal.fire({
                        icon: 'warning',
                        title: 'File belum dipilih',
                        text: 'Silakan pilih file patch terlebih dahulu.',
                    });
                    return;
                }

                Swal.fire({
                    title: 'Yakin ingin menginstall patch ini?',
                    text: "Pastikan Anda sudah melakukan backup data.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Install Sekarang!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log('User mengkonfirmasi');

                        // Tampilkan swal loading
                        Swal.fire({
                            title: 'Sedang Memproses...',
                            text: 'Mohon tunggu, proses instalasi sedang berjalan.',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Submit form setelah loading tampil
                        setTimeout(() => {
                            formUpload.submit();
                        }, 800); // Delay kecil agar loading terlihat
                    } else {
                        console.log('User membatalkan');
                    }
                });
            });
        } else {
            console.log('Tombol Upload tidak ditemukan di DOM');
        }
    });
</script>
<script>
    $(function() {
        // File input label update
        bsCustomFileInput.init();

        // Tooltip initialization
        $('[data-toggle="tooltip"]').tooltip();

        // Card animation
        $('.card').hover(
            function() {
                $(this).addClass('shadow');
            },
            function() {
                $(this).removeClass('shadow');
            }
        );

        // Smooth scroll for alerts
        $('.alert').on('closed.bs.alert', function() {
            $('html, body').animate({
                scrollTop: 0
            }, 'smooth');
        });
    });
</script>

<script>
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
            timer: 3500,
            showConfirmButton: false
        });
    @endif

    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '{{ session('error') }}',
            timer: 5000,
            showConfirmButton: true
        });
    @endif
</script>
