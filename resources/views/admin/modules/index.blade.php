<x-header>{{ $judul }}</x-header>
<div class="content-wrapper">
    <x-breadcrumb>{{ $judul }}</x-breadcrumb>
    <section class="content">
        <div class="container-fluid">
            <a href="{{ route('admin.modules.create') }}" class="btn btn-primary mb-3">Tambah Modul</a>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Alias</th>
                        <th>Versi</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($modules as $modul)
                        <tr>
                            <td>{{ $modul->name }}</td>
                            <td>{{ $modul->alias }}</td>
                            <td>{{ $modul->version }}</td>
                            <td>{{ $modul->description }}</td>
                            <td>
                                <form action="{{ route('admin.modules.toggle', $modul) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm {{ $modul->enabled ? 'btn-success' : 'btn-secondary' }}">
                                        {{ $modul->enabled ? 'Aktif' : 'Nonaktif' }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('admin.modules.edit', $modul) }}"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.modules.destroy', $modul) }}" method="POST"
                                    style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus modul ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>
<x-footer />
