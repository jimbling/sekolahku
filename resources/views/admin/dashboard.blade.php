<x-header>
    {{ $judul }}</x-header>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">

        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

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
                        <a href="{{ route('blog.posts') }}" class="small-box-footer">More info <i
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
                        <a href="{{ route('files.all') }}" class="small-box-footer">More info <i
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
                        <a href="{{ route('gtk.all') }}" class="small-box-footer">More info <i
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
                        <a href="{{ route('students.all') }}" class="small-box-footer">More info <i
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

                    <div class="card">
                        <div class="card-header bg-navy text-white">
                            <h3 class="card-title mb-0">Komentar Terbaru</h3>
                        </div>
                        <div class="card-body">
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
                                                            class="text-decoration-none text-primary" target="_blank">
                                                            {{ $comment['postTitle'] }}
                                                        </a>
                                                    </h6>
                                                    <div class="">
                                                        <p class="card-text text-center bg-light">
                                                            " {{ strip_tags($comment['message']) }} " </p>
                                                    </div>
                                                    <p class="card-text">
                                                        <small class="text-muted">
                                                            <i class="fas fa-calendar-day"></i>
                                                            {{ $comment['createdAtRelative'] }} |
                                                            <i class="fas fa-user"></i> {{ $comment['authorName'] }}
                                                        </small>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
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
                                            Untuk fitur yang lebih lengkap silahkan klik menu <button type="button"
                                                class="btn btn-sm btn-light"> Pemeliharaan </button>
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
