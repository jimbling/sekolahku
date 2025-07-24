<?php

namespace Modules\Formulir\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Formulir\Models\Form;
use Modules\Formulir\Models\Pattern;
use Modules\Formulir\Services\FormulirService;
use Modules\Formulir\Services\GoogleSheetService;


class FormulirController extends Controller
{

    protected $service;

    public function __construct(FormulirService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $judul = 'Formulir';

        // Eager load jumlah response tiap formulir
        $formulirs = Form::withCount('responses')->latest()->get();

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
        $patterns = Pattern::all();
        $form = Form::with(['themeSetting'])
            ->where('id', $id)
            ->orWhere('uuid', $id)
            ->firstOrFail();

        $judul = 'Builder: ' . $form->title;

        $questions = $form->questions()->with('options')->orderBy('sort_order')->get();

        return view('formulir::builder', compact('form', 'judul', 'questions', 'patterns'));
    }


    public function preview(Form $form)
    {

        $form->load('questions.options');

        return view('formulir::frontend.show', [
            'form' => $form,
            'previewMode' => true
        ]);
    }



    // Formulir CRUD Operations
    public function storeQuestions(Request $request, Form $form)
    {
        $result = $this->service->storeQuestions($request, $form);

        if ($result['success']) {
            return response()->json([
                'message' => 'Berhasil disimpan',
                'slug' => $result['slug'],
            ]);
        }

        return response()->json(['error' => $result['message']], 500);
    }

    public function updateHeader(Request $request, Form $form)
    {
        $result = $this->service->updateHeader($request, $form);

        return response()->json($result, $result['success'] ? 200 : 500);
    }

    public function deleteHeader(Form $form)
    {
        $result = $this->service->deleteHeader($form);

        return response()->json(['success' => $result['success']], $result['success'] ? 200 : 500);
    }

    public function saveTheme(Request $request, Form $form)
    {
        $result = $this->service->saveTheme($request, $form);

        return response()->json(['success' => $result['success']]);
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


    public function refreshList()
    {
        $formulirs = Form::latest()->get();
        return view('formulir::partials._list', compact('formulirs'));
    }



    public function destroy($id)
    {
        // Ambil Form berdasarkan UUID atau ID
        $form = Form::where('uuid', $id)->orWhere('id', $id)->firstOrFail();


        $form->questions()->delete();
        $form->responses()->delete();
        $form->themeSetting()?->delete();

        $form->delete();

        return response()->json([
            'type' => 'success',
            'message' => 'Formulir berhasil dihapus.'
        ]);
    }


    public function jawaban($uuid)
    {
        $formulir = Form::where('uuid', $uuid)->firstOrFail();
        $judul = 'Jawaban: ' . $formulir->title;

        // Load relasi jawaban, misal via `responses` dan `answers`
        $responses = $formulir->responses()->with(['answers.question'])->orderBy('created_at')->get();

        return view('formulir::partials.jawaban', compact('formulir', 'judul', 'responses'));
    }

    public function connectGoogleSheet(Request $request, $uuid)
    {
        $form = Form::with(['questions' => function ($q) {
            $q->orderBy('sort_order');
        }])->where('uuid', $uuid)->firstOrFail();

        app(GoogleSheetService::class)->connect($form);

        return back()->with('success', 'Form berhasil terhubung ke Google Sheet!');
    }

    public function syncGoogleSheet(Request $request, $uuid)
    {
        $form = Form::with(['questions' => function ($q) {
            $q->orderBy('sort_order');
        }, 'responses.answers'])->where('uuid', $uuid)->firstOrFail();

        app(GoogleSheetService::class)->sync($form);

        return back()->with('success', 'Sinkronisasi berhasil!');
    }
}
