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
                            <div class="mb-4">
                                <div class="upload-container relative">
                                    <!-- Hidden file input -->
                                    <input type="file" name="question[{{ $q->id }}]"
                                        id="file-upload-{{ $q->id }}"
                                        @if ($q->is_required) required data-required @endif
                                        @if ($q->file_max_size) data-max-size="{{ $q->file_max_size }}" @endif
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                        accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt">

                                    <!-- Upload box (label) -->
                                    <label for="file-upload-{{ $q->id }}"
                                        class="upload-box block p-6 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-400 transition-colors duration-200">
                                        <div class="text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="mx-auto h-12 w-12 text-gray-400" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                            </svg>
                                            <h3 class="mt-2 text-sm font-medium text-gray-900">
                                                <span
                                                    class="relative cursor-pointer rounded-md font-semibold text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                                    Upload a file
                                                </span>
                                                or drag and drop
                                            </h3>
                                            <p class="mt-1 text-xs text-gray-500">
                                                @if ($q->file_max_size)
                                                    {{ strtoupper(implode(', ', ['PNG', 'JPG', 'PDF', 'DOC', 'XLS', 'PPT'])) }}
                                                    up to {{ number_format($q->file_max_size / 1024 / 1024, 2) }}MB
                                                @else
                                                    {{ strtoupper(implode(', ', ['PNG', 'JPG', 'PDF', 'DOC', 'XLS', 'PPT'])) }}
                                                @endif
                                            </p>
                                        </div>
                                    </label>

                                    <!-- Preview container -->
                                    <div id="preview-container-{{ $q->id }}"
                                        class="preview-container mt-4 hidden">
                                        <div
                                            class="preview-content flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                            <div class="flex items-center space-x-4">
                                                <!-- File icon or image preview -->
                                                <div id="file-icon-{{ $q->id }}"
                                                    class="file-icon flex-shrink-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-10 w-10 text-gray-400" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                </div>

                                                <!-- File info -->
                                                <div class="file-info">
                                                    <p id="file-name-{{ $q->id }}"
                                                        class="text-sm font-medium text-gray-900 truncate max-w-xs"></p>
                                                    <p id="file-size-{{ $q->id }}"
                                                        class="text-xs text-gray-500"></p>
                                                </div>
                                            </div>

                                            <!-- ❌ Remove button (TIDAK di dalam label) -->
                                            <button type="button" class="remove-file text-red-500 hover:text-red-700"
                                                data-target="{{ $q->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Progress bar (hidden by default) -->
                                        <div id="progress-bar-{{ $q->id }}" class="progress-bar mt-2 hidden">
                                            <div class="w-full bg-green-300 rounded-full h-2.5">
                                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if ($q->file_max_size)
                                    <p class="text-sm text-gray-500 mt-1">
                                        Maksimal: {{ number_format($q->file_max_size / 1024 / 1024, 2) }} MB
                                    </p>
                                @endif
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

            /* ============================
               📌 FUNGSI HELPER VALIDASI
            ============================ */
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

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return `${(bytes / Math.pow(k, i)).toFixed(2)} ${sizes[i]}`;
            }

            function getFileIconClass(filename) {
                const ext = filename.split('.').pop().toLowerCase();
                if (['pdf'].includes(ext)) return 'bg-red-100';
                if (['doc', 'docx'].includes(ext)) return 'bg-blue-100';
                if (['xls', 'xlsx'].includes(ext)) return 'bg-green-100';
                if (['ppt', 'pptx'].includes(ext)) return 'bg-orange-100';
                return 'bg-gray-100';
            }

            function getFileIconPath(filename) {
                const ext = filename.split('.').pop().toLowerCase();
                if (ext === 'pdf')
                    return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />';
                if (['doc', 'docx'].includes(ext))
                    return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />';
                if (['xls', 'xlsx'].includes(ext))
                    return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />';
                if (['ppt', 'pptx'].includes(ext))
                    return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />';
                return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />';
            }

            function checkFormValidity() {
                let hasError = false;
                const form = document.querySelector('form');

                // Validasi input wajib diisi
                form.querySelectorAll('[data-required]').forEach(input => {
                    if (input.dataset.required !== undefined) {
                        const isFile = input.type === 'file';
                        const isEmpty = isFile ? input.files.length === 0 : !input.value.trim();
                        if (isEmpty) {
                            showError(input, 'Wajib diisi');
                            hasError = true;
                        } else {
                            clearError(input);
                        }
                    }
                });

                // Validasi ukuran file
                form.querySelectorAll('input[type="file"]').forEach(input => {
                    const maxSize = input.dataset.maxSize ? parseInt(input.dataset.maxSize) : null;
                    if (maxSize && input.files.length > 0) {
                        const fileSize = input.files[0].size;
                        if (fileSize > maxSize) {
                            const maxMB = (maxSize / (1024 * 1024)).toFixed(2);
                            showError(input, `Ukuran file melebihi ${maxMB} MB`);
                            hasError = true;
                        }
                    }
                });

                // Toggle tombol submit
                const submitButton = document.getElementById('submit-button');
                submitButton.disabled = hasError;
                submitButton.classList.toggle('opacity-50', hasError);
                submitButton.classList.toggle('cursor-not-allowed', hasError);
            }

            /* ============================
               📌 HANDLE FILE UPLOAD
            ============================ */
            document.querySelectorAll('input[type="file"]').forEach(input => {
                const qid = input.id.split('-')[2];
                const preview = document.getElementById(`preview-container-${qid}`);
                const iconBox = document.getElementById(`file-icon-${qid}`);
                const nameBox = document.getElementById(`file-name-${qid}`);
                const sizeBox = document.getElementById(`file-size-${qid}`);
                const progressBar = document.getElementById(`progress-bar-${qid}`);

                // 👉 Saat file dipilih
                input.addEventListener('change', function() {
                    if (!this.files.length) return;
                    const file = this.files[0];

                    // ✅ Cek ukuran file
                    const maxSize = this.dataset.maxSize ? parseInt(this.dataset.maxSize) : null;
                    if (maxSize && file.size > maxSize) {
                        const maxMB = (maxSize / (1024 * 1024)).toFixed(2);
                        showError(input, `Ukuran file melebihi ${maxMB} MB`);
                        return;
                    }

                    // ✅ Tampilkan preview
                    preview.classList.remove('hidden');
                    nameBox.textContent = file.name;
                    sizeBox.textContent = formatFileSize(file.size);

                    if (file.type.match('image.*')) {
                        const reader = new FileReader();
                        reader.onload = e => iconBox.innerHTML =
                            `<img src="${e.target.result}" class="h-10 w-10 object-cover rounded">`;
                        reader.readAsDataURL(file);
                    } else {
                        iconBox.innerHTML = `
                  <div class="${getFileIconClass(file.name)} flex items-center justify-center h-10 w-10 rounded">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          ${getFileIconPath(file.name)}
                      </svg>
                  </div>`;
                    }

                    // ✅ Simulasi progress bar (nanti bisa ganti AJAX)
                    if (progressBar) {
                        progressBar.classList.remove('hidden');
                        const bar = progressBar.querySelector('div > div');
                        let width = 0;
                        const interval = setInterval(() => {
                            if (width >= 100) {
                                clearInterval(interval);
                            } else {
                                width += 10;
                                bar.style.width = width + '%';
                            }
                        }, 100);
                    }

                    clearError(input);
                    checkFormValidity();
                });

                // 👉 Drag & Drop
                const uploadBox = input.closest('.upload-container').querySelector('.upload-box');
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    uploadBox.addEventListener(eventName, e => {
                        e.preventDefault();
                        e.stopPropagation();
                    });
                });

                ['dragenter', 'dragover'].forEach(eventName => {
                    uploadBox.addEventListener(eventName, () => uploadBox.classList.add(
                        'border-blue-500', 'bg-blue-50'));
                });
                ['dragleave', 'drop'].forEach(eventName => {
                    uploadBox.addEventListener(eventName, () => uploadBox.classList.remove(
                        'border-blue-500', 'bg-blue-50'));
                });

                uploadBox.addEventListener('drop', e => {
                    input.files = e.dataTransfer.files;
                    input.dispatchEvent(new Event('change'));
                });
            });

            /* ============================
               📌 REMOVE FILE
            ============================ */
            document.querySelectorAll('.remove-file').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation(); // ✅ Hentikan bubbling
                    e.stopImmediatePropagation(); // ✅ Hentikan event lanjut ke label/input

                    const qid = this.dataset.target;
                    const input = document.getElementById(`file-upload-${qid}`);
                    const preview = document.getElementById(`preview-container-${qid}`);

                    // ✅ Kosongkan file yang dipilih
                    input.value = "";

                    // ✅ Hide preview
                    preview.classList.add('hidden');

                    // ✅ Kalau required, munculkan pesan error lagi
                    if (input.hasAttribute('required')) {
                        showError(input, 'Wajib diisi');
                    } else {
                        clearError(input);
                    }

                    // ✅ Cek ulang form
                    checkFormValidity();
                });
            });





            /* ============================
               📌 SUBMIT FORM HANDLER
            ============================ */
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                checkFormValidity();
                const btn = document.getElementById('submit-button');
                const spinner = document.getElementById('submit-spinner');
                const text = document.getElementById('submit-text');

                if (btn.disabled) {
                    e.preventDefault();
                    return;
                }

                btn.disabled = true;
                spinner.classList.remove('hidden');
                text.textContent = 'Sedang Mengirim Jawaban...';
            });

            // ✅ Inisialisasi awal
            checkFormValidity();
        });

        function bindFileInputEvents(input) {
            const qid = input.id.split('-')[2];
            const preview = document.getElementById(`preview-container-${qid}`);
            const iconBox = document.getElementById(`file-icon-${qid}`);
            const nameBox = document.getElementById(`file-name-${qid}`);
            const sizeBox = document.getElementById(`file-size-${qid}`);
            const progressBar = document.getElementById(`progress-bar-${qid}`);
            const uploadBox = input.closest('.upload-container').querySelector('.upload-box');

            // ✅ Event change (saat file dipilih)
            input.addEventListener('change', function() {
                if (!this.files.length) return;
                const file = this.files[0];

                // cek ukuran file
                const maxSize = this.dataset.maxSize ? parseInt(this.dataset.maxSize) : null;
                if (maxSize && file.size > maxSize) {
                    const maxMB = (maxSize / (1024 * 1024)).toFixed(2);
                    showError(input, `Ukuran file melebihi ${maxMB} MB`);
                    return;
                }

                // preview file
                preview.classList.remove('hidden');
                nameBox.textContent = file.name;
                sizeBox.textContent = formatFileSize(file.size);

                if (file.type.match('image.*')) {
                    const reader = new FileReader();
                    reader.onload = e => iconBox.innerHTML =
                        `<img src="${e.target.result}" class="h-10 w-10 object-cover rounded">`;
                    reader.readAsDataURL(file);
                } else {
                    iconBox.innerHTML = `
                <div class="${getFileIconClass(file.name)} flex items-center justify-center h-10 w-10 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        ${getFileIconPath(file.name)}
                    </svg>
                </div>`;
                }

                // progress bar dummy
                if (progressBar) {
                    progressBar.classList.remove('hidden');
                    const bar = progressBar.querySelector('div > div');
                    let width = 0;
                    const interval = setInterval(() => {
                        if (width >= 100) {
                            clearInterval(interval);
                        } else {
                            width += 10;
                            bar.style.width = width + '%';
                        }
                    }, 100);
                }

                clearError(input);
                checkFormValidity();
            });

            // ✅ Event drag & drop
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                uploadBox.addEventListener(eventName, e => {
                    e.preventDefault();
                    e.stopPropagation();
                });
            });

            ['dragenter', 'dragover'].forEach(eventName => {
                uploadBox.addEventListener(eventName, () => uploadBox.classList.add('border-blue-500',
                    'bg-blue-50'));
            });
            ['dragleave', 'drop'].forEach(eventName => {
                uploadBox.addEventListener(eventName, () => uploadBox.classList.remove('border-blue-500',
                    'bg-blue-50'));
            });

            uploadBox.addEventListener('drop', e => {
                input.files = e.dataTransfer.files;
                input.dispatchEvent(new Event('change'));
            });
        }
    </script>


    <style>
        .upload-container {
            position: relative;
        }

        .upload-box {
            transition: all 0.3s ease;
        }

        .upload-box:hover {
            border-color: #3b82f6;
            background-color: #f8fafc;
        }

        .preview-container {
            transition: all 0.3s ease;
        }

        .file-icon img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }

        .remove-file {
            transition: all 0.2s ease;
        }

        .remove-file:hover {
            transform: scale(1.1);
        }

        .remove-file {
            position: relative;
            z-index: 50;
            pointer-events: auto;
        }
    </style>



</body>

</html>
