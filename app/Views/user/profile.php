 <?= $this->extend('layout/TemplateUser'); ?>


 <?= $this->section('content'); ?>
 <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #ff6b6b 0%, #ffa726 100%);
            min-height: 100vh;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 280px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid #e9ecef;
            background: linear-gradient(45deg, #ff6b6b, #ffa726);
            color: white;
        }

        .sidebar-header h2 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .sidebar-header p {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: #495057;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }

        .menu-item:hover {
            background: #f8f9fa;
            border-left-color: #ff6b6b;
            color: #ff6b6b;
        }

        .menu-item.active {
            background: #fff5f5;
            border-left-color: #ff6b6b;
            color: #ff6b6b;
        }

        .menu-item i {
            width: 20px;
            margin-right: 1rem;
            font-size: 1.1rem;
        }

        .main-content {
            margin-left: 280px;
            flex: 1;
            padding: 2rem;
        }

        .top-bar {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 1rem 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .welcome-text h1 {
            color: #2c3e50;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .welcome-text p {
            color: #6c757d;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(45deg, #ff6b6b, #ffa726);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .profile-container {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .profile-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(45deg, #ff6b6b, #ffa726);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            margin: 0 auto 1rem;
            position: relative;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .profile-avatar:hover {
            transform: scale(1.05);
        }

        .profile-avatar .upload-overlay {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 35px;
            height: 35px;
            background: #28a745;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background 0.3s;
        }

        .profile-avatar .upload-overlay:hover {
            background: #218838;
        }

        .profile-name {
            font-size: 1.5rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .profile-nim {
            color: #6c757d;
            margin-bottom: 1rem;
        }

        .profile-status {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            background: #d4edda;
            color: #155724;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .profile-details {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            color: #2c3e50;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 0.5rem;
            color: #ff6b6b;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            color: #495057;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
            background: #fff;
        }

        .form-input:focus {
            outline: none;
            border-color: #ff6b6b;
            box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.1);
        }

        .form-input:disabled {
            background: #f8f9fa;
            color: #6c757d;
        }

        .btn-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(45deg, #ff6b6b, #ffa726);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.3);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        .stats-section {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .stat-item {
            text-align: center;
            padding: 1rem;
            border-radius: 10px;
            background: #f8f9fa;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: bold;
            color: #ff6b6b;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .mobile-menu-toggle {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1001;
            background: #ff6b6b;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.5rem;
            font-size: 1.2rem;
            cursor: pointer;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                transform: translateX(-100%);
                transition: transform 0.3s;
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .profile-container {
                grid-template-columns: 1fr;
            }

            .mobile-menu-toggle {
                display: block;
            }

            .btn-group {
                flex-direction: column;
            }
        }

        .change-password-section {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin-top: 2rem;
        }

        .alert {
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            display: none;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
 <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="welcome-text">
                    <h1>Profil Saya</h1>
                    <p>Kelola informasi pribadi dan pengaturan akun Anda</p>
                </div>
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <div style="font-weight: 600; color: #2c3e50;"><?= esc($nama); ?></div>
                        <div style="font-size: 0.85rem; color: #6c757d;">NIM: <?= esc($nim); ?></div>
                    </div>
                </div>
            </div>

            <!-- Profile Container -->
            <div class="profile-container">
                <!-- Profile Card -->
                <div class="profile-card">
                    <div class="profile-avatar" id="profileAvatar">
                        <i class="fas fa-user"></i>
                        <div class="upload-overlay" title="Ganti Foto Profil">
                            <i class="fas fa-camera"></i>
                        </div>
                    </div>
                    <input type="file" id="avatarInput" accept="image/*" style="display: none;">
                    <div class="profile-name"><?= esc($nama); ?></div>
                    <div class="profile-nim">NIM: <?= esc($nim); ?></div>
                    <div class="profile-status">Status: Aktif KP</div>
                </div>

                <!-- Profile Details -->
                <div class="profile-details">
                    <div class="section-title">
                        <i class="fas fa-user-cog"></i>
                        Informasi Pribadi
                    </div>

                    <div class="alert alert-success" id="successAlert">
                        <i class="fas fa-check-circle"></i> Profil berhasil diperbarui!
                    </div>

                    <form action="<?= base_url('user/profile/update') ?>" method="post" >
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-input" id="namaLengkap" name="nama" value="<?= esc($nama); ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label">NIM</label>
                            <input type="text" class="form-input" id="nim" name="nim" value="<?= esc($nim); ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-input" id="email" name="email" value="<?= esc($email); ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Kampus</label>
                            <input type="text" class="form-input" id="kampus" name="kampus" value="<?= esc($kampus); ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-input" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap"><?= esc($alamat); ?></textarea>
                        </div>

                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Statistics Section -->
            <div class="stats-section">
                <div class="section-title">
                    <i class="fas fa-chart-bar"></i>
                    Statistik KP Saya
                </div>
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-value">45</div>
                        <div class="stat-label">Hari KP</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">22</div>
                        <div class="stat-label">Hari Hadir</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">91%</div>
                        <div class="stat-label">Kehadiran</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">176</div>
                        <div class="stat-label">Total Jam</div>
                    </div>
                </div>
            </div>

            <!-- Change Password Section -->
            <div class="change-password-section">
                <div class="section-title">
                    <i class="fas fa-lock"></i>
                    Ubah Password
                </div>

                <div class="alert alert-error" id="passwordError">
                    <i class="fas fa-exclamation-circle"></i> <span id="errorMessage"></span>
                </div>

                <form id="passwordForm">
                    <div class="form-group">
                        <label class="form-label">Password Lama</label>
                        <input type="password" class="form-input" id="oldPassword" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password Baru</label>
                        <input type="password" class="form-input" id="newPassword" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-input" id="confirmPassword" required>
                    </div>

                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-key"></i>
                            Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

        <script>
        // Mobile menu toggle
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebar = document.getElementById('sidebar');

        mobileMenuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });

        // Profile form handling
        const profileForm = document.getElementById('profileForm');
        const successAlert = document.getElementById('successAlert');
        const cancelBtn = document.getElementById('cancelBtn');

        let originalData = {
            namaLengkap: document.getElementById('namaLengkap').value,
            email: document.getElementById('email').value,
            telepon: document.getElementById('telepon').value,
            perusahaan: document.getElementById('perusahaan').value,
            alamat: document.getElementById('alamat').value
        };

        // Avatar upload handling
        const profileAvatar = document.getElementById('profileAvatar');
        const avatarInput = document.getElementById('avatarInput');

        profileAvatar.addEventListener('click', function() {
            avatarInput.click();
        });

        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profileAvatar.style.backgroundImage = `url(${e.target.result})`;
                    profileAvatar.style.backgroundSize = 'cover';
                    profileAvatar.style.backgroundPosition = 'center';
                    profileAvatar.innerHTML = '<div class="upload-overlay"><i class="fas fa-camera"></i></div>';
                };
                reader.readAsDataURL(file);
            }
        });

        // Password form handling
        const passwordForm = document.getElementById('passwordForm');
        const passwordError = document.getElementById('passwordError');
        const errorMessage = document.getElementById('errorMessage');

        passwordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const oldPassword = document.getElementById('oldPassword').value;
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            // Reset error display
            passwordError.style.display = 'none';

            // Validate passwords
            if (newPassword !== confirmPassword) {
                errorMessage.textContent = 'Password baru dan konfirmasi password tidak cocok!';
                passwordError.style.display = 'block';
                return;
            }

            if (newPassword.length < 6) {
                errorMessage.textContent = 'Password baru minimal 6 karakter!';
                passwordError.style.display = 'block';
                return;
            }

            // Simulate password change
            setTimeout(() => {
                alert('Password berhasil diubah!');
                passwordForm.reset();
            }, 500);
        });

        // Close alerts when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.alert') && !e.target.closest('form')) {
                successAlert.style.display = 'none';
                passwordError.style.display = 'none';
            }
        });
    </script>
<?= $this->endSection(); ?>