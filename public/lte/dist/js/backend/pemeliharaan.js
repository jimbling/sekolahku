function deleteBackup(filename) {
    Swal.fire({
        title: "Apakah Anda yakin?",
        text: "Anda tidak akan dapat mengembalikan ini!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            const url = `${deleteBackupUrl}/${encodeURIComponent(filename)}`;
            fetch(url, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire("Terhapus!", "Backup telah dihapus.", "success")
                        .then(() => {
                            location.reload();
                        });
                } else {
                    Swal.fire("Gagal!", data.message, "error");
                }
            })
            .catch(error => {
                Swal.fire("Oops...", "Terjadi kesalahan!", "error");
            });
        }
    });
}

document.getElementById("backupForm").addEventListener("submit", function (event) {
    event.preventDefault();

    Swal.fire({
        title: "Konfirmasi Backup",
        text: "Backup akan dijalankan di latar belakang. Apakah Anda yakin ingin melanjutkan?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Ya, lanjutkan!",
        cancelButtonText: "Batal",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(this.action, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: new FormData(this)
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    icon: data.success ? "success" : "error",
                    title: data.success ? "Backup Dimulai" : "Gagal!",
                    text: data.success
                        ? "Backup sedang berjalan di latar belakang. Anda bisa melanjutkan aktivitas lain."
                        : data.message
                }).then(() => {
                    if (data.success) {
                        location.reload();
                    }
                });
            })
            .catch(error => {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Terjadi kesalahan saat mengirim permintaan!"
                });
                console.error(error); // debug
            });
        }
    });
});

