$(".treeview").jstree({
    "core": {
        "themes": {
            "responsive": false
        },
        // so that create works
        "check_callback": true,
        'data': {
            'url': function(node) {
                return '/ajax/getNodes'; 
            },
            'data': function(node) {
                return {
                    'parent': node.id
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
    "plugins": ["dnd", "state", "types", "wholerow"]
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
		  });;
