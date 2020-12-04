<?php
    $sql= $db->prepare("SELECT * FROM tb_art a WHERE a.nik=?");
    $sql->execute([$_GET['id']]);
    $data = $sql->fetch(PDO::FETCH_ASSOC);

    $no_kk = $data['no_kk'];

?>
                <div class="col-md-4 col-xs-12">
                    <span class="btn btn-danger" onclick="window.close()">Kembali</span>
                </div>

                <div class="col-xl-12 col-md-12">
                    <div class="card card-shadow mb-4">
                        <div class="card-header border-0">
                            <div class="custom-title-wrap bar-primary">
                                <div class="custom-title">List Data Rumah Tangga</div>
                            </div>
                        </div>
                        <div class="pt-3 pb-4">
                            <div class="table-responsive">
                                <table id="data_table" class="table table-bordered table-striped" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nomor KK</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Puskesmas</th>
                                        <th>Kelurahan</th>
                                        <th>RT/RW</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Nomor KK</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Puskesmas</th>
                                        <th>Kelurahan</th>
                                        <th>RT/RW</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                        $no = 1;

                                        $sql= $db->prepare("SELECT * FROM tb_kk a, tb_puskesmas b, tb_art c, tb_kelurahan d WHERE a.kelurahan=d.id_kelurahan AND a.no_kk=c.no_kk AND a.puskesmas=b.id_puskesmas AND d.id_puskesmas=b.id_puskesmas AND a.no_kk=?");
                                        $sql->execute([$no_kk]);
                                        $data2 = $sql->fetchAll(PDO::FETCH_ASSOC);

                                        foreach ($data2 as $row) {
                                    ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $row['no_kk']; ?></td>
                                        <td><?php echo $row['nik']; ?></td>
                                        <td><?php echo $row['nama']; ?></td>
                                        <td><?php echo $row['puskesmas']; ?></td>
                                        <td><?php echo $row['kelurahan']; ?></td>
                                        <td><?php echo $row['rt'].'/'.$row['rw']; ?></td>
                                        <td>
                                            <?php
                                                if ($row['nik'] == $_GET['id']) {
                                            ?>
                                            <span class="text-success" style="cursor:pointer">Pindahkan KK?</span>
                                            <?php
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                            $no++;
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>