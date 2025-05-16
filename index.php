<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('config_paginaComercial/modulos/head.php') ?>
    <style>
    body {
        font-size: 16px;
        line-height: 1.6;
    }

    .zoom-buttons {
    position: fixed;
    bottom: 15px;
    left: 15px;
    background: rgba(0, 137, 123, 0.9);
    border-radius: 6px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    padding: 4px;
    z-index: 1000;
    display: flex;
    gap: 4px;
}

.zoom-buttons button {
    background: transparent;
    border: none;
    color: white;
    font-size: 12px;
    padding: 4px 6px;
    border-radius: 4px;
    cursor: pointer;
    transition: background 0.2s;
}

.zoom-buttons button:hover {
    background: rgba(255, 255, 255, 0.15);
}

</style>

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
            <?php include('config_paginaComercial/modulos/navbar.php') ?>
            <div class="container-xxl bg-primary hero-header">
                <div class="container">
                    <div class="row g-5 align-items-center">
                        <div class="col-lg-6 text-center text-lg-start">
                            <h1 class="text-white mb-4 animated zoomIn">Conectando Tu Empresa con la Eficiencia Digital</h1>
                            <p class="text-white pb-4 animated zoomIn">SoftDoc surge como una solución tecnológica de Ventanilla Única Digital como una plataforma web integral que optimiza los procesos de recepción, radicación, distribución y conservación de la correspondencia</p>
                            <!-- <a href="" class="btn btn-outline-light rounded-pill border-2 py-3 px-5 animated slideInRight">Aprender más</a> -->
                        </div>
                        <div class="col-lg-6 text-center text-lg-start">
                            <img class="img-fluid animated zoomIn" src="img/hero.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->


        <!-- About Start -->
        <?php include('config_paginaComercial/modulos/aboutM.php') ?>
        <!-- About End -->


        <!-- Newsletter Start -->
        <?php include('config_paginaComercial/modulos/NewStart.php') ?>
        <!-- Newsletter End -->


        <!-- Service Start -->
        <?php include('config_paginaComercial/modulos/service.php') ?>
        <!-- Service End -->


        <!-- Features Start -->
        <?php include('config_paginaComercial/modulos/features.php') ?>
        <!-- Features End -->
        <!-- la lupa-->
        <div class="zoom-buttons">
            <button onclick="zoomIn()" title="Aumentar texto">A+</button>
            <button onclick="zoomOut()" title="Disminuir texto">A-</button>
            <button onclick="resetZoom()" title="Restablecer">↺</button>
        </div>

        <!-- Client Start -->
        <div class="container-xxl bg-primary my-6 py-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container">
                <div class="owl-carousel client-carousel">
                    <a href="#"><img class="img-fluid" src="config_paginaComercial/img/logo-1.png" alt=""></a>
                    <a href="#"><img class="img-fluid" src="config_paginaComercial/img/logo-2.png" alt=""></a>
                    <a href="#"><img class="img-fluid" src="config_paginaComercial/img/logo-3.png" alt=""></a>
                    <a href="#"><img class="img-fluid" src="config_paginaComercial/img/logo-4.png" alt=""></a>
                    <a href="#"><img class="img-fluid" src="config_paginaComercial/img/logo-5.png" alt=""></a>
                    <a href="#"><img class="img-fluid" src="config_paginaComercial/img/logo-6.png" alt=""></a>
                    <a href="#"><img class="img-fluid" src="config_paginaComercial/img/logo-7.png" alt=""></a>
                    <a href="#"><img class="img-fluid" src="config_paginaComercial/img/logo-8.png" alt=""></a>
                </div>
            </div>
        </div>
        <!-- Client End -->


        <!-- Testimonial Start -->
        <?php include('config_paginaComercial/modulos/testimonial.php') ?>
        <!-- Testimonial End -->


        <!-- Team Start -->
        <?php include('config_paginaComercial/modulos/teams.php') ?>
        <!-- Team End -->


        <!-- Footer Start -->
        <?php include('config_paginaComercial/modulos/footer.php') ?>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <?php include('config_paginaComercial/modulos/script.php') ?>
</body>

<script>
        let currentFontSize = 16;

        function zoomIn() {
            if (currentFontSize < 40) {
                currentFontSize += 2;
                document.body.style.fontSize = currentFontSize + 'px';
            }
        }

        function zoomOut() {
            if (currentFontSize > 10) {
                currentFontSize -= 2;
                document.body.style.fontSize = currentFontSize + 'px';
            }
        }

        function resetZoom() {
            currentFontSize = 16;
            document.body.style.fontSize = currentFontSize + 'px';
        }
    </script>

</html>