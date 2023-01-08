<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row my-2">
        <div class="row">
            <div class="col">
                <h1 class="text-center">Daftar Orang</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= $i = 1; ?>
                        <?php foreach ($orang as $o) : ?>
                            <tr>
                                <th scope="row"><?= $i++; ?></th>
                                <td><?= $o['nama']; ?></td>
                                <td><?= $o['alamat']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?= $this->endSection(); ?>