<?= $this->extend('layout/auth') ?>
<?= $this->section('content') ?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
  <div class="card p-4 shadow" style="width: 100%; max-width: 460px;">
    <h3 class="text-center mb-4">Daftar Akun Si-Kejar</h3>
    <form action="<?= base_url('register') ?>" method="post">
      <div class="mb-3">
        <label for="name" class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control" id="name" name="name" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email / Username</label>
        <input type="text" class="form-control" id="email" name="email" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Kata Sandi</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <div class="mb-3">
        <label for="password_confirm" class="form-label">Konfirmasi Sandi</label>
        <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Daftar</button>
    </form>
    <p class="mt-3 text-center">Sudah punya akun? <a href="<?= base_url('login') ?>" class="text-decoration-none text-primary">Login</a></p>
  </div>
</div>

<?= $this->endSection() ?>
