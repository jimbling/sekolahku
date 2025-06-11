<?php

namespace App\Http\Controllers\Backend;

use App\Models\QuickLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuickLinkController extends Controller
{
    public function index()
    {
        $items = QuickLink::latest()->get();
        $judul = "Publikasi Akses Cepat";

        return view('admin.publikasi.akses-cepat', compact('items', 'judul'));
    }

    public function create()
    {
        return view('backend.content.quick_links.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required',
            'url' => 'required|url',
            'icon' => 'nullable|string',
            'color' => 'required|string'
        ]);

        QuickLink::create($validated);

        return redirect()->route('quick-links.index')->with('success', 'Tautan ditambahkan.');
    }

    public function edit(QuickLink $quickLink)
    {
        return view('backend.content.quick_links.edit', compact('quickLink'));
    }

    public function update(Request $request, QuickLink $quickLink)
    {
        $validated = $request->validate([
            'label' => 'required',
            'url' => 'required|url',
            'icon' => 'nullable|string',
            'color' => 'required|string'
        ]);

        $quickLink->update($validated);

        return redirect()->route('quick-links.index')->with('success', 'Tautan diperbarui.');
    }

    public function destroy(QuickLink $quickLink)
    {
        $quickLink->delete();
        return redirect()->route('quick-links.index')->with('success', 'Tautan dihapus.');
    }
}
