<?php

namespace Modules\Formulir\Controllers;

use Log;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Modules\Formulir\Models\Form;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class FormulirController extends Controller
{

    public function index()
    {
        $judul = 'Formulir';
        $formulirs = Form::latest()->get();

        return view('formulir::index', compact('judul', 'formulirs'));
    }

    public function create()
    {
        $judul = 'Buat Formulir';
        return view('formulir::create', compact('judul'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        // Cek slug unik, jika sudah ada, tambahkan angka
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (\Modules\Formulir\Models\Form::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter++;
        }

        $formulir = Form::create($validated);

        return redirect()->route('formulir.builder', $formulir->uuid)
            ->with('success', 'Formulir berhasil dibuat. Lanjut ke builder.');
    }

    public function builder($id)
    {
        $form = Form::with(['themeSetting'])
            ->where('id', $id)
            ->orWhere('uuid', $id)
            ->firstOrFail();

        $judul = 'Builder: ' . $form->title;

        $questions = $form->questions()->with('options')->orderBy('sort_order')->get();

        return view('formulir::builder', compact('form', 'judul', 'questions'));
    }


    public function preview(Form $form)
    {

        $form->load('questions.options');

        return view('formulir::frontend.show', [
            'form' => $form,
            'previewMode' => true
        ]);
    }




    public function storeQuestions(Request $request, Form $form)
    {
        try {
            // Simpan judul, deskripsi, dan update slug jika judul berubah
            if ($request->has('title')) {
                $form->title = $request->input('title');

                // Update slug dari judul
                $newSlug = Str::slug($form->title);
                $i = 1;
                $baseSlug = $newSlug;

                while (Form::where('slug', $newSlug)->where('id', '!=', $form->id)->exists()) {
                    $newSlug = $baseSlug . '-' . $i++;
                }

                $form->slug = $newSlug;
            }

            if ($request->has('description')) {
                $form->description = $request->input('description');
            }

            $form->save();

            // Hapus pertanyaan lama
            $form->questions()->delete();

            foreach ($request->input('questions', []) as $index => $q) {
                $question = $form->questions()->create([
                    'question_text' => $q['question_text'],
                    'type' => $q['type'],
                    'is_required' => $q['is_required'] ?? false,
                    'sort_order' => $index + 1,
                ]);

                if (in_array($q['type'], ['select', 'radio', 'checkbox']) && isset($q['options'])) {
                    foreach ($q['options'] as $option) {
                        $question->options()->create([
                            'option_text' => $option,
                        ]);
                    }
                }
            }



            return response()->json([
                'message' => 'Berhasil disimpan',
                'slug' => $form->slug, // ⬅️ Kirim slug terbaru
            ]);
        } catch (\Throwable $e) {
            \Log::error('Gagal menyimpan formulir: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal menyimpan'], 500);
        }
    }

    public function updateHeader(Request $request, Form $form)
    {
        try {
            if ($request->hasFile('header_image')) {
                $file = $request->file('header_image');
                $filename = 'header_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('form_headers', $filename, 'public');

                $form->header_image = $path;
                $form->save();
            }

            return response()->json([
                'message' => 'Header berhasil diperbarui',
                'header' => Storage::url($form->header_image),
            ]);
        } catch (\Throwable $e) {
            \Log::error('Gagal update header: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal menyimpan header'], 500);
        }
    }


    public function deleteHeader(Form $form)
    {
        try {
            if ($form->header_image && Storage::disk('public')->exists($form->header_image)) {
                Storage::disk('public')->delete($form->header_image);
            }

            $form->header_image = null;
            $form->save();

            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            \Log::error('Gagal hapus header: ' . $e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }



    public function publish(Form $form)
    {
        $form->is_active = 1;
        $form->save();

        return response()->json([
            'message' => 'Berhasil dipublikasikan',
            'url' => url("/formulir/{$form->slug}")
        ]);
    }

    public function unpublish($id)
    {
        $form = Form::where('id', $id)->orWhere('uuid', $id)->firstOrFail();
        $form->update(['is_active' => false]);

        return redirect()->back()->with('success', 'Formulir berhasil dinonaktifkan.');
    }

    public function updateMetadata(Request $request, Form $form)
    {
        $form->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return response()->json(['message' => 'Metadata diperbarui']);
    }
}
