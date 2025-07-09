    <x-header>{{ $judul }}</x-header>
    <div class="content-wrapper">
        <x-breadcrumb>{{ $judul }}</x-breadcrumb>
        @php
            $disqusDipilih = $settings->firstWhere('key', 'komentar_engine')?->setting_value === 'disqus';
        @endphp

        @if ($disqusDipilih)
            <div class="alert alert-danger alert-dismissible fade show mx-3 mt-2" role="alert">
                <strong>Perhatian!</strong> Anda sedang menggunakan sistem komentar <strong>Disqus</strong>.
                Disqus versi gratis dapat menampilkan iklan yang <strong>tidak relevan atau sensitif</strong>.
                Pertimbangkan untuk menggunakan sistem komentar bawaan (native) demi kenyamanan pengguna.
            </div>
        @endif

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="penggunaTabel" class="table table-sm table-striped table-hover w-100">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%; text-align: center; vertical-align: middle;">No
                                                </th>
                                                <th style="width: 12%; text-align: center;">Aksi</th>
                                                <th style="width: 28%;">Nama Pengaturan</th>
                                                <th style="width: 55%;">Pengaturan Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($settings as $index => $setting)
                                                <tr>
                                                    <td style="text-align: center; vertical-align: middle;">
                                                        {{ $index + 1 }}
                                                    </td>
                                                    <td style="text-align: center; vertical-align: middle;">
                                                        @if ($setting->modal_type !== 'upload')
                                                            <button class="btn btn-xs btn-primary mr-1"
                                                                onclick="openEditModal({{ $setting->id }}, '{{ $setting->modal_type }}', '{{ $setting->key }}')">
                                                                <i class='far fa-edit'></i>
                                                            </button>
                                                        @else
                                                            <button class="btn btn-xs btn-info mr-1"
                                                                onclick="openUploadModal({{ $setting->id }})">
                                                                <i class='fas fa-cloud-upload-alt'></i>
                                                            </button>
                                                            <button class="btn btn-xs btn-success"
                                                                onclick="openViewModal('{{ $setting->setting_value }}')">
                                                                <i class="fa fa-eye"></i>
                                                            </button>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $setting->setting_description }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $displayValue = '';
                                                            if ($setting->setting_value === 'true') {
                                                                $displayValue = 'Ya';
                                                            } elseif ($setting->setting_value === 'false') {
                                                                $displayValue = 'Tidak';
                                                            } else {
                                                                $displayValue = $setting->setting_value;
                                                            }
                                                        @endphp
                                                        {!! $displayValue !!}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal untuk menampilkan gambar -->
    <div class="modal fade" id="viewImageModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="viewImageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered custom-modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewImageModalLabel">View Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body custom-modal-body">
                    <img id="viewImage" src="" alt="Image" class="img-fluid custom-modal-img" />
                </div>
            </div>
        </div>
    </div>

    <x-footer></x-footer>

    <!-- Include Modals Based on Modal Type -->
    @foreach ($settings as $setting)
        @include('admin.pengaturan.partials.modals.' . $setting->modal_type, ['setting' => $setting])
    @endforeach

    <script>
        $(document).ready((function() {
            $(".datepicker").datepicker({
                format: "yyyy-mm-dd",
                autoclose: !0,
                todayHighlight: !0
            }), toastr.options = {
                closeButton: !1,
                debug: !1,
                newestOnTop: !1,
                progressBar: !0,
                positionClass: "toast-top-right",
                preventDuplicates: !1,
                onclick: null,
                showDuration: "300",
                hideDuration: "1000",
                timeOut: "5000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut"
            }, document.querySelectorAll('form[id^="editForm-"]').forEach((e => {
                e.addEventListener("submit", (function(e) {
                    e.preventDefault();
                    const t = this.querySelector('input[name="setting_id"]').value,
                        o = this.querySelector('[name="setting_value"]').value,
                        n = this.querySelector('input[name="_token"]').value;
                    $("#editModal-" + t).modal("hide"), fetch(`/admin/settings/${t}`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": n
                        },
                        body: JSON.stringify({
                            setting_value: o
                        })
                    }).then((e => e.json())).then((e => {
                        e.success ? toastr.success(
                            "Pengaturan berhasil diperbarui", "", {
                                timeOut: 2e3,
                                progressBar: !0,
                                onHidden: function() {
                                    location.reload()
                                }
                            }) : toastr.error(
                            "Gagal memperbarui pengaturan")
                    })).catch((e => console.error("Error:", e)))
                }))
            }))
        }));


        function openEditModal(id, modalType, key) {

            $('#uploadModal-' + id).modal('hide');
            fetch(`/admin/settings/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    const modalId = 'editModal-' + id;
                    const modalElement = document.getElementById(modalId);
                    if (modalElement) {

                        if (modalType === 'input') {
                            const inputElement = modalElement.querySelector('input[name="setting_value"]');
                            if (inputElement) {
                                inputElement.value = data.setting.setting_value;
                            }
                        } else if (modalType === 'select') {
                            const selectElement = modalElement.querySelector('select[name="setting_value"]');
                            if (selectElement) {

                                selectElement.innerHTML = '';

                                // Map true/false to Ya/Tidak
                                const optionsMap = {
                                    'true': 'Ya',
                                    'false': 'Tidak',
                                    'native': 'Komentar Bawaan',
                                    'disqus': 'Disqus'
                                };

                                data.options.forEach(option => {
                                    const optionElement = document.createElement('option');
                                    optionElement.value = option.option_name; // Keep true/false for value
                                    optionElement.textContent = optionsMap[option.option_name] || option
                                        .option_name; // Display Ya/Tidak
                                    if (option.option_name === data.setting.setting_value) {
                                        optionElement.selected = true;
                                    }
                                    selectElement.appendChild(optionElement);
                                });
                            }
                        } else if (modalType === 'date') {
                            const dateElement = modalElement.querySelector('input[name="setting_value"]');
                            if (dateElement) {
                                dateElement.value = data.setting.setting_value;
                            }
                        }

                        $('#' + modalId).modal('show'); // Show Bootstrap modal
                    }
                })
                .catch(error => console.error('Error:', error));
        }



        function openUploadModal(id) {
            $('[id^=editModal-]').modal('hide');
            $('#uploadModal-' + id).modal('show');
        }

        function openViewModal(e) {
            const t = `/storage/images/settings/${e}`;
            document.getElementById("viewImage").src = t;
            new bootstrap.Modal(document.getElementById("viewImageModal")).show()
        }
    </script>
