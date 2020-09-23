@extends('menos.office.app')

@section('content')
    <h2>Tabla de las comisiones</h2>
    <br />
    <table class="table table-responsive table-hover table-condensed">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Requisitos</th>
                <th>Rango Mínimo</th>
                <th>Comisión</th>
                <th>Forma de Pago</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th class="text-nowrap">Bono Rango</th>
                <td>Alcanzar un nuevo Rango, cuando tu equipo de menor consumo alcance un valor segun la tabla, y tengas un mínimo de patrocinados en un rango segun la tabla</td>
                <td>Director</td>
                <td>Bono según escala</td>
                <td>Abono a tu cuenta al momento de de cumplir el requisito</td>
            </tr>
            <tr>
                <th class="text-nowrap">Bono Éxito</th>
                <td>Cada vez que invitas un nuevo asociado y lo ayudas a conseguir dos asociados (es decir un asociado obtiene el rango de Emprendedor)</td>
                <td>Asociado</td>
                <td>Bono según escala</td>
                <td>Abono a tu cuenta Menos al momento de de cumplir el requisito</td>
            </tr>
            <tr>
                <th class="text-nowrap">Bono por Equipo</th>
                <td>Consumo del tus equipos de red binaria</td>
                <td>Emprendedor</td>
                <td>10% del consumo de mi equipo con menor puntaje durante el mes</td>
                <td>Al cierre del período se abonara el bono a tu cuenta Menos</td>
            </tr>
            <tr>
                <th class="text-nowrap">Bono Generacional</th>
                <td>Que mis asociados patrocinados por mi tengan consumo en el mes</td>
                <td>Boss</td>
                <td>Un % del consumo hasta tu 7ma Generación según la tabla</td>
                <td>Al cierre del período se abonara el bono a tu cuenta Menos</td>
            </tr>
            <tr>
                <th class="text-nowrap">Comisión Venta Directa</th>
                <td>Todas las ventas de tus e-commerce</td>
                <td>Asociado</td>
                <td>85% del valor de venta de los productos</td>
                <td>Al momento de entrega del producto o pasados 5 días desde la venta, se abonará a tu cuenta Menos</td>
            </tr>
            <tr>
                <th class="text-nowrap">Comision de Comercios asociados</th>
                <td>Usar Menos como pasarela de pago en un comercio asociado por el usuario</td>
                <td>Asociado</td>
                <td>De un 0,3 a un 0,5% del total de las ventas en comercios asociados por mi</td>
                <td>Al momento de entrega del producto o pasados 5 días desde la venta, se abonará a tu cuenta Menos</td>
            </tr>
            <tr>
                <th class="text-nowrap">Bono Referido</th>
                <td>Referir un producto para venta mediante link</td>
                <td>Asociado</td>
                <td>2% de la venta</td>
                <td>Al momento de entrega del producto o pasados 5 días desde la venta, se abonará a tu cuenta Menos</td>
            </tr>
            <tr>
                <th class="text-nowrap">Comision por Patrocinar</th>
                <td>Patrocinar un nuevo asociado</td>
                <td>Asociado</td>
                <td>25% del valor del paquete Business</td>
                <td>Al momento de entrega del producto o pasados 5 días desde la venta, se abonará a tu cuenta Menos</td>
            </tr>
        </tbody>
    </table>
    <br />
    <h2>Tabla de Rangos</h2>
    <br />
    <table class="table table-bordered table-condensed table-hover table-responsive">
        <thead>
            <tr>
                <th class="text-center" rowspan="2">Rango</th>
                <th class="text-center" colspan="7">Asociados Mínimos con Rango</th>
                <th class="text-center text-vertical" rowspan="2">Consumo equipo puntaje inferior</th>
                <th class="text-center text-vertical" rowspan="2">Monto Bono Rango</th>
                <th class="text-center" colspan="2">Bono Generacion</th>
                <th class="text-center text-vertical" rowspan="2">Consumo mínimo para estar activo</th>
            </tr>
            <tr>
                <th>Asociado</th>
                <th>Emprendedor</th>
                <th>Emp. Senior</th>
                <th>Boss</th>
                <th>Director</th>
                <th>Senior Direc</th>
                <th>Diamante</th>
                <th>Generacion</th>
                <th>%</th>
            </tr>

        </thead>
        <tbody>
            <tr>
                <th class="text-nowrap" style="color:white; background:black;">Diamante Negro</th>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center">2</td>
                <td class="text-right text-nowrap">$ 50.000.000.-</td>
                <td class="text-right text-nowrap">$ 10.000.000.-</td>
                <td class="text-center">7º</td>
                <td class="text-center">1%</td>
                <td class="text-right text-nowrap">$ 1.000.000.-</td>
            </tr>
            <tr>
                <th class="text-nowrap" style="background: white">Diamante Blanco</th>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center">2</td>
                <td class="text-center"></td>
                <td class="text-right text-nowrap">$ 40.000.000.-</td>
                <td class="text-right text-nowrap">$  5.000.000.-</td>
                <td class="text-center">7º</td>
                <td class="text-center">1%</td>
                <td class="text-right text-nowrap">$ 1.000.000.-</td>
            </tr>
            <tr>
                <th class="text-nowrap" style="background: blue; color:white">Diamante Azul</th>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center">2</td>
                <td class="text-center"></td>
                <td class="text-right text-nowrap">$ 35.000.000.-</td>
                <td class="text-right text-nowrap">$  5.000.000.-</td>
                <td class="text-center">7º</td>
                <td class="text-center">1%</td>
                <td class="text-right text-nowrap">$ 1.000.000.-</td>
            </tr>
            <tr>
                <th class="text-nowrap" style="background: lightblue">Diamante</th>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center">2</td>
                <td class="text-center"></td>
                <td class="text-right text-nowrap">$ 30.000.000.-</td>
                <td class="text-right text-nowrap">$  5.000.000.-</td>
                <td class="text-center">7º</td>
                <td class="text-center">1%</td>
                <td class="text-right text-nowrap">$   500.000.-</td>
            </tr>
            <tr>
                <th class="text-nowrap" style="background: gold">Oro</th>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center">2</td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-right text-nowrap">$ 15.000.000.-</td>
                <td class="text-right text-nowrap">$  2.500.000.-</td>
                <td class="text-center">6º</td>
                <td class="text-center">2%</td>
                <td class="text-right text-nowrap">$   250.000.-</td>
            </tr>
            <tr>
                <th class="text-nowrap" style="background: silver">Plata</th>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center">2</td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-right text-nowrap">$ 10.000.000.-</td>
                <td class="text-right text-nowrap">$  2.000.000.-</td>
                <td class="text-center">5º</td>
                <td class="text-center">3%</td>
                <td class="text-right text-nowrap">$   250.000.-</td>
            </tr>
            <tr>
                <th class="text-nowrap" style="background: orange">Bronce</th>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center">2</td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-right text-nowrap">$  8.000.000.-</td>
                <td class="text-right text-nowrap">$  1.500.000.-</td>
                <td class="text-center">4º</td>
                <td class="text-center">4%</td>
                <td class="text-right text-nowrap">$   200.000.-</td>
            </tr>
            <tr>
                <th class="text-nowrap" style="background: purple; color: white">Senior Director</th>
                <td class="text-center"></td>
                <td class="text-center">2</td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-right text-nowrap">$  5.000.000.-</td>
                <td class="text-right text-nowrap">$  1.000.000.-</td>
                <td class="text-center">3º</td>
                <td class="text-center">5%</td>
                <td class="text-right text-nowrap">$   100.000.-</td>
            </tr>
            <tr>
                <th class="text-nowrap" style="background: plum">Director</th>
                <td class="text-center">2</td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-right text-nowrap">$  2.500.000.-</td>
                <td class="text-right text-nowrap">$    500.000.-</td>
                <td class="text-center">2º</td>
                <td class="text-center">6%</td>
                <td class="text-right text-nowrap">$    50.000.-</td>
            </tr>
            <tr>
                <th class="text-nowrap" style="background: thistle">Boss</th>
                <td class="text-center">2</td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-right text-nowrap">$  1.000.000.-</td>
                <td class="text-right"></td>
                <td class="text-center">1º</td>
                <td class="text-center">7%</td>
                <td class="text-right text-nowrap">$    35.000.-</td>
            </tr>
            <tr>
                <th class="text-nowrap" style="background: gray; color: white">Emp. Senior</th>
                <td class="text-center">2</td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-right text-nowrap">$    500.000.-</td>
                <td class="text-right"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-right text-nowrap">$    20.000.-</td>
            </tr>
            <tr>
                <th class="text-nowrap" style="background: darkgrey">Emprendedor</th>
                <td class="text-center">2</td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-right text-nowrap">$     40.000.-</td>
                <td class="text-right"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-right text-nowrap">$    20.000.-</td>
            </tr>
            <tr>
                <th class="text-nowrap" style="background: lightgray">Asociado</th>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-right text-nowrap">$         0.-</td>
                <td class="text-right"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-right text-nowrap">$    20.000.-</td>
            </tr>
        </tbody>
    </table>
    <style>
        .text-vertical{
            writing-mode: vertical-rl;
            text-orientation: mixed;
        }
    </style>
@endsection