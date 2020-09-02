@extends('menos.office.app')

@section('content')
<div class="dhx_sample-container__widget" id="diagram"></div>

<script type="text/javascript" src="/diagram/codebase/diagram.js?v=3.0.2"></script>
<link rel="stylesheet" href="/diagram/codebase/diagram.css?v=3.0.2">
    <script type="text/javascript">
      fetch('/api/afiliates_sponsor_tree/{!! auth()->user()->id !!}')
            .then(response => response.json())
            .then(function(res){
              var data = [];
              var nodes = [];
              var orgChartData = [];

              res.forEach(function(item, index, arr){
                var structure = [];
                
                structure[0] = item.sponsor_id == null || item.id == {!! auth()->user()->id !!} ? "" : `${item.sponsor_id}`;
                structure[1] = String(item.id);
                
                var person = {};
                person.id = structure[1];
                person.title = item.name;
                person.text = String(item.total_purchases)
                person.img = item.avatar;
                if (structure[0] != "") {
                  data.push(structure);

                  var lines = {
                    id: `${structure[0]}-${structure[1]}`,
                    from: structure[0],
                    to: structure[1],
                    type: "line"
                  }
                }
                orgChartData.push(person);
                if(lines){
                  orgChartData.push(lines);
                }
              });

              var diagram = new dhx.Diagram("diagram", { type: "org", defaultShapeType: "img-card" });
              diagram.data.parse(orgChartData);

              
            });
   </script>
@endsection