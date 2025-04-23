function confirmDeleteKaryawan(id) {
    swal({
        title: "Apakah Anda yakin?",
        text: "Setelah dihapus, data karyawan akan benar-benar hilang!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            // Jika user menekan tombol OK pada SweetAlert
            window.location.href = "/admin/karyawan/delete/" + id;
        } else {
            // Jika user menekan tombol Cancel pada SweetAlert
            swal("Batal menghapus data karyawan!");
        }
    });
}

function confirmDeleteJamKerja(id) {
    swal({
        title: "Apakah Anda yakin?",
        text: "Setelah dihapus, data karyawan akan benar-benar hilang!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            // Jika user menekan tombol OK pada SweetAlert
            window.location.href = "/admin/karyawan/delete/" + id;
        } else {
            // Jika user menekan tombol Cancel pada SweetAlert
            swal("Batal menghapus data karyawan!");
        }
    });
}
function confirmDelete(id) {
    swal({
        title: "Apakah Anda yakin?",
        text: "Setelah dihapus, data Anda akan benar-benar hilang!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            // Jika user menekan tombol OK pada SweetAlert
            window.location.href = "/admin/product/delete/" + id;
        } else {
            // Jika user menekan tombol Cancel pada SweetAlert
            swal("Batal menghapus data!");
        }
    });
}
function confirmDeletePelanggan(id) {
    swal({
        title: "Apakah Anda yakin?",
        text: "Setelah dihapus, data Anda akan benar-benar hilang!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            // Jika user menekan tombol OK pada SweetAlert
            window.location.href = "/admin/product/delete/" + id;
        } else {
            // Jika user menekan tombol Cancel pada SweetAlert
            swal("Batal menghapus data!");
        }
    });
}