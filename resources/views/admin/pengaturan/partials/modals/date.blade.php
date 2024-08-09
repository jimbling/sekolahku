<div class="modal fade" data-backdrop="static" data-keyboard="false" id="editModal-{{ $setting->id }}" tabindex="-1"
    aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Tanggal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm-{{ $setting->id }}" method="POST">
                @csrf
                <input type="hidden" name="setting_id" value="{{ $setting->id }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="setting_value-{{ $setting->id }}"
                            class="col-form-label">{{ $setting->settings_name }}:</label>
                        <input type="text" class="form-control datepicker" id="setting_value-{{ $setting->id }}"
                            name="setting_value" value="{{ $setting->setting_value }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
