<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="sidebar-sticky pt-3">
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Información Personal</span>
        </h6>
      <ul class="nav flex-column nav-pills">
        <li class="nav-item">
            <a href="{{ Request::is('mi_cuenta/resumen') ? '#' : '/mi_cuenta/resumen' }}" class="nav-link {{ Request::is('mi_cuenta/resumen') ? 'active' : '' }}">Mis Datos Personales</a>
        </li>
        <li class="nav-item">
            <a href="{{ Request::is('mi_cuenta/direcciones') ? '#' : '/mi_cuenta/direcciones' }}" class="nav-link {{ Request::is('mi_cuenta/direcciones') ? 'active' : '' }}">Mis Direcciones</a>
        </li>
        <li class="nav-item">
          <a href="{{ Request::is('mi_cuenta/cuenta_bancaria') ? '#' : '/mi_cuenta/cuenta_bancaria' }}" class="nav-link {{ Request::is('mi_cuenta/cuenta_bancaria') ? 'active' : '' }}">Mi Cuenta Bancaria</a>
      </li>
        <li class="nav-item">
            <a href="{{ Request::is('mi_cuenta/seguridad') ? '#' : '/mi_cuenta/seguridad' }}" class="nav-link {{ Request::is('mi_cuenta/seguridad') ? 'active' : '' }}">Seguridad</a>
        </li>
    </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Mi Billetera</span>
          <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
            <span data-feather="plus-circle"></span>
          </a>
        </h6>
        <ul class="nav flex-column nav-pills">
            <li class="nav-item">
                <a href="{{ Request::is('billetera/resumen') ? '#' : '/billetera/resumen' }}" class="nav-link {{ Request::is('billetera/resumen') ? 'active' : '' }}">Resumen</a>
            </li>
            <li class="nav-item">
                <a href="{{ Request::is('billetera/historial') ? '#' : '/billetera/historial' }}" class="nav-link {{ Request::is('billetera/historial') ? 'active' : '' }}">Historial</a>
            </li>
            <li class="nav-item">
                <a href="{{ Request::is('billetera/transferir') ? '#' : '/billetera/transferir' }}" class="nav-link {{ Request::is('billetera/transferir') ? 'active' : '' }}">Transferir</a>
            </li>
            <li class="nav-item">
                <a href="{{ Request::is('billetera/retirar') ? '#' : '/billetera/retirar' }}" class="nav-link {{ Request::is('billetera/retirar') ? 'active' : '' }}">Retirar</a>
            </li>
            <li class="nav-item">
                <a href="{{ Request::is('billetera/depositar') ? '#' : '/billetera/depositar' }}" class="nav-link {{ Request::is('billetera/depositar') ? 'active' : '' }}">Cargar Saldo</a>
            </li>
            <li class="nav-item">
              <a href="{{ Request::is('billetera/pagoQR') ? '#' : '/billetera/pagoQR' }}" class="nav-link {{ Request::is('billetera/pagoQR') ? 'active' : '' }}">Pago QR</a>
          </li>
          <li>
            <hr />
          </li>
            <li class="nav-item">
                <a href="{{ Request::is('billetera/servicios') ? '#' : '/billetera/servicios' }}" class="nav-link {{ Request::is('billetera/servicios') ? 'active' : '' }}">Pago de Servicios</a>
            </li>
            
            <li class="nav-item">
                <a href="{{ Request::is('billetera/caja_digital') ? '#' : '/billetera/caja_digital' }}" class="nav-link {{ Request::is('billetera/caja_digital') ? 'active' : '' }}">Busca Caja Digital</a>
            </li>
        </ul>
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Finanzas</span>
          <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
            <span data-feather="plus-circle"></span>
          </a>
        </h6>
        <ul class="nav flex-column nav-pills">
            <li class="nav-item">
                <a href="{{ Request::is('billetera/inversion') ? '#' : '/billetera/inversion' }}" class="nav-link {{ Request::is('billetera/inversion') ? 'active' : '' }}">Cuenta de Inversion</a>
            </li>
            <li class="nav-item">
                <a href="{{ Request::is('billetera/credito') ? '#' : '/billetera/credito' }}" class="nav-link {{ Request::is('billetera/credito') ? 'active' : '' }}">Simular Crédito</a>
            </li>

        </ul>
      </div>
    </nav>
    <style>
        body {
  font-size: .875rem;
}

/*
 * Sidebar
 */

.sidebar {
  top: 0;
  bottom: 0;
  left: 0;
  z-index: 100; /* Behind the navbar */
  padding: 0; /* Height of navbar */
  box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
}

.sidebar a.active{
  color: white !important;
}

@media (max-width: 767.98px) {
  .sidebar {
    top: 5rem;
  }
}

.sidebar-sticky {
  position: relative;
  top: 0;
  height: calc(100vh - 48px);
  padding-top: .5rem;
  overflow-x: hidden;
  overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
}

@supports ((position: -webkit-sticky) or (position: sticky)) {
  .sidebar-sticky {
    position: -webkit-sticky;
    position: sticky;
  }
}

.sidebar .nav-link {
  font-weight: 500;
  color: #333;
}

.sidebar .nav-link .feather {
  margin-right: 4px;
  color: #999;
}

.sidebar .nav-link.active {
  color: #007bff;
}

.sidebar .nav-link:hover .feather,
.sidebar .nav-link.active .feather {
  color: inherit;
}

.sidebar-heading {
  font-size: .75rem;
  text-transform: uppercase;
}


    </style>

    <script type="text/javascript">

    </script>
