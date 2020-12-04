        
            <!--page title-->
            <div class="page-title mb-4 d-flex align-items-center">
                <div class="mr-auto">
                    <h4 class="weight500 d-inline-block pr-3 mr-3 border-right">IKS Wilayah</h4>
                </div>
            </div>
            <!--/page title-->
            <div class="row">
            <?php
            if ($level == '1') {
                if (isset($_GET['kecamatan'])) {
                    if(isset($_GET['desa'])){
                        if (isset($_GET['rw'])) {
                            if (isset($_GET['rt'])) {
                                include "pages/laporan/iks/rt.php";
                            } else {
                                include "pages/laporan/iks/rw.php";
                            }
                        } else {
                            include "pages/laporan/iks/desa.php";
                        }
                    } else {
                        include "pages/laporan/iks/home.php";
                    }
                } else {
                    include "pages/laporan/iks/home2.php";
                }
            } else {
                if(isset($_GET['desa'])){
                    if (isset($_GET['rw'])) {
                        if (isset($_GET['rt'])) {
                            include "pages/laporan/iks/rt.php";
                        } else {
                            include "pages/laporan/iks/rw.php";
                        }
                    } else {
                        include "pages/laporan/iks/desa.php";
                    }
                    
                } else {
                    include "pages/laporan/iks/home.php";
                }
            }
            
            ?>
            </div>

            
<div class="modal fade" id="modalIks" tabindex="-1" role="dialog" aria-labelledby="modalIks" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>