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

use App\Http\Middleware\CheckMaintenanceMode;
use App\Http\Controllers\Frontend\DirektoriController;
use App\Http\Controllers\Frontend\MediaController;

use App\Models\Classroom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Medium;




// Grup rute yang memerlukan middleware CheckMaintenanceMode
Route::middleware([CheckMaintenanceMode::class])->group(function () {
    // Rute-rute yang memerlukan pemeliharaan situs
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

Route::get('/perawatan', function () {
    return view('maintenance'); // Ganti dengan nama view atau logika pemeliharaan Anda
})->name('maintenance');

// Rute-rute yang tidak memerlukan pemeliharaan situs atau autentikasi
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {

    Route::post('/image/upload', [ImageController::class, 'upload'])->name('image.upload');
    // Post
    Route::get('/blog/posts', [PostController::class, 'index'])->name('blog.posts');
    Route::get('admin/posts/data', [PostController::class, 'getPosts'])->name('admin.posts.data');
    Route::get('/blog/posts/create', [PostController::class, 'create'])->name('admin.posts.create');
    Route::post('/tulisan/simpan', [PostController::class, 'store'])->name('posts.store');
    Route::delete('/blog/posts/{id}', [PostController::class, 'destroy'])->name('admin.posts.destroy');
    Route::delete('/admin/posts/delete-selected', [PostController::class, 'deleteSelected'])->name('admin.posts.deleteSelected');
    Route::post('/blog/posts/update-published/{id}', [PostController::class, 'updatePublishedAt'])
        ->name('admin.posts.updatePublished');
    Route::get('/blog/posts/{id}/content', [PostController::class, 'getPostContent'])
        ->name('admin.posts.content');
    Route::get('/blog/posts/{id}/published_at', [PostController::class, 'getPublishedAt'])->name('blog.posts.published_at');
    Route::get('/blog/posts/create/{id}', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/blog/posts/update/{id}', [PostController::class, 'update'])->name('posts.update');

    // Kategori
    Route::post('/new_posts/kategori/simpan', [CategoryController::class, 'simpanNewPosts'])->name('kategori.simpan');
    Route::post('/tambah/kategori/simpan', [CategoryController::class, 'simpanKategori'])->name('kategori.tambah');
    Route::get('/blog/posts/post_categories', [CategoryController::class, 'index'])->name('blog.kategori');
    Route::get('/data-kategori', [CategoryController::class, 'getKategori'])->name('admin.kategori.data');
    Route::delete('/kategori/{id}', [CategoryController::class, 'destroy'])->name('admin.kategori.destroy');
    // Route::get('/kategoris/data', [CategoryController::class, 'getKategori'])->name('kategori.data');
    Route::get('/kategori/{id}/fetch', [CategoryController::class, 'fetchKategoriById'])->name('kategori.fetch');
    Route::put('/kategori/{id}/update', [CategoryController::class, 'update'])->name('kategori.update');

    // Tags
    Route::get('/blog/tags', [TagController::class, 'index'])->name('tags.all');
    Route::get('/tag/{slug}', [TagController::class, 'showPostsByTag'])->name('tags.show');
    Route::get('/data-tags', [TagController::class, 'getTags'])->name('tags.data');
    Route::post('/tags/create', [TagController::class, 'simpanTags'])->name('tags.create');
    Route::post('/tags', [TagController::class, 'store'])->name('tags.store');
    Route::get('/tags/{tag}/edit', [TagController::class, 'edit'])->name('tags.edit');
    Route::put('/tags/{tag}', [TagController::class, 'update'])->name('tags.update');
    Route::delete('/tags/{id}', [TagController::class, 'destroy'])->name('tags.destroy');
    Route::post('/tags/delete-selected', [TagController::class, 'deleteSelectedTags'])->name('tags.delete.selected');

    // Sambutan KS
    Route::get('/blog/sambutan', [PostController::class, 'editSambutan'])->name('admin.edit.sambutan');
    Route::post('/blog/sambutan', [PostController::class, 'updateSambutan'])->name('sambutan.update');

    // Kutipan
    Route::get('/blog/kutipan', [QuoteController::class, 'index'])->name('blog.kutipan');
    Route::get('/kutipan/data', [QuoteController::class, 'getQuote'])->name('admin.kutipan.data');
    Route::post('/kutipan/simpan', [QuoteController::class, 'simpanQuote'])->name('kutipan.tambah');
    Route::delete('/kutipan/{id}', [QuoteController::class, 'destroy'])->name('admin.kutipan.destroy');
    Route::get('/kutipan/{id}/fetch', [QuoteController::class, 'fetchQuoteById'])->name('kutipan.fetch');
    Route::put('/kutipan/{id}/update', [QuoteController::class, 'update'])->name('kutipan.update');

    // Tautan
    Route::get('/blog/tautan', [LinkController::class, 'index'])->name('blog.tautan');
    Route::get('/tautan/data', [LinkController::class, 'getTautan'])->name('admin.tautan.data');
    Route::post('/tautan/simpan', [LinkController::class, 'simpanTautan'])->name('tautan.tambah');
    Route::delete('/tautan/{id}', [LinkController::class, 'destroy'])->name('admin.tautan.destroy');
    Route::get('/tautan/{id}/fetch', [LinkController::class, 'fetchTautanById'])->name('tautan.fetch');
    Route::put('/tautan/{id}/update', [LinkController::class, 'update'])->name('tautan.update');

    // Halaman
    Route::get('/blog/pages', [PostController::class, 'pages'])->name('blog.pages');
    Route::get('admin/pages/data', [PostController::class, 'getPages'])->name('admin.pages.data');
    Route::get('/blog/pages/create', [PostController::class, 'create_pages'])->name('admin.pages.create');
    Route::post('/pages/simpan', [PostController::class, 'pages_store'])->name('pages.store');
    Route::get('/blog/pages/{id}/content', [PostController::class, 'getPostContent'])
        ->name('admin.pages.content');
    Route::get('/blog/pages/create/{id}', [PostController::class, 'editPages'])->name('pages.edit');
    Route::put('/blog/pages/update/{id}', [PostController::class, 'updatePages'])->name('pages.update');
    Route::delete('/blog/pages/{id}', [PostController::class, 'destroy'])->name('admin.pages.destroy');
    Route::delete('/admin/pages/delete-selected', [PostController::class, 'deleteSelected'])->name('admin.pages.deleteSelected');
    Route::get('/blog/pages/{id}/published_at', [PostController::class, 'getPublishedAt'])->name('blog.pages.published_at');
    Route::post('/blog/pages/update-published/{id}', [PostController::class, 'updatePublishedAt'])
        ->name('admin.pages.updatePublished');

    // Hubungi Kami

    Route::get('/blog/pesan', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/admin/pesan/{id}', [MessageController::class, 'show'])->name('messages.show');
    Route::get('/pesan/data', [MessageController::class, 'getData'])->name('messages.data');
    Route::post('/admin/pesan/{id}/reply', [MessageController::class, 'storeReply'])->name('messages.reply');

    // Pengaturan
    Route::get('/settings/general', [SettingController::class, 'settingUmum'])->name('settings.general');
    Route::get('/settings/school_profile', [SettingController::class, 'settingProfileSekolah'])->name('settings.profile.sekolah');
    Route::get('/settings/reading', [SettingController::class, 'settingMembaca'])->name('settings.reading');
    Route::get('/settings/writing', [SettingController::class, 'settingMenulis'])->name('settings.writing');
    Route::get('/settings/media', [SettingController::class, 'settingMedia'])->name('settings.media');
    Route::get('/settings/medsos', [SettingController::class, 'settingMedsos'])->name('settings.medsos');
    Route::get('/settings/discussion', [SettingController::class, 'settingDiskusi'])->name('settings.discussion');
    Route::get('/settings/{id}/edit', [SettingController::class, 'edit'])->name('settings.general.edit');
    Route::post('/settings/{id}', [SettingController::class, 'update'])->name('settings.general.update');
    Route::post('/upload/foto/{id}', [SettingController::class, 'upload'])->name('upload.foto');

    // GTK
    Route::get('/gtk/all', [GtkController::class, 'index'])->name('gtk.all');
    Route::get('/gtk/data', [GtkController::class, 'getGtk'])->name('gtk.data');
    Route::delete('/gtk/{id}', [GtkController::class, 'destroy'])->name('gtk.destroy');
    Route::post('/gtk/delete-selected', [GtkController::class, 'deleteSelectedTags'])->name('gtk.delete.selected');
    Route::post('/gtk/create', [GtkController::class, 'store'])->name('gtk.store');
    Route::get('/gtk/{id}/fetch', [GtkController::class, 'fetchGtkById'])->name('gtk.fetch');
    Route::put('/gtk/{id}/update', [GtkController::class, 'update'])->name('gtk.update');

    // Media - FILE
    Route::get('/files/all', [FilesController::class, 'index'])->name('files.all');
    Route::get('/files/data', [FilesController::class, 'getFiles'])->name('files.data');
    Route::post('/files/create', [FilesController::class, 'store'])->name('files.store');
    Route::delete('/files/{id}', [FilesController::class, 'destroy'])->name('files.destroy');
    Route::post('/files/delete-selected', [FilesController::class, 'deleteSelectedFiles'])->name('files.delete.selected');
    Route::get('/files/{id}/fetch', [FilesController::class, 'fetchFilesById'])->name('files.fetch');
    Route::put('/files/{id}/update', [FilesController::class, 'update'])->name('files.update');

    // Media - VIDEO
    Route::get('/files/videos', [VideoController::class, 'index'])->name('videos.all');
    Route::get('/files/videos/data', [VideoController::class, 'getVideoPosts'])->name('files.videos.data');
    Route::post('/videos/create', [VideoController::class, 'videos_store'])->name('videos.store');
    Route::delete('/videos/{id}', [VideoController::class, 'destroy'])->name('videos.destroy');
    Route::post('/videos/delete-selected', [VideoController::class, 'deleteSelectedVideos'])->name('videos.delete.selected');
    Route::get('/videos/{id}/fetch', [VideoController::class, 'fetchVideosById'])->name('videos.fetch');
    Route::put('/videos/{id}/update', [VideoController::class, 'update'])->name('videos.update');


    // TAMPILAN - Menu
    Route::get('/tampilan/menu', [MenuController::class, 'aturMenu'])->name('menus.all');
    Route::get('/menu/data', [MenuController::class, 'getMenu'])->name('menus.data');
    Route::post('/menu/create', [MenuController::class, 'store'])->name('menus.store');
    Route::get('/menu/{id}/fetch', [MenuController::class, 'fetchMenuById'])->name('menus.fetch');
    Route::put('/menu/{id}/update', [MenuController::class, 'update'])->name('menus.update');
    Route::delete('/menu/{id}', [MenuController::class, 'destroy'])->name('menus.destroy');
    Route::post('/menu/delete-selected', [MenuController::class, 'deleteSelectedMenus'])->name('menus.delete.selected');
    Route::get('/post-pages', [MenuController::class, 'getPublishedPages']);
    Route::post('/menus/store-from-checkbox', [MenuController::class, 'storeFromCheckbox'])->name('menus.storeFromCheckbox');
    Route::post('/menus/update-order', [MenuController::class, 'updateOrder'])->name('menus.updateOrder');


    // ROMBEL

    Route::get('/academic/rombels/all', [RombelController::class, 'index'])->name('rombels.index');
    Route::get('/academic/rombels/filter', [RombelController::class, 'filter'])->name('rombels.filter');
    Route::get('/academic/rombels/create', [RombelController::class, 'daftarRombel'])->name('rombels.create');
    Route::get('/academic/rombels/data', [RombelController::class, 'getDaftarRombel'])->name('rombels.data');
    Route::post('/academic/rombels/create', [RombelController::class, 'store'])->name('rombongan_belajar.store');
    Route::delete('/academic/rombels/{id}', [RombelController::class, 'destroy'])->name('rombels.destroy');
    Route::post('/academic/rombels/delete-selected', [RombelController::class, 'deleteSelectedRombels'])->name('rombels.delete.selected');
    Route::get('/rombels/{id}/fetch', [RombelController::class, 'fetchRombelsById'])->name('rombels.fetch');
    Route::put('/rombels/{id}/update', [RombelController::class, 'update'])->name('rombels.update');

    Route::get('/academic/rombels/members', [RombelController::class, 'anggotaRombel'])->name('rombels.members');
    Route::get('rombels/students/data', [RombelController::class, 'getStudents'])->name('rombels.students.data');
    Route::get('rombels/anggota/data', [RombelController::class, 'getFilteredStudents'])->name('rombels.anggota.data');
    Route::get('/rombels/rombel-id', [RombelController::class, 'getRombelId']);


    Route::post('/anggota-rombel/store', [AnggotaRombelController::class, 'store']);
    Route::post('/anggota-rombel/destroy', [AnggotaRombelController::class, 'destroy']);
    Route::post('/rombels/anggota/store', [AnggotaRombelController::class, 'store'])->name('anggota.store');
    Route::post('/anggota/delete-selected', [AnggotaRombelController::class, 'deleteSelected']);


    // PESERTA DIDIK AKTIF
    Route::get('/academic/students/all', [StudentController::class, 'index'])->name('students.all');
    Route::get('/students/data', [StudentController::class, 'getStudents'])->name('students.data');
    Route::post('/students/create', [StudentController::class, 'store'])->name('students.store');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
    Route::post('/students/delete-selected', [StudentController::class, 'deleteSelectedStudents'])->name('students.delete.selected');
    Route::get('/students/{id}/fetch', [StudentController::class, 'fetchStudentsById'])->name('students.fetch');
    Route::put('/students/{id}/update', [StudentController::class, 'update'])->name('students.update');



    // PESERTA DIDIK NON AKTIF / ALUMNI
    Route::get('/academic/students/non-active', [StudentController::class, 'studentsNonActive'])->name('students.non.active');
    Route::get('/students/data/non-active', [StudentController::class, 'getStudentsNonActive'])->name('students.data.non.active');
    Route::post('/students/mark-as-alumni', [StudentController::class, 'markAsAlumni'])->name('students.markAsAlumni');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
    Route::post('/students/restore-as-student', [StudentController::class, 'restoreAlumni'])->name('students.restoreAlumni');


    // TAHUN PELAJARAN
    Route::get('/academic/academic_years/all', [AcademicYearsController::class, 'index'])->name('academic.years.index');
    Route::get('/academic/academic_years/data', [AcademicYearsController::class, 'getAcademicYears'])->name('academic.years.data');
    Route::delete('/academic/academic_years/{id}', [AcademicYearsController::class, 'destroy'])->name('academic.years.destroy');
    Route::post('/academic/academic_years/delete-selected', [AcademicYearsController::class, 'deleteSelectedAcademicYears'])->name('academic.years.delete.selected');
    Route::post('/academic/academic_years/create', [AcademicYearsController::class, 'store'])->name('academic.years.store');
    Route::get('/academic/academic_years/{id}/fetch', [AcademicYearsController::class, 'fetchAcademicYearsById'])->name('academic.years.fetch');
    Route::put('/academic/academic_years/{id}/update', [AcademicYearsController::class, 'update'])->name('academic.years.update');


    // KELAS
    Route::get('/academic/classrooms', [ClassroomController::class, 'index'])->name('classrooms.all');
    Route::get('/classrooms/data', [ClassroomController::class, 'getClassrooms'])->name('classrooms.data');
    Route::post('/classrooms/create', [ClassroomController::class, 'store'])->name('classrooms.store');
    Route::delete('/classrooms/{id}', [ClassroomController::class, 'destroy'])->name('classrooms.destroy');
    Route::post('/classrooms/delete-selected', [ClassroomController::class, 'deleteSelectedClassrooms'])->name('classrooms.delete.selected');
    Route::get('/classrooms/{id}/fetch', [ClassroomController::class, 'fetchClassromsById'])->name('classrooms.fetch');
    Route::put('/classrooms/{id}/update', [ClassroomController::class, 'update'])->name('classrooms.update');




    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'verified', 'role:writer'])->group(function () {
    Route::post('/image/upload', [ImageController::class, 'upload'])->name('image.upload');
    // Post
    Route::get('/blog/posts', [PostController::class, 'index'])->name('blog.posts');
    Route::get('admin/posts/data', [PostController::class, 'getPosts'])->name('admin.posts.data');
    Route::get('/blog/posts/create', [PostController::class, 'create'])->name('admin.posts.create');
    Route::post('/tulisan/simpan', [PostController::class, 'store'])->name('posts.store');
    Route::delete('/blog/posts/{id}', [PostController::class, 'destroy'])->name('admin.posts.destroy');
    Route::delete('/admin/posts/delete-selected', [PostController::class, 'deleteSelected'])->name('admin.posts.deleteSelected');
    Route::post('/blog/posts/update-published/{id}', [PostController::class, 'updatePublishedAt'])
        ->name('admin.posts.updatePublished');
    Route::get('/blog/posts/{id}/content', [PostController::class, 'getPostContent'])
        ->name('admin.posts.content');
    Route::get('/blog/posts/{id}/published_at', [PostController::class, 'getPublishedAt'])->name('blog.posts.published_at');
    Route::get('/blog/posts/create/{id}', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/blog/posts/update/{id}', [PostController::class, 'update'])->name('posts.update');

    // Kategori
    Route::post('/new_posts/kategori/simpan', [CategoryController::class, 'simpanNewPosts'])->name('kategori.simpan');
    Route::post('/tambah/kategori/simpan', [CategoryController::class, 'simpanKategori'])->name('kategori.tambah');
    Route::get('/blog/posts/post_categories', [CategoryController::class, 'index'])->name('blog.kategori');
    Route::get('/data-kategori', [CategoryController::class, 'getKategori'])->name('admin.kategori.data');
    Route::delete('/kategori/{id}', [CategoryController::class, 'destroy'])->name('admin.kategori.destroy');
    // Route::get('/kategoris/data', [CategoryController::class, 'getKategori'])->name('kategori.data');
    Route::get('/kategori/{id}/fetch', [CategoryController::class, 'fetchKategoriById'])->name('kategori.fetch');
    Route::put('/kategori/{id}/update', [CategoryController::class, 'update'])->name('kategori.update');

    // Tags
    Route::get('/blog/tags', [TagController::class, 'index'])->name('tags.all');
    Route::get('/tag/{slug}', [TagController::class, 'showPostsByTag'])->name('tags.show');
    Route::get('/data-tags', [TagController::class, 'getTags'])->name('tags.data');
    Route::post('/tags/create', [TagController::class, 'simpanTags'])->name('tags.create');
    Route::post('/tags', [TagController::class, 'store'])->name('tags.store');
    Route::get('/tags/{tag}/edit', [TagController::class, 'edit'])->name('tags.edit');
    Route::put('/tags/{tag}', [TagController::class, 'update'])->name('tags.update');
    Route::delete('/tags/{id}', [TagController::class, 'destroy'])->name('tags.destroy');
    Route::post('/tags/delete-selected', [TagController::class, 'deleteSelectedTags'])->name('tags.delete.selected');

    // Sambutan KS
    Route::get('/blog/sambutan', [PostController::class, 'editSambutan'])->name('admin.edit.sambutan');
    Route::post('/blog/sambutan', [PostController::class, 'updateSambutan'])->name('sambutan.update');

    // Kutipan
    Route::get('/blog/kutipan', [QuoteController::class, 'index'])->name('blog.kutipan');
    Route::get('/kutipan/data', [QuoteController::class, 'getQuote'])->name('admin.kutipan.data');
    Route::post('/kutipan/simpan', [QuoteController::class, 'simpanQuote'])->name('kutipan.tambah');
    Route::delete('/kutipan/{id}', [QuoteController::class, 'destroy'])->name('admin.kutipan.destroy');
    Route::get('/kutipan/{id}/fetch', [QuoteController::class, 'fetchQuoteById'])->name('kutipan.fetch');
    Route::put('/kutipan/{id}/update', [QuoteController::class, 'update'])->name('kutipan.update');

    // Halaman
    Route::get('/blog/pages', [PostController::class, 'pages'])->name('blog.pages');
    Route::get('admin/pages/data', [PostController::class, 'getPages'])->name('admin.pages.data');
    Route::get('/blog/pages/create', [PostController::class, 'create_pages'])->name('admin.pages.create');
    Route::post('/pages/simpan', [PostController::class, 'pages_store'])->name('pages.store');
    Route::get('/blog/pages/{id}/content', [PostController::class, 'getPostContent'])
        ->name('admin.pages.content');
    Route::get('/blog/pages/create/{id}', [PostController::class, 'editPages'])->name('pages.edit');
    Route::put('/blog/pages/update/{id}', [PostController::class, 'updatePages'])->name('pages.update');
    Route::delete('/blog/pages/{id}', [PostController::class, 'destroy'])->name('admin.pages.destroy');
    Route::delete('/admin/pages/delete-selected', [PostController::class, 'deleteSelected'])->name('admin.pages.deleteSelected');
    Route::get('/blog/pages/{id}/published_at', [PostController::class, 'getPublishedAt'])->name('blog.pages.published_at');
    Route::post('/blog/pages/update-published/{id}', [PostController::class, 'updatePublishedAt'])
        ->name('admin.pages.updatePublished');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__ . '/auth.php';
