<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="">
        @csrf
        @method('put')

        <div class="form-group row">
            <label for="update_password_current_password" class="col-sm-4 col-form-label font-weight-bold">Password
                Lama</label>
            <div class="col-sm-8">
                <input id="update_password_current_password" name="current_password" type="password" class="form-control"
                    autocomplete="current-password" />
                @error('current_password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="form-group row ">
            <label for="update_password_password" class="col-sm-4 col-form-label font-weight-bold">Password Baru</label>
            <div class="col-sm-8">
                <input id="update_password_password" name="password" type="password" class="form-control"
                    autocomplete="new-password" />
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="update_password_password_confirmation"
                class="col-sm-4 col-form-label font-weight-bold">Konfirmasi Password</label>
            <div class="col-sm-8">
                <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                    class="form-control" autocomplete="new-password" />
                @error('password_confirmation')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="d-flex align-items-center gap-4">
            <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>

            @if (session('status') === 'password-updated')
                <div class="text-success">Tersimpam.</div>
            @endif
        </div>
    </form>
</section>
