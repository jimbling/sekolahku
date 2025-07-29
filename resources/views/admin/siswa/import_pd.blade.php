<x-header>{{ $judul = 'Import Data Peserta Didik' }}</x-header>
<div class="content-wrapper">
    <x-breadcrumb>{{ $judul }}</x-breadcrumb>

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-file-import mr-1"></i> {{ $judul }}</h3>
                        </div>
                        <div class="card-body">

                            <p class="mb-3">
                                Silakan <strong>copy dan paste</strong> data dari Excel ke dalam textarea di bawah ini.
                                Gunakan
                                format <code>TAB</code> sebagai pemisah antar kolom.
                                <br>
                                <small class="text-muted">Kolom: NIS, Nama, Tempat Lahir, Tanggal Lahir, Gender, Email,
                                    No HP,
                                    Alamat</small>
                            </p>

                            <form action="{{ route('admin.student.importForm') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="raw_data">Data Siswa</label>
                                    <textarea name="raw_data" id="raw_data" class="form-control" rows="10" required>{{ old('raw_data') }}</textarea>
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-eye mr-1"></i> Preview Data
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if (session('students'))
                        <div class="card card-success card-outline shadow-sm">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-search mr-1"></i> Preview Data</h3>
                            </div>
                            <div class="card-body">

                                <p>Periksa kembali data berikut sebelum disimpan ke database.</p>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-sm">
                                        <thead class="bg-success text-white text-center">
                                            <tr>
                                                <th>NIS</th>
                                                <th>Nama</th>
                                                <th>Tempat Lahir</th>
                                                <th>Tanggal Lahir</th>
                                                <th>Gender</th>
                                                <th>Email</th>
                                                <th>No HP</th>
                                                <th>Alamat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (session('students') as $siswa)
                                                <tr>
                                                    <td>{{ $siswa['nis'] }}</td>
                                                    <td>{{ $siswa['name'] }}</td>
                                                    <td>{{ $siswa['birth_place'] }}</td>
                                                    <td>{{ $siswa['birth_date'] }}</td>
                                                    <td>{{ $siswa['gender'] }}</td>
                                                    <td>{{ $siswa['email'] }}</td>
                                                    <td>{{ $siswa['no_hp'] }}</td>
                                                    <td>{{ $siswa['alamat'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <form action="{{ route('student.import') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="students"
                                        value="{{ json_encode(session('students')) }}">
                                    <div class="mt-3 text-right">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save mr-1"></i> Simpan ke Database
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

</div>
<x-footer />
