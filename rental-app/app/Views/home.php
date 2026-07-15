<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-8">
        <h1>Selamat Datang di Sistem Rental Kendaraan</h1>
        <p>Kelola penyewaan kendaraan Anda dengan mudah dan efisien.</p>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Kendaraan</h5>
                <p class="card-text">Kelola daftar kendaraan yang tersedia untuk disewakan.</p>
                <a href="<?= base_url('vehicle') ?>" class="btn btn-primary">Lihat Kendaraan</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Pelanggan</h5>
                <p class="card-text">Kelola data pelanggan yang terdaftar dalam sistem.</p>
                <a href="<?= base_url('customer') ?>" class="btn btn-primary">Lihat Pelanggan</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Penyewaan</h5>
                <p class="card-text">Kelola semua transaksi penyewaan kendaraan.</p>
                <a href="<?= base_url('rental') ?>" class="btn btn-primary">Lihat Penyewaan</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
