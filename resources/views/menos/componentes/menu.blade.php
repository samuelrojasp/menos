
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav flex-column nav-pills">
                    <li>Información Personal</a></li>
                    <li class="nav-item">
                        <a href="{{ Request::is('mi_cuenta/resumen') ? '#' : '/mi_cuenta/resumen' }}" class="nav-link {{ Request::is('mi_cuenta/resumen') ? 'active' : '' }}">Mis Datos Personales</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ Request::is('mi_cuenta/seguridad') ? '#' : '/mi_cuenta/seguridad' }}" class="nav-link {{ Request::is('mi_cuenta/seguridad') ? 'active' : '' }}">Seguridad</a>
                    </li>
                    <li><hr/></li>
                    <li>Billetera</a></li>
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
                        <a href="{{ Request::is('billetera/retirar') ? '#' : '/billetera/retirar' }}" class="nav-link {{ Request::is('billetera/retirar') ? 'active' : '' }}">Retiro en Efectivo</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ Request::is('billetera/depositar') ? '#' : '/billetera/depositar' }}" class="nav-link {{ Request::is('billetera/depositar') ? 'active' : '' }}">Depósito en Efectivo</a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </div>
