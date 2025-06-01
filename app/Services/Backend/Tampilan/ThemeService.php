<?php

namespace App\Services\Backend\Tampilan;

use App\Models\Theme;
use Illuminate\Support\Facades\DB;

class ThemeService
{
    public function all()
    {
        return Theme::orderBy('theme_name')->get();
    }

    public function getTemasForDatatables()
    {
        return Theme::select([
            'id',
            'theme_name',
            'folder_name',
            'display_name',
            'is_active',
            'description',
            'created_at',
            'updated_at'
        ]);
    }

    public function find($id)
    {
        return Theme::findOrFail($id);
    }

    public function store(array $data)
    {
        return Theme::create($data);
    }

    public function update(Theme $theme, array $data)
    {
        return $theme->update($data);
    }

    public function delete(Theme $theme)
    {
        if ($theme->is_active) {
            throw new \Exception("Tema aktif tidak boleh dihapus. Silakan nonaktifkan dulu tema ini.");
        }

        // Hapus folder fisik tema
        $folderPath = resource_path('views/themes/' . $theme->folder_name);
        if (\Illuminate\Support\Facades\File::exists($folderPath)) {
            \Illuminate\Support\Facades\File::deleteDirectory($folderPath);
        }

        // Hapus record database
        return $theme->delete();
    }



    public function setActive(Theme $theme)
    {
        DB::transaction(function () use ($theme) {
            Theme::where('is_active', 1)->update(['is_active' => 0]);
            $theme->update(['is_active' => 1]);
        });

        return $theme;
    }
}
