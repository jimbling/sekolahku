<?php

namespace App\Http\Controllers\Backend;

use App\Models\Widget;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WidgetController extends Controller
{


    /**
     * Tampilkan semua widget.
     */
    public function index()
    {
        $widgets = Widget::orderBy('position')->get();
        $judul = "Pengaturan Widget";
        return view('admin.tampilan.widgets', compact('widgets', 'judul'));
    }

    /**
     * Update widget dari form modal.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'title' => 'nullable|string|max:255',
            'position' => 'required|integer|unique:widgets,position,' . $id,
            'settings' => 'nullable|string',
        ]);

        $widget = Widget::findOrFail($id);

        $settings = json_decode($request->input('settings'), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return redirect()->back()->withErrors(['settings' => 'Format JSON tidak valid'])->withInput();
        }

        $widget->update([
            'name' => $request->input('name'),
            'title' => $request->input('title'),
            'position' => $request->input('position'),
            'is_active' => $request->has('is_active'),
            'settings' => $settings,
        ]);

        return redirect()->route('widgets.index')->with('toastr', [
            'type' => 'success',
            'message' => 'Widget berhasil diperbarui.'
        ]);
    }

    /**
     * Update urutan widget (drag & drop).
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
        ]);

        foreach ($request->order as $index => $id) {
            Widget::where('id', $id)->update(['position' => $index + 1]);
        }

        return response()->json(['status' => 'ok']);
    }
}
