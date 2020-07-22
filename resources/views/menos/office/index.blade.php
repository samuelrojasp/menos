@extends('menos.office.app')

@section('content')
<h2>Dashboard</h2>
<div class="card">
    <div class="row">
        <div class="col-md-6">
            <div class="col-md-12">
                <h5>Ventas de mis e-commerce</h5>
            </div>
            <canvas height="150" width="300" id="sales-chart"></canvas>
            <div class="col-md-6">
                <select class="form-control selector-periodo" data-target="sales-chart">
                    <option value="weekday">Esta Semana</option>
                    <option value="monthday">Este Mes</option>
                    <option value="yearmonth">Este Año</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-md-12">
                <h5>Consumo árbol binario</h5>
            </div>
            <canvas height="150" width="300" id="binary-purchases-chart"></canvas>
            <div class="col-md-6">
                <select class="form-control selector-periodo" data-target="binary-purchases-chart">
                    <option value="weekday">Esta Semana</option>
                    <option value="monthday">Este Mes</option>
                    <option value="yearmonth">Este Año</option>
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="col-md-12">
                <h5>Consumo árbol binario</h5>
            </div>
            <canvas height="150" width="300" id="binary-members"></canvas>
        </div>

        <div class="col-md-6">
            <div class="col-md-12">
                <h5>Arbol generacional por niveles</h5>
            </div>
            <table class="table">
                <tr>
                    <th>Nivel</th>
                    <th>Nº Asociados</th>
                    <th>Consumo</th>
                </tr>
            @forelse ($resumen as $r)
                <tr>
                    <td>{{ $r['level'] }}</td>
                    <td>{{ $r['qty'] }}</td>
                    <td>{{ $r['purchases'] }}</td>
                </tr>
            @empty
                
            @endforelse
            </table>
        </div>


    </div>
    
    
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>

var $select = document.getElementsByClassName('selector-periodo');

var weekdays = ['lun', 'mar', 'mié', 'jue', 'vie', 'sáb', 'dom'];
var months = ['ene', 'feb','mar','abr','may','jun','jul','ago','sep','oct','nov','dic'];

var weekdaySales = {
    label: weekdays,
    url: "/api/charts/sales/all-shops/{!! $user->id !!}/weekday",
    target: "sales-chart",
}

var monthdaySales ={
    label: null,
    url: '/api/charts/sales/all-shops/{!! $user->id !!}/monthdays',
    target: 'sales-chart',
}

var yearmonthSales ={
    label: months,
    url: '/api/charts/sales/all-shops/{!! $user->id !!}/yearmonths',
    target: 'sales-chart',
}

var weekdayBinary = {
    label: weekdays,
    url: "/api/charts/binary/purchases/{!! $user->id !!}/weekday",
    target: "binary-purchases-chart",
}

var monthdayBinary ={
    label: null,
    url: '/api/charts/binary/purchases/{!! $user->id !!}/monthdays',
    target: 'binary-purchases-chart',
}

var yearmonthBinary ={
    label: months,
    url: '/api/charts/binary/purchases/{!! $user->id !!}/yearmonths',
    target: 'binary-purchases-chart',
}

function changePeriod(e){
    var value = e.target.value
    var target = e.target.dataset['target']
    
    target = target.charAt(0).toUpperCase() + target.slice(1).split('-')[0];
    
    showChart(eval(value + target))
}

Array.from($select).forEach(function($select) {
    $select.addEventListener('change', changePeriod)
})

showChart(weekdaySales)
showChart(weekdayBinary)

function showChart(obj){    
    fetch(obj.url)
        .then(response => response.json())
        .then(function(res){
            var ctx = document.getElementById(obj.target).getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'bar',

                // The data for our dataset
                data: {
                    labels: obj.label || Object.keys(res.this_year),
                    datasets: [{
                        label: 'Mismo periodo año anterior',
                        backgroundColor: '#ff0000',
                        borderColor: '#000000',
                        data: Object.values(res.last_year)
                    },
                    {
                        label: 'Este año',
                        backgroundColor: '#0000ff',
                        borderColor: '#000000',
                        data: Object.values(res.this_year)
                    }]
                },

                // Configuration options go here
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                precision: 0,
                                suggestedMax: 1000000
                            }
                        }]
                    }
                }
            });
    });
}

  
fetch('/api/charts/binary/{!! $user->id !!}/by-team')
    .then(response => response.json())
    .then(function (res) {
        var ctx = document.getElementById('binary-members').getContext('2d');
        var chart = new Chart(ctx, {
            
            // The type of chart we want to create
            type: 'bar',

            // The data for our dataset
            data: {
                datasets: [{
                    label: 'Nº Eq. Izquierdo',
                    backgroundColor: '#ff0000',
                    borderColor: '#000000',
                    data: [res.left.member_count],
                    yAxisID: 'y-axis-1',
                },
                {
                    label: '$ Eq. Izquierdo',
                    type: 'bar',
                    backgroundColor: '#cccccc',
                    borderColor: '#aa0000',
                    data: [res.left.total_purchases],
                    yAxisID: 'y-axis-2',
                },
                {
                    label: 'Nº Eq. Derecho',
                    backgroundColor: '#0000ff',
                    borderColor: '#000000',
                    data: [res.right.member_count],
                    yAxisID: 'y-axis-1',
                },
                {
                    label: '$ Eq. Derecho',
                    type: 'bar',
                    backgroundColor: '#cccccc',
                    borderColor: '#0000aa',
                    data: [res.right.total_purchases],
                    yAxisID: 'y-axis-2',
                },
                ],
            },

            // Configuration options go here
            options: {
                scales: {
                    yAxes: [{
                        
                    }]
                },
                scales: {
						yAxes: [{
							type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
							display: true,
							position: 'left',
							id: 'y-axis-1',
						}, {
							type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
							display: true,
							position: 'right',
							id: 'y-axis-2',
							gridLines: {
								drawOnChartArea: false
							}
						}],
                }
            }
        });
    });
</script>
@endsection