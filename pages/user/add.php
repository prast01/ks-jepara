
                <div class="col-md-4 col-xs-12">
                    <a href="?page=user" class="btn btn-danger">Kembali</a>
                </div>
                
                <div class="col-xl-12 col-md-12">
                    <div class="card card-shadow mb-4">
                        <div class="card-body">
                            <form id="form-user-add">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group mb-3 row">
                                            <label class="col-sm-4 col-form-label col-form-label-sm">Puskesmas</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="id_puskesmas" name="id_puskesmas">
                                                    <?php
                                                    if($level == '1'){
                                                        echo "<option selected disabled>Pilih</option>";
                                                        $q = mysqli_query($con, "SELECT * FROM tb_puskesmas ORDER BY id_puskesmas ASC");
                                                        while($d = mysqli_fetch_assoc($q)){
                                                    ?>
                                                    <option value="<?php echo $d['id_puskesmas']; ?>">
                                                        <?php echo $d['puskesmas']; ?>
                                                    </option>
                                                    <?php
                                                        }
                                                    } else {
                                                        echo "<option disabled>Pilih</option>";
                                                        $q = mysqli_query($con, "SELECT * FROM tb_puskesmas WHERE id_puskesmas='$id_puskesmas' ORDER BY id_puskesmas ASC");
                                                        while($d = mysqli_fetch_assoc($q)){
                                                    ?>
                                                    <option selected value="<?php echo $d['id_puskesmas']; ?>">
                                                        <?php echo $d['puskesmas']; ?>
                                                    </option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3 row">
                                            <label class="col-sm-4 col-form-label col-form-label-sm">Email</label>
                                            <div class="col-sm-8">
                                                <input type="email" required class="form-control" id="email" name="email">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3 row">
                                            <label class="col-sm-4 col-form-label col-form-label-sm">Password</label>
                                            <div class="col-sm-8">
                                                <input type="password" required class="form-control" id="password" name="password">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3 row">
                                            <label class="col-sm-4 col-form-label col-form-label-sm">Nama</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="nama" name="nama">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3 row">
                                            <label class="col-sm-4 col-form-label col-form-label-sm">Jenis User</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" required id="id_jenis_user" name="id_jenis_user">
                                                    <option selected disabled>Pilih</option>
                                                    <option value="2">
                                                        Supervisor
                                                    </option>
                                                    <option value="3">
                                                        Surveyor
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <input type="submit" name="add_simpan" id="add_simpan" class="finish btn btn-success sweet" value="Simpan"/>
                                        <input type="hidden" name="page" value="user">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>