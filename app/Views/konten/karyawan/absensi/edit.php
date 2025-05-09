<?= $this->extend('layout/page') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="row">
                <div class="col-lg-6">
                    <h5 class="card-header">Edit Data Absensi</h5>
                </div>
                <div class="col-lg-6 text-end">
                    <a href="/karyawan/absensi" class="btn btn-dark me-3 mt-3"><i class='bx bx-arrow-back'></i> Kembali</a>
                </div>
                <div class="col-lg-12 p-5">
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('lokasi_error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('lokasi_error') ?>
                        </div>
                    <?php endif; ?>
                    <!-- Form untuk mengedit data absensi -->
                    <form action="/karyawan/absensi/update/<?= encrypt_url($absensi['id']) ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="users_id">Nama Karyawan</label>
                                <select class="form-control" id="users_id" name="users_id" required>
                                    <option value="">Pilih Karyawan</option>
                                    <?php foreach ($users as $user): ?>
                                        <option value="<?= $user['id'] ?>" <?= $user['id'] == $absensi['users_id'] ? 'selected' : '' ?>><?= $user['nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="tanggal">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= $absensi['tanggal'] ?>" readonly required>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label for="sesi_id" class="form-label">Sesi</label>
                                <select name="sesi_id" id="sesi_id" class="form-control" required>
                                    <option value="">Pilih Sesi</option>
                                    <?php foreach ($sesi as $row): ?>
                                        <option
                                            value="<?= $row['id'] ?>"
                                            data-jam-masuk="<?= $row['jam_masuk'] ?>"
                                            data-jam-keluar="<?= $row['jam_keluar'] ?>"
                                            <?= $row['id'] == $absensi['sesi_id'] ? 'selected' : '' ?>>
                                            <?= $row['sesi'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="jam_masuk">Jam Masuk</label>
                                <input type="time" class="form-control" id="jam_masuk" name="jam_masuk" value="<?= $absensi['jam_masuk'] ?>" readonly>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="jam_keluar">Jam Keluar</label>
                                <input type="time" class="form-control" id="jam_keluar" name="jam_keluar" value="<?= $absensi['jam_keluar'] ?>" readonly>
                            </div>


                            <div class="col-lg-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="Hadir" <?= $absensi['status'] == 'Hadir' ? 'selected' : '' ?>>Hadir</option>
                                    <option value="Izin" <?= $absensi['status'] == 'Izin' ? 'selected' : '' ?>>Izin</option>
                                    <option value="Sakit" <?= $absensi['status'] == 'Sakit' ? 'selected' : '' ?>>Sakit</option>
                                    <option value="Terlambat" <?= $absensi['status'] == 'Terlambat' ? 'selected' : '' ?>>Terlambat</option>
                                </select>
                            </div>

                            <div class="col-lg-12 mb-3" id="keterangan_div">
                                <label class="form-label" for="keterangan">Keterangan</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?= $absensi['keterangan'] ?></textarea>
                            </div>
                            <input type="hidden" name="latitude" id="latitude">
                            <input type="hidden" name="longitude" id="longitude">

                        </div>

                        <div class="col-lg-6 mt-5">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                    <div class="col-lg-12 mb-3">
                        <label class="form-label">Lokasi Anda Sekarang</label>
                        <div id="map" style="height: 300px;"></div>
                    </div>

                    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
                    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

                    <script>
                        const kantorLat = -5.3786508;
                        const kantorLng = 105.2606752;

                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(function(position) {
                                const userLat = position.coords.latitude;
                                const userLng = position.coords.longitude;

                                // Isi input hidden
                                document.getElementById('latitude').value = userLat;
                                document.getElementById('longitude').value = userLng;

                                const map = L.map('map').setView([userLat, userLng], 16);

                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>'
                                }).addTo(map);

                                L.marker([userLat, userLng]).addTo(map).bindPopup("Lokasi Anda Sekarang").openPopup();

                                L.marker([kantorLat, kantorLng], {
                                    icon: L.icon({
                                        iconUrl: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
                                        iconSize: [30, 30],
                                        iconAnchor: [15, 30]
                                    })
                                }).addTo(map).bindPopup("Lokasi Kantor");

                                L.polyline([
                                    [userLat, userLng],
                                    [kantorLat, kantorLng]
                                ], {
                                    color: 'red'
                                }).addTo(map);
                            }, function(error) {
                                alert("Gagal mendapatkan lokasi. Pastikan izin lokasi diaktifkan.");
                            });
                        } else {
                            alert("Browser tidak mendukung geolokasi.");
                        }
                    </script>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- JavaScript untuk mengisi otomatis jam masuk dan keluar -->
<script>
    document.getElementById('sesi_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const jamMasuk = selectedOption.getAttribute('data-jam-masuk');
        const jamKeluar = selectedOption.getAttribute('data-jam-keluar');

        document.getElementById('jam_masuk').value = jamMasuk || '';
        document.getElementById('jam_keluar').value = jamKeluar || '';
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('status');
        const keteranganDiv = document.getElementById('keterangan_div');

        // Fungsi untuk mengatur apakah kolom keterangan akan terlihat
        function toggleKeteranganField() {
            if (statusSelect.value === 'Hadir') {
                keteranganDiv.style.display = 'none'; // Sembunyikan keterangan jika status Hadir
            } else {
                keteranganDiv.style.display = 'block'; // Tampilkan keterangan jika status selain Hadir
            }
        }

        // Inisialisasi status saat halaman pertama kali dimuat
        toggleKeteranganField();

        // Menambahkan event listener untuk perubahan status
        statusSelect.addEventListener('change', toggleKeteranganField);
    });
</script>
<script>
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById("latitude").value = position.coords.latitude;
            document.getElementById("longitude").value = position.coords.longitude;
        }, function(error) {
            console.warn("Lokasi tidak bisa didapatkan: ", error.message);
        });
    } else {
        alert("Geolocation tidak didukung di browser Anda.");
    }
</script>

<?= $this->endSection() ?>