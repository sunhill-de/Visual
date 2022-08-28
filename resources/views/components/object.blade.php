<div class="inputgroup">
 <fieldset>

 <input name="_{{ $name }}" id="_{{ $name }}" />
 <input type="hidden" name="{{ $name }}" id="{{ $name }}" />

 <legend>{{ __( $name ) }}</legend>
 <script>
 	$( function() { objectField('{{ $name }}', '{{ $class}}'); } );
 </script>
 </fieldset>	     
</div>
