<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Daftar Pelanggan</h2>
    <a href="<?= base_url('customer/create') ?>" class="btn btn-primary">+ Tambah Pelanggan</a>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>No. Identitas</th>
                <th>No. SIM</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($customers as $customer): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $customer['nama'] ?></td>
                <td><?= $customer['email'] ?></td>
                <td><?= $customer['telepon'] ?></td>
                <td><?= $customer['nomor_identitas'] ?></td>
                <td><?= $customer['nomor_sim'] ?></td>
                <td>
                    <span class="badge bg-<?= $customer['status'] === 'aktif' ? 'success' : 'danger' ?>">
                        <?= ucfirst($customer['status']) ?>
                    </span>
                </td>
                <td>
                    <a href="<?= base_url('customer/edit/' . $customer['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="<?= base_url('customer/delete/' . $customer['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menonaktifkan?')">Nonaktifkan</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
