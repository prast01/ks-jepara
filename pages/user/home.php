
                <div class="col-md-4 col-xs-12">
                    <a href="?page=user&add" class="btn btn-success">Tambah Data</a>
                </div>
                <div class="col-xl-12 col-md-12">
                    <div class="card card-shadow mb-4">
                        <div class="pt-3 pb-4">
                            <div class="table-responsive">
                                <table id="data_table" class="table table-bordered table-striped" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama User</th>
                                        <th>Email</th>
                                        <th>Puskesmas</th>
                                        <th>Posisi</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if($level == '1'){
                                        $query = mysqli_query($con, "SELECT * FROM tb_user a, tb_puskesmas b, tb_jenis_user c WHERE a.id_puskesmas=b.id_puskesmas AND a.id_jenis_user=c.id_jenis_user AND a.id_jenis_user='2'");
                                    } else {
                                        $query = mysqli_query($con, "SELECT * FROM tb_user a, tb_puskesmas b, tb_jenis_user c WHERE a.id_puskesmas=b.id_puskesmas AND a.id_jenis_user=c.id_jenis_user AND a.id_puskesmas = '$id_puskesmas' AND a.id_jenis_user='3'");
                                    }
                                        $no = 1;
                                        while($d = mysqli_fetch_assoc($query)){
                                    ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $d['nama_user']; ?></td>
                                        <td><?php echo $d['email']; ?></td>
                                        <td><?php echo $d['puskesmas']; ?></td>
                                        <td><?php echo $d['jenis_user']; ?></td>
                                        <td class="text-center">
                                            <span class="fa fa-pencil" style="cursor:pointer" title="Ubah" onclick="clickNav('user', '<?php echo $d['id_user']; ?>', 'edit')"></span>&nbsp;
                                            <span class="fa fa-trash" style="cursor:pointer" title="Hapus" onclick="clickHapus('user-del', '<?php echo $d['id_user']; ?>', 'user')"></span>&nbsp;
                                            <span class="fa fa-lock" style="cursor:pointer" title="Ganti Password" onclick="clickNav('user', '<?php echo $d['id_user']; ?>', 'password')"></span>
                                        </td>
                                    </tr>
                                    <?php
                                            $no++;
                                        }
                                    ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama User</th>
                                        <th>Email</th>
                                        <th>Puskesmas</th>
                                        <th>Posisi</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>