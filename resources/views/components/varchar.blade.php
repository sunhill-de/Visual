<div class="field">
 <label class="label">{{__($name)}}</label>
 <div class="control">
  <input class="input is-small" style="width: 33%;" type="text" name="{{$name}}" id="{{$name}}" @isset($value)) value="{{ $value }}" @endisset />
 </div>
</div>
