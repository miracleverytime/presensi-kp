<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Si-Kejar</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #6b7b8c 0%, #8a9aa5 100%);
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
            background: linear-gradient(45deg, #ff6b6b, #ee5a52);
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
            justify-content: between;
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
            margin-left: auto;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(45deg, #ff6b6b, #ee5a52);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(45deg, #ff6b6b, #ee5a52);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }

        .stat-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: white;
            margin-right: 1rem;
        }

        .stat-icon.users { background: linear-gradient(45deg, #4ecdc4, #44a08d); }
        .stat-icon.attendance { background: linear-gradient(45deg, #45b7d1, #96c93d); }
        .stat-icon.reports { background: linear-gradient(45deg, #f9ca24, #f0932b); }
        .stat-icon.alerts { background: linear-gradient(45deg, #ff6b6b, #ee5a52); }

        .stat-value {
            font-size: 2.5rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .chart-section, .activity-section {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .section-header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f8f9fa;
        }

        .section-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(45deg, #ff6b6b, #ee5a52);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-right: 1rem;
        }

        .section-title {
            color: #2c3e50;
            font-size: 1.3rem;
            font-weight: 600;
        }

        .chart-placeholder {
            height: 300px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            border: 2px dashed #dee2e6;
        }

        .chart-placeholder i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .activity-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            transition: background 0.3s;
        }

        .activity-item:hover {
            background: #f8f9fa;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: white;
            font-size: 0.9rem;
        }

        .activity-icon.login { background: linear-gradient(45deg, #28a745, #20c997); }
        .activity-icon.checkin { background: linear-gradient(45deg, #17a2b8, #138496); }
        .activity-icon.checkout { background: linear-gradient(45deg, #ffc107, #fd7e14); }
        .activity-icon.user { background: linear-gradient(45deg, #6f42c1, #5a67d8); }

        .activity-details h4 {
            color: #2c3e50;
            font-size: 0.95rem;
            margin-bottom: 0.3rem;
        }

        .activity-details p {
            color: #6c757d;
            font-size: 0.85rem;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .action-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-decoration: none;
            color: inherit;
            transition: transform 0.3s, box-shadow 0.3s;
            text-align: center;
        }

        .action-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            text-decoration: none;
            color: inherit;
        }

        .action-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            background: linear-gradient(45deg, #ff6b6b, #ee5a52);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin: 0 auto 1rem;
        }

        .action-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .action-desc {
            color: #6c757d;
            font-size: 0.9rem;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .content-grid {
                grid-template-columns: 1fr;
            }
            
            .quick-actions {
                grid-template-columns: 1fr;
            }
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

        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: block;
            }
            
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body>
    <button class="mobile-menu-toggle" id="mobileMenuToggle">
        <i class="fas fa-bars"></i>
    </button>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h2>Si-Kejar Admin</h2>
                <p>Control Panel</p>
            </div>
            <nav class="sidebar-menu">
                <a href="#" class="menu-item active">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-users"></i>
                    Kelola Peserta
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-chart-bar"></i>
                    Rekap Presensi
                </a>
                <a href="<?= base_url('logout') ?>" class="menu-item">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="welcome-text">
                    <h1>Dashboard Admin</h1>
                    <p>Selamat datang kembali! Pantau kehadiran peserta KP dengan mudah</p>
                </div>
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div>
                        <div style="font-weight: 600; color: #2c3e50;">Admin User</div>
                        <div style="font-size: 0.85rem; color: #6c757d;">Super Admin</div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon users">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <div class="stat-value">48</div>
                            <div class="stat-label">Total Peserta KP</div>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon attendance">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <div class="stat-value">42</div>
                            <div class="stat-label">Hadir Hari Ini</div>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon reports">
                            <i class="fas fa-percentage"></i>
                        </div>
                        <div>
                            <div class="stat-value">87%</div>
                            <div class="stat-label">Tingkat Kehadiran</div>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon alerts">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div>
                            <div class="stat-value">6</div>
                            <div class="stat-label">Perlu Perhatian</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="content-grid">
                <!-- Chart Section -->
                <div class="chart-section">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="section-title">Grafik Kehadiran Mingguan</div>
                    </div>
                    <div class="chart-placeholder">
                        <i class="fas fa-chart-bar"></i>
                        <p>Grafik kehadiran akan ditampilkan di sini</p>
                        <small>Integrasi dengan Chart.js atau library lainnya</small>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="activity-section">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <div class="section-title">Aktivitas Terbaru</div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon login">
                            <i class="fas fa-sign-in-alt"></i>
                        </div>
                        <div class="activity-details">
                            <h4>Ahmad Fauzi Check In</h4>
                            <p>08:15 WIB - Tepat waktu</p>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon checkin">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="activity-details">
                            <h4>Siti Nurhaliza Check In</h4>
                            <p>08:30 WIB - Terlambat 15 menit</p>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon checkout">
                            <i class="fas fa-sign-out-alt"></i>
                        </div>
                        <div class="activity-details">
                            <h4>Budi Santoso Check Out</h4>
                            <p>17:00 WIB - Selesai</p>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon user">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="activity-details">
                            <h4>User Baru Terdaftar</h4>
                            <p>Rina Melati - Jurusan TI</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <a href="#" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="action-title">Tambah Peserta</div>
                    <div class="action-desc">Daftarkan peserta KP baru</div>
                </a>
                <a href="#" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-file-export"></i>
                    </div>
                    <div class="action-title">Export Laporan</div>
                    <div class="action-desc">Unduh laporan kehadiran</div>
                </a>
                <a href="#" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="action-title">Kirim Pengumuman</div>
                    <div class="action-desc">Broadcast ke semua peserta</div>
                </a>
                <a href="#" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <div class="action-title">Pengaturan Sistem</div>
                    <div class="action-desc">Konfigurasi aplikasi</div>
                </a>
            </div>
        </main>
    </div>

</body>
</html>