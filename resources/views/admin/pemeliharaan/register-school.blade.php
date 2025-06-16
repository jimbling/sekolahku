<x-header>{{ $judul }}</x-header>
<div class="content-wrapper">
    <x-breadcrumb>{{ $judul }}</x-breadcrumb>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Registrasi Sekolah</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Token Verification Step -->
                        <div class="card-body" id="tokenStep">
                            <div class="text-center mb-4">
                                <i class="fas fa-key fa-4x text-primary mb-3"></i>
                                <h4>Verifikasi Token Registrasi</h4>
                                <p class="text-muted">Masukkan token lengkap (contoh: <strong>SINAU-BAYYNDDM</strong>)
                                </p>
                            </div>

                            <form id="formToken">
                                <div class="form-group">
                                    <label for="token">Token Registrasi</label>
                                    <div class="input-group">
                                        <input type="text" id="token" class="form-control form-control-lg"
                                            placeholder="SINAU-XXXXXX" required
                                            style="font-family: 'Courier New', monospace; letter-spacing: 1px;">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fas fa-check-circle mr-2"></i>Verifikasi
                                            </button>
                                        </div>
                                    </div>
                                    <small class="text-muted">Masukkan token lengkap termasuk prefix SINAU-</small>
                                </div>
                            </form>
                        </div>

                        <!-- School Information Step -->
                        <div class="card-body d-none" id="schoolStep">
                            <div class="text-center mb-4">
                                <i class="fas fa-school fa-4x text-success mb-3"></i>
                                <h4>Informasi Sekolah</h4>
                                <p class="text-muted">Verifikasi data sekolah Anda sebelum menyimpan</p>
                            </div>

                            <form id="formSekolah" method="POST" action="{{ route('school.store') }}">
                                @csrf
                                <input type="hidden" name="school_uuid">
                                <input type="hidden" name="license_key">
                                <input type="hidden" name="valid_until">

                                <div class="form-group">
                                    <label>Nama Sekolah</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-university"></i></span>
                                        </div>
                                        <input type="text" name="name" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>NPSN</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <input type="text" name="npsn" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="fas fa-envelope"></i></span>
                                                </div>
                                                <input type="text" name="email" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Alamat</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        </div>
                                        <textarea name="address" class="form-control" rows="3" readonly></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Masa Berlaku Lisensi</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="licensePeriod" readonly>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-secondary" id="backToToken">
                                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save mr-2"></i>Simpan Registrasi
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Panduan Registrasi</h3>
                        </div>
                        <div class="card-body">
                            <ol>
                                <li>Masukkan <strong>token lengkap</strong> (contoh: SINAU-BAYYNDDM)</li>
                                <li>Klik tombol <strong>Verifikasi</strong> untuk memvalidasi token</li>
                                <li>Periksa data sekolah yang muncul setelah verifikasi berhasil</li>
                                <li>Klik <strong>Simpan Registrasi</strong> untuk menyelesaikan proses</li>
                            </ol>
                            <div class="alert alert-warning mt-3">
                                <i class="icon fas fa-exclamation-triangle"></i>
                                Pastikan data sekolah yang muncul sudah benar sebelum disimpan.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<x-footer />

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const formToken = document.getElementById('formToken');
        const tokenStep = document.getElementById('tokenStep');
        const schoolStep = document.getElementById('schoolStep');
        const backToTokenBtn = document.getElementById('backToToken');
        const tokenInput = document.getElementById('token');

        // Format license period display
        function formatLicenseDate(dateString) {
            if (!dateString) return '-';
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            return new Date(dateString).toLocaleDateString('id-ID', options);
        }

        // Token form submission
        formToken.addEventListener('submit', function(e) {
            e.preventDefault();

            const tokenValue = tokenInput.value.trim();

            if (!tokenValue) {
                Swal.fire({
                    icon: 'error',
                    title: 'Token Kosong',
                    text: 'Harap masukkan token registrasi lengkap',
                });
                return;
            }

            if (!tokenValue.startsWith('SINAU-')) {
                Swal.fire({
                    icon: 'error',
                    title: 'Format Token Salah',
                    text: 'Token harus diawali dengan SINAU- (contoh: SINAU-BAYYNDDM)',
                });
                return;
            }

            Swal.fire({
                title: 'Memverifikasi Token',
                html: 'Sedang memvalidasi token registrasi...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            fetch('{{ route('school.verify') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        token: tokenValue
                    })
                })
                .then(async res => {
                    const data = await res.json();

                    if (res.ok && data.school_uuid) {
                        // Success response
                        Swal.fire({
                            icon: 'success',
                            title: 'Verifikasi Berhasil!',
                            text: 'Data sekolah berhasil diverifikasi',
                            timer: 2000,
                            timerProgressBar: true,
                            showConfirmButton: false
                        });

                        // Fill school form
                        const formSekolah = document.getElementById('formSekolah');
                        formSekolah.school_uuid.value = data.school_uuid;
                        formSekolah.license_key.value = data.license_key;
                        formSekolah.valid_until.value = data.valid_until;
                        formSekolah.name.value = data.name;
                        formSekolah.npsn.value = data.npsn;
                        formSekolah.email.value = data.email;
                        formSekolah.address.value = data.address;

                        // Format and display license period
                        document.getElementById('licensePeriod').value =
                            `Sampai ${formatLicenseDate(data.valid_until)}`;

                        // Switch to school info step
                        tokenStep.classList.add('d-none');
                        schoolStep.classList.remove('d-none');

                        // Smooth scroll to top
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    } else {
                        // Error response
                        let message = data.message || 'Terjadi kesalahan saat verifikasi token';
                        if (data.errors) {
                            message = Object.values(data.errors).flat().join('\n');
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Verifikasi Gagal',
                            text: message,
                            confirmButtonText: 'Mengerti'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan Jaringan',
                        text: 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.',
                        confirmButtonText: 'Mengerti'
                    });
                });
        });


        backToTokenBtn.addEventListener('click', function() {
            schoolStep.classList.add('d-none');
            tokenStep.classList.remove('d-none');
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });


        tokenInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });


        tokenInput.focus();


    });
</script>
