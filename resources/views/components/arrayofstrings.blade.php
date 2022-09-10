<div class="inputgroup">
 <fieldset>
 <legend>{{ __( $name ) }}</legend>
 <input type="text" name="input_{{ $name }}" id="input_{{ $name }}" />
 <input type="hidden" name="value_{{ $name }}" id="value_{{ $name }}" /> <!-- only for compatibility -->
 
 <input type="button" value="+" onClick="addEntry( '{{ $name }}', false )">
 
 <ul class="selectable" name="list_{{ $name }}" id="list_{{ $name }}">
  @isset($values)
  @foreach($values as $value)
 <li>{{ $value }}<input type="hidden" name="value_{{ $name }}{{ $loop->index+1 }}" value="{{ $value }}"/></li>
  @endforeach
 @endisset
 </ul>
 <input type="hidden" name="count_{{$name}}" id="count_{{$name}}" value="@isset($values){{ count($values) }} @else 0 @endisset"/>
 <script>
 	$( function() { stringArrayField('{{ $name }}', '{{ $class}}'); } );
 </script>
 </fieldset>	     
</div>
