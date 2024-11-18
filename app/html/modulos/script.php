<script src="../assets/libs/jquery/dist/jquery.min.js"></script>
<script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> -->
<script src="../assets/js/sidebarmenu.js"></script>
<script src="../assets/js/app.min.js"></script>
<!-- <script src="../assets/js/ocultarPass.js"></script> -->
<!-- <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script> -->
<script src="../assets/libs/simplebar/dist/simplebar.js"></script>
<!-- <script src="../assets/js/dashboard.js"></script> -->

<script src="../assets/libs/datatables/jquery.dataTables.min.js"></script>
<script src="../assets/libs/datatables/dataTables.bootstrap4.min.js"></script>


<!-- Page level custom scripts -->
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable(); // ID From dataTable 
        $('#dataTablekHover').DataTable(); // ID From dataTable with Hover
    });
</script>

<script>
    function eliminarAdjunto() {
        var campoDocumento = document.getElementById('documento');
        campoDocumento.value = ''; // Borra el valor del campo de archivo
        // Aquí puedes añadir más lógica si necesitas realizar otras acciones al eliminar el adjunto
    }
</script>