<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="notificationBell">
                    <i class="ti ti-bell-ringing"></i>
                    <div class="notification bg-primary rounded-circle" id="notificationDot" style="display: none;"></div>
                </a>
                <div class="dropdown-menu dropdown-menu-end" id="notificationDropdown" style="display: none;">
                    <div id="notificationList"></div>
                </div>
            </li>
        </ul>
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                <?php if (isset($_SESSION['name'])) { 
                    echo '<p>' . $_SESSION['name'] . '</p>';
                } ?>
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                        <div class="message-body">
                            <a href="perfil.php" class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-user fs-6"></i>
                                <p class="mb-0 fs-3">Mi perfil</p>
                            </a>
                            <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-mail fs-6"></i>
                                <p class="mb-0 fs-3">Mi cuenta</p>
                            </a>
                            <!-- Redireccionar al archivo logout.php para cerrar variables de sesi -->
                            <a href="../config/close.php" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const notificationBell = document.getElementById('notificationBell');
    const notificationDot = document.getElementById('notificationDot');
    const notificationDropdown = document.getElementById('notificationDropdown');
    const notificationList = document.getElementById('notificationList');

    // Función para obtener notificaciones
    async function fetchNotifications() {
        try {
            const response = await fetch('../config/get_notifications.php');
            const notifications = await response.json();

            console.log("Notifications:", notifications);  // Para ver los datos

            if (Array.isArray(notifications) && notifications.length > 0) {
                notificationDot.style.display = 'block';
                notificationList.innerHTML = notifications.map(n => `
                    <a href="/app/html/ver_radicado.php?id=${encodeURIComponent(n.radicado)}" class="dropdown-item">
                        <p class="mb-0">${n.message}</p>
                        <small>${n.time}</small>
                    </a>
                `).join('');
            } else {
                notificationDot.style.display = 'none';
                notificationList.innerHTML = '<p class="text-center mb-0">Sin notificaciones</p>';
            }
            
        } catch (error) {
            console.error('Error fetching notifications:', error);
            notificationDot.style.display = 'none';
            notificationList.innerHTML = '<p class="text-center mb-0">Error al cargar notificaciones</p>';
        }
    }

    // Llama a la función cada 10 segundos
    setInterval(fetchNotifications, 10000);

    // Muestra/oculta el dropdown al hacer clic en la campanita
    notificationBell.addEventListener('click', function () {
        notificationDropdown.style.display = notificationDropdown.style.display === 'none' ? 'block' : 'none';
    });

    // Carga inicial de notificaciones
    fetchNotifications();
});

</script>
