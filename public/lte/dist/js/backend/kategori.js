
$(document).ready(function() {

  // Ambil base URL dari meta tag
  const baseUrl = $('meta[name="base-url"]').attr('content');

  // Inisialisasi DataTables
  $('#kategoriTable').DataTable({
      processing: false,
      serverSide: true,
      responsive: true,
      ordering: false,
      ajax: {
          url: `${baseUrl}/kategori/data`, // Gunakan base URL untuk membangun URL rute
      },
      columns: [
          { data: 'DT_RowIndex', name: 'DT_RowIndex' },
          { data: 'name', name: 'name' },
          { data: 'keterangan', name: 'keterangan' },
          {
              data: 'created_at',
              name: 'created_at',
              render: function(data) {
                  // Ubah format tanggal menggunakan moment.js atau cara lain
                  return moment(data).format('DD MMMM YYYY - HH:mm [WIB]');
              }
          },
          {
              data: 'action',
              name: 'action',
              orderable: false,
              searchable: false
          }
      ],
      order: [
          [1, 'asc']
      ]
  });
});

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










