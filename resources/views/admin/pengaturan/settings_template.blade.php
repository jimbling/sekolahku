    <x-header>{{ $judul }}</x-header>
    <div class="content-wrapper">
        <x-breadcrumb>{{ $judul }}</x-breadcrumb>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="penggunaTabel" class="table table-sm table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center; vertical-align: middle;">No</th>
                                                <th style="text-align: center;">Aksi</th>
                                                <th>Nama Pengaturan</th>
                                                <th>Pengaturan Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($settings as $index => $setting)
                                                <tr>
                                                    <td style="width:5%; text-align: center; vertical-align: middle;">
                                                        {{ $index + 1 }}
                                                    </td>
                                                    <td style="width:15%; text-align: center; vertical-align: middle;">
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
                                                    <td style="width:15%">
                                                        {{ $setting->setting_description }}
                                                    </td>
                                                    <td>
                                                        {!! $setting->setting_value !!}
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

    <x-footer></x-footer>

    <!-- Include Modals Based on Modal Type -->
    @foreach ($settings as $setting)
        @include('admin.pengaturan.partials.modals.' . $setting->modal_type, ['setting' => $setting])
    @endforeach

    <script>
        $(document).ready(function() {
            // Initialize datepicker for input type text with date class
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });

            // Set Toastr options
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            document.querySelectorAll('form[id^="editForm-"]').forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    const id = this.querySelector('input[name="setting_id"]').value;
                    const settingValue = this.querySelector('[name="setting_value"]').value;
                    const token = this.querySelector('input[name="_token"]').value;

                    // Hide Bootstrap modal
                    $('#editModal-' + id).modal('hide');

                    fetch(`/settings/${id}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({
                                setting_value: settingValue
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Show Toastr with success message and progress bar
                                toastr.success('Setting updated successfully', '', {
                                    timeOut: 2000,
                                    progressBar: true,
                                    onHidden: function() {
                                        location
                                            .reload(); // Reload page after Toastr is hidden
                                    }
                                });
                            } else {
                                toastr.error('Failed to update setting');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });

        });







        function openEditModal(id, modalType, key) {
            console.log('Setting key:', key);

            // Hide upload modal if visible
            $('#uploadModal-' + id).modal('hide');

            // Your existing logic for opening edit modal
            fetch(`/settings/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    console.log('Response data:', data); // Log the response data

                    const modalId = 'editModal-' + id;
                    const modalElement = document.getElementById(modalId);

                    if (modalElement) {
                        // Update the value based on the modal type
                        if (modalType === 'input') {
                            const inputElement = modalElement.querySelector('input[name="setting_value"]');
                            if (inputElement) {
                                inputElement.value = data.setting.setting_value;
                            }
                        } else if (modalType === 'select') {
                            const selectElement = modalElement.querySelector('select[name="setting_value"]');
                            if (selectElement) {
                                // Clear existing options
                                selectElement.innerHTML = '';

                                // Populate select options
                                data.options.forEach(option => {
                                    const optionElement = document.createElement('option');
                                    optionElement.value = option.option_name;
                                    optionElement.textContent = option.option_name;
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
            // Hide edit modals if visible
            $('[id^=editModal-]').modal('hide');

            $('#uploadModal-' + id).modal('show');
        }
    </script>
