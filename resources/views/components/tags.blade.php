<div class="field has-addons">
 <label class="label">{{ __( "Tags" ) }}</label>
 <div class="control">
  <input class="input" type="text" name="input_tags" id="input_tags" />
 </div>
 <div class="control">
  <input class="button is-info" type="button" value="+" onClick="addEntry( 'tags', false )">
 </div>
 <input type="hidden" name="value_tags" id="value_tags" /> <!-- only for compatibility -->
 
 
 <ul class="selectable" name="list_tags" id="list_tags">
  @isset($values)
  @foreach($values as $value)
 <li>{{ $value }}<input type="hidden" name="value_tags{{ $loop->index+1 }}" value="{{ $value }}"/></li>
  @endforeach
 @endisset
 </ul>
 <input type="hidden" name="count_tags" id="count_tags" value="@isset($values){{ count($values) }} @else 0 @endisset"/>
 <script>
 	$( function() { tags('{{ $class}}'); } );
 </script>
 </siv>	     
</div>
