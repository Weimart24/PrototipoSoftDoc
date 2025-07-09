<?php
session_start();
if (!isset($_SESSION['name']) && !isset($_SESSION['id'])) {
    header('Location: ../../index.php');
}
include '../config/conexion.php';
$query = "SELECT * FROM roles";
$resultado = $conexion->query($query);
?>


<!doctype html>
<html lang="en">

<head>
    <?php include 'modulos/head.php' ?>
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <?php include 'modulos/sidebar.php' ?>
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <?php include 'modulos/header.php' ?>
            <!--  Header End -->
            <div class="container-fluid">
                <!-- funcioario.php visualizar los funcionarios -->
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="table-responsive p-3">
                            <h3 class="text-left">REGISTRO DE DEPENDENCIAS</h3>
                            <table class="table align-items-center table-flush" id="dataTable">
                                <thead>
                                    <td>Ver</td>
                                    <td>Id</td>
                                    <td>Nombre Rol</td>
                                    <td>Descripción</td>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($resultado->num_rows > 0) {
                                        while ($fila = $resultado->fetch_assoc()) {
                                            echo "<td><a href='ver_rol.php?id=" . $fila["id_rol"] . "' class='btn btn-outline-info btn-sm'>Ver</a></td>";
                                            echo "<td>" . $fila["id_rol"] . "</td>";
                                            echo "<td>" . $fila["nombre_rol"] . "</td>";
                                            echo "<td>" . $fila["descripcion"] . "</td>";
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- funcioario.php visualizar los funcionarios -->
                <div class="py-6 px-6 text-center">
                    <p class="mb-0 fs-4">Diseñado y desarrollado por <a href="https://softDocument.com/" target="_blank" class="pe-1 text-primary text-decoration-underline">SoftDocument.com</a></p>
                </div>
            </div>
        </div>
    </div>
    <?php include_once 'modulos/script.php' ?>
</body>

</html>
<?php
// Cerrar la conexión
$conexion->close();
?>