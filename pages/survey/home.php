
                <div class="col-md-4 col-xs-12">
                    <a href="?page=survey&add" class="btn btn-success">Tambah Data</a>
                    <a href="assets/file/kuesioner_survei.pdf" target="_blank" class="btn btn-info">Download Kuisioner</a>
                </div>
                <div class="col-xl-12 col-md-12">
                    <div class="card card-shadow mb-4">
                        <div class="card-header border-0">
                            <div class="custom-title-wrap bar-primary">
                                <div class="custom-title">List Data Rumah Tangga</div>
                            </div>
                        </div>
                        <div class="pt-3 pb-4">
                            <div class="table-responsive">
                                <table id="data_table" class="table table-bordered table-striped" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No urut Bangunan / <br>No Urut Keluarga</th>
                                        <th>Tgl Survei</th>
                                        <th>No KK</th>
                                        <th>Nama KK</th>
                                        <th>Puskesmas</th>
                                        <th>Kelurahan</th>
                                        <th>RT/RW</th>
                                        <th>IKS Inti</th>
                                        <th>IKS Besar</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>No urut Bangunan / <br>No Urut Keluarga</th>
                                        <th>Tgl Survei</th>
                                        <th>No KK</th>
                                        <th>Nama KK</th>
                                        <th>Puskesmas</th>
                                        <th>Kelurahan</th>
                                        <th>RT/RW</th>
                                        <th>IKS Inti</th>
                                        <th>IKS Besar</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                        $no = 1;
                                        $q = mysqli_query($con, "SELECT * FROM tb_view_kk WHERE id_puskesmas='$id_puskesmas'");
                                        while($d = mysqli_fetch_assoc($q)){
                                            $blm = '<span class="badge badge-danger ml-2">Belum Lengkap</span>';
                                    ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $d['no_urut_rt']."/".$d['no_urut_kel']; ?></td>
                                        <td><?php echo $d['tanggal']; ?></td>
                                        <td><?php echo $d['no_kk']; ?></td>
                                        <td><?php echo $d['nama_kk']; ?></td>
                                        <td><?php echo $d['puskesmas']; ?></td>
                                        <td><?php echo $d['kelurahan']; ?></td>
                                        <td><?php echo $d['rt']."/".$d['rw']; ?></td>
                                        <td>
                                            <?php
                                                if ($d['sts_valid'] == '0') {
                                                    echo $blm;
                                                } else {
                                                    echo "<span class='text-success' title='IKS INTI' style='cursor:pointer' onclick='modalIks(\"IKS INTI\", ".$d['no_kk'].", \"iksInti\")'>";
                                                    echo $d['iks_inti'];
                                                    echo "</span>";
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                if ($d['sts_valid'] == '0') {
                                                    echo $blm;
                                                } else {
                                                    echo "<span class='text-success' title='IKS BESAR' style='cursor:pointer' onclick='modalIks(\"IKS BESAR\", ".$d['no_kk'].", \"iks\")'>";
                                                    echo $d['iks_besar'];
                                                    echo "</span>";
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <span class="fa fa-pencil text-success" style="cursor:pointer" title="Ubah" onclick="clickNav('survey', '<?php echo $d['no_kk']; ?>', 'edit')"></span>&nbsp;
                                            <span class="fa fa-trash text-success" style="cursor:pointer" title="Hapus" onclick="clickHapus('survei-del', '<?php echo $d['no_kk']; ?>', 'survey')"></span>
                                        </td>
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