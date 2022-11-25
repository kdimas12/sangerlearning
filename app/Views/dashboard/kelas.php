<?= $this->extend('dashboard/layout/default') ?>

<?= $this->section('content') ?>
<div class="mt-4">
    <table id="datatablesSimple">
        <thead>
            <tr>
                <th>Nama Kelas</th>
                <th>ID Kelas</th>
                <th>Jenis Kelas</th>
                <th>Keterangan</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php foreach ($dataCourses as $key => $course) : ?>

                    <td><?= $course['nama_kelas'] ?></td>
                    <td><?= $course['id_kelas'] ?></td>
                    <td><?= $course['id_jenis'] ?></td>
                    <td><?= $course['ket_kelas'] ?></td>
                    <td><?= $course['harga'] ?></td>
                <?php endforeach ?>
            </tr>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>