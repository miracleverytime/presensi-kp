<?= $this->extend('layout/auth') ?>
<?= $this->section('content') ?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
  <div class="card login-card p-4 shadow" style="width: 100%; max-width: 420px;">
    <h3 class="text-center login-title">Lupa Password</h3>
    <p class="text-center text-muted mb-4">Masukkan email Anda untuk mendapatkan link reset password</p>
    
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
    
    <form action="<?= base_url('proses/forgot') ?>" method="post">
      <?= csrf_field() ?>
      
      <div class="field email">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required 
               value="<?= old('email') ?>" placeholder="Masukkan email Anda">
      </div>
      
      <button type="submit" class="btn btn-login w-100 mt-3">Kirim Link Reset</button>
    </form>
    
    <div class="text-center mt-3">
      <a href="<?= base_url('login') ?>" class="login-link">Kembali ke Login</a>
    </div>
  </div>
</div>

<?= $this->endSection() ?>