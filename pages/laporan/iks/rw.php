<?php
    if ($level == 1) {
        $sql= $db->prepare("SELECT a.kelurahan FROM tb_kelurahan a WHERE a.id_kecamatan=? AND a.id_kelurahan=?");
        $sql->execute([$_GET['kecamatan'], $_GET['desa']]);
        $dat = $sql->fetch(PDO::FETCH_ASSOC);
    } else {
        $sql= $db->prepare("SELECT a.kelurahan FROM tb_kelurahan a, tb_puskesmas b WHERE a.id_puskesmas=b.id_puskesmas AND b.id_puskesmas=? AND a.id_kelurahan=?");
        $sql->execute([$id_puskesmas, $_GET['desa']]);
        $dat = $sql->fetch(PDO::FETCH_ASSOC);
    }
?>
                <div class="col-md-4 col-xs-12">
                    <a href="javascript: window.history.go(-1)" class="btn btn-danger">Kembali</a>
                </div>
                <div class="col-xl-12 col-md-12">
                    <div class="card card-shadow mb-4">
                        <div class="card-header border-0">
                            <div class="custom-title-wrap bar-primary">
                                <div class="custom-title">INDEKS KELUARGA SEHAT - DESA <?php echo $dat['kelurahan']; ?> RW <?php echo $_GET['rw']; ?></div>
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
                                            <th rowspan="2" class="align-middle text-center">No RT</th>
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
                                                $no = 1;
                                                $total_kk = 0;
                                                if ($level == 1) {
                                                    $sql= $db->prepare("SELECT * FROM tb_kk WHERE kecamatan=? AND kelurahan=? AND rw=? AND sts_valid='1' GROUP BY rt ORDER BY rt ASC");
                                                    $sql->execute([$_GET['kecamatan'], $_GET['desa'], $_GET['rw']]);
                                                } else {
                                                    $sql= $db->prepare("SELECT * FROM tb_kk WHERE puskesmas=? AND kelurahan=? AND rw=? AND sts_valid='1' GROUP BY rt ORDER BY rt ASC");
                                                    $sql->execute([$id_puskesmas, $_GET['desa'], $_GET['rw']]);
                                                }
                                                $data2 = $sql->fetchAll(PDO::FETCH_ASSOC);

                                                foreach ($data as $key) {
                                                    $b['Y'][$key['no_urut']] = 0;
                                                    $b['N'][$key['no_urut']] = 0;
                                                }
    

                                                if (count($data2) == 0) {
                                            ?>
                                            <tr>
                                                <th class="text-center" colspan="<?php echo count($data)+2; ?>">Data Survei Belum Ada</th>
                                            </tr>
                                            <?php
                                                } else {
                                                    foreach ($data2 as $key2) {

                                                        foreach ($data as $key) {
                                                            $a['Y'][$no][$key['no_urut']] = 0;
                                                            $a['N'][$no][$key['no_urut']] = 0;
                                                        }
                                                ?>
                                            <tr>
                                                <td><?php echo $no; ?></td>
                                                <td>
                                                    <?php
                                                        if ($level == 1) {
                                                            $link = "?page=laporan&subpage=iks_wilayah&kecamatan=".$_GET['kecamatan']."&desa=".$key2['kelurahan']."&rw=".$key2['rw']."&rt=".$key2['rt'];
                                                        } else {
                                                            $link = "?page=laporan&subpage=iks_wilayah&desa=".$key2['kelurahan']."&rw=".$key2['rw']."&rt=".$key2['rt'];
                                                        }
                                                    ?>
                                                    <a href="<?php echo $link; ?>"><?php echo $key2['rt']; ?></a>
                                                </td>
                                                <?php

                                                    $sql= $db->prepare("SELECT * FROM tb_view_iks WHERE kelurahan=? AND puskesmas=? AND rw=? AND rt=?");
                                                    $sql->execute([$key2['kelurahan'], $key2['puskesmas'], $key2['rw'], $key2['rt']]);
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
                                                <th colspan="2">% Cakupan Desa <?php echo $dat['kelurahan']; ?> RW <?php echo $_GET['rw']; ?></th>
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
                                        // echo "<pre>";
                                        // print_r($total_kk);
                                        // print_r($a);
                                        // echo "</pre>";
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>