
$(document).ready(function() {
  // Tampilkan modal edit ketika tombol edit diklik
  $('#kategoriTable').on('click', '.edit-btn', function() {
      var id = $(this).data('id');

      // Ambil data kategori berdasarkan ID menggunakan AJAX
      $.ajax({
          url: '/kategori/' + id + '/fetch',
          type: 'GET',
          success: function(response) {
              $('#editId').val(response.id);
              $('#editName').val(response.name);
              $('#editKeterangan').val(response.keterangan);
              $('#editModal').modal('show');
          },
          error: function(xhr) {
              console.log('Error:', xhr);
          }
      });
  });

  // Submit form edit kategori
  $('#editForm').submit(function(e) {
      e.preventDefault();

      var id = $('#editId').val();
      var formData = {
          name: $('#editName').val(),
          keterangan: $('#editKeterangan').val(),
          _token: $('input[name=_token]').val(),
      };

      // Kirim permintaan AJAX untuk menyimpan perubahan
      $.ajax({
          url: '/kategori/' + id + '/update',
          type: 'PUT',
          data: formData,
          success: function(response) {
              $('#editModal').modal('hide');
              $('#kategoriTable').DataTable().ajax.reload();
              toastr.success(response.message);
          },
          error: function(xhr) {
              $.each(xhr.responseJSON.errors, function(key, value) {
                  toastr.error(value);
              });
          }
      });
  });
});
