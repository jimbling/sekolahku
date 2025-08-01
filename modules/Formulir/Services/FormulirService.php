<?php

namespace Modules\Formulir\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Formulir\Models\Form;
use Modules\Formulir\Models\FormQuestion;

class FormulirService
{
    public function storeQuestions(Request $request, Form $form)
    {
        try {
            if ($request->has('title')) {
                $form->title = $request->input('title');
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

            $existingQuestionIds = $form->questions->pluck('id')->toArray();
            $submittedIds = [];

            foreach ($request->input('questions', []) as $index => $q) {
                if (isset($q['id']) && in_array($q['id'], $existingQuestionIds)) {
                    $question = FormQuestion::find($q['id']);
                    $question->update([
                        'question_text' => $q['question_text'],
                        'type' => $q['type'],
                        'is_required' => $q['is_required'] ?? false,
                        'sort_order' => $index + 1,
                        'file_max_size' => $q['type'] === 'file'
                            ? ($q['fileSettings']['maxSize'] ? $q['fileSettings']['maxSize'] * 1024 * 1024 : null)
                            : null,
                    ]);
                    $question->options()->delete();
                } else {
                    $question = $form->questions()->create([
                        'question_text' => $q['question_text'],
                        'type' => $q['type'],
                        'is_required' => $q['is_required'] ?? false,
                        'sort_order' => $index + 1,
                        'file_max_size' => $q['type'] === 'file'
                            ? ($q['fileSettings']['maxSize'] ? $q['fileSettings']['maxSize'] * 1024 * 1024 : null)
                            : null,
                    ]);
                }

                $submittedIds[] = $question->id;

                if (in_array($q['type'], ['select', 'radio', 'checkbox']) && isset($q['options'])) {
                    foreach ($q['options'] as $option) {
                        $question->options()->create([
                            'option_text' => $option,
                        ]);
                    }
                }
            }

            $questionsToDelete = array_diff($existingQuestionIds, $submittedIds);
            FormQuestion::whereIn('id', $questionsToDelete)->delete();

            return ['success' => true, 'slug' => $form->slug];
        } catch (\Throwable $e) {
            Log::error('Gagal menyimpan formulir: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Gagal menyimpan'];
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

            return ['success' => true, 'header' => Storage::url($form->header_image)];
        } catch (\Throwable $e) {
            Log::error('Gagal update header: ' . $e->getMessage());
            return ['success' => false];
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

            return ['success' => true];
        } catch (\Throwable $e) {
            Log::error('Gagal hapus header: ' . $e->getMessage());
            return ['success' => false];
        }
    }

    public function saveTheme(Request $request, Form $form)
    {
        $theme = $form->themeSetting()->firstOrNew(['form_id' => $form->id]);
        $theme->pattern_url = $request->filled('pattern_url') ? $request->pattern_url : null;
        $theme->save();

        return ['success' => true];
    }
}
