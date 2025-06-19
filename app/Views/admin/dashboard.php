<?= $this->extend('layout/TemplateAdmin'); ?>
<?= $this->section('content'); ?>

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

    <!-- Aktivitas Terbaru (Full Width) -->
    <div class="activity-section" style="margin-top: 30px; background: #f5f6f8; border-radius: 12px; padding: 20px;">
        <div class="section-header" style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
            <div class="section-icon"><i class="fas fa-history"></i></div>
            <div class="section-title">Aktivitas Terbaru</div>
        </div>
        <?php if (!empty($aktivitasTerbaru)) : ?>
            <?php foreach ($aktivitasTerbaru as $log): ?>
                <div class="activity-item">
                    <div class="activity-icon 
                        <?= ($log['waktu_keluar']) ? 'checkout' : (($log['status'] === 'terlambat') ? 'checkin' : 'login') ?>">
                        <i class="<?= ($log['waktu_keluar']) ? 'fas fa-sign-out-alt' : (($log['status'] === 'terlambat') ? 'fas fa-clock' : 'fas fa-sign-in-alt') ?>"></i>
                    </div>
                    <div class="activity-details">
                        <h4><?= esc($log['nama']) ?> <?= $log['waktu_keluar'] ? 'Check Out' : 'Check In' ?></h4>
                        <p>
                            <?= date('d M Y', strtotime($log['tanggal'])) ?> –
                            <?= $log['waktu_keluar']
                                ? date('H:i', strtotime($log['waktu_keluar'])) . ' WIB'
                                : date('H:i', strtotime($log['waktu_masuk'])) . ' WIB'
                            ?>
                            –
                            <?= ucfirst($log['status']) ?>
                        </p>
                    </div>
                </div>
            <?php endforeach ?>
        <?php else: ?>
            <p style="margin-top: 10px;">Belum ada aktivitas terbaru.</p>
        <?php endif ?>
    </div>


</main>

<?= $this->endSection(); ?>
