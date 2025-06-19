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

    <!-- Content Grid -->
    <div class="content-grid">

        <!-- Recent Activity -->
        <div class="activity-section">
            <div class="section-header">
                <div class="section-icon"><i class="fas fa-history"></i></div>
                <div class="section-title">Aktivitas Terbaru</div>
            </div>
            <?php if (!empty($aktivitasTerbaru)) : ?>
                <?php foreach ($aktivitasTerbaru as $log): ?>
                    <div class="activity-item">
                        <div class="activity-icon <?= esc($log['tipe']) ?>">
                            <i class="<?= esc($log['ikon']) ?>"></i>
                        </div>
                        <div class="activity-details">
                            <h4><?= esc($log['judul']) ?></h4>
                            <p><?= esc($log['waktu']) ?> - <?= esc($log['keterangan']) ?></p>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php else: ?>
                <p style="margin-top: 10px;">Belum ada aktivitas terbaru.</p>
            <?php endif ?>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <a href="<?= base_url('admin/peserta/tambah') ?>" class="action-card">
            <div class="action-icon"><i class="fas fa-user-plus"></i></div>
            <div class="action-title">Tambah Peserta</div>
            <div class="action-desc">Daftarkan peserta KP baru</div>
        </a>
        <a href="<?= base_url('admin/rekap/export') ?>" class="action-card">
            <div class="action-icon"><i class="fas fa-file-export"></i></div>
            <div class="action-title">Export Laporan</div>
            <div class="action-desc">Unduh laporan kehadiran</div>
        </a>
        <a href="<?= base_url('admin/pengumuman') ?>" class="action-card">
            <div class="action-icon"><i class="fas fa-bell"></i></div>
            <div class="action-title">Kirim Pengumuman</div>
            <div class="action-desc">Broadcast ke semua peserta</div>
        </a>
        <a href="<?= base_url('admin/pengaturan') ?>" class="action-card">
            <div class="action-icon"><i class="fas fa-cogs"></i></div>
            <div class="action-title">Pengaturan Sistem</div>
            <div class="action-desc">Konfigurasi aplikasi</div>
        </a>
    </div>
</main>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('grafikKehadiran').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($labelTanggal) ?>,
            datasets: [{
                label: 'Jumlah Hadir',
                data: <?= json_encode($jumlahHadir) ?>,
                borderColor: '#ff6b6b',
                backgroundColor: 'rgba(255,107,107,0.2)',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 1
                }
            }
        }
    });
</script>

<?= $this->endSection(); ?>
