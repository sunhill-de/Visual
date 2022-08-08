@extends('visual::basic.navigation')

@push('css')
  <style>
  .feedback { font-size: 1.4em; }
  .selectable .ui-selecting { background: #FECA40; }
  .selectable .ui-selected { background: #F39814; color: white; }
  .selectable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
  .selectable li { margin: 3px; padding: 0.4em; font-size: 1.4em; height: 18px; }
  </style>
@endpush

@section('title','Objekt hinzufügen')

@section('caption')
Objekt von '{{ $class->name }}' hinzufügen
@endsection

@section('content')
@parent
<form method="post" id="add" name="add" action="{{ $prefix }}/Objects/execadd">
 @csrf
 Klassenname: {{ $class->name }}<br />
 Tabellenname: {{ $class->tablename }}<br />
 <input type="hidden" name="_class" value="{{ $class->name }}" />
 @foreach ($class->fields as $field)
  <x-visual-input id="{{ $class->name }}" name="{{ $field->name }}" action="add" />
 @endforeach
 <input type="submit" value="abschicken" />
</form>
<script>
  $( function() {
    $( ".selectable" ).selectable();

  }); 

  function addStrEntry( id ) {
		 $('<form><input type="text" id="_enter"></form>').dialog({
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
					 alert($('#_'+id+'_count').val());
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

  	  
</script>
@endsection
  
