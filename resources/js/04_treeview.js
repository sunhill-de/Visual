  $( function() {
$(".treeview").jstree({
    "core": {
        "themes": {
            "responsive": false,
			"stripes": true
        },
        // so that create works
     //   "check_callback": true,
        'data': {
            "url": function(node) {
				if (node.id === "#") {
					return "{{ asset("/ajax/getNodes/!root!") }}";
				} else {
					return "{{ asset("/ajax/getNodes/") }}/"+node.id; 					
				}             
            },
			"data-type": "json",
            "data": function(node) {
                return {
                    "id": node.id
                };
			}
       } 
    },
    "types": {
        "default": {
            "icon": "fa fa-folder text-primary"
        },
        "file": {
            "icon": "fa fa-file  text-primary"
        }
    },
    "state": {
        "key": "demo3"
    },
    "themes": {
		"theme": "default",
		"dots": true,
		"icons": true
	},

    "plugins": ["dnd", "themes", "state", "json-data", "types", "wholerow"]
})

$(".treeview").on('changed.jstree', function (e,data) {
			var id = data.instance.get_node(data.selected).id;
				
				$.ajax("{{ asset('/ajax/getItem/') }}/"+id,
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
		/*				if (jsondata.writeable) {
							$("#setvalue").enable();
						} else {
							$("#setvalue").disable();
						}*/
					}
				})
		  });;

});
