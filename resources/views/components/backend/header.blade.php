<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="base-url" content="{{ url('/') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ get_setting('meta_description') }}">
    <meta name="keywords" content="{{ get_setting('meta_keywords') }}">
    <title>{{ $slot }} - {{ get_setting('school_name') }} {{ get_setting('district') }}</title>

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
                            <a href="{{ route('admin.messages.show', $message->id) }}" class="dropdown-item">
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
                        <a href="{{ route('admin.messages.index') }}" class="dropdown-item dropdown-footer">Lihat semua
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

            <a href="/admin" class="brand-link bg-olive">
                <img src="{{ asset('lte/dist/img/sinaucms-logo.png') }}" alt="Sinau CMS"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-bold">Sinau CMS</span>
            </a>

            <div class="sidebar">

                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ '/storage/images/illustrasi/gtk-pria.jpg' }}" class="img-circle elevation-2"
                            alt="User Sinau CMS">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ current_user()->name }}</a>
                    </div>
                </div>
                @php
                    use Illuminate\Support\Facades\Request;
                    $menus = config('menu');
                @endphp



                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    @foreach ($menus as $menu)
                        @php
                            $hasChildren = isset($menu['children']) && is_array($menu['children']);
                            $isActive =
                                (isset($menu['pattern']) && Request::is($menu['pattern'])) ||
                                collect($menu['children'] ?? [])->some(
                                    fn($child) => Request::is($child['pattern'] ?? ''),
                                );
                            $menuUrl =
                                isset($menu['url']) && is_string($menu['url'])
                                    ? url('admin/' . ltrim($menu['url'], '/'))
                                    : '#';
                        @endphp

                        @if (!isset($menu['permission']) || auth()->user()->can($menu['permission']))
                            <li class="nav-item {{ $hasChildren && $isActive ? 'menu-open' : '' }}">
                                <a href="{{ $menu['external'] ?? false ? $menu['url'] : $menuUrl }}"
                                    class="nav-link {{ $isActive ? 'active' : '' }}"
                                    @if ($menu['external'] ?? false) target="_blank" @endif>
                                    <i class="nav-icon {{ $menu['icon'] }}"></i>
                                    <p>
                                        {{ $menu['title'] }}
                                        @if ($hasChildren)
                                            <i class="fas fa-angle-left right"></i>
                                        @endif
                                    </p>
                                </a>

                                @if ($hasChildren)
                                    <ul class="nav nav-treeview ml-2">
                                        @foreach ($menu['children'] as $child)
                                            @if (!isset($child['permission']) || auth()->user()->can($child['permission']))
                                                @php
                                                    $childHasChildren =
                                                        isset($child['children']) && is_array($child['children']);
                                                    $isChildActive =
                                                        (isset($child['pattern']) && Request::is($child['pattern'])) ||
                                                        collect($child['children'] ?? [])->contains(
                                                            fn($sub) => Request::is($sub['pattern'] ?? ''),
                                                        );
                                                    $childUrl =
                                                        isset($child['url']) && is_string($child['url'])
                                                            ? url('admin/' . ltrim($child['url'], '/'))
                                                            : '#';
                                                @endphp

                                                <li
                                                    class="nav-item {{ $childHasChildren && $isChildActive ? 'menu-open' : '' }}">
                                                    <a href="{{ $childUrl }}"
                                                        class="nav-link {{ $isChildActive ? 'active' : '' }}">
                                                        <i class="fas fa-angle-right nav-icon"></i>
                                                        <p>
                                                            {{ $child['title'] }}
                                                            @if ($childHasChildren)
                                                                <i class="fas fa-angle-left right"></i>
                                                            @endif
                                                        </p>
                                                    </a>

                                                    @if ($childHasChildren)
                                                        <ul class="nav nav-treeview ml-4">
                                                            @foreach ($child['children'] as $sub)
                                                                @php
                                                                    $subUrl =
                                                                        isset($sub['url']) && is_string($sub['url'])
                                                                            ? url('admin/' . ltrim($sub['url'], '/'))
                                                                            : '#';
                                                                @endphp
                                                                <li class="nav-item">
                                                                    <a href="{{ $subUrl }}"
                                                                        class="nav-link {{ Request::is($sub['pattern'] ?? '') ? 'active' : '' }}">
                                                                        <i class="fas fa-angle-right nav-icon"></i>
                                                                        <p>{{ $sub['title'] }}</p>
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endif
                    @endforeach

                    {{-- ========================= --}}
                    {{-- ===== MODUL DINAMIS ===== --}}
                    {{-- ========================= --}}
                    @php
                        $modulActive = collect($moduleMenus ?? [])->contains(function ($view) {
                            $slug = str_replace('::menu', '', $view);
                            return request()->is("admin/{$slug}*");
                        });
                    @endphp

                    <!-- Header -->
                    <li class="nav-header">MODUL</li>

                    <!-- 1. Kelola Modul -->
                    @can('atur_modul')
                        <li class="nav-item">
                            <a href="/admin/modules"
                                class="nav-link {{ request()->is('admin/modules') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tools"></i>
                                <p>Kelola Modul</p>
                            </a>
                        </li>
                    @endcan

                    <!-- 2. Daftar Modul -->
                    <li class="nav-item {{ $modulActive ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ $modulActive ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cubes"></i>
                            <p>
                                Daftar Modul
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            @foreach ($moduleMenus as $menu)
                                @includeIf($menu)
                            @endforeach
                        </ul>
                    </li>



                </ul>




            </div>

        </aside>
