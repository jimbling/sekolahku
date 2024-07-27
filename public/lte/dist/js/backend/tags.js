
$(document).ready(function() {

  // Ambil base URL dari meta tag
  const baseUrl = $('meta[name="base-url"]').attr('content');

  // Inisialisasi DataTables
  $('#tags-table').DataTable({
      processing: false,
      serverSide: true,
      responsive: true,
      ordering: false,
      ajax: {
          url: `${baseUrl}/asas/data`, // Gunakan base URL untuk membangun URL rute
      },
      columns: [
        {
          // Kolom No
          data: null,
          render: function(data, type, full, meta) {
              return meta.row +
                  1; // Menggunakan meta.row untuk mendapatkan nomor urut
          },
          orderable: false,
          searchable: false,
          className: 'text-center'
      },
      {
          // Kolom checkbox
          data: 'id',
          render: function(data, type, full, meta) {
              return '<input type="checkbox" class="row-select" data-id="' + data +
                  '">';
          },
          orderable: false,
          searchable: false,
          className: 'text-center'
      },
      {
          // Kolom Judul
          data: 'name',
          name: 'name'
      },
      {
          // Kolom Author
          data: 'slug',
          name: 'slug'
      },
      {
        data: 'action',
        name: 'action',
        orderable: false,
        searchable: false,
        className: 'text-center'
    },
      ],
      order: [
          [1, 'asc']
      ]
  });
});
 // Event listener untuk checkbox "Select All"
 $('#select-all').on('change', function() {
  var isChecked = $(this).prop('checked');
  $('.row-select').prop('checked', isChecked);
});











