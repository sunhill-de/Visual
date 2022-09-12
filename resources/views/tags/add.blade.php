@extends('visual::basic.navigation')

@section('title',__('Add tag'))

@section('caption')
{{ __('Add Tag') }}
@endsection

@section('content')
@parent
<form method="post" id="add" name="add" action="{{ $prefix }}/Tags/execadd">
 <div class="dialogelements">
 @csrf
 <label for="tagname">{{ __('Tag name') }}</label>
 <input name="name" type="text" />
 <label for="parent">{{ __('Tag parent') }}</label>
 <input name="input_parent" type="text" />
 <input name="value_parent" type="hidden" value="{{ $parent_id }}" />
 <inputgroup>
  <caption>Optionen</caption>
  <input type="checkbox" name="leafable" checked />{{ __('leafable') }}
 </inputgroup>
 <input type="submit" value="{{ __("send") }}" />
</div>
</form>
@endsection
  
