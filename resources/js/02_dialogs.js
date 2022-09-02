	function objectField( id, classid ) {
		$("#_"+id).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url:"/ajax/searchObjects/"+classid+"/"+id+"/",
					type:"get",
					dataType:"json",
					data: { 
						search: request.term 
					},
					success: function( data ) {
						response( data );
				}	
				});
			},
			select: function( event, ui ) {
				$("#_"+id).val(ui.item.label);
				$("#"+id).val(ui.item.id);
				return false;
			},
			focus: function( event, ui ) {
				$("#_"+id).val(ui.item.label);
				$("#"+id).val(ui.item.id);
				return false;
			}
		})
	}
	
	function stringArrayField( id, classid ) {
		$("#_"+id).selectable({
			selecting: function ( event, ui ) {
				var el = $(ui.selected);
				el.remove()
			}
		});
		$("#__"+id).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url:"/ajax/searchArrayOfString/"+classid+"/"+id+"/",
					type:"get",
					dataType:"json",
					data: { 
						search: request.term 
					},
					success: function( data ) {
						response( data );
				}	
				});
			},
			select: function( event, ui ) {
				$("#__"+id).val(ui.item.label);
				return false;
			},
			focus: function( event, ui ) {
				$("#__"+id).val(ui.item.label);
				return false;
			}
		})		
	}	

  function addStrEntry( id ) {
	// Get the input
    var entry = $('#__'+id).val();
	// Get the next index
    var index = parseInt($('#_'+id+'_count').val()) + 1;
    // Append it to the visual part
    $('#_'+id).append('<li>'+entry+'</li>');
	// Append it to the hidden part
    $('#_'+id+'_count').val(index);
    $('<input>').attr({
							type: 'hidden',
							name: '_'+id+index,
							id: '_'+id+index,
							value: entry
						 }).appendTo('#add'); 
  }

  function delStrEntry( id ) {
	
  }

  function objectArrayField( id, classid ) {
		$("#_"+id).selectable({
			selecting: function ( event, ui ) {
				var el = $(ui.selected);
				el.remove()
			}
		});
		$("#__"+id).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url:"/ajax/searchObjects/"+classid+"/"+id+"/",
					type:"get",
					dataType:"json",
					data: { 
						search: request.term 
					},
					success: function( data ) {
						response( data );
				}	
				});
			},
			select: function( event, ui ) {
				$("#__"+id).val(ui.item.label);
				$("#"+id).val(ui.item.id);
				return false;
			},
			focus: function( event, ui ) {
				$("#__"+id).val(ui.item.label);
				$("#"+id).val(ui.item.id);
				return false;
			}
		})			
  }
  
 function addObjectEntry( id ) {
	// Get the input
    var text_entry = $('#__'+id).val();
    var num_entry = $('#'+id).val();
	// Get the next index
    var index = parseInt($('#_'+id+'_count').val()) + 1;
    // Append it to the visual part
    $('#_'+id).append('<li>'+text_entry+'</li>');
	// Append it to the hidden part
    $('#_'+id+'_count').val(index);
    $('<input>').attr({
							type: 'hidden',
							name: '_'+id+index,
							id: id+index,
							value: num_entry
						 }).appendTo('#add'); 
  }

	