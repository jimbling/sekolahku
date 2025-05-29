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
                                UPDATES, UPGRADES, FIXED BUGS
                            </h3>
                        </div>
                        <div class="card-body">

                            <table class="min-w-full border border-gray-300 bg-white">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="border px-4 py-2">Versi</th>
                                        <th class="border px-4 py-2">Changelog</th>
                                        <th class="border px-4 py-2">Tanggal Rilis</th>
                                        <th class="border px-4 py-2">File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($updates as $update)
                                        <tr>
                                            <td class="border px-4 py-2">{{ $update->version }}</td>
                                            <td class="border px-4 py-2">{{ $update->changelog }}</td>
                                            <td class="border px-4 py-2">{{ $update->release_date }}</td>
                                            <td class="border px-4 py-2">
                                                <a href="{{ route('updates.download', $update->id) }}"
                                                    class="text-blue-500">Download</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>






        </div>
    </section>

</div>
<x-footer></x-footer>
