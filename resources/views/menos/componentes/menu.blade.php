
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
                        <a href="#" class="nav-link">Retirar en Efectivo</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Comprar (SOLO PRUEBAS)</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Historial de Movimientos</a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </div>
