<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="base-url" content="{{ url('/') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ get_setting('meta_description') }}">
    <meta name="keywords" content="{{ get_setting('meta_keywords') }}">
    <title>{{ $slot }}</title>

    <link rel="icon" href="{{ asset('storage/images/settings/' . get_setting('favicon')) }}" type="image/x-icon">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet"
        href="{{ asset('lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/jqvmap/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/dist/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css?v=3.2.0') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/dropzone/min/dropzone.min.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>


<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <!-- Notification Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <!-- Badge dengan teks "Pesan Baru" -->
                        @if ($unreadMessagesCount > 0)
                            <span class="badge badge-danger navbar-badge mt-2 mr-4"
                                style="font-size: 14px; margin-right: 5px;">
                                {{ $unreadMessagesCount }} Pesan Baru
                            </span>
                        @endif
                        <!-- Ikon Email -->
                        <i class="far fa-envelope" style="font-size: 20px;"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">{{ $unreadMessagesCount }} Pesan Baru</span>
                        <div class="dropdown-divider"></div>
                        @foreach ($unreadMessages as $message)
                            <a href="{{ route('messages.show', $message->id) }}" class="dropdown-item">
                                <i class="fas fa-envelope mr-2"></i>
                                <span
                                    style="max-width: 200px; display: inline-block; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $message->name }} mengirim pesan
                                </span>
                                <span
                                    class="float-right text-muted text-sm">{{ $message->created_at->diffForHumans() }}</span>
                            </a>
                            <div class="dropdown-divider"></div>
                        @endforeach
                        <a href="{{ route('messages.index') }}" class="dropdown-item dropdown-footer">Lihat semua
                            Pesan</a>
                    </div>
                </li>

                <!-- Help Dropdown as Button -->
                <li class="nav-item dropdown ml-10">
                    <a class="nav-link btn btn-info btn-sm text-white" data-toggle="dropdown" href="#"
                        role="button">
                        <i class='fas fa-question-circle'></i> Bantuan
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="https://wa.me/6283130500748" class="dropdown-item">
                            <i class="fab fa-whatsapp mr-2"></i> WhatsApp
                        </a>
                        <a href="mailto:jimbling05@gmail.com" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> Email
                        </a>
                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#aboutModal">
                            <i class="fas fa-info-circle mr-2"></i> Tentang
                        </a>
                    </div>
                </li>

                <!-- Logout Button -->
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" class="ml-2">
                        @csrf
                        <button type="submit" class="nav-link btn btn-danger btn-sm text-white">
                            <i class="fa fa-power-off"></i> Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </nav>


        <aside class="main-sidebar sidebar-dark-olive elevation-4">

            <a href="index3.html" class="brand-link bg-olive">
                <img src="{{ asset('lte/dist/img/AdminLTELogo.png') }}" alt="CMS Jimbling"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Admin Dashboard</span>
            </a>

            <div class="sidebar">


                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
                            <a href="/dashboard" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-school"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        <li class="nav-item {{ Request::is('') ? 'menu-open' : '' }}">
                            <a href="/" class="nav-link {{ Request::is('home') ? 'active' : '' }}"
                                target="_blank">
                                <i class="nav-icon 	far fa-paper-plane"></i>
                                <p>
                                    Lihat Situs
                                </p>
                            </a>
                        </li>

                        <li class="nav-item {{ Request::is('') ? 'menu-open' : '' }}">
                            <a href="/ringkas/url" class="nav-link {{ Request::is('ringkas/url') ? 'active' : '' }}">
                                <i class="nav-icon 	fas fa-link"></i>
                                <p>
                                    Tautan Ramah
                                </p>
                            </a>
                        </li>



                        @if ($canViewBlogMenu)
                            <li class="nav-item">
                                <a href="#" class="nav-link {{ Request::is('blog/*') ? 'active' : '' }}">
                                    <i class="nav-icon far fa-newspaper"></i>
                                    <p>
                                        BLOG
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('edit_posts')
                                        <li
                                            class="nav-item ml-3 {{ Request::is('blog/posts*', 'blog/tags') ? 'menu-open' : '' }}">
                                            <a href="#"
                                                class="nav-link {{ Request::is('blog/posts*', 'blog/tags') ? 'active' : '' }}">
                                                <i class="fas fa-angle-double-right nav-icon"></i>
                                                <p>Tulisan</p>
                                                <i class="fas fa-angle-left right"></i>
                                            </a>
                                            <ul class="nav nav-treeview ml-4"> <!-- Add ml-4 for more indentation -->
                                                <li class="nav-item">
                                                    <a href="/blog/posts"
                                                        class="nav-link {{ Request::is('blog/posts') ? 'active' : '' }}">
                                                        <i class="fas fa-angle-right nav-icon"></i>
                                                        <p>Semua Tulisan</p>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="/blog/posts/create"
                                                        class="nav-link {{ Request::is('blog/posts/create') ? 'active' : '' }}">
                                                        <i class="fas fa-angle-right nav-icon"></i>
                                                        <p>Tambah Baru</p>
                                                    </a>
                                                </li>

                                                @can('edit_categories')
                                                    <li class="nav-item">
                                                        <a href="/blog/posts/post_categories"
                                                            class="nav-link {{ Request::is('blog/posts/post_categories') ? 'active' : '' }}">
                                                            <i class="fas fa-angle-right nav-icon"></i>
                                                            <p>Kategori Tulisan</p>
                                                        </a>
                                                    </li>
                                                @endcan

                                                @can('edit_tags')
                                                    <li class="nav-item">
                                                        <a href="/blog/tags"
                                                            class="nav-link {{ Request::is('blog/tags') ? 'active' : '' }}">
                                                            <i class="fas fa-angle-right nav-icon"></i>
                                                            <p>Tags</p>
                                                        </a>
                                                    </li>
                                                @endcan
                                            </ul>
                                        </li>
                                    @endcan
                                    <li
                                        class="nav-item ml-3 {{ Request::is('blog/gambar_slide') ? 'menu-open' : '' }}">
                                        <a href="/blog/gambar_slide"
                                            class="nav-link {{ Request::is('blog/gambar_slide') ? 'active' : '' }}">
                                            <i class="fas fa-angle-double-right nav-icon"></i>
                                            <p>Gambar Slide</p>
                                        </a>
                                    </li>
                                    @can('edit_hubungi')
                                        <li
                                            class="nav-item ml-3 {{ Request::is('contact/messages') ? 'menu-open' : '' }}">
                                            <a href="/contact/messages"
                                                class="nav-link {{ Request::is('blog/pesan') ? 'active' : '' }}">
                                                <i class="fas fa-angle-double-right nav-icon"></i>
                                                <p>Pesan Masuk</p>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('edit_tautan')
                                        <li class="nav-item ml-3 {{ Request::is('blog/tautan') ? 'menu-open' : '' }}">
                                            <a href="/blog/tautan"
                                                class="nav-link {{ Request::is('blog/tautan') ? 'active' : '' }}">
                                                <i class="fas fa-angle-double-right nav-icon"></i>
                                                <p>Tautan</p>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('edit_halaman')
                                        <li class="nav-item ml-3 {{ Request::is('blog/pages') ? 'menu-open' : '' }}">
                                            <a href="/blog/pages"
                                                class="nav-link {{ Request::is('blog/pages') ? 'active' : '' }}">
                                                <i class="fas fa-angle-double-right nav-icon"></i>
                                                <p>Halaman</p>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('edit_kutipan')
                                        <li class="nav-item ml-3 {{ Request::is('blog/kutipan') ? 'menu-open' : '' }}">
                                            <a href="/blog/kutipan"
                                                class="nav-link {{ Request::is('blog/kutipan') ? 'active' : '' }}">
                                                <i class="fas fa-angle-double-right nav-icon"></i>
                                                <p>Kutipan</p>
                                            </a>
                                        </li>
                                    @endcan


                                    <li class="nav-item ml-3 {{ Request::is('blog/sambutan') ? 'menu-open' : '' }}">
                                        <a href="/blog/sambutan"
                                            class="nav-link {{ Request::is('blog/sambutan') ? 'active' : '' }}">
                                            <i class="fas fa-angle-double-right nav-icon"></i>
                                            <p>Sambutan KS</p>
                                        </a>
                                    </li>

                                    @can('edit_tautan')
                                        <li class="nav-item ml-3 {{ Request::is('blog/subscribe') ? 'menu-open' : '' }}">
                                            <a href="/blog/subscribe"
                                                class="nav-link {{ Request::is('blog/subscribe') ? 'active' : '' }}">
                                                <i class="fas fa-angle-double-right nav-icon"></i>
                                                <p>Subscriber</p>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endif


                        @can('edit_gtk')
                            <li class="nav-item">
                                <a href="/gtk/all" class="nav-link {{ Request::is('gtk/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-chalkboard-teacher"></i>
                                    <p>
                                        GTK
                                    </p>
                                </a>
                            </li>
                        @endcan


                        @if ($canViewAkademikMenu)
                            <li class="nav-item">
                                <a href="#" class="nav-link {{ Request::is('academic/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-user-graduate"></i>
                                    <p>
                                        AKADEMIK
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>


                                <ul class="nav nav-treeview">
                                    @can('edit_pd')
                                        <li
                                            class="nav-item ml-3 {{ Request::is('academic/students/all') ? 'menu-open' : '' }}">
                                            <a href="/academic/students/all"
                                                class="nav-link {{ Request::is('academic/students/all') ? 'active' : '' }}">
                                                <i class="fas fa-angle-double-right nav-icon"></i>
                                                <p>Peserta Didik</p>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('edit_kelas')
                                        <li
                                            class="nav-item ml-3 {{ Request::is('academic/classrooms') ? 'menu-open' : '' }}">
                                            <a href="/academic/classrooms"
                                                class="nav-link {{ Request::is('academic/classrooms') ? 'active' : '' }}">
                                                <i class="fas fa-angle-double-right nav-icon"></i>
                                                <p>Kelas</p>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('edit_tahun_pelajaran')
                                        <li
                                            class="nav-item ml-3 {{ Request::is('academic/academic_years/all') ? 'menu-open' : '' }}">
                                            <a href="/academic/academic_years/all"
                                                class="nav-link {{ Request::is('academic/academic_years/all') ? 'active' : '' }}">
                                                <i class="fas fa-angle-double-right nav-icon"></i>
                                                <p>Tahun Pelajaran</p>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('edit_rombel')
                                        <li
                                            class="nav-item ml-3 {{ Request::is('academic/rombels/*') ? 'menu-open' : '' }}">
                                            <a href="#"
                                                class="nav-link {{ Request::is('academic/rombels/*') ? 'active' : '' }}">
                                                <i class="fas fa-angle-double-right nav-icon"></i>
                                                <p>Rombongan Belajar</p>
                                                <i class="fas fa-angle-left right"></i>
                                            </a>
                                            <ul class="nav nav-treeview ml-4"> <!-- Add ml-4 for more indentation -->
                                                <li class="nav-item">
                                                    <a href="/academic/rombels/create"
                                                        class="nav-link {{ Request::is('academic/rombels/create') ? 'active' : '' }}">
                                                        <i class="fas fa-angle-right nav-icon"></i>
                                                        <p>Data Rombel</p>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="/academic/rombels/members"
                                                        class="nav-link {{ Request::is('academic/rombels/members') ? 'active' : '' }}">
                                                        <i class="fas fa-angle-right nav-icon"></i>
                                                        <p>Anggota Rombel</p>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="/academic/rombels/all"
                                                        class="nav-link {{ Request::is('academic/rombels/all') ? 'active' : '' }}">
                                                        <i class="fas fa-angle-right nav-icon"></i>
                                                        <p>Daftar PD Rombel</p>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    @endcan


                                    <li
                                        class="nav-item ml-3 {{ Request::is('academic/students/non-active') ? 'menu-open' : '' }}">
                                        <a href="/academic/students/non-active"
                                            class="nav-link {{ Request::is('academic/students/non-active') ? 'active' : '' }}">
                                            <i class="fas fa-angle-double-right nav-icon"></i>
                                            <p>PD Non Aktif</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if ($canViewMediaMenu)
                            <li class="nav-item">
                                <a href="#"
                                    class="nav-link {{ Request::is('files/*', 'videos', 'photos', 'photos/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-server"></i>
                                    <p>
                                        MEDIA
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                @can('edit_file')
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item ml-3 {{ Request::is('files/all') ? 'menu-open' : '' }}">
                                            <a href="/files/all"
                                                class="nav-link {{ Request::is('files/all') ? 'active' : '' }}">
                                                <i class="fas fa-angle-double-right nav-icon"></i>
                                                <p>File</p>
                                            </a>
                                        </li>
                                    </ul>
                                @endcan
                                @can('edit_photo')
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item ml-3 {{ Request::is('photos/*') ? 'menu-open' : '' }}">
                                            <a href="/photos"
                                                class="nav-link {{ Request::is('photos/*') ? 'active' : '' }}">
                                                <i class="fas fa-angle-double-right nav-icon"></i>
                                                <p>Foto</p>
                                            </a>
                                        </li>
                                    </ul>
                                @endcan
                                @can('edit_video')
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item ml-3 {{ Request::is('videos') ? 'menu-open' : '' }}">
                                            <a href="/videos"
                                                class="nav-link {{ Request::is('videos') ? 'active' : '' }}">
                                                <i class="fas fa-angle-double-right nav-icon"></i>
                                                <p>Video</p>
                                            </a>
                                        </li>
                                    </ul>
                                @endcan
                            </li>
                        @endcan

                        @can('edit_menu')
                            <li class="nav-item">
                                <a href="#" class="nav-link {{ Request::is('menu') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-paint-brush"></i>
                                    <p>
                                        TAMPILAN
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item ml-3 {{ Request::is('/menu') ? 'menu-open' : '' }}">
                                        <a href="/menu" class="nav-link {{ Request::is('menu') ? 'active' : '' }}">
                                            <i class="fas fa-angle-double-right nav-icon"></i>
                                            <p>Menu</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif



                        @if ($canViewUserMenu)
                            <li class="nav-item">

                                <a href="#"
                                    class="nav-link {{ Request::is('profile', 'privilege') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-user-alt"></i>
                                    <p>
                                        PENGGUNA
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('edit_profile')
                                        <li class="nav-item ml-3 {{ Request::is('profile') ? 'menu-open' : '' }}">
                                            <a href="/profile"
                                                class="nav-link {{ Request::is('profile') ? 'active' : '' }}">
                                                <i class="fas fa-angle-double-right nav-icon"></i>
                                                <p>Profile</p>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('edit_hak_akses')
                                        <li class="nav-item ml-3 {{ Request::is('privilege') ? 'menu-open' : '' }}">
                                            <a href="/privilege"
                                                class="nav-link {{ Request::is('privilege') ? 'active' : '' }}">
                                                <i class="fas fa-angle-double-right nav-icon"></i>
                                                <p>Hak Akses</p>
                                            </a>
                                        </li>
                                    @endcan

                                </ul>

                            </li>
                        @endif


                        @can('edit_pengaturan')
                            <li class="nav-item">
                                <a href="#" class="nav-link {{ Request::is('settings/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-tools"></i>
                                    <p>
                                        PENGATURAN
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item ml-3 {{ Request::is('settings/discussion') ? 'menu-open' : '' }}">
                                        <a href="{{ route('settings.discussion') }}"
                                            class="nav-link {{ Request::is('settings/discussion') ? 'active' : '' }}">
                                            <i class="fas fa-angle-double-right nav-icon"></i>
                                            <p>Diskusi</p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-3 {{ Request::is('settings/medsos') ? 'menu-open' : '' }}">
                                        <a href="{{ route('settings.medsos') }}"
                                            class="nav-link {{ Request::is('settings/medsos') ? 'active' : '' }}">
                                            <i class="fas fa-angle-double-right nav-icon"></i>
                                            <p>Media Sosial</p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-3 {{ Request::is('settings/reading') ? 'menu-open' : '' }}">
                                        <a href="{{ route('settings.reading') }}"
                                            class="nav-link {{ Request::is('settings/reading') ? 'active' : '' }}">
                                            <i class="fas fa-angle-double-right nav-icon"></i>
                                            <p>Membaca</p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-3 {{ Request::is('settings/writing') ? 'menu-open' : '' }}">
                                        <a href="{{ route('settings.writing') }}"
                                            class="nav-link {{ Request::is('settings/writing') ? 'active' : '' }}">
                                            <i class="fas fa-angle-double-right nav-icon"></i>
                                            <p>Menulis</p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-3 {{ Request::is('settings/media') ? 'menu-open' : '' }}">
                                        <a href="{{ route('settings.media') }}"
                                            class="nav-link {{ Request::is('settings/media') ? 'active' : '' }}">
                                            <i class="fas fa-angle-double-right nav-icon"></i>
                                            <p>Media</p>
                                        </a>
                                    </li>
                                    <li
                                        class="nav-item ml-3 {{ Request::is('settings/school_profile') ? 'menu-open' : '' }}">
                                        <a href="{{ route('settings.profile.sekolah') }}"
                                            class="nav-link {{ Request::is('settings/school_profile') ? 'active' : '' }}">
                                            <i class="fas fa-angle-double-right nav-icon"></i>
                                            <p>Profil Sekolah</p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-3 {{ Request::is('settings/general') ? 'menu-open' : '' }}">
                                        <a href="{{ route('settings.general') }}"
                                            class="nav-link {{ Request::is('settings/general') ? 'active' : '' }}">
                                            <i class="fas fa-angle-double-right nav-icon"></i>
                                            <p>Umum</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan

                        @can('edit_pemeliharaan')
                            <li class="nav-item">
                                <a href="/pemeliharaan"
                                    class="nav-link {{ Request::is('pemeliharaan') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-laptop-medical"></i>
                                    <p>
                                        PEMELIHARAAN
                                    </p>
                                </a>
                            </li>
                        @endcan

                        <li class="nav-item">
                            <a href="/pemeliharaan"
                                class="nav-link {{ Request::is('pemeliharaan') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-laptop-medical"></i>
                                <p>
                                    UPDATES
                                </p>
                            </a>
                        </li>




                    </ul>
                </nav>

            </div>

        </aside>
