<div class="inputgroup">
 <fieldset>
 <legend>{{ __( $name ) }}</legend>
 <input type="text" name="__{{ $name }}" id="__{{ $name }}" />
  <input type="hidden" name="{{ $name }}" id="{{ $name }}" />
 
 <input type="button" value="+" onClick="addObjectEntry('{{ $name }}')" />
 <input type="button" value="-" onClick="delObjectEntry('{{ $name }}')" />

 <ul class="selectable" name="_{{ $name }}" id="_{{ $name }}">
 </ul>

 <input type="hidden" name="{{ $name }}_count" id="_{{$name}}_count" value="0" />
 <script>
 	$( function() { objectArrayField('{{ $name }}', '{{ $class}}'); } );
 </script>
 </fieldset>	     
</div>
