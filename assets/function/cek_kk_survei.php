<?php
    include "config.php";
    date_default_timezone_set('Asia/Jakarta');

    $sql= $db->prepare("SELECT * FROM tb_cek_kk_survei WHERE cek_survei_kk=? ORDER BY survei_id ASC LIMIT 1");
    $sql->execute(['0']);
    $data = $sql->fetchAll(PDO::FETCH_ASSOC);

    $sql= $db->prepare("SELECT * FROM tb_cek_kk_survei WHERE cek_survei_kk=? ORDER BY survei_id ASC");
    $sql->execute(['0']);
    $data2 = $sql->fetchAll(PDO::FETCH_ASSOC);
    $total = count($data2);

    echo 'Total data Survei KK kurang : '.$total.'<br><br>';
    echo 'Hari, Tanggal, Jam : '.date("l , d-m-Y , H:i:s").'<br><br>';
    $tgl = date("Y-m-d H:i:s");
    if ($total > 0) {
        foreach ($data as $row) {
            echo 'KK = '.$row['no_kk'].'<br><br>';
            echo 'NAMA = '.$row['nama_kk'].'<br><br>';
            if ($row['jml_art'] != '') {

                $sql= $db->prepare("INSERT INTO tb_survey_kk(no_kk, jml_art, jml_art_wawancara, jml_art_dewasa, jml_art_10_54_thn, jml_art_12_59_bln, jml_art_0_11_bln, sab, sat, jk, js, gjb, obat_gjb, pasung, keterangan) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $q = $sql->execute([$row['no_kk'], $row['jml_art'], $row['jml_art_wawancara'], $row['jml_art_dewasa'], $row['jml_art_10_54'], $row['jml_art_12_59'], $row['jml_art_0_11'], $row['sab'], $row['sat'], $row['jk'], $row['js'], $row['gjb'], $row['obat_gjb'], $row['pasung'], $row['keterangan_kk']]);
    
                $sql= $db->prepare("UPDATE sheet1 SET cek_survei_kk=? WHERE survei_id=?");
                $q2 = $sql->execute(['1', $row['survei_id']]);
    
                if ($q && $q2) {
                    $sql= $db->prepare("INSERT INTO tb_iks_inti(no_kk) VALUES(?)");
                    $sql->execute([$row['no_kk']]);
                    $sql= $db->prepare("INSERT INTO tb_iks_besar(no_kk) VALUES(?)");
                    $sql->execute([$row['no_kk']]);
                    echo "<script>location.href='cek_kk_survei.php';</script>";
                } else {
                    echo "Error ! survei ID : ".$row['survei_id'];
                    break;
                }
            } else {
                $sql= $db->prepare("UPDATE sheet1 SET cek_survei_kk=? WHERE survei_id=?");
                $q2 = $sql->execute(['2', $row['survei_id']]);
                echo "<script>location.href='cek_kk_survei.php';</script>";
            }
        }
    } else {
        echo "SELESAI !";
        echo "<script>location.href='cek_art_survei.php';</script>";
    }
    
?>