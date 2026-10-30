// Menú de hamburguesa + mensaje precargado al elegir un destino
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
            boton.setAttribute('aria-label', abierto ? 'Cerrar menú' : 'Abrir menú');
      });

      // Al tocar un enlace del menú, se cierra
      menu.addEventListener('click', (e) => {
            if (e.target.closest('a')) cerrar();
      });

      document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                  cerrar();
                  boton.focus();
            }
      });

      window.matchMedia('(min-width: 768px)').addEventListener('change', (e) => {
            if (e.matches) cerrar();
      });
}

// Al hacer clic en un destino, el mensaje del formulario ya dice cuál fue
document.addEventListener('click', (e) => {
      const enlace = e.target.closest('[data-destino]');
      const mensaje = document.getElementById('mensaje');
      if (enlace && mensaje && !mensaje.value.trim()) {
            mensaje.value = `Hola, me interesa información sobre ${enlace.dataset.destino}.`;
      }
});
