<?php
    session_start();
    include ("config.php");
    include ("service.php");
    $page = (isset($_POST['page'])) ? $_POST['page'] : '' ;
    date_default_timezone_set('Asia/Jakarta');
    // $page = (isset($_GET['page'])) ? $_GET['page'] : '' ;

    switch ($page) {
        case 'login':
            $email = mysqli_real_escape_string($con, $_POST['email']);
            $password = mysqli_real_escape_string($con, $_POST['password']);

            $query = mysqli_query($con, "SELECT * FROM tb_user WHERE email='$email' AND password='$password'");
            $res = 0;
            if (mysqli_num_rows($query) > 0) {
                $data = mysqli_fetch_assoc($query);
                if ($password != $data['password'] && $email != $data['email']) {
                    $res = 0;
                } else {
                    $res = 1;

                    $_SESSION['id_user'] = $data['id_user'];
                    $_SESSION['LAST_ACTIVITY'] = $_SERVER['REQUEST_TIME'];
                    // $_SESSION['level'] = $data['id_jenis_user'];
                    // $_SESSION['id_puskesmas'] = $data['id_puskesmas'];
                }
                
            } else {
                $res = 0;
            }
            
            if ($res) {
                $msg = array('res'=>1, 'msg' => 'Selamat Datang di Aplikasi Keluarga Sehat Jepara');
            } else {
                $msg = array('res'=>0, 'msg' => 'Login gagal ! Silahkan cek email atau password anda.');
            }
            
            echo json_encode($msg);
            break;
        case 'logout':
            session_destroy();

            $msg = array('res'=>1, 'msg' => 'Anda Berhasil Keluar');

            echo json_encode($msg);

            break;
        case 'user':
            $id_puskesmas = $_POST['id_puskesmas'];
            $email = mysqli_real_escape_string($con, $_POST['email']);
            $password = mysqli_real_escape_string($con, $_POST['password']);
            $nama_user = mysqli_real_escape_string($con, $_POST['nama']);
            $id_jenis_user = $_POST['id_jenis_user'];

            $cek = mysqli_query($con, "SELECT * FROM tb_user WHERE email='$email'");

            $res = 0;

            if (mysqli_num_rows($cek) > 0) {
                $res = 0;
            } else {
                $query = mysqli_query($con, "INSERT INTO tb_user(id_jenis_user, id_puskesmas, nama_user, email, password) VALUES('$id_jenis_user', '$id_puskesmas', '$nama_user', '$email', '$password')");
                if ($query) {
                    $res = 1;
                } else {
                    $res = 0;
                }
            }

            if ($res) {
                $msg = array('res'=>1, 'msg' => 'Data Berhasil Disimpan');
            } else {
                $msg = array('res'=>0, 'msg' => 'Data Gagal Disimpan');
            }
            
            echo json_encode($msg);
            break;

        case 'user-del':
            $id = $_POST['id'];
            $query = mysqli_query($con, "DELETE FROM tb_user WHERE id_user='$id'");

            if ($query) {
                $msg = array('res'=>1, 'msg' => 'Data Berhasil Dihapus');
            } else {
                $msg = array('res'=>0, 'msg' => 'Data Gagal Dihapus');
            }
            
            echo json_encode($msg);
            break;

        case 'user-edit':
            $id = $_POST['id'];
            $id_puskesmas = $_POST['id_puskesmas'];
            $email = mysqli_real_escape_string($con, $_POST['email']);
            $nama_user = mysqli_real_escape_string($con, $_POST['nama']);
            $id_jenis_user = $_POST['id_jenis_user'];

            $cek = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM tb_user WHERE id_user='$id'"));

            $res = 0;

            if ($cek['email'] != $email) {
                $cek2 = mysqli_query($con, "SELECT * FROM tb_user WHERE email='$email'");
                if (mysqli_num_rows($cek2) > 0) {
                    $res = 0;
                } else {
                    $query = mysqli_query($con, "UPDATE tb_user SET id_jenis_user='$id_jenis_user', id_puskesmas='$id_puskesmas', nama_user='$nama_user', email='$email' WHERE id_user='$id'");
                    if ($query) {
                        $res = 1;
                    } else {
                        $res = 0;
                    }
                }
            } else {
                $query = mysqli_query($con, "UPDATE tb_user SET id_jenis_user='$id_jenis_user', id_puskesmas='$id_puskesmas', nama_user='$nama_user' WHERE id_user='$id'");
                if ($query) {
                    $res = 1;
                } else {
                    $res = 0;
                }
            }

            if ($res) {
                $msg = array('res'=>1, 'msg' => 'Data Berhasil Diubah');
            } else {
                $msg = array('res'=>0, 'msg' => 'Data Gagal Diubah');
            }
            
            echo json_encode($msg);

            break;
        
        case 'user-pass':
            $id = $_POST['id'];
            $password_lama = $_POST['password_lama'];
            $password_baru = $_POST['password_baru'];

            $cek = mysqli_query($con, "SELECT * FROM tb_user WHERE id_user='$id' AND password='$password_lama'");
            $res = 0;

            if (mysqli_num_rows($cek) > 0) {
                $query = mysqli_query($con, "UPDATE tb_user SET password='$password_baru' WHERE id_user='$id'");
                if ($query) {
                    $res = 1;
                } else {
                    $res = 0;
                }
                
            } else {
                $res = 0;
            }
            
            if ($res) {
                $msg = array('res'=>1, 'msg' => 'Data Berhasil Diubah');
            } else {
                $msg = array('res'=>0, 'msg' => 'Data Gagal Diubah');
            }
            
            echo json_encode($msg);

            break;
        
        case 'getKk':
            $no_kk = $_POST['no_kk'];
            $kunci = $_POST['kunci'];
            $by = $_POST['by'];
            $id_pkm = $_POST['puskesmas'];
            // $no_kk = $_GET['no_kk'];
            // $kunci = $_GET['kunci'];

            if ($by == 'kk') {
                $url  = "http://220.247.173.10:8181/index.html?user=dkk&kunci=$kunci&akses=kk&nomor_kk={$no_kk}";
            } else {
                $url  = "http://220.247.173.10:8181/index.html?user=dkk&kunci=$kunci&akses=nik&nomor_nik={$no_kk}";
            }
            $fields = array(
                'nik'
            );
            
            $con = fSockOpen("220.247.173.10", 8181);

            $res = 0;

            if ($con) {
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
            
                if ($server_output['data']['0']['nomor_kk'] != '') {
                    $no_kk2 = $server_output['data']['0']['nomor_kk'];
                    
                    $sql= $db->prepare("SELECT * FROM tb_kk WHERE no_kk=?");
                    $sql->execute([$server_output['data']['0']['nomor_kk']]);
                    $cek = $sql->fetch(PDO::FETCH_ASSOC);

                    if ($cek == false) {
                        $no_kec = sprintf("%02s", $server_output['data']['0']['no_kec']);
                        $sql= $db->prepare("SELECT a.id_puskesmas FROM tb_puskesmas a, tb_kelurahan b WHERE a.id_puskesmas=b.id_puskesmas AND b.id_kecamatan=? AND b.id_kelurahan=?");
                        $sql->execute([$no_kec, $server_output['data']['0']['no_kel']]);
                        $pkm = $sql->fetch(PDO::FETCH_ASSOC);

                        $tgl = date("Y-m-d");
                        $createdAt = date("Y-m-d H:i:s");
                        $id_user = $_SESSION['id_user'];

                        // data kk
                        if($by == 'nik'){
                            $kk = $server_output['data']['0']['nomor_kk'];
                            $url2  = "http://220.247.173.10:8181/index.html?user=dkk&kunci=$kunci&akses=kk&nomor_kk={$kk}";
                            $fields = array(
                                'nik'
                            );
                            $data2 = http_build_query($fields);
                
                            $context2 = stream_context_create(array(
                                'http' =>  array(
                                    'method'  => 'GET',
                                    'header'  => 'Content-type: application/x-www-form-urlencoded',
                                    'content' => $data2,
                                )
                            ));
                
                            $result2 = file_get_contents($url2, false, $context2);
                            $server_output = json_decode($result2,true);
                        }
                        $data = array();

                        // $sql= $db->prepare("INSERT INTO tb_kk(no_kk, puskesmas, provinsi, kota, kecamatan, kelurahan, tanggal, nama_kk, rt, rw, alamat, createdAt, createdBy, sts_valid) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                        // $q = $sql->execute([$server_output['data']['0']['nomor_kk'], $pkm['id_puskesmas'], $server_output['data']['0']['no_prop'], $server_output['data']['0']['no_kab'], $server_output['data']['0']['no_kec'], $server_output['data']['0']['no_kel'], $tgl, $server_output['data']['0']['nama_lengkap'], $server_output['data']['0']['rt'], $server_output['data']['0']['rw'], $server_output['data']['0']['alamat'], $createdAt, $id_user, '0']);



                        $t = 0;
                        $art_dewasa = 0;
                        $art_10_54 = 0;
                        $art_12_59 = 0;
                        $art_0_11 = 0;
                        $jml_art = 0;
                        //insert art
                        for($i = 0; $i < count($server_output['data']); $i++){
                            $jml_art = $jml_art+1;
                            // 
                            $hk = "%".$server_output['data'][$i]['hubungan_keluarga']."%";
                            $ag = "%".$server_output['data'][$i]['agama']."%";
                            $pd = "%".$server_output['data'][$i]['pendidikan']."%";
                            $pk = "%".$server_output['data'][$i]['pekerjaan']."%";

                            $sql= $db->prepare("select * from tb_hubkel where hub_kel like ?");
                            $sql->execute([$hk]);
                            $hub_kel = $sql->fetch(PDO::FETCH_ASSOC);
                            if ($hub_kel['id_hubkel'] == '1') {
                                $data = $server_output['data'][$i];
                                $data['no_rt'] = sprintf("%03s", $server_output['data'][$i]['rt']);
                                $data['no_rw'] = sprintf("%03s", $server_output['data'][$i]['rw']);
                            }
                            
                            $sql= $db->prepare("select * from tb_agama where agama like ?");
                            $sql->execute([$ag]);
                            $agama = $sql->fetch(PDO::FETCH_ASSOC);
                            
                            $sql= $db->prepare("select * from tb_pendidikan where pendidikan like ?");
                            $sql->execute([$pd]);
                            $pendidikan = $sql->fetch(PDO::FETCH_ASSOC);
                            
                            $sql= $db->prepare("select * from tb_pekerjaan where pekerjaan like ?");
                            $sql->execute([$pk]);
                            $pekerjaan = $sql->fetch(PDO::FETCH_ASSOC);

                            // umur
                            $tgl_lahir = date("Y-m-d", strtotime($server_output['data'][$i]['tgl_lahir']));
                            $tanggal = new DateTime($server_output['data'][$i]['tgl_lahir']);
                            $today = new DateTime('today');
                            $y = $today->diff($tanggal)->y;
                            $m = $today->diff($tanggal)->m;
                            $umur_bln = 0;
                            $umur_thn = 0;
                            if($y > 5){
                                $umur_thn = $y;
                                if ($umur_thn > 17) {
                                    $art_dewasa = $art_dewasa+1;
                                }
                                if ($umur_thn >= 10 && $umur_thn <= 54) {
                                    $art_10_54 = $art_10_54+1;
                                }
                            } else {
                                $umur_bln = $m + ($y*12);
                                if ($umur_bln >= 12 && $umur_bln <= 59) {
                                    $art_12_59 = $art_12_59+1;
                                }
                                if ($umur_bln >= 0 && $umur_bln <=11) {
                                    $art_0_11 = $art_0_11+1;
                                }
                            }

                            // jenis kelamin
                            if ($server_output['data'][$i]['jenis_kelamin'] == 'LAKI-LAKI') {
                                $jekel = 1;
                            } else {
                                $jekel = 2;
                            }

                            // status
                            if ($server_output['data'][$i]['status_kawin'] == 'BELUM KAWIN') {
                                $status = 1;
                            } elseif ($server_output['data'][$i]['status_kawin'] == 'KAWIN') {
                                $status = 2;
                            } elseif ($server_output['data'][$i]['status_kawin'] == 'CERAI HIDUP') {
                                $status = 3;
                            } elseif ($server_output['data'][$i]['status_kawin'] == 'CERAI MATI') {
                                $status = 4;
                            }

                            // $sql= $db->prepare("INSERT INTO tb_art(nik, no_kk, nama, hub_kel, tanggal_lahir, umur_bln, umur_thn, jenis_kelamin, marital_status, agama, pendidikan, pekerjaan) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
                            // $q = $sql->execute([$server_output['data'][$i]['nik'], $server_output['data'][$i]['nomor_kk'], $server_output['data'][$i]['nama_lengkap'], $hub_kel['id_hubkel'], $tgl_lahir, $umur_bln, $umur_thn, $jekel, $status, $agama['id_agama'], $pendidikan['id_pendidikan'], $pekerjaan['id_pekerjaan']]);
                            $q = 1;

                            if ($q) {
                                $t = 1;
                            } else {
                                $t = 0;
                            }
                            
                        }

                        $data['art_dewasa'] = $art_dewasa;
                        $data['art_10_54'] = $art_10_54;
                        $data['art_12_59'] = $art_12_59;
                        $data['art_0_11'] = $art_0_11;
                        $data['jml_art'] = $jml_art;
                        $data['puskesmas'] = $pkm['id_puskesmas'];

                        // $sql2= $db->prepare("INSERT INTO tb_iks_inti(no_kk) VALUES(?)");
                        // $sql2->execute([$no_kk2]);
                        // $sql2= $db->prepare("INSERT INTO tb_iks_besar(no_kk) VALUES(?)");
                        // $sql2->execute([$no_kk2]);

                        if ($t) {
                            // if ($pkm['id_puskesmas'] == $id_pkm) {
                                $msg = array('res'=>1, 'msg' => 'Data Berhasil Ditemukan', 'data'=> $data);
                            // } else {
                            //     $msg = array('res'=>0, 'msg' => 'Data yang dicari berada diluar cakupan wilayah puskesmas.');
                            // }
                        } else {
                            $msg = array('res'=>0, 'msg' => 'Terjadi Kesalahan. Hubungi Pihak Terkait.');
                        }
                    } else {
                        $msg = array('res'=>0, 'msg' => 'Terjadi Kesalahan. Data KK sudah ada.');
                    }
                    
                    
                } else {
                    $msg = array('res'=>0, 'msg' => 'Data Gagal Ditemukan');
                }
            } else {
                $msg = array('res'=>0, 'msg' => 'Disdukcapil Down');
            }
            
            echo json_encode($msg);

            break;

        case 'simpan-kk':
            $no_kk = $_POST['no_kk'];
            $kunci = $_POST['kunci'];
            $id_pkm = $_POST['puskesmas'];
            $no_kel = $_POST['no_kel'];
            $no_rt = $_POST['no_rt'];
            $url  = "http://220.247.173.10:8181/index.html?user=dkk&kunci=$kunci&akses=kk&nomor_kk={$no_kk}";
            $fields = array(
                'nik'
            );
            
            $con = fSockOpen("220.247.173.10", 8181);

            $res = 0;
            if ($con) {
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

                if ($server_output['data']['0']['nomor_kk'] != '') {
                    $sql= $db->prepare("SELECT * FROM tb_kk WHERE no_kk=?");
                    $sql->execute([$server_output['data']['0']['nomor_kk']]);
                    $cek = $sql->fetchAll(PDO::FETCH_ASSOC);

                    if (count($cek) == 0) {
                        $tgl = date("Y-m-d");
                        $createdAt = date("Y-m-d H:i:s");
                        $id_user = $_SESSION['id_user'];

                        $data = array();

                        $t = 0;
                        $art_dewasa = 0;
                        $art_10_54 = 0;
                        $art_12_59 = 0;
                        $art_0_11 = 0;
                        $jml_art = 0;
                        $r = 0;
                        //insert art
                        for($i = 0; $i < count($server_output['data']); $i++){
                            
                            $sql= $db->prepare("SELECT a.nik, c.puskesmas FROM tb_art a, tb_kk b, tb_puskesmas c WHERE a.no_kk=b.no_kk AND b.puskesmas=c.id_puskesmas AND a.nik=?");
                            $sql->execute([$server_output['data'][$i]['nik']]);
                            $cek2 = $sql->fetchAll(PDO::FETCH_ASSOC);

                            if (count($cek2) > 0) {
                                $r = 0;
                                $data['nik'] = $server_output['data'][$i]['nik'];
                                $data['puskesmas'] = $cek2[0]['puskesmas'];
                                $data['no_kk'] = $no_kk;

                                break;
                            } else {
                                $r = 1;
                            }
                        }

                        if ($r) {
                            for($i = 0; $i < count($server_output['data']); $i++){
                                $jml_art = $jml_art+1;
                                // 
                                $hk = "%".$server_output['data'][$i]['hubungan_keluarga']."%";
                                $ag = "%".$server_output['data'][$i]['agama']."%";
                                $pd = "%".$server_output['data'][$i]['pendidikan']."%";
                                $pk = "%".$server_output['data'][$i]['pekerjaan']."%";
    
                                $sql= $db->prepare("select * from tb_hubkel where hub_kel like ?");
                                $sql->execute([$hk]);
                                $hub_kel = $sql->fetch(PDO::FETCH_ASSOC);
                                if ($hub_kel['id_hubkel'] == '1') {
                                    $data = $server_output['data'][$i];
                                    $data['no_rt'] = sprintf("%03s", $server_output['data'][$i]['rt']);
                                    $data['no_rw'] = sprintf("%03s", $server_output['data'][$i]['rw']);
                                    $kec = sprintf("%02s", $server_output['data'][$i]['no_kec']);
                                    $sql= $db->prepare("INSERT INTO tb_kk(no_kk, puskesmas, provinsi, kota, kecamatan, kelurahan, tanggal, nama_kk, rt, rw, alamat, createdAt, createdBy, sts_valid, no_urut_rt, no_urut_kel) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                                    $q = $sql->execute([$server_output['data'][$i]['nomor_kk'], $id_pkm, $server_output['data'][$i]['no_prop'], $server_output['data'][$i]['no_kab'], $kec, $server_output['data'][$i]['no_kel'], $tgl, $server_output['data'][$i]['nama_lengkap'], $data['no_rt'], $data['no_rw'], $server_output['data'][$i]['alamat'], $createdAt, $id_user, '0', $no_rt, $no_kel]);
                                }
                                
                                $sql= $db->prepare("select * from tb_agama where agama like ?");
                                $sql->execute([$ag]);
                                $agama = $sql->fetch(PDO::FETCH_ASSOC);
                                
                                $sql= $db->prepare("select * from tb_pendidikan where pendidikan like ?");
                                $sql->execute([$pd]);
                                $pendidikan = $sql->fetch(PDO::FETCH_ASSOC);
                                
                                $sql= $db->prepare("select * from tb_pekerjaan where pekerjaan like ?");
                                $sql->execute([$pk]);
                                $pekerjaan = $sql->fetch(PDO::FETCH_ASSOC);
    
                                // umur
                                $tgl_lahir = date("Y-m-d", strtotime($server_output['data'][$i]['tgl_lahir']));
                                $tanggal = new DateTime($server_output['data'][$i]['tgl_lahir']);
                                $today = new DateTime('today');
                                $y = $today->diff($tanggal)->y;
                                $m = $today->diff($tanggal)->m;
                                $umur_bln = 0;
                                $umur_thn = 0;
                                if($y > 5){
                                    $umur_thn = $y;
                                    if ($umur_thn > 17) {
                                        $art_dewasa = $art_dewasa+1;
                                    }
                                    if ($umur_thn >= 10 && $umur_thn <= 54) {
                                        $art_10_54 = $art_10_54+1;
                                    }
                                } else {
                                    $umur_bln = $m + ($y*12);
                                    if ($umur_bln >= 12 && $umur_bln <= 59) {
                                        $art_12_59 = $art_12_59+1;
                                    }
                                    if ($umur_bln >= 0 && $umur_bln <=11) {
                                        $art_0_11 = $art_0_11+1;
                                    }
                                }
    
                                // jenis kelamin
                                if ($server_output['data'][$i]['jenis_kelamin'] == 'LAKI-LAKI') {
                                    $jekel = 1;
                                } else {
                                    $jekel = 2;
                                }
    
                                // status
                                if ($server_output['data'][$i]['status_kawin'] == 'BELUM KAWIN') {
                                    $status = 1;
                                } elseif ($server_output['data'][$i]['status_kawin'] == 'KAWIN') {
                                    $status = 2;
                                } elseif ($server_output['data'][$i]['status_kawin'] == 'CERAI HIDUP') {
                                    $status = 3;
                                } elseif ($server_output['data'][$i]['status_kawin'] == 'CERAI MATI') {
                                    $status = 4;
                                }
    
                                $sql= $db->prepare("INSERT INTO tb_art(nik, no_kk, nama, hub_kel, tanggal_lahir, umur_bln, umur_thn, jenis_kelamin, marital_status, agama, pendidikan, pekerjaan) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
                                $q = $sql->execute([$server_output['data'][$i]['nik'], $server_output['data'][$i]['nomor_kk'], $server_output['data'][$i]['nama_lengkap'], $hub_kel['id_hubkel'], $tgl_lahir, $umur_bln, $umur_thn, $jekel, $status, $agama['id_agama'], $pendidikan['id_pendidikan'], $pekerjaan['id_pekerjaan']]);
                                // $q = 1;
    
                                if ($q) {
                                    $t = 1;
                                } else {
                                    $t = 0;
                                }
                                
                            }
                            $data['art_dewasa'] = $art_dewasa;
                            $data['art_10_54'] = $art_10_54;
                            $data['art_12_59'] = $art_12_59;
                            $data['art_0_11'] = $art_0_11;
                            $data['jml_art'] = $jml_art;
    
                            if ($t) {
                                $sql2= $db->prepare("INSERT INTO tb_iks_inti(no_kk) VALUES(?)");
                                $sql2->execute([$no_kk]);
                                $sql2= $db->prepare("INSERT INTO tb_iks_besar(no_kk) VALUES(?)");
                                $sql2->execute([$no_kk]);
                                $msg = array('res'=>1, 'msg' => 'Data Berhasil Disimpan', 'data'=> $data);
                            } else {
                                $msg = array('res'=>0, 'msg' => 'Data Gagal Disimpan');
                            }
                        } else {
                            $msg = array('res'=>0, 'msg' => 'Salah satu data NIK sudah pernah disurvei oleh Puskesmas '.$data['puskesmas'].'. NIK : '.$data['nik'].' dan No KK : '.$data['no_kk'], 'data'=> $data);
                        }
                        

                    } else {
                        $msg = array('res'=>0, 'msg' => 'Terjadi Kesalahan. Data KK sudah ada.');
                    }
                    
                } else {
                    $msg = array('res'=>0, 'msg' => 'Data Gagal Disimpan');
                }
                
            } else {
                $msg = array('res'=>0, 'msg' => 'Terjadi Kesalahan Jaringan.');
            }
            
            echo json_encode($msg);
            
            break;

        case 'data-art':
            $no_kk = $_POST['no_kk'];
        
            $con = mysqli_query($con, "SELECT * FROM tb_art a, tb_hubkel b, tb_agama c WHERE a.agama=c.id_agama AND a.hub_kel=b.id_hubkel AND a.no_kk='$no_kk'");

            $res = 0;

            if ($con) {
                $data = array();
                $i = 0;
                while ($d = mysqli_fetch_assoc($con)) {
                    
                    // jenis kelamin
                    if ($d['jenis_kelamin'] == '1') {
                        $jekel = 'LAKI-LAKI';
                    } else {
                        $jekel = 'PEREMPUAN';
                    }

                    // status
                    if ($d['marital_status'] == 1) {
                        $status = 'BELUM KAWIN';
                    } elseif ($d['marital_status'] == 2) {
                        $status = 'KAWIN';
                    } elseif ($d['marital_status'] == 3) {
                        $status = 'CERAI HIDUP';
                    } elseif ($d['marital_status'] == 4) {
                        $status = 'CERAI MATI';
                    }
                    
                    $data[$i]['No'] = $i+1;
                    $data[$i]['Nama'] = $d['nama'];
                    $data[$i]['Hubungan RT'] = $d['hub_kel'];
                    $data[$i]['Tanggal Lahir'] = $d['tanggal_lahir'];
                    $data[$i]['Jenis Kelamin'] = $jekel;
                    $data[$i]['Status Perkawinan'] = $status;
                    $data[$i]['Agama'] = $d['agama'];
                    $data[$i]['Aksi'] = "<span title='Ubah' style='cursor:pointer' class='fa fa-pencil' onclick='editArt(\"".$d['nik']."\")'></span>&nbsp;<span class='fa fa-trash' style='cursor:pointer' onclick='hapusArt(\"".$d['nik']."\")' title='Hapus'></span>";
                    
                    $i++;
                }
            
                $msg = array('res'=>1, 'data'=> $data);
            } else {
                $msg = array('res'=>0, 'msg' => 'Terjadi Kesalahan. Hubungi Pihak Terkait.');
            }
            
            echo json_encode($msg);
            break;
            
        case 'survei-art':
            $no_kk = $_POST['no_kk'];
        
            $con = mysqli_query($con, "SELECT * FROM tb_art a, tb_hubkel b, tb_agama c WHERE a.agama=c.id_agama AND a.hub_kel=b.id_hubkel AND a.no_kk='$no_kk'");

            $res = 0;

            if ($con) {
                $data = array();
                $i = 0;
                while ($d = mysqli_fetch_assoc($con)) {
                    
                    // jenis kelamin
                    if ($d['jenis_kelamin'] == '1') {
                        $jekel = 'LAKI-LAKI';
                    } else {
                        $jekel = 'PEREMPUAN';
                    }

                    // status
                    if ($d['marital_status'] == 1) {
                        $status = 'BELUM KAWIN';
                    } elseif ($d['marital_status'] == 2) {
                        $status = 'KAWIN';
                    } elseif ($d['marital_status'] == 3) {
                        $status = 'CERAI HIDUP';
                    } elseif ($d['marital_status'] == 4) {
                        $status = 'CERAI MATI';
                    }

                    
                    $sql= $db->prepare("SELECT * FROM tb_survey_art WHERE nik=?");
                    $sql->execute([$d['nik']]);
                    $da = $sql->fetchAll(PDO::FETCH_ASSOC);
                    if(count($da) > 0){
                        $tombol = "<button title='Survei Individu' style='cursor:pointer' class='btn btn-danger' onclick='editSurveiArt(\"".$d['nik']."\")'>Ubah</button>";
                    } else {
                        $tombol = "<button title='Survei Individu' style='cursor:pointer' class='btn btn-success' onclick='surveiArt(\"".$d['nik']."\")'>Survei</button>";
                    }

                    $data[$i]['No'] = $i+1;
                    $data[$i]['Nama'] = $d['nama'];
                    $data[$i]['Hubungan RT'] = $d['hub_kel'];
                    $data[$i]['Tanggal Lahir'] = $d['tanggal_lahir'];
                    $data[$i]['Jenis Kelamin'] = $jekel;
                    $data[$i]['Status Perkawinan'] = $status;
                    $data[$i]['Agama'] = $d['agama'];
                    $data[$i]['Aksi'] = $tombol;
                    
                    $i++;
                }
            
                $msg = array('res'=>1, 'data'=> $data);
            } else {
                $msg = array('res'=>0, 'msg' => 'Terjadi Kesalahan. Hubungi Pihak Terkait.');
            }
            
            echo json_encode($msg);
            break;
        
        case 'cariNik':
            $nik = $_POST['nik'];
            
            $sql= $db->prepare("SELECT * FROM tb_art WHERE nik=?");
            $sql->execute([$nik]);
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            $ada = 0;

            if(count($data) > 0){
                $no_kk = $data[0]['no_kk'];
                
                $sql2= $db->prepare("SELECT * FROM tb_art WHERE no_kk=? AND umur_bln=? AND umur_thn=?");
                $sql2->execute([$no_kk, '0', '0']);
                $data2 = $sql2->fetchAll(PDO::FETCH_ASSOC);

                if(count($data2) > 0){
                    $ada = 1;
                }

                $data[0]['ada'] = $ada;

                $msg = array('res'=>1, 'msg' => '', 'data' => $data[0]);
            } else {
                $msg = array('res'=>0, 'msg' => 'Terjadi Kesalahan. Hubungi Pihak Terkait.');
            }
            echo json_encode($msg);
            break;

        case 'survei-del':
            $id = $_POST['id'];
            $query = mysqli_query($con, "DELETE FROM tb_kk WHERE no_kk='$id'");
            $query2 = mysqli_query($con, "DELETE FROM tb_art WHERE no_kk='$id'");
            $query3 = mysqli_query($con, "DELETE FROM tb_survey_kk WHERE no_kk='$id'");
            $query4 = mysqli_query($con, "DELETE FROM tb_survey_art WHERE no_kk='$id'");
            $query5 = mysqli_query($con, "DELETE FROM tb_iks_inti WHERE no_kk='$id'");
            $query6 = mysqli_query($con, "DELETE FROM tb_iks_besar WHERE no_kk='$id'");

            if ($query && $query2 || ($query3 || $query4) || ($query5 || $query6)) {
                $msg = array('res'=>1, 'msg' => 'Data Berhasil Dihapus');
            } else {
                $msg = array('res'=>0, 'msg' => 'Data Gagal Dihapus');
            }
            
            echo json_encode($msg);
            break;
        case 'getNik':
            $nik = $_POST['nik'];
            $kunci = $_POST['kunci'];
            
            $url  = "http://220.247.173.10:8181/index.html?user=dkk&kunci=$kunci&akses=nik&nomor_nik={$nik}";
            $fields = array(
                'nik'
            );
            
            $con = fSockOpen("220.247.173.10", 8181);

            $res = 0;
            if ($con) {
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

                if ($server_output['data'] != '') {
                    $data2 = $server_output['data'][0];
    
                    $hk = "%".$server_output['data'][0]['hubungan_keluarga']."%";
                    $ag = "%".$server_output['data'][0]['agama']."%";
                    $pd = "%".$server_output['data'][0]['pendidikan']."%";
                    $pk = "%".$server_output['data'][0]['pekerjaan']."%";
    
                    $sql= $db->prepare("select * from tb_hubkel where hub_kel like ?");
                    $sql->execute([$hk]);
                    $hub_kel = $sql->fetch(PDO::FETCH_ASSOC);
                    $data2['id_hubkel'] = $hub_kel['id_hubkel'];
                    
                    $sql= $db->prepare("select * from tb_agama where agama like ?");
                    $sql->execute([$ag]);
                    $agama = $sql->fetch(PDO::FETCH_ASSOC);
                    $data2['id_agama'] = $agama['id_agama'];
                    
                    $sql= $db->prepare("select * from tb_pendidikan where pendidikan like ?");
                    $sql->execute([$pd]);
                    $pendidikan = $sql->fetch(PDO::FETCH_ASSOC);
                    $data2['id_pendidikan'] = $pendidikan['id_pendidikan'];
                    
                    $sql= $db->prepare("select * from tb_pekerjaan where pekerjaan like ?");
                    $sql->execute([$pk]);
                    $pekerjaan = $sql->fetch(PDO::FETCH_ASSOC);
                    $data2['id_pekerjaan'] = $pekerjaan['id_pekerjaan'];
    
                    // umur
                    $tgl_lahir = date("Y-m-d", strtotime($server_output['data'][0]['tgl_lahir']));
                    $tanggal = new DateTime($server_output['data'][0]['tgl_lahir']);
                    $today = new DateTime('today');
                    $y = $today->diff($tanggal)->y;
                    $m = $today->diff($tanggal)->m;
                    $umur_bln = 0;
                    $umur_thn = 0;
                    if($y > 5){
                        $umur_thn = $y;
                    } else {
                        $umur_bln = $m + ($y*12);
                    }
                    $data2['umur_bln'] = $umur_bln;
                    $data2['umur_thn'] = $umur_thn;
                    $data2['tanggal_lahir'] = $tgl_lahir;
    
                    // jenis kelamin
                    if ($server_output['data'][0]['jenis_kelamin'] == 'LAKI-LAKI') {
                        $jekel = 1;
                    } else {
                        $jekel = 2;
                    }
                    $data2['jekel'] = $jekel;
    
                    // status
                    if ($server_output['data'][0]['status_kawin'] == 'BELUM KAWIN') {
                        $status = 1;
                    } elseif ($server_output['data'][0]['status_kawin'] == 'KAWIN') {
                        $status = 2;
                    } elseif ($server_output['data'][0]['status_kawin'] == 'CERAI HIDUP') {
                        $status = 3;
                    } elseif ($server_output['data'][0]['status_kawin'] == 'CERAI MATI') {
                        $status = 4;
                    }
                    $data2['sts_kawin'] = $status;
    
                    $msg = array('res'=>1, 'msg' => 'Data Ditemukan.', 'data'=> $data2);
                } else {
                    $msg = array('res'=>0, 'msg' => 'Data Tidak Ditemukan');
                }
                
            } else {
                $msg = array('res'=>0, 'msg' => 'Disdukcapil Down');
            }
            
            echo json_encode($msg);
            break;        

        case 'art-del':
            $nik = $_POST['nik'];

            $query = mysqli_query($con, "DELETE FROM tb_art WHERE nik='$nik'");
            $query2 = mysqli_query($con, "DELETE FROM tb_survey_art WHERE nik='$nik'");

            if ($query) {
                if ($query2) {
                    $msg = array('res'=>1, 'msg' => 'Data Berhasil Dihapus', 'ada'=> 1);
                } else {
                    $msg = array('res'=>1, 'msg' => 'Data Berhasil Dihapus', 'ada'=> 0);
                }
            } else {
                $msg = array('res'=>0, 'msg' => 'Data Gagal Dihapus');
            }
            
            echo json_encode($msg);
            break;

        case 'simpan-art':

            $sql= $db->prepare("SELECT * FROM tb_art WHERE nik=? AND no_kk=?");
            $sql->execute([$_POST['nik'], $_POST['no_kk']]);
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            if (count($data) > 0) {
                $id = $data[0]['nik'];
                
                $sql= $db->prepare("UPDATE tb_art SET nik=?, nama=?, hub_kel=?, tanggal_lahir=?, umur_bln=?, umur_thn=?, jenis_kelamin=?, marital_status=?, agama=?, pendidikan=?, pekerjaan=?, keterangan=?, wanita_usia_hamil=? WHERE nik=? AND no_kk=?");
                $q = $sql->execute([$_POST['nik'], $_POST['nama_art'], $_POST['hub_kel'], $_POST['tgl_lahir'], $_POST['bulan'], $_POST['tahun'], $_POST['jekel'], $_POST['status'], $_POST['agama'], $_POST['pend'], $_POST['peker'], $_POST['keterangan_art'], $_POST['usia_hamil'], $id, $_POST['no_kk']]);

                $msg = array('res'=>1, 'msg' => 'Data Berhasil Disimpan');
            } else {
                    
                $sql= $db->prepare("SELECT * FROM tb_art WHERE nik=?");
                $sql->execute([$_POST['nik']]);
                $data2 = $sql->fetchAll(PDO::FETCH_ASSOC);

                if (count($data2) == 0) {
                    $sql= $db->prepare("INSERT INTO tb_art(nik, no_kk, nama, hub_kel, tanggal_lahir, umur_bln, umur_thn, jenis_kelamin, marital_status, agama, pendidikan, pekerjaan, keterangan, wanita_usia_hamil) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $q = $sql->execute([$_POST['nik'], $_POST['no_kk'], $_POST['nama_art'], $_POST['hub_kel'], $_POST['tgl_lahir'], $_POST['bulan'], $_POST['tahun'], $_POST['jekel'], $_POST['status'], $_POST['agama'], $_POST['pend'], $_POST['peker'], $_POST['keterangan_art'], $_POST['usia_hamil']]);

                    $msg = array('res'=>1, 'msg' => 'Data Berhasil Disimpan');
                } else {
                    $msg = array('res'=>0, 'msg' => 'Data Gagal Disimpan. NIK Sudah didaftarkan.');
                }
            }
            
            // if ($q) {
            //     $msg = array('res'=>1, 'msg' => 'Data Berhasil Disimpan');
            // } else {
            //     $msg = array('res'=>0, 'msg' => 'Data Gagal Disimpan');
            // }
            
            echo json_encode($msg);
            break;

        case 'cekArt':
            $no_kk = $_POST['no_kk'];
            
            $sql= $db->prepare("SELECT * FROM tb_art WHERE no_kk=? AND umur_bln=? AND umur_thn=?");
            $sql->execute([$no_kk, '0', '0']);
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            if(count($data) > 0){
                $msg = array('res'=>1, 'msg' => '');
            } else {
                $msg = array('res'=>0, 'msg' => 'Terjadi Kesalahan. Hubungi Pihak Terkait.');
            }
            echo json_encode($msg);
            break;

        case 'simpan-survei-art':
            $jkn = (isset($_POST['jkn'])) ? $_POST['jkn'] : 'N' ;
            $merokok = (isset($_POST['merokok'])) ? $_POST['merokok'] : 'N' ;
			if($merokok=="T"){
				$merokok_2 = "Y";			
			}elseif($merokok=="Y"){
				$merokok_2 = "T";			
			}
            $babj = (isset($_POST['babj'])) ? $_POST['babj'] : 'N' ;
            $sab = (isset($_POST['sab2'])) ? $_POST['sab2'] : 'N' ;
            $tb = (isset($_POST['tb'])) ? $_POST['tb'] : 'N' ;
            $obat_tb = (isset($_POST['obtbe'])) ? $_POST['obtbe'] : 'N' ;
            $batuk = (isset($_POST['batuk'])) ? $_POST['batuk'] : 'N' ;
            $hipertensi = (isset($_POST['hipertensi'])) ? $_POST['hipertensi'] : 'N' ;
            $obat_hipertensi = (isset($_POST['obhiper'])) ? $_POST['obhiper'] : 'N' ;
            $tekanan_darah = (isset($_POST['tekanan_darah'])) ? $_POST['tekanan_darah'] : 'N' ;
            $kb = (isset($_POST['kb'])) ? $_POST['kb'] : 'N' ;
            $pantau_balita = (isset($_POST['pantau_balita'])) ? $_POST['pantau_balita'] : 'N' ;
            $faskes = (isset($_POST['faskes'])) ? $_POST['faskes'] : 'N' ;
            $asi_eksklusif = (isset($_POST['asi_eksklusif'])) ? $_POST['asi_eksklusif'] : 'N' ;
            $imunisasi = (isset($_POST['imunisasi'])) ? $_POST['imunisasi'] : 'N' ;
            $sistolik = (isset($_POST['sistol'])) ? $_POST['sistol'] : '' ;
            $diastolik = (isset($_POST['diastol'])) ? $_POST['diastol'] : '' ;
            $keterangan = (isset($_POST['keterangan_indi'])) ? $_POST['keterangan_indi'] : '' ;
            $no_kk = (isset($_POST['m_kk'])) ? $_POST['m_kk'] : '' ;
            $nik = (isset($_POST['m_nik'])) ? $_POST['m_nik'] : '' ;
            
            $sql= $db->prepare("INSERT INTO tb_survey_art(nik, no_kk, jkn, merokok, merokok_2, babj, sab, tb, obat_tb, batuk, hipertensi, obat_hipertensi, tekanan_darah, kb, pantau_balita, faskes, asi_eksklusif, imunisasi, sistolik, diastolik, keterangan) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $q = $sql->execute([$nik, $no_kk, $jkn, $merokok, $merokok_2, $babj, $sab, $tb, $obat_tb, $batuk, $hipertensi, $obat_hipertensi, $tekanan_darah, $kb, $pantau_balita, $faskes, $asi_eksklusif, $imunisasi, $sistolik, $diastolik, $keterangan]);

            if ($q) {
                $msg = array('res'=>1, 'msg' => 'Data Berhasil Disimpan');
            } else {
                $msg = array('res'=>0, 'msg' => 'Data Gagal Disimpan');
            }
            
            echo json_encode($msg);
            break;

        case 'ubah-survei-art':
            $jkn = (isset($_POST['jkn'])) ? $_POST['jkn'] : 'N' ;
            $merokok = (isset($_POST['merokok'])) ? $_POST['merokok'] : 'N' ;
			if($merokok=="T"){
				$merokok_2 = "Y";			
			}elseif($merokok=="Y"){
				$merokok_2 = "T";			
			}
            $babj = (isset($_POST['babj'])) ? $_POST['babj'] : 'N' ;
            $sab = (isset($_POST['sab2'])) ? $_POST['sab2'] : 'N' ;
            $tb = (isset($_POST['tb'])) ? $_POST['tb'] : 'N' ;
            $obat_tb = (isset($_POST['obtbe'])) ? $_POST['obtbe'] : 'N' ;
            $batuk = (isset($_POST['batuk'])) ? $_POST['batuk'] : 'N' ;
            $hipertensi = (isset($_POST['hipertensi'])) ? $_POST['hipertensi'] : 'N' ;
            $obat_hipertensi = (isset($_POST['obhiper'])) ? $_POST['obhiper'] : 'N' ;
            $tekanan_darah = (isset($_POST['tekanan_darah'])) ? $_POST['tekanan_darah'] : 'N' ;
            $kb = (isset($_POST['kb'])) ? $_POST['kb'] : 'N' ;
            $pantau_balita = (isset($_POST['pantau_balita'])) ? $_POST['pantau_balita'] : 'N' ;
            $faskes = (isset($_POST['faskes'])) ? $_POST['faskes'] : 'N' ;
            $asi_eksklusif = (isset($_POST['asi_eksklusif'])) ? $_POST['asi_eksklusif'] : 'N' ;
            $imunisasi = (isset($_POST['imunisasi'])) ? $_POST['imunisasi'] : 'N' ;
            $sistolik = (isset($_POST['sistol'])) ? $_POST['sistol'] : '' ;
            $diastolik = (isset($_POST['diastol'])) ? $_POST['diastol'] : '' ;
            $keterangan = (isset($_POST['keterangan_indi'])) ? $_POST['keterangan_indi'] : '' ;
            $no_kk = (isset($_POST['m_kk'])) ? $_POST['m_kk'] : '' ;
            $nik = (isset($_POST['m_nik'])) ? $_POST['m_nik'] : '' ;
            
            $sql= $db->prepare("UPDATE tb_survey_art SET jkn=?, merokok=?, merokok_2=?, babj=?, sab=?, tb=?, obat_tb=?, batuk=?, hipertensi=?, obat_hipertensi=?, tekanan_darah=?, kb=?, pantau_balita=?, faskes=?, asi_eksklusif=?, imunisasi=?, sistolik=?, diastolik=?, keterangan=? WHERE nik=? AND no_kk=?");
            $q = $sql->execute([$jkn, $merokok, $merokok_2, $babj, $sab, $tb, $obat_tb, $batuk, $hipertensi, $obat_hipertensi, $tekanan_darah, $kb, $pantau_balita, $faskes, $asi_eksklusif, $imunisasi, $sistolik, $diastolik, $keterangan, $nik, $no_kk]);

            if ($q) {
                $msg = array('res'=>1, 'msg' => 'Data Berhasil Disimpan');
            } else {
                $msg = array('res'=>0, 'msg' => 'Data Gagal Disimpan');
            }
            
            echo json_encode($msg);
            break;

        case 'cariSurvei':
            $nik = $_POST['nik'];
            
            $sql= $db->prepare("SELECT * FROM tb_survey_art WHERE nik=?");
            $sql->execute([$nik]);
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            if(count($data) > 0){
                $msg = array('res'=>1, 'msg' => '', 'data' => $data[0]);
            } else {
                $msg = array('res'=>0, 'msg' => 'Terjadi Kesalahan. Hubungi Pihak Terkait.');
            }
            echo json_encode($msg);
            break;

        case 'simpan-survey-kk':

            $createdAt = date("Y-m-d H:i:s");
            $id_user = $_SESSION['id_user'];

            $no_kk = (isset($_POST['no_kk'])) ? $_POST['no_kk'] : '' ;
            $tgl_survei = (isset($_POST['tgl_survei'])) ? $_POST['tgl_survei'] : date("Y-m-d") ;
            $nama_kk = (isset($_POST['nama_kk'])) ? $_POST['nama_kk'] : '' ;
            $jml_art = (isset($_POST['jml_art'])) ? $_POST['jml_art'] : '' ;
            $kelurahan = (isset($_POST['kelurahan'])) ? $_POST['kelurahan'] : '' ;
            $rt = (isset($_POST['rt'])) ? $_POST['rt'] : '' ;
            $rw = (isset($_POST['rw'])) ? $_POST['rw'] : '' ;
            $no_urut_rt = (isset($_POST['no_urut_rt'])) ? $_POST['no_urut_rt'] : '' ;
            $no_urut_kel = (isset($_POST['no_urut_kel'])) ? $_POST['no_urut_kel'] : '' ;
            $alamat = (isset($_POST['alamat'])) ? $_POST['alamat'] : '' ;
            $sab = (isset($_POST['sab'])) ? $_POST['sab'] : 'N' ;
            $sat = (isset($_POST['sat'])) ? $_POST['sat'] : 'N' ;
            $jk = (isset($_POST['jk'])) ? $_POST['jk'] : 'N' ;
            $js = (isset($_POST['js'])) ? $_POST['js'] : 'N' ;
            $gjb = (isset($_POST['gjb'])) ? $_POST['gjb'] : 'N' ;
            $obat = (isset($_POST['obat'])) ? $_POST['obat'] : 'N' ;
            $pasung = (isset($_POST['pasung'])) ? $_POST['pasung'] : 'N' ;
            $keterangan = (isset($_POST['keterangan_kk'])) ? $_POST['keterangan_kk'] : 'N' ;
            $art_wawancara = (isset($_POST['art_wawancara'])) ? $_POST['art_wawancara'] : '' ;
            $art_dewasa = (isset($_POST['art_dewasa'])) ? $_POST['art_dewasa'] : '' ;
            $art_10_54 = (isset($_POST['art_10_54'])) ? $_POST['art_10_54'] : '' ;
            $art_12_59 = (isset($_POST['art_12_59'])) ? $_POST['art_12_59'] : '' ;
            $art_0_11 = (isset($_POST['art_0_11'])) ? $_POST['art_0_11'] : '' ;

            
            $sql= $db->prepare("SELECT * FROM tb_view_art WHERE no_kk=?");
            $sql->execute([$no_kk]);
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            if(count($data) == $jml_art){
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
                
                foreach($data as $row){
                    if ($row['marital_status'] == '2') {
                        if ($row['kb'] == 'Y' || $row['kb'] == 'T') {
                            $v[1] = $row['kb'];
                        }
                    }
                }
                foreach($data as $row){
                    if ($row['jenis_kelamin'] == '2') {
                        if ($row['faskes'] == 'Y' || $row['faskes'] == 'T') {
                            $v[2] = $row['faskes'];
                        }
                    }
                }
                foreach($data as $row){
                    if ($row['umur_bln'] >= 1 && $row['umur_bln'] <= 6 && $row['umur_thn'] == 0) {
                        if ($row['imunisasi'] == 'Y' || $row['imunisasi'] == 'T') {
                            $v[3] = $row['imunisasi'];
                        }
                        if ($row['asi_eksklusif'] == 'Y' || $row['asi_eksklusif'] == 'T') {
                            $v[4] = $row['asi_eksklusif'];
                        }
                    }
                }
                foreach($data as $row){
                    if ($row['umur_bln'] >= 7 && $row['umur_thn'] == 0) {
                        if ($row['pantau_balita'] == 'Y' || $row['pantau_balita'] == 'T') {
                            $v[5] = $row['pantau_balita'];
                        }
                    }
                }
                foreach($data as $row){

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
                foreach($data as $row){
                    if ($row['obat_hipertensi'] == 'Y' || $row['obat_hipertensi'] == 'T') {
                        if ($row['obat_hipertensi'] == 'T') {
                            $v[7] = $row['obat_hipertensi'];
                            break;
                        } else {
                            $v[7] = $row['obat_hipertensi'];
                        }
                    }
                }
                /* foreach($data as $row){
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
                } */
                foreach($data as $row){
                    if ($row['merokok'] == 'Y' || $row['merokok'] == 'T') {
                        if ($row['merokok'] == 'Y') {
                            // $v[9] = $row['merokok'];
                            $v[9] = 'T';
                            break;
                        } else {
                            // $v[9] = $row['merokok'];
                            $v[9] = 'Y';
                        }
                    }
                }
				
                foreach($data as $row){
                    if ($row['jkn'] == 'Y' || $row['jkn'] == 'T') {
                        if ($row['jkn'] == 'T') {
                            $v[10] = $row['jkn'];
                            break;
                        } else {
                            $v[10] = $row['jkn'];
                        }
                    }
                }

                
                if ($sat == 'Y') {
                    foreach ($data as $row) {
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
                    $v[11] = $sat;
                }

                if ($js == 'Y') {
                    foreach ($data as $row) {
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
                    $v[12] = $js;
                }

                $v[8] = $obat;
                // $v[11] = $sat;
                // $v[12] = $js;

                $sql2= $db->prepare("UPDATE tb_iks_inti SET i1=?, i2=?, i3=?, i4=?, i5=?, i6=?, i7=?, i8=?, i9=?, i10=?, i11=?, i12=? WHERE no_kk=?");
                $sql2->execute([$v[1], $v[2], $v[3], $v[4], $v[5], $v[6], $v[7], $v[8], $v[9], $v[10], $v[11], $v[12], $no_kk]);
                $sql2= $db->prepare("UPDATE tb_iks_besar SET i1=?, i2=?, i3=?, i4=?, i5=?, i6=?, i7=?, i8=?, i9=?, i10=?, i11=?, i12=? WHERE no_kk=?");
                $sql2->execute([$v[1], $v[2], $v[3], $v[4], $v[5], $v[6], $v[7], $v[8], $v[9], $v[10], $v[11], $v[12], $no_kk]);

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
                $sts_valid = 1;
            } else {
                $iks_inti = '';
                $iks_besar = '';
                $sts_valid = 0;
            }

            $sql= $db->prepare("UPDATE tb_kk SET kelurahan=?, tanggal=?, nama_kk=?, rt=?, rw=?, alamat=?, no_urut_rt=?, no_urut_kel=?, iks_inti=?, iks_besar=?, sts_valid=?, createdBy=?, createdAt=? WHERE no_kk=?");
            $q = $sql->execute([$kelurahan, $tgl_survei, $nama_kk, $rt, $rw, $alamat, $no_urut_rt, $no_urut_kel, $iks_inti, $iks_besar, $sts_valid, $id_user, $createdAt, $no_kk]);

            if ($q) {
                $sql= $db->prepare("INSERT INTO tb_survey_kk(no_kk, jml_art, jml_art_wawancara, jml_art_dewasa, jml_art_10_54_thn, jml_art_12_59_bln, jml_art_0_11_bln, sab, sat, jk, js, gjb, obat_gjb, pasung, keterangan) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $q2 = $sql->execute([$no_kk, $jml_art, $art_wawancara, $art_dewasa, $art_10_54, $art_12_59, $art_0_11, $sab, $sat, $jk, $js, $gjb, $obat, $pasung, $keterangan]);
                if ($q2) {
                    $msg = array('res'=>1, 'msg' => 'Data Berhasil Disimpan.');

                    if ($sts_valid) {
                        $sql= $db->prepare("SELECT * FROM tb_kk WHERE no_kk=?");
                        $sql->execute([$no_kk]);
                        $data = $sql->fetch();
    
                        $service = [
                            "tanggal"=> date("Ymd"),
                            "no_urut_rt"=> $no_urut_rt,
                            "no_urut_kel"=> $no_urut_kel,
                            "no_kk"=> $no_kk,
                            "nama_kk"=> $nama_kk,
                            "alamat"=> $alamat,
                            "propinsi"=> "33",
                            "kota"=> "3320",
                            "kecamatan"=> "3320".$data['kecamatan'],
                            "kelurahan"=> "3320".$data['kecamatan'].$data['kelurahan'],
                            "puskesmas"=> $data['puskesmas'],
                            "rt"=> $rt,
                            "rw"=> $rw,
                            "iks_inti"=> number_format($iks_inti, 3, '.', ','),
                            "iks_besar"=> number_format($iks_besar, 3, '.', ','),
                            "survei_rumah_tangga"=> [
                                "jml_art"=> $jml_art,
                                "jml_art_wawancara"=> $art_wawancara,
                                "jml_art_dewasa"=> $art_dewasa,
                                "jml_art_10_54_thn"=> $art_10_54,
                                "jml_art_12_59_bln"=> $art_12_59,
                                "jml_art_0_11_bln"=> $art_0_11,
                                "sab"=> $sab,
                                "sat"=> $sat,
                                "jk"=> $jk,
                                "js"=> $js,
                                "gjb"=> $gjb,
                                "obat_gjb"=> $obat,
                                "pasung"=> $pasung,
                                "keterangan"=> $keterangan
                            ]
                        ];

                        $sql= $db->prepare("SELECT * FROM tb_view_art WHERE no_kk=?");
                        $sql->execute([$no_kk]);
                        $data = $sql->fetchAll();

                        $no = 1;
                        foreach ($data as $key) {

                            $service['survei_individu_list'][] = [
                                "survei_individu"=> [
                                    "no_urut"=> $no,
                                    "nik"=> $key['nik'],
                                    "nama"=> $key['nama'],
                                    "hub_kel"=> $key['hub_kel'],
                                    "tanggal_lahir"=> date("Ymd", strtotime($key['tanggal_lahir'])),
                                    "umur_bln"=> $key['umur_bln'],
                                    "umur_tahun"=> $key['umur_thn'],
                                    "jenis_kelamin"=> $key['jenis_kelamin'],
                                    "marital_status"=> $key['marital_status'],
                                    "wanita_usia_hamil"=> $key['wanita_usia_hamil'],
                                    "agama"=> $key['agama'],
                                    "pendidikan"=> $key['pendidikan'],
                                    "pekerjaan"=> $key['pekerjaan'],
                                    "flag_survei"=> 0
                                ],
                                "detail"=> [
                                    "jkn"=> $key['jkn'],
                                    "merokok"=> $key['merokok'],
                                    "babj"=> $key['babj'],
                                    "sab"=> $key['sab'],
                                    "tb"=> $key['tb'],
                                    "obat_tb"=> $key['obat_tb'],
                                    "batuk"=> $key['batuk'],
                                    "hipertensi"=> $key['hipertensi'],
                                    "obat_hipertensi"=> $key['obat_hipertensi'],
                                    "tekanan_darah"=> $key['tekanan_darah'],
                                    "sistolik"=> $key['sistolik'],
                                    "diastolik"=> $key['diastolik'],
                                    "kb"=> $key['kb'],
                                    "faskes"=> $key['faskes'],
                                    "asi_eksklusif"=> $key['asi_eksklusif'],
                                    "imunisasi"=> $key['imunisasi'],
                                    "pantau_balita"=> $key['pantau_balita'],
                                    "keterangan"=> $key['ket_survei']
                                ]
                            ];

                            $no++;
                        }

                        $sql= $db->prepare("SELECT * FROM tb_indikator");
                        $sql->execute();
                        $data = $sql->fetchAll();

                        $sql2= $db->prepare("SELECT * FROM tb_iks_besar WHERE no_kk=?");
                        $sql2->execute([$no_kk]);
                        $data2 = $sql2->fetch(PDO::FETCH_ASSOC);

                        foreach ($data as $key) {
                            $indi = "i".$key['no_urut'];
                            $service["indikator_iks_besar"][] = [
                                "kode" => $key['no_urut'],
                                "nilai" => $data2[$indi]
                            ];
                        }

                        $sql2= $db->prepare("SELECT * FROM tb_iks_inti WHERE no_kk=?");
                        $sql2->execute([$no_kk]);
                        $data2 = $sql2->fetch(PDO::FETCH_ASSOC);

                        foreach ($data as $key) {
                            $indi = "i".$key['no_urut'];
                            $service["indikator_iks_inti"][] = [
                                "kode" => $key['no_urut'],
                                "nilai" => $data2[$indi]
                            ];
                        }
                        
                        // $hasil = service(json_encode($service));

                        // if ($hasil['status'] == "SUKSES") {
                        //     $msg = array('res'=>1, 'msg' => 'Data Berhasil Disimpan dan SUKSES terkirim ke Pusdatin Kemenkes RI');
                        // } else {
                        //     $msg = array('res'=>1, 'msg' => 'Data Berhasil Disimpan dan GAGAL terkirim ke Pusdatin Kemenkes RI');
                        // }
                    }
                } else {
                    $msg = array('res'=>0, 'msg' => 'Terjadi Kesalahan. Hubungi Pihak Terkait.');
                }
            } else {
                $msg = array('res'=>0, 'msg' => 'Terjadi Kesalahan. Hubungi Pihak Terkait.');
            }

            echo json_encode($msg);

            break;

        case 'ubah-survey-kk':

            $createdAt = date("Y-m-d H:i:s");
            $id_user = $_SESSION['id_user'];

            $no_kk = (isset($_POST['no_kk'])) ? $_POST['no_kk'] : '' ;
            $tgl_survei = (isset($_POST['tgl_survei'])) ? $_POST['tgl_survei'] : date("Y-m-d") ;
            $nama_kk = (isset($_POST['nama_kk'])) ? $_POST['nama_kk'] : '' ;
            $jml_art = (isset($_POST['jml_art'])) ? $_POST['jml_art'] : '' ;
            $kelurahan = (isset($_POST['kelurahan'])) ? $_POST['kelurahan'] : '' ;
            $rt = (isset($_POST['rt'])) ? $_POST['rt'] : '' ;
            $rw = (isset($_POST['rw'])) ? $_POST['rw'] : '' ;
            $no_urut_rt = (isset($_POST['no_urut_rt'])) ? $_POST['no_urut_rt'] : '' ;
            $no_urut_kel = (isset($_POST['no_urut_kel'])) ? $_POST['no_urut_kel'] : '' ;
            $alamat = (isset($_POST['alamat'])) ? $_POST['alamat'] : '' ;
            $sab = (isset($_POST['sab'])) ? $_POST['sab'] : 'N' ;
            $sat = (isset($_POST['sat'])) ? $_POST['sat'] : 'N' ;
            $jk = (isset($_POST['jk'])) ? $_POST['jk'] : 'N' ;
            $js = (isset($_POST['js'])) ? $_POST['js'] : 'N' ;
            $gjb = (isset($_POST['gjb'])) ? $_POST['gjb'] : 'N' ;
            $obat = (isset($_POST['obat'])) ? $_POST['obat'] : 'N' ;
            $pasung = (isset($_POST['pasung'])) ? $_POST['pasung'] : 'N' ;
            $keterangan = (isset($_POST['keterangan_kk'])) ? $_POST['keterangan_kk'] : 'N' ;
            $art_wawancara = (isset($_POST['art_wawancara'])) ? $_POST['art_wawancara'] : '' ;
            $art_dewasa = (isset($_POST['art_dewasa'])) ? $_POST['art_dewasa'] : '' ;
            $art_10_54 = (isset($_POST['art_10_54'])) ? $_POST['art_10_54'] : '' ;
            $art_12_59 = (isset($_POST['art_12_59'])) ? $_POST['art_12_59'] : '' ;
            $art_0_11 = (isset($_POST['art_0_11'])) ? $_POST['art_0_11'] : '' ;

            
            $sql= $db->prepare("SELECT * FROM tb_view_art WHERE no_kk=?");
            $sql->execute([$no_kk]);
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            if(count($data) == $jml_art){
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
                // print_r($data);
                // for ($a = 0; $a < count($data); $a++) {
                foreach($data as $row){
                    if ($row['marital_status'] == '2') {
                        if ($row['kb'] == 'Y' || $row['kb'] == 'T') {
                            $v[1] = $row['kb'];
                        }
                    }
                }
                foreach($data as $row){
                    if ($row['jenis_kelamin'] == '2') {
                        if ($row['faskes'] == 'Y' || $row['faskes'] == 'T') {
                            $v[2] = $row['faskes'];
                        }
                    }
                }
                foreach($data as $row){
                    if ($row['umur_bln'] >= 1 && $row['umur_bln'] <= 6 && $row['umur_thn'] == 0) {
                        if ($row['imunisasi'] == 'Y' || $row['imunisasi'] == 'T') {
                            $v[3] = $row['imunisasi'];
                        }
                        if ($row['asi_eksklusif'] == 'Y' || $row['asi_eksklusif'] == 'T') {
                            $v[4] = $row['asi_eksklusif'];
                        }
                    }
                }
                foreach($data as $row){
                    if ($row['umur_bln'] >= 7 && $row['umur_thn'] == 0) {
                        if ($row['pantau_balita'] == 'Y' || $row['pantau_balita'] == 'T') {
                            $v[5] = $row['pantau_balita'];
                        }
                    }
                }
                foreach($data as $row){

                    if ($row['obat_tb'] == 'Y' || $row['obat_tb'] == 'T') {
                        if ($row['obat_tb'] == 'T') {
                            $v[6] = $row['obat_tb'];
                            break;
                        } else {
                            $v[6] = $row['obat_tb'];
                        }
                    }
                }
                foreach($data as $row){
                    if ($row['obat_hipertensi'] == 'Y' || $row['obat_hipertensi'] == 'T') {
                        if ($row['obat_hipertensi'] == 'T') {
                            $v[7] = $row['obat_hipertensi'];
                            break;
                        } else {
                            $v[7] = $row['obat_hipertensi'];
                        }
                    }
                }
                /* foreach($data as $row){
                    if ($row['merokok'] == 'Y' || $row['merokok'] == 'T') {
                        if ($row['merokok'] == 'T') {
                            $v[9] = $row['merokok'];
                            break;
                        } else {
                            $v[9] = $row['merokok'];
                        }
                    }
                } */
                foreach($data as $row){
                    if ($row['merokok'] == 'Y' || $row['merokok'] == 'T') {
                        if ($row['merokok'] == 'Y') {
                            // $v[9] = $row['merokok'];
                            $v[9] = 'T';
                            break;
                        } else {
                            // $v[9] = $row['merokok'];
                            $v[9] = 'Y';
                        }
                    }
                }
                foreach($data as $row){
                    if ($row['jkn'] == 'Y' || $row['jkn'] == 'T') {
                        if ($row['jkn'] == 'T') {
                            $v[10] = $row['jkn'];
                            break;
                        } else {
                            $v[10] = $row['jkn'];
                        }
                    }
                }

                $v[8] = $obat;
                $v[11] = $sat;
                $v[12] = $js;

                $sql2= $db->prepare("UPDATE tb_iks_inti SET i1=?, i2=?, i3=?, i4=?, i5=?, i6=?, i7=?, i8=?, i9=?, i10=?, i11=?, i12=? WHERE no_kk=?");
                $sql2->execute([$v[1], $v[2], $v[3], $v[4], $v[5], $v[6], $v[7], $v[8], $v[9], $v[10], $v[11], $v[12], $no_kk]);
                $sql2= $db->prepare("UPDATE tb_iks_besar SET i1=?, i2=?, i3=?, i4=?, i5=?, i6=?, i7=?, i8=?, i9=?, i10=?, i11=?, i12=? WHERE no_kk=?");
                $sql2->execute([$v[1], $v[2], $v[3], $v[4], $v[5], $v[6], $v[7], $v[8], $v[9], $v[10], $v[11], $v[12], $no_kk]);

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
                $sts_valid = 1;
            } else {
                $iks_inti = '';
                $iks_besar = '';
                $sts_valid = 0;
            }

            $sql= $db->prepare("UPDATE tb_kk SET kelurahan=?, tanggal=?, nama_kk=?, rt=?, rw=?, alamat=?, no_urut_rt=?, no_urut_kel=?, iks_inti=?, iks_besar=?, sts_valid=?, updatedBy=?, updatedAt=? WHERE no_kk=?");
            $q = $sql->execute([$kelurahan, $tgl_survei, $nama_kk, $rt, $rw, $alamat, $no_urut_rt, $no_urut_kel, $iks_inti, $iks_besar, $sts_valid, $id_user, $createdAt, $no_kk]);

            if ($q) {
                $sql3= $db->prepare("SELECT * FROM tb_survey_kk WHERE no_kk=?");
                $sql3->execute([$no_kk]);
                $cekSur = $sql3->fetchAll();
                if (count($cekSur) > 0) {
                    $sql= $db->prepare("UPDATE tb_survey_kk SET jml_art=?, jml_art_wawancara=?, jml_art_dewasa=?, jml_art_10_54_thn=?, jml_art_12_59_bln=?, jml_art_0_11_bln=?, sab=?, sat=?, jk=?, js=?, gjb=?, obat_gjb=?, pasung=?, keterangan=? WHERE no_kk=?");
                    $q2 = $sql->execute([$jml_art, $art_wawancara, $art_dewasa, $art_10_54, $art_12_59, $art_0_11, $sab, $sat, $jk, $js, $gjb, $obat, $pasung, $keterangan, $no_kk]);
                } else {
                    $sql= $db->prepare("INSERT INTO tb_survey_kk(no_kk, jml_art, jml_art_wawancara, jml_art_dewasa, jml_art_10_54_thn, jml_art_12_59_bln, jml_art_0_11_bln, sab, sat, jk, js, gjb, obat_gjb, pasung, keterangan) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $q2 = $sql->execute([$no_kk, $jml_art, $art_wawancara, $art_dewasa, $art_10_54, $art_12_59, $art_0_11, $sab, $sat, $jk, $js, $gjb, $obat, $pasung, $keterangan]);
                }
                
                if ($q2) {
                    $msg = array('res'=>1, 'msg' => 'Data Berhasil Disimpan.');
                    if ($sts_valid) {
                        $sql= $db->prepare("SELECT * FROM tb_kk WHERE no_kk=?");
                        $sql->execute([$no_kk]);
                        $data = $sql->fetch();
    
                        $service = [
                            "tanggal"=> date("Ymd"),
                            "no_urut_rt"=> $no_urut_rt,
                            "no_urut_kel"=> $no_urut_kel,
                            "no_kk"=> $no_kk,
                            "nama_kk"=> $nama_kk,
                            "alamat"=> $alamat,
                            "propinsi"=> "33",
                            "kota"=> "3320",
                            "kecamatan"=> "3320".$data['kecamatan'],
                            "kelurahan"=> "3320".$data['kecamatan'].$data['kelurahan'],
                            "puskesmas"=> $data['puskesmas'],
                            "rt"=> $rt,
                            "rw"=> $rw,
                            "iks_inti"=> number_format($iks_inti, 3, '.', ','),
                            "iks_besar"=> number_format($iks_besar, 3, '.', ','),
                            "survei_rumah_tangga"=> [
                                "jml_art"=> $jml_art,
                                "jml_art_wawancara"=> $art_wawancara,
                                "jml_art_dewasa"=> $art_dewasa,
                                "jml_art_10_54_thn"=> $art_10_54,
                                "jml_art_12_59_bln"=> $art_12_59,
                                "jml_art_0_11_bln"=> $art_0_11,
                                "sab"=> $sab,
                                "sat"=> $sat,
                                "jk"=> $jk,
                                "js"=> $js,
                                "gjb"=> $gjb,
                                "obat_gjb"=> $obat,
                                "pasung"=> $pasung,
                                "keterangan"=> $keterangan
                            ]
                        ];

                        $sql= $db->prepare("SELECT * FROM tb_view_art WHERE no_kk=?");
                        $sql->execute([$no_kk]);
                        $data = $sql->fetchAll();

                        $no = 1;
                        foreach ($data as $key) {

                            $service['survei_individu_list'][] = [
                                "survei_individu"=> [
                                    "no_urut"=> $no,
                                    "nik"=> $key['nik'],
                                    "nama"=> $key['nama'],
                                    "hub_kel"=> $key['hub_kel'],
                                    "tanggal_lahir"=> date("Ymd", strtotime($key['tanggal_lahir'])),
                                    "umur_bln"=> $key['umur_bln'],
                                    "umur_tahun"=> $key['umur_thn'],
                                    "jenis_kelamin"=> $key['jenis_kelamin'],
                                    "marital_status"=> $key['marital_status'],
                                    "wanita_usia_hamil"=> $key['wanita_usia_hamil'],
                                    "agama"=> $key['agama'],
                                    "pendidikan"=> $key['pendidikan'],
                                    "pekerjaan"=> $key['pekerjaan'],
                                    "flag_survei"=> 0
                                ],
                                "detail"=> [
                                    "jkn"=> $key['jkn'],
                                    "merokok"=> $key['merokok'],
                                    "babj"=> $key['babj'],
                                    "sab"=> $key['sab'],
                                    "tb"=> $key['tb'],
                                    "obat_tb"=> $key['obat_tb'],
                                    "batuk"=> $key['batuk'],
                                    "hipertensi"=> $key['hipertensi'],
                                    "obat_hipertensi"=> $key['obat_hipertensi'],
                                    "tekanan_darah"=> $key['tekanan_darah'],
                                    "sistolik"=> $key['sistolik'],
                                    "diastolik"=> $key['diastolik'],
                                    "kb"=> $key['kb'],
                                    "faskes"=> $key['faskes'],
                                    "asi_eksklusif"=> $key['asi_eksklusif'],
                                    "imunisasi"=> $key['imunisasi'],
                                    "pantau_balita"=> $key['pantau_balita'],
                                    "keterangan"=> $key['ket_survei']
                                ]
                            ];

                            $no++;
                        }

                        $sql= $db->prepare("SELECT * FROM tb_indikator");
                        $sql->execute();
                        $data = $sql->fetchAll();

                        $sql2= $db->prepare("SELECT * FROM tb_iks_besar WHERE no_kk=?");
                        $sql2->execute([$no_kk]);
                        $data2 = $sql2->fetch(PDO::FETCH_ASSOC);

                        foreach ($data as $key) {
                            $indi = "i".$key['no_urut'];
                            $service["indikator_iks_besar"][] = [
                                "kode" => $key['no_urut'],
                                "nilai" => $data2[$indi]
                            ];
                        }

                        $sql2= $db->prepare("SELECT * FROM tb_iks_inti WHERE no_kk=?");
                        $sql2->execute([$no_kk]);
                        $data2 = $sql2->fetch(PDO::FETCH_ASSOC);

                        foreach ($data as $key) {
                            $indi = "i".$key['no_urut'];
                            $service["indikator_iks_inti"][] = [
                                "kode" => $key['no_urut'],
                                "nilai" => $data2[$indi]
                            ];
                        }

                        // $hasil = service(json_encode($service));

                        // if ($hasil['status'] == "SUKSES") {
                        //     $msg = array('res'=>1, 'msg' => 'Data Berhasil Disimpan dan SUKSES terkirim ke Pusdatin Kemenkes RI');
                        // } else {
                        //     $msg = array('res'=>1, 'msg' => 'Data Berhasil Disimpan dan GAGAL terkirim ke Pusdatin Kemenkes RI');
                        // }
                        
                    }
                } else {
                    $msg = array('res'=>0, 'msg' => 'Terjadi Kesalahan. Hubungi Pihak Terkait.');
                }
            } else {
                $msg = array('res'=>0, 'msg' => 'Terjadi Kesalahan. Hubungi Pihak Terkait.');
            }

            echo json_encode($msg);

            break;

        case 'cariSurveiKk':
            $no_kk = $_POST['no_kk'];
            
            $sql= $db->prepare("SELECT * FROM tb_survey_kk WHERE no_kk=?");
            $sql->execute([$no_kk]);
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            if (count($data) > 0) {
                $msg = array('res'=>1, 'msg' => '', 'data'=> $data[0]);
            } else {
                $msg = array('res'=>0, 'msg' => 'Terjadi Kesalahan. Hubungi Pihak Terkait.');
            }

            echo json_encode($msg);
            
            break;

        case 'iks':
            $no_kk = $_POST['no_kk'];
            $title = $_POST['title'];
            
            $sql= $db->prepare("SELECT * FROM tb_indikator");
            $sql->execute();
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            if($title == 'IKS INTI'){
                $sql2= $db->prepare("SELECT a.nama_kk, b.* FROM tb_kk a, tb_iks_inti b WHERE a.no_kk=b.no_kk AND b.no_kk=?");
                $sql2->execute([$no_kk]);
                $data2 = $sql2->fetch(PDO::FETCH_ASSOC);
            } else {
                $sql2= $db->prepare("SELECT a.nama_kk, b.* FROM tb_kk a, tb_iks_besar b WHERE a.no_kk=b.no_kk AND b.no_kk=?");
                $sql2->execute([$no_kk]);
                $data2 = $sql2->fetch(PDO::FETCH_ASSOC);
            }

            ?>
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $title; ?> - <?php echo $data2['nama_kk']; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table table-bordered text-size-small">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Indikator</th>
                                        <th width="10%" class="text-center">Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sumY = 0;
                                        $sumN = 0;
                                        foreach ($data as $row) {
                                            if ($data2['i'.$row['no_urut']] == 'Y') {
                                                $sumY++;
                                            }
                                            if ($data2['i'.$row['no_urut']] == 'N') {
                                                $sumN++;
                                            }
                                    ?>
                                    <tr>
                                        <td><?php echo $row['no_urut']; ?></td>
                                        <td><?php echo $row['indikator']; ?></td>
                                        <td class="text-center"><?php echo $data2['i'.$row['no_urut']]; ?></td>
                                    </tr>
                                    <?php
                                        }

                                        $iks = $sumY / (12-$sumN);
                                        if ($iks > 0.800) {
                                            $text = "KELUARGA SEHAT";
                                            $color = "#2cf13b";
                                        } elseif ($iks >= 0.500 && $iks <= 0.800) {
                                            $text = "KELUARGA PRA-SEHAT";
                                            $color = "#fff705";
                                        } else {
                                            $text = "TIDAK SEHAT";
                                            $color = "#f50202";
                                        }
                                    ?>
                                    <tr>
                                        <td colspan="2">
                                            Indeks Keluarga Sehat = Σ Y / (12 - Σ N)<br>
                                            <?php echo $sumY ?> / (12 - <?php echo $sumN; ?>)
                                        </td>
                                        <td style="background-color: <?php echo $color; ?>"><?php echo number_format($iks, 3, '.', ','); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-center" style="background-color: <?php echo $color; ?>"><?php echo $text; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php

            break;

        case 'cekSesi':
            $time = $_SERVER['REQUEST_TIME'];

            /**
            * for a 30 minute timeout, specified in seconds
            */
            $timeout_duration = $_POST['time'];
            
            /**
            * Here we look for the user's LAST_ACTIVITY timestamp. If
            * it's set and indicates our $timeout_duration has passed,
            * blow away any previous $_SESSION data and start a new one.
            */
            if (isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
                session_unset();
                session_destroy();

                $msg = array('res'=>1, 'msg'=>'Sesi waktu anda telah habis. Silahkan LOGIN kembali');
            } else {
                $msg = array('res'=>0);
            }
            echo json_encode($msg);
            break;

        case 'dash':
            $id_pkm = $_SESSION['id_pkm'];
            $hasil = array();

            if ($_SESSION['id_user'] == 1) {
                //jml penduduk
                $sql= $db->prepare("SELECT * FROM tb_art a, tb_kk b WHERE a.no_kk=b.no_kk AND b.sts_valid='1'");
                $sql->execute();
                $data = $sql->fetchAll(PDO::FETCH_ASSOC);
    
                $hasil['jml_p'] = number_format(count($data), 0, ',', '.');
    
                //jml KK
                $sql= $db->prepare("SELECT * FROM tb_kk b WHERE b.sts_valid='1'");
                $sql->execute([]);
                $data = $sql->fetchAll(PDO::FETCH_ASSOC);
    
                $hasil['jml_kk'] = number_format(count($data), 0, ',', '.');
                
                //jml IKS inti
                $sql= $db->prepare("SELECT AVG(iks_inti) as iks FROM tb_kk b WHERE b.sts_valid='1'");
                $sql->execute([]);
                $data = $sql->fetch(PDO::FETCH_ASSOC);
    
                $hasil['jml_iks_i'] = number_format($data['iks'], 3, ',', '.');
                
                //jml IKS besar
                $sql= $db->prepare("SELECT AVG(iks_besar) as iks FROM tb_kk b WHERE b.sts_valid='1'");
                $sql->execute([]);
                $data = $sql->fetch(PDO::FETCH_ASSOC);
    
                $hasil['jml_iks_b'] = number_format($data['iks'], 3, ',', '.');
            } else {
                //jml penduduk
                $sql= $db->prepare("SELECT * FROM tb_art a, tb_kk b WHERE a.no_kk=b.no_kk AND b.puskesmas=? AND b.sts_valid='1'");
                $sql->execute([$id_pkm]);
                $data = $sql->fetchAll(PDO::FETCH_ASSOC);
    
                $hasil['jml_p'] = number_format(count($data), 0, ',', '.');
    
                //jml KK
                $sql= $db->prepare("SELECT * FROM tb_kk b WHERE b.puskesmas=? AND b.sts_valid='1'");
                $sql->execute([$id_pkm]);
                $data = $sql->fetchAll(PDO::FETCH_ASSOC);
    
                $hasil['jml_kk'] = number_format(count($data), 0, ',', '.');
                
                //jml IKS inti
                $sql= $db->prepare("SELECT AVG(iks_inti) as iks FROM tb_kk b WHERE b.puskesmas=? AND b.sts_valid='1'");
                $sql->execute([$id_pkm]);
                $data = $sql->fetch(PDO::FETCH_ASSOC);
    
                $hasil['jml_iks_i'] = number_format($data['iks'], 3, ',', '.');
                
                //jml IKS besar
                $sql= $db->prepare("SELECT AVG(iks_besar) as iks FROM tb_kk b WHERE b.puskesmas=? AND b.sts_valid='1'");
                $sql->execute([$id_pkm]);
                $data = $sql->fetch(PDO::FETCH_ASSOC);
    
                $hasil['jml_iks_b'] = number_format($data['iks'], 3, ',', '.');
            }
            
            $msg = array('res'=>1, 'data' => $hasil);
            echo json_encode($msg);

            break;

        case 'iksInti':
            $no_kk = $_POST['no_kk'];
            $title = $_POST['title'];
            
            $sql= $db->prepare("SELECT * FROM tb_indikator");
            $sql->execute();
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            if($title == 'IKS INTI'){
                $sql2= $db->prepare("SELECT a.nama_kk, b.* FROM tb_kk a, tb_iks_inti b WHERE a.no_kk=b.no_kk AND b.no_kk=?");
                $sql2->execute([$no_kk]);
                $data2 = $sql2->fetch(PDO::FETCH_ASSOC);
            } else {
                $sql2= $db->prepare("SELECT a.nama_kk, b.* FROM tb_kk a, tb_iks_besar b WHERE a.no_kk=b.no_kk AND b.no_kk=?");
                $sql2->execute([$no_kk]);
                $data2 = $sql2->fetch(PDO::FETCH_ASSOC);
            }

            
            $sql= $db->prepare("SELECT * FROM tb_art WHERE no_kk=? ORDER BY hub_kel ASC");
            $sql->execute([$no_kk]);
            $data3 = $sql->fetchAll(PDO::FETCH_ASSOC);

            ?>
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $title; ?> - <?php echo $data2['nama_kk']; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table table-bordered" style="font-size:12px">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Indikator</th>
                                        <th>Pertanyaan Rumah Tangga</th>
                                        <?php
                                            foreach ($data3 as $key) {
                                        ?>
                                        <th><?php echo $key['nama']; ?></th>
                                        <?php
                                            }
                                        ?>
                                        <th width="5%" class="text-center">Kesimpulan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sumY = 0;
                                        $sumN = 0;
                                        foreach ($data as $row) {
                                            if ($data2['i'.$row['no_urut']] == 'Y') {
                                                $sumY++;
                                            }
                                            if ($data2['i'.$row['no_urut']] == 'N') {
                                                $sumN++;
                                            }
                                    ?>
                                    <tr>
                                        <td><?php echo $row['no_urut']; ?></td>
                                        <td><?php echo $row['indikator']; ?></td>
                                        <?php
                                                $sql= $db->prepare("SELECT * FROM tb_survey_kk WHERE no_kk=?");
                                                $sql->execute([$no_kk]);
                                                $data5 = $sql->fetch(PDO::FETCH_ASSOC);
                                        ?>
                                        <td><?php error_reporting(0); if($data5[$row['inisial']]==""){ echo "-"; }else{ echo $data5[$row['inisial']]; } ?></td>
                                        <?php
                                            foreach ($data3 as $key) {
                                                $sql= $db->prepare("SELECT * FROM tb_view_survei WHERE no_kk=? AND nik=?");
                                                $sql->execute([$no_kk, $key['nik']]);
                                                $data4 = $sql->fetch(PDO::FETCH_ASSOC);
                                        ?>
                                        <td><?php echo $data4[$row['inisial']]; ?></td>
                                        <?php
                                            }
                                        ?>
                                        <td class="text-center"><?php echo $data2['i'.$row['no_urut']]; ?></td>
                                    </tr>
                                    <?php
                                        }

                                        $iks = $sumY / (12-$sumN);
                                        if ($iks > 0.800) {
                                            $text = "KELUARGA SEHAT";
                                            $color = "#2cf13b";
                                        } elseif ($iks >= 0.500 && $iks <= 0.800) {
                                            $text = "KELUARGA PRA-SEHAT";
                                            $color = "#fff705";
                                        } else {
                                            $text = "TIDAK SEHAT";
                                            $color = "#f50202";
                                        }
                                    ?>
                                    <tr>
                                        <td colspan="<?php echo count($data3)+3; ?>">
                                            Indeks Keluarga Sehat = Σ Y / (12 - Σ N)<br>
                                            <?php echo $sumY ?> / (12 - <?php echo $sumN; ?>)
                                        </td>
                                        <td style="background-color: <?php echo $color; ?>"><?php echo number_format($iks, 3, '.', ','); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="<?php echo count($data3)+4; ?>" class="text-center" style="background-color: <?php echo $color; ?>"><?php echo $text; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php

            break;

        default:
            $msg = array('res'=>0, 'msg' => 'Terjadi Kesalahan. Hubungi Pihak Terkait.');
            echo json_encode($msg);
            break;
    }
?>