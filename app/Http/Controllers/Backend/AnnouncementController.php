<?php

namespace App\Http\Controllers\Backend;

use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnnouncementController extends Controller
{
    public function index()
    {
        $items = Announcement::latest()->get();
        $judul = "Publikasi Pengumuman";
        return view('admin.publikasi.pengumuman', compact('items', 'judul'));
    }

    public function create()
    {
        return view('backend.content.announcements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'publish_date' => 'nullable|date',
            'expired_at' => 'nullable|date'
        ]);

        Announcement::create($validated);

        return redirect()->route('announcements.index')->with('success', 'Pengumuman ditambahkan.');
    }

    public function edit(Announcement $announcement)
    {
        return view('backend.content.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'publish_date' => 'nullable|date',
            'expired_at' => 'nullable|date'
        ]);

        $announcement->update($validated);

        return redirect()->route('announcements.index')->with('success', 'Pengumuman diperbarui.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->route('announcements.index')->with('success', 'Pengumuman dihapus.');
    }
}
