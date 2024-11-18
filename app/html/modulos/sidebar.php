<div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
        <a href="radicado.php" class="text-nowrap logo-img">
            <img src="../assets/images/logos/logoSoftDoc.svg" width="180" alt="" />
        </a>
        <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
        </div>
    </div>
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
        <ul id="sidebarnav">
            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">RADICADOS</span>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="radicado.php" aria-expanded="false">
                    <span>
                        <i class="ti ti-article"></i>
                    </span>
                    <span class="hide-menu">Visualizar Radicados</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="crear_radicado.php" aria-expanded="false">
                    <span>
                        <i class="ti ti-alert-circle"></i>
                    </span>
                    <span class="hide-menu">Radicar</span>
                </a>
            </li>
            <!-- <li class="sidebar-item">
                <a class="sidebar-link" href="actualizar_radicado.php" aria-expanded="false">
                    <span>
                        <i class="ti ti-cards"></i>
                    </span>
                    <span class="hide-menu">Actualizar</span>
                </a>
            </li> -->
            <?php if($_SESSION['rol'] === "Admin"){ ?>

            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">FUNCIONARIOS</span>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="funcionario.php" aria-expanded="false">
                    <span>
                        <i class="ti ti-login"></i>
                    </span>
                    <span class="hide-menu">Administrar</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="crear_funcionario.php" aria-expanded="false">
                    <span>
                        <i class="ti ti-user-plus"></i>
                    </span>
                    <span class="hide-menu">Registrar Funcionario</span>
                    <span class="hide-menu"><?php
                    ?></span>
                </a>
            </li>
            <?php } ?>
        </ul>
    </nav>
    <!-- End Sidebar navigation -->
</div>