<?php

namespace Modules\Ringkas\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Routing\Controller;
use Modules\Ringkas\Models\RingkasLink;
use Illuminate\Support\Facades\Validator;

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
        $perPage = 3;
        $query = RingkasLink::query();

        if ($request->has('q') && $request->q) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('slug', 'like', "%$keyword%")
                    ->orWhere('original_url', 'like', "%$keyword%")
                    ->orWhere('description', 'like', "%$keyword%");
            });
        }

        $links = $query->orderBy('created_at', 'desc')->paginate($perPage);

        $mapped = $links->getCollection()->map(function ($item) {
            return [
                'id' => $item->id,
                'slug' => $item->slug,
                'original_url' => $item->original_url,
                'description' => $item->description,
                'is_active' => $item->is_active,
                'hit_count' => $item->hit_count,
                'created_at' => \Carbon\Carbon::parse($item->created_at)
                    ->timezone('Asia/Jakarta')
                    ->translatedFormat('d M Y H:i'),
            ];
        });

        return response()->json([
            'data' => $mapped,
            'pagination' => [
                'current_page' => $links->currentPage(),
                'last_page' => $links->lastPage(),
                'next_page_url' => $links->nextPageUrl(),
                'prev_page_url' => $links->previousPageUrl(),
            ]
        ]);
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
        // Validasi dengan pesan custom
        $request->validate([
            'original_url' => 'required|url',
            'slug' => 'nullable|unique:ringkas_links,slug',
            'description' => 'nullable|string',
        ], [
            'original_url.required' => 'URL asli wajib diisi.',
            'original_url.url' => 'Format URL tidak valid.',
            'slug.unique' => 'Slug sudah digunakan. Silakan pilih slug lain.',
        ]);

        // Generate slug jika kosong
        $slug = $request->slug;
        if (empty($slug)) {
            do {
                $slug = Str::lower(Str::random(6));
            } while (RingkasLink::where('slug', $slug)->exists());
        }

        RingkasLink::create([
            'slug' => $slug,
            'original_url' => $request->original_url,
            'description' => $request->description,
            'created_by' => auth()->id(),
        ]);

        return response()->json(['message' => 'Link berhasil ditambahkan.', 'slug' => $slug]);
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


    public function createPublic()
    {
        $judul = 'Ringkasin';

        return view('ringkas::frontend.form', compact('judul'));
    }


    public function storePublic(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'slug' => 'nullable|unique:ringkas_links,slug|alpha_dash|max:30',
            'original_url' => 'required|url',
            'description' => 'nullable|string|max:255',
        ]);

        // Jika AJAX, dan gagal validasi
        if ($request->ajax() && $validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Validasi biasa (jika bukan AJAX)
        $validator->validate();

        $slug = $request->slug ?: Str::random(6);

        $link = RingkasLink::create([
            'slug' => $slug,
            'original_url' => $request->original_url,
            'description' => $request->description,
            'created_by' => null,
        ]);

        $shortUrl = url('ringkas/' . $link->slug);

        // Jika AJAX, kirim response JSON
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Link berhasil dibuat!',
                'short_url' => $shortUrl
            ]);
        }

        // Jika non-AJAX, fallback ke redirect biasa
        return back()->with([
            'success' => 'Link berhasil dibuat!',
            'short_url' => $shortUrl
        ]);
    }
}
