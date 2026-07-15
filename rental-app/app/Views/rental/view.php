<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-8">
        <h2>Detail Penyewaan</h2>
        
        <div class="card mt-4 mb-3">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Informasi Penyewaan #<?= $rental['id'] ?></h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">Data Pelanggan</h6>
                        <p><strong>Nama:</strong> <?= $rental['customer_nama'] ?></p>
                        <p><strong>Telepon:</strong> <?= $rental['telepon'] ?></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Data Kendaraan</h6>
                        <p><strong>Merek & Model:</strong> <?= $rental['merek'] ?> <?= $rental['model'] ?></p>
                        <p><strong>Plat Nomor:</strong> <?= $rental['plat_nomor'] ?></p>
                    </div>
                </div>

                <hr>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Tanggal Sewa:</strong> <?= date('d-m-Y', strtotime($rental['tanggal_sewa'])) ?></p>
                        <p><strong>Tanggal Kembali:</strong> <?= date('d-m-Y', strtotime($rental['tanggal_kembali'])) ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Total Hari:</strong> <?= $rental['total_hari'] ?> hari</p>
                        <p><strong>Harga Per Hari:</strong> Rp <?= number_format($rental['harga_perhari'], 0, ',', '.') ?></p>
                    </div>
                </div>

                <hr>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Total Harga:</strong> <span class="h5 text-success">Rp <?= number_format($rental['total_harga'], 0, ',', '.') ?></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Denda:</strong> <span class="h5 text-danger">Rp <?= number_format($rental['denda'], 0, ',', '.') ?></span></p>
                    </div>
                </div>

                <hr>

                <div class="mb-3">
                    <p><strong>Status:</strong> 
                        <span class="badge bg-<?= $rental['status'] === 'aktif' ? 'info' : ($rental['status'] === 'selesai' ? 'success' : 'danger') ?>">
                            <?= ucfirst($rental['status']) ?>
                        </span>
                    </p>
                </div>

                <?php if ($rental['status'] === 'aktif'): ?>
                <div class="mt-4">
                    <h5>Selesaikan Penyewaan</h5>
                    <form action="<?= base_url('rental/complete/' . $rental['id']) ?>" method="post" class="mt-3">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label for="tanggal_kembali_actual" class="form-label">Tanggal Pengembalian Aktual</label>
                            <input type="date" class="form-control" id="tanggal_kembali_actual" name="tanggal_kembali_actual" required>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">Selesaikan Penyewaan</button>
                            <a href="<?= base_url('rental') ?>" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
                <?php else: ?>
                <div class="mt-4">
                    <a href="<?= base_url('rental') ?>" class="btn btn-secondary">Kembali</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
