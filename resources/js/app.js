/* =========================================================
   NAVEGACIÓN RESPONSIVE
   POS - TIENDA DE ROPA
   ========================================================= */

document.addEventListener('DOMContentLoaded', () => {

    const sidebar = document.getElementById('appSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const menuButton = document.getElementById('mobileMenuButton');

    // En login o registro estos elementos no existen.
    if (!sidebar || !overlay || !menuButton) {
        return;
    }

    const openSidebar = () => {
        sidebar.classList.add('show');
        overlay.classList.add('show');

        document.body.style.overflow = 'hidden';

        menuButton.setAttribute('aria-expanded', 'true');
    };

    const closeSidebar = () => {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');

        document.body.style.overflow = '';

        menuButton.setAttribute('aria-expanded', 'false');
    };

    // Abrir / cerrar con botón hamburguesa
    menuButton.addEventListener('click', () => {

        if (sidebar.classList.contains('show')) {
            closeSidebar();
        } else {
            openSidebar();
        }

    });

    // Cerrar tocando el fondo
    overlay.addEventListener('click', closeSidebar);

    // Cerrar con Escape
    document.addEventListener('keydown', (event) => {

        if (
            event.key === 'Escape' &&
            sidebar.classList.contains('show')
        ) {
            closeSidebar();
        }

    });

    // Cerrar menú al entrar a una opción desde móvil
    sidebar
        .querySelectorAll('a.sidebar-link')
        .forEach((link) => {

            link.addEventListener('click', () => {

                if (window.innerWidth < 992) {
                    closeSidebar();
                }

            });

        });

    // Limpiar estado si pasamos de móvil a escritorio
    window.addEventListener('resize', () => {

        if (window.innerWidth >= 992) {

            sidebar.classList.remove('show');
            overlay.classList.remove('show');

            document.body.style.overflow = '';

            menuButton.setAttribute('aria-expanded', 'false');
        }

    });

});