<div class="inputgroup">
 <fieldset>

 <input name="_{{ $name }}" id="_{{ $name }}" />
 <input type="hidden" name="{{ $name }}" id="{{ $name }}" />
 <input type="button" value="+" onClick="addObjectToList('{{ $name }}')" />
 <input type="button" value="-" onClick="delObjectToList('{{ $name }}')" />
 <input type="hidden" name="{{ $name }}_count" value="0" />
 <legend>{{ __( $name ) }}</legend>
 <script>
 	$( function() { objectField('{{ $name }}', '{{ $class}}'); } );
 </script>
 </fieldset>	     
</div>
