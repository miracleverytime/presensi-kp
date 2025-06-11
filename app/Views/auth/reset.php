<?= $this->extend('layout/auth') ?>
<?= $this->section('content') ?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
  <div class="card login-card p-4 shadow" style="width: 100%; max-width: 420px;">
    <h3 class="text-center login-title">Reset Password</h3>
    <p class="text-center text-muted mb-4">Masukkan password baru Anda</p>
    
    <?php if(session()->getFlashdata('error')): ?>
      <div class="error-message">
        <?= session()->getFlashdata('error'); ?>
      </div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('success')): ?>
      <div class="success-message">
        <?= session()->getFlashdata('success'); ?>
      </div>
    <?php endif; ?>
    
    <form action="<?= base_url('proses/reset-password') ?>" method="post">
      <?= csrf_field() ?>
      <input type="hidden" name="token" value="<?= $token ?>">
      
      <div class="field password position-relative">
        <label for="password" class="form-label">Password Baru</label>
        <input type="password" class="form-control" id="password" name="password" required
               minlength="6" placeholder="Minimal 6 karakter">
        <span class="password-toggle" onclick="togglePasswordVisibility('password')">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
          </svg>
        </span>
      </div>
      
      <div class="field password position-relative">
        <label for="confirm_password" class="form-label">Konfirmasi Password</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required
               minlength="6" placeholder="Ulangi password baru">
        <span class="password-toggle" onclick="togglePasswordVisibility('confirm_password')">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
          </svg>
        </span>
      </div>
      
      <button type="submit" class="btn btn-login w-100 mt-3">Reset Password</button>
    </form>
    
    <div class="text-center mt-3">
      <a href="<?= base_url('login') ?>" class="login-link">Kembali ke Login</a>
    </div>
  </div>
</div>

<script>
function togglePasswordVisibility(fieldId) {
  const field = document.getElementById(fieldId);
  if (field.type === 'password') {
    field.type = 'text';
  } else {  
    field.type = 'password';
  }
}
</script>

<?= $this->endSection() ?>