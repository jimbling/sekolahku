<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4" id="login-form">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="input input-bordered w-full" type="email" name="email" :value="old('email')"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="input input-bordered w-full" type="password" name="password" required
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="checkbox checkbox-primary" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-4">
            @if (Route::has('password.request'))
                <a class="link link-primary text-sm" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif

            <x-primary-button class="btn btn-primary" id="submit-btn">
                {{ __('Masuk') }}
            </x-primary-button>
        </div>
    </form>

</x-guest-layout>


<script>
    document.getElementById('login-form').addEventListener('submit', function(e) {
        e.preventDefault(); // Cegah submit langsung

        Swal.fire({
            title: 'Sedang memproses...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Kirim form via fetch
        const form = e.target;
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
            },
            body: formData
        }).then(async response => {
            if (response.ok) {
                Swal.fire({
                    icon: 'success',
                    title: 'Login Berhasil!',
                    timer: 1500,
                    showConfirmButton: false
                });

                setTimeout(() => {
                    window.location.href = "{{ route('dashboard') }}";
                }, 1600);
            } else {
                const data = await response.json();
                Swal.close();

                // Tampilkan pesan error di bawah input
                if (data.errors) {
                    for (const field in data.errors) {
                        const el = document.querySelector(`[name="${field}"]`);
                        if (el) el.classList.add('border-red-500'); // opsional
                    }
                }

                if (data.message) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Login',
                        text: data.message,
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan',
                        text: 'Periksa kembali data login Anda.',
                    });
                }
            }
        }).catch(() => {
            Swal.fire({
                icon: 'error',
                title: 'Gagal terhubung',
                text: 'Coba lagi beberapa saat.',
            });
        });
    });
</script>
