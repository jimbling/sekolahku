<x-header>Analitik Formulir</x-header>

<div class="content-wrapper">
    <div class="navigation-bar sticky-top bg-white shadow-sm py-2 mb-4">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-secondary mr-2">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h5 class="mb-0 text-primary">{{ $judul ?? 'Analitik Jawaban' }}</h5>
                </div>

                <div class="action-buttons">

                    <button class="btn btn-sm btn-success" id="export-btn">
                        <i class="fas fa-file-excel mr-1"></i> Export
                    </button>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">

                    <!-- Header Informasi Utama -->
                    <div class="card analytics-header mb-4">
                        <div class="card-body">
                            <h2 class="form-title">{{ $form->title }}</h2>

                            <div class="stats-grid">
                                <!-- Statistik Utama -->
                                <div class="stat-card">
                                    <div class="stat-value">{{ $totalResponses }}</div>
                                    <div class="stat-label">Total Respon</div>
                                </div>

                                <div class="stat-card">
                                    <div class="stat-value">{{ $totalQuestions }}</div>
                                    <div class="stat-label">Pertanyaan</div>
                                </div>

                                <div class="stat-card">
                                    <div class="stat-value">{{ $percentageFull }}%</div>
                                    <div class="stat-label">Kelengkapan</div>
                                </div>

                                <div class="stat-card">
                                    <div class="stat-value">
                                        @if ($lastSubmit)
                                            {{ \Carbon\Carbon::parse($lastSubmit)->translatedFormat('d M Y') }}
                                        @else
                                            -
                                        @endif
                                    </div>
                                    <div class="stat-label">Update Terakhir</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Visualisasi Data -->
                    <div class="row">
                        <!-- Grafik Kelengkapan -->
                        <div class="col-md-6 mb-4">
                            <div class="card data-visualization">
                                <div class="card-body">
                                    <h5 class="section-title">📊 Tingkat Kelengkapan</h5>
                                    <div class="completion-chart">
                                        <div class="chart-bar" style="width: {{ $percentageFull }}%">
                                            <span>{{ $percentageFull }}%</span>
                                        </div>
                                    </div>
                                    <div class="chart-legend">
                                        <span class="full-answers">{{ $fullyAnswered }} respon lengkap</span>
                                        <span class="partial-answers">{{ $totalResponses - $fullyAnswered }} respon
                                            tidak
                                            lengkap</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Statistik Upload -->
                        @if ($uploadCount > 0)
                            <div class="col-md-6 mb-4">
                                <div class="card data-visualization">
                                    <div class="card-body">
                                        <h5 class="section-title">📁 Data Unggahan</h5>
                                        <div class="upload-stats">
                                            <div class="upload-stat">
                                                <div class="stat-icon">📦</div>
                                                <div>
                                                    <div class="stat-number">{{ $uploadCount }}</div>
                                                    <div class="stat-desc">Total File</div>
                                                </div>
                                            </div>
                                            <div class="upload-stat">
                                                <div class="stat-icon">💾</div>
                                                <div>
                                                    <div class="stat-number">
                                                        {{ number_format($uploadSize / 1024 / 1024, 2) }}
                                                    </div>
                                                    <div class="stat-desc">MB Total Ukuran</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Analisis Pertanyaan -->
                    <h3 class="h5 font-weight-bold mb-4">🔍 Analisis Per Pertanyaan</h3>

                    <div class="row">
                        @foreach ($analytics as $q)
                            <div class="col-12 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-header d-flex justify-content-between align-items-start">
                                        <div>
                                            <h5 class="mb-1">
                                                <span class="badge badge-primary mr-2">{{ $loop->iteration }}</span>
                                                {{ $q['text'] }}
                                            </h5>
                                            <small class="text-muted">Jenis: {{ ucfirst($q['type']) }}</small>
                                        </div>
                                        <div class="text-right small text-muted">
                                            <div>{{ $q['answered'] }} dijawab</div>
                                            <div>{{ $q['skipped'] }} dilewati</div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        @if (count($q['options']))
                                            @foreach ($q['options'] as $opt)
                                                <div class="mb-3">
                                                    <div class="d-flex justify-content-between">
                                                        <span>{{ $opt['text'] }}</span>
                                                        <span class="font-weight-bold text-primary">{{ $opt['count'] }}
                                                            ({{ $opt['percentage'] }}%)
                                                        </span>
                                                    </div>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-info"
                                                            style="width: {{ $opt['percentage'] }}%;"
                                                            aria-valuenow="{{ $opt['percentage'] }}" aria-valuemin="0"
                                                            aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-muted mb-0">
                                                Tipe pertanyaan ini tidak memiliki pilihan untuk dianalisis.
                                            </p>
                                        @endif

                                        <div class="text-right text-muted small mt-3">
                                            @if ($q['skipped'] > 0)
                                                Dilewati oleh {{ $q['skipped'] }} responden
                                            @else
                                                Semua responden menjawab pertanyaan ini
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>



                </div>
            </div>
        </div>
    </section>
</div>

<x-footer />
