<x-header>{{ $judul }}</x-header>
<div class="content-wrapper">
    <x-breadcrumb>{{ $judul }}</x-breadcrumb>

    <section class="content">
        <div class="container-fluid">
            <!-- Card Container -->
            <div class="card card-modern">
                <div class="card-header bg-gradient-primary">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title text-white">
                            <i class="fas fa-users mr-2"></i> {{ $judul }}
                        </h3>
                        <button class="btn btn-light btn-sm btn-add-user" onclick="openUserModal()">
                            <i class="fas fa-plus-circle mr-1"></i> Tambah Pengguna
                        </button>
                    </div>
                </div>



                <div class="card-body">
                    <!-- Search and Filter Bar -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="input-group input-group-modern">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                                <input type="text" id="searchInput" class="form-control"
                                    placeholder="Cari pengguna..." onkeyup="searchUsers()">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control select-modern" id="sortSelect" onchange="sortUsers()">
                                <option value="">Urutkan berdasarkan</option>
                                <option value="name-asc">Nama (A-Z)</option>
                                <option value="name-desc">Nama (Z-A)</option>
                                <option value="date-asc">Tanggal Terbaru</option>
                                <option value="date-desc">Tanggal Terlama</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control select-modern" id="filterSelect" onchange="filterUsers()">
                                <option value="">Semua Role</option>
                                <option value="admin">Admin</option>
                                <option value="gtk">GTK</option>
                                <option value="siswa">Siswa</option>
                            </select>
                        </div>

                        <div class="col-md-2 text-right">
                            <button class="btn btn-outline-secondary btn-refresh" onclick="resetFilters()">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>

                    <!-- User Table -->
                    <div class="table-responsive">
                        <table id="users-table" class="table table-hover table-modern">
                            <thead class="bg-light">
                                <tr>
                                    <th onclick="sortTable('name')" class="sortable" data-sort="name">
                                        Nama <i class="fas fa-sort ml-1"></i>
                                    </th>
                                    <th>Email</th>
                                    <th onclick="sortTable('date')" class="sortable" data-sort="date">
                                        Tanggal Buat <i class="fas fa-sort ml-1"></i>
                                    </th>
                                    <th class="text-center">Status</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="usersTableBody">
                                @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle mr-3">
                                                    <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $user->name }}</h6>
                                                    <small class="text-muted">ID: {{ $user->id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td data-date="{{ $user->created_at->format('Y-m-d') }}">
                                            <div class="d-flex flex-column">
                                                <span>{{ $user->created_at->format('d M Y') }}</span>
                                                <small
                                                    class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if ($user->roles->isNotEmpty())
                                                <span class="badge badge-primary"
                                                    data-role="{{ $user->roles->first()->name }}">
                                                    {{ $user->roles->first()->name }}
                                                </span>
                                            @else
                                                <span class="badge badge-secondary" data-role="none">Tidak ada
                                                    role</span>
                                            @endif
                                        </td>


                                        <td class="text-right">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button class="btn btn-outline-warning btn-role"
                                                    data-id="{{ $user->id }}"
                                                    data-role="{{ $user->roles->first()->name ?? '' }}">
                                                    <i class="fas fa-user-tag"></i>
                                                </button>
                                                <button class="btn btn-outline-primary btn-edit"
                                                    data-id="{{ $user->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-outline-info btn-view"
                                                    data-id="{{ $user->id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-outline-danger btn-delete"
                                                    data-id="{{ $user->id }}"
                                                    data-role="{{ $user->roles->first()->name ?? '' }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted" id="userCount">
                            Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari
                            {{ $users->total() }} pengguna
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-modern">
                                {{ $users->links() }}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>


</div>
<x-footer></x-footer>

<!-- Modal Ubah Role -->
<div class="modal fade" id="roleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="roleForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Role Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="roleUserId">
                    <div class="form-group">
                        <label for="roleSelect">Role</label>
                        <select name="role" id="roleSelect" class="form-control" required>
                            <option value="admin">Admin</option>
                            <option value="gtk">GTK</option>
                            <option value="siswa">Siswa</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>


{{-- Modal --}}
<div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="userForm" action="{{ route('admin.users.store') }}">
            @csrf
            <input type="hidden" name="_method" value="POST" id="formMethod">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah/Edit Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- Nama --}}
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" name="name" id="nameInput" class="form-control" required>
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="emailInput" class="form-control" required>
                    </div>

                    {{-- Password --}}
                    <div class="form-group">
                        <label for="password">Password <small class="text-muted">(Kosongkan jika tidak
                                diubah)</small></label>
                        <input type="password" name="password" id="passwordInput" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="passwordConfirmationInput"
                            class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Script --}}
<script>
    $(document).ready(function() {
        // Tombol Tambah
        $('.btn-tambah').on('click', function() {
            openUserModal();
        });

        // Tombol Edit
        $('.btn-edit').on('click', function() {
            const id = $(this).data('id');

            $.get(`/admin/users/${id}`, function(user) {
                openUserModal(user); // Kirim data user ke modal
            }).fail(function() {
                toastr.error('Gagal mengambil data pengguna.');
            });
        });

        // Tombol View
        $('.btn-view').on('click', function() {
            const id = $(this).data('id');

            $.get(`/admin/users/${id}`, function(user) {
                openUserModal(user, true);
            }).fail(function() {
                toastr.error('Gagal menampilkan detail pengguna.');
            });
        });

        // Tombol Hapus
        $('.btn-delete').on('click', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            const role = $(this).data('role');

            if (role.toLowerCase() === 'admin') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Aksi tidak diizinkan!',
                    text: 'Pengguna dengan role admin tidak dapat dihapus.',
                });
                return;
            }

            Swal.fire({
                title: 'Hapus pengguna ini?',
                text: "Data tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/users/${id}`,
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            toastr.success(res.message);
                            setTimeout(() => location.reload(), 1000);
                        },
                        error: function(xhr) {
                            const message = xhr.responseJSON?.message ||
                                'Gagal menghapus pengguna.';
                            toastr.error(message);
                        }
                    });
                }
            });
        });


        // Submit Form Modal
        $('#userForm').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            const formData = form.serialize();
            const actionUrl = form.attr('action');
            const method = $('#formMethod').val();

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData + '&_method=' + method,
                success: function(response) {
                    $('#userModal').modal('hide');
                    toastr.success('Pengguna berhasil disimpan.');
                    setTimeout(() => location.reload(), 1000); // delay reload
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        Object.values(errors).forEach(error => {
                            toastr.error(error[0]);
                        });
                    } else {
                        toastr.error('Terjadi kesalahan saat menyimpan pengguna.');
                    }
                }
            });
        });
    });


    function openUserModal(user = null, readonly = false) {
        const modal = $('#userModal');
        const form = $('#userForm');

        form.trigger("reset");
        $('#formMethod').val('POST');
        form.attr('action', `{{ route('admin.users.store') }}`);
        $('#emailInput, #nameInput, #passwordInput, #passwordConfirmationInput').prop('readonly', false);

        if (user) {
            $('#formMethod').val('PUT');
            form.attr('action', `/admin/users/${user.id}`);
            $('#nameInput').val(user.name);
            $('#emailInput').val(user.email);
            $('#passwordInput').val('');
            $('#passwordConfirmationInput').val('');

            if (readonly) {
                $('#emailInput, #nameInput, #passwordInput, #passwordConfirmationInput').prop('readonly', true);
                form.find('button[type="submit"]').hide();
            } else {
                form.find('button[type="submit"]').show();
            }
        } else {
            form.find('button[type="submit"]').show();
        }

        modal.modal('show');
    }
</script>


<script>
    // Fungsi pencarian
    function searchUsers() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toUpperCase();
        const table = document.getElementById('usersTableBody');
        const rows = table.getElementsByTagName('tr');
        let visibleCount = 0;

        for (let i = 0; i < rows.length; i++) {
            const nameColumn = rows[i].getElementsByTagName('td')[0];
            const emailColumn = rows[i].getElementsByTagName('td')[1];

            if (nameColumn || emailColumn) {
                const nameText = nameColumn.textContent || nameColumn.innerText;
                const emailText = emailColumn.textContent || emailColumn.innerText;

                if (nameText.toUpperCase().indexOf(filter) > -1 || emailText.toUpperCase().indexOf(filter) > -1) {
                    rows[i].style.display = "";
                    visibleCount++;
                } else {
                    rows[i].style.display = "none";
                }
            }
        }

        updateUserCount(visibleCount, rows.length);
    }

    // Fungsi sorting
    function sortUsers() {
        const sortSelect = document.getElementById('sortSelect');
        const sortValue = sortSelect.value;

        if (sortValue === 'name-asc') {
            sortTable('name', 'asc');
        } else if (sortValue === 'name-desc') {
            sortTable('name', 'desc');
        } else if (sortValue === 'date-asc') {
            sortTable('date', 'asc');
        } else if (sortValue === 'date-desc') {
            sortTable('date', 'desc');
        }
    }

    // Fungsi sorting tabel
    function sortTable(column, direction = 'asc') {
        const table = document.getElementById('usersTableBody');
        const rows = Array.from(table.getElementsByTagName('tr'));

        rows.sort((a, b) => {
            let aValue, bValue;

            if (column === 'name') {
                aValue = a.getElementsByTagName('td')[0].textContent.trim();
                bValue = b.getElementsByTagName('td')[0].textContent.trim();
            } else if (column === 'date') {
                aValue = a.getElementsByTagName('td')[2].getAttribute('data-date');
                bValue = b.getElementsByTagName('td')[2].getAttribute('data-date');
            }

            if (direction === 'asc') {
                return aValue.localeCompare(bValue);
            } else {
                return bValue.localeCompare(aValue);
            }
        });

        // Update arrow icons
        updateSortIcons(column, direction);

        // Rebuild table
        rows.forEach(row => table.appendChild(row));
    }

    // Fungsi filter
    function filterUsers() {
        const filterSelect = document.getElementById('filterSelect');
        const filterValue = filterSelect.value.toLowerCase(); // lowercase biar aman
        const table = document.getElementById('usersTableBody');
        const rows = table.getElementsByTagName('tr');
        let visibleCount = 0;

        for (let i = 0; i < rows.length; i++) {
            const roleBadge = rows[i].querySelector('[data-role]');
            const role = roleBadge ? roleBadge.getAttribute('data-role').toLowerCase() : '';

            if (filterValue === '' || role === filterValue) {
                rows[i].style.display = "";
                visibleCount++;
            } else {
                rows[i].style.display = "none";
            }
        }

        updateUserCount(visibleCount, rows.length);
    }


    // Fungsi reset filter
    function resetFilters() {
        document.getElementById('searchInput').value = '';
        document.getElementById('sortSelect').value = '';
        document.getElementById('filterSelect').value = '';

        const table = document.getElementById('usersTableBody');
        const rows = table.getElementsByTagName('tr');

        for (let i = 0; i < rows.length; i++) {
            rows[i].style.display = "";
        }

        // Reset sort icons
        document.querySelectorAll('.sortable i').forEach(icon => {
            icon.className = 'fas fa-sort ml-1';
        });

        updateUserCount(rows.length, rows.length);
    }

    // Update icon sorting
    function updateSortIcons(column, direction) {
        document.querySelectorAll('.sortable i').forEach(icon => {
            icon.className = 'fas fa-sort ml-1';
        });

        const icon = document.querySelector(`.sortable[data-sort="${column}"] i`);
        if (icon) {
            icon.className = direction === 'asc' ?
                'fas fa-sort-up ml-1' :
                'fas fa-sort-down ml-1';
        }
    }

    // Update counter pengguna
    function updateUserCount(visible, total) {
        const countElement = document.getElementById('userCount');
        if (countElement) {
            countElement.textContent = `Menampilkan ${visible} dari ${total} pengguna`;
        }
    }

    // Inisialisasi
    document.addEventListener('DOMContentLoaded', function() {
        // Tambahkan event listener untuk header kolom yang bisa di-sort
        document.querySelectorAll('.sortable').forEach(header => {
            header.addEventListener('click', function() {
                const column = this.getAttribute('data-sort');
                const currentSort = this.querySelector('i').className.includes('up') ? 'desc' :
                    'asc';
                sortTable(column, currentSort);
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.btn-role').on('click', function() {
            const userId = $(this).data('id');
            const role = $(this).data('role');

            $('#roleUserId').val(userId);
            $('#roleSelect').val(role.toLowerCase());
            $('#roleModal').modal('show');
        });

        // Submit form via AJAX
        $('#roleForm').on('submit', function(e) {
            e.preventDefault();

            const userId = $('#roleUserId').val();
            const newRole = $('#roleSelect').val();

            $.ajax({
                url: `/admin/users/${userId}/role`,
                method: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    role: newRole,
                },
                success: function(res) {
                    toastr.success('Role pengguna berhasil diperbarui');
                    $('#roleModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    toastr.error('Gagal memperbarui role pengguna');
                }
            });
        });
    });
</script>
