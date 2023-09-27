function lookupInput( id, ajaxmodule, addentry = false, param1 = '', param2 = '')
{
	$('#input_'+id).autocomplete({
		source: function( request, response ) {
			$.ajax({
				url:"{{ asset("/ajax/") }}/"+ajaxmodule+"/"+((param1)?param1+"/":"")+((param2)?param2+"/":""),
				type: "get",
				dataType: "json",
				data: {
					search: request.term
				},
				success: function( data ) {
					response( data )
				}
			})
		},
		select: function( event, ui ) {
		   $("#input_"+id).val(ui.item.label);
		   $("#value_"+id).val(ui.item.id);
		   if (addentry) {
		   	addEntry(id , false);
		   }	
		   return false;	
		},
		focus: function( event, ui ) {
		   $("#input_"+id).val(ui.item.label);
		   $("#value"+id).val(ui.item.id);
		   return false;				
		}
	})
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
	  	$('#list_'+id).append('<div class="control"><input type="hidden" name="'+id+'[]" id='+id+'[]" value="'+entry_value+'"/>'+
	  						  '<input readonly type="input" class="input is-small dynamic_entry" name="name_'+id+'[]" id="value_'+id+'[]" value="'+entry_text+'" onclick="removeElement( $(this) )" /></div>');

      } else {
	  	$('#list_'+id).append('<div class="control"><input readonly type="input" class="input is-small dynamic_entry" name="'+id+'[]" id="value_'+id+'[]" value="'+entry_text+'" onclick="removeElement( $(this) )" /></div>');
	  }
	  // Append it to the hidden part
      $( "#input_"+id ).val("");
      $( "#value_"+id ).val("");
    }     
}

function removeEntry( id ) {
	$( "#input_"+id ).val("");
	$( "#value_"+id ).val("");
	$( "#current_"+id).val("");
} 

