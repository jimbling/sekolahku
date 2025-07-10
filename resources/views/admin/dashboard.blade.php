<x-header>
    {{ $judul }}</x-header>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">

        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            @if ($lastBackup)
                <div class="alert alert-success alert-dismissible d-flex align-items-center py-2"
                    style="border-left: 5px solid #28a745; background-color: #003569;">
                    <i class="fas fa-check-circle fa-lg mr-3" style="color: #28a745;"></i>
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center flex-wrap">
                            <span class="font-weight-bold mr-2">Backup Sukses!</span>
                            <span class="mr-2">File <code
                                    class="bg-light px-1 rounded">{{ $lastBackup['filename'] }}</code></span>
                            <span class=" mr-2">pada
                                {{ \Carbon\Carbon::parse($lastBackup['timestamp'])->translatedFormat('d F Y, H:i') }}</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.pemeliharaan.index') }}" class="btn btn-sm btn-success ml-2"
                        style="white-space: nowrap; text-decoration: none;">
                        <i class="fas fa-download mr-1"></i> Unduh Backup
                    </a>

                    <button type="button" class="close ml-2" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true" style="color: #dee8f1;">&times;</span>
                    </button>
                </div>
            @endif

            @if ($cacheEnabled)
                <div class="alert alert-warning alert-dismissible d-flex align-items-center"
                    style="border-left: 4px solid #FFD700; background-color: #800020; border-radius: 6px;">
                    <div class="mr-3">
                        <i class="fas fa-exclamation-triangle fa-lg" style="color: #FFD700;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex flex-column flex-md-row align-items-md-center">
                            <div class="mr-md-3 mb-2 mb-md-0">
                                <h5 class="alert-title mb-0" style="color: #FFD700; font-weight: 600;">Cache Aktif</h5>
                                <p class="mb-0 small" style="color: #F5DEB3;">
                                    Sistem cache <strong style="color: #FFFFFF;">diaktifkan</strong>. Perubahan
                                    <strong style="color: #FFFFFF;">tidak langsung terlihat</strong>.
                                </p>
                            </div>
                            <div class="d-flex align-items-center">
                                <button id="btnClearCache" class="btn btn-sm"
                                    style="background-color: #D4AF37; color: #800020; border: none;">
                                    <i class="fas fa-broom mr-2"></i>Bersihkan Cache
                                </button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true" style="color: #F5DEB3;">&times;</span>
                    </button>
                </div>
            @endif







            <div class="row">
                <div class="col-lg-3 col-6">

                    <div class="small-box bg-indigo">
                        <div class="inner">
                            <h3>{{ $postinganAktif }}</h3>
                            <p>Postingan Dipublikasikan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <a href="{{ route('admin.blog.posts') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-pink">
                        <div class="inner">
                            <h3>{{ $fileAktif }}</h3>
                            <p>File Unduhan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-download"></i>
                        </div>
                        <a href="{{ route('admin.files.all') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-teal">
                        <div class="inner">
                            <h3>{{ $gtkAktif }}</h3>
                            <p>Guru dan Tendik</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{ route('admin.gtk.all') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-orange">
                        <div class="inner">
                            <h3>{{ $pesertaDidikAktif }}</h3>
                            <p>Peserta Didik Aktif</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-friends"></i>
                        </div>
                        <a href="{{ route('admin.students.all') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>


            <div class="row">
                <div class="col-md-6">

                    <div class="card card-widget widget-user ">

                        <div class="widget-user-header bg-warning">
                            <div class="widget-user-image">
                                <img class="img-circle elevation-2"
                                    src="{{ '/storage/images/illustrasi/gtk-pria.jpg' }}" alt="User Avatar">
                            </div>

                            <h3 class="widget-user-username">Selamat Datang</h3>
                            <h5 class="widget-user-desc">
                                @if ($user['isAdmin'])
                                    <p>Anda Login sebagai Admin</p>
                                @endif

                                @if ($user['isWriter'])
                                    <p>Anda Login sebagai Writer</p>
                                @endif
                            </h5>
                        </div>
                        <div class="card-footer p-0">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        Nama <span class="float-right badge bg-primary">{{ $user['name'] }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        Email <span class="float-right badge bg-info">{{ $user['email'] }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        Hak Akses <span class="float-right badge bg-success">
                                            @if ($user['isAdmin'])
                                                Admin
                                            @endif

                                            @if ($user['isWriter'])
                                                Penulis
                                            @endif
                                        </span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>


                    <div class="card border-primary mb-3 ">
                        <div class="card-header bg-navy text-white">
                            <h3 class="card-title mb-0">Profile Sekolah</h3>
                        </div>
                        <div class="card-body">
                            <table class="table custom-table">
                                <tbody>
                                    <tr>
                                        <th scope="row" class="font-weight-bold">Nama Sekolah</th>
                                        <td>{{ get_setting('school_name') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="font-weight-bold">NPSN</th>
                                        <td>{{ get_setting('npsn') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="font-weight-bold">Kepala Sekolah</th>
                                        <td>{{ get_setting('headmaster') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="font-weight-bold">Alamat Jalan</th>
                                        <td>{{ get_setting('sub_village') }},
                                            {{ get_setting('rt') }}/{{ get_setting('rw') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="font-weight-bold">Dusun</th>
                                        <td>{{ get_setting('sub_village') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="font-weight-bold">Kalurahan</th>
                                        <td>{{ get_setting('village') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="font-weight-bold">Kapanewon/Kecamatan</th>
                                        <td>{{ get_setting('sub_district') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="font-weight-bold">Kota/Kabupaten</th>
                                        <td>{{ get_setting('district') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="font-weight-bold">Telp</th>
                                        <td>{{ get_setting('phone') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="font-weight-bold">Fax</th>
                                        <td>{{ get_setting('fax') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="font-weight-bold">Email</th>
                                        <td>{{ get_setting('email') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="font-weight-bold">Website</th>
                                        <td>{{ get_setting('website') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="font-weight-bold">Kode Pos</th>
                                        <td>{{ get_setting('postal_code') }}</td>
                                    </tr>
                                    <!-- Add more rows as needed -->
                                </tbody>
                            </table>
                        </div>
                    </div>



                </div>

                <div class="col-md-6">

                    @php
                        $engine = $komentar_engine ?? get_setting('komentar_engine', 'native');
                    @endphp

                    <div class="card">
                        <div class="card-header bg-navy text-white">
                            <h3 class="card-title mb-0">Komentar Terbaru</h3>
                        </div>
                        <div class="card-body">
                            @if ($engine === 'disqus')
                                {{-- Tampilan komentar DISQUS --}}
                                @if (isset($disqusComments['error']))
                                    <div class="alert alert-danger" role="alert">
                                        Terjadi kesalahan dalam mengambil komentar: {{ $disqusComments['error'] }}
                                    </div>
                                @else
                                    <div class="row">
                                        @foreach ($disqusComments as $comment)
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h6 class="card-title">
                                                            <a href="{{ $comment['postUrl'] }}"
                                                                class="text-decoration-none text-primary"
                                                                target="_blank">
                                                                {{ $comment['postTitle'] }}
                                                            </a>
                                                        </h6>
                                                        <div class="">
                                                            <p class="card-text text-center bg-light">
                                                                " {{ strip_tags($comment['message']) }} "
                                                            </p>
                                                        </div>
                                                        <p class="card-text">
                                                            <small class="text-muted">
                                                                <i class="fas fa-calendar-day"></i>
                                                                {{ $comment['createdAtRelative'] }} |
                                                                <i class="fas fa-user"></i>
                                                                {{ $comment['authorName'] }}
                                                            </small>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @elseif ($engine === 'native')
                                {{-- Tampilan komentar NATIVE, sama dengan disqus tapi dari model --}}
                                @if ($nativeComments->isEmpty())
                                    <div class="alert alert-info">Belum ada komentar.</div>
                                @else
                                    <div class="row">
                                        @foreach ($nativeComments as $comment)
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h6 class="card-title">
                                                            {{-- Link ke post terkait, sesuaikan jika ada relasi post --}}
                                                            <a href="{{ route('posts.show', ['id' => $comment->post_id, 'slug' => \Str::slug($comment->post->title ?? 'post')]) }}"
                                                                class="text-decoration-none text-primary"
                                                                target="_blank">
                                                                {{ $comment->post->title ?? 'Post Tidak Ditemukan' }}
                                                            </a>
                                                        </h6>
                                                        <div class="">
                                                            <p class="card-text text-center bg-light">
                                                                " {{ strip_tags($comment->content) }} "
                                                            </p>
                                                        </div>
                                                        <p class="card-text">
                                                            <small class="text-muted">
                                                                <i class="fas fa-calendar-day"></i>
                                                                {{ $comment->created_at->diffForHumans() }} |
                                                                <i class="fas fa-user"></i>
                                                                {{ $comment->user->name ?? $comment->guest_name }}
                                                            </small>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @else
                                <div class="alert alert-warning">Engine komentar tidak dikenali.</div>
                            @endif
                        </div>
                    </div>



                    @auth
                        @if ($user['isAdmin'])
                            <div class="card bg-gradient-danger">
                                <div class="card-header border-0">
                                    <h3 class="card-title">
                                        <i class="fas fa-database"></i>
                                        Backup Sistem
                                    </h3>
                                </div>
                                <div class="card-body pt-0">
                                    <!-- Form untuk membuat backup -->
                                    <form id="backupForm" action="{{ route('admin.backup.create') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Buat Backup Database</button>
                                    </form>

                                    <!-- Daftar file backup -->
                                    <h5 class="mt-4">Daftar Backup:</h5>
                                    @if ($backups->isEmpty())
                                        <p>Tidak ada file backup tersedia.</p>
                                    @else
                                        <ul class="list-group">
                                            @foreach ($backups as $backup)
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span class="backup-file-name">{{ $backup->filename }}
                                                        ({{ number_format($backup->size / 1024, 2) }} MB)
                                                    </span>
                                                    <a href="{{ route('admin.backup.download', ['filename' => $backup->filename]) }}"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="fas fa-download"></i> Unduh
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                <div class="card-footer">
                                    <div class="footer-content">
                                        <p class="mb-2">
                                            Backup Sistem akan menghasilkan file .zip yang dapat diunduh. File .zip tersebut
                                            berisi dua bagian:
                                        </p>
                                        <ul class="list-unstyled">
                                            <li><strong>File Sistem:</strong> Berisi keseluruhan source code aplikasi CMS
                                                Sinau.
                                            </li>
                                            <li><strong>File Database:</strong> Berisi database MySQL dalam format .sql.
                                            </li>
                                        </ul>
                                        <p class="mt-2">
                                            Disarankan untuk rutin melakukan backup untuk mengantisipasi hal-hal yang tidak
                                            diinginkan di kemudian hari.
                                            Simpan file backup di tempat lain, karena file backup dapat membebani kapasitas
                                            hosting yang digunakan.
                                        </p>
                                        <p class="mt-1">
                                            Untuk fitur yang lebih lengkap silahkan klik menu
                                            <button type="button" id="maintenanceButton"
                                                class="btn btn-sm btn-light">Pemeliharaan</button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endauth


                </div>


            </div>


            {{-- TULISAN TERBARU --}}
            <div class="row">
                <div class="col-md-12">

                    <div class="card ">
                        <div class="card-header bg-navy text-white">
                            <h3 class="card-title mb-0">Tulisan Terbaru</h3>
                        </div>
                        <div class="card-body">
                            @if ($latestPosts->isNotEmpty())
                                <div class="row">
                                    @foreach ($latestPosts as $post)
                                        <div class="col-md-4 col-lg-3 mb-3">
                                            <div class="card">
                                                <img src="{{ Storage::url('uploads/posts/' . $post->image) }}"
                                                    class="card-img-top img-fluid" alt="Post Image"
                                                    style="height: 200px; object-fit: cover;">
                                                <div class="card-body">
                                                    <a href="{{ route('posts.show', ['id' => $post->id, 'slug' => $post->slug]) }}"
                                                        class="text-dark text-decoration-none" target="_blank">
                                                        <h5 class="card-title">{{ Str::limit($post->title, 50) }}</h5>
                                                    </a>
                                                    <p class="card-text text-muted">
                                                        {{ \Carbon\Carbon::parse($post->published_at)->locale('id')->translatedFormat('l, d F Y') }}
                                                    </p>
                                                    <p class="card-text text-muted mb-0">
                                                        <strong>Penulis:</strong>
                                                        {{ $post->author->name ?? 'Tidak Diketahui' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted mb-0">Belum ada tulisan terbaru.</p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
            {{-- AKHIR TULISAN TERBARU --}}



        </div>
    </section>

</div>
<x-footer></x-footer>
<script src="{{ asset('lte/dist/js/backend/pemeliharaan.js') }}"></script>
<script>
    document.getElementById('maintenanceButton').addEventListener('click', function() {
        window.location.href = '{{ route('admin.pemeliharaan.index') }}';
    });
</script>

@if (session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        });
    </script>
@endif


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const btn = document.getElementById('btnClearCache');
        if (btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Yakin ingin bersihkan cache?',
                    text: "Perubahan akan langsung diterapkan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, bersihkan!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Tampilkan loading sebelum redirect
                        Swal.fire({
                            title: 'Sedang membersihkan...',
                            text: 'Mohon tunggu sebentar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading()
                            }
                        });

                        // Tunggu sedikit agar spinner muncul, lalu redirect
                        setTimeout(() => {
                            window.location.href = "{{ route('admin.cache.clear') }}";
                        }, 1000);
                    }
                });
            });
        }
    });
</script>
