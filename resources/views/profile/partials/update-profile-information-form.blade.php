<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="name" class="font-weight-bold">Name</label>
                <input id="name" name="name" type="text" class="form-control"
                    value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="email" class="font-weight-bold">Email</label>
                <input id="email" name="email" type="email" class="form-control"
                    value="{{ old('email', $user->email) }}" required autocomplete="email" />
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-dark">
                            Your email address is unverified.

                            <button form="send-verification" class="btn btn-link text-sm text-secondary">Click here
                                to re-send the verification email.</button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-success">
                                A new verification link has been sent to your email address.
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="d-flex align-items-center gap-4 mt-3">
            <button type="submit" class="btn btn-primary">Simpan</button>

            @if (session('status') === 'profile-updated')
                <div class="text-success">Tersimpan.</div>
            @endif
        </div>
    </form>
</section>
