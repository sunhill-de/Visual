@extends('visual::basic.navigation')

@section('title','Objekt hinzufügen')

@section('caption')
Objekt von '{{ $class->name }}' hinzufügen
@endsection

@section('content')
@parent
<form method="post" action="{{ $prefix }}/objects/execadd">
 Klassenname: {{ $class->name }}<br />
 Tabellenname: {{ $class->tablename }}<br />
 @foreach ($class->fields as $field)
  <x-visual-input id="{{ $class->name }}" name="{{ $field->name }}" action="add" />
 @endforeach
 <input type="submit" value="abschicken" />
</form>
@endsection
  
