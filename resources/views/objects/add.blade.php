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
<form method="post" id="add" name="add" action="{{ $currentFeaturePath }}/ExecAdd">
 @csrf
 <input type="hidden" name="_class" value="{{ $class->name }}" />
 @foreach ($class->fields as $field)
  <div style="width:33%;">
  <x-visual-input id="{{ $class->name }}" name="{{ $field->name }}" action="add" />
 </div>
 @endforeach
 <div class="pt-2 pb-2">
   <x-visual-input id="{{ $class->name }}" name="tags" action="add" />
 </div>
 <div class="field is-grouped">
  <div class="control">
    <button class="button is-link">{{ __('submit') }}</button>
  </div>
  <div class="control">
    <button class="button is-link is-light">{{ __('cancel') }}</button>
  </div>
 </div>

</form>
@endsection
  
