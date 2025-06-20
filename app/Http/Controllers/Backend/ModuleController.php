<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index()
    {
        $judul = 'Manajemen Modul';
        $modules = Module::all();
        return view('admin.modules.index', compact('judul', 'modules'));
    }

    public function create()
    {
        $judul = 'Tambah Modul';
        return view('admin.modules.create', compact('judul'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'alias' => 'required|string|unique:modules,alias',
            'version' => 'required|string',
            'description' => 'nullable|string',
            'enabled' => 'boolean'
        ]);

        Module::create($request->all());

        return redirect()->route('admin.modules.index')->with('success', 'Modul berhasil ditambahkan.');
    }

    public function edit(Module $module)
    {
        $judul = 'Edit Modul';
        return view('admin.modules.edit', compact('judul', 'module'));
    }

    public function update(Request $request, Module $module)
    {
        $request->validate([
            'name' => 'required|string',
            'alias' => "required|string|unique:modules,alias,{$module->id}",
            'version' => 'required|string',
            'description' => 'nullable|string',
            'enabled' => 'boolean'
        ]);

        $module->update($request->all());

        return redirect()->route('admin.modules.index')->with('success', 'Modul berhasil diperbarui.');
    }

    public function destroy(Module $module)
    {
        $module->delete();
        return redirect()->route('admin.modules.index')->with('success', 'Modul berhasil dihapus.');
    }

    public function toggle(Module $module)
    {
        $module->enabled = !$module->enabled;
        $module->save();

        return redirect()->route('admin.modules.index')->with('success', 'Status modul berhasil diubah.');
    }
}
