@extends('visual::basic.navigation')

@push('css')
  <style>
  .feedback { font-size: 1.4em; }
  .selectable .ui-selecting { background: #FECA40; }
  .selectable .ui-selected { background: #F39814; color: white; }
  .selectable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
  .selectable li { margin: 3px; padding: 0.4em; font-size: 1.4em; height: 18px; }
  </style>
@endpush

@section('title',__('add object'))

@section('caption')
 {{ __("Add object of ':classname'",['classname'=>$class->name]) }}
@endsection

@section('content')
@parent
<form method="post" id="add" name="add" action="{{ $prefix }}/Objects/execadd">
 @csrf
 <input type="hidden" name="_class" value="{{ $class->name }}" />
 @foreach ($class->fields as $field)
  <x-visual-input id="{{ $class->name }}" name="{{ $field->name }}" action="add" />
 @endforeach
 <x-visual-input id="{{ $class->name }}" name="tags" action="add" />
 
 <div class="field is-grouped">
  <div class="control">
    <button class="button is-link">Submit</button>
  </div>
  <div class="control">
    <button class="button is-link is-light">Cancel</button>
  </div>
 </div>

</form>
@endsection
  
