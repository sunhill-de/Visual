@extends('visual::basic.navigation')

@section('title','Objekt bearbeiten')

@section('caption')
Objekt mit der ID '{{ $object->id }}' bearbeiten
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
 <input type="submit" value="abschicken" />
 </div>
</form>
@endsection
  
