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
            <?php if (in_array('2', $_SESSION['permisos'])) { ?>
            <li class="sidebar-item">
                <a class="sidebar-link" href="crear_radicado.php" aria-expanded="false">
                    <span>
                        <i class="ti ti-alert-circle"></i>
                    </span>
                    <span class="hide-menu">Radicar</span>
                </a>
            </li>
            <?php } ?>
            <?php 
            $permisos_necesarios = ['1', '2', '3', '4'];
            $tiene_todos = !array_diff($permisos_necesarios, $_SESSION['permisos']);
            if ($tiene_todos) { ?>
            <li class="nav-small-cap">
                <span class="hide-menu">FUNCIONARIOS</span>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="funcionario.php" aria-expanded="false">
                    <span>
                        <i class="ti ti-users"></i>
                    </span>
                    <span class="hide-menu">Administrar Funcionarios</span>
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
            <li class="nav-small-cap">
                <span class="hide-menu">DEPENDENCIAS</span>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="dependencia.php" aria-expanded="false">
                    <span>
                        <i class="ti ti-building"></i>
                    </span>
                    <span class="hide-menu">Administar Dependencias</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="crear_dependencia.php" aria-expanded="false">
                    <span>
                        <i class="ti ti-layout-grid "></i>
                    </span>
                    <span class="hide-menu">Agregar Dependencia</span>
                </a>
            </li>
            <li class="nav-small-cap">
                <span class="hide-menu">ROLES</span>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="rol.php" aria-expanded="false">
                    <span>
                        <i class="ti ti-briefcase"></i>
                    </span>
                    <span class="hide-menu">Administar Roles</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="crear_rol.php" aria-expanded="false">
                    <span>
                        <i class="ti ti-id-badge"></i>
                    </span>
                    <span class="hide-menu">Agregar Rol</span>
                </a>
            </li>
            <?php } ?>
        </ul>
    </nav>
    <!-- End Sidebar navigation -->
</div>