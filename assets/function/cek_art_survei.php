<?php
    include "config.php";
    date_default_timezone_set('Asia/Jakarta');

    $sql= $db->prepare("SELECT * FROM tb_cek_art_survei WHERE cek_survei_art=? LIMIT 1");
    $sql->execute(['0']);
    $data = $sql->fetchAll(PDO::FETCH_ASSOC);

    $sql= $db->prepare("SELECT COUNT(nik) as jml FROM sheet1 WHERE cek_survei_art=? AND nik!='' AND no_kk!=''");
    $sql->execute(['0']);
    $data2 = $sql->fetch(PDO::FETCH_ASSOC);
    $total = $data2['jml'];

    echo 'Total data Survei ART kurang : '.$total.'<br><br>';
    echo 'Hari, Tanggal, Jam : '.date("l , d-m-Y , H:i:s").'<br><br>';
    if ($total > 0) {
        foreach ($data as $row) {
            echo 'NIK = '.$row['nik'].'<br><br>';
            echo 'NAMA = '.$row['nama_art'].'<br><br>';

            if($row['jml_art'] != ''){
                $sql= $db->prepare("INSERT INTO tb_survey_art(nik, no_kk, jkn, merokok, babj, sab, tb, obat_tb, batuk, hipertensi, obat_hipertensi, tekanan_darah, sistolik, diastolik, kb, faskes, asi_eksklusif, imunisasi, pantau_balita, keterangan) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $q = $sql->execute([$row['nik'], $row['no_kk'], $row['jkn'], $row['merokok'], $row['babj'], $row['sab1'], $row['tb'], $row['obat_tb'], $row['batuk'], $row['hipertensi'], $row['obat_hipertensi'], $row['tekanan_darah'], $row['sistolik'], $row['diastolik'], $row['kb'], $row['faskes'], $row['asi'], $row['imunisasi'], $row['pantau_balita'], $row['keterangan_survei']]);
    
                $sql= $db->prepare("UPDATE sheet1 SET cek_survei_art=? WHERE nik=?");
                $q2 = $sql->execute(['1', $row['nik']]);
    
                if ($q && $q2) {
                    echo "<script>location.href='cek_art_survei.php';</script>";
                } else {
                    echo "Error ! survei ID : ".$row['survei_id'];
                    break;
                }
            } else {
                $sql= $db->prepare("UPDATE sheet1 SET cek_survei_art=? WHERE nik=?");
                $q2 = $sql->execute(['2', $row['nik']]);
                echo "<script>location.href='cek_art_survei.php';</script>";
            }

        }
    } else {
        echo "SELESAI !";
        echo "<script>location.href='cek_iks.php';</script>";
    }
    
?>