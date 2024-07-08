
    // Script Konfirmasi Penghapusan
function confirmDelete() {
  // Mendapatkan semua checkbox yang dicentang
  var selectedBarangCount = document.querySelectorAll('input[name="selected_barangs[]"]:checked').length;

  // Memeriksa apakah ada data yang dicentang
  if (selectedBarangCount === 0) {
      toastr.error('Pilih setidaknya satu barang untuk dihapus');
      return false; // Mencegah pengiriman formulir
  }

  // Pesan konfirmasi berdasarkan jumlah data yang akan dihapus
  var confirmationMessage = selectedBarangCount > 1 ? "Anda yakin ingin menghapus semua barang yang terpilih?" :
      "Anda yakin ingin menghapus barang ini?";

  // Menampilkan konfirmasi SweetAlert
  Swal.fire({
      title: 'HAPUS!',
      text: confirmationMessage,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus saja!'
  }).then((result) => {
      if (result.isConfirmed) {
          document.getElementById('deleteForm').submit();
      }
  });

}



    // Script Checkbox All

    // Mengambil elemen checkbox-toggle dan semua checkbox data barang
    var toggleAll = document.getElementById('toggleAll');
    var checkboxes = document.querySelectorAll('input[name="selected_barangs[]"]');

    // Menambahkan event listener untuk checkbox-toggle
    toggleAll.addEventListener('click', function() {
        // Memeriksa status checkbox-toggle
        var isChecked = toggleAll.querySelector('i').classList.contains('fa-check-square');

        // Mengubah status setiap checkbox data barang sesuai dengan status checkbox-toggle
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = !isChecked;
        });

        // Mengubah ikon pada checkbox-toggle
        if (isChecked) {
            toggleAll.querySelector('i').classList.remove('fa-check-square');
            toggleAll.querySelector('i').classList.add('fa-square');
        } else {
            toggleAll.querySelector('i').classList.remove('fa-square');
            toggleAll.querySelector('i').classList.add('fa-check-square');
        }
    });

    // Script edit Barang
    $('#editBarang').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget); // Tombol yang memicu modal
      var id = button.data('id'); // Ekstrak data ID barang dari atribut data-id
      var nama = button.data('nama'); // Ekstrak data nama barang dari atribut data-nama
      var keadaan = button.data('keadaan'); // Ekstrak data keadaan barang dari atribut data-keadaan
      var kepemilikan = button.data(
      'kepemilikan'); // Ekstrak data kepemilikan barang dari atribut data-kepemilikan
      var modal = $(this);

      // Isi nilai-nilai dalam formulir modal dengan data barang
      modal.find('.modal-body #barang_id').val(id);
      modal.find('.modal-body #edit_nama_barang').val(nama);
      modal.find('.modal-body #edit_keadaan').val(keadaan);
      modal.find('.modal-body #edit_kepemilikan').val(kepemilikan);
  });

  // Script Validasi Input Tambah Barang Baru
  function validateForm() {
    var namaBarang = document.getElementById('nama_barang').value;
    var keadaan = document.getElementById('keadaan').value;
    var kepemilikan = document.getElementById('kepemilikan').value;

    if (!namaBarang) {
        // Menampilkan pesan error untuk nama barang
        toastr.error('Nama barang harus diisi');
    } else if (!keadaan) {
        // Menampilkan pesan error untuk keadaan
        toastr.error('Keadaan harus dipilih');
    } else if (!kepemilikan) {
        // Menampilkan pesan error untuk kepemilikan
        toastr.error('Kepemilikan harus dipilih');
    } else {
        // Jika semua field terisi, submit form
        document.getElementById('tambahBarangForm').submit();
    }
}

