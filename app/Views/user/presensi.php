<?= $this->extend('layout/TemplateUser'); ?>       
       
<?= $this->section('content'); ?>
       <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="welcome-text">
                    <h1>Presensi Hari Ini</h1>
                    <p>Lakukan presensi masuk dan keluar untuk <?= esc($nama) ?></p>
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

            <!-- Status Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <!-- Real-time Clock Card -->
            <div class="checkin-card">
                <div class="current-time" id="currentTime">08:15:24</div>
                <div class="current-date" id="currentDate">Senin, 8 Juni 2025</div>
                
                <!-- Location Info -->
                <div class="location-info">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Lokasi: Kantor Pusat</span>
                </div>
            </div>

            <!-- Presensi Form Section -->
            <div class="presensi-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <div class="section-title">Form Presensi</div>
                </div>

                <!-- Presensi Cards Grid -->
                <div class="presensi-grid">
                    <!-- Check In Card -->
                    <div class="presensi-card">
                        <div class="presensi-header checkin-header">
                            <div class="presensi-icon">
                                <i class="fas fa-sign-in-alt"></i>
                            </div>
                            <div>
                                <h3>Presensi Masuk</h3>
                                <p>Waktu masuk kerja</p>
                            </div>
                        </div>
                        
                        <?php if (isset($presensi_hari_ini) && !empty($presensi_hari_ini['waktu_masuk'])): ?>
                            <!-- Already checked in -->
                            <div class="presensi-status completed">
                                <i class="fas fa-check-circle"></i>
                                <div>
                                    <div class="status-text">Sudah Presensi Masuk</div>
                                    <div class="status-time"><?= date('H:i:s', strtotime($presensi_hari_ini['waktu_masuk'])) ?></div>
                                </div>
                            </div>
                        <?php else: ?>
                            <!-- Check in form -->
                            <form action="<?= base_url('user/presensi/checkin') ?>" method="POST" class="presensi-form">
                                <?= csrf_field() ?>
                                <div class="form-group">
                                    <label for="keterangan_masuk">Keterangan (Opsional)</label>
                                    <textarea name="keterangan" id="keterangan_masuk" rows="3" placeholder="Tambahkan keterangan jika diperlukan..."></textarea>
                                </div>
                                <button type="submit" class="btn-presensi btn-checkin">
                                    <i class="fas fa-sign-in-alt"></i>
                                    Presensi Masuk
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>

                    <!-- Check Out Card -->
                    <div class="presensi-card">
                        <div class="presensi-header checkout-header">
                            <div class="presensi-icon">
                                <i class="fas fa-sign-out-alt"></i>
                            </div>
                            <div>
                                <h3>Presensi Keluar</h3>
                                <p>Waktu selesai kerja</p>
                            </div>
                        </div>
                        
                        <?php if (isset($presensi_hari_ini) && !empty($presensi_hari_ini['waktu_keluar'])): ?>
                            <!-- Already checked out -->
                            <div class="presensi-status completed">
                                <i class="fas fa-check-circle"></i>
                                <div>
                                    <div class="status-text">Sudah Presensi Keluar</div>
                                    <div class="status-time"><?= date('H:i:s', strtotime($presensi_hari_ini['waktu_keluar'])) ?></div>
                                </div>
                            </div>
                        <?php elseif (isset($presensi_hari_ini) && !empty($presensi_hari_ini['waktu_masuk'])): ?>
                            <!-- Check out form -->
                            <form action="<?= base_url('user/presensi/checkout') ?>" method="POST" class="presensi-form">
                                <?= csrf_field() ?>
                                <div class="form-group">
                                    <label for="keterangan_keluar">Keterangan (Opsional)</label>
                                    <textarea name="keterangan" id="keterangan_keluar" rows="3" placeholder="Tambahkan keterangan jika diperlukan..."></textarea>
                                </div>
                                <button type="submit" class="btn-presensi btn-checkout">
                                    <i class="fas fa-sign-out-alt"></i>
                                    Presensi Keluar
                                </button>
                            </form>
                        <?php else: ?>
                            <!-- Cannot check out without check in -->
                            <div class="presensi-status disabled">
                                <i class="fas fa-lock"></i>
                                <div>
                                    <div class="status-text">Belum Presensi Masuk</div>
                                    <div class="status-desc">Lakukan presensi masuk terlebih dahulu</div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Today's Summary -->
            <?php if (isset($presensi_hari_ini) && !empty($presensi_hari_ini)): ?>
            <div class="summary-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="section-title">Ringkasan Hari Ini</div>
                </div>
                
                <div class="summary-grid">
                    <div class="summary-card">
                        <div class="summary-icon checkin">
                            <i class="fas fa-sign-in-alt"></i>
                        </div>
                        <div class="summary-content">
                            <div class="summary-label">Waktu Masuk</div>
                            <div class="summary-value">
                                <?= !empty($presensi_hari_ini['waktu_masuk']) ? date('H:i', strtotime($presensi_hari_ini['waktu_masuk'])) : '-' ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="summary-card">
                        <div class="summary-icon checkout">
                            <i class="fas fa-sign-out-alt"></i>
                        </div>
                        <div class="summary-content">
                            <div class="summary-label">Waktu Keluar</div>
                            <div class="summary-value">
                                <?= !empty($presensi_hari_ini['waktu_keluar']) ? date('H:i', strtotime($presensi_hari_ini['waktu_keluar'])) : '-' ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="summary-card">
                        <div class="summary-icon duration">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="summary-content">
                            <div class="summary-label">Total Jam Kerja</div>
                            <div class="summary-value">
                                <?php 
                                if (!empty($presensi_hari_ini['waktu_masuk']) && !empty($presensi_hari_ini['waktu_keluar'])) {
                                    $masuk = strtotime($presensi_hari_ini['waktu_masuk']);
                                    $keluar = strtotime($presensi_hari_ini['waktu_keluar']);
                                    $durasi = $keluar - $masuk;
                                    $jam = floor($durasi / 3600);
                                    $menit = floor(($durasi % 3600) / 60);
                                    echo "{$jam}j {$menit}m";
                                } else {
                                    echo '-';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="summary-card">
                        <div class="summary-icon status">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="summary-content">
                            <div class="summary-label">Status</div>
                            <div class="summary-value">
                                <span class="status-badge status-<?= strtolower($presensi_hari_ini['status'] ?? 'belum') ?>">
                                    <?= $presensi_hari_ini['status'] ?? 'Belum Presensi' ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <a href="<?= base_url('user/dashboard') ?>" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="action-title">Dashboard</div>
                    <div class="action-desc">Kembali ke dashboard</div>
                </a>
                <a href="<?= base_url('user/riwayat') ?>" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-history"></i>
                    </div>
                    <div class="action-title">Riwayat Presensi</div>
                    <div class="action-desc">Lihat riwayat kehadiran</div>
                </a>
                <a href="<?= base_url('user/izin') ?>" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-file-medical"></i>
                    </div>
                    <div class="action-title">Pengajuan Izin</div>
                    <div class="action-desc">Ajukan izin tidak hadir</div>
                </a>
                <a href="<?= base_url('user/bantuan') ?>" class="action-card">
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

        // Auto-hide success/error messages after 5 seconds
        setTimeout(function() {
            const messages = document.querySelectorAll('.success-message, .error-message');
            messages.forEach(function(message) {
                message.style.transition = 'opacity 0.5s';
                message.style.opacity = '0';
                setTimeout(function() {
                    message.remove();
                }, 500);
            });
        }, 5000);
    </script>
<?= $this->endSection(''); ?>