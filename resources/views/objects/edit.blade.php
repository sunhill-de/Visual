@extends('visual::basic.navigation')

@section('title','Objekt bearbeiten')

@section('caption')
Objekt mit der ID '{{ $object->id }}' bearbeiten
@endsection

@section('content')
@parent
<form method="post" action="{{ $prefix }}/objects/execedit/{{ $object->id }}">
 @foreach ($fields as $field)
  <x-visual-input id="{{ $object->getID() }}" name="{{ $field->name }}" action="edit" />
 @endforeach
 <input type="submit" value="abschicken" />
</form>
@endsection
  
