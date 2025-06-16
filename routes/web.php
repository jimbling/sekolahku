<?php


use App\Models\Application;
use Illuminate\Http\Request;
use App\Mail\NotifikasiEmail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\UpdateController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SitemapController;
use App\Http\Middleware\CheckMaintenanceMode;
use App\Http\Controllers\Backend\GtkController;
use App\Http\Controllers\Backend\TagController;
use App\Http\Controllers\Backend\UrlController;
use App\Http\Controllers\MailPreviewController;
use App\Http\Controllers\Backend\LinkController;
use App\Http\Controllers\Backend\MenuController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Frontend\ImagesGallery;
use App\Http\Controllers\Backend\FilesController;
use App\Http\Controllers\Backend\ImageController;
use App\Http\Controllers\Backend\PatchController;
use App\Http\Controllers\Backend\QuoteController;



use App\Http\Controllers\Backend\ThemeController;
use App\Http\Controllers\Backend\VideoController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Backend\BackupController;

use App\Http\Controllers\Backend\RombelController;
use App\Http\Controllers\Backend\WidgetController;
use App\Http\Controllers\Frontend\MediaController;
use App\Http\Controllers\Backend\MessageController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\StudentController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ClassroomController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\QuickLinkController;
use App\Http\Controllers\Backend\UrgentInfoController;
use App\Http\Controllers\Frontend\DirektoriController;
use App\Http\Controllers\Frontend\PostinganController;
use App\Http\Controllers\Backend\AnnouncementController;
use App\Http\Controllers\Backend\ImageSlidersController;
use App\Http\Controllers\Backend\SubscriptionController;
use App\Http\Controllers\Backend\AcademicYearsController;
use App\Http\Controllers\Backend\AnggotaRombelController;
use App\Http\Controllers\Backend\ImageGallerysController;
use App\Http\Controllers\Backend\SchoolRegistrationController;



// Rute api untuk Tautan Ringkas, bisa diaktifkan ketika sudah dihosting
// Route::get('/api/urls', [UrlController::class, 'getAllUrls']);
Route::get('/sitemap.xml', [SitemapController::class, 'generateSitemap']);
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
    Route::get('/galeri/foto', [ImagesGallery::class, 'index'])->name('albums.index');
    Route::get('/album/{id}', [ImagesGallery::class, 'show'])->name('albums.show');
    Route::get('/album/{id}/photos', [ImagesGallery::class, 'photos'])->name('albums.photos');
    Route::get('/cari/album', [ImagesGallery::class, 'searchAlbums'])->name('web.cari.albums');

    Route::get('/cari/video', [PostinganController::class, 'searchVideos'])->name('web.cari.videos');
    Route::get('/galeri/video/detail/{id}/{slug}', [PostinganController::class, 'videosDetail'])->name('web.videos.detail');


    // Media
    Route::get('/unduhan', [MediaController::class, 'unduhan'])->name('web.unduhan');
    Route::get('/cari/files', [MediaController::class, 'search'])->name('web.cari.unduhan');
    Route::get('/unduh/{id}', [MediaController::class, 'unduhFile'])->name('unduh.file');

    Route::get('/menu', [HomeController::class, 'menu']);
    Route::post('/kirim-pesan', [MessageController::class, 'store'])->name('messages.store');

    // ALUMNI
    Route::post('/simpan-alumni', [StudentController::class, 'storeAlumni'])->name('alumni.store');

    Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscribe');
    Route::get('/unsubscribe/{token}', [SubscriptionController::class, 'unsubscribe'])->name('unsubscribe');

    Route::get('/komite-sekolah', [HomeController::class, 'komite'])->name('web.komite');
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
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

    // Route::get('/ringkas/url', [UrlController::class, 'index'])->name('home');
    // Route::post('/shorten', [UrlController::class, 'shorten'])->name('shorten.url');
    // Route::get('/url/data', [UrlController::class, 'getUrls'])->name('urls.data');
    // Route::delete('/urls/{id}', [UrlController::class, 'destroy'])->name('urls.destroy');
    // Route::post('/urls/delete-selected', [UrlController::class, 'deleteSelectedUrls'])->name('urls.delete.selected');
    // Route::get('/urls/{id}/fetch', [UrlController::class, 'fetchUrlsById'])->name('urls.fetch');
    // Route::put('/urls/{id}/update', [UrlController::class, 'update'])->name('urls.update');

    Route::get('/disqus-comments', [DashboardController::class, 'disqusComments']);

    // Rute untuk fitur blog
    Route::prefix('blog')->group(function () {
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
            Route::post('/delete_selected', [PostController::class, 'deleteSelected'])->name('admin.posts.deleteSelected');
            Route::post('/update-published/{id}', [PostController::class, 'updatePublishedAt'])->name('admin.posts.updatePublished');
            Route::get('/{id}/content', [PostController::class, 'getPostContent'])->name('admin.posts.content');
            Route::get('/{id}/published_at', [PostController::class, 'getPublishedAt'])->name('blog.posts.published_at');
            Route::DELETE('/remove-image/{id}', [PostController::class, 'removeImage'])->name('removeImage');
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

    // Subscribe
    Route::middleware(['permission:edit_tautan'])->prefix('blog')->group(function () {
        Route::get('/tautan', [LinkController::class, 'index'])->name('blog.tautan');
        Route::get('/tautan/data', [LinkController::class, 'getTautan'])->name('admin.tautan.data');
        Route::post('/tautan/simpan', [LinkController::class, 'simpanTautan'])->name('tautan.tambah');
        Route::delete('/tautan/{id}', [LinkController::class, 'destroy'])->name('admin.tautan.destroy');
        Route::get('/tautan/{id}/fetch', [LinkController::class, 'fetchTautanById'])->name('tautan.fetch');
        Route::put('/tautan/{id}/update', [LinkController::class, 'update'])->name('tautan.update');

        Route::get('/subscribe', [SubscriptionController::class, 'index'])->name('subscribe.index');
        Route::get('/subscribe/data', [SubscriptionController::class, 'getData'])->name('admin.subscribe.data');
    });

    // Komentar
    Route::middleware(['permission:edit_komentar'])->prefix('blog')->group(function () {
        Route::get('/komentar', [CommentController::class, 'index'])->name('blog.comments.index');
        Route::post('/komentar/reply/{comment}', [CommentController::class, 'reply'])->name('blog.komentar.reply');
        Route::put('/komentar/{comment}/approve', [CommentController::class, 'approve'])->name('blog.komentar.approve');
        Route::put('/komentar/{comment}/reject', [CommentController::class, 'reject'])->name('blog.komentar.reject');
        Route::delete('/komentar/{comment}', [CommentController::class, 'destroy'])->name('blog.komentar.destroy');
        Route::post('/komentar/{id}/restore', [CommentController::class, 'restore'])->name('blog.komentar.restore');
    });

    // Gambar Slide
    Route::middleware(['permission:edit_slider'])->prefix('blog/gambar_slide')->group(function () {
        Route::get('/', [ImageSlidersController::class, 'index'])->name('sliders.index');
        Route::get('/data', [ImageSlidersController::class, 'getSlider'])->name('admin.sliders.data');
        Route::post('/simpan', [ImageSlidersController::class, 'simpanSliders'])->name('sliders.tambah');
        Route::delete('/{id}', [ImageSlidersController::class, 'destroy'])->name('admin.sliders.destroy');
        Route::get('/{id}/fetch', [ImageSlidersController::class, 'fetchSliderById'])->name('sliders.fetch');
        Route::put('/{id}/update', [ImageSlidersController::class, 'update'])->name('sliders.update');
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
        Route::post('/delete-selected', [GtkController::class, 'deleteSelectedGtks'])->name('gtk.delete.selected');
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

    // Media - Foto
    Route::middleware(['permission:edit_photo'])->prefix('photos')->group(function () {
        // Album Foto
        Route::get('/', [ImageGallerysController::class, 'index'])->name('photos.all');
        Route::get('/albums/data', [ImageGallerysController::class, 'getAlbums'])->name('albums.data');
        Route::post('/albums/create', [ImageGallerysController::class, 'albums_store'])->name('albums.store');
        Route::delete('/albums/{id}', [ImageGallerysController::class, 'destroy'])->name('albums.destroy');
        Route::post('/albums/delete-selected', [ImageGallerysController::class, 'deleteSelectedAlbums'])->name('albums.delete.selected');
        Route::get('/albums/{id}/fetch', [ImageGallerysController::class, 'fetchAlbumsById'])->name('albums.fetch');
        Route::put('/albums/{id}/update', [ImageGallerysController::class, 'update'])->name('albums.update');
        Route::get('/albums/{id}/upload', [ImageGallerysController::class, 'showUploadForm'])->name('albums.upload');
        Route::post('/albums/{id}/upload', [ImageGallerysController::class, 'storeImage'])->name('albums.upload.store');
        Route::get('/albums/{id}/atur', [ImageGallerysController::class, 'aturFoto'])->name('albums.foto');
        Route::delete('/images/{id}', [ImageGallerysController::class, 'hapusFoto'])->name('images.hapus');
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

    // PENGATURAN TEMA
    Route::prefix('tema')->name('tema.')->middleware(['auth', 'verified', 'permission:edit_tema'])->group(function () {
        Route::get('/', [ThemeController::class, 'index'])->name('index');
        Route::get('/data', [ThemeController::class, 'getTemas'])->name('data');
        Route::post('/{theme}/activate', [ThemeController::class, 'activate'])->name('activate');
        Route::delete('/{theme}', [ThemeController::class, 'destroy'])->name('destroy');
        Route::post('/upload', [ThemeController::class, 'store'])->name('upload.store');
    });

    // PENGATURAN WIDGETS SIDEBAR
    Route::middleware(['auth', 'verified', 'permission:edit_widgets'])->group(function () {
        Route::resource('widgets', WidgetController::class)->only(['index', 'update']);
        Route::put('widgets/update-order', [WidgetController::class, 'updateOrder'])->name('widgets.updateOrder');
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

        // IMPORT PESERTA DIDIK
        Route::post('/preview-import', [StudentController::class, 'previewImport'])->name('student.previewImport');
        Route::post('/import', [StudentController::class, 'import'])->name('student.import');
        Route::match(['get', 'post'], '/import-form', [StudentController::class, 'importForm'])->name('student.importForm');
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

    // PROFILE
    Route::middleware(['permission:edit_profile'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });


    // HAK AKSES
    Route::middleware(['permission:edit_hak_akses'])->group(function () {
        Route::get('/privilege', [RoleController::class, 'edit'])->name('roles.edit');
        Route::post('roles/update-permissions', [RoleController::class, 'updatePermissions'])->name('roles.updatePermissions');
        Route::get('/get-user-permissions/{userId}', [RoleController::class, 'getUserPermissions']);
    });

    // PEMELIHARAAN
    Route::middleware(['permission:edit_pemeliharaan'])->group(function () {
        Route::get('/pemeliharaan', [BackupController::class, 'index'])->name('pemeliharaan.index');
        Route::post('/admin/backup', [BackupController::class, 'createBackup'])->name('admin.backup.create');
        Route::get('/backup-progress', function () {
            $logFile = storage_path('logs/backup_progress.log');
            $content = file_exists($logFile) ? file_get_contents($logFile) : 'No progress yet.';
            return response()->json(['progress' => $content]);
        });

        Route::get('/admin/backups', [BackupController::class, 'listBackups'])->name('admin.backups');
        Route::get('/admin/backups/download/{filename}', [BackupController::class, 'downloadBackup'])->name('admin.backup.download');
        Route::get('/admin/backups/sql', [BackupController::class, 'backupDatabase'])->name('admin.backups.sql');
        Route::delete('/admin/backup/delete/{filename}', [BackupController::class, 'deleteBackup'])->name('admin.backup.delete');
    });

    // PUBLIKASI
    Route::middleware(['auth', 'verified', 'permission:atur_publikasi'])->prefix('publikasi')->name('admin.')->group(function () {
        Route::resource('informasi', UrgentInfoController::class)->except(['show']);
        Route::get('/informasi/data', [UrgentInfoController::class, 'getInformasi'])->name('publikasi.informasi.data');
        Route::get('/informasi/{id}/fetch', [UrgentInfoController::class, 'fetchUrgentInfoById'])->name('publikasi.informasi.fetch');

        Route::resource('pengumuman', AnnouncementController::class)->except(['show']);
        Route::get('/pengumuman/data', [AnnouncementController::class, 'getPengumuman'])->name('publikasi.pengumuman.data');
        Route::get('/pengumuman/{id}/fetch', [AnnouncementController::class, 'fetchAnnouncementById'])->name('publikasi.pengumuman.fetch');

        Route::resource('akses-cepat', QuickLinkController::class)->except(['show']);
        Route::get('/akses-cepat/data', [QuickLinkController::class, 'getAksesCepat'])->name('publikasi.akses.cepat.data');
        Route::get('/akses-cepat/{id}/fetch', [QuickLinkController::class, 'fetchAksesCepatById'])->name('publikasi.akses.cepat.fetch');
    });

    Route::prefix('admin')->middleware(['auth'])->group(function () {
        Route::get('/patch-update', [PatchController::class, 'index'])->name('patch.index');
        Route::post('/patch-upload', [PatchController::class, 'upload'])->name('patch.upload');
    });
    Route::prefix('admin')->middleware(['auth'])->group(function () {
        Route::get('/register-school', [SchoolRegistrationController::class, 'showForm'])->name('school.register');
        Route::post('/register-school/verify', [SchoolRegistrationController::class, 'verifyToken'])->name('school.verify');
        Route::post('/register-school/store', [SchoolRegistrationController::class, 'store'])->name('school.store');
    });
});


Route::get('/admin/clear-cache', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    return redirect()->back()->with('success', 'Cache berhasil dibersihkan!');
})->name('cache.clear')->middleware('auth');

Route::post('/patch/check-update', [PatchController::class, 'checkForUpdate'])
    ->middleware(['auth', 'verified', 'permission:edit_pemeliharaan', 'throttle:5,1'])
    ->name('patch.check');



require __DIR__ . '/auth.php';
