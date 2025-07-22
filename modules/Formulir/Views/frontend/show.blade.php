<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('storage/images/settings/' . get_setting('favicon')) }}" type="image/x-icon">
    <title>{{ $form->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #e2e8ee 0%, #e2ebfd 100%);
            min-height: 100vh;
        }

        .form-card {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            transition: all 0.2s ease;
        }

        .form-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.03);
        }

        .option-card:hover {
            border-color: #3b82f6;
            transform: translateY(-1px);
        }

        .option-card.selected {
            border-color: #3b82f6;
            background-color: #f0f7ff;
        }

        .required-star {
            color: #d32f2f;
        }

        .header-image {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }

        .title-card {
            background: linear-gradient(135deg, #f5f7fc 0%, #fafafa 100%);
            color: black;
            position: relative;
            overflow: hidden;
        }

        .title-card::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #f59e0b 0%, #ef4444 50%, #f59e0b 100%);
        }

        .required-info {
            font-size: 0.8rem;
            color: #6b7280;
            margin-top: 0.5rem;
        }
    </style>
</head>

<body class="py-8">
    <div class="max-w-2xl mx-auto px-4 space-y-6">
        <!-- Header Image (if exists) -->
        @if ($form->header_image)
            <div class="overflow-hidden">
                <img src="{{ asset('storage/' . $form->header_image) }}" alt="Header" class="w-full  object-cover">
            </div>
        @endif

        <!-- Form Header - Updated with new design -->
        <div class="rounded-xl form-card title-card p-8 ">
            <h1 class="text-2xl font-bold mb-2">{{ $form->title }}</h1>
            @if ($form->description)
                <p class="text-gray-800">{{ $form->description }}</p>
            @endif
            <p class="required-info">
                <span class="required-star">*</span> Menandakan pertanyaan wajib diisi
            </p>
        </div>


        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                <div class="flex items-center justify-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="text-green-700">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Form Questions -->
        <form method="POST" action="" class="space-y-4">
            @csrf

            @foreach ($form->questions as $q)
                <div class="bg-white rounded-xl form-card p-6">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            {{ $q->question_text }}
                            @if ($q->is_required)
                                <span class="required-star">*</span>
                            @endif
                        </label>

                        @php $fieldName = "question.{$q->id}"; @endphp

                        @if ($q->type == 'text')
                            <input type="text" name="question[{{ $q->id }}]"
                                value="{{ old("question.{$q->id}") }}"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error($fieldName) border-red-500 @enderror"
                                placeholder="Ketik jawaban Anda">
                        @elseif ($q->type == 'textarea')
                            <textarea name="question[{{ $q->id }}]" rows="3"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error($fieldName) border-red-500 @enderror"
                                placeholder="Ketik jawaban Anda">{{ old("question.{$q->id}") }}</textarea>
                        @elseif ($q->type == 'select')
                            <select name="question[{{ $q->id }}]"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-lg @error($fieldName) border-red-500 @enderror">
                                <option value="">-- Pilih --</option>
                                @foreach ($q->options as $opt)
                                    <option value="{{ $opt->option_text }}"
                                        {{ old("question.{$q->id}") == $opt->option_text ? 'selected' : '' }}>
                                        {{ $opt->option_text }}
                                    </option>
                                @endforeach
                            </select>
                        @elseif ($q->type == 'radio')
                            <div class="mt-2 space-y-2">
                                @foreach ($q->options as $opt)
                                    <label
                                        class="flex items-center p-3 border rounded-lg option-card cursor-pointer transition">
                                        <input type="radio" name="question[{{ $q->id }}]"
                                            value="{{ $opt->option_text }}"
                                            {{ old("question.{$q->id}") == $opt->option_text ? 'checked' : '' }}
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="ml-3 text-gray-700">{{ $opt->option_text }}</span>
                                    </label>
                                @endforeach
                            </div>
                        @elseif ($q->type == 'checkbox')
                            <div class="mt-2 space-y-2">
                                @foreach ($q->options as $opt)
                                    <label
                                        class="flex items-center p-3 border rounded-lg option-card cursor-pointer transition">
                                        <input type="checkbox" name="question[{{ $q->id }}][]"
                                            value="{{ $opt->option_text }}"
                                            {{ collect(old("question.{$q->id}", []))->contains($opt->option_text) ? 'checked' : '' }}
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="ml-3 text-gray-700">{{ $opt->option_text }}</span>
                                    </label>
                                @endforeach
                            </div>
                        @endif

                        @error($fieldName)
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            @endforeach

            <!-- Submit Button -->
            <div class="bg-white rounded-xl form-card p-6">
                <button type="submit"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                    Kirim Jawaban
                </button>
            </div>
        </form>

        <!-- Footer -->
        <footer class="text-center text-gray-500 text-sm mt-12 pb-8">
            <div class="border-t border-gray-200 pt-6">
                <p>Formulir dibuat dengan <span class="text-red-500">♥</span> oleh {{ config('app.name') }}</p>
                <p class="mt-1">© {{ date('Y') }} Hak Cipta Dilindungi</p>
            </div>
        </footer>
    </div>

    <script>
        // Add visual feedback for selected options
        document.querySelectorAll('.option-card input').forEach(input => {
            input.addEventListener('change', function() {
                const card = this.closest('.option-card');

                // For radio buttons, remove selected class from all options in group
                if (this.type === 'radio') {
                    document.querySelectorAll(`input[name="${this.name}"]`).forEach(radio => {
                        radio.closest('.option-card').classList.remove('selected');
                    });
                }

                // Toggle selected class based on checked state
                if (this.checked) {
                    card.classList.add('selected');
                } else {
                    card.classList.remove('selected');
                }
            });

            // Initialize selected state
            if (input.checked) {
                input.closest('.option-card').classList.add('selected');
            }
        });
    </script>
</body>

</html>
