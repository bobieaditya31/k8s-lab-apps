<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-6">
        <h2>Tambah Pelanggan</h2>
        <form action="<?= base_url('customer/store') ?>" method="post" class="mt-4">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="mb-3">
                <label for="telepon" class="form-label">Telepon</label>
                <input type="text" class="form-control" id="telepon" name="telepon" required>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="nomor_identitas" class="form-label">Nomor Identitas (KTP/Paspor)</label>
                <input type="text" class="form-control" id="nomor_identitas" name="nomor_identitas" required>
            </div>

            <div class="mb-3">
                <label for="nomor_sim" class="form-label">Nomor SIM</label>
                <input type="text" class="form-control" id="nomor_sim" name="nomor_sim" required>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('customer') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
