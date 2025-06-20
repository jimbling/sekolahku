<x-header>{{ $judul }}</x-header>
<div class="content-wrapper">
    <x-breadcrumb>{{ $judul }}</x-breadcrumb>
    <section class="content">
        <div class="container-fluid">
            <form action="{{ isset($module) ? route('admin.modules.update', $module) : route('admin.modules.store') }}"
                method="POST">
                @csrf
                @if (isset($module))
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label>Nama Modul</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $module->name ?? '') }}"
                        required>
                </div>
                <div class="form-group">
                    <label>Alias</label>
                    <input type="text" name="alias" class="form-control"
                        value="{{ old('alias', $module->alias ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label>Versi</label>
                    <input type="text" name="version" class="form-control"
                        value="{{ old('version', $module->version ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control">{{ old('description', $module->description ?? '') }}</textarea>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" name="enabled" class="form-check-input" value="1"
                        {{ old('enabled', $module->enabled ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label">Aktif</label>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </section>
</div>
<x-footer />
