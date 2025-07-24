<!DOCTYPE html>
<html lang="id">

@include('themes.' . getActiveTheme() . '.components.frontend.partials.header')



<body class="min-h-screen text-gray-900"
    style="
        background-image: url('{{ optional($form->themeSetting)->pattern_url }}');
        background-color: {{ optional($form->themeSetting)->pattern_url ? optional($form->themeSetting)->background_color : '#f3f4f6' }};
        background-size: auto;
        background-repeat: repeat;">



    <div id="toast-container" class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 space-y-2 max-w-sm w-full">
    </div>

    <!-- Toast -->
    <div id="toast-copy-success"
        class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-emerald-500 text-white px-4 py-2 rounded shadow-lg text-sm hidden z-[9999]">
        Link berhasil disalin!
    </div>



    {{-- Header Bar --}}
    <header class="bg-white shadow-md sticky top-0 z-10">


        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">


            {{-- Kiri: Judul & Status --}}
            <div class="flex items-center space-x-3">
                <a href="{{ route('formulir.index') }}" class="text-gray-700 hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </a>

                <span class="text-lg font-semibold">Form Builder</span>

                {{-- Indikator Status --}}
                <span
                    class="text-sm px-2 py-1 rounded-full font-medium
        {{ $form->is_active ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ $form->is_active ? 'Published' : 'Draft' }}
                </span>
            </div>


            {{-- Kanan: Tombol Publikasi + Preview --}}
            <div class="flex items-center space-x-3">


                <!-- Tombol Tema -->
                <div class="relative group">
                    <button onclick="toggleThemeSidebar()"
                        class="inline-flex items-center px-2 py-1.5 text-sm font-medium text-gray-700 hover:text-indigo-600 rounded-lg transition border border-gray-300 hover:border-indigo-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.098 19.902a3.75 3.75 0 0 0 5.304 0l6.401-6.402M6.75 21A3.75 3.75 0 0 1 3 17.25V4.125C3 3.504 3.504 3 4.125 3h5.25c.621 0 1.125.504 1.125 1.125v4.072M6.75 21a3.75 3.75 0 0 0 3.75-3.75V8.197M6.75 21h13.125c.621 0 1.125-.504 1.125-1.125v-5.25c0-.621-.504-1.125-1.125-1.125h-4.072M10.5 8.197l2.88-2.88c.438-.439 1.15-.439 1.59 0l3.712 3.713c.44.44.44 1.152 0 1.59l-2.879 2.88M6.75 17.25h.008v.008H6.75v-.008Z" />
                        </svg>

                    </button>
                    <div
                        class="absolute left-1/2 top-full mt-2 -translate-x-1/2 scale-0 group-hover:scale-100 transition-all duration-150
        bg-gray-800 text-white text-xs rounded py-1 px-2 whitespace-nowrap shadow-md z-50">
                        Tema
                        <div class="absolute w-2 h-2 bg-gray-800 rotate-45 -top-1 left-1/2 -translate-x-1/2"></div>
                    </div>
                </div>

                {{-- Tombol Preview --}}
                <div class="relative group">
                    <button onclick="previewForm()"
                        class="inline-flex items-center px-2 py-1.5 text-sm font-medium text-gray-700 hover:text-indigo-600 rounded-lg transition border border-gray-300 hover:border-indigo-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </button>
                    <div
                        class="absolute left-1/2 top-full mt-2 -translate-x-1/2 scale-0 group-hover:scale-100 transition-all duration-150
        bg-gray-800 text-white text-xs rounded py-1 px-2 whitespace-nowrap shadow-md z-50">
                        Pratinjau
                        <div class="absolute w-2 h-2 bg-gray-800 rotate-45 -top-1 left-1/2 -translate-x-1/2"></div>
                    </div>
                </div>


                {{-- Tombol Copy Link --}}
                @if ($form->is_active)
                    <div class="relative group">
                        <button onclick="copyFormLink()"
                            class="inline-flex items-center px-2 py-1.5 text-sm font-medium text-gray-700 hover:text-indigo-600 rounded-lg transition border border-gray-300 hover:border-indigo-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622
                            1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                            </svg>
                        </button>
                        <div
                            class="absolute left-1/2 top-full mt-2 -translate-x-1/2 scale-0 group-hover:scale-100 transition-all duration-150
                bg-gray-800 text-white text-xs rounded py-1 px-2 whitespace-nowrap shadow-md z-50">
                            Salin Link
                            <div class="absolute w-2 h-2 bg-gray-800 rotate-45 -top-1 left-1/2 -translate-x-1/2"></div>
                        </div>
                    </div>



                    {{-- Tombol "Dipublikasikan" --}}
                    <div class="relative group">
                        <button onclick="openUnpublishModal()"
                            class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-green-700 bg-green-100 hover:bg-green-200 rounded-lg border border-green-300 transition">
                            Dipublikasikan
                        </button>
                        <div
                            class="absolute left-1/2 top-full mt-2 -translate-x-1/2 scale-0 group-hover:scale-100 transition-all duration-150
                bg-gray-800 text-white text-xs rounded py-1 px-2 whitespace-nowrap shadow-md z-50">
                            Nonaktifkan Formulir
                            <div class="absolute w-2 h-2 bg-gray-800 rotate-45 -top-1 left-1/2 -translate-x-1/2"></div>
                        </div>
                    </div>
                @else
                    {{-- Jika belum aktif, tombol aktifkan --}}
                    <button id="btn-publish"
                        class="flex items-center gap-2 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm">
                        Publikasikan
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                        </svg>
                    </button>
                @endif
            </div>

    </header>


    {{-- Main Content --}}
    <main class="py-6">
        <div class="max-w-3xl mx-auto px-4 space-y-6">

            @if ($form->header_image)
                <div id="header-image-preview"
                    class="overflow-hidden rounded-xl shadow mb-4 border border-gray-200 bg-white">

                    <!-- Gambar Header -->
                    <img src="{{ asset('storage/' . $form->header_image) }}" alt="Header Image"
                        class="w-full object-contain object-center rounded-t-xl">

                    <!-- Strip warna di bawah -->
                    <div id="header-color-strip" class="h-2 w-full"
                        style="background-color: {{ optional($form->themeSetting)->header_color ?? '#4f46e5' }};">
                    </div>
                </div>
            @endif





            {{-- Form Builder App --}}
            <div id="form-builder" data-form-id="{{ $form->uuid }}" data-form-slug="{{ $form->slug }}"
                data-title="{{ $form->title }}" data-description="{{ $form->description }}"
                data-questions='@json($questions)' class="bg-white p-6 rounded-xl shadow">
            </div>

        </div>



    </main>

    <!-- Modal Publish -->
    <div id="publish-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-xl">
            <h2 class="text-xl font-semibold mb-4">Publikasikan Formulir?</h2>
            <p class="text-gray-600">Formulir ini akan tersedia untuk publik. Lanjutkan?</p>

            <div class="mt-6 flex justify-end space-x-2">
                <button id="cancel-publish" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</button>
                <button id="confirm-publish"
                    class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Publikasikan</button>
            </div>
        </div>
    </div>

    <!-- Modal Berhasil -->
    <div id="success-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-xl">
            <h2 class="text-xl font-semibold mb-4">Berhasil Dipublikasikan!</h2>
            <p class="text-gray-600 mb-3">Formulir berhasil dipublikasikan. Berikut link-nya:</p>

            <div class="flex items-center mb-4">
                <input id="form-link" type="text" readonly
                    class="w-full border p-2 rounded bg-gray-100 text-sm" />
                <button id="copy-link"
                    class="ml-2 px-3 py-2 bg-green-500 text-white rounded hover:bg-green-600 text-sm">
                    Salin
                </button>
            </div>
            <textarea id="clipboard-fallback" class="hidden"></textarea>
            <div class="flex justify-end">
                <button id="close-success" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Modal Nonaktifkan -->
    <div id="modal-unpublish" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <h2 class="text-lg font-semibold mb-3">Nonaktifkan Formulir?</h2>
            <p class="text-sm text-gray-600 mb-4">Formulir akan tidak dapat diakses publik sampai diaktifkan kembali.
            </p>
            <div class="flex justify-end space-x-3">
                <button onclick="closeUnpublishModal()"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 text-sm">Batal</button>
                <form action="{{ route('admin.formulir.unpublish', $form->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">Nonaktifkan</button>
                </form>
            </div>
        </div>
    </div>


    <div id="theme-sidebar"
        class="fixed top-0 right-0 h-full w-80 bg-white shadow-xl transform translate-x-full transition-transform duration-300 ease-in-out z-50 border-l border-gray-100">
        <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h2 class="text-lg font-semibold text-gray-800">Pengaturan Tema</h2>
            <button onclick="toggleThemeSidebar()"
                class="text-gray-400 hover:text-gray-600 transition-colors duration-200 p-1 rounded-full hover:bg-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <div class="p-5 space-y-6 overflow-y-auto h-[calc(100%-120px)]">
            <!-- Bagian Gambar Header -->
            <div id="header-title-only" class="{{ $form->header_image ? '' : 'hidden' }} space-y-4">
                <label class="block text-sm font-medium text-gray-700">Gambar Header</label>

                <div class="relative">
                    @if ($form->header_image)
                        <img src="{{ Storage::url($form->header_image) }}" alt="Header saat ini"
                            class="w-full h-auto rounded-lg border border-gray-200">
                    @endif
                </div>

                <button id="delete-header-btn"
                    class="w-full px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 font-medium rounded-md shadow-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 flex items-center justify-center space-x-2">

                    <span>Hapus Header</span>
                </button>
            </div>


            <div id="header-upload-group" class="{{ $form->header_image ? 'hidden' : '' }}">
                <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Header</label>
                <div class="flex items-center justify-center w-full">
                    <label id="header-upload-label"
                        class="flex flex-col w-full h-32 border-2 border-dashed border-gray-300 hover:border-gray-400 rounded-lg cursor-pointer transition-all duration-200 hover:bg-gray-50">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-sm text-gray-500 mt-2">Klik untuk mengunggah gambar</p>
                        </div>
                        <input type="file" id="header-image-input" accept="image/*" class="hidden">
                    </label>
                    <div id="header-upload-inline-preview" class="mt-4 hidden">
                        <p class="text-sm text-gray-600 mb-2" id="inline-selected-file-name"></p>
                        <div class="overflow-hidden rounded-lg border border-gray-200">
                            <img id="inline-preview-image" src="#"
                                class="w-full object-cover object-center rounded-lg" alt="Preview gambar" />
                        </div>
                    </div>
                </div>

                <button id="save-theme-btn"
                    class="w-full mt-4 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md shadow-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Simpan Perubahan
                </button>
            </div>

            <!-- Pattern Background -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pola Latar Belakang</label>
                <div id="pattern-selector" class="grid grid-cols-3 gap-3">
                    <div class="relative">
                        <input type="radio" name="pattern_url" id="pattern_none" value=""
                            class="hidden peer"
                            {{ empty(optional($form->themeSetting)->pattern_url) ? 'checked' : '' }}>
                        <label for="pattern_none"
                            class="block cursor-pointer border border-gray-300 rounded-lg overflow-hidden peer-checked:ring-2 peer-checked:ring-indigo-500 transition-all duration-200 bg-gray-100 flex items-center justify-center h-16 text-sm text-gray-600">
                            Tanpa Pola
                        </label>
                    </div>


                    @foreach ($patterns as $pattern)
                        <div class="relative">
                            <input type="radio" name="pattern_url" id="pattern_{{ $pattern->id }}"
                                value="{{ $pattern->url }}" class="hidden peer"
                                {{ optional($form->themeSetting)->pattern_url == $pattern->url ? 'checked' : '' }}>
                            <label for="pattern_{{ $pattern->id }}"
                                class="block cursor-pointer border border-gray-300 rounded-lg overflow-hidden peer-checked:ring-2 peer-checked:ring-indigo-500 transition-all duration-200">
                                <img src="{{ $pattern->url }}" alt="{{ $pattern->name }}"
                                    class="w-full h-16 object-cover">
                            </label>
                        </div>
                    @endforeach
                </div>

                <button id="save-pattern-btn"
                    class="w-full mt-4 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md shadow-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Simpan Pola
                </button>

            </div>
        </div>





    </div>



    {{-- FormBuilder Styles --}}
    <link rel="stylesheet" href="{{ asset('modules/Formulir/public/js/main-KE2P0Ztj.css') }}">
    {{-- Vue FormBuilder --}}
    <script src="{{ asset('modules/Formulir/public/js/formbuilder.js') }}"></script>
    <script>
        window.formSlug = @json($form->slug);
    </script>
    <script>
        const formId = "{{ $form->uuid }}";
        const headerUploadUrl = "{{ route('formulir.updateHeader', ['form' => $form->uuid]) }}";
        const deleteHeaderUrl = "{{ route('formulir.deleteHeader', ['form' => $form->uuid]) }}";

        document.addEventListener('DOMContentLoaded', () => {
            // Inisialisasi elemen
            const publishModal = document.getElementById('publish-modal');
            const successModal = document.getElementById('success-modal');
            const formBuilder = document.getElementById('form-builder');

            // Tombol Publish
            document.getElementById('btn-publish')?.addEventListener('click', () => {
                publishModal.classList.remove('hidden');
            });

            // Batal publish
            document.getElementById('cancel-publish')?.addEventListener('click', () => {
                publishModal.classList.add('hidden');
            });

            // Konfirmasi publish
            document.getElementById('confirm-publish')?.addEventListener('click', async () => {
                try {
                    const response = await fetch(`/admin/formulir/${formId}/publish`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content
                        }
                    });

                    const data = await response.json();

                    if (response.ok) {
                        const newUrl = new URL(window.location.href);
                        newUrl.searchParams.set('published', 'true');
                        window.location.href = newUrl.toString();
                    } else {
                        alert(data.error || 'Gagal mempublikasikan.');
                    }
                } catch (error) {
                    alert('Terjadi kesalahan.');
                }
            });

            // Tutup modal sukses
            document.getElementById('close-success')?.addEventListener('click', () => {
                successModal.classList.add('hidden');
            });

            // Tombol salin link
            document.getElementById('copy-link')?.addEventListener('click', () => {
                const input = document.getElementById('form-link');
                input.select();
                input.setSelectionRange(0, 99999);

                try {
                    document.execCommand('copy');
                    showCopyToast();
                } catch (err) {
                    showCopyToast('Clipboard tidak didukung di browser ini.', true);
                }
            });

            // Tampilkan modal sukses jika published
            const url = new URL(window.location.href);
            if (url.searchParams.get('published') === 'true') {
                successModal.classList.remove('hidden');

                const formSlug = formBuilder?.dataset.formSlug;
                const input = document.getElementById('form-link');
                if (input && formSlug) {
                    input.value = `${window.location.origin}/formulir/${formSlug}`;
                }

                url.searchParams.delete('published');
                window.history.replaceState({}, document.title, url.toString());
            }
        });

        function showCopyToast(message = 'Link berhasil disalin!', isError = false) {
            const toast = document.getElementById('toast-copy-success');
            toast.textContent = message;
            toast.classList.remove('hidden', 'bg-emerald-500', 'bg-red-500');
            toast.classList.add(isError ? 'bg-red-500' : 'bg-emerald-500');

            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }

        function copyFormLink() {
            const link = `${window.location.origin}/formulir/${formSlug}`;

            if (navigator.clipboard?.writeText) {
                navigator.clipboard.writeText(link)
                    .then(() => showToast('Link formulir berhasil disalin!'))
                    .catch(() => fallbackCopy(link));
            } else {
                fallbackCopy(link);
            }
        }

        function previewForm() {
            const link = `${window.location.origin}/admin/formulir/${formSlug}/preview`;
            window.open(link, '_blank');
        }

        function fallbackCopy(text) {
            const input = document.createElement('textarea');
            input.value = text;
            input.style.position = 'fixed';
            input.style.top = '-1000px';
            document.body.appendChild(input);
            input.focus();
            input.select();

            try {
                const successful = document.execCommand('copy');
                showToast(successful ? 'Link formulir berhasil disalin!' : 'Gagal menyalin link.', successful ? 'success' :
                    'error');
            } catch (err) {
                showToast('Browser tidak mendukung salin otomatis.', 'error');
            }

            document.body.removeChild(input);
        }

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `
            px-4 py-2 rounded shadow text-sm text-white
            ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}
            animate-fade-in-down
        `;
            toast.innerText = message;

            const container = document.getElementById('toast-container');
            container.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Tambahkan animasi fade-in-down ke <head>
        const style = document.createElement('style');
        style.innerHTML = `
        @keyframes fade-in-down {
            0% { opacity: 0; transform: translateY(-10px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-down {
            animation: fade-in-down 0.3s ease-out;
        }
    `;
        document.head.appendChild(style);

        // Modal Unpublish
        function openUnpublishModal() {
            const modal = document.getElementById('modal-unpublish');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeUnpublishModal() {
            const modal = document.getElementById('modal-unpublish');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        // Toggle Sidebar Tema
        function toggleThemeSidebar() {
            document.getElementById('theme-sidebar').classList.toggle('translate-x-full');
        }

        // Preview gambar header sebelum upload
        document.getElementById('header-image-input').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.onload = function(event) {
                    let preview = document.getElementById('header-image-preview');
                    if (!preview) {
                        preview = document.createElement('div');
                        preview.id = 'header-image-preview';
                        preview.className =
                            'overflow-hidden rounded-xl shadow mb-4 border border-gray-200 bg-white';

                        const container = document.querySelector('main > div');
                        container.insertBefore(preview, container.firstChild);
                    }

                    const headerColor = "{{ optional($form->themeSetting)->header_color ?? '#4f46e5' }}";

                    preview.innerHTML = `
        <img src="${event.target.result}" class="w-full object-contain object-center rounded-t-xl">
        <div class="h-2 w-full" style="background-color: ${headerColor};"></div>
    `;



                    // === Preview di dalam area upload (sidebar)
                    const inlinePreview = document.getElementById('header-upload-inline-preview');
                    const inlineImage = document.getElementById('inline-preview-image');
                    const inlineFileName = document.getElementById('inline-selected-file-name');
                    const uploadLabel = document.getElementById('header-upload-label');

                    if (inlinePreview && inlineImage && inlineFileName && uploadLabel) {
                        inlineImage.src = event.target.result;
                        inlineFileName.textContent = `Gambar dipilih: ${file.name}`;
                        inlinePreview.classList.remove('hidden');
                        uploadLabel.classList.add('hidden'); // sembunyikan kotak upload
                    } else {
                        console.warn("Elemen preview sidebar tidak ditemukan");
                    }
                };

                reader.readAsDataURL(file);
            } else {
                showToast('Silakan pilih file gambar yang valid.', 'error');
            }
        });



        // Simpan header image
        document.getElementById('save-theme-btn').addEventListener('click', function() {
            const fileInput = document.getElementById('header-image-input');
            const file = fileInput.files[0];

            if (!file) {
                showToast('Silakan pilih gambar terlebih dahulu.', 'error');
                return;
            }

            const formData = new FormData();
            formData.append('header_image', file);

            fetch(headerUploadUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.header) {
                        showToast('Header berhasil diperbarui!');
                        document.getElementById('header-upload-group').style.display = 'none';
                        document.getElementById('header-title-only').style.display = 'block';

                        // Update gambar di sidebar
                        const headerImg = document.querySelector('#header-title-only img');
                        if (headerImg) {
                            headerImg.src = data.header;
                        }

                        const deleteBtn = document.getElementById('delete-header-btn');
                        if (deleteBtn) {
                            deleteBtn.style.display = 'block';
                        }
                    } else {
                        showToast('Gagal memperbarui header.', 'error');
                    }
                })
                .catch(err => {
                    console.error('Gagal update header', err);
                    showToast('Terjadi kesalahan saat menyimpan.', 'error');
                });
        });


        document.getElementById('delete-header-btn').addEventListener('click', function() {
            fetch(deleteHeaderUrl, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Hapus tampilan gambar preview
                        const preview = document.getElementById('header-image-preview');
                        if (preview) preview.remove();

                        // Sembunyikan tombol hapus
                        const deleteBtn = document.getElementById('delete-header-btn');
                        if (deleteBtn) deleteBtn.style.display = 'none';
                        // Tampilkan input upload
                        document.getElementById('header-upload-group').style.display = 'block';
                        // Sembunyikan label-only
                        document.getElementById('header-title-only').style.display = 'none';
                        // Tampilkan toast sukses
                        showToast('Header berhasil dihapus!');
                    } else {
                        showToast('Gagal menghapus header image.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Terjadi kesalahan saat menghapus header.');
                });
        });
    </script>

    <script>
        document.querySelectorAll('input[name="pattern_url"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                const url = this.value;
                if (url) {
                    document.body.style.backgroundImage = `url('${url}')`;
                } else {
                    document.body.style.backgroundImage = 'none';
                    document.body.style.backgroundColor = '#f3f4f6';
                }
            });
        });
    </script>

    <script>
        document.getElementById('save-pattern-btn').addEventListener('click', function() {
            const selectedPattern = document.querySelector('input[name="pattern_url"]:checked')?.value;
            const formId = "{{ $form->uuid }}";

            fetch(`/admin/formulir/${formId}/save-theme`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        pattern_url: selectedPattern
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('Pola latar berhasil disimpan!', 'success');
                    } else {
                        showToast('Gagal menyimpan pola latar.', 'error');
                    }
                })
                .catch(() => {
                    showToast('Terjadi kesalahan saat mengirim data.', 'error');
                });
        });
    </script>







</body>

</html>
