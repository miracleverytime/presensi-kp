<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User - Si-Kejar</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
            background: linear-gradient(45deg, #ff6b6b, #ffa726);
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

        .stat-icon.checkin { background: linear-gradient(45deg, #28a745, #20c997); }
        .stat-icon.hours { background: linear-gradient(45deg, #17a2b8, #138496); }
        .stat-icon.percentage { background: linear-gradient(45deg, #f9ca24, #f0932b); }
        .stat-icon.remaining { background: linear-gradient(45deg, #ff6b6b, #ffa726); }

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
            background: linear-gradient(45deg, #ff6b6b, #ffa726);
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

        .checkin-card {
            background: linear-gradient(135deg, #ff6b6b 0%, #ffa726 100%);
            border-radius: 15px;
            padding: 2rem;
            color: white;
            text-align: center;
            margin-bottom: 2rem;
        }

        .current-time {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .current-date {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        .checkin-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .btn-checkin, .btn-checkout {
            padding: 1rem 2rem;
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

        .btn-checkin {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .btn-checkin:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .btn-checkout {
            background: rgba(255, 255, 255, 0.9);
            color: #ff6b6b;
        }

        .btn-checkout:hover {
            background: white;
        }

        .attendance-history {
            max-height: 400px;
            overflow-y: auto;
        }

        .history-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            background: #f8f9fa;
            transition: background 0.3s;
        }

        .history-item:hover {
            background: #e9ecef;
        }

        .history-date {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            background: linear-gradient(45deg, #ff6b6b, #ffa726);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            margin-right: 1rem;
            font-size: 0.8rem;
        }

        .history-day {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .history-details {
            flex: 1;
        }

        .history-details h4 {
            color: #2c3e50;
            margin-bottom: 0.3rem;
        }

        .history-details p {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .status-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-hadir {
            background: #d4edda;
            color: #155724;
        }

        .status-terlambat {
            background: #fff3cd;
            color: #856404;
        }

        .status-alpha {
            background: #f8d7da;
            color: #721c24;
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
            background: linear-gradient(45deg, #ff6b6b, #ffa726);
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
                transform: translateX(-100%);
                transition: transform 0.3s;
            }
            
            .sidebar.active {
                transform: translateX(0);
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

            .checkin-buttons {
                flex-direction: column;
            }

            .current-time {
                font-size: 2rem;
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
                <h2>Si-Kejar User</h2>
                <p>Sistem Kehadiran KP</p>
            </div>
            <nav class="sidebar-menu">
                <a href="#" class="menu-item active">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-calendar-check"></i>
                    Presensi Hari Ini
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-history"></i>
                    Riwayat Presensi
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-user-edit"></i>
                    Profil Saya
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
                    <h1>Dashboard Peserta</h1>
                    <p>Selamat datang <?= esc($user['nama']) ?>, Jangan lupa presensi hari ini!</p>
                </div>
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <div style="font-weight: 600; color: #2c3e50;">Ahmad Fauzi</div>
                        <div style="font-size: 0.85rem; color: #6c757d;">NIM: 20220001</div>
                    </div>
                </div>
            </div>

            <!-- Check-in Card -->
            <div class="checkin-card">
                <div class="current-time" id="currentTime">08:15:24</div>
                <div class="current-date" id="currentDate">Senin, 8 Juni 2025</div>
                <div class="checkin-buttons">
                    <button class="btn-checkin" id="checkinBtn">
                        <i class="fas fa-sign-in-alt"></i>
                        Check In
                    </button>
                    <button class="btn-checkout" id="checkoutBtn" disabled>
                        <i class="fas fa-sign-out-alt"></i>
                        Check Out
                    </button>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon checkin">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div>
                            <div class="stat-value">22</div>
                            <div class="stat-label">Hari Hadir</div>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon hours">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <div class="stat-value">176</div>
                            <div class="stat-label">Total Jam KP</div>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon percentage">
                            <i class="fas fa-percentage"></i>
                        </div>
                        <div>
                            <div class="stat-value">91%</div>
                            <div class="stat-label">Tingkat Kehadiran</div>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon remaining">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <div>
                            <div class="stat-value">184</div>
                            <div class="stat-label">Jam Tersisa</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <a href="#" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="action-title">Lihat Jadwal</div>
                    <div class="action-desc">Cek jadwal KP minggu ini</div>
                </a>
                <a href="#" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-file-download"></i>
                    </div>
                    <div class="action-title">Download Rekap</div>
                    <div class="action-desc">Unduh rekap kehadiran</div>
                </a>
                <a href="#" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="action-title">Ajukan Izin</div>
                    <div class="action-desc">Form pengajuan izin</div>
                </a>
                <a href="#" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <div class="action-title">Bantuan</div>
                    <div class="action-desc">FAQ dan kontak admin</div>
                </a>
            </div>
        </main>
    </div>

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

        // Check-in/Check-out functionality
        let checkedIn = false;
        const checkinBtn = document.getElementById('checkinBtn');
        const checkoutBtn = document.getElementById('checkoutBtn');

        checkinBtn.addEventListener('click', function() {
            if (!checkedIn) {
                checkedIn = true;
                checkinBtn.disabled = true;
                checkinBtn.innerHTML = '<i class="fas fa-check"></i> Sudah Check In';
                checkoutBtn.disabled = false;
                
                // Show success message (you can replace with a toast notification)
                alert('Check-in berhasil! Selamat bekerja!');
            }
        });

        checkoutBtn.addEventListener('click', function() {
            if (checkedIn) {
                checkedIn = false;
                checkinBtn.disabled = false;
                checkinBtn.innerHTML = '<i class="fas fa-sign-in-alt"></i> Check In';
                checkoutBtn.disabled = true;
                
                // Show success message
                alert('Check-out berhasil! Terima kasih atas kerja kerasnya!');
            }
        });

    </script>
</body>
</html>