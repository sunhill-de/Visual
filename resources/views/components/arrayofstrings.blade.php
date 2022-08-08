<div class="inputgroup">
 <fieldset>
 <input type="button" value="+" onClick="addStrEntry( '{{ $name }}' )">
 <input type="button" value="-" onClick="delStrEntry( '{{ $name }}' )">

 <legend>{{ __( $name ) }}</legend>
 <ul class="selectable" name="_{{ $name }}" id="_{{ $name }}">
 </ul>

 <input type="hidden" name="_{{$name}}_count" id="_{{$name}}_count" value="0"/>
 <ul id="_{{$name}}"></ul>
 </fieldset>	     
</div>
