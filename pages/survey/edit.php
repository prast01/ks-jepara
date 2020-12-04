<?php
    date_default_timezone_set("Asia/Jakarta");
    $no_kk = (isset($_GET['id'])) ? $_GET['id'] : '' ;
    
    $sql= $db->prepare("SELECT * FROM tb_kk WHERE no_kk=?");
    $sql->execute([$no_kk]);
    $data = $sql->fetch(PDO::FETCH_ASSOC);

    $sql2= $db->prepare("SELECT * FROM tb_art WHERE no_kk=?");
    $sql2->execute([$no_kk]);
    $data2 = $sql2->fetchAll();
    
    $sql3= $db->prepare("SELECT * FROM tb_survey_kk WHERE no_kk=?");
    $sql3->execute([$no_kk]);
    $data3 = $sql3->fetch(PDO::FETCH_ASSOC);
?>
                <div class="col-md-4 col-xs-12">
                    <a href="?page=survey" class="btn btn-danger">Kembali</a>
                </div>
                <div class="col-xl-12 col-md-12">
                    <div class="card card-shadow mb-4">
                        <div class="card-body">
                            <div class="stepy-tab">
                                <ul id="default-titles" class="stepy-titles">
                                    <li id="default-title-0" class="current-step">
                                        <div>Tahap 1</div>
                                    </li>
                                    <li id="default-title-1" class="">
                                        <div>Tahap 2</div>
                                    </li>
                                    <li id="default-title-2" class="">
                                        <div>Tahap 3</div>
                                    </li>
                                    <li id="default-title-3" class="">
                                        <div>Tahap 4</div>
                                    </li>
                                </ul>
                            </div>
                            <form id="default">
                                <input type="hidden" name="page" value="ubah-survey-kk">
                                <input type="hidden" id="cek" value="1">

                                <fieldset title="Step 1 (Pengenalan Tempat)" class="step" id="default-step-0">
                                    <legend> </legend>
                                    <h2 class="mb-3">List Data Rumah Tangga</h2>

                                    
                                    <div class="row">
                                        <div class="col-md-6 col-xs-12">
                                            <div class="input-group mb-3 row">
                                                <input type="text" maxlength="16" class="form-control" name="no_kk" id="no_kk" placeholder="Masukkan Nomor KK" aria-label="Masukkan Nomor KK" aria-describedby="basic-addon2" value="<?php echo $data['no_kk']; ?>">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" id="cari_kk" type="button" title="Cari KK"><span class="fa fa-search"></span></button>
                                                </div>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" id="cari_nik" type="button" title="Cari NIK"><span class="fa fa-search"></span></button>
                                                </div>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" id="ganti_nik" type="button" title="Cari dengan NIK">Gunakan NIK?</button>
                                                </div>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" id="ganti_kk" type="button" title="Cari dengan KK">Gunakan KK?</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group mb-3 row">
                                                <label class="col-sm-4 col-form-label col-form-label-sm">Tanggal Survei</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control date-picker-input" name="tgl_survei" value="<?php echo $data['tanggal']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 row">
                                                <label class="col-sm-4 col-form-label col-form-label-sm">Nama KK</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="nama_kk" id="nama_kk" value="<?php echo $data['nama_kk']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 row">
                                                <label class="col-sm-4 col-form-label col-form-label-sm">Jumlah ART</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="jml_art" id="jml_art" value="<?php echo count($data2); ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group mb-3 row">
                                                <label class="col-sm-4 col-form-label col-form-label-sm">Kelurahan</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" id="option_s4" name="kelurahan">
                                                        <option></option>
                                                        <?php
                                                            $q = mysqli_fetch_assoc(mysqli_query($con, "SELECT kecamatan FROM tb_kelurahan WHERE id_puskesmas='$id_puskesmas' GROUP BY id_kecamatan"));
                                                        ?>
                                                        <optgroup label="<?php echo $q['kecamatan']; ?>">
                                                        <?php
                                                            $q2 = mysqli_query($con, "SELECT * FROM tb_kelurahan WHERE id_puskesmas='$id_puskesmas'");
                                                            while($d = mysqli_fetch_assoc($q2)){
                                                        ?>
                                                            <option <?php if($data['kelurahan'] == $d['id_kelurahan']){ echo "selected"; } ?> value="<?php echo $d['id_kelurahan']; ?>">
                                                                <?php echo $d['kelurahan']; ?>
                                                            </option>
                                                        <?php
                                                            }
                                                        ?>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 row">
                                                <label class="col-sm-4 col-form-label col-form-label-sm">RT</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" name="rt" id="rt" value="<?php echo $data['rt']; ?>">
                                                </div>
                                                <label class="col-sm-2 col-form-label col-form-label-sm">RW</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" name="rw" id="rw" value="<?php echo $data['rw']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 row">
                                                <label class="col-sm-4 col-form-label col-form-label-sm">No. Urut Bangunan</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" name="no_urut_rt" id="no_urut_rt" value="<?php echo $data['no_urut_rt']; ?>">
                                                </div>
                                                <label class="col-sm-2 col-form-label col-form-label-sm">No. Urut Keluarga</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" name="no_urut_kel" id="no_urut_kel" value="<?php echo $data['no_urut_kel']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12">
                                            <div class="input-group mb-3 row">
                                                <label class="col-sm-2 col-form-label col-form-label-sm">Alamat Rumah</label>
                                                <div class="col-sm-10">
                                                    <textarea name="alamat" id="alamat" class="form-control"><?php echo $data['alamat']; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </fieldset>

                                <input type="hidden" name="art_dewasa" id="art_dewasa" value="<?php echo $data3['jml_art_dewasa']; ?>">
                                <input type="hidden" name="art_10_54" id="art_10_54" value="<?php echo $data3['jml_art_10_54_thn']; ?>">
                                <input type="hidden" name="art_12_59" id="art_12_59" value="<?php echo $data3['jml_art_12_59_bln']; ?>">
                                <input type="hidden" name="art_0_11" id="art_0_11" value="<?php echo $data3['jml_art_0_11_bln']; ?>">
                                <input type="hidden" name="art_wawancara" id="art_wawancara" value="<?php echo $data3['jml_art_wawancara']; ?>">
                                <fieldset title="Step 2 (Keterangan Keluarga)" class="step" id="default-step-1" >
                                    <legend> </legend>
                                    <h2 class="mb-3">Survey Rumah Tangga</h2>

                                    <div class="row">
                                        <div class="col-md-12 col-xs-12">
                                            <div class="form-group mb-3 row">
                                                <label class="col-sm-2 col-form-label col-form-label-sm">1. Nama KK</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="nama_kk" value="<?php echo $data['nama_kk']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 row">
                                                <label class="col-sm-2 col-form-label col-form-label-sm">2a. Jumlah ART</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="jml_art" value="<?php echo $data3['jml_art']; ?>">
                                                </div>
                                                <label class="col-sm-2 col-form-label col-form-label-sm">2b. Jumlah ART diwawancara</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="art_wawancara" value="<?php echo $data3['jml_art_wawancara']; ?>" readonly="">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 row">
                                                <label class="col-sm-2 col-form-label col-form-label-sm">2c. Jumlah ART dewasa (=15 tahun)</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="art_dewasa" value="<?php echo $data3['jml_art_dewasa']; ?>" readonly="">
                                                </div>
                                                <label class="col-sm-2 col-form-label col-form-label-sm">2d. Jumlah ART usia 10-54 tahun</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="art_10_54" value="<?php echo $data3['jml_art_10_54_thn']; ?>" readonly="">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 row">
                                                <label class="col-sm-2 col-form-label col-form-label-sm">2e. Jumlah ART usia 12-59 bulan</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="art_12_59" value="<?php echo $data3['jml_art_12_59_bln']; ?>" readonly="">
                                                </div>
                                                <label class="col-sm-2 col-form-label col-form-label-sm">2f. Jumlah ART usia 0-11 bulan</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="art_0_11" value="<?php echo $data3['jml_art_0_11_bln']; ?>" readonly="">
                                                </div>
                                            </div>
                                            <div class="form-group" id="q1">
                                                <label for="exampleInputEmail1">3. Apakah tersedia sarana air bersih di lingkungan rumah?</label>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input" type="radio" name="sab" value="Y">
                                                                Ya
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input" type="radio" name="sab" value="T">
                                                                Tidak
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" id="q2">
                                                <label for="exampleInputEmail1">4. Bila ya, apa jenis sumber airnya terlindungi? (PDAM, sumur pompa, sumur gali terlindung, mata air terlindung)</label>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input" type="radio" name="sat" id="sat" value="Y">
                                                                Ya
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input" type="radio" name="sat" id="sat" value="T">
                                                                Tidak
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" id="q3">
                                                <label for="exampleInputEmail1">5. Apakah tersedia jamban keluarga?</label>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input" type="radio" name="jk" id="jk" value="Y">
                                                                Ya
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input" type="radio" name="jk" id="jk" value="T">
                                                                Tidak
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" id="q4">
                                                <label for="exampleInputEmail1">6. Bila ya, apakah jenis jambannya saniter? (kloset/leher angsa/plengsengan)</label>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input" type="radio" name="js" id="js" value="Y">
                                                                Ya
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input" type="radio" name="js" id="js" value="T">
                                                                Tidak
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group" id="q5">
                                                <label for="exampleInputEmail1">7. Apakah ada ART yang pernah didiagnosa menderita gangguan jiwa berat (Schizoprenia)?</label>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input" type="radio" name="gjb" id="gjb" value="Y">
                                                                Ya
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input" type="radio" name="gjb" id="gjb" value="T">
                                                                Tidak
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" id="q6">
                                                <label for="exampleInputEmail1">8. Bila ya, apakah selama ini ART tersebut meminum obat gangguan jiwa berat secara teratur?</label>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input" type="radio" name="obat" id="obat" value="Y">
                                                                Ya
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input" type="radio" name="obat" id="obat" value="T">
                                                                Tidak
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" id="q7">
                                                <label for="exampleInputEmail1">9. Apakah ada ART yang dipasung?</label>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input" type="radio" name="pasung" id="pasung" value="Y">
                                                                Ya
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input" type="radio" name="pasung" id="pasung" value="T">
                                                                Tidak
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12">
                                            <div class="input-group mb-3 row">
                                                <label class="col-sm-2 col-form-label col-form-label-sm">Keterangan</label>
                                                <div class="col-sm-10">
                                                    <textarea name="keterangan_kk" id="keterangan_kk" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    

                                </fieldset>
                                <fieldset title="Step 3 (Anggota RT)" class="step" id="default-step-2" >
                                    <legend> </legend>
                                    <h2 class="mb-3">Anggota Rumah Tangga</h2>

                                    <div class="row">
                                        <div class="col-md-6 col-xs-12">
                                            <div class="input-group mb-3 row">
                                                <input type="text" maxlength="16" class="form-control" id="nik" placeholder="Masukkan NIK" aria-label="Masukkan NIK" aria-describedby="basic-addon2">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" id="cari_art" type="button"><span class="fa fa-search"></span></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group mb-3 row">
                                                <label class="col-sm-4 col-form-label col-form-label-sm">Nama ART</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="nama_art" id="nama_art">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 row">
                                                <label class="col-sm-4 col-form-label col-form-label-sm">Tanggal Lahir</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control date-picker-input" name="tgl_lahir" id="tgl_lahir">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 row">
                                                <label class="col-sm-4 col-form-label col-form-label-sm">Jenis Kelamin</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" id="jekel" name="jekel">
                                                        <option></option>
                                                        <option value="1">
                                                            Laki-laki
                                                        </option>
                                                        <option value="2">
                                                            Perempuan
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 row">
                                                <label class="col-sm-4 col-form-label col-form-label-sm">Agama</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" id="agama" name="agama">
                                                        <option></option>
                                                        <?php
                                                            $q3 = mysqli_query($con, "SELECT * FROM tb_agama");
                                                            while($d3 = mysqli_fetch_assoc($q3)){
                                                        ?>
                                                            <option value="<?php echo $d3['id_agama']; ?>">
                                                                <?php echo $d3['agama']; ?>
                                                            </option>
                                                        <?php
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 row">
                                                <label class="col-sm-4 col-form-label col-form-label-sm">Pendidikan (ART > 5 tahun)</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" id="pend" name="pend">
                                                        <option></option>
                                                        <?php
                                                            $q4 = mysqli_query($con, "SELECT * FROM tb_pendidikan");
                                                            while($d4 = mysqli_fetch_assoc($q4)){
                                                        ?>
                                                            <option value="<?php echo $d4['id_pendidikan']; ?>">
                                                                <?php echo $d4['pendidikan']; ?>
                                                            </option>
                                                        <?php
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group mb-3 row">
                                                <label class="col-sm-4 col-form-label col-form-label-sm">Hubungan ART</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" id="hub_kel" name="hub_kel">
                                                        <option></option>
                                                        <?php
                                                            $q5 = mysqli_query($con, "SELECT * FROM tb_hubkel");
                                                            while($d5 = mysqli_fetch_assoc($q5)){
                                                        ?>
                                                            <option value="<?php echo $d5['id_hubkel']; ?>">
                                                                <?php echo $d5['hub_kel']; ?>
                                                            </option>
                                                        <?php
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 row">
                                                <label class="col-sm-4 col-form-label col-form-label-sm">Tahun</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" disabled name="tahun" id="tahun">
                                                </div>
                                                <label class="col-sm-2 col-form-label col-form-label-sm">Bulan</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" disabled name="bulan" id="bulan">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 row">
                                                <label class="col-sm-4 col-form-label col-form-label-sm">Status Perkawinan</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" id="status" name="status">
                                                        <option></option>
                                                        <option value="1">
                                                            Belum Kawin
                                                        </option>
                                                        <option value="2">
                                                            Kawin
                                                        </option>
                                                        <option value="3">
                                                            Cerai Hidup
                                                        </option>
                                                        <option value="4">
                                                            Cerai Mati
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 row">
                                                <label class="col-sm-4 col-form-label col-form-label-sm">Pekerjaan (ART > 9 tahun)</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" id="peker" name="peker">
                                                        <option></option>
                                                        <?php
                                                            $q6 = mysqli_query($con, "SELECT * FROM tb_pekerjaan");
                                                            while($d6 = mysqli_fetch_assoc($q6)){
                                                        ?>
                                                            <option value="<?php echo $d6['id_pekerjaan']; ?>">
                                                                <?php echo $d6['pekerjaan']; ?>
                                                            </option>
                                                        <?php
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group" id="q_hamil">
                                                <label for="exampleInputEmail1">Sedang Hamil? (khusus wanita usia 10-54 tahun)</label>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input" type="radio" name="usia_hamil" value="Y">
                                                                Ya
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input" type="radio" name="usia_hamil" value="T">
                                                                Tidak
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12">
                                            <div class="input-group mb-3 row">
                                                <label class="col-sm-2 col-form-label col-form-label-sm">Keterangan</label>
                                                <div class="col-sm-10">
                                                    <textarea name="keterangan_art" id="keterangan_art" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 col-xs-12">
                                            <button class="btn btn-success btn-block" id="simpan_art">Simpan ART</button>
                                        </div>
                                        <div class="col-md-2 col-xs-12">
                                            <button class="btn btn-danger btn-block" id="reset_art">Reset</button>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div id='data-art' class="col-md-12 col-xs-12">
                                        </div>
                                    </div>
                                    <br>

                                </fieldset>
                                <fieldset title="Step 4 (Individu)" class="step" id="default-step-3" >
                                    <legend> </legend>
                                    <h2 class="mb-3">Survei Anggota Rumah Tangga</h2>
                                    
                                    <div class="row">
                                        <div id="survei-art" class="col-md-12 col-xs-12">
                                        </div>
                                    </div>
                                    <br>
                                </fieldset>

                                <input type="submit" class="finish btn btn-danger" value="Finish"/>
                            </form>
                        </div>
                    </div>
                </div>
