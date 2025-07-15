<?php

namespace Modules\Ringkas\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Routing\Controller;
use Modules\Ringkas\Models\RingkasLink;

class RingkasController extends Controller
{
    public function index()
    {
        $judul = 'Ringkas';
        $links = RingkasLink::latest()->paginate(10);

        // Data statistik untuk dashboard
        $totalLinks = RingkasLink::count();
        $totalHits = RingkasLink::sum('hit_count');
        $activeLinks = RingkasLink::where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expired_at')
                    ->orWhere('expired_at', '>', now());
            })->count();

        return view('ringkas::index', compact('judul', 'links', 'totalLinks', 'totalHits', 'activeLinks'));
    }


    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = RingkasLink::query();
            return DataTables::of($data)
                ->editColumn('slug', function ($row) {
                    $url = url('ringkas/' . $row->slug);
                    return "
       <div class='d-flex flex-column'>
    <code>{$row->slug}</code>
    <small>
        <a href='{$url}' target='_blank'>{$url}</a>
        <button class='btn btn-link btn-sm text-primary p-0 copy-btn'
                data-url='{$url}'
                data-toggle='tooltip'
                data-placement='top'
                title='Salin'>
            <i class='fas fa-copy'></i>
        </button>
    </small>
</div>
    ";
                })

                ->editColumn('is_active', fn($r) => $r->is_active
                    ? '<span class="badge badge-success">Aktif</span>'
                    : '<span class="badge badge-secondary">Nonaktif</span>')
                ->editColumn('created_at', function ($row) {
                    return \Carbon\Carbon::parse($row->created_at)->translatedFormat('d F Y H:i');
                })
                ->editColumn('original_url', function ($row) {
                    $url = e($row->original_url);
                    return "<div class='text-truncate' style='max-width: 300px;' title='$url'>$url</div>";
                })
                ->addColumn('aksi', function ($row) {
                    return view('ringkas::partials._aksi', compact('row'))->render();
                })
                ->rawColumns(['slug', 'is_active', 'original_url', 'aksi'])
                ->make(true);
        }
    }


    public function updateStatus($id, Request $request)
    {
        $link = RingkasLink::findOrFail($id);

        $request->validate([
            'is_active' => 'required|in:0,1',
        ]);

        $link->is_active = $request->is_active;
        $link->save();

        return response()->json([
            'message' => 'Status berhasil diperbarui.'
        ]);
    }

    public function getStats()
    {
        $totalLinks = RingkasLink::count();
        $totalHits = RingkasLink::sum('hit_count');
        $activeLinks = RingkasLink::where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expired_at')
                    ->orWhere('expired_at', '>', now());
            })->count();

        return response()->json([
            'totalLinks' => $totalLinks,
            'totalHits' => $totalHits,
            'activeLinks' => $activeLinks
        ]);
    }







    public function store(Request $request)
    {
        $request->validate([
            'slug' => 'required|unique:ringkas_links,slug',
            'original_url' => 'required|url',
            'description' => 'nullable|string',
        ]);

        RingkasLink::create([
            'slug' => $request->slug,
            'original_url' => $request->original_url,
            'description' => $request->description,
            'created_by' => auth()->id(),
        ]);

        return response()->json(['message' => 'Link berhasil ditambahkan.']);
    }

    public function update(Request $request, $id)
    {
        $link = RingkasLink::findOrFail($id);

        $request->validate([
            'slug' => 'required|unique:ringkas_links,slug,' . $link->id,
            'original_url' => 'required|url',
            'description' => 'nullable|string',
        ]);

        $link->update($request->only('slug', 'original_url', 'description'));

        return response()->json(['message' => 'Link berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        $link = RingkasLink::findOrFail($id);
        $link->delete();

        return response()->json([
            'message' => 'Link berhasil dihapus.'
        ]);
    }


    public function edit($id)
    {
        $link = RingkasLink::findOrFail($id);
        return view('admin.ringkas.edit', compact('link'));
    }
}
