@extends('visual::basic.navigation')

@push('css')
  <link rel="stylesheet" href="/css/style.min.css" />
@endpush

@section('title')
Datenbank Hauptseite
@endsection

@section('content')
@parent
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
<div class="treeview"><ul>
@each('visual::partials.infomarket', $entries, 'entry')
</ul></div>
<div id="result"></div>
@endsection
