{{-- resources/views/modules/formulir/jawaban.blade.php --}}
<x-header>{{ $judul ?? 'Jawaban' }}</x-header>

<div class="content-wrapper">
    <!-- Navigation Bar Replacement -->
    <div class="navigation-bar sticky-top bg-white shadow-sm py-2 mb-4">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-secondary mr-2">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h5 class="mb-0 text-primary">{{ $judul ?? 'Detail Jawaban' }}</h5>
                </div>

                <div class="action-buttons">
                    <button class="btn btn-sm btn-outline-primary mr-2" id="analytics-btn">
                        <i class="fas fa-chart-pie mr-1"></i> Analitik
                    </button>
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

                    <!-- Navigation and Status Card -->
                    <div class="card card-navigation mb-4 shadow-sm">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <button class="btn btn-outline-primary btn-navigation" id="prev-btn">
                                    <i class="fas fa-chevron-left mr-2"></i>Sebelumnya
                                </button>

                                <div class="text-center px-3">
                                    <div class="text-muted small">Respon saat ini</div>
                                    <div class="font-weight-bold">
                                        <span id="currentIndex">1</span> dari <span
                                            id="totalCount">{{ $responses->count() }}</span>
                                    </div>
                                </div>

                                <button class="btn btn-outline-primary btn-navigation" id="next-btn">
                                    Selanjutnya<i class="fas fa-chevron-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Response Content -->
                    <div id="response-content" class="response-container">
                        {{-- Response data will be loaded here --}}
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>

<x-footer />

<style>
    .card-navigation {
        border-radius: 10px;
        border: 1px solid #e0e0e0;
    }

    .btn-navigation {
        border-radius: 8px;
        min-width: 120px;
    }

    .response-container {
        transition: opacity 0.3s ease;
    }

    .response-card {
        border-radius: 10px;
        border: none;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
    }

    .response-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #eee;
        border-radius: 10px 10px 0 0 !important;
        padding: 1rem 1.5rem;
    }

    .answer-item {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f0f0f0;
    }

    .answer-item:last-child {
        border-bottom: none;
    }

    .question-text {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .answer-text {
        color: #34495e;
        line-height: 1.6;
        padding: 0.75rem;
        background-color: #f9f9f9;
        border-radius: 6px;
        margin-top: 0.5rem;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #7f8c8d;
    }

    @media (max-width: 768px) {
        .btn-navigation {
            min-width: auto;
            padding: 0.375rem 0.75rem;
        }

        .answer-item {
            padding: 1rem;
        }
    }
</style>

<script>
    const responses = @json($responses);
    let current = 0;

    function renderResponse(index) {
        const res = responses[index];
        const container = document.getElementById('response-content');

        if (!res) {
            container.innerHTML = `
                <div class="card response-card">
                    <div class="empty-state">
                        <i class="far fa-file-alt fa-3x mb-3"></i>
                        <h5>Tidak ada data respon</h5>
                    </div>
                </div>
            `;
            return;
        }

        let html = `
            <div class="card response-card">
                <div class="card-header response-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Respon #${index + 1}</h5>
                    </div>
                    <div class="text-muted small">
                        <i class="far fa-clock mr-1"></i> ${formatDate(res.created_at)}
                    </div>
                </div>
                <div class="card-body p-0">
        `;

        if (res.answers && res.answers.length > 0) {
            res.answers.forEach((ans, i) => {
                html += `
                    <div class="answer-item ${i === res.answers.length - 1 ? 'border-bottom-0' : ''}">
                        <div class="question-text">${ans.question?.question_text || 'Pertanyaan tidak tersedia'}</div>
                        <div class="answer-text">${renderAnswer(ans.answer)}</div>
                    </div>
                `;
            });
        } else {
            html += `
                <div class="answer-item">
                    <div class="text-muted">Tidak ada jawaban tersedia untuk respon ini</div>
                </div>
            `;
        }

        html += `</div></div>`;

        // Fade in effect
        container.style.opacity = 0;
        setTimeout(() => {
            container.innerHTML = html;
            container.style.opacity = 1;
        }, 150);

        // Update navigation
        document.getElementById('currentIndex').textContent = index + 1;
        document.getElementById('prev-btn').disabled = index === 0;
        document.getElementById('next-btn').disabled = index === responses.length - 1;
    }

    function renderAnswer(answer) {
        if (!answer) return '<span class="text-muted">(Tidak diisi)</span>';

        try {
            const parsed = JSON.parse(answer);
            if (Array.isArray(parsed)) {
                return parsed.map(item => item || '(Kosong)').join('<br>');
            }
            return parsed;
        } catch (e) {
            return answer || '<span class="text-muted">(Tidak diisi)</span>';
        }
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    // Navigation event listeners
    document.getElementById('prev-btn').addEventListener('click', () => {
        if (current > 0) {
            current--;
            renderResponse(current);
        }
    });

    document.getElementById('next-btn').addEventListener('click', () => {
        if (current < responses.length - 1) {
            current++;
            renderResponse(current);
        }
    });

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            document.getElementById('prev-btn').click();
        } else if (e.key === 'ArrowRight') {
            document.getElementById('next-btn').click();
        }
    });

    // Initial render
    renderResponse(current);
</script>
<style>
    .navigation-bar {
        z-index: 1020;
        border-bottom: 1px solid #e0e0e0;
    }

    .action-buttons .btn {
        border-radius: 6px;
        font-size: 0.85rem;
        padding: 0.35rem 0.75rem;
    }

    /* Optional: Add transition for buttons */
    .action-buttons .btn:hover {
        transform: translateY(-1px);
        transition: all 0.2s ease;
    }

    @media (max-width: 768px) {
        .navigation-bar h5 {
            font-size: 1.1rem;
        }

        .action-buttons .btn span {
            display: none;
        }

        .action-buttons .btn i {
            margin-right: 0 !important;
        }
    }
</style>

<script>
    // Button functionalities
    document.getElementById('analytics-btn').addEventListener('click', function() {
        // Implement analytics modal or page redirect
        console.log('Analytics button clicked');

    });

    document.getElementById('export-btn').addEventListener('click', function() {
        // Trigger export functionality
        console.log('Export button clicked');

    });
</script>
