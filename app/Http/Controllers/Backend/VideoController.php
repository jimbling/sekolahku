<?php
// app/Http/Controllers/Backend/VideoController.php
namespace App\Http\Controllers\Backend;

use App\Models\Post;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Services\Backend\Media\VideoService;
use App\Http\Requests\Backend\Media\VideoStoreRequest;
use App\Http\Requests\Backend\Media\VideoUpdateRequest;

class VideoController extends Controller
{
    protected $videoService;

    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }

    public function index()
    {
        $posts = $this->videoService->getAllVideos();

        $data = [
            'judul' => "Galeri Video",
            'posts' => $posts,
        ];

        return view('admin.media.all_video', $data);
    }

    public function getVideoPosts()
    {
        $posts = $this->videoService->getVideosForDatatables()->get();

        return DataTables::of($posts)
            ->addColumn('action', function ($row) {
                return '
                <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-primary btn-xs edit-btn"><i class="fas fa-edit"></i> Edit</a>
                <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-xs delete-btn"><i class="fas fa-trash-alt"></i> Hapus</a>
            ';
            })
            ->editColumn('content', function ($row) {
                return $this->videoService->formatVideoContent($row->content);
            })
            ->rawColumns(['content', 'action'])
            ->make(true);
    }

    public function videos_store(VideoStoreRequest $request)
    {
        $this->videoService->storeVideo($request->all());

        Session::flash('success', 'Video baru berhasil ditambahkan!');

        return response()->json([
            'success' => 'Video baru berhasil ditambahkan!',
            'redirect' => route('admin.videos.all')
        ]);
    }

    public function fetchVideosById($id)
    {
        $video = Post::findOrFail($id);
        return response()->json($video);
    }

    public function update(VideoUpdateRequest $request, $id)
    {
        $video = Post::findOrFail($id);
        $this->videoService->updateVideo($video, $request->all());

        return response()->json(['message' => 'Data Video berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        $video = Post::findOrFail($id);
        $this->videoService->deleteVideo($video);

        return response()->json([
            'type' => 'success',
            'message' => 'Data Video berhasil dihapus.'
        ]);
    }

    public function deleteSelectedVideos(Request $request)
    {
        if ($request->ajax()) {
            $ids = $request->ids;

            if (!empty($ids)) {
                $this->videoService->deleteMultipleVideos($ids);

                return response()->json([
                    'type' => 'success',
                    'message' => 'Video berhasil dihapus.'
                ]);
            }

            return response()->json([
                'type' => 'error',
                'message' => 'Tidak ada Video yang dipilih untuk dihapus.'
            ], 422);
        }
    }
}
