@extends('visual::basic.navigation')

@section('title','Objekt hinzufügen')

@section('caption')
Objekt von '{{ $class->name }}' hinzufügen
@endsection

@section('content')
@parent
<form method="post" action="{{ $prefix }}/Objects/execadd">
 @csrf
 Klassenname: {{ $class->name }}<br />
 Tabellenname: {{ $class->tablename }}<br />
 <input type="hidden" name="_class" value="{{ $class->name }}" />
 @foreach ($class->fields as $field)
  <x-visual-input id="{{ $class->name }}" name="{{ $field->name }}" action="add" />
 @endforeach
 <input type="submit" value="abschicken" />
</form>
@endsection
  
