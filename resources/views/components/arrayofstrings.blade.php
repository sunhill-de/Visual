<div class="inputgroup">
<!--   <label for="_{{$name}}">{{__($name)}}</label>
 <input type="text" name="_{{$name}}" id="_{{$name}}" />
 <input type="button" value="+" onClick="

	     "/> -->
 <fieldset>
 <input type="button" value="+" onClick="addStrEntry( '{{ $name }}' )">
 <input type="button" value="-" onClick="delStrEntry( '{{ $name }}' )">

 <legend>{{ __( $name ) }}</legend>
 <ul class="selectable" name="_{{ $name }}" id="_{{ $name }}">
 </ul>

 <input type="hidden" name="{{$name}}" id="{{$name}}" value=""/>
 <ul id="value_{{$name}}"></ul>
 </fieldset>	     
</div>
