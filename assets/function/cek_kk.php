<?php
    include "config.php";
    date_default_timezone_set('Asia/Jakarta');

    function cariNik($nik){
        $tanggal=date('dmY');
        $kunci1= 's3h44t'.$tanggal;
        $kunci = md5($kunci1);

        $url = "http://220.247.173.10:8181/index.html?user=dkk&kunci=$kunci&akses=nik&nomor_nik={$nik}";
        $fields = array(
            'nik'
        );
        $data = http_build_query($fields);

        $context = stream_context_create(array(
            'http' =>  array(
                'method'  => 'GET',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $data,
            )
        ));

        $result = file_get_contents($url, false, $context);
        $server_output = json_decode($result,true);
        if (isset($server_output['data'][0]['nomor_kk'])) {
            $kk = $server_output['data'][0]['nomor_kk'];
        } else {
            $kk = 0;
        }
        
        return $kk;
    }

    $sql= $db->prepare("SELECT * FROM tb_cek_kk WHERE cek_kk=? ORDER BY survei_id ASC LIMIT 1");
    $sql->execute(['0']);
    $data = $sql->fetchAll(PDO::FETCH_ASSOC);

    $sql= $db->prepare("SELECT * FROM tb_cek_kk WHERE cek_kk=? ORDER BY survei_id ASC");
    $sql->execute(['0']);
    $data2 = $sql->fetchAll(PDO::FETCH_ASSOC);
    $total = count($data2);

    echo 'Total data KK kurang : '.$total.'<br><br>';
    echo 'Hari, Tanggal, Jam : '.date("l , d-m-Y , H:i:s").'<br><br>';
    $tgl = date("Y-m-d H:i:s");
    if ($total > 0) {
        foreach ($data as $row) {
            $kk = cariNik($row['nik']);
            echo 'KK = '.$kk.'<br><br>';
            echo 'NIK = '.$row['nik'].'<br><br>';
            if ($kk != 0) {
                $sql= $db->prepare("INSERT INTO tb_kk(no_kk, puskesmas, kecamatan, kelurahan, tanggal, nama_kk, rt, rw, alamat, no_urut_rt, no_urut_kel, iks_inti, iks_besar, createdAt, createdBy, sts_valid) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $q = $sql->execute([$kk, $row['id_puskesmas'], $row['id_kecamatan'], $row['id_kelurahan'], $row['tgl_survei'], $row['nama_kk'], $row['rt'], $row['rw'], $row['alamat'], $row['no_urut_rt'], $row['no_urut_kel'], $row['iks_inti'], $row['iks_besar'], $tgl, $row['id_user'],'1']);
    
                $sql= $db->prepare("UPDATE sheet1 SET no_kk=?, cek_kk=? WHERE survei_id=?");
                $q2 = $sql->execute([$kk, '1', $row['survei_id']]);
    
                if ($q && $q2) {
                    echo "<script>location.href='cek_kk.php';</script>";
                } else {
                    echo "Error ! survei ID : ".$row['survei_id'];
                    break;
                }
            } else {
                $sql= $db->prepare("UPDATE sheet1 SET cek_kk=? WHERE survei_id=?");
                $q2 = $sql->execute(['2', $row['survei_id']]);
                echo "<script>location.href='cek_kk.php';</script>";
            }
        }
    } else {
        echo "SELESAI !";
        echo "<script>location.href='cek_art.php';</script>";
    }
    
?>