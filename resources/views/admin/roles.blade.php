<x-header>{{ $judul }}</x-header>
<div class="content-wrapper">
    <x-breadcrumb>{{ $judul }}</x-breadcrumb>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-primary card-outline">

                <div class="card-body">
                    <form id="permissionsForm" action="{{ route('roles.updatePermissions') }}" method="POST">
                        @csrf

                        <!-- Select User -->
                        <div class="form-group">
                            <label for="userSelect">Pilih Pengguna:</label>
                            <select id="userSelect" name="user_id" class="form-control">
                                <option value="">-- Pilih Pengguna --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $selectedUser && $selectedUser->id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Permissions -->
                        @php
                            use App\Helpers\PermissionHelper;
                        @endphp



                        <div id="permissions" class="form-group mt-4">
                            <label>Hak Akses:</label>
                            <div class="row">
                                @foreach ($permissions as $permission)
                                    <div class="col-md-2">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input custom-control-input-danger"
                                                type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                                id="permission{{ $permission->id }}">
                                            <label class="custom-control-label" for="permission{{ $permission->id }}">
                                                {{ PermissionHelper::getUserFriendlyName($permission->name) }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>


                        <button type="submit" class="btn btn-sm btn-primary"><i class='fas fa-user-lock mr-2'></i>
                            Perbarui
                            Hak Akses</button>
                    </form>
                </div>
            </div>

            <div class="alert alert-danger" role="alert">
                Hak Akses Pengguna mencakup operasi Tambah, Edit, dan Hapus. Silahkan disesuaikan dengan kebijakan
                masing-masing
                untuk setiap pengguna.
            </div>

        </div>
    </section>
</div>

<x-footer></x-footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userSelect = document.getElementById('userSelect');
        const permissionsCheckboxes = document.querySelectorAll('input[name="permissions[]"]');
        const form = document.getElementById('permissionsForm');

        userSelect.addEventListener('change', function() {
            const userId = userSelect.value;

            if (userId) {
                fetch(`/get-user-permissions/${userId}`)
                    .then(response => response.json())
                    .then(data => {
                        permissionsCheckboxes.forEach(checkbox => {
                            checkbox.checked = data.includes(parseInt(checkbox.value, 10));
                        });
                    })
                    .catch(error => console.error('Error:', error));
            }
        });

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin memperbarui hak akses?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Perbarui!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {

                    fetch(form.action, {
                            method: 'POST',
                            body: new FormData(form),
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {

                                Swal.fire({
                                    title: 'Sukses!',
                                    text: 'Hak akses telah diperbarui.',
                                    icon: 'success',
                                    confirmButtonColor: '#3085d6'
                                }).then(() => {

                                    window.location.href =
                                        "{{ route('roles.edit') }}";
                                });
                            } else {

                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Terjadi masalah saat memperbarui hak akses.',
                                    icon: 'error',
                                    confirmButtonColor: '#3085d6'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi masalah saat memperbarui hak akses.',
                                icon: 'error',
                                confirmButtonColor: '#3085d6'
                            });
                        });
                }
            });
        });
    });
</script>
