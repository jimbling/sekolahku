<x-header>{{ $judul ?? 'Formulir' }}</x-header>
<div class="content-wrapper">
    <x-breadcrumb>{{ $judul ?? 'Formulir' }}</x-breadcrumb>
    <section class="content">
        <div class="container-fluid">
            <!-- Tombol Tambah -->
            <div class="mb-3 text-right">
                <a href="{{ route('formulir.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> Formulir Baru
                </a>
            </div>

            <!-- Daftar Formulir -->
            <div class="row">
                @forelse($formulirs as $formulir)
                    <div class="col-md-6 col-lg-4">
                        <div class="card shadow-sm border border-light mb-4">
                            <div class="card-body">
                                <h5 class="card-title mb-1">{{ $formulir->title }}</h5>
                                <p class="text-muted small mb-2">{{ Str::limit($formulir->description, 80) }}</p>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('formulir.builder', $formulir->uuid) }}"
                                        class="btn btn-sm btn-success">
                                        <i class="fas fa-tools"></i> Builder
                                    </a>
                                    <a href="{{ route('formulir.edit', $formulir->uuid) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('formulir.destroy', $formulir->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus formulir ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">Belum ada formulir.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</div>
<x-footer />
