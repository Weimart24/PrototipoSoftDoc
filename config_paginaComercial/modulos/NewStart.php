<div class="container-xxl bg-primary my-6 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container px-lg-5">
        <div class="row align-items-center" style="height: 250px;">
            <div class="col-12 col-md-6">
                <h3 class="text-white">¿Listo para integrar nuestro software?</h3>
                <small class="text-white">Envíanos tu información y te contactaremos.</small>
                <form action="config_paginaComercial/modulos/send_email_contact.php" method="POST">
                    <div class="position-relative w-100 mt-3">
                        <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" 
                               type="email" name="email" placeholder="Ingrese tu correo electrónico" 
                               required style="height: 48px;"> 
                    </div>
                    <div class="position-relative w-100 mt-3">
                        <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" 
                               type="text" name="nombre" placeholder="Ingrese tu nombre completo" 
                               required style="height: 48px;">
                        <button type="submit" class="btn shadow-none position-absolute top-0 end-0 mt-1 me-2">
                            <i class="fa fa-paper-plane text-primary fs-4"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-md-6 text-center mb-n5 d-none d-md-block">
                <img class="img-fluid mt-5" style="max-height: 250px;" src="config_paginaComercial/img/newsletter.png">
            </div>
        </div>
    </div>
</div>
