<!--  Template for table views  -->
@extends('visual::basic.navigation')

@section('content')
<form action="{{ route($dialog_route, $dialog_route_parameters) }}" method="{{ $dialog_method }}">
 @csrf
 @if (isset($ids))
  @foreach ($ids as $id)
  <input type="hidden" name="selected[]" id="{{ $id }}">
  @endforeach
 @endif
 @foreach($elements as $element)
 <div class="field is-horizontal">
 <label class="field-label" for="{{ $element->name }}">{{__($element->label)}}</label>
 <div class="control field-body">
  {!! $element->dialog !!}
  @if( property_exists($element,'error' ) )
    <p class="help is-danger">{{ $element->error }}</p>  
  @endif
 </div>
</div>
 @endforeach
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
  