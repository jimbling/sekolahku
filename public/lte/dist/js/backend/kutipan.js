
$(document).ready(function() {

  // Ambil base URL dari meta tag
  const baseUrl = $('meta[name="base-url"]').attr('content');

  // Inisialisasi DataTables
  $('#kutipanTable').DataTable({
      processing: false,
      serverSide: true,
      responsive: true,
      ordering: false,
      ajax: {
        url: routeVars.dataKutipanUrl,
      },
      columns: [
          { data: 'DT_RowIndex', name: 'DT_RowIndex' },
          { data: 'quote', name: 'quote' },
          { data: 'quote_by', name: 'quote_by' },
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
  $('#kutipanTable').on('click', '.edit-btn', function() {
      var id = $(this).data('id');

      // Ambil data kategori berdasarkan ID menggunakan AJAX
      $.ajax({
          url: '/blog/kutipan/' + id + '/fetch',
          type: 'GET',
          success: function(response) {
              $('#editId').val(response.id);
              $('#editQuote').val(response.quote);
              $('#editQuoteBy').val(response.quote_by);
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
        quote: $('#editQuote').val(),
        quote_by: $('#editQuoteBy').val(),
        _token: $('input[name=_token]').val(), // Pastikan token CSRF disertakan
    };

    // Kirim permintaan AJAX untuk menyimpan perubahan
    $.ajax({
        url: '/blog/kutipan/' + id + '/update',
        type: 'PUT',
        data: formData,
        success: function(response) {
            $('#editModal').modal('hide');
            $('#kutipanTable').DataTable().ajax.reload();
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










