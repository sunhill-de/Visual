<div class="field">
 <label class="label">{{ __( $name ) }}</label>
 <div class="columns">
  <div class="column">
   <label class="label">{{__( "Search" ) }}</label>
   <div class="control">
    <input class="input" type="text" name="input_{{ $name }}" id="input_{{ $name }}" />
    <input type="hidden" name="value_{{ $name }}" id="value_{{ $name }}" /> <!-- only for compatibility -->
    <div class="control">
     <input class="button is-info" type="button" value="+" onClick="addEntry( '{{  $name }}', false )">
    </div>
   </div>
  
   <div class="column">
    <label class="label">{{__( "Current setting" ) }}</label>  
    <div class="dynamic_list" id="list_{{ $name }}">
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
 </div>
</div>

<script>
 	$( function() { stringArrayField('{{ $name }}', '{{ $class}}'); } );
</script>
