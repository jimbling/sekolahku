<!-- Modal untuk Textarea -->
<div class="modal fade" id="editModal-{{ $setting->id }}" tabindex="-1" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Setting</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm-{{ $setting->id }}" method="POST">
                @csrf
                <input type="hidden" name="setting_id" value="{{ $setting->id }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="setting_value" class="col-form-label">{{ $setting->settings_name }}:</label>
                        <textarea class="form-control" id="setting_value" name="setting_value" rows="4">{{ $setting->setting_value }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
