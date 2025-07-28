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
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            // Admin bisa lihat semua formulir
            $formulirs = Form::withCount('responses')->latest()->get();
        } else {
            // User biasa cuma bisa lihat formulir dia sendiri
            $formulirs = Form::withCount('responses')
                ->where('user_id', $user->id)
                ->latest()
                ->get();
        }

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

        // ✅ Tambahkan user_id pembuat formulir
        $validated['user_id'] = Auth::id();

        // 🔁 Pastikan slug unik
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (\Modules\Formulir\Models\Form::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter++;
        }

        // ✅ Buat formulir dengan semua data termasuk user_id
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

        $user = Auth::user();


        if ($user->hasRole('admin')) {
            $formulirs = Form::latest()->get();
        } else {

            $formulirs = Form::where('user_id', $user->id)
                ->latest()
                ->get();
        }

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

    public function analytics($uuid)
    {
        $form = Form::with(['questions.options', 'responses.answers', 'responses.uploads'])
            ->where('uuid', $uuid)
            ->firstOrFail();

        $totalResponses = $form->responses->count();
        $totalQuestions = $form->questions->count();
        $lastSubmit = $form->responses->max('created_at');

        // Hitung jumlah pertanyaan wajib
        $requiredQuestions = $form->questions->where('is_required', 1);

        // ✅ Respon dianggap lengkap jika semua pertanyaan wajib dijawab (jawaban valid)
        $fullyAnswered = $form->responses->filter(function ($response) use ($requiredQuestions) {
            $answeredIds = $response->answers
                ->filter(fn($a) => !is_null($a->answer) && trim($a->answer) !== '' && $a->answer !== '[]')
                ->pluck('question_id')
                ->toArray();
            return $requiredQuestions->every(fn($q) => in_array($q->id, $answeredIds));
        })->count();

        $percentageFull = $totalResponses > 0 ? round(($fullyAnswered / $totalResponses) * 100, 1) : 0;

        // ✅ Hitung upload stat
        $totalUploads = $form->responses->flatMap->uploads;
        $uploadCount = $totalUploads->count();
        $uploadSize = $totalUploads->sum('file_size');

        // ✅ Kumpulkan analisis per pertanyaan
        $analytics = $form->questions->map(function ($q) use ($totalResponses) {
            // 🔹 Hitung jumlah jawaban valid (tergantung tipe)
            $answeredCount = $q->answers->filter(function ($answer) use ($q) {
                if ($q->type === 'checkbox') {
                    $decoded = json_decode($answer->answer, true);
                    return is_array($decoded) && count($decoded) > 0;
                }
                return !is_null($answer->answer) && trim($answer->answer) !== '';
            })->count();

            $skippedCount = $totalResponses - $answeredCount;

            // 🔹 Hitung jumlah untuk tiap opsi (radio/select/checkbox)
            $optionStats = [];
            if (in_array($q->type, ['radio', 'select', 'checkbox']) && $q->options->count()) {
                foreach ($q->options as $opt) {
                    if ($q->type === 'checkbox') {
                        $count = $q->answers->filter(function ($answer) use ($opt) {
                            $decoded = json_decode($answer->answer, true);
                            return is_array($decoded) && in_array($opt->option_text, $decoded);
                        })->count();
                    } else {
                        $count = $q->answers->where('answer', $opt->option_text)->count();
                    }

                    $percentage = $totalResponses > 0 ? round(($count / $totalResponses) * 100) : 0;

                    $optionStats[] = [
                        'text' => $opt->option_text,
                        'count' => $count,
                        'percentage' => $percentage
                    ];
                }
            }

            return [
                'id' => $q->id,
                'text' => $q->question_text,
                'type' => $q->type,
                'is_required' => $q->is_required,
                'answered' => $answeredCount,
                'skipped' => $skippedCount,
                'options' => $optionStats
            ];
        });

        return view('formulir::partials.analitik', compact(
            'form',
            'totalResponses',
            'totalQuestions',
            'lastSubmit',
            'fullyAnswered',
            'percentageFull',
            'uploadCount',
            'uploadSize',
            'analytics' // ✅ Kirim data analitik ke Blade
        ));
    }


    public function analyticsJson(Form $form)
    {
        $responses = $form->responses;
        $totalResponses = $responses->count();
        $fullyAnswered = $responses->filter(fn($r) => $r->is_complete)->count();
        $percentageFull = $totalResponses > 0 ? round(($fullyAnswered / $totalResponses) * 100) : 0;

        return response()->json([
            'form' => $form,
            'totalResponses' => $totalResponses,
            'totalQuestions' => $form->questions()->count(),
            'fullyAnswered' => $fullyAnswered,
            'percentageFull' => $percentageFull,
            'lastSubmit' => optional($responses->last())->created_at,
            'questions' => $form->questions()->with('answers', 'options')->get(),
            'uploadCount' => $form->responses()->withCount('uploads')->get()->sum('uploads_count'),
            'uploadSize' => $form->responses()->with('uploads')->get()->flatMap->uploads->sum('file_size'),

        ]);
    }
}
