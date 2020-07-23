@extends('menos.office.app')

@section('content')
<style>
    .google-visualization-orgchart-table{
        border-collapse: separate;
    }
</style>

<div id="chart_div"></div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {packages:["orgchart"]});
      google.charts.setOnLoadCallback(drawChart);

      

      function drawChart(obj) {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('string', 'Manager');
        data.addColumn('string', 'ToolTip');

        fetch('/api/afiliates_sponsor_tree/{!! auth()->user()->id !!}')
            .then(response => response.json())
            .then(function(res){
              var nodes = [];
              
              res.forEach(function(item, index, arr){
                var obj = {};
                obj.v = String(item.id);
                obj.f = `${item.name} <br /> $ ${parseInt(item.total_purchases)}`;
                
                nodes.push([obj, item.sponsor_id == null || item.id == {!! auth()->user()->id !!} ? "" : String(item.sponsor_id), '']);
              });

              data.addRows(
                nodes
        );

        // Create the chart.
        var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
        // Draw the chart, setting the allowHtml option to true for the tooltips.
        chart.draw(data, {'allowHtml':true});
            });

        // For each orgchart box, provide the name, manager, and tooltip to show.
        
      }
   </script>
@endsection