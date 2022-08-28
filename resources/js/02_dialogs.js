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

  function addStrEntry( id ) {
// @todo Implement a suggestion AJAX function
	  $('<form><label for="_enter">Eingabe</label><input type="text" id="_enter"></form>').dialog({
			 modal: true,
			 buttons: {
				 'OK': function() {
					// Get the input
					 var entry = $(this).find('#_enter').val();
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
					 $(this).dialog('close');
				 },
				 'Cancel': function() {
					 $(this).dialog('close');
				 }
			 }
		 });	 		 			 
  }

	