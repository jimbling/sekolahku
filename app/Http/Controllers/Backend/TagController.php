<?php

// app/Http/Controllers/Backend/TagController.php
namespace App\Http\Controllers\Backend;

use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Services\Backend\Blog\TagService;
use App\Http\Requests\Backend\Blog\Tag\TagStoreRequest;
use App\Http\Requests\Backend\Blog\Tag\TagUpdateRequest;

class TagController extends Controller
{
    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function index()
    {
        $tags = $this->tagService->getAllTags();
        $data = [
            'judul' => "All Tags",
            'tags' => $tags
        ];

        return view('admin.blog.tags', $data, compact('tags'));
    }

    public function getTags(Request $request)
    {
        if ($request->ajax()) {
            $tags = $this->tagService->getTagsForDatatables();

            return DataTables::of($tags)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                        <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-xs delete-btn"><i class="fas fa-trash-alt"></i> Hapus</a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function simpanTags(TagStoreRequest $request)
    {
        $this->tagService->storeTag($request->all());
        return response()->json(['message' => 'Tag berhasil ditambahkan.'], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:tags,name|max:255',
        ]);

        $tag = new Tag();
        $tag->name = $request->name;
        $tag->slug = Str::slug($request->name, '-');
        $tag->save();

        return redirect()->route('tags.index')->with('success', 'Tag berhasil ditambahkan.');
    }

    public function edit(Tag $tag)
    {
        return view('backend.tags.edit', compact('tag'));
    }

    public function update(TagUpdateRequest $request, Tag $tag)
    {
        $this->tagService->updateTag($tag, $request->all());
        return redirect()->route('tags.index')->with('success', 'Tag berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $this->tagService->deleteTag($tag);

        return response()->json([
            'type' => 'success',
            'message' => 'Tag berhasil dihapus.'
        ]);
    }

    public function deleteSelectedTags(Request $request)
    {
        if ($request->ajax()) {
            $ids = $request->ids;

            if (!empty($ids)) {
                $this->tagService->deleteMultipleTags($ids);

                return response()->json([
                    'type' => 'success',
                    'message' => 'Tags berhasil dihapus.'
                ]);
            }

            return response()->json([
                'type' => 'error',
                'message' => 'Tidak ada tags yang dipilih untuk dihapus.'
            ], 422);
        }
    }
}
