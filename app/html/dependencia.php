<?php
session_start();
if (!isset($_SESSION['name']) && !isset($_SESSION['id'])) {
    header('Location: ../../index.php');
}
include '../config/conexion.php';
$query = "SELECT * FROM dependencia";
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
                                    <td>Estado</td>
                                    <td>Id</td>
                                    <td>Nombre</td>
                                    <td>Teléfono</td>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($resultado->num_rows > 0) {
                                        while ($fila = $resultado->fetch_assoc()) {
                                            $estado = ($fila["activo"] == 1)
                                                ? "<a href='/app/config/cambiarEstadoDependencia.php?id={$fila['id_dependencia']}&activo=1' class='text-success text-decoration-none'><strong>Activo</strong></a>"
                                                : "<a href='/app/config/cambiarEstadoDependencia.php?id={$fila['id_dependencia']}&activo=0' style='color: #b0b0b0;' class='text-decoration-none'><strong>Inactivo</strong></a>";
                                            echo "<td>$estado</td>";
                                            echo "<td>" . $fila["id_dependencia"] . "</td>";
                                            echo "<td>" . $fila["nombre_dependencia"] . "</td>";
                                            echo "<td>" . $fila["telefono"] . "</td>";
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