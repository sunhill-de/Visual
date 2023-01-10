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

function tags( classid ) {
	listField( 'tags' );
	lookupField( 'tags', classid, "searchTags" );
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
 	  
      // Append it to the visual part
      if (valueonly || entry_value) {
	  	$('#list_'+id).append('<input type="hidden" name="value_'+id+'[]" id="value_'+id+'[]" value="'+entry_value+'"/>');
	  	$('#list_'+id).append('<div class="control"><input readonly type="input" class"input" name="name_'+id+'[]" id="value_'+id+'[]" value="'+entry_text+'"/></div>');

      } else {
	  	$('#list_'+id).append('<div class="control"><input readonly type="input" class"input" name="value_'+id+'[]" id="value_'+id+'[]" value="'+entry_text+'"/></div>');
	  }
	  // Append it to the hidden part
      $( "#input_"+id ).val("");
      $( "#value_"+id ).val("");
    }     
}
  
