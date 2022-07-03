@extends('visual::basic.navigation')

@section('title','Objekt hinzufügen')

@section('caption')
Objekt von '{{ $key }}' hinzufügen
@endsection

@section('content')
@parent
<form method="post" action="{{ $prefix }}/objects/execadd">
 Klassenname: {{ $class::$object_infos['name'] }}<br />
 Tabellenname: {{ $class::$object_infos['table'] }}<br />
 <input type="submit" value="abschicken" />
</form>
@endsection
  
