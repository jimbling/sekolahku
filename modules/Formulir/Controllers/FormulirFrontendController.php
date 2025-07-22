<?php

namespace Modules\Formulir\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\Formulir\Models\Form;
use Modules\Formulir\Models\FormResponse;

class FormulirFrontendController extends Controller
{
    public function index()
    {
        $judul = 'Formulir';
        return view('formulir::frontend.index', compact('judul'));
    }

    public function showForm(Form $form)
    {
        if (! $form->is_active) {
            abort(404); // atau bisa redirect dengan pesan error jika mau
        }

        $form->load('questions.options'); // eager load
        return view('formulir::frontend.show', compact('form'));
    }


    public function submitForm(Request $request, Form $form)
    {
        $rules = [];

        // Buat rules berdasarkan is_required
        foreach ($form->questions as $question) {
            if ($question->is_required) {
                $key = "question.{$question->id}";
                if (in_array($question->type, ['checkbox'])) {
                    $rules[$key] = 'required|array|min:1';
                } else {
                    $rules[$key] = 'required';
                }
            }
        }

        $messages = [
            'required' => 'Pertanyaan ini wajib diisi.',
            'array' => 'Pilih minimal satu jawaban.',
        ];

        $validated = $request->validate($rules, $messages);

        // Simpan respons utama
        $response = $form->responses()->create([
            'submitted_at' => now(),
        ]);

        foreach ($request->input('question', []) as $question_id => $value) {
            $valid = $form->questions()->where('id', $question_id)->exists();
            if (!$valid) continue;

            $response->answers()->create([
                'question_id' => $question_id,
                'answer' => is_array($value) ? json_encode($value) : $value,
            ]);
        }

        return redirect()->back()->with('success', 'Terima kasih, jawaban Anda telah disimpan!');
    }
}
