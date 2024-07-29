<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ClassroomController;
use App\Http\Controllers\Backend\TagController;
use App\Http\Controllers\Frontend\PostinganController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Backend\QuoteController;
use App\Http\Controllers\Backend\LinkController;
use App\Http\Controllers\Backend\ImageController;
use App\Http\Controllers\Backend\MessageController;
use App\Http\Controllers\Backend\MenuController;
use App\Http\Controllers\Backend\StudentController;
use App\Http\Controllers\Backend\RombelController;
use App\Http\Controllers\Backend\AnggotaRombelController;
use App\Http\Controllers\Backend\AcademicYearsController;
use App\Http\Controllers\Backend\GtkController;
use App\Http\Controllers\Backend\FilesController;
use App\Http\Controllers\Backend\VideoController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\RoleController;

use App\Http\Middleware\CheckMaintenanceMode;
use App\Http\Controllers\Frontend\DirektoriController;
use App\Http\Controllers\Frontend\MediaController;

use Illuminate\Support\Facades\Route;





//  Rute-rute Frontend yang memerlukan pemeliharaan situs
Route::middleware([CheckMaintenanceMode::class])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('web.home');
    Route::get('/hubungi-kami', [HomeController::class, 'hubungi_kami'])->name('web.hubungi_kami');
    Route::get('/news', [PostinganController::class, 'index'])->name('news.index');
    Route::get('/read/{id}/{slug}', [PostinganController::class, 'show'])->name('posts.show');
    Route::get('/pages/{slug}', [PostinganController::class, 'showPages'])->name('posts.show.pages');
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile');
    Route::get('/guru-tendik', [DirektoriController::class, 'gtk'])->name('web.gtk');
    Route::get('/api/gtk', [DirektoriController::class, 'gtkData']);
    Route::get('/api/gtk/{id}', [DirektoriController::class, 'gtkDetail']);
    Route::get('/peserta-didik', [DirektoriController::class, 'peserta_didik'])->name('web.pd');
    Route::get('/pd-non-aktif', [DirektoriController::class, 'peserta_didik_non_aktif'])->name('web.pd.non.active');
    Route::get('/pd/nonaktif', [DirektoriController::class, 'nonaktif']);
    Route::post('/pd/filter', [DirektoriController::class, 'filterPesertaDidik'])->name('web.pd.filter');
    Route::get('/kategori/{slug}', [PostinganController::class, 'showCategoryPosts'])->name('category.posts');
    Route::get('/tags/{slug}', [PostinganController::class, 'showTagsPosts'])->name('tags.posts');
    Route::get('/pencarian', [PostinganController::class, 'search'])->name('search.results');
    Route::get('/berita', [PostinganController::class, 'berita'])->name('index.berita');

    Route::get('/galeri/video', [PostinganController::class, 'videos'])->name('web.videos');
    Route::get('/cari/video', [PostinganController::class, 'searchVideos'])->name('web.cari.videos');
    Route::get('/galeri/video/detail/{id}/{slug}', [PostinganController::class, 'videosDetail'])->name('web.videos.detail');


    // Media
    Route::get('/unduhan', [MediaController::class, 'unduhan'])->name('web.unduhan');
    Route::get('/cari/files', [MediaController::class, 'search'])->name('web.cari.unduhan');
    Route::get('/unduh/{id}', [MediaController::class, 'unduhFile'])->name('unduh.file');

    Route::get('/menu', [HomeController::class, 'menu']);
    Route::post('/kirim-pesan', [MessageController::class, 'store'])->name('messages.store');
});

// Rute untuk maintenance
Route::get('/perawatan', function () {
    return view('maintenance');
})->name('maintenance');

// Rute-rute yang tidak memerlukan pemeliharaan situs atau autentikasi
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {

    // Rute untuk fitur blog
    Route::middleware(['permission:edit_posts'])->prefix('blog')->group(function () {
        // Image Upload
        Route::post('/image/upload', [ImageController::class, 'upload'])->name('image.upload');

        // Posts
        Route::prefix('posts')->group(function () {
            Route::get('/', [PostController::class, 'index'])->name('blog.posts');
            Route::get('/create', [PostController::class, 'create'])->name('admin.posts.create');
            Route::post('/store', [PostController::class, 'store'])->name('posts.store');
            Route::get('/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
            Route::put('/{id}', [PostController::class, 'update'])->name('posts.update');
            Route::delete('/{id}', [PostController::class, 'destroy'])->name('admin.posts.destroy');
            Route::delete('/delete-selected', [PostController::class, 'deleteSelected'])->name('admin.posts.deleteSelected');
            Route::post('/update-published/{id}', [PostController::class, 'updatePublishedAt'])->name('admin.posts.updatePublished');
            Route::get('/{id}/content', [PostController::class, 'getPostContent'])->name('admin.posts.content');
            Route::get('/{id}/published_at', [PostController::class, 'getPublishedAt'])->name('blog.posts.published_at');
        });

        // Admin Data
        Route::get('admin/posts/data', [PostController::class, 'getPosts'])->name('admin.posts.data');
    });

    // Kategori
    Route::middleware(['permission:edit_categories'])->prefix('blog')->group(function () {
        Route::post('/new_posts/kategori/simpan', [CategoryController::class, 'simpanNewPosts'])->name('kategori.simpan');
        Route::post('/tambah/kategori/simpan', [CategoryController::class, 'simpanKategori'])->name('kategori.tambah');
        Route::get('/posts/post_categories', [CategoryController::class, 'index'])->name('blog.kategori');
        Route::get('/data-kategori', [CategoryController::class, 'getKategori'])->name('admin.kategori.data');
        Route::delete('/kategori/{id}', [CategoryController::class, 'destroy'])->name('admin.kategori.destroy');
        Route::get('/kategori/{id}/fetch', [CategoryController::class, 'fetchKategoriById'])->name('kategori.fetch');
        Route::put('/kategori/{id}/update', [CategoryController::class, 'update'])->name('kategori.update');
    });

    // Tags
    Route::middleware(['permission:edit_tags'])->prefix('blog')->group(function () {
        Route::get('/tags', [TagController::class, 'index'])->name('tags.all');
        Route::get('/tag/{slug}', [TagController::class, 'showPostsByTag'])->name('tags.show');
        Route::get('/data-tags', [TagController::class, 'getTags'])->name('admin.tags.data');
        Route::post('/tags/create', [TagController::class, 'simpanTags'])->name('tags.create');
        Route::post('/tags', [TagController::class, 'store'])->name('tags.store');
        Route::get('/tags/{tag}/edit', [TagController::class, 'edit'])->name('tags.edit');
        Route::put('/tags/{tag}', [TagController::class, 'update'])->name('tags.update');
        Route::delete('/tags/{id}', [TagController::class, 'destroy'])->name('tags.destroy');
        Route::post('/tags/delete-selected', [TagController::class, 'deleteSelectedTags'])->name('tags.delete.selected');
    });


    // Kutipan
    Route::middleware(['permission:edit_kutipan'])->prefix('blog')->group(function () {
        Route::get('/kutipan', [QuoteController::class, 'index'])->name('blog.kutipan');
        Route::get('/kutipan/data', [QuoteController::class, 'getQuote'])->name('admin.kutipan.data');
        Route::post('/kutipan/simpan', [QuoteController::class, 'simpanQuote'])->name('kutipan.tambah');
        Route::delete('/kutipan/{id}', [QuoteController::class, 'destroy'])->name('admin.kutipan.destroy');
        Route::get('/kutipan/{id}/fetch', [QuoteController::class, 'fetchQuoteById'])->name('kutipan.fetch');
        Route::put('/kutipan/{id}/update', [QuoteController::class, 'update'])->name('kutipan.update');
    });

    // Tautan
    Route::middleware(['permission:edit_tautan'])->prefix('blog')->group(function () {
        Route::get('/tautan', [LinkController::class, 'index'])->name('blog.tautan');
        Route::get('/tautan/data', [LinkController::class, 'getTautan'])->name('admin.tautan.data');
        Route::post('/tautan/simpan', [LinkController::class, 'simpanTautan'])->name('tautan.tambah');
        Route::delete('/tautan/{id}', [LinkController::class, 'destroy'])->name('admin.tautan.destroy');
        Route::get('/tautan/{id}/fetch', [LinkController::class, 'fetchTautanById'])->name('tautan.fetch');
        Route::put('/tautan/{id}/update', [LinkController::class, 'update'])->name('tautan.update');
    });

    // Halaman
    Route::middleware(['permission:edit_halaman'])->group(function () {
        Route::prefix('blog')->group(function () {
            // Sambutan KS
            Route::get('/sambutan', [PostController::class, 'editSambutan'])->name('admin.edit.sambutan');
            Route::post('/sambutan', [PostController::class, 'updateSambutan'])->name('sambutan.update');

            // Pages
            Route::prefix('pages')->group(function () {
                Route::get('/', [PostController::class, 'pages'])->name('blog.pages');
                Route::get('/data', [PostController::class, 'getPages'])->name('admin.pages.data');
                Route::get('/create', [PostController::class, 'create_pages'])->name('admin.pages.create');
                Route::post('/simpan', [PostController::class, 'pages_store'])->name('pages.store');
                Route::get('/{id}/content', [PostController::class, 'getPostContent'])->name('admin.pages.content');
                Route::get('/create/{id}', [PostController::class, 'editPages'])->name('pages.edit');
                Route::put('/update/{id}', [PostController::class, 'updatePages'])->name('pages.update');
                Route::delete('/{id}', [PostController::class, 'destroy'])->name('admin.pages.destroy');
                Route::delete('/delete-selected', [PostController::class, 'deleteSelected'])->name('admin.pages.deleteSelected');
                Route::get('/{id}/published_at', [PostController::class, 'getPublishedAt'])->name('blog.pages.published_at');
                Route::post('/update-published/{id}', [PostController::class, 'updatePublishedAt'])->name('admin.pages.updatePublished');
            });

            // Tambahan untuk Sambutan KS
            Route::get('/sambutan', [PostController::class, 'editSambutan'])->name('admin.edit.sambutan');
            Route::post('/sambutan', [PostController::class, 'updateSambutan'])->name('sambutan.update');
        });
    });


    // Hubungi Kami
    Route::middleware(['permission:edit_hubungi'])->group(function () {
        Route::prefix('contact')->group(function () {
            Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
            Route::get('/admin/messages/{id}', [MessageController::class, 'show'])->name('messages.show');
            Route::get('/messages/data', [MessageController::class, 'getData'])->name('messages.data');
            Route::post('/admin/messages/{id}/reply', [MessageController::class, 'storeReply'])->name('messages.reply');
        });
    });

    Route::middleware(['permission:edit_pengaturan'])->prefix('settings')->group(function () {
        // Pengaturan
        Route::get('/general', [SettingController::class, 'settingUmum'])->name('settings.general');
        Route::get('/school_profile', [SettingController::class, 'settingProfileSekolah'])->name('settings.profile.sekolah');
        Route::get('/reading', [SettingController::class, 'settingMembaca'])->name('settings.reading');
        Route::get('/writing', [SettingController::class, 'settingMenulis'])->name('settings.writing');
        Route::get('/media', [SettingController::class, 'settingMedia'])->name('settings.media');
        Route::get('/medsos', [SettingController::class, 'settingMedsos'])->name('settings.medsos');
        Route::get('/discussion', [SettingController::class, 'settingDiskusi'])->name('settings.discussion');
        Route::get('/{id}/edit', [SettingController::class, 'edit'])->name('settings.general.edit');
        Route::post('/{id}', [SettingController::class, 'update'])->name('settings.general.update');
        Route::post('/upload/foto/{id}', [SettingController::class, 'upload'])->name('upload.foto');
    });

    // GTK
    Route::middleware(['permission:edit_gtk'])->prefix('gtk')->group(function () {
        Route::get('/all', [GtkController::class, 'index'])->name('gtk.all');
        Route::get('/data', [GtkController::class, 'getGtk'])->name('gtk.data');
        Route::delete('/{id}', [GtkController::class, 'destroy'])->name('gtk.destroy');
        Route::post('/delete-selected', [GtkController::class, 'deleteSelectedTags'])->name('gtk.delete.selected');
        Route::post('/create', [GtkController::class, 'store'])->name('gtk.store');
        Route::get('/{id}/fetch', [GtkController::class, 'fetchGtkById'])->name('gtk.fetch');
        Route::put('/{id}/update', [GtkController::class, 'update'])->name('gtk.update');
    });

    // Media - FILE
    Route::middleware(['permission:edit_file'])->prefix('files')->group(function () {
        Route::get('/all', [FilesController::class, 'index'])->name('files.all');
        Route::get('/data', [FilesController::class, 'getFiles'])->name('files.data');
        Route::post('/create', [FilesController::class, 'store'])->name('files.store');
        Route::delete('/{id}', [FilesController::class, 'destroy'])->name('files.destroy');
        Route::post('/delete-selected', [FilesController::class, 'deleteSelectedFiles'])->name('files.delete.selected');
        Route::get('/{id}/fetch', [FilesController::class, 'fetchFilesById'])->name('files.fetch');
        Route::put('/{id}/update', [FilesController::class, 'update'])->name('files.update');
    });

    // Media - VIDEO
    Route::middleware(['permission:edit_video'])->prefix('videos')->group(function () {
        Route::get('/', [VideoController::class, 'index'])->name('videos.all');
        Route::get('data', [VideoController::class, 'getVideoPosts'])->name('files.videos.data');
        Route::post('/create', [VideoController::class, 'videos_store'])->name('videos.store');
        Route::delete('/{id}', [VideoController::class, 'destroy'])->name('videos.destroy');
        Route::post('/delete-selected', [VideoController::class, 'deleteSelectedVideos'])->name('videos.delete.selected');
        Route::get('/{id}/fetch', [VideoController::class, 'fetchVideosById'])->name('videos.fetch');
        Route::put('/{id}/update', [VideoController::class, 'update'])->name('videos.update');
    });

    // TAMPILAN - Menu
    Route::middleware(['permission:edit_menu'])->prefix('menu')->group(function () {
        Route::get('/', [MenuController::class, 'aturMenu'])->name('menus.all');
        Route::get('/data', [MenuController::class, 'getMenu'])->name('menus.data');
        Route::post('/create', [MenuController::class, 'store'])->name('menus.store');
        Route::get('/{id}/fetch', [MenuController::class, 'fetchMenuById'])->name('menus.fetch');
        Route::put('/{id}/update', [MenuController::class, 'update'])->name('menus.update');
        Route::delete('/{id}', [MenuController::class, 'destroy'])->name('menus.destroy');
        Route::post('/delete-selected', [MenuController::class, 'deleteSelectedMenus'])->name('menus.delete.selected');
        Route::get('/post-pages', [MenuController::class, 'getPublishedPages']);
        Route::post('s/store-from-checkbox', [MenuController::class, 'storeFromCheckbox'])->name('menus.storeFromCheckbox');
        Route::post('s/update-order', [MenuController::class, 'updateOrder'])->name('menus.updateOrder');
    });

    // AKADEMIK - ROMBONGAN BELAJAR
    Route::middleware(['permission:edit_rombel'])->prefix('academic/rombels')->group(function () {
        Route::get('/all', [RombelController::class, 'index'])->name('rombels.index');
        Route::get('/filter', [RombelController::class, 'filter'])->name('rombels.filter');
        Route::get('/create', [RombelController::class, 'daftarRombel'])->name('rombels.create');
        Route::get('/data', [RombelController::class, 'getDaftarRombel'])->name('rombels.data');
        Route::post('/create', [RombelController::class, 'store'])->name('rombongan_belajar.store');
        Route::delete('/{id}', [RombelController::class, 'destroy'])->name('rombels.destroy');
        Route::post('/delete-selected', [RombelController::class, 'deleteSelectedRombels'])->name('rombels.delete.selected');
        Route::get('/{id}/fetch', [RombelController::class, 'fetchRombelsById'])->name('rombels.fetch');
        Route::put('/{id}/update', [RombelController::class, 'update'])->name('rombels.update');

        Route::get('/members', [RombelController::class, 'anggotaRombel'])->name('rombels.members');
        Route::get('/students/data', [RombelController::class, 'getStudents'])->name('rombels.students.data');
        Route::get('/anggota/data', [RombelController::class, 'getFilteredStudents'])->name('rombels.anggota.data');
        Route::get('/rombel-id', [RombelController::class, 'getRombelId']);

        Route::post('/anggota-rombel/store', [AnggotaRombelController::class, 'store']);
        Route::post('/anggota-rombel/destroy', [AnggotaRombelController::class, 'destroy']);
        Route::post('/anggota/store', [AnggotaRombelController::class, 'store'])->name('anggota.store');
        Route::post('/anggota/delete-selected', [AnggotaRombelController::class, 'deleteSelected']);
    });

    // PESERTA DIDIK AKTIF
    Route::middleware(['permission:edit_pd'])->prefix('academic/students')->group(function () {
        Route::get('/all', [StudentController::class, 'index'])->name('students.all');
        Route::get('/data', [StudentController::class, 'getStudents'])->name('students.data');
        Route::post('/create', [StudentController::class, 'store'])->name('students.store');
        Route::delete('/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
        Route::post('/delete-selected', [StudentController::class, 'deleteSelectedStudents'])->name('students.delete.selected');
        Route::get('/{id}/fetch', [StudentController::class, 'fetchStudentsById'])->name('students.fetch');
        Route::put('/{id}/update', [StudentController::class, 'update'])->name('students.update');

        // PESERTA DIDIK NON AKTIF / ALUMNI
        Route::get('/non-active', [StudentController::class, 'studentsNonActive'])->name('students.non.active');
        Route::get('/data/non-active', [StudentController::class, 'getStudentsNonActive'])->name('students.data.non.active');
        Route::post('/mark-as-alumni', [StudentController::class, 'markAsAlumni'])->name('students.markAsAlumni');
        Route::post('/restore-as-student', [StudentController::class, 'restoreAlumni'])->name('students.restoreAlumni');
    });

    // AKADEMIK - TAHUN PELAJARAN
    Route::middleware(['permission:edit_tahun_pelajaran'])->prefix('academic/academic_years')->group(function () {
        Route::get('/all', [AcademicYearsController::class, 'index'])->name('academic.years.index');
        Route::get('/data', [AcademicYearsController::class, 'getAcademicYears'])->name('academic.years.data');
        Route::delete('/{id}', [AcademicYearsController::class, 'destroy'])->name('academic.years.destroy');
        Route::post('/delete-selected', [AcademicYearsController::class, 'deleteSelectedAcademicYears'])->name('academic.years.delete.selected');
        Route::post('/create', [AcademicYearsController::class, 'store'])->name('academic.years.store');
        Route::get('/{id}/fetch', [AcademicYearsController::class, 'fetchAcademicYearsById'])->name('academic.years.fetch');
        Route::put('/{id}/update', [AcademicYearsController::class, 'update'])->name('academic.years.update');
    });

    // AKADEMIK - KELAS
    Route::middleware(['permission:edit_kelas'])->prefix('academic/classrooms')->group(function () {
        Route::get('/', [ClassroomController::class, 'index'])->name('classrooms.all');
        Route::get('/data', [ClassroomController::class, 'getClassrooms'])->name('classrooms.data');
        Route::post('/create', [ClassroomController::class, 'store'])->name('classrooms.store');
        Route::delete('/{id}', [ClassroomController::class, 'destroy'])->name('classrooms.destroy');
        Route::post('/delete-selected', [ClassroomController::class, 'deleteSelectedClassrooms'])->name('classrooms.delete.selected');
        Route::get('/{id}/fetch', [ClassroomController::class, 'fetchClassromsById'])->name('classrooms.fetch');
        Route::put('/{id}/update', [ClassroomController::class, 'update'])->name('classrooms.update');
    });


    Route::middleware(['permission:edit_profile'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::middleware(['permission:edit_hak_akses'])->group(function () {
        Route::get('/privilege', [RoleController::class, 'edit'])->name('roles.edit');
        Route::post('roles/update-permissions', [RoleController::class, 'updatePermissions'])->name('roles.updatePermissions');
        Route::get('/get-user-permissions/{userId}', [RoleController::class, 'getUserPermissions']);
    });
});






require __DIR__ . '/auth.php';
