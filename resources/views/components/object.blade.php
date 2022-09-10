<div class="inputgroup">
 <fieldset>

 <input name="input_{{ $name }}" id="input_{{ $name }}"  @isset($key) value="{{ $obj_key }}" @endisset />
 <input type="hidden" name="value_{{ $name }}" id="value_{{ $name }}" @isset($id) value="{{ $obj_id }}" @endisset/>

 <legend>{{ __( $name ) }}</legend>
 <script>
 	$( function() { objectField('{{ $name }}', '{{ $class}}'); } );
 </script>
 </fieldset>	     
</div>
