
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
          url: `${baseUrl}/tags/data`, // Gunakan base URL untuk membangun URL rute
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
// $(document).ready(function() {
//   // Tampilkan modal edit ketika tombol edit diklik
//   $('#kategoriTable').on('click', '.edit-btn', function() {
//       var id = $(this).data('id');

//       // Ambil data kategori berdasarkan ID menggunakan AJAX
//       $.ajax({
//           url: '/kategori/' + id + '/fetch',
//           type: 'GET',
//           success: function(response) {
//               $('#editId').val(response.id);
//               $('#editName').val(response.name);
//               $('#editKeterangan').val(response.keterangan);
//               $('#editModal').modal('show');
//           },
//           error: function(xhr) {
//               console.log('Error:', xhr);
//           }
//       });
//   });

//   // Submit form edit kategori
//   $('#editForm').submit(function(e) {
//       e.preventDefault();

//       var id = $('#editId').val();
//       var formData = {
//           name: $('#editName').val(),
//           keterangan: $('#editKeterangan').val(),
//           _token: $('input[name=_token]').val(),
//       };

//       // Kirim permintaan AJAX untuk menyimpan perubahan
//       $.ajax({
//           url: '/kategori/' + id + '/update',
//           type: 'PUT',
//           data: formData,
//           success: function(response) {
//               $('#editModal').modal('hide');
//               $('#kategoriTable').DataTable().ajax.reload();
//               toastr.success(response.message);
//           },
//           error: function(xhr) {
//               $.each(xhr.responseJSON.errors, function(key, value) {
//                   toastr.error(value);
//               });
//           }
//       });
//   });
// });










