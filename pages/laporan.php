
            <?php
                if(isset($_GET['subpage']) && $subpage != ''){
                    if($subpage == 'iks_wilayah'){
                        include "pages/laporan/iks.php";
                    } elseif ($subpage == 'status_data') {
                        include "pages/laporan/data.php";
                    }
                }
            ?>