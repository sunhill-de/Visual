<!--  Template for table views  -->
@extends('visual::basic.navigation')

@section('content')
<form action="{{ $form_action }}" method="post">
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
  