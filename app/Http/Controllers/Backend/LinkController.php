<?php

// app/Http/Controllers/Backend/LinkController.php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Blog\LinkStoreRequest;
use App\Http\Requests\Backend\Blog\LinkUpdateRequest;
use App\Models\Link;
use App\Services\Backend\Blog\LinkService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LinkController extends Controller
{
    protected $linkService;

    public function __construct(LinkService $linkService)
    {
        $this->linkService = $linkService;
    }

    public function index()
    {
        $tautan = $this->linkService->getAllLinks();
        $data = [
            'judul' => "Tautan",
            'tautan' => $tautan,
        ];
        return view('admin.blog.tautan', $data);
    }

    public function getTautan(Request $request)
    {
        if ($request->ajax()) {
            $tautan = $this->linkService->getLinksForDatatables();

            return DataTables::of($tautan)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                        <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-primary btn-xs edit-btn"><i class="fas fa-edit"></i> Edit</a>
                        <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-xs delete-btn"><i class="fas fa-trash-alt"></i> Hapus</a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function simpanTautan(LinkStoreRequest $request)
    {
        $this->linkService->storeLink($request->all());
        return response()->json(['message' => 'Tautan berhasil ditambahkan.'], 200);
    }

    public function fetchTautanById($id)
    {
        $tautan = Link::findOrFail($id);
        return response()->json($tautan);
    }

    public function update(LinkUpdateRequest $request, $id)
    {
        $tautan = Link::findOrFail($id);
        $this->linkService->updateLink($tautan, $request->all());
        return response()->json(['message' => 'Tautan berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        $tautan = Link::findOrFail($id);
        $this->linkService->deleteLink($tautan);
        return response()->json([
            'type' => 'success',
            'message' => 'Tautan berhasil dihapus.'
        ]);
    }
}
