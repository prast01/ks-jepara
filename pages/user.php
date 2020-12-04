        
            <!--page title-->
            <div class="page-title mb-4 d-flex align-items-center">
                <div class="mr-auto">
                    <h4 class="weight500 d-inline-block pr-3 mr-3 border-right">Data Pengguna</h4>
                </div>
            </div>
            <!--/page title-->
            <div class="row">
            <?php
                if(isset($_GET['add'])){
                    include "pages/user/add.php";
                } elseif (isset($_GET['edit'])) {
                    include "pages/user/edit.php";
                } elseif (isset($_GET['password'])) {
                    include "pages/user/pass.php";
                } else {
                    include "pages/user/home.php";
                }
            ?>
            </div>