@extends('visual::basic.navigation')

@push('css')
  <link rel="stylesheet" href="/css/style.min.css" />
@endpush

@section('title')
Datenbank Hauptseite
@endsection

@section('content')
@parent
<div class="treeview">
<ul>
<li id="Entry1">Entry 1</li>
<li id="Entry2">Entry 2
 <ul>
  <li id="Entry1.Subentry1">Subentry 1</li>
  <li id="Entry1.Subentry2">Subentry 2
   <ul>
    <li id="Entry1.Subentry2.Subsub1">Subsub1</li>
    <li id="Entry1.Subentry2.Subsub2">Subsub2</li>
   </ul>
  </li>
 </ul>
</li> 
</ul>
</div>
<div id="result"></div>
<script>
 $(function() {
	$('.treeview').jstree({
		"core": {
		   "multiple": false,
		   "animation": 0,
           "themes": { "name":"default",
               			"stripes":"true",
                       "variant":"large",
                       "dots":"true",
                       "icons":"true" }
		},
		"plugins": [ "wholerow" ]
	  }).on('changed.jstree', function (e,data) {
			$("#result").html("Gewählt: "+data.instance.get_node(data.selected).id);	
		  });
	 });
</script>
@endsection
