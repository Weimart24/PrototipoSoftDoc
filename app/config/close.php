<?php
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['name']) && isset($_SESSION['validate'])) {
    // Destruir la sesión
    session_destroy();
    header('Location: ../../index.php');
}else{
    header('Location: ../../index.php');
}
