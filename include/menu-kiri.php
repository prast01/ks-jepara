        
        <!--left sidebar start-->
        <div class="left-nav-wrap">
            <div class="left-sidebar">
                <nav class="sidebar-menu">
                    <ul id="nav-accordion">
                        <li>
                            <a href="?page=dashboard" <?php if($page == 'dashboard') { echo 'class="active"'; } ?>>
                                <i class=" ti-home"></i>
                                <span>Home</span>
                            </a>
                        </li>

                        <li class="nav-title">
                            <h5 class="text-uppercase">Data Keluarga</h5>
                        </li>
                        <li class="sub-menu">
                            <a href="javascript:;" <?php if($page == 'laporan') { echo 'class="active"'; } ?>>
                                <i class="fa fa-file-text-o"></i>
                                <span>Dashboard</span>
                            </a>
                            <ul class="sub">
                                <li <?php if($subpage == 'iks_provinsi') { echo 'class=""'; } ?>><a  href="#" onclick="alertB('Mohon Maaf !', 'Menu dalam proses perbaikan.', 'warning')">IKS Provinsi</a></li>
                                <li <?php if($subpage == 'iks_wilayah') { echo 'class="active"'; } ?>><a  href="?page=laporan&subpage=iks_wilayah">IKS Wilayah</a></li>
                                <li <?php if($subpage == 'status_data') { echo 'class=""'; } ?>><a  href="?page=laporan&subpage=status_data">Status Pendataan</a></li>
                            </ul>
                        </li>
                        <?php
                            if($level != '1'){
                        ?>
                        <li>
                            <a href="?page=survey" <?php if($page == 'survey') { echo 'class="active"'; } ?>>
                                <i class="fa fa-address-card"></i>
                                <span>Data Rumah Tangga</span>
                            </a>
                        </li>
                        <?php
                            }
                        ?>
                        <!--multi level menu end-->
                        <?php
                            if($level == '1' || $level == '2'){
                        ?>
                        <li class="nav-title">
                            <h5 class="text-uppercase">Lain-lain</h5>
                        </li>

                        <li>
                            <a href="?page=user" <?php if($page == 'user') { echo 'class="active"'; } ?>>
                                <i class="ti-user"></i>
                                <span>Pengguna</span>
                            </a>
                        </li>
                        <?php
                            }
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
        <!--left sidebar end-->