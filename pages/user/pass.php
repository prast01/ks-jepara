<?php
    $id = $_GET['id'];
    $edit = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM tb_user WHERE id_user='$id'"));

?>
                <div class="col-md-4 col-xs-12">
                    <a href="javascript: window.history.go(-1)" class="btn btn-danger">Kembali</a>
                </div>
                <div class="col-xl-12 col-md-12">
                    <div class="card card-shadow mb-4">
                        <div class="card-body">
                            <form id="form-user-pass">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group mb-3 row">
                                            <label class="col-sm-4 col-form-label col-form-label-sm">Password Lama</label>
                                            <div class="col-sm-8">
                                                <input type="password" required class="form-control" id="password" name="password_lama">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3 row">
                                            <label class="col-sm-4 col-form-label col-form-label-sm">Password Baru</label>
                                            <div class="col-sm-8">
                                                <input type="password" required class="form-control" id="password" name="password_baru">
                                            </div>
                                        </div>
                                        <input type="submit" name="add_simpan" id="add_simpan" class="finish btn btn-success sweet" value="Simpan"/>
                                        <input type="hidden" name="page" value="user-pass">
                                        <input type="hidden" name="id" value="<?php echo $edit['id_user']; ?>">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>