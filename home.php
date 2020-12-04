<?php
    session_start();
    if(!isset($_SESSION['id_user'])){
        echo "<script>alert('Anda Belum Login, Silahkan Login Dahulu !');location.href='../ks-jepara/'</script>";
    }
    $_SESSION['LAST_ACTIVITY'] = $_SERVER['REQUEST_TIME'];
    
    include "assets/function/config.php";
    $page = (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : 'dashboard' ;
    $subpage = (isset($_GET['subpage'])) ? $_GET['subpage'] : '' ;
    $i = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM tb_user WHERE id_user='$_SESSION[id_user]'"));
    $nama_user = $i['nama_user'];
    $id_puskesmas = $i['id_puskesmas'];
    $_SESSION['id_pkm'] = $id_puskesmas;
    $level = $i['id_jenis_user'];
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

<body class="left-sidebar-fixed <?php if($page == 'laporan'){ echo 'left-nav-toggle'; } ?>">
    <!-- <div class="loader"></div> -->
    <!-- Menu header -->
    <?php
        include "include/header.php";
    ?>

    <!--search modal start-->
    <!-- <div class="modal modal-search fade" id="searchModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <input type="text" class="form-control" placeholder="Search...">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    </div> -->
    <!--search modal end-->

    <div class="app-body">
        <!-- menu kiri -->
        <?php
            include "include/menu-kiri.php";
        ?>
        <!--main content wrapper-->
        <div class="content-wrapper">
            <div class="container-fluid">
                <!-- Content -->
                <?php
                    include "pages/$page.php";
                ?>
            </div>
            <!--footer-->
            <footer class="sticky-footer">
                <div class="container">
                    <div class="text-center">
                        <small>Copyright &copy; Dinas Kesehatan Kabupaten Jepara</small>
                    </div>
                </div>
            </footer>
            <!--/footer-->
        </div>
        <!--main content wrapper end-->

        <!-- menu kanan -->
        <?php
            include "include/menu-kanan.php";
        ?>
    </div>

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
    <!--Function Process-->
    <script src="assets/function/func.js"></script>
    <script>
        // $body = $("body");
        // $(document).on({
        //     ajaxStart: function() { $body.addClass("loading");    },
        //     ajaxStop: function() { $body.removeClass("loading"); }    
        // });
    </script>
</body>

</html>

