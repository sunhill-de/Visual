<!--  Template for table views  -->
@extends('visual::basic.navigation')

@section('content')
{{ __('Are you sure that the following records should be deleted?') }}
<form method="post" action="{{ $action }}">
@csrf
<ul>

@foreach ($entries as $entry)
<li><input type="hidden" name="selected[]" value="{{ $entry->id }}">{{ $entry->key }}</li>
@endforeach
</ul>
<input type="submit" class="button is-success" value="{{ __('OK') }}">
</form>
@endsection
  