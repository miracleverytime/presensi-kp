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

