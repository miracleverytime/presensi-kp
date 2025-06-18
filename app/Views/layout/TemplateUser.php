<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User - Si-Kejar</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="<?= base_url('/assets/css/user.css'); ?>" rel="stylesheet">
</head>
<body>
    <button class="mobile-menu-toggle" id="mobileMenuToggle">
        <i class="fas fa-bars"></i>
    </button>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h2>Si-Kejar User</h2>
                <p>Sistem Kehadiran KP</p>
            </div>
            <nav class="sidebar-menu">
                <a href="<?= base_url('user/dashboard') ?>" class="menu-item">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
                <a href="<?= base_url('user/presensi') ?>" class="menu-item">
                    <i class="fas fa-calendar-check"></i>
                    Presensi Hari Ini
                </a>
                <a href="<?= base_url('user/riwayat') ?>" class="menu-item">
                    <i class="fas fa-history"></i>
                    Riwayat Presensi
                </a>
                <a href="<?= base_url('user/profile') ?>" class="menu-item">
                    <i class="fas fa-user-edit"></i>
                    Profil Saya
                </a>
                <a href="<?= base_url('logout') ?>" class="menu-item">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </nav>
        </aside>

        <?= $this->renderSection('content'); ?>

        
    <script>
        // Real-time clock
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID');
            const dateString = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            
            document.getElementById('currentTime').textContent = timeString;
            document.getElementById('currentDate').textContent = dateString;
        }

        // Update time every second
        setInterval(updateTime, 1000);
        updateTime();

    </script>
</body>
</html>