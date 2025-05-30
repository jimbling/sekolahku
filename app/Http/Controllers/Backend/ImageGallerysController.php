<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\ImageGallery;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Services\Backend\Media\AlbumService;
use App\Services\Backend\Media\ImageService;
use App\Http\Requests\Backend\Media\AlbumStoreRequest;

use App\Http\Requests\Backend\Media\ImageStoreRequest;
use App\Http\Requests\Backend\Media\AlbumUpdateRequest;

class ImageGallerysController extends Controller
{
    protected $albumService;
    protected $imageService;

    public function __construct(AlbumService $albumService, ImageService $imageService)
    {
        $this->albumService = $albumService;
        $this->imageService = $imageService;
    }

    public function index()
    {
        $albums = $this->albumService->getAllAlbums();
        $data = [
            'judul' => "Galeri Foto",
            'foto' => $albums,
        ];

        return view('admin.media.all_photos', $data);
    }

    public function getAlbums(Request $request)
    {
        if ($request->ajax()) {
            $albums = $this->albumService->getAlbumsForDatatables();

            return DataTables::of($albums)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                    <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-primary btn-xs edit-btn mt-1"><i class="fas fa-edit"></i> Edit</a>
                    <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-xs delete-btn mt-1"><i class="fas fa-trash-alt"></i> Hapus</a>
                    <a href="' . route('albums.upload', $row->id) . '" class="btn btn-success btn-xs mt-1"><i class="fas fa-plus "></i> Tambah Foto</a>
                    <a href="' . route('albums.foto', $row->id) . '" class="btn btn-warning btn-xs mt-1"><i class="far fa-images"></i> Atur Foto</a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function albums_store(AlbumStoreRequest $request)
    {
        $this->albumService->storeAlbum($request->all());

        return response()->json([
            'success' => 'Data album baru berhasil ditambahkan!',
            'redirect' => route('photos.all')
        ]);
    }

    public function fetchAlbumsById($id)
    {
        $album = Album::findOrFail($id);
        return response()->json($album);
    }

    public function update(AlbumUpdateRequest $request, $id)
    {
        $album = Album::findOrFail($id);
        $this->albumService->updateAlbum($album, $request->all());

        return response()->json(['message' => 'Data Album berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        $album = Album::findOrFail($id);
        $this->albumService->deleteAlbum($album);

        return response()->json([
            'type' => 'success',
            'message' => 'Data Album dan foto-foto terkait berhasil dihapus.'
        ]);
    }

    public function deleteSelectedAlbums(Request $request)
    {
        if ($request->ajax()) {
            $ids = $request->ids;

            if (!empty($ids)) {
                $this->albumService->deleteMultipleAlbums($ids);

                return response()->json([
                    'type' => 'success',
                    'message' => 'Data album dan foto-foto terkait berhasil dihapus.'
                ]);
            }

            return response()->json([
                'type' => 'error',
                'message' => 'Tidak ada data album yang dipilih untuk dihapus.'
            ], 422);
        }
    }

    public function showUploadForm($id)
    {
        $album = Album::findOrFail($id);
        $data = [
            'judul' => "Unggah Foto"
        ];
        return view('admin.media.albums_upload', $data, compact('album'));
    }

    public function storeImage(ImageStoreRequest $request, $id)
    {
        $this->imageService->storeImages(
            $id,
            $request->file('files', []),
            $request->only(['caption', 'alt_text', 'order'])
        );

        return response()->json(['success' => 'Gambar berhasil diupload.']);
    }

    public function aturFoto($id)
    {
        $album = Album::findOrFail($id);
        $data = [
            'judul' => "Atur Foto"
        ];
        $images = $album->images()->get();

        return view('admin.media.atur_foto', $data, compact('album', 'images'));
    }

    public function hapusFoto($id)
    {
        $image = ImageGallery::findOrFail($id);
        $this->imageService->deleteImage($image);

        return redirect()->back()->with('success', 'Gambar berhasil dihapus.');
    }
}
