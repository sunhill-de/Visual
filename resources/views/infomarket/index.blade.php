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
			var id = data.instance.get_node(data.selected).id;
			if (id.substring(0,5) == 'item:') {
				id = id.substr(5);
				$.ajax('/ajax/getItem/'+id,
				{
					dataType: 'json',
					timeout: 500,
					success: function ( data, status, xhr ) {
						jsondata = JSON.parse( data );
						console.log(jsondata);
						$("#itemname").html(id);
						$("#itemvalue").html( jsondata.value );
						$("#itemunit").html( jsondata.unit );
						$("#itemsemantic").html( jsondata.semantic );
						$("#itemtype").html( jsondata.type );
						$("#itemupdate").html (jsondata.update );
						if (jsondata.writeable) {
							$("#setvalue").enable();
						} else {
							$("#setvalue").disable();
						}
					}
				})
			}
		  });
	 
	 	$("#setvalue").click( function() {
	 		var id = $("#itemname").html();
	 		alert(id); 
	 	});
	 });
</script>
<div class="treeview"><ul>
@each('visual::partials.infomarket', $entries, 'entry')
</ul></div>
<div id="info" class="footer">
 <div class="columns">
 <div class="column"><div class="label">{{ __("Item") }}:</div><div id="itemname"></div></div>
 <div class="column"><div class="label">{{ __("Type") }}:</div><div id="itemtype"></div></div>
 </div>
 <div class="columns"> 
 <div class="column"><div class="label">{{ __("Semantic type") }}:</div><div id="itemsemantic"></div></div>
 <div class="column"><div class="label">{{ __("Unit") }}:</div><div id="itemunit"></div></div>
 </div>
 <div class="columns"> 
 <div class="column"><div class="label">{{ __("Value") }}:</div><div id="itemvalue"></div></div>
 <div class="column"><div class="label">{{ __("Update") }}:</div><div id="itemupdate"></div></div>
 </div>
 <button id="setvalue">Wert setzen</button>
</div>
@endsection
