// Menú de hamburguesa para celular
const boton = document.querySelector('.menu-toggle');
const menu = document.getElementById('menu-principal');

if (boton && menu) {
      const cerrar = () => {
            menu.classList.remove('main-menu--abierto');
            boton.setAttribute('aria-expanded', 'false');
            boton.setAttribute('aria-label', 'Abrir menú');
      };

      boton.addEventListener('click', () => {
            const abierto = menu.classList.toggle('main-menu--abierto');
            boton.setAttribute('aria-expanded', String(abierto));
            boton.setAttribute(
                  'aria-label',
                  abierto ? 'Cerrar menú' : 'Abrir menú',
            );
      });

      // Escape cierra el menú
      document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                  cerrar();
                  boton.focus();
            }
      });

      // Al pasar a tablet/laptop el menú ya es horizontal: lo reiniciamos
      window
            .matchMedia('(min-width: 768px)')
            .addEventListener('change', (e) => {
                  if (e.matches) cerrar();
            });
}
