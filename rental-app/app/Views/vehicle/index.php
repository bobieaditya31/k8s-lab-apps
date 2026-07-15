<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Daftar Kendaraan</h2>
    <a href="<?= base_url('vehicle/create') ?>" class="btn btn-primary">+ Tambah Kendaraan</a>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Plat Nomor</th>
                <th>Merek</th>
                <th>Model</th>
                <th>Tipe</th>
                <th>Tahun</th>
                <th>Warna</th>
                <th>Harga/Hari</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($vehicles as $vehicle): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $vehicle['plat_nomor'] ?></td>
                <td><?= $vehicle['merek'] ?></td>
                <td><?= $vehicle['model'] ?></td>
                <td><?= ucfirst($vehicle['tipe']) ?></td>
                <td><?= $vehicle['tahun'] ?></td>
                <td><?= $vehicle['warna'] ?></td>
                <td>Rp <?= number_format($vehicle['harga_perhari'], 0, ',', '.') ?></td>
                <td>
                    <span class="badge bg-<?= $vehicle['status'] === 'tersedia' ? 'success' : ($vehicle['status'] === 'dipinjam' ? 'warning' : 'danger') ?>">
                        <?= ucfirst($vehicle['status']) ?>
                    </span>
                </td>
                <td>
                    <a href="<?= base_url('vehicle/edit/' . $vehicle['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="<?= base_url('vehicle/delete/' . $vehicle['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
