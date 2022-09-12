@extends('visual::basic.navigation')

@section('title',{{ $title }})

@section('caption')
{{ $title }}
@endsection

@section('content')
@parent
<form method="post" action="{{ $method }}">
 <div class="dialogelements">
 @csrf
 <label for="tagname">{{ __('Tag name') }}</label>
 <input name="name" type="text" value="{{ $name }}"/>
 <label for="parent">{{ __('Tag parent') }}</label>
 <input name="input_parent" type="text" value="{{ $parent_name }}" />
 <input name="value_parent" type="hidden" value="{{ $parent_id }}" />
 <inputgroup>
  <caption>Optionen</caption>
  <input type="checkbox" name="leafable" checked />{{ __('leafable') }}
 </inputgroup>
 <input type="submit" value="{{ __('send') }}" />
</div>
</form>
@endsection
  
