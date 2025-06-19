<?= $this->extend('layout/TemplateAdmin'); ?>
<?= $this->section('content'); ?>

<main class="main-content">
    <div class="top-bar">
        <div class="welcome-text">
            <h1>Rekap Presensi</h1>
            <p>Data lengkap kehadiran peserta KP</p>
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

    <!-- Tabel Presensi -->
    <div style="margin-top: 30px; background: #fff; padding: 20px; border-radius: 16px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); overflow-x: auto;">
        <h2 style="margin-bottom: 20px;">Tabel Rekap Kehadiran</h2>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: linear-gradient(to right, #ff6b6b, #ffa726); color: white;">
                    <th style="padding: 12px; border: 1px solid #ddd;">No</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Nama Peserta KP</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">NIM</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Kampus</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Tanggal</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Waktu Masuk</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Waktu Keluar</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Durasi Kerja</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Status</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($rekap)) : ?>
                    <?php $no = 1; foreach ($rekap as $row) : ?>
                        <tr>
                            <td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?= $no++ ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= esc($row['nama']) ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= esc($row['nim']) ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= esc($row['kampus']) ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= $row['waktu_masuk'] ?? '-' ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= $row['waktu_keluar'] ?? '-' ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= $row['durasi_kerja'] ?? '-' ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;">
                                <span style="font-weight: bold; color: 
                                    <?= match(strtolower($row['status'])) {
                                        'hadir' => 'green',
                                        'izin' => 'orange',
                                        'terlambat' => '#ff9800',
                                        'alpha' => 'red',
                                        default => '#333'
                                    } ?>;">
                                    <?= ucfirst($row['status']) ?>
                                </span>
                            </td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= $row['keterangan'] ?? '-' ?></td>
                        </tr>
                    <?php endforeach ?>
                <?php else : ?>
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 20px;">Belum ada data presensi.</td>
                    </tr>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('table').DataTable({
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Tidak ditemukan data",
                "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Berikutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
    });
</script>

<?= $this->endSection(); ?>
