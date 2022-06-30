@extends('visual::basic.list')

@section('title','Tags auflisten')

@section('caption')
Tags auflisten
@endsection

@section('headerrow')
<th><a href="{{ $prefix }}/Tags/list/{{ $delta }}/id">ID</a></th>
<th><a href="{{ $prefix }}/Tags/list/{{ $delta }}/name">Name</a></th>
<th><a href="{{ $prefix }}/Tags/list/{{ $delta }}/parent">Parent</a></th>
<th><a href="{{ $prefix }}/Tags/list/{{ $delta }}/full_path">Vollständiger Pfad</a></th>
<th>&nbsp;</th>
<th>&nbsp;</th>
@endsection

@section('datarow')
 <td>{{$item->id}}</td>
 <td>{{$item->name}}</td>
 <td>{{$class->parent}}</td>
 <td>{{$class->full_path}}</td>
 <td><a href="{{ $prefix }}/Tags/edit/{{$item->id}}">bearbeiten</a></td>
 <td><a href="{{ $prefix }}/Tags/delete/{{$item->id}}">löschen</a></td>
@endsection
