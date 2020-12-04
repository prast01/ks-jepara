<?php
    include "config.php";
    date_default_timezone_set('Asia/Jakarta');

    $sql= $db->prepare("SELECT * FROM tb_cek_art WHERE cek_art=? LIMIT 1");
    $sql->execute(['0']);
    $data = $sql->fetchAll(PDO::FETCH_ASSOC);

    $sql= $db->prepare("SELECT COUNT(nik) as jml FROM sheet1 WHERE cek_art=? AND nik!='' AND no_kk!=''");
    $sql->execute(['0']);
    $data2 = $sql->fetch(PDO::FETCH_ASSOC);
    $total = $data2['jml'];

    echo 'Total data ART kurang : '.$total.'<br><br>';
    echo 'Hari, Tanggal, Jam : '.date("l , d-m-Y , H:i:s").'<br><br>';
    if ($total > 0) {
        foreach ($data as $row) {
            echo 'NIK = '.$row['nik'].'<br><br>';
            echo 'NAMA = '.$row['nama_art'].'<br><br>';

            if ($row['jekel'] == "LAKI-LAKI") {
                $jekel = 1;
            } else {
                $jekel = 2;
            }

            if ($row['status_kawin'] == 'BELUM KAWIN') {
                $marital = 1;
            } else if ($row['status_kawin'] == 'KAWIN') {
                $marital = 2;
            } else if ($row['status_kawin'] == 'CERAI HIDUP') {
                $marital = 3;
            } else if ($row['status_kawin'] == 'CERAI MATI') {
                $marital = 4;
            }

            if ($row['usia_hamil'] == '') {
                $hamil = 'T';
            } else {
                $hamil = $row['usia_hamil'];
            }
            
            if (strlen($row['nik']) > 5) {
                $sql= $db->prepare("INSERT INTO tb_art(nik, no_kk, nama, hub_kel, tanggal_lahir, umur_bln, umur_thn, jenis_kelamin, marital_status, wanita_usia_hamil, agama, pendidikan, pekerjaan, keterangan) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $q = $sql->execute([$row['nik'], $row['no_kk'], $row['nama_art'], $row['id_hubkel'], $row['tgl_lahir'], $row['umur_bln'], $row['umur_thn'], $jekel, $marital, $hamil, $row['id_agama'], $row['id_pendidikan'], $row['id_pekerjaan'], $row['keterangan_art']]);
    
                $sql= $db->prepare("UPDATE sheet1 SET cek_art=? WHERE nik=?");
                $q2 = $sql->execute(['1', $row['nik']]);
    
                if ($q && $q2) {
                    echo "<script>location.href='cek_art.php';</script>";
                } else {
                    echo "Error ! survei ID : ".$row['survei_id'];
                    break;
                }
            } else {
                $sql= $db->prepare("UPDATE sheet1 SET cek_art=? WHERE nik=?");
                $q2 = $sql->execute(['2', $row['nik']]);
                echo "<script>location.href='cek_art.php';</script>";
            }
        }
    } else {
        echo "SELESAI !";
        echo "<script>location.href='cek_kk_survei.php';</script>";
    }
    
?>