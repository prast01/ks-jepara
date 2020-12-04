<?php
    if ($level == 1) {
        $sql= $db->prepare("SELECT * FROM tb_kecamatan WHERE id_kecamatan=?");
        $sql->execute([$_GET['kecamatan']]);
        $dat = $sql->fetch(PDO::FETCH_ASSOC);
?>
<div class="col-md-4 col-xs-12">
    <a href="javascript: window.history.go(-1)" class="btn btn-danger">Kembali</a>
</div>
<?php
    } else {
        $sql= $db->prepare("SELECT a.kecamatan FROM tkecamatan a, tb_puskesmas b WHERE a.kkecamatan=b.id_kecamatan AND b.id_puskesmas=?");
        $sql->execute([$id_puskesmas]);
        $dat = $sql->fetch(PDO::FETCH_ASSOC);
    }
?>
                <div class="col-xl-12 col-md-12">
                    <div class="card card-shadow mb-4">
                        <div class="card-header border-0">
                            <div class="custom-title-wrap bar-primary">
                                <div class="custom-title">INDEKS KELUARGA SEHAT - KECAMATAN <?php echo $dat['kecamatan']; ?></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="pt-3 pb-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" cellspacing="0">
                                        <thead>
                                        <?php
                                            $sql= $db->prepare("SELECT * FROM tb_indikator");
                                            $sql->execute();
                                            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
                                        ?>
                                        <tr>
                                            <th rowspan="2" class="align-middle text-center">No</th>
                                            <th rowspan="2" class="align-middle text-center">Nama Desa</th>
                                            <th colspan="<?php echo count($data); ?>" class="align-middle text-center">Indikator</th>
                                            <!-- <th rowspan="2" class="align-middle text-center">IKS</th> -->
                                        </tr>
                                        <tr>
                                            <?php
                                                foreach ($data as $key) {
                                            ?>
                                            <td class="align-middle text-center"><?php echo $key['indikator']; ?></td>
                                            <?php
                                                }
                                            ?>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $no=1;
                                            if ($level == 1) {
                                                $sql= $db->prepare("SELECT * FROM tb_kelurahan WHERE id_kecamatan=? ORDER BY id_kelurahan ASC");
                                                $sql->execute([$_GET['kecamatan']]);
                                                $data2 = $sql->fetchAll(PDO::FETCH_ASSOC);
                                            } else {
                                                $sql= $db->prepare("SELECT * FROM tb_kelurahan WHERE id_puskesmas=? ORDER BY id_kelurahan ASC");
                                                $sql->execute([$id_puskesmas]);
                                                $data2 = $sql->fetchAll(PDO::FETCH_ASSOC);
                                            }
                                            

                                            foreach ($data as $key) {
                                                $b['Y'][$key['no_urut']] = 0;
                                                $b['N'][$key['no_urut']] = 0;
                                            }

                                            $total_kk = 0;

                                            foreach ($data2 as $key2) {
                                        ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td>
                                                <?php
                                                    if ($level == 1) {
                                                        $link = "?page=laporan&subpage=iks_wilayah&kecamatan=".$_GET['kecamatan']."&desa=".$key2['id_kelurahan'];
                                                    } else {
                                                        $link = "?page=laporan&subpage=iks_wilayah&desa=".$key2['id_kelurahan'];
                                                    }
                                                ?>
                                                <a href="<?php echo $link; ?>"><?php echo $key2['kelurahan']; ?></a>
                                            </td>
                                            <?php
                                                foreach ($data as $key) {
                                                    $a['Y'][$no][$key['no_urut']] = 0;
                                                    $a['N'][$no][$key['no_urut']] = 0;
                                                }

                                                $sql= $db->prepare("SELECT * FROM tb_view_iks WHERE kelurahan=? AND puskesmas=?");
                                                $sql->execute([$key2['id_kelurahan'], $key2['id_puskesmas']]);
                                                $data3 = $sql->fetchAll(PDO::FETCH_ASSOC);
                                                $total_kk = count($data3) + $total_kk;
                                                $iks =0;

                                                foreach ($data3 as $key) {
                                                    foreach ($data as $key2) {
                                                        $i = 'i'.$key2['no_urut'];
                                                        $sv = $key[$i];
                                                        if ($sv == 'Y') {
                                                            $a['Y'][$no][$key2['no_urut']] = $a['Y'][$no][$key2['no_urut']]+1;
                                                        }
                                                        if ($sv == 'N') {
                                                            $a['N'][$no][$key2['no_urut']] = $a['N'][$no][$key2['no_urut']]+1;
                                                        }
                                                    }
                                                }

                                                foreach ($data as $key) {
                                            ?>
                                            <td class="align-middle text-center"><?php echo $a['Y'][$no][$key['no_urut']]; ?></td>
                                            <?php
                                                }
                                            ?>
                                            <!-- <td class="align-middle text-center"><?php echo number_format($iks, 3, ',', '.'); ?></td> -->
                                        </tr>
                                        <?php
                                                $no++;
                                            }
                                            foreach ($a['Y'] as $key) {
                                                foreach ($data as $key2) {
                                                    $b['Y'][$key2['no_urut']] = $b['Y'][$key2['no_urut']] + $key[$key2['no_urut']];
                                                }
                                            }
                                            foreach ($a['N'] as $key) {
                                                foreach ($data as $key2) {
                                                    $b['N'][$key2['no_urut']] = $b['N'][$key2['no_urut']] + $key[$key2['no_urut']];
                                                }
                                            }
                                        ?>
                                            <tr>
                                                <th colspan="2">Σ Keluarga Bernilai "Y"</th>
                                                <?php
                                                    foreach ($data as $key) {
                                                ?>
                                                <th class="align-middle text-center"><?php echo $b['Y'][$key['no_urut']]; ?></th>
                                                <?php
                                                    }
                                                ?>
                                                <!-- <th></th> -->
                                            </tr>
                                            <tr>
                                                <th colspan="2">Total Keluarga - Σ Keluarga Bernilai "N"</th>
                                                <?php
                                                    foreach ($data as $key) {
                                                        $x[$key['no_urut']] = $total_kk-$b['N'][$key['no_urut']];
                                                ?>
                                                <th class="align-middle text-center"><?php echo $x[$key['no_urut']]; ?></th>
                                                <?php
                                                    }
                                                ?>
                                                <!-- <th></th> -->
                                            </tr>
                                            <tr>
                                                <th colspan="2">% Cakupan Kecamatan <?php echo $dat['kecamatan']; ?></th>
                                                <?php
                                                    foreach ($data as $key) {
                                                        if ($x[$key['no_urut']] == 0 || $b['Y'][$key['no_urut']] == 0) {
                                                            $p = 0;
                                                        } else {
                                                            $p = ($b['Y'][$key['no_urut']]/$x[$key['no_urut']])*100;
                                                        }
                                                ?>
                                                <th class="align-middle text-center"><?php echo number_format($p, 2, ',', '.'); ?></th>
                                                <?php
                                                    }
                                                ?>
                                                <!-- <th></th> -->
                                            </tr>
                                        </tbody>
                                    </table>
                                    <?php
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>