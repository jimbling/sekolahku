<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\Backend\Media\FilesServices;
use Illuminate\Http\Request;

class FilesController extends Controller
{
    protected $service;

    public function __construct(FilesServices $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('admin.media.all_files', $this->service->getIndexData());
    }

    public function getFiles(Request $request)
    {
        if ($request->ajax()) {
            return $this->service->getFiles($request);
        }
    }

    public function store(Request $request)
    {
        $result = $this->service->store($request);

        if (isset($result['errors'])) {
            return response()->json(['errors' => $result['errors']], 422);
        }

        return response()->json([
            'success' => $result['success'],
            'redirect' => route('admin.files.all')
        ]);
    }


    public function fetchFilesById($id)
    {
        return response()->json($this->service->fetchById($id));
    }

    public function update(Request $request, $id)
    {
        $result = $this->service->update($request, $id);

        if (isset($result['errors'])) {
            return response()->json(['errors' => $result['errors']], 422);
        }

        return response()->json([
            'message' => $result['message'],
            'redirect' => route('admin.files.all')
        ]);
    }

    public function destroy($id)
    {
        return response()->json($this->service->destroy($id));
    }

    public function deleteSelectedFiles(Request $request)
    {
        if ($request->ajax()) {
            if (empty($request->ids)) {
                return response()->json([
                    'type' => 'error',
                    'message' => 'Tidak ada File yang dipilih untuk dihapus.'
                ], 422);
            }

            return response()->json($this->service->deleteSelected($request->ids));
        }
    }
}
