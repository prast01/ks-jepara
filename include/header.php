    
    <!--header start-->
    <header class="app-header">
        <div class="branding-wrap">
            <!--left nav toggler start-->
            <a class="nav-link mt-2 float-left js_left-nav-toggler pos-fixed" href="javaScript:;">
                <i class=" ti-align-right"></i>
            </a>
            <!--left nav toggler end-->

            <!--brand start-->
            <div class="navbar-brand pos-fixed">
                <a class="js_left-nav-toggler" href="javaScript:;">
                    <img src="assets/img/ikon-ks.png" width="150px" alt="CodeLab">
                </a>
            </div>
            <!--brand end-->
        </div>

        <!--header rightside links-->
        <ul class="header-links hide-arrow navbar">
            <li class="nav-item dropdown ">
                <a class="nav-link dropdown-toggle" id="userNav" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-thumb">
                        <img class="rounded-circle" src="assets/img/avatar/user.png" alt=""/>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userNav">
                    <div class="dropdown-item- px-3 py-2">
                        <img class="rounded-circle mr-2" src="assets/img/avatar/user.png" width="35" alt=""/>
                        <span class="text-muted"><?php echo strtoupper($nama_user); ?></span>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" onclick="clickNav('user', '<?php echo $_SESSION['id_user']; ?>', 'password')">Ganti Password</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" onclick="logout()">Sign Out</a>
                </div>
            </li>
            <!-- <li class="nav-item">
                <a href="javascript:;" class="nav-link right_side_toggle">
                    <i class="icon-options-vertical"> </i>
                </a>
            </li> -->
        </ul>
        <!--/header rightside links-->
    </header>