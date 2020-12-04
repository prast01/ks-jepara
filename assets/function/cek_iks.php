<?php
    include "config.php";
    date_default_timezone_set('Asia/Jakarta');

    $sql= $db->prepare("SELECT * FROM tb_cek_kk_survei WHERE cek_iks=? ORDER BY survei_id ASC LIMIT 1");
    $sql->execute(['0']);
    $data = $sql->fetchAll(PDO::FETCH_ASSOC);

    $sql= $db->prepare("SELECT * FROM tb_cek_kk_survei WHERE cek_iks=? ORDER BY survei_id ASC");
    $sql->execute(['0']);
    $data2 = $sql->fetchAll(PDO::FETCH_ASSOC);
    $total = count($data2);

    echo 'Total data IKS KK kurang : '.$total.'<br><br>';
    echo 'Hari, Tanggal, Jam : '.date("l , d-m-Y , H:i:s").'<br><br>';
    if ($total > 0) {
        foreach ($data as $row2) {
            echo 'KK = '.$row2['no_kk'].'<br><br>';
            echo 'NAMA = '.$row2['nama_kk'].'<br><br>';
            if ($row2['cek_survei_kk'] == '1') {

                $sql= $db->prepare("SELECT * FROM tb_view_art WHERE no_kk=?");
                $sql->execute([$row2['no_kk']]);
                $data2 = $sql->fetchAll(PDO::FETCH_ASSOC);

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
                
                foreach($data2 as $row){
                    if ($row['marital_status'] == '2') {
                        if ($row['kb'] == 'Y' || $row['kb'] == 'T') {
                            $v[1] = $row['kb'];
                        }
                    }
                }
                foreach($data2 as $row){
                    if ($row['jenis_kelamin'] == '2') {
                        if ($row['faskes'] == 'Y' || $row['faskes'] == 'T') {
                            $v[2] = $row['faskes'];
                        }
                    }
                }
                foreach($data2 as $row){
                    if ($row['umur_bln'] >= 1 && $row['umur_bln'] <= 18 && $row['umur_thn'] == 0) {
                        if ($row['imunisasi'] == 'Y' || $row['imunisasi'] == 'T') {
                            $v[3] = $row['imunisasi'];
                        }
                        if ($row['asi_eksklusif'] == 'Y' || $row['asi_eksklusif'] == 'T') {
                            $v[4] = $row['asi_eksklusif'];
                        }
                    }
                }
                foreach($data2 as $row){
                    if ($row['umur_bln'] >= 7 && $row['umur_thn'] == 0) {
                        if ($row['pantau_balita'] == 'Y' || $row['pantau_balita'] == 'T') {
                            $v[5] = $row['pantau_balita'];
                        }
                    }
                }
                foreach($data2 as $row){

                    if ($row['tb'] == 'Y' || $row['tb'] == 'T') {
                        if ($row['tb'] == 'Y') {
                            $v[6] = $row['obat_tb'];
                            break;
                        } else {
                            if ($row['batuk'] == 'Y') {
                                $v[6] = $row['batuk'];
                            } else {
                                $v[6] = 'N';
                            }
                        }
                    }
                }
                foreach($data2 as $row){
                    if ($row['obat_hipertensi'] == 'Y' || $row['obat_hipertensi'] == 'T') {
                        if ($row['obat_hipertensi'] == 'T') {
                            $v[7] = $row['obat_hipertensi'];
                            break;
                        } else {
                            $v[7] = $row['obat_hipertensi'];
                        }
                    }
                }
                foreach($data2 as $row){
                    if ($row['merokok'] == 'Y' || $row['merokok'] == 'T') {
                        if ($row['merokok'] == 'T') {
                            // $v[9] = $row['merokok'];
                            $v[9] = 'Y';
                            break;
                        } else {
                            // $v[9] = $row['merokok'];
                            $v[9] = 'T';
                        }
                    }
                    
                }
                foreach($data2 as $row){
                    if ($row['jkn'] == 'Y' || $row['jkn'] == 'T') {
                        if ($row['jkn'] == 'T') {
                            $v[10] = $row['jkn'];
                            break;
                        } else {
                            $v[10] = $row['jkn'];
                        }
                    }
                }

                $v[8] = $row2['obat_gjb'];

                if ($row2['sat'] == 'Y') {
                    foreach ($data2 as $row) {
                        if ($row['sab'] == 'Y' || $row['sab'] == 'T') {
                            if ($row['sab'] == 'T') {
                                $v[11] = $row['sab'];
                                break;
                            } else {
                                $v[11] = ($row['sab'] == '') ? 'N' : $row['sab'];
                            }
                        }
                    }
                } else {
                    $v[11] = $row2['sat'];
                }

                if ($row2['js'] == 'Y') {
                    foreach ($data2 as $row) {
                        if ($row['babj'] == 'Y' || $row['babj'] == 'T') {
                            if ($row['babj'] == 'T') {
                                $v[12] = $row['babj'];
                                break;
                            } else {
                                $v[12] = ($row['babj'] == '') ? 'N' : $row['babj'];
                            }
                        }
                    }
                } else {
                    $v[12] = $row2['js'];
                }

                $sql2= $db->prepare("UPDATE tb_iks_inti SET i1=?, i2=?, i3=?, i4=?, i5=?, i6=?, i7=?, i8=?, i9=?, i10=?, i11=?, i12=? WHERE no_kk=?");
                $sql2->execute([$v[1], $v[2], $v[3], $v[4], $v[5], $v[6], $v[7], $v[8], $v[9], $v[10], $v[11], $v[12], $row2['no_kk']]);
                $sql2= $db->prepare("UPDATE tb_iks_besar SET i1=?, i2=?, i3=?, i4=?, i5=?, i6=?, i7=?, i8=?, i9=?, i10=?, i11=?, i12=? WHERE no_kk=?");
                $sql2->execute([$v[1], $v[2], $v[3], $v[4], $v[5], $v[6], $v[7], $v[8], $v[9], $v[10], $v[11], $v[12], $row2['no_kk']]);

                $sql3= $db->prepare("SELECT * FROM tb_indikator");
                $sql3->execute();
                $data3 = $sql3->fetchAll();

                $sumY = 0;
                $sumN = 0;
                for ($i=1; $i <= count($data3) ; $i++) { 
                    if($v[$i] == 'Y'){
                        $sumY++;
                    }
                    if($v[$i] == 'N'){
                        $sumN++;
                    }
                }

                $iks_inti = $sumY/(12-$sumN);
                $iks_besar = $sumY/(12-$sumN);

                $sql= $db->prepare("UPDATE tb_kk SET iks_inti=?, iks_besar=? WHERE no_kk=?");
                $q = $sql->execute([$iks_inti, $iks_besar, $row2['no_kk']]);
    
                $sql= $db->prepare("UPDATE sheet1 SET cek_iks=? WHERE survei_id=?");
                $q2 = $sql->execute(['1', $row2['survei_id']]);
    
                if ($q && $q2) {
                    echo "<script>location.href='cek_iks.php';</script>";
                } else {
                    echo "Error ! survei ID : ".$row2['survei_id'];
                    break;
                }
            } else {
                $sql= $db->prepare("UPDATE sheet1 SET cek_iks=? WHERE survei_id=?");
                $q2 = $sql->execute(['2', $row2['survei_id']]);
                echo "<script>location.href='cek_iks.php';</script>";
            }
        }
    } else {
        echo "SELESAI !";
        echo "<script>location.href='../../../ks-jepara/';</script>";
    }
    
?>