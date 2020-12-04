
                <div class="col-xl-12 col-md-12">
                    <div class="card card-shadow mb-4">
                        <div class="card-header border-0">
                            <div class="custom-title-wrap bar-primary">
                                <div class="custom-title">INDEKS KELUARGA SEHAT - KECAMATAN X</div>
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
                                            <th rowspan="2" class="align-middle text-center">IKS</th>
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
                                            $sql= $db->prepare("SELECT * FROM tb_kelurahan WHERE id_puskesmas=?");
                                            $sql->execute([$id_puskesmas]);
                                            $data2 = $sql->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($data2 as $key2) {
                                        ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $key2['kelurahan']; ?></td>
                                            <?php
                                                $v[1] = "N";
                                                $v[2] = "N";
                                                $v[3] = "N";
                                                $v[4] = "N";
                                                $v[5] = "N";
                                                $v[6] = "N";
                                                $v[7] = "N";
                                                $v[8] = "N";
                                                $v[9] = "N";
                                                $v[10] = "N";
                                                $v[11] = "N";
                                                $v[12] = "N";

                                                $sql= $db->prepare("SELECT * FROM tb_view_survei WHERE kelurahan=?");
                                                $sql->execute([$key2['id_kelurahan']]);
                                                $data3 = $sql->fetchAll(PDO::FETCH_ASSOC);

                                                $iks = 0;
                                                if(count($data3) > 0){
                                                    foreach($data3 as $row){
                                                        if ($row['marital_status'] == '2') {
                                                            if ($row['kb'] == 'Y' || $row['kb'] == 'T') {
                                                                $v[1] = $row['kb'];
                                                            }
                                                        }
                                                    }
                                                    foreach($data3 as $row){
                                                        if ($row['jenis_kelamin'] == '2') {
                                                            if ($row['faskes'] == 'Y' || $row['faskes'] == 'T') {
                                                                $v[2] = $row['faskes'];
                                                            }
                                                        }
                                                    }
                                                    foreach($data3 as $row){
                                                        if ($row['umur_bln'] >= 1 && $row['umur_bln'] <= 6 && $row['umur_thn'] == 0) {
                                                            if ($row['imunisasi'] == 'Y' || $row['imunisasi'] == 'T') {
                                                                $v[3] = $row['imunisasi'];
                                                            }
                                                            if ($row['asi_eksklusif'] == 'Y' || $row['asi_eksklusif'] == 'T') {
                                                                $v[4] = $row['asi_eksklusif'];
                                                            }
                                                        }
                                                    }
                                                    foreach($data3 as $row){
                                                        if ($row['umur_bln'] >= 7 && $row['umur_thn'] == 0) {
                                                            if ($row['pantau_balita'] == 'Y' || $row['pantau_balita'] == 'T') {
                                                                $v[5] = $row['pantau_balita'];
                                                            }
                                                        }
                                                    }
                                                    foreach($data3 as $row){
                                    
                                                        if ($row['obat_tb'] == 'Y' || $row['obat_tb'] == 'T') {
                                                            if ($row['obat_tb'] == 'T') {
                                                                $v[6] = $row['obat_tb'];
                                                                break;
                                                            } else {
                                                                $v[6] = $row['obat_tb'];
                                                            }
                                                        }
                                                    }
                                                    foreach($data3 as $row){
                                                        if ($row['obat_hipertensi'] == 'Y' || $row['obat_hipertensi'] == 'T') {
                                                            if ($row['obat_hipertensi'] == 'T') {
                                                                $v[7] = $row['obat_hipertensi'];
                                                                break;
                                                            } else {
                                                                $v[7] = $row['obat_hipertensi'];
                                                            }
                                                        }
                                                    }
                                                    foreach($data3 as $row){
                                                        if ($row['merokok'] == 'Y' || $row['merokok'] == 'T') {
                                                            if ($row['merokok'] == 'T') {
                                                                $v[9] = $row['merokok'];
                                                                break;
                                                            } else {
                                                                $v[9] = $row['merokok'];
                                                            }
                                                        }
                                                    }
                                                    foreach($data3 as $row){
                                                        if ($row['jkn'] == 'Y' || $row['jkn'] == 'T') {
                                                            if ($row['jkn'] == 'T') {
                                                                $v[10] = $row['jkn'];
                                                                break;
                                                            } else {
                                                                $v[10] = $row['jkn'];
                                                            }
                                                        }
                                                    }
                                                    foreach($data3 as $row){
                                                        if ($row['obat_gjb'] == 'Y' || $row['obat_gjb'] == 'T') {
                                                            if ($row['obat_gjb'] == 'T') {
                                                                $v[8] = $row['obat_gjb'];
                                                                break;
                                                            } else {
                                                                $v[8] = $row['obat_gjb'];
                                                            }
                                                        }
                                                    }
                                                    foreach($data3 as $row){
                                                        if ($row['sat'] == 'Y' || $row['sat'] == 'T') {
                                                            if ($row['sat'] == 'T') {
                                                                $v[11] = $row['sat'];
                                                                break;
                                                            } else {
                                                                $v[11] = $row['sat'];
                                                            }
                                                        }
                                                    }
                                                    foreach($data3 as $row){
                                                        if ($row['js'] == 'Y' || $row['js'] == 'T') {
                                                            if ($row['js'] == 'T') {
                                                                $v[12] = $row['js'];
                                                                break;
                                                            } else {
                                                                $v[12] = $row['js'];
                                                            }
                                                        }
                                                    }
    
                                                    $sumY = 0;
                                                    $sumN = 0;
                                                    for ($i=1; $i <= count($data) ; $i++) { 
                                                        if($v[$i] == 'Y'){
                                                            $sumY++;
                                                        }
                                                        if($v[$i] == 'N'){
                                                            $sumN++;
                                                        }
                                                    }
                                    
                                                    $iks = $sumY/(12-$sumN);
                                                }

                                                foreach ($data as $key) {
                                            ?>
                                            <td class="align-middle text-center"><?php echo $v[$key['no_urut']]; ?></td>
                                            <?php
                                                }
                                            ?>
                                            <td class="align-middle text-center"><?php echo number_format($iks, 3, ',', '.'); ?></td>
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
                </div>