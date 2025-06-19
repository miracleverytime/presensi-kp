<?= $this->extend('layout/TemplateUser'); ?>       
       
<?= $this->section('content'); ?>
       <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="welcome-text">
                    <h1>Dashboard Peserta</h1>
                    <p>Selamat datang <?= esc($nama) ?>, Jangan lupa presensi hari ini!</p>
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

        </main>
    </div>
<?= $this->endSection(''); ?>