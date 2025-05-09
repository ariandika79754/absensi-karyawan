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
function confirmDeleteAbsensi(id) {
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
            window.location.href = "/admin/absensi/delete/" + id;
        } else {
            // Jika user menekan tombol Cancel pada SweetAlert
            swal("Batal menghapus data karyawan!");
        }
    });
}
function confirmDeleteJamKerja(id) {
    swal({
        title: "Apakah Anda yakin?",
        text: "Setelah dihapus, data jam kerja akan benar-benar hilang!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            // Jika user menekan tombol OK pada SweetAlert
            window.location.href = "/admin/master/jam-kerja/delete/" + id;
        } else {
            // Jika user menekan tombol Cancel pada SweetAlert
            swal("Batal menghapus data jam kerja!");
        }
    });
}


function confirmDeleteJabatan(id) {
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
            window.location.href = "/admin/master/jabatan/delete/" + id;
        } else {
            // Jika user menekan tombol Cancel pada SweetAlert
            swal("Batal menghapus data!");
        }
    });
}
function confirmDeleteUsers(id) {
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
            window.location.href = "/admin/master/users/delete/" + id;
        } else {
            // Jika user menekan tombol Cancel pada SweetAlert
            swal("Batal menghapus data!");
        }
    });
}