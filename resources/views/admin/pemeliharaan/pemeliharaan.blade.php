<x-header>{{ $judul }}</x-header>
<div class="content-wrapper">
    <x-breadcrumb>{{ $judul }}</x-breadcrumb>

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <!-- Card untuk Backup Sistem dan Backup Database SQL -->
                <div class="col-md-12">
                    <div class="card bg-gradient-danger mb-4">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class="fas fa-database"></i>
                                Backup Sistem dan Database
                            </h3>
                        </div>
                        <div class="card-body">
                            <!-- Form untuk membuat backup sistem -->
                            <form id="backupForm" action="{{ route('admin.backup.create') }}" method="POST"
                                class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-light">
                                    Buat Backup Sistem</button>
                            </form>

                            <!-- Form untuk membuat backup database SQL -->
                            <form id="backupSqlForm" action="{{ route('admin.backups.sql') }}" method="GET"
                                class="d-inline ml-2">
                                @csrf
                                <button type="submit" class="btn btn-warning">Buat Backup SQL</button>
                            </form>

                            <!-- Daftar file backup -->
                            <h5 class="mt-4">Daftar Backup:</h5>
                            @if ($backups->isEmpty())
                                <p>Tidak ada file backup tersedia.</p>
                            @else
                                <ul class="list-group">
                                    @foreach ($backups as $backup)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="backup-file-name">
                                                {{ $backup->filename }} ({{ round($backup->size / (1024 * 1024)) }} MB)
                                            </span>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.backup.download', ['filename' => $backup->filename]) }}"
                                                    class="btn btn-primary btn-sm ml-2">
                                                    <i class="fas fa-download"></i> Unduh
                                                </a>
                                                <button class="btn btn-danger btn-sm ml-2"
                                                    onclick="deleteBackup('{{ $backup->filename }}')">
                                                    <i class="fas fa-trash-alt"></i> Hapus
                                                </button>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>


                            @endif
                        </div>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-md-12">

                    <div class="callout callout-danger">
                        <h5 class="alert-heading">Informasi Backup</h5>
                        <p class="mb-2">
                            Backup Sistem akan menghasilkan file .zip yang dapat diunduh. File .zip tersebut
                            berisi dua bagian:
                        </p>
                        <ul class="list-unstyled">
                            <li><strong>File Sistem:</strong> Berisi keseluruhan source code aplikasi CMS Sinau.
                            </li>
                            <li><strong>File Database:</strong> Berisi database MySQL dalam format .sql.</li>
                        </ul>
                        <p class="mt-2">
                            Disarankan untuk rutin melakukan backup untuk mengantisipasi hal-hal yang tidak
                            diinginkan di kemudian hari. Simpan file backup di tempat lain. Jika tidak ingin membackup
                            sistem secara keseluruhan, dapat memanfaatkan Backup SQL, yang hanya membackup file database
                            .sql saja.
                            Setelah yakin telah mengamankan file backup, <strong style="color: red;">lakukan penghapusan
                                file backup pada sistem karena file backup dapat membebani kapasitas hosting yang
                                digunakan.</strong>
                        </p>

                    </div>


                </div>
            </div>


        </div>
    </section>

</div>
<x-footer></x-footer>
<script>
    const deleteBackupUrl = '{{ url('/admin/backup/delete') }}';
</script>
<script src="{{ asset('lte/dist/js/backend/pemeliharaan.js') }}"></script>
