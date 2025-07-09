
$(document).ready(function() {

  // Ambil base URL dari meta tag
  const baseUrl = $('meta[name="base-url"]').attr('content');

  // Inisialisasi DataTables
  $('#temaTable').DataTable({
      processing: false,
      serverSide: true,
      responsive: true,
      ordering: false,
      ajax: {
    url: routeVars.dataTemaUrl,
  },
      columns: [
  {
    data: 'DT_RowIndex',
    name: 'DT_RowIndex',
    orderable: false,  // <- harus false
    searchable: false  // <- harus false
  },
  { data: 'theme_name', name: 'theme_name' },
  { data: 'folder_name', name: 'folder_name' },
  { data: 'display_name', name: 'display_name' },
  { data: 'description', name: 'description' },
  {
    data: 'is_active',
    name: 'is_active',
    render: function(data, type, row) {
      return data == 1 ? 'Aktif' : 'Tidak Aktif';
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

$(document).ready(function () {
  $('#temaTable').on('click', '.activate-btn', function () {
    var id = $(this).data('id');

    $.ajax({
      url: '/admin/tema/' + id + '/activate',
      type: 'POST',
      data: {
        _token: $('meta[name="csrf-token"]').attr('content')
      },
      success: function (response) {
        $('#temaTable').DataTable().ajax.reload();
        toastr.success(response.message);
      },
      error: function (xhr) {
        toastr.error('Gagal mengaktifkan tema.');
      }
    });
  });
});












