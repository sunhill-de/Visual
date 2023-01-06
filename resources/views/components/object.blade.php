<div class="field">
 <label class="label">{{ __( $name ) }}</label>

 <div class="control">
  <input  class="input is-small" style="width: 33%;" name="input_{{ $name }}" id="input_{{ $name }}"  @isset($key) value="{{ $obj_key }}" @endisset />
 </div>
 <input type="hidden" name="value_{{ $name }}" id="value_{{ $name }}" @isset($id) value="{{ $obj_id }}" @endisset/>
 <script>
 	$( function() { objectField('{{ $name }}', '{{ $class}}'); } );
 </script>
</div>
