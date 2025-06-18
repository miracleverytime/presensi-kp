<?= $this->extend('layout/TemplateAdmin'); ?>
<?= $this->section('content'); ?>
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
<?= $this->endSection(); ?>