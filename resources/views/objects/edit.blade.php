@extends('visual::basic.navigation')

@section('title','Objekt bearbeiten')

@section('caption')
Objekt mit der ID '{{ $object->id }}' bearbeiten
@endsection

@section('content')
@parent
<form method="post" action="{{ $prefix }}/objects/execadd/{{ $object->id }}">
 Klassenname: {{ $class->name }}<br />
 Tabellenname: {{ $class->tablename }}<br />
 @foreach ($object->fields as $field)
  <x-input class="{{ $class->name }}" name="{{ $field->name }}" action="edit" />
 @endforeach
 <input type="submit" value="abschicken" />
</form>
@endsection
  
