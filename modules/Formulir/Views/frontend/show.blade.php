<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('storage/images/settings/' . get_setting('favicon')) }}" type="image/x-icon">
    <title>{{ $form->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #e2e8ee 0%, #e2ebfd 100%);
            min-height: 100vh;
        }

        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: url('{{ optional($form->themeSetting)->pattern_url }}');
            background-size: auto;
            background-repeat: repeat;
            opacity: 0.1;
            /* Sesuaikan transparansi di sini */
            z-index: 0;
            pointer-events: none;
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
            border-color: hsl(217, 91%, 60%);
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
            background-color: #ffffff;
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
            color: #ff0000;
            margin-top: 0.5rem;
        }

        #submit-button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>


</head>

@php
    $patternUrl = optional($form->themeSetting)->pattern_url;
    $bgStyle = $patternUrl
        ? "background-image: url('{$patternUrl}'); background-size: auto; background-repeat: repeat;"
        : 'background-image: none; background-color: #f3f4f8;';
@endphp

<body class="py-8 relative" style="{{ $bgStyle }}">

    <div class="max-w-3xl mx-auto px-4 space-y-6 ">
        <!-- Header Image (if exists) -->
        @if ($form->header_image)
            <div id="header-image-preview" class="overflow-hidden rounded-xl shadow border border-gray-200 bg-white">

                <!-- Gambar Header -->
                <img src="{{ asset('storage/' . $form->header_image) }}" alt="Header Image"
                    class="w-full object-contain object-center rounded-t-xl">


            </div>
        @endif


        <!-- Form Header - Updated with new design -->
        <div class="rounded-xl form-card title-card p-8 bg-white">
            <h1 class="text-2xl font-bold mb-2">{{ $form->title }}</h1>

            @if ($form->description)
                <p class="text-gray-800">{{ $form->description }}</p>
            @endif

            <hr class="my-4 border-t border-gray-200">

            <p class="required-info text-sm text-red-600">
                <span class="required-star text-red-500 font-semibold">*</span> Menandakan pertanyaan wajib diisi
            </p>
        </div>


        <!-- Form Questions -->
        <form method="POST" action="" enctype="multipart/form-data" class="space-y-4">
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
                                @if ($q->is_required) required data-required @endif
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error($fieldName) border-red-500 @enderror"
                                placeholder="Ketik jawaban Anda">
                        @elseif ($q->type == 'textarea')
                            <textarea name="question[{{ $q->id }}]" rows="3"
                                @if ($q->is_required) required data-required @endif
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error($fieldName) border-red-500 @enderror"
                                placeholder="Ketik jawaban Anda">{{ old("question.{$q->id}") }}</textarea>
                        @elseif ($q->type == 'select')
                            <select name="question[{{ $q->id }}]" data-tom-select
                                @if ($q->is_required) required data-required @endif
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
                            <div class="mt-2 space-y-2"
                                @if ($q->is_required) data-required-radio="{{ $q->id }}" @endif>
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
                            <div class="mt-2 space-y-2"
                                @if ($q->is_required) data-required-checkbox="{{ $q->id }}" @endif>
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
                        @elseif ($q->type == 'file')
                            <input type="file" name="question[{{ $q->id }}]"
                                @if ($q->is_required) required data-required @endif
                                @if ($q->file_max_size) data-max-size="{{ $q->file_max_size }}" @endif
                                class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border file:border-gray-300 file:text-sm file:font-semibold file:bg-gray-100 hover:file:bg-gray-200 @error($fieldName) border-red-500 @enderror">

                            @if ($q->file_max_size)
                                <p class="text-sm text-gray-500 mt-1">
                                    Maksimal: {{ number_format($q->file_max_size / 1024 / 1024, 2) }} MB
                                </p>
                            @endif
                        @endif



                        @error($fieldName)
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            @endforeach

            <!-- Submit Button -->
            <div class="bg-white rounded-xl form-card p-6">
                <button type="submit" id="submit-button" disabled
                    class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">

                    <svg id="submit-spinner" class="hidden animate-spin h-5 w-5 text-white mr-2"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                    </svg>

                    <span id="submit-text">Kirim Jawaban</span>
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

    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('select[data-tom-select]').forEach(function(el) {
                new TomSelect(el, {
                    allowEmptyOption: true,
                    placeholder: '-- Pilih --'
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.querySelector('form');
            const submitButton = document.getElementById('submit-button');

            function showError(input, message) {
                const container = input.closest('.mb-4');
                if (!container) return;

                let error = container.querySelector('.realtime-error');
                if (!error) {
                    error = document.createElement('p');
                    error.classList.add('mt-1', 'text-sm', 'text-red-600', 'realtime-error');
                    container.appendChild(error);
                }
                error.textContent = message;
                input.classList.add('border-red-500');
            }

            function clearError(input) {
                const container = input.closest('.mb-4');
                if (!container) return;

                const error = container.querySelector('.realtime-error');
                if (error) error.remove();
                input.classList.remove('border-red-500');
            }

            function validateInput(input) {
                if (input.dataset.required !== undefined) {
                    const isFileInput = input.type === 'file';
                    const isEmpty = isFileInput ? input.files.length === 0 : !input.value.trim();

                    if (isEmpty) {
                        showError(input, 'Wajib diisi');
                        return false;
                    } else {
                        clearError(input);
                        return true;
                    }
                }
                return true;
            }

            function validateGroup(groupSelector, errorMessage) {
                const group = form.querySelector(groupSelector);
                if (!group) return true;

                const inputs = group.querySelectorAll('input');
                const isValid = Array.from(inputs).some(i => i.checked);
                const firstInput = inputs[0];

                if (!isValid) {
                    showError(firstInput, errorMessage);
                    return false;
                } else {
                    clearError(firstInput);
                    return true;
                }
            }

            function checkFormValidity() {
                let hasError = false;

                form.querySelectorAll('[data-required]').forEach(input => {
                    if (!validateInput(input)) hasError = true;
                });

                form.querySelectorAll('[data-required-radio]').forEach(group => {
                    const id = group.dataset.requiredRadio;
                    if (!validateGroup(`[data-required-radio="${id}"]`, 'Wajib dipilih')) hasError = true;
                });

                form.querySelectorAll('[data-required-checkbox]').forEach(group => {
                    const id = group.dataset.requiredCheckbox;
                    if (!validateGroup(`[data-required-checkbox="${id}"]`, 'Wajib dipilih')) hasError =
                        true;
                });

                // Validasi ukuran file
                form.querySelectorAll('input[type="file"]').forEach(input => {
                    const maxSize = input.dataset.maxSize ? parseInt(input.dataset.maxSize) : null;

                    if (maxSize && input.files.length > 0) {
                        const fileSize = input.files[0].size;

                        if (fileSize > maxSize) {
                            const maxMB = (maxSize / (1024 * 1024)).toFixed(2);
                            showError(input, `Ukuran file melebihi batas maksimal (${maxMB} MB)`);
                            hasError = true;
                        } else {
                            clearError(input);
                        }
                    }
                });

                submitButton.disabled = hasError;
                submitButton.classList.toggle('opacity-50', hasError);
                submitButton.classList.toggle('cursor-not-allowed', hasError);
            }

            // Event untuk input biasa
            form.querySelectorAll('[data-required]').forEach(input => {
                input.addEventListener('input', () => {
                    validateInput(input);
                    checkFormValidity();
                });
                input.addEventListener('blur', () => {
                    validateInput(input);
                    checkFormValidity();
                });
            });

            // Event untuk radio dan checkbox
            form.querySelectorAll('[data-required-radio], [data-required-checkbox]').forEach(group => {
                const type = group.dataset.requiredRadio !== undefined ? 'radio' : 'checkbox';
                const questionId = group.dataset.requiredRadio || group.dataset.requiredCheckbox;
                const inputs = group.querySelectorAll(`input[type="${type}"]`);

                inputs.forEach(input => {
                    input.addEventListener('change', () => {
                        validateGroup(`[data-required-${type}="${questionId}"]`,
                            'Wajib dipilih');
                        checkFormValidity();
                    });
                });
            });

            // Saat form di-submit
            form.addEventListener('submit', (e) => {
                let hasError = false;

                form.querySelectorAll('[data-required]').forEach(input => {
                    if (!validateInput(input)) hasError = true;
                });

                form.querySelectorAll('[data-required-radio]').forEach(group => {
                    const id = group.dataset.requiredRadio;
                    if (!validateGroup(`[data-required-radio="${id}"]`, 'Wajib dipilih')) hasError =
                        true;
                });

                form.querySelectorAll('[data-required-checkbox]').forEach(group => {
                    const id = group.dataset.requiredCheckbox;
                    if (!validateGroup(`[data-required-checkbox="${id}"]`, 'Wajib dipilih'))
                        hasError = true;
                });

                form.querySelectorAll('input[type="file"]').forEach(input => {
                    const maxSize = input.dataset.maxSize ? parseInt(input.dataset.maxSize) : null;

                    if (maxSize && input.files.length > 0) {
                        const fileSize = input.files[0].size;

                        if (fileSize > maxSize) {
                            const maxMB = (maxSize / (1024 * 1024)).toFixed(2);
                            showError(input, `Ukuran file melebihi batas maksimal (${maxMB} MB)`);
                            hasError = true;
                        }
                    }
                });

                if (hasError) {
                    e.preventDefault();
                }
            });

            checkFormValidity();
        });
    </script>

    <script>
        document.querySelector('form').addEventListener('submit', function() {
            const button = document.getElementById('submit-button');
            const spinner = document.getElementById('submit-spinner');
            const text = document.getElementById('submit-text');

            button.disabled = true;
            spinner.classList.remove('hidden');
            text.textContent = 'Sedang Mengirim Jawaban...';
        });
    </script>






</body>

</html>
