<?php

namespace App\Http\Controllers\Backend;

use App\Models\Theme;

use Illuminate\View\View;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Services\Backend\Tampilan\ThemeService;
use App\Http\Requests\Backend\Tampilan\Tema\StoreThemeRequest;
use App\Http\Requests\Backend\Tampilan\Tema\UpdateThemeRequest;
use App\Services\Backend\Tampilan\ThemeUploadService;

class ThemeController extends Controller
{
    protected $themeservice;
    protected $themeuploadservice;


    public function __construct(ThemeService $themeservice, ThemeUploadService $themeuploadservice)
    {
        $this->themeservice = $themeservice;
        $this->themeuploadservice = $themeuploadservice;
    }


    public function index(): View
    {
        $themes = $this->themeservice->all();
        $data = [
            'judul' => "All Themes",
            'tema' => $themes
        ];
        return view('admin.tampilan.tema', $data);
    }

    public function getTemas(Request $request)
    {
        if ($request->ajax()) {
            $tema = $this->themeservice->getTemasForDatatables();

            return DataTables::of($tema)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '';

                    // Tampilkan tombol "Aktifkan" hanya jika belum aktif
                    if (!$row->is_active) {
                        $btn .= '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-success btn-xs activate-btn"><i class="fas fa-check"></i> Aktifkan</a> ';
                    }

                    // Tambahkan tombol hapus
                    $btn .= '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-xs delete-btn"><i class="fas fa-trash-alt"></i> Hapus</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }


    public function create(): View
    {
        return view('backend.tampilan.theme.create');
    }

    public function store(StoreThemeRequest $request, ThemeUploadService $uploadService)
    {
        try {
            // Jalankan upload dan ekstraksi, hasilnya array data tema
            $themeData = $uploadService->uploadAndExtract($request);

            // Simpan ke database
            $theme = Theme::create($themeData);

            return response()->json([
                'message' => 'Tema berhasil diunggah dan disimpan.',
                'data' => $theme
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengunggah tema: ' . $e->getMessage()
            ], 500);
        }
    }



    public function activate(Theme $theme, Request $request)
    {
        $this->themeservice->setActive($theme);

        if ($request->ajax()) {
            return response()->json(['message' => 'Tema berhasil diaktifkan']);
        }

        return redirect()->route('admin.tema.index')->with('success', 'Tema berhasil diaktifkan.');
    }

    public function destroy(Theme $theme, Request $request)
    {
        try {
            $this->themeservice->delete($theme);

            if ($request->ajax()) {
                return response()->json(['message' => 'Tema berhasil dihapus']);
            }

            return redirect()->route('admin.tema.index')->with('success', 'Tema berhasil dihapus.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 400);
            }

            return redirect()->route('admin.tema.index')->with('error', $e->getMessage());
        }
    }
}
