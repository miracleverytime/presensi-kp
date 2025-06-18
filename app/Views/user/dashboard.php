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

            <!-- Check-in Card -->
            <div class="checkin-card">
                <div class="current-time" id="currentTime"></div>
                <div class="current-date" id="currentDate"></div>
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
<?= $this->endSection(''); ?>