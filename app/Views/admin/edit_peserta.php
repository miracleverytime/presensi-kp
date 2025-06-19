<?= $this->extend('layout/TemplateAdmin'); ?>
<?= $this->section('content'); ?>

<main class="main-content">
    <div class="top-bar">
        <div class="welcome-text">
            <h1>Edit Data Peserta</h1>
            <p>Perbarui informasi peserta KP di bawah ini</p>
        </div>
    </div>

    <div style="margin-top: 30px; background: #fff; padding: 20px; border-radius: 16px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); overflow-x: auto;">
        <h2 style="margin-bottom: 20px;">Edit Data Peserta</h2>
        <form action="<?= base_url('admin/peserta/update/' . $peserta['id']) ?>" method="post">
            <?= csrf_field() ?>

            <div style="display: grid; grid-template-columns: 200px 1fr; row-gap: 20px; column-gap: 20px;">
                <label for="nama" style="font-weight: bold; align-self: center;">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" value="<?= esc($peserta['nama']) ?>" required style="padding: 10px; border-radius: 8px; border: 1px solid #ccc; width: 100%;">

                <label for="nim" style="font-weight: bold; align-self: center;">NIM</label>
                <input type="text" name="nim" id="nim" value="<?= esc($peserta['nim']) ?>" required style="padding: 10px; border-radius: 8px; border: 1px solid #ccc; width: 100%;">

                <label for="email" style="font-weight: bold; align-self: center;">Email</label>
                <input type="email" name="email" id="email" value="<?= esc($peserta['email']) ?>" required style="padding: 10px; border-radius: 8px; border: 1px solid #ccc; width: 100%;">

                <label for="kampus" style="font-weight: bold; align-self: center;">Kampus</label>
                <input type="text" name="kampus" id="kampus" value="<?= esc($peserta['kampus']) ?>" required style="padding: 10px; border-radius: 8px; border: 1px solid #ccc; width: 100%;">

                <label for="alamat" style="font-weight: bold; align-self: start;">Alamat</label>
                <textarea name="alamat" id="alamat" rows="3" required style="padding: 10px; border-radius: 8px; border: 1px solid #ccc; width: 100%;"><?= esc($peserta['alamat']) ?></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 30px;">
                <a href="<?= base_url('admin/peserta') ?>" style="padding: 10px 20px; background: #ccc; color: #333; border-radius: 8px; text-decoration: none;">Batal</a>
                <button type="submit" style="padding: 10px 20px; background: linear-gradient(to right, #ff6b6b, #ffa726); color: white; border: none; border-radius: 8px;">Simpan Perubahan</button>
            </div>
        </form>
    </div>

</main>

<?= $this->endSection(); ?>
