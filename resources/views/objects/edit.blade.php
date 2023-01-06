@extends('visual::basic.navigation')

@section('title',{{ __('edit object') }} )

@section('caption')
{{ __("Edit object of ':classname' with ID ':id'",['classname'=>$class->name,'id'=>$object->id]) }}
@endsection

@section('content')
@parent
<form method="post" action="{{ $prefix }}/Objects/execedit/{{ $object->id }}">
 <div class="dialogelements">
 @csrf
 @foreach ($fields as $field)
  <x-visual-input id="{{ $object->getID() }}" name="{{ $field->name }}" action="edit" />
 @endforeach
 <x-visual-input id="{{ $object->getID() }}" name="tags" action="edit" />

 <div class="field is-grouped">
  <div class="control">
    <button class="button is-link">Submit</button>
  </div>
  <div class="control">
    <button class="button is-link is-light">Cancel</button>
  </div>
 </div>
 
</div>
</form>
@endsection
  
