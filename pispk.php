<?php
    include "assets/function/config.php";
    $nik = (isset($_GET['nik'])) ? $_GET['nik'] : '' ;
    error_reporting(E_ALL ^ E_WARNING)
?>

<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from thevectorlab.net/codelab/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 29 Jan 2019 06:27:06 GMT -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">

    <!--favicon icon-->
    <link rel="icon" type="image/png" href="assets/img/icon-ks.png">

    <title>Keluarga Sehat Jepara</title>

    <!--web fonts-->
    <link href="http://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,800" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

    <!--bootstrap styles-->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> -->

    <!--icon font-->
    <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/vendor/dashlab-icon/dashlab-icon.css" rel="stylesheet">
    <link href="assets/vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
    <link href="assets/vendor/themify-icons/css/themify-icons.css" rel="stylesheet">
    <link href="assets/vendor/weather-icons/css/weather-icons.min.css" rel="stylesheet">

    <!--jquery ui-->
    <link href="assets/vendor/jquery-ui/jquery-ui.min.css" rel="stylesheet">

    <!--iCheck-->
    <link href="assets/vendor/icheck/skins/all.css" rel="stylesheet">

    <!--jqery steps-->
    <link href="assets/vendor/jquery-steps/jquery.steps.css" rel="stylesheet">
    <!--data table-->
    <link href="assets/vendor/data-tables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!--date picker-->
    <link href="assets/vendor/date-picker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <!--select2-->
    <link href="assets/vendor/select2/css/select2.css" rel="stylesheet">
    <!--swal-->
    <link href="assets/vendor/swal/sweetalert.css" rel="stylesheet">

    <!--custom styles-->
    <link href="assets/css/main.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="assets/vendor/html5shiv.js"></script>
    <script src="assets/vendor/respond.min.js"></script>
    <![endif]-->
    <style>
    </style>
</head>
<body>
    <?php
        $sql= $db->prepare("SELECT * FROM tb_indikator");
        $sql->execute();
        $data = $sql->fetchAll(PDO::FETCH_ASSOC);

        $sql= $db->prepare("SELECT * FROM tb_art WHERE nik=?");
        $sql->execute([$nik]);
        $x = $sql->fetch(PDO::FETCH_ASSOC);
        $no_kk = $x['no_kk'];

        $sql2= $db->prepare("SELECT a.nama_kk, b.* FROM tb_kk a, tb_iks_inti b WHERE a.no_kk=b.no_kk AND b.no_kk=?");
        $sql2->execute([$no_kk]);
        $data2 = $sql2->fetch(PDO::FETCH_ASSOC);

        $sql= $db->prepare("SELECT * FROM tb_art WHERE no_kk=? ORDER BY hub_kel ASC");
        $sql->execute([$no_kk]);
        $data3 = $sql->fetchAll(PDO::FETCH_ASSOC);

        if($no_kk != ''){
    ?>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered" style="font-size:12px">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Indikator</th>
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
                            <td colspan="<?php echo count($data3)+2; ?>">
                                Indeks Keluarga Sehat = Σ Y / (12 - Σ N)<br>
                                <?php echo $sumY ?> / (12 - <?php echo $sumN; ?>)
                            </td>
                            <td style="background-color: <?php echo $color; ?>"><?php echo number_format($iks, 3, '.', ','); ?></td>
                        </tr>
                        <tr>
                            <td colspan="<?php echo count($data3)+3; ?>" class="text-center" style="background-color: <?php echo $color; ?>"><?php echo $text; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
        } else {
            echo "<h2 class='text-center text-danger mt-5'>NIK BELUM DISURVEY PISPK</h2>";
        }
    ?>

    <!--basic scripts-->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/jquery-ui/jquery-ui.min.js"></script>
    <script src="assets/vendor/popper.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/vendor/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/vendor/jquery.nicescroll.min.js"></script>

    <!--chartjs-->
    <script src="assets/vendor/chartjs/Chart.bundle.min.js"></script>
    <!--chartjs initialization-->
    <script src="assets/vendor/js-init/chartjs/init-sales-overview-chart.js"></script>
    <script src="assets/vendor/js-init/chartjs/init-area-chart.js"></script>
    <script src="assets/vendor/js-init/chartjs/init-line-chart.js"></script>

    <!--[if lt IE 9]>
    <script src="assets/vendor/modernizr.js"></script>
    <![endif]-->
    
    <!--jquery validate-->
    <script src="assets/vendor/jquery-validation/jquery.validate.min.js"></script>

    <!--jquery steps-->
    <script src="assets/vendor/jquery-steps/jquery.steps.min.js"></script>
    <!--init steps-->
    <script src="assets/vendor/js-init/init-form-wizard.js"></script>

    <!--jquery stepy-->
    <script src="assets/vendor/jquery-steps/jquery.stepy.js"></script>

    <!--datatables-->
    <script src="assets/vendor/data-tables/jquery.dataTables.min.js"></script>
    <script src="assets/vendor/data-tables/dataTables.bootstrap4.min.js"></script>
    <!--init ajax datatable-->
    <script src="assets/vendor/js-init/init-ajax-datatable.js"></script>
    <!--date picker-->
    <script src="assets/vendor/date-picker/js/bootstrap-datepicker.min.js"></script>
    <!--init date picker-->
    <script src="assets/vendor/js-init/pickers/init-date-picker.js"></script>
    <!--select2-->
    <script src="assets/vendor/select2/js/select2.min.js"></script>
    <!--init select2-->
    <script src="assets/vendor/js-init/init-select2.js"></script>
    <!--init icheck-->
    <script src="assets/vendor/js-init/init-icheck.js"></script>
    <!--init datatable-->
    <script src="assets/vendor/js-init/init-datatable.js"></script>
    <!--swal-->
    <script src="assets/vendor/swal/sweetalert.js"></script>

    <!--basic scripts initialization-->
    <script src="assets/js/scripts.js"></script>
</body>
</html>