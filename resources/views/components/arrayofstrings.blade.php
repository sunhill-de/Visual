<div class="field">
 <label class="label">{{ __( $name ) }}</label>
 <div class="control">
  <input class="input" type="text" name="input_{{ $name }}" id="input_{{ $name }}" />
  <input type="hidden" name="value_{{ $name }}" id="value_{{ $name }}" /> <!-- only for compatibility -->
  <div class="control">
   <input class="button is-info" type="button" value="+" onClick="addEntry( 'tags', false )">
  </div>
  <div class="dynamic_list">
  @isset($values)
   @foreach($values as $value)
   <div class="control">
    <input class="input dynamic_entry" readonly name="{{ $name }}[]" />
   </div>
   @endforeach
  @endisset
  </div>
 </div>
</div>
<script>
 	$( function() { stringArrayField('{{ $name }}', '{{ $class}}'); } );
</script>
</div>
