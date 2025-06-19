<?= $this->extend('layout/TemplateUser'); ?>       
       
<?= $this->section('content'); ?>
<style>
    /* Page Header */
    .page-header {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        z-index: 1;
    }

    .header-title h1 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .header-title p {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    /* Filter Section */
    .filter-section {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        align-items: end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
    }

    .filter-group label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .filter-group input,
    .filter-group select {
        padding: 0.75rem 1rem;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }

    .filter-group input:focus,
    .filter-group select:focus {
        outline: none;
        border-color: #ff6b6b;
    }

    .filter-btn {
        background: linear-gradient(135deg, #ff6b6b, #ff8e53);
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .filter-btn:hover {
        transform: translateY(-2px);
    }

    /* Statistics Cards */
    .stats-overview {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.5rem;
        color: white;
    }

    .stat-icon.hadir { background: linear-gradient(135deg, #28a745, #20c997); }
    .stat-icon.sakit { background: linear-gradient(135deg, #ffc107, #fd7e14); }
    .stat-icon.izin { background: linear-gradient(135deg, #17a2b8, #007bff); }
    .stat-icon.alpha { background: linear-gradient(135deg, #dc3545, #e83e8c); }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: #6c757d;
        font-weight: 500;
    }

    /* History Table */
    .history-section {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-title i {
        color: #ff6b6b;
    }

    .table-container {
        overflow-x: auto;
        border-radius: 15px;
        border: 1px solid #e9ecef;
    }

    .history-table {
        width: 100%;
        border-collapse: collapse;
    }

    .history-table th {
        background: linear-gradient(135deg, #ff6b6b, #ff8e53);
        color: white;
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .history-table th:first-child {
        border-top-left-radius: 15px;
    }

    .history-table th:last-child {
        border-top-right-radius: 15px;
    }

    .history-table td {
        padding: 1rem;
        border-bottom: 1px solid #e9ecef;
        vertical-align: middle;
    }

    .history-table tr:hover {
        background: rgba(255, 107, 107, 0.05);
    }

    .status-badge {
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        text-align: center;
        min-width: 80px;
        display: inline-block;
    }

    .status-hadir {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }

    .status-sakit {
        background: rgba(255, 193, 7, 0.1);
        color: #ffc107;
    }

    .status-izin {
        background: rgba(23, 162, 184, 0.1);
        color: #17a2b8;
    }

    .status-alpha {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }

    .time-display {
        font-family: 'Courier New', monospace;
        font-weight: 600;
        color: #2c3e50;
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
        margin-top: 2rem;
    }

    .pagination button {
        padding: 0.5rem 1rem;
        border: 2px solid #e9ecef;
        background: white;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .pagination button:hover:not(:disabled) {
        border-color: #ff6b6b;
        color: #ff6b6b;
    }

    .pagination button.active {
        background: #ff6b6b;
        border-color: #ff6b6b;
        color: white;
    }

    .pagination button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .header-content {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .filter-grid {
            grid-template-columns: 1fr;
        }

        .stats-overview {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<!-- Main Content -->
<main class="main-content">
    <div class="top-bar">
        <div class="welcome-text">
            <h1>Riwayat Presensi</h1>
            <p>Riwayat presensi peserta KP</p>
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

    <!-- Statistics Overview -->
    <div class="stats-overview">
        <div class="stat-card">
            <div class="stat-icon hadir">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-value"><?= $totalHadir ?? 22 ?></div>
            <div class="stat-label">Hari Hadir</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon sakit">
                <i class="fas fa-thermometer-half"></i>
            </div>
            <div class="stat-value"><?= $totalSakit ?? 2 ?></div>
            <div class="stat-label">Sakit</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon izin">
                <i class="fas fa-calendar-times"></i>
            </div>
            <div class="stat-value"><?= $totalIzin ?? 1 ?></div>
            <div class="stat-label">Izin</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon alpha">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-value"><?= $totalAlpha ?? 0 ?></div>
            <div class="stat-label">Alpha</div>
        </div>
    </div>

    <!-- History Table -->
    <div class="history-section">
        <h2 class="section-title">
            <i class="fas fa-list"></i>
            Detail Riwayat Presensi
        </h2>
        <div class="table-container">
            <table class="history-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Hari</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Total Jam</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody id="historyTableBody">
                    <?php if (isset($riwayatPresensi) && !empty($riwayatPresensi)): ?>
                        <?php foreach ($riwayatPresensi as $presensi): ?>
                            <tr>
                                <td><?= date('d M Y', strtotime($presensi['tanggal'])) ?></td>
                                <td><?= $presensi['hari'] ?></td>
                                <td>
                                    <span class="time-display">
                                        <?= $presensi['jam_masuk'] ? date('H:i', strtotime($presensi['jam_masuk'])) : '-' ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="time-display">
                                        <?= $presensi['jam_keluar'] ? date('H:i', strtotime($presensi['jam_keluar'])) : '-' ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="time-display">
                                        <?= $presensi['total_jam'] ?? '0 jam' ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge status-<?= strtolower($presensi['status']) ?>">
                                        <?= ucfirst($presensi['status']) ?>
                                    </span>
                                </td>
                                <td><?= $presensi['keterangan'] ?? '-' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Sample Data -->
                        <tr>
                            <td>18 Jun 2025</td>
                            <td>Rabu</td>
                            <td><span class="time-display">08:15</span></td>
                            <td><span class="time-display">16:30</span></td>
                            <td><span class="time-display">8 jam 15 menit</span></td>
                            <td><span class="status-badge status-hadir">Hadir</span></td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>17 Jun 2025</td>
                            <td>Selasa</td>
                            <td><span class="time-display">08:00</span></td>
                            <td><span class="time-display">16:00</span></td>
                            <td><span class="time-display">8 jam</span></td>
                            <td><span class="status-badge status-hadir">Hadir</span></td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>16 Jun 2025</td>
                            <td>Senin</td>
                            <td><span class="time-display">-</span></td>
                            <td><span class="time-display">-</span></td>
                            <td><span class="time-display">0 jam</span></td>
                            <td><span class="status-badge status-sakit">Sakit</span></td>
                            <td>Demam tinggi</td>
                        </tr>
                        <tr>
                            <td>15 Jun 2025</td>
                            <td>Minggu</td>
                            <td colspan="6" style="text-align: center; color: #6c757d; font-style: italic;">Hari Libur</td>
                        </tr>
                        <tr>
                            <td>14 Jun 2025</td>
                            <td>Sabtu</td>
                            <td colspan="6" style="text-align: center; color: #6c757d; font-style: italic;">Hari Libur</td>
                        </tr>
                        <tr>
                            <td>13 Jun 2025</td>
                            <td>Jumat</td>
                            <td><span class="time-display">08:10</span></td>
                            <td><span class="time-display">16:15</span></td>
                            <td><span class="time-display">8 jam 5 menit</span></td>
                            <td><span class="status-badge status-hadir">Hadir</span></td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>12 Jun 2025</td>
                            <td>Kamis</td>
                            <td><span class="time-display">-</span></td>
                            <td><span class="time-display">-</span></td>
                            <td><span class="time-display">0 jam</span></td>
                            <td><span class="status-badge status-izin">Izin</span></td>
                            <td>Keperluan keluarga</td>
                        </tr>
                        <tr>
                            <td>11 Jun 2025</td>
                            <td>Rabu</td>
                            <td><span class="time-display">08:05</span></td>
                            <td><span class="time-display">16:20</span></td>
                            <td><span class="time-display">8 jam 15 menit</span></td>
                            <td><span class="status-badge status-hadir">Hadir</span></td>
                            <td>-</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <button disabled><i class="fas fa-chevron-left"></i></button>
            <button class="active">1</button>
            <button>2</button>
            <button>3</button>
            <button><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>
</main>

<script>
function filterData() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    const status = document.getElementById('statusFilter').value;
    
    // Implementasi filter data - bisa dikirim ke controller
    const filterParams = new URLSearchParams({
        start_date: startDate,
        end_date: endDate,
        status: status
    });
    
    // Redirect dengan parameter filter
    window.location.href = '<?= base_url('riwayat-presensi') ?>?' + filterParams.toString();
}
</script>

<?= $this->endSection(''); ?>