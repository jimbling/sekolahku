<div class="row">
    @forelse($formulirs as $formulir)
        <div id="form-card-{{ $formulir->id }}" class="col-md-6 col-lg-4 mb-4">
            <div class="card card-hover border-0 shadow-lg rounded-lg overflow-hidden h-100">

                {{-- Header --}}
                <div class="position-relative bg-gradient-primary text-white px-3 pt-3 pb-4" style="height: 80px;">
                    {{-- Judul --}}
                    <h5 class="card-title mb-0 font-weight-bold text-truncate"
                        style="max-width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ $formulir->title }}
                    </h5>

                    {{-- Tanggal di kiri bawah --}}
                    <small class="position-absolute" style="bottom: 8px; left: 16px; font-size: 0.8rem;">
                        <i class="far fa-calendar-alt mr-1"></i>
                        {{ \Carbon\Carbon::parse($formulir->created_at)->translatedFormat('d F Y H:i') }}

                    </small>

                    {{-- Tombol hapus kanan atas --}}
                    <button class="btn btn-sm btn-outline-light position-absolute" title="Hapus"
                        style="top: 8px; right: 8px;"
                        onclick="confirmDelete('{{ route('formulir.destroy', $formulir->id) }}', 'form-card-{{ $formulir->id }}')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                {{-- Body --}}
                <div class="card-body d-flex flex-column">
                    <p class="text-muted mb-4 flex-grow-1">{{ Str::limit($formulir->description, 100) }}</p>

                    <div class="d-flex justify-content-between align-items-center border-top pt-3">
                        <!-- Tombol Kelola -->
                        <a href="{{ route('formulir.builder', $formulir->uuid) }}"
                            class="btn btn-sm btn-warning rounded-pill px-3 shadow-sm">
                            <i class="fas fa-tools mr-1"></i> Kelola
                        </a>

                        <!-- Grup kanan: Jawaban + Copy -->
                        <div class="d-flex align-items-center gap-2">
                            <!-- Tombol Jawaban + Badge -->
                            <a href="{{ route('formulir.jawaban', $formulir->uuid) }}"
                                class="btn btn-sm btn-outline-info rounded-pill px-3 shadow-sm d-flex align-items-center">
                                <i class="fas fa-list-alt mr-2"></i>
                                <span class="mr-2">Jawaban</span>
                                <span class="badge badge-danger badge-pill">{{ $formulir->responses_count }}</span>
                            </a>

                            <!-- Tombol Copy Link -->
                            <button type="button"
                                class="btn btn-sm btn-outline-secondary rounded-circle shadow-sm ml-2"
                                onclick="copyToClipboard('{{ url('/formulir/' . $formulir->slug) }}')"
                                title="Salin Link">
                                <i class="fas fa-link"></i>
                            </button>
                        </div>
                    </div>


                    <div class="mt-3 d-flex flex-wrap justify-content-between gap-2">

                        @if ($formulir->google_sheet_id)
                            {{-- Lihat Sheet --}}
                            <a href="https://docs.google.com/spreadsheets/d/{{ $formulir->google_sheet_id }}"
                                target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 shadow-sm">
                                <i class="far fa-file-excel mr-1"></i> Lihat Spreadsheet
                            </a>

                            {{-- Tombol Sinkronkan --}}
                            <form method="POST" action="{{ route('formulir.syncGoogleSheet', $formulir->uuid) }}"
                                class="sync-google-sheet-form">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-info rounded-pill px-3 shadow-sm">
                                    <i class="fas fa-sync-alt mr-1"></i> Sinkron Sheet
                                </button>
                            </form>
                        @else
                            {{-- Tombol Hubungkan Google Sheet --}}
                            <form method="POST" action="{{ route('formulir.connectGoogleSheet', $formulir->uuid) }}"
                                class="connect-google-sheet-form">
                                @csrf
                                <button type="submit"
                                    class="btn btn-sm btn-outline-secondary rounded-pill px-3 shadow-sm">
                                    <i class="fas fa-plug mr-1"></i> Hubungkan Google Sheet
                                </button>
                            </form>
                        @endif

                    </div>

                </div>

            </div>
        </div>
    @empty
        {{-- Kosong --}}
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center py-5">
                    <i class="fas fa-file-alt fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted">Belum ada formulir</h4>
                    <p class="text-muted">Mulai dengan membuat formulir baru</p>
                    <button type="button" class="btn btn-primary btn-md shadow-sm" data-toggle="modal"
                        data-target="#createFormModal">
                        <i class="fas fa-plus-circle mr-2"></i> Buat Formulir Baru
                    </button>

                </div>
            </div>
        </div>
    @endforelse
</div>
