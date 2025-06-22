<x-header>{{ $judul }}</x-header>
<div class="content-wrapper">
    <x-breadcrumb>{{ $judul }}</x-breadcrumb>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="container">
                        <div class="card shadow">
                            <div class="card-header bg-primary text-white">
                                <h4><i class="fas fa-cogs mr-2"></i> Dokumentasi: Perintah <code>make:module</code></h4>
                            </div>
                            <div class="card-body">
                                <p class="lead">Perintah untuk membuat modul lengkap backend + frontend dengan
                                    struktur standar, siap pakai.</p>

                                <h5 class="mt-4"><i class="fas fa-terminal mr-2"></i>Cara Penggunaan</h5>
                                <pre class="bg-light p-3"><code>php artisan make:module NamaModul</code></pre>

                                <div class="alert alert-info">
                                    <strong>Contoh:</strong> <code>php artisan make:module KelulusanSiswa</code> akan
                                    menghasilkan folder <code>modules/KelulusanSiswa</code>
                                </div>

                                <h5 class="mt-4"><i class="fas fa-folder-open mr-2"></i>Struktur Folder</h5>
                                <pre class="bg-dark text-white p-3">
KelulusanSiswa/
├── Controllers/
│   ├── KelulusanSiswaController.php
│   └── KelulusanSiswaFrontendController.php
├── Models/
│   └── KelulusanSiswa.php
├── Views/
│   ├── index.blade.php
│   ├── menu.blade.php
│   └── frontend/index.blade.php
├── Migrations/
│   └── {timestamp}_create_kelulusansiswa_table.php
├── routes/
│   ├── admin.php
│   └── web.php
├── Lang/en/
├── module.json
      </pre>

                                <h5 class="mt-4"><i class="fas fa-cogs mr-2"></i>Penjelasan File</h5>
                                <ul class="list-group">
                                    <li class="list-group-item"><strong>Controllers/</strong>: Backend dan frontend
                                        controller</li>
                                    <li class="list-group-item"><strong>Views/</strong>: Blade untuk tampilan backend &
                                        frontend</li>
                                    <li class="list-group-item"><strong>Migrations/</strong>: File migrasi awal modul
                                    </li>
                                    <li class="list-group-item"><strong>Models/</strong>: Model utama tabel</li>
                                    <li class="list-group-item"><strong>routes/</strong>: admin.php (backend) & web.php
                                        (frontend publik)</li>
                                    <li class="list-group-item"><strong>module.json</strong>: Konfigurasi & metadata
                                        modul</li>
                                </ul>

                                <h5 class="mt-4"><i class="fas fa-shield-alt mr-2"></i>Permission Otomatis</h5>
                                <ul>
                                    <li>Disimpan ke tabel <code>permissions</code></li>
                                    <li>Didaftarkan ke helper: <code>register_permission_label()</code></li>
                                    <li>Cache permission direset via <code>permission:cache-reset</code></li>
                                </ul>

                                <h5 class="mt-4"><i class="fas fa-random mr-2"></i>Route yang Dihasilkan</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Jenis</th>
                                                <th>File</th>
                                                <th>URL</th>
                                                <th>Middleware</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>Backend</strong></td>
                                                <td><code>routes/admin.php</code></td>
                                                <td><code>/admin/{prefix}</code></td>
                                                <td><code>web, auth, permission:atur_xxx, module.active</code></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Frontend</strong></td>
                                                <td><code>routes/web.php</code></td>
                                                <td><code>/</code> (bisa dimodifikasi)</td>
                                                <td><code>module.active</code></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <h5 class="mt-4"><i class="fas fa-code-branch mr-2"></i>Tips Developer</h5>
                                <ul>
                                    <li>Ubah prefix di <code>module.json</code> untuk menyesuaikan URL</li>
                                    <li>Edit controller untuk menambah logika</li>
                                    <li>Gunakan view sesuai struktur: backend di <code>Views/</code>, frontend di
                                        <code>Views/frontend/</code>
                                    </li>
                                    <li>Untuk menambah menu sidebar, include <code>menu.blade.php</code></li>
                                </ul>

                                <div class="alert alert-success mt-4">
                                    ✅ Modul akan langsung siap pakai, terhubung ke database, permission system, dan tema
                                    frontend.
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>

</div>
<x-footer></x-footer>
