<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row my-2">
        <div class="col">
            <h1 class="">Daftar Orang</h1>
            <div class="row">
                <div class="col-6">
                    <form action="" method="post">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Masukkan keyword pencarian" name="keyword">
                            <button class="btn btn-outline-secondary" type="submit" name="submit">Search</button>
                        </div>
                    </form>
                </div>
                <div class="col-6 text-end">
                    <a href="/orang/export" class="btn btn-primary">Export PDF</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1 + ($batasData * ($currentPage - 1)); ?>
                    <?php foreach ($orang as $o) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= $o['nama']; ?></td>
                            <td><?= $o['alamat']; ?></td>
                            <td><a href="" class="btn btn-success">Detail</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- parameter function links(table, pagination_template) -->
            <?= $pager->links('orang', 'orang_pagination'); ?>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>