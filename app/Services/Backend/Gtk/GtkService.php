<?php

namespace App\Services\Backend\Gtk;

use App\Models\Gtk;
use Illuminate\Support\Facades\Storage;

class GtkService
{
    public function getAllGtk()
    {
        return Gtk::all();
    }

    public function getGtkDatatable()
    {
        return Gtk::select(['id', 'full_name', 'gender', 'parent_school_status', 'gtk_status', 'email', 'photo'])
            ->orderBy('full_name', 'asc');
    }

    public function storeGtk(array $data)
    {
        $photoPath = null;
        if (isset($data['gtk_foto'])) {
            $photoPath = $data['gtk_foto']->store('images/gtks', 'public');
        }

        return Gtk::create([
            'full_name' => $data['gtk_name'],
            'gender' => $data['gtk_jk'],
            'parent_school_status' => $data['gtk_status_induk'],
            'gtk_status' => $data['gtk_keaktifan'],
            'email' => $data['gtk_email'],
            'photo' => $photoPath,
        ]);
    }

    public function getGtkById($id)
    {
        return Gtk::findOrFail($id);
    }

    public function updateGtk($id, array $data)
    {
        $gtk = Gtk::findOrFail($id);

        $gtk->full_name = $data['gtk_name'];
        $gtk->gender = $data['gtk_jk'];
        $gtk->parent_school_status = $data['gtk_status_induk'];
        $gtk->gtk_status = $data['gtk_keaktifan'];
        $gtk->email = $data['gtk_email'];

        if (isset($data['gtk_foto'])) {
            if ($gtk->photo && Storage::disk('public')->exists($gtk->photo)) {
                Storage::disk('public')->delete($gtk->photo);
            }
            $gtk->photo = $data['gtk_foto']->store('images/gtks', 'public');
        }

        $gtk->save();
        return $gtk;
    }

    public function deleteGtk($id)
    {
        $gtk = Gtk::findOrFail($id);
        $gtk->delete();
        return true;
    }

    public function deleteSelected(array $ids)
    {
        return Gtk::whereIn('id', $ids)->delete();
    }
}
