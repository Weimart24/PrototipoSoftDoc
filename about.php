<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('config_paginaComercial/modulos/head.php') ?>
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
            <div class="container-xxl bg-primary page-header">
                <div class="container text-center">
                    <h1 class="text-white animated zoomIn mb-3">Acerca de nosotros</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                            <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">About</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->


        <!-- About Start -->
        <?php include('config_paginaComercial/modulos/aboutM.php') ?>
        <!-- About End -->


        <!-- Features Start -->
        <?php include('config_paginaComercial/modulos/features.php') ?>
        <!-- Features End -->


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

</html>