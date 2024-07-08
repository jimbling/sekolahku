<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="base-url" content="{{ url('/') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $slot }}</title>

    <link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('/lte/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
        </nav>


        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <a href="index3.html" class="brand-link bg-olive">
                <img src="{{ asset('lte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Admin Dashboard</span>
            </a>

            <div class="sidebar">


                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
                            <a href="/dashboard" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
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

                        <li class="nav-item">
                            <a href="#" class="nav-link {{ Request::is('blog/*') ? 'active' : '' }}">
                                <i class="nav-icon far fa-newspaper"></i>
                                <p>
                                    BLOG
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item {{ Request::is('blog/posts*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                        class="nav-link {{ Request::is('blog/posts*') ? 'active' : '' }}">
                                        <i class="fas fa-arrow-alt-circle-right nav-icon"></i>
                                        <p>Tulisan</p>
                                        <i class="fas fa-angle-left right"></i>
                                    </a>
                                    <ul class="nav nav-treeview">
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
                                        <li class="nav-item">
                                            <a href="/blog/posts/post_categories"
                                                class="nav-link {{ Request::is('blog/posts/post_categories') ? 'active' : '' }}">
                                                <i class="fas fa-angle-right nav-icon"></i>
                                                <p>Kategori Tulisan</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="/blog/posts/post_comments"
                                                class="nav-link {{ Request::is('blog/posts/post_comments') ? 'active' : '' }}">
                                                <i class="fas fa-angle-right nav-icon"></i>
                                                <p>Komentar</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="/blog/tags"
                                                class="nav-link {{ Request::is('blog/tags') ? 'active' : '' }}">
                                                <i class="fas fa-angle-right nav-icon"></i>
                                                <p>Tags</p>
                                            </a>
                                        </li>
                                    </ul>

                                </li>
                                <li class="nav-item {{ Request::is('blog/gambar_slide') ? 'menu-open' : '' }}">
                                    <a href="/blog/gambar_slide"
                                        class="nav-link {{ Request::is('blog/gambar_slide') ? 'active' : '' }}">
                                        <i class="fas fa-arrow-alt-circle-right nav-icon"></i>
                                        <p>Gambar Slide</p>
                                    </a>
                                </li>

                                <li class="nav-item {{ Request::is('blog/pesan') ? 'menu-open' : '' }}">
                                    <a href="/blog/pesan"
                                        class="nav-link {{ Request::is('blog/pesan') ? 'active' : '' }}">
                                        <i class="fas fa-arrow-alt-circle-right nav-icon"></i>
                                        <p>Pesan Masuk</p>
                                    </a>
                                </li>
                                <li class="nav-item {{ Request::is('blog/tautan') ? 'menu-open' : '' }}">
                                    <a href="/blog/tautan"
                                        class="nav-link {{ Request::is('blog/tautan') ? 'active' : '' }}">
                                        <i class="fas fa-arrow-alt-circle-right nav-icon"></i>
                                        <p>Tautan</p>
                                    </a>
                                </li>
                                <li class="nav-item {{ Request::is('blog/pages') ? 'menu-open' : '' }}">
                                    <a href="/blog/pages"
                                        class="nav-link {{ Request::is('blog/pages') ? 'active' : '' }}">
                                        <i class="fas fa-arrow-alt-circle-right nav-icon"></i>
                                        <p>Halaman</p>
                                    </a>
                                </li>

                                <li class="nav-item {{ Request::is('blog/kutipan') ? 'menu-open' : '' }}">
                                    <a href="/blog/kutipan"
                                        class="nav-link {{ Request::is('blog/kutipan') ? 'active' : '' }}">
                                        <i class="fas fa-arrow-alt-circle-right nav-icon"></i>
                                        <p>Kutipan</p>
                                    </a>
                                </li>
                                <li class="nav-item {{ Request::is('blog/sambutan') ? 'menu-open' : '' }}">
                                    <a href="/blog/sambutan"
                                        class="nav-link {{ Request::is('blog/sambutan') ? 'active' : '' }}">
                                        <i class="fas fa-arrow-alt-circle-right nav-icon"></i>
                                        <p>Sambutan KS</p>
                                    </a>
                                </li>
                                <li class="nav-item {{ Request::is('laporan') ? 'menu-open' : '' }}">
                                    <a href="/blog/subs"
                                        class="nav-link {{ Request::is('laporan') ? 'active' : '' }}">
                                        <i class="fas fa-arrow-alt-circle-right nav-icon"></i>
                                        <p>Subscriber</p>
                                    </a>
                                </li>
                            </ul>
                        </li>




                        <li class="nav-item {{ Request::is('invoice', 'profile') ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ Request::is('invoice', 'profile') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tools"></i>
                                <p>
                                    Pengaturan
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item {{ Request::is('profile') ? 'menu-open' : '' }}">
                                    <a href="/profile" class="nav-link {{ Request::is('profile') ? 'active' : '' }}">
                                        <i class="fas fa-user-cog nav-icon"></i>
                                        <p>Profile</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" class="nav-link"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="nav-icon fas fa-sign-out-alt"></i>
                                    <p>
                                        Keluar
                                    </p>
                                </a>
                            </form>
                        </li>


                    </ul>
                </nav>

            </div>

        </aside>
