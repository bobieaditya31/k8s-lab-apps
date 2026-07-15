<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-6">
        <h2>Buat Penyewaan Baru</h2>
        <form action="<?= base_url('rental/store') ?>" method="post" class="mt-4">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="customer_id" class="form-label">Pelanggan</label>
                <select class="form-control" id="customer_id" name="customer_id" required>
                    <option value="">-- Pilih Pelanggan --</option>
                    <?php foreach ($customers as $customer): ?>
                        <option value="<?= $customer['id'] ?>"><?= $customer['nama'] ?> - <?= $customer['nomor_sim'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="vehicle_id" class="form-label">Kendaraan</label>
                <select class="form-control" id="vehicle_id" name="vehicle_id" required onchange="updateVehiclePrice()">
                    <option value="">-- Pilih Kendaraan --</option>
                    <?php foreach ($vehicles as $vehicle): ?>
                        <option value="<?= $vehicle['id'] ?>" data-price="<?= $vehicle['harga_perhari'] ?>">
                            <?= $vehicle['merek'] ?> <?= $vehicle['model'] ?> (<?= $vehicle['plat_nomor'] ?>) - Rp <?= number_format($vehicle['harga_perhari'], 0, ',', '.') ?>/hari
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="tanggal_sewa" class="form-label">Tanggal Sewa</label>
                <input type="date" class="form-control" id="tanggal_sewa" name="tanggal_sewa" required onchange="calculateDays()">
            </div>

            <div class="mb-3">
                <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" required onchange="calculateDays()">
            </div>

            <div class="mb-3">
                <label for="total_hari" class="form-label">Total Hari</label>
                <input type="number" class="form-control" id="total_hari" readonly>
            </div>

            <div class="mb-3">
                <label for="total_harga" class="form-label">Total Harga</label>
                <input type="text" class="form-control" id="total_harga" readonly>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan Penyewaan</button>
                <a href="<?= base_url('rental') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
function calculateDays() {
    const start = new Date(document.getElementById('tanggal_sewa').value);
    const end = new Date(document.getElementById('tanggal_kembali').value);
    
    if (start && end && end > start) {
        const days = Math.ceil((end - start) / (1000 * 60 * 60 * 24)) + 1;
        document.getElementById('total_hari').value = days;
        updateTotalPrice();
    }
}

function updateVehiclePrice() {
    updateTotalPrice();
}

function updateTotalPrice() {
    const vehicle = document.getElementById('vehicle_id');
    const selectedOption = vehicle.options[vehicle.selectedIndex];
    const price = selectedOption.getAttribute('data-price');
    const days = document.getElementById('total_hari').value;
    
    if (price && days) {
        const total = price * days;
        document.getElementById('total_harga').value = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    }
}
</script>
<?= $this->endSection() ?>
