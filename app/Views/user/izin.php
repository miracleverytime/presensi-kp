<?= $this->extend('layout/TemplateUser'); ?>

<?= $this->section('content'); ?>
<main class="main-content">
    <div class="top-bar">
        <div class="welcome-text">
            <h1>Pengajuan Izin</h1>
            <p>Ajukan izin ketidakhadiran Kerja Praktik Anda</p>
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

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="error-message">
            <i class="fas fa-exclamation-triangle"></i>
            <ul style="margin: 0; padding-left: 20px;">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="presensi-section">
        <div class="section-header">
            <div class="section-icon">
                <i class="fas fa-file-medical"></i>
            </div>
            <div class="section-title">Form Pengajuan Izin</div>
        </div>

        <form action="<?= base_url('user/izin/ajukan') ?>" method="POST" class="presensi-form">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="tanggal">Tanggal Izin</label>
                <input type="date" 
                       name="tanggal" 
                       id="tanggal" 
                       class="form-control" 
                       value="<?= old('tanggal') ?>"
                       min="<?= date('Y-m-d') ?>"
                       required>
                <small class="form-text">Pilih tanggal yang akan diizinkan (tidak boleh masa lalu)</small>
            </div>

            <div class="form-group">
                <label for="jenis">Jenis Izin</label>
                <select name="jenis" id="jenis" class="form-control" required>
                    <option value="">-- Pilih Jenis --</option>
                    <option value="Izin" <?= old('jenis') == 'Izin' ? 'selected' : '' ?>>Izin</option>
                    <option value="Sakit" <?= old('jenis') == 'Sakit' ? 'selected' : '' ?>>Sakit</option>
                </select>
            </div>

            <div class="form-group">
                <label for="alasan">Alasan</label>
                <textarea name="alasan" 
                         id="alasan" 
                         rows="4" 
                         class="form-control" 
                         placeholder="Tuliskan alasan izin Anda (minimal 10 karakter)..." 
                         maxlength="500"
                         required><?= old('alasan') ?></textarea>
                <small class="form-text">
                    <span id="char-count">0</span>/500 karakter
                </small>
            </div>

            <button type="submit" class="btn-presensi btn-checkin" id="submit-btn">
                <i class="fas fa-paper-plane"></i> Ajukan Izin
            </button>
        </form>
    </div>

    <!-- Daftar Izin -->
    <?php if (!empty($daftarIzin)): ?>
    <div class="presensi-section" style="margin-top: 2rem;">
        <div class="section-header">
            <div class="section-icon">
                <i class="fas fa-list"></i>
            </div>
            <div class="section-title">Riwayat Pengajuan Izin</div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Alasan</th>
                        <th>Status</th>
                        <th>Tanggal Pengajuan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($daftarIzin as $izin): ?>
                    <tr>
                        <td><?= date('d/m/Y', strtotime($izin['tanggal'])) ?></td>
                        <td>
                            <span class="badge <?= $izin['jenis'] == 'Sakit' ? 'badge-warning' : 'badge-info' ?>">
                                <?= esc($izin['jenis']) ?>
                            </span>
                        </td>
                        <td><?= esc(substr($izin['alasan'], 0, 50)) ?><?= strlen($izin['alasan']) > 50 ? '...' : '' ?></td>
                        <td>
                            <?php
                            $statusClass = '';
                            switch($izin['status']) {
                                case 'pending': $statusClass = 'badge-warning'; break;
                                case 'approved': $statusClass = 'badge-success'; break;
                                case 'rejected': $statusClass = 'badge-danger'; break;
                                default: $statusClass = 'badge-secondary';
                            }
                            ?>
                            <span class="badge <?= $statusClass ?>">
                                <?= ucfirst(esc($izin['status'])) ?>
                            </span>
                        </td>
                        <td><?= isset($izin['created_at']) ? date('d/m/Y H:i', strtotime($izin['created_at'])) : '-' ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

    <div class="quick-actions">
        <a href="<?= base_url('user/dashboard') ?>" class="action-card">
            <div class="action-icon">
                <i class="fas fa-home"></i>
            </div>
            <div class="action-title">Dashboard</div>
            <div class="action-desc">Kembali ke beranda</div>
        </a>
        <a href="<?= base_url('user/presensi') ?>" class="action-card">
            <div class="action-icon">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <div class="action-title">Presensi</div>
            <div class="action-desc">Cek presensi harian</div>
        </a>
    </div>
</main>

<script>
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

    // Character counter for textarea
    const textarea = document.getElementById('alasan');
    const charCount = document.getElementById('char-count');
    const submitBtn = document.getElementById('submit-btn');

    textarea.addEventListener('input', function() {
        const length = this.value.length;
        charCount.textContent = length;
        
        if (length < 10) {
            charCount.style.color = '#dc3545';
            submitBtn.disabled = true;
        } else if (length >= 500) {
            charCount.style.color = '#dc3545';
        } else {
            charCount.style.color = '#28a745';
            submitBtn.disabled = false;
        }
    });

    // Form validation
    document.querySelector('.presensi-form').addEventListener('submit', function(e) {
        const tanggal = document.getElementById('tanggal').value;
        const jenis = document.getElementById('jenis').value;
        const alasan = document.getElementById('alasan').value.trim();

        if (!tanggal || !jenis || alasan.length < 10) {
            e.preventDefault();
            alert('Mohon lengkapi semua field dengan benar.');
            return false;
        }

        // Confirm submission
        if (!confirm('Apakah Anda yakin ingin mengajukan izin ini?')) {
            e.preventDefault();
            return false;
        }

    });

</script>

<style>
.table-responsive {
    overflow-x: auto;
    margin-top: 1rem;
}

.table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.table th,
.table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #eee;
}

.table th {
    background: #f8f9fa;
    font-weight: 600;
    color: #495057;
}

.badge {
    display: inline-block;
    padding: 0.25em 0.6em;
    font-size: 0.75em;
    font-weight: 700;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.25rem;
}

.badge-success { background-color: #28a745; color: white; }
.badge-warning { background-color: #ffc107; color: #212529; }
.badge-danger { background-color: #dc3545; color: white; }
.badge-info { background-color: #17a2b8; color: white; }
.badge-secondary { background-color: #6c757d; color: white; }

.form-text {
    display: block;
    margin-top: 0.25rem;
    font-size: 0.875em;
    color: #6c757d;
}

.btn-presensi:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
</style>
<?= $this->endSection(); ?>