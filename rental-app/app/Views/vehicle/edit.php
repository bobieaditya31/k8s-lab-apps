<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-6">
        <h2>Edit Kendaraan</h2>
        <form action="<?= base_url('vehicle/update/' . $vehicle['id']) ?>" method="post" class="mt-4">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="plat_nomor" class="form-label">Plat Nomor</label>
                <input type="text" class="form-control" id="plat_nomor" name="plat_nomor" value="<?= $vehicle['plat_nomor'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="merek" class="form-label">Merek</label>
                <input type="text" class="form-control" id="merek" name="merek" value="<?= $vehicle['merek'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="model" class="form-label">Model</label>
                <input type="text" class="form-control" id="model" name="model" value="<?= $vehicle['model'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="tipe" class="form-label">Tipe</label>
                <select class="form-control" id="tipe" name="tipe" required>
                    <option value="mobil" <?= $vehicle['tipe'] === 'mobil' ? 'selected' : '' ?>>Mobil</option>
                    <option value="motor" <?= $vehicle['tipe'] === 'motor' ? 'selected' : '' ?>>Motor</option>
                    <option value="bus" <?= $vehicle['tipe'] === 'bus' ? 'selected' : '' ?>>Bus</option>
                    <option value="truk" <?= $vehicle['tipe'] === 'truk' ? 'selected' : '' ?>>Truk</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="tahun" class="form-label">Tahun</label>
                <input type="number" class="form-control" id="tahun" name="tahun" value="<?= $vehicle['tahun'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="warna" class="form-label">Warna</label>
                <input type="text" class="form-control" id="warna" name="warna" value="<?= $vehicle['warna'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="harga_perhari" class="form-label">Harga Per Hari (Rp)</label>
                <input type="number" class="form-control" id="harga_perhari" name="harga_perhari" value="<?= $vehicle['harga_perhari'] ?>" step="0.01" required>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Perbarui</button>
                <a href="<?= base_url('vehicle') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
