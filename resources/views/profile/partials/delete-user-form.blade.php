<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Hapus Akun') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Setelah akun Anda dihapus, semua sumber daya dan data di dalamnya akan dihapus secara permanen. Sebelum menghapus akun Anda, harap unduh semua data atau informasi yang ingin Anda simpan.') }}
        </p>
    </header>

    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirm-user-deletion">Hapus
        Akun</button>


    <div class="modal fade" id="confirm-user-deletion" data-backdrop="static" tabindex="-1"
        aria-labelledby="confirm-user-deletion-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                    @csrf
                    @method('delete')

                    <div class="modal-header">
                        <h5 class="modal-title" id="confirm-user-deletion-label">Apakah anda yakin akan menghapus akun
                            ini?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p class="mt-1 text-sm text-dark">
                            Setelah akun Anda dihapus, semua sumber daya dan data di dalamnya akan dihapus secara
                            permanen. Silakan masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus
                            akun Anda secara permanen.
                        </p>

                        <div class="mt-3">
                            <label for="password" class="form-label sr-only">Password</label>
                            <input id="password" name="password" type="password" class="form-control"
                                placeholder="Password" />
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
