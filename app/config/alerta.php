<?php
function mostrarAlerta($tipo, $titulo, $mensaje, $redireccion = null, $tiempo = null) {
    echo "
    <script>
        (function(){
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
            script.onload = function() {
                Swal.fire({
                    icon: '$tipo',
                    title: '$titulo',
                    text: '$mensaje',"
                    . ($tiempo ? "timer: $tiempo, timerProgressBar: true," : "") . "
                    confirmButtonText: 'Aceptar'
                }).then(() => {";

                if ($redireccion && trim($redireccion) !== '') {
                    echo "window.location.href = '$redireccion';";
                } else {
                    echo "window.history.back();";
                }

                echo "});
            };
            document.head.appendChild(script);
        })();
    </script>";
}
?>
