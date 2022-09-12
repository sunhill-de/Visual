  $( function() {
    $( document ).tooltip();
  } );
  
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
		$("#list_"+id).selectable({
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
 * @todo only do something, when there is an input (finished)
 * @todo clean the input field afterwards (finished)
 */
function addEntry( id, valueonly ) {
    var entry_text = $( "#input_"+id ).val();  // Get the display value
    var entry_value = $( "#value_"+id ).val(); // Get the internal value	      
    if ((entry_value) && (valueonly == true) ||
        (valueonly == false) && (entry_text)) {
      var index = parseInt($('#count_'+id).val()) + 1; // Get the next index
	  
      // Append it to the visual part
      if (valueonly || entry_value) {
	  	$('#list_'+id).append('<li>'+entry_text+'<input type="hidden" name="value_'+id+index+'" id="value_'+id+index+'" value="'+entry_value+'"/></li>');
      } else {
	  	$('#list_'+id).append('<li>'+entry_text+'<input type="hidden" name="value_'+id+index+'" id="value_'+id+index+'" value="'+entry_text+'"/></li>');	
	  }
	  // Append it to the hidden part
      $('#count_'+id).val(index);
      $( "#input_"+id ).val("");
      $( "#value_"+id ).val("");
    }	    
}
  
