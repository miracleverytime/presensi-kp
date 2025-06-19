<?= $this->extend('layout/TemplateAdmin'); ?>
<?= $this->section('content'); ?>

<main class="main-content">
    <div class="top-bar">
        <div class="welcome-text">
            <h1 >Kelola Peserta KP</h1>
            <p>Untuk keperlulan mengelola data peserta KP</p>
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

    <!-- Tabel Peserta -->
    <div style="margin-top: 30px; background: #fff; padding: 20px; border-radius: 16px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); overflow-x: auto;">
        <h2 style="margin-bottom: 20px;">Tabel Peserta KP</h2>
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
                    <th style="padding: 12px; border: 1px solid #ddd;">Email</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Kampus</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Alamat</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($peserta)) : ?>
                    <?php $no = 1; foreach ($peserta as $p) : ?>
                        <tr>
                            <td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?= $no++ ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= esc($p['nama']) ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= esc($p['nim']) ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= esc($p['email']) ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= esc($p['kampus']) ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= esc($p['alamat']) ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">
                                <a href="<?= base_url('admin/peserta/edit/' . $p['id']) ?>" title="Edit">
                                    <i class="fas fa-edit" style="color: #ffa726;"></i>
                                </a>
                                &nbsp;
                                <a href="#" class="btn-hapus" data-id="<?= $p['id'] ?>" title="Hapus">
                                    <i class="fas fa-trash" style="color: red;"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px;">Belum ada data peserta.</td>
                    </tr>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</main>

<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('table').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ peserta per halaman",
                zeroRecords: "Tidak ditemukan peserta",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ peserta",
                paginate: {
                    next: "Berikutnya",
                    previous: "Sebelumnya"
                }
            }
        });
    });
        $('.btn-hapus').on('click', function (e) {
        e.preventDefault();
        const pesertaId = $(this).data('id');

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data peserta akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff6b6b',
            cancelButtonColor: '#ccc',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('admin/peserta/delete/') ?>" + pesertaId;
            }
        });
    });
</script>

<?= $this->endSection(); ?>
