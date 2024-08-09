<x-guest-layout>

    <!-- Toast container -->
    <div id="toast-container" class="fixed  toast-top right-4 space-y-2 z-50">
        <!-- Toast message -->
        <div id="toast" class="hidden toast bg-blue-500 text-white p-4 rounded shadow-lg">
            <p id="toast-message">Pesan berhasil dikirim!</p>
            <button id="toast-close" class="absolute top-1 right-2 text-white">
                &times;
            </button>
        </div>
    </div>



    <div class="mb-4 text-sm text-gray-600">
        {{ __('Lupa password? Tidak masalah! Beritahu kami alamat email Anda, dan kami akan mengirimkan tautan reset password ke email Anda. Tautan tersebut akan memungkinkan Anda untuk memilih password baru.') }}
    </div>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        function showToast(message) {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');
            const toastClose = document.getElementById('toast-close');

            toastMessage.textContent = message;
            toast.classList.remove('hidden');
            toast.classList.add('show');

            toastClose.addEventListener('click', () => {
                toast.classList.remove('show');
                toast.classList.add('hide');
                setTimeout(() => toast.classList.add('hidden'), 500);
            });

            setTimeout(() => {
                toast.classList.remove('show');
                toast.classList.add('hide');
                setTimeout(() => toast.classList.add('hidden'), 500);
            }, 5000);
        }

        @if (session('status'))
            showToast('{{ session('status') }}');
        @endif
    </script>

</x-guest-layout>
