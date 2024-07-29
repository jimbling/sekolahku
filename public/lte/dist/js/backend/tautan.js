
$(document).ready(function() {

  // Ambil base URL dari meta tag
  const baseUrl = $('meta[name="base-url"]').attr('content');

  // Inisialisasi DataTables
  $('#tautanTable').DataTable({
      processing: false,
      serverSide: true,
      responsive: true,
      ordering: false,
      ajax: {
        url: routeVars.dataTautanUrl,
      },
      columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex' },
        { data: 'link_url', name: 'link_url' },
        { data: 'link_title', name: 'link_title' },
        {
            data: 'link_target',
            name: 'link_target',
            render: function(data, type, row) {
                switch(data) {
                    case '_blank':
                        return 'Blank';
                    case '_self':
                        return 'Self';
                    case '_parent':
                        return 'Parent';
                    case '_top':
                        return 'Top';
                    default:
                        return data;
                }
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
  $('#tautanTable').on('click', '.edit-btn', function() {
      var id = $(this).data('id');

      // Ambil data kategori berdasarkan ID menggunakan AJAX
      $.ajax({
          url: '/tautan/' + id + '/fetch',
          type: 'GET',
          success: function(response) {
              $('#editId').val(response.id);
              $('#edit_tautan_url').val(response.link_url);
              $('#edit_tautan_name').val(response.link_title);
              $('#edit_tautan_target').val(response.link_target);
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
      link_url: $('#edit_tautan_url').val(),
      link_title: $('#edit_tautan_name').val(),
      link_target: $('#edit_tautan_target').val(),
        _token: $('input[name=_token]').val(), // Pastikan token CSRF disertakan
    };

    // Kirim permintaan AJAX untuk menyimpan perubahan
    $.ajax({
        url: '/tautan/' + id + '/update',
        type: 'PUT',
        data: formData,
        success: function(response) {
            $('#editModal').modal('hide');
            $('#tautanTable').DataTable().ajax.reload();
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










