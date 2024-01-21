@extends('visual::basic.navigation')

@section('content')
<form action="{{ route('user.execlogin') }}" method="post">
 @csrf
 <div class="field is-horizontal">
  <label class="field-label" for="name">{{ __("User name") }}</label>
  <div class="control field-body">
   <select name="name">
  @foreach($users as $user)
    <option value="{{ $user }}">{{ $user }}</option>
  @endforeach
  </select>
 </div>
</div>

<div class="field is-horizontal">
 @isset($error)
  <p class="help is-danger">{{ $error }}</p>   
 @endisset
 <label class="field-label" for="password">{{ __("User password") }}</label>
 <div class="control field-body">
  <input name="password" type="password">
 </div>
</div>
 <input type="hidden" name="returnto" value="{{ url()->previous('/') }}" />
 <div class="field is-grouped">
  <div class="control is-small">
    <button class="button is-link" name="submit">{{ __('submit') }}</button>
  </div>
  <div class="control is-small">
    <button class="button is-link is-light" name="cancel">{{ __('cancel') }}</button>
  </div>
 </div>
</form>
@endsection