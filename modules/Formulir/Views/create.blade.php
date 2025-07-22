<x-header>Buat Formulir</x-header>
<div class="content-wrapper">
    <x-breadcrumb>Buat Formulir</x-breadcrumb>
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('formulir.store') }}" method="POST">
                @csrf

                <div class="card shadow-sm border border-light">
                    <div class="card-header">
                        <h3 class="card-title">Formulir Baru</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Judul Formulir</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        <div class="form-group mt-3">
                            <label for="description">Deskripsi (Opsional)</label>
                            <textarea name="description" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan & Lanjut ke Builder
                        </button>
                        <a href="{{ route('formulir.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
<x-footer />
