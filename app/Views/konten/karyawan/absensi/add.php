<?= $this->extend('layout/page') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="row">
                <div class="col-lg-6">
                    <h5 class="card-header">Tambah Data Absensi</h5>
                </div>
                <div class="col-lg-6 text-end">
                    <a href="/karyawan/absensi" class="btn btn-dark me-3 mt-3"><i class='bx bx-arrow-back'></i> Kembali</a>
                </div>
                <div class="col-lg-12 p-5">
                    <!-- Menampilkan pesan error jika ada -->
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

                    <!-- Form untuk menambah data absensi -->
                    <form action="/karyawan/absensi/save" method="POST">
                        <?= csrf_field() ?>

                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="users_id">Nama Karyawan</label>
                                <input type="text" class="form-control" value="<?= $users['nama'] ?>" readonly>
                                <input type="hidden" name="users_id" value="<?= $users['id'] ?>">
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal"
                                    value="<?= date('Y-m-d') ?>" readonly
                                    min="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>">
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label for="sesi_id" class="form-label">Sesi</label>
                                <select name="sesi_id" id="sesi_id" class="form-control" required>
                                    <option value="">Pilih Sesi</option>
                                    <?php foreach ($sesi as $row): ?>
                                        <option
                                            value="<?= $row['id'] ?>"
                                            data-jam-masuk="<?= $row['jam_masuk'] ?>"
                                            data-jam-keluar="<?= $row['jam_keluar'] ?>">
                                            <?= $row['sesi'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label for="jam_masuk" class="form-label">Jam Masuk</label>
                                <input type="time" class="form-control" id="jam_masuk" name="jam_masuk" readonly required>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label for="jam_keluar" class="form-label">Jam Keluar</label>
                                <input type="time" class="form-control" id="jam_keluar" name="jam_keluar" readonly required>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="">Pilih Status</option>
                                    <option value="Hadir">Hadir</option>
                                    <option value="Sakit">Sakit</option>
                                    <option value="Izin">Izin</option>
                                    <option value="Terlambat">Terlambat</option>
                                </select>
                            </div>

                            <div class="col-lg-12 mb-3" id="keterangan-container" style="display:none;">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea class="form-control" name="keterangan" id="keterangan" rows="3"></textarea>
                            </div>


                            <!-- ✅ Tambahan hidden input koordinat -->
                            <input type="hidden" id="latitude" name="latitude">
                            <input type="hidden" id="longitude" name="longitude">

                        </div>

                        <button class="btn btn-primary">
                            <i class='bx bx-save me-1'></i> Simpan
                        </button>
                    </form>
                    <!-- Leaflet CSS & JS -->
                    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
                    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

                    <!-- Container Peta -->
                    <div class="col-lg-12 mb-3">
                        <label class="form-label">Lokasi Anda Sekarang</label>
                        <div id="map" style="height: 300px;"></div>
                    </div>

                    <script>
                        const kantorLat = -5.3786508; // Ganti dengan lat kantor kamu
                        const kantorLng = 105.2606752; // Ganti dengan lng kantor kamu

                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(function(position) {
                                const userLat = position.coords.latitude;
                                const userLng = position.coords.longitude;

                                // Isi hidden input
                                document.getElementById('latitude').value = userLat;
                                document.getElementById('longitude').value = userLng;

                                // Inisialisasi peta
                                const map = L.map('map').setView([userLat, userLng], 16);

                                // Tambahkan layer OpenStreetMap
                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
                                }).addTo(map);

                                // Marker lokasi user
                                const userMarker = L.marker([userLat, userLng]).addTo(map)
                                    .bindPopup("Lokasi Anda Sekarang").openPopup();

                                // Marker kantor
                                const kantorMarker = L.marker([kantorLat, kantorLng], {
                                    icon: L.icon({
                                        iconUrl: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
                                        iconSize: [30, 30],
                                        iconAnchor: [15, 30]
                                    })
                                }).addTo(map).bindPopup("Lokasi Kantor");

                                // Gambar garis antara user dan kantor
                                const polyline = L.polyline([
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

<!-- ✅ Script untuk mengisi jam otomatis -->
<script>
    document.getElementById('sesi_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const jamMasuk = selectedOption.getAttribute('data-jam-masuk');
        const jamKeluar = selectedOption.getAttribute('data-jam-keluar');

        document.getElementById('jam_masuk').value = jamMasuk || '';
        document.getElementById('jam_keluar').value = jamKeluar || '';
    });
    document.getElementById('status').addEventListener('change', function() {
        var status = this.value;
        var keteranganContainer = document.getElementById('keterangan-container');

        // Sembunyikan kolom keterangan jika status "Hadir"
        if (status === 'Hadir') {
            keteranganContainer.style.display = 'none';
        } else {
            // Tampilkan kolom keterangan jika status "Sakit" atau "Terlambat"
            keteranganContainer.style.display = 'block';
        }
    });
</script>

<!-- ✅ Script Geolocation untuk isi latitude & longitude -->
<script>
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById('latitude').value = position.coords.latitude;
            document.getElementById('longitude').value = position.coords.longitude;
        }, function(error) {
            alert("Gagal mendapatkan lokasi. Pastikan izin lokasi diaktifkan.");
        });
    } else {
        alert("Browser tidak mendukung geolokasi.");
    }
</script>

<?= $this->endSection() ?>