<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Daftar Penyewaan</h2>
    <a href="<?= base_url('rental/create') ?>" class="btn btn-primary">+ Buat Penyewaan</a>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Pelanggan</th>
                <th>Kendaraan</th>
                <th>Tanggal Sewa</th>
                <th>Tanggal Kembali</th>
                <th>Total Hari</th>
                <th>Total Harga</th>
                <th>Denda</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($rentals as $rental): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $rental['customer_nama'] ?></td>
                <td><?= $rental['merek'] ?> <?= $rental['model'] ?> (<?= $rental['plat_nomor'] ?>)</td>
                <td><?= date('d-m-Y', strtotime($rental['tanggal_sewa'])) ?></td>
                <td><?= date('d-m-Y', strtotime($rental['tanggal_kembali'])) ?></td>
                <td><?= $rental['total_hari'] ?> hari</td>
                <td>Rp <?= number_format($rental['total_harga'], 0, ',', '.') ?></td>
                <td>Rp <?= number_format($rental['denda'], 0, ',', '.') ?></td>
                <td>
                    <span class="badge bg-<?= $rental['status'] === 'aktif' ? 'info' : ($rental['status'] === 'selesai' ? 'success' : 'danger') ?>">
                        <?= ucfirst($rental['status']) ?>
                    </span>
                </td>
                <td>
                    <a href="<?= base_url('rental/view/' . $rental['id']) ?>" class="btn btn-sm btn-info">Lihat</a>
                    <?php if ($rental['status'] === 'aktif'): ?>
                        <a href="<?= base_url('rental/cancel/' . $rental['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin membatalkan?')">Batalkan</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
