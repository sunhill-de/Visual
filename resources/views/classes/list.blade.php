@extends('visual::basic.list')

@section('title','Klassen auflisten')

@section('caption')
Klassen auflisten
@endsection

@section('headerrow')
<th><a href="{{ $prefix }}/Classes/list/{{ $delta }}/Name">Name</a></th>
<th><a href="{{ $prefix }}/Classes/list/{{ $delta }}/Parent">Parent</a></th>
<th>Beschreibung</th>
<th>&nbsp;</th>
<th>&nbsp;</th>
<th>&nbsp;</th>
@endsection

@section('datarow')
 <td>{{$class->name}}</td>
 <td>{{$class->parent}}</td>
 <td>{{$class->description}}</td>
 <td><a href="{{ $prefix }}/Classes/show/{{$class->name}}">anzeigen</a></td>
 <td><a href="{{ $prefix }}/Objects/list/{{$class->name}}">Objekte auflisten</a></td>
 <td><a href="{{ $prefix }}/Objects/add/{{$class->name}}">Objekt hinzuf&uuml;gen</a></td>
@endsection
