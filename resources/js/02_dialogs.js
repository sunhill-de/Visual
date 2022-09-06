function lookupField( id, classid, ajaxmethod ) {
		$("#input_"+id).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url:"/ajax/"+ajaxmethod+"/"+classid+"/"+id+"/",
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
				$("#input_"+id).val(ui.item.label);
				$("#value_"+id).val(ui.item.id);
				return false;
			},
			focus: function( event, ui ) {
				$("#input_"+id).val(ui.item.label);
				$("#value_"+id).val(ui.item.id);
				return false;
			}
		})

}

function listField( id ) {
		$("#_"+id).selectable({
			selected: function ( event, ui ) {
				var el = $(ui.selected);
				el.remove()
			}
		});
}

function objectField( id, classid ) {
	lookupField( id, classid, "searchObjects" );
}
	
function stringArrayField( id, classid ) {
	listField( id );
	lookupField( id, classid, "searchArrayOfString" );
}	

function objectArrayField( id, classid ) {
	listField( id );
	lookupField( id, classid, "searchObjects" );
}

/**
 * When clicked on the add button, add the current entry to the list
 * @todo only do something, when there is an input
 * @todo clean the input field afterwards
 */
function addEntry( id ) {
    var entry_text = $( "#input_"+id ).val();  // Get the display value
    var entry_value = $( "#value_"+id ).val(); // Get the internal value	      
    var index = parseInt($('#count_'+id).val()) + 1; // Get the next index
	  
    // Append it to the visual part
    $('#_'+id).append('<li>'+entry_text+'<input type="hidden" name="value_'+id+index+'" id="value_'+id+index+'" value="'+entry_value+'"/></li>');
	// Append it to the hidden part
    $('#_'+id+'_count').val(index);    
}
  
