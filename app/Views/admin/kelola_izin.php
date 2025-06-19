<?= $this->extend('layout/TemplateAdmin'); ?>
<?= $this->section('content'); ?>

<main class="main-content">
    <div class="top-bar">
        <div class="welcome-text">
            <h1>Kelola Izin</h1>
            <p>Terima atau tolak permintaan izin dari peserta KP</p>
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

    <div style="margin-top: 30px; background: #fff; padding: 20px; border-radius: 16px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); overflow-x: auto;">
        <h2 style="color: #ff6b6b; margin-bottom: 20px;">Daftar Ajuan Izin</h2>
            <?php if (session()->getFlashdata('success')) : ?>
                <div style="padding: 12px; background: #d4edda; color: #155724; border-radius: 8px; margin-bottom: 16px;">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php elseif (session()->getFlashdata('error')) : ?>
                <div style="padding: 12px; background: #f8d7da; color: #721c24; border-radius: 8px; margin-bottom: 16px;">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif ?>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: linear-gradient(to right, #ff6b6b, #ffa726); color: white;">
                    <th style="padding: 12px; border: 1px solid #ddd;">No</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Nama</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">NIM</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Kampus</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Tanggal</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Jenis</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Alasan</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Status</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($daftarIzin)) : ?>
                    <?php $no = 1; foreach ($daftarIzin as $izin) : ?>
                        <tr>
                            <td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?= $no++ ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= esc($izin['nama']) ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= esc($izin['nim']) ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= esc($izin['kampus']) ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= date('d-m-Y', strtotime($izin['tanggal'])) ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= esc($izin['jenis']) ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= esc($izin['alasan']) ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;">
                                <span style="font-weight: bold; color:
                                    <?= match(strtolower($izin['status'])) {
                                        'pending' => 'orange',
                                        'diterima' => 'green',
                                        'ditolak' => 'red',
                                        default => '#333'
                                    } ?>;">
                                    <?= ucfirst($izin['status']) ?>
                                </span>
                            </td>
                            <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">
                                <?php if ($izin['status'] === 'pending') : ?>
                                    <a href="#" class="btn-izin-setuju" data-id="<?= $izin['id'] ?>" style="color: green;">
                                        <i class="fas fa-check-circle"></i>
                                    </a>
                                    <a href="#" class="btn-izin-tolak" data-id="<?= $izin['id'] ?>" style="color: red;">
                                        <i class="fas fa-times-circle"></i>
                                    </a>
                                <?php else : ?>
                                    <span>-</span>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php else : ?>
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 20px;">Belum ada pengajuan izin.</td>
                    </tr>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Handle tombol setuju
    document.querySelectorAll('.btn-izin-setuju').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const id = this.getAttribute('data-id');

            Swal.fire({
                title: 'Setujui Izin?',
                text: "Izin ini akan ditandai sebagai disetujui.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Ya, Setujui'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `/admin/izin/setuju/${id}`;
                }
            });
        });
    });

    // Handle tombol tolak
    document.querySelectorAll('.btn-izin-tolak').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const id = this.getAttribute('data-id');

            Swal.fire({
                title: 'Tolak Izin?',
                text: "Izin ini akan ditandai sebagai ditolak.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Ya, Tolak'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `/admin/izin/tolak/${id}`;
                }
            });
        });
    });
});
</script>

<?= $this->endSection(); ?>
