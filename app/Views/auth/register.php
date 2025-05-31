<?= $this->extend('layout/auth') ?>
<?= $this->section('content') ?>

<style>
  /* CSS untuk validation states */
  .field {
    position: relative;
    margin-bottom: 1rem;
  }
  
  .field.error .form-control {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
  }
  
  .field.valid .form-control {
    border-color: #198754;
    box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
  }
  
  .error-txt {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    display: none;
  }
  
  /* Shake animation */
  @keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
    20%, 40%, 60%, 80% { transform: translateX(5px); }
  }
  
  .shake {
    animation: shake 0.5s ease-in-out;
  }
  
  /* Password toggle styling - UPDATED untuk centering */
  .password-toggle {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    z-index: 10;
    color: #6c757d;
    transition: color 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 20px;
    height: 20px;
  }
  
  .password-toggle:hover {
    color: #ff5f6d;
  }
  
  .position-relative {
    position: relative;
  }
  
  /* Positioning khusus untuk field dengan label */
  .field.password .password-toggle,
  .field.verify-password .password-toggle {
    top: calc(50% + 14px); /* Menyesuaikan dengan tinggi label */
    transform: translateY(-50%);
  }
  
  /* Menyesuaikan dengan tema card dari layout */
  .register-card {
    background-color: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    backdrop-filter: blur(8px);
    border: none;
    box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
    transition: transform 0.3s ease;
  }
  
  .register-card:hover {
    transform: translateY(-5px);
  }
  
  /* Button styling sesuai tema */
  .btn-register {
    background: linear-gradient(135deg, #ff5f6d, #ffc371);
    border: none;
    color: white;
    font-weight: 600;
    padding: 12px;
    border-radius: 10px;
    transition: all 0.3s ease;
  }
  
  .btn-register:hover {
    background: linear-gradient(135deg, #ffc371, #ff5f6d);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(255, 95, 109, 0.4);
    color: white;
  }
  
  /* Link styling */
  .register-link {
    color: #ff5f6d;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
  }
  
  .register-link:hover {
    color: #ffc371;
    text-decoration: none;
  }
  
  /* Form label styling */
  .form-label {
    font-weight: 500;
    color: #333;
    margin-bottom: 0.5rem;
  }
  
  /* Input styling */
  .form-control {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    padding: 12px 15px;
    transition: all 0.3s ease;
  }
  
  .form-control:focus {
    border-color: #ff5f6d;
    box-shadow: 0 0 0 0.2rem rgba(255, 95, 109, 0.25);
  }
  
  /* Heading styling */
  .register-title {
    color: #333;
    font-weight: 700;
    margin-bottom: 2rem;
    position: relative;
  }
  
  .register-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 50px;
    height: 3px;
    background: linear-gradient(135deg, #ff5f6d, #ffc371);
    border-radius: 2px;
  }
</style>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
  <div class="card register-card p-4 shadow" style="width: 100%; max-width: 460px;">
    <h3 class="text-center register-title">Daftar Akun Si-Kejar</h3>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector("form");

    const namaField = form.querySelector(".nama"),
          namaInput = namaField ? namaField.querySelector("input") : null,
          kampusField = form.querySelector(".kampus"),
          kampusInput = kampusField ? kampusField.querySelector("input") : null,
          eField = form.querySelector(".email"),
          eInput = eField.querySelector("input"),
          pField = form.querySelector(".password"),
          pInput = pField.querySelector("input"),
          vpField = form.querySelector(".verify-password"),
          vpInput = vpField ? vpField.querySelector("input") : null;

    // Password toggle functionality untuk password utama
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    if (togglePassword && passwordInput) {
      togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        // Update icon SVG
        const svg = this.querySelector('svg');
        if (passwordInput.getAttribute('type') === 'password') {
          // Eye icon (show password)
          svg.innerHTML = '<path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>';
        } else {
          // Eye-slash icon (hide password)
          svg.innerHTML = '<path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/>';
        }
      });
    }

    // Password toggle functionality untuk verify password
    const toggleVerifyPassword = document.getElementById('toggleVerifyPassword');
    const verifyPasswordInput = document.getElementById('password_confirm');

    if (toggleVerifyPassword && verifyPasswordInput) {
      toggleVerifyPassword.addEventListener('click', function() {
        const type = verifyPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        verifyPasswordInput.setAttribute('type', type);
        
        // Update icon SVG
        const svg = this.querySelector('svg');
        if (verifyPasswordInput.getAttribute('type') === 'password') {
          // Eye icon (show password)
          svg.innerHTML = '<path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>';
        } else {
          // Eye-slash icon (hide password)
          svg.innerHTML = '<path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/>';
        }
      });
    }

    // VALIDATION FUNCTIONS
    function checkNama() { 
      if(!namaInput || namaInput.value == "") { 
        if(namaField) {
          namaField.classList.add("error");
          namaField.classList.remove("valid");
        }
      } else { 
        namaField.classList.remove("error");
        namaField.classList.add("valid");
      }
    }

    function checkKampus() { 
      if(!kampusInput || kampusInput.value == "") { 
        if(kampusField) {
          kampusField.classList.add("error");
          kampusField.classList.remove("valid");
        }
      } else { 
        kampusField.classList.remove("error");
        kampusField.classList.add("valid");
      }
    }

    function checkEmail() { 
      let pattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/; 
      if(!eInput.value.match(pattern)) { 
        eField.classList.add("error");
        eField.classList.remove("valid");
      } else { 
        eField.classList.remove("error");
        eField.classList.add("valid");
      }
    }

    function checkPass() { 
      if (pInput.value === "" || pInput.value.length < 8) { 
        pField.classList.add("error");
        pField.classList.remove("valid");
      } else { 
        pField.classList.remove("error");
        pField.classList.add("valid");
      }
    }

    function checkVerifyPass() { 
      if(!vpInput || vpInput.value === "") { 
        if(vpField) {
          vpField.classList.add("error");
          vpField.classList.remove("valid");
        }
      } else if(vpInput.value !== pInput.value) {
        vpField.classList.add("error");
        vpField.classList.remove("valid");
      } else { 
        vpField.classList.remove("error");
        vpField.classList.add("valid");
      }
    }

    // EVENT LISTENERS UNTUK REAL-TIME VALIDATION
    if (namaInput) namaInput.onkeyup = () => { checkNama(); }
    if (kampusInput) kampusInput.onkeyup = () => { checkKampus(); }
    if (eInput) eInput.onkeyup = () => { checkEmail(); }
    if (pInput) {
      pInput.onkeyup = () => { 
        checkPass(); 
        // Juga check verify password ketika password berubah
        if(vpInput && vpInput.value !== "") checkVerifyPass(); 
      }
    }
    if (vpInput) vpInput.onkeyup = () => { checkVerifyPass(); }

    // FORM SUBMIT HANDLER
    form.onsubmit = (e) => {
      e.preventDefault();

      // Check semua field dan tambah shake effect
      if (namaField && namaInput) { 
        (namaInput.value == "") ? namaField.classList.add("shake", "error") : checkNama();
        setTimeout(() => { namaField.classList.remove("shake"); }, 500);
      }

      if (kampusField && kampusInput) {
        (kampusInput.value == "") ? kampusField.classList.add("shake", "error") : checkKampus();
        setTimeout(() => { kampusField.classList.remove("shake"); }, 500);
      }

      (eInput.value == "") ? eField.classList.add("shake", "error") : checkEmail();
      (pInput.value == "") ? pField.classList.add("shake", "error") : checkPass();
      
      if (vpField && vpInput) {
        (vpInput.value == "" || vpInput.value !== pInput.value) ? vpField.classList.add("shake", "error") : checkVerifyPass();
        setTimeout(() => { vpField.classList.remove("shake"); }, 500);
      }

      // Remove shake effect
      setTimeout(() => { 
        eField.classList.remove("shake");
        pField.classList.remove("shake");
      }, 500);

      // Submit jika semua valid
      if((!namaField || !namaField.classList.contains("error")) &&
         (!kampusField || !kampusField.classList.contains("error")) &&
         !eField.classList.contains("error") &&
         !pField.classList.contains("error") &&
         (!vpField || !vpField.classList.contains("error"))) {
        form.submit();
      }
    }
});
</script>

<?= $this->endSection() ?>