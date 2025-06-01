<?= $this->extend('layout/auth') ?>
<?= $this->section('content') ?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
  <div class="card register-card p-4 shadow" style="width: 100%; max-width: 460px;">
    <h3 class="text-center register-title">Daftar Akun Si-Kejar</h3>
        <?php if(session()->getFlashdata('error')): ?>
          <div class="error-message">
          <?= session()->getFlashdata('error'); ?>
      </div>
    <?php endif; ?>
    <form action="<?= base_url('register/account') ?>" method="post">
      
      <div class="field nama">
        <label for="name" class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control" id="name" name="name">

      </div>
      
      <div class="field kampus">
        <label for="kampus" class="form-label">Kampus</label>
        <input type="text" class="form-control" id="kampus" name="kampus">

      </div>
      
      <div class="field email">
        <label for="email" class="form-label">Email</label>
        <input type="text" class="form-control" id="email" name="email">

      </div>
      
      <div class="field password position-relative">
        <label for="password" class="form-label">Kata Sandi</label>
        <input type="password" class="form-control" id="password" name="password">
        <span class="password-toggle" id="togglePassword">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
          </svg>
        </span>

      </div>
      
      <div class="field verify-password position-relative">
        <label for="password_confirm" class="form-label">Konfirmasi Sandi</label>
        <input type="password" class="form-control" id="password_confirm" name="password_confirm">
        <span class="password-toggle" id="toggleVerifyPassword">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
          </svg>
        </span>

      </div>
      
      <button type="submit" class="btn btn-register w-100">Daftar</button>
    </form>
    <p class="mt-3 text-center" style="color: #666;">Sudah punya akun? <a href="<?= base_url('login') ?>" class="register-link">Login</a></p>
  </div>
</div>

<?= $this->endSection() ?>