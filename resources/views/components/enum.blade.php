<div class="inputgroup">
 <fieldset>
  <legend>{{__($name)}}</legend>>
  <select name="{{$name}}" id="{{$name}}">
	<option value="">(leer)</option>
	@foreach($entries as $value)
	<option value="{{$value}}">{{__($value)}}</option>
	@endforeach
  </select>
 </fieldset>
</div>
