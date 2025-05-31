<?= $this->extend('layout/auth') ?>
<?= $this->section('content') ?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
  <div class="card p-4 shadow" style="width: 100%; max-width: 420px;">
    <h3 class="text-center mb-2">Login ke Si-Kejar</h3>
    <?= session()->getFlashdata('error'); ?>
    <form action="<?= base_url('proses/login') ?>" method="post">
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="text" class="form-control" id="email" name="email">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Kata Sandi</label>
        <input type="password" class="form-control" id="password" name="password">
      </div>
      <div class="d-flex justify-content-between ">
        <div class="form-check">
        </div>
        <a href="<?= base_url('lupa-password') ?>" class="text-decoration-none text-primary">Lupa Password?</a>
      </div>
      <button type="submit" class="btn btn-primary w-100">Masuk</button>
    </form>
    <p class="mt-3 text-center">Belum punya akun? <a href="<?= base_url('register') ?>" class="text-decoration-none text-primary">Daftar</a></p>
  </div>
</div>

<?= $this->endSection() ?>
