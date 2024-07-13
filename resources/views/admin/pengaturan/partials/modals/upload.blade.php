<!-- upload.blade.php -->
<div class="modal fade" id="uploadModal-{{ $setting->id }}" tabindex="-1"
    aria-labelledby="uploadModalLabel-{{ $setting->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel-{{ $setting->id }}">Upload Foto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="uploadForm-{{ $setting->id }}" method="POST"
                action="{{ route('upload.foto', ['id' => $setting->id]) }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="setting_id" value="{{ $setting->id }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="foto" class="col-form-label">Pilih Foto:</label>
                        <input type="file" class="form-control-file" id="foto" name="foto" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
