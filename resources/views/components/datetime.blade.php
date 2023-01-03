<div class="field">
 <label class="label" for="{{$name}}">{{__($name)}}</label>
 <div class="control">
  <input class="input" type="datetime-local" name="{{$name}}" id="{{$name}}" @isset($value)) value="{{ $value }}" @endisset/>
 </div> 
</div>
