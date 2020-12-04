<?php
    session_start();
    if(isset($_SESSION['id_user'])){
        echo "<script>location.href='../ks-jepara/home.php?page=dashboard'</script>";
    }
?>
<!DOCTYPE html>
<html lang="en">

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

    <!--icon font-->
    <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/vendor/dashlab-icon/dashlab-icon.css" rel="stylesheet">
    <link href="assets/vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
    <link href="assets/vendor/themify-icons/css/themify-icons.css" rel="stylesheet">
    <link href="assets/vendor/weather-icons/css/weather-icons.min.css" rel="stylesheet">

    <!--custom scrollbar-->
    <link href="assets/vendor/m-custom-scrollbar/jquery.mCustomScrollbar.html" rel="stylesheet">

    <!--jquery dropdown-->
    <link href="assets/vendor/jquery-dropdown-master/jquery.dropdown.html" rel="stylesheet">

    <!--jquery ui-->
    <link href="assets/vendor/jquery-ui/jquery-ui.min.css" rel="stylesheet">

    <!--iCheck-->
    <link href="assets/vendor/icheck/skins/all.css" rel="stylesheet">

    <!--custom styles-->
    <link href="assets/css/main.css" rel="stylesheet">
    <!--swal-->
    <link href="assets/vendor/swal/sweetalert.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="assets/vendor/html5shiv.js"></script>
    <script src="assets/vendor/respond.min.js"></script>
    <![endif]-->
</head>

<body class="signin-up-bg">

    <div class="leftHalf" style="background-image: url('assets/img/ks.png')">
        <div class="login-promo-txt">
            <h3>Keluarga Sehat Jepara</h3>
            <p>Dinas Kesehatan Kabupaten Jepara</p>
        </div>
    </div>

    <div class="rightHalf">
        <div class="position-relative">
            <!--login form-->
            <div class="login-form">
                <h2 class="text-center mb-4">
                    <img src="assets/img/ks-logo.png" srcset="assets/img/ks-logo.png 8x" alt="CodeLab">
                </h2>
                <h4 class="text-uppercase- text-purple text-center mb-5">Keluarga Sehat Jepara</h4>
                <form id='login-form'>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                    </div>
                    <div class="form-group mb-4">
                        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Enter Password">
                    </div>

                    <div class="form-group clearfix">
                        <!-- <a href="#" class="float-left forgot-link my-2">Forgot Password ?</a> -->
                        <button type="submit" class="btn btn-purple btn-pill btn-block">LOGIN</button>
                        <input type="hidden" name="page" value="login">
                    </div>

                    <!-- <div class="form-divider"></div> -->

                    <!-- <a href="#" class="btn btn-facebook btn-pill text-uppercase"><i class="fa fa-facebook-square"></i> Login with facebook</a>
                    <div class="text-center mt-5">
                        <a href="registration.html" class="btn-link text-capitalize f12">Create New Account</a>
                    </div> -->
                </form>
            </div>
            <!--/login form-->
        </div>
    </div>

    <!--basic scripts-->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/jquery-ui/jquery-ui.min.js"></script>
    <script src="assets/vendor/popper.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/vendor/jquery-dropdown-master/jquery.dropdown-2.html"></script>
    <script src="assets/vendor/m-custom-scrollbar/jquery.mCustomScrollbar.concat.min.html"></script>
    <script src="assets/vendor/icheck/skins/icheck.min.js"></script>
    <script src="assets/vendor/jquery.nicescroll.min.js"></script>
    <!--Function Process-->
    <script src="assets/function/func.js"></script>
    <!--swal-->
    <script src="assets/vendor/swal/sweetalert.js"></script>
    <!--[if lt IE 9]>
    <script src="assets/vendor/modernizr.js"></script>
    <![endif]-->

    <!--basic scripts initialization-->
    <!--<script src="assets/js/scripts.js"></script>-->
</body>

</html>

