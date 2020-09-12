@extends('menos.office.app')

@section('content')
    <h2>Tabla de las comisiones</h2>
    <br />
    <table class="table">
        <tr>
            <th>Nombre</th>
            <th>Requisitos</th>
            <th>Comisión</th>
        </tr>

        <tr>
            <td>Bono Rango</td>
            <td>Alcanzar un nuevo Rango (rango mínimo: Director)</td>
            <td>Bono según escala</td>
        </tr>
        <tr>
            <td>Bono Éxito</td>
            <td>Cada vez que invitas un nuevo asociado</td>
            <td>Bono según escala</td>
        </tr>
        <tr>
            <td>Bono por Equipo</td>
            <td>Desde Emprendedor</td>
            <td>10% del consumo de mi equipo inferior</td>
        </tr>
        <tr>
            <td>Bono Liderazgo</td>
            <td>Desde el Rango Boss</td>
            <td>Un % del consumo hasta tu 7ma Generación</td>
        </tr>
        <tr>
            <td>Comisión Venta Directa</td>
            <td>Todas las ventas de tus e-commerce</td>
            <td>85% del valor de venta de los productos</td>
        </tr>
        <tr>
            <td>Comision de Comercios asociados</td>
            <td>Ventas de comercios asociados en la plataforma</td>
            <td>De un 0,3 a un 0,5% del total de las ventas en comercios asociados por mi</td>
        </tr>
    </table>
@endsection