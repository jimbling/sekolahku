<x-header>{{ $judul }}</x-header>
<div class="content-wrapper">
    <x-breadcrumb>{{ $judul }}</x-breadcrumb>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <div class="container">
                                <form method="GET" action="{{ route('rombels.filter') }}" class="form-inline mb-4">
                                    <div class="form-group mr-2">
                                        <label for="academic_year" class="mr-2">Tahun Pelajaran</label>
                                        <select class="form-control form-control-sm" id="academic_year"
                                            name="academic_year">
                                            <option value="">Pilih Tahun Pelajaran</option>
                                            @foreach ($academicYears as $year)
                                                <option value="{{ $year->academic_year }}"
                                                    {{ isset($selectedAcademicYear) && $selectedAcademicYear == $year->academic_year ? 'selected' : '' }}>
                                                    {{ $year->academic_year }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mr-2 ml-4">
                                        <label for="classroom" class="mr-2">Kelas</label>
                                        <select class="form-control form-control-sm" id="classroom" name="classroom">
                                            <option value="">Pilih Kelas</option>
                                            @foreach ($classrooms as $classroom)
                                                <option value="{{ $classroom->name }}"
                                                    {{ isset($selectedClassroom) && $selectedClassroom == $classroom->name ? 'selected' : '' }}>
                                                    {{ $classroom->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                                </form>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm table-hover" id="rombelTable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>NO</th>
                                                <th>Tahun Pelajaran</th>
                                                <th>Semester</th>
                                                <th>Kelas</th>
                                                <th>NIS</th>
                                                <th>Nama</th>
                                                <th>JK</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1; // Inisialisasi nomor urut
                                                $studentsDisplayed = []; // Array untuk melacak siswa yang sudah ditampilkan
                                            @endphp
                                            @foreach ($students as $student)
                                                @if (!in_array($student->id, $studentsDisplayed))
                                                    @foreach ($student->anggotaRombels as $anggotaRombel)
                                                        @if (empty($selectedAcademicYear) && empty($selectedClassroom))
                                                            <!-- Tampilkan semua data siswa jika filter tidak ada -->
                                                            <tr>
                                                                <td>{{ $no++ }}</td>
                                                                <td>{{ $anggotaRombel->rombel->academicYear->academic_year }}
                                                                </td>
                                                                <td>{{ $anggotaRombel->rombel->academicYear->semester }}
                                                                </td>
                                                                <td>{{ $anggotaRombel->rombel->classroom->name }}</td>
                                                                <td>{{ $student->nis }}</td>
                                                                <td>{{ $student->name }}</td>
                                                                <td>
                                                                    @if ($student->gender == 'F')
                                                                        Perempuan
                                                                    @elseif($student->gender == 'M')
                                                                        Laki-Laki
                                                                    @else
                                                                        Tidak Diketahui
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @break

                                                        // Hentikan loop anggotaRombels jika sudah ditemukan yang
                                                        sesuai
                                                    @elseif (
                                                        $anggotaRombel->rombel->academicYear->academic_year == $selectedAcademicYear &&
                                                            $anggotaRombel->rombel->classroom->name == $selectedClassroom)
                                                        <!-- Tampilkan data siswa yang sesuai dengan filter -->
                                                        <tr>
                                                            <td>{{ $no++ }}</td>
                                                            <td>{{ $anggotaRombel->rombel->academicYear->academic_year }}
                                                            </td>
                                                            <td>{{ $anggotaRombel->rombel->academicYear->semester }}
                                                            </td>
                                                            <td>{{ $anggotaRombel->rombel->classroom->name }}</td>
                                                            <td>{{ $student->nis }}</td>
                                                            <td>{{ $student->name }}</td>
                                                            <td>
                                                                @if ($student->gender == 'F')
                                                                    Perempuan
                                                                @elseif ($student->gender == 'M')
                                                                    Laki-Laki
                                                                @else
                                                                    Tidak Diketahui
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @break

                                                    // Hentikan loop anggotaRombels jika sudah ditemukan yang
                                                    sesuai
                                                @endif
                                            @endforeach
                                            @php
                                                $studentsDisplayed[] = $student->id; // Tambahkan ID siswa ke daftar yang ditampilkan
                                            @endphp
                                        @endif
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>


                </div>
            </div>
        </div>

    </div>
</section>

</div>




<x-footer></x-footer>
