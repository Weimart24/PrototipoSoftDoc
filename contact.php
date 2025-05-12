<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('config_paginaComercial/modulos/head.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container-xxl bg-white p-0">

        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0">
            <?php include('config_paginaComercial/modulos/navbar.php'); ?>

            <div class="container-xxl bg-primary page-header">
                <div class="container text-center">
                    <h1 class="text-white animated zoomIn mb-3">Contáctenos</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                            <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Contact</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->

        <!-- Contact Start -->
        <div class="container-xxl py-6">
            <div class="container">
                <div class="mx-auto text-center wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                    <div class="d-inline-block border rounded-pill text-primary px-4 mb-3">Contact Us</div>
                    <h2 class="mb-5">Si tiene alguna consulta, por favor siéntase libre de contactarnos</h2>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-7 wow fadeInUp" data-wow-delay="0.3s">
                        <form action="app/config/op_contact.php" method="POST">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Su nombre" required>
                                        <label for="name">Su nombre</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Su correo" required>
                                        <label for="email">Su correo</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Asunto" required>
                                        <label for="subject">Asunto</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" id="message" name="message" placeholder="Mensaje" style="height: 150px" required></textarea>
                                        <label for="message">Mensaje</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">Enviar mensaje</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact End -->

        <!-- Footer Start -->
        <?php include('config_paginaComercial/modulos/footer.php'); ?>
        <!-- Footer End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <?php include('config_paginaComercial/modulos/script.php'); ?>

    <!-- SweetAlert2 feedback -->
    <?php if (isset($_GET['status']) && isset($_GET['message'])): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                icon: "<?php echo $_GET['status'] === 'success' ? 'success' : 'error'; ?>",
                title: "<?php echo $_GET['status'] === 'success' ? 'Éxito' : 'Error'; ?>",
                text: "<?php echo urldecode($_GET['message']); ?>",
                confirmButtonColor: "<?php echo $_GET['status'] === 'success' ? '#28a745' : '#d33'; ?>"
            }).then(() => {
                // Elimina los parámetros de la URL sin recargar la página
                if (window.history.replaceState) {
                    const cleanURL = window.location.origin + window.location.pathname;
                    window.history.replaceState(null, null, cleanURL);
                }
            });
        });
    </script>
    <?php endif; ?>

    <!-- Limpieza del formulario si el usuario regresa con "Atrás" -->
    <script>
        window.addEventListener("pageshow", function (event) {
            if (event.persisted || performance.navigation.type === 2) {
                document.querySelector("form").reset();
            }
        });
    </script>
</body>

</html>
