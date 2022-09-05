<div class="inputgroup">
 <fieldset>

 <input name="_{{ $name }}" id="_{{ $name }}"  @isset($key) value="{{ $obj_key }}" @endisset />
 <input type="hidden" name="{{ $name }}" id="{{ $name }}" @isset($id) value="{{ $obj_id }}" @endisset/>

 <legend>{{ __( $name ) }}</legend>
 <script>
 	$( function() { objectField('{{ $name }}', '{{ $class}}'); } );
 </script>
 </fieldset>	     
</div>
