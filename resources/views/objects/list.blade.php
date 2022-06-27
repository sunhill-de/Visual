@extends('visual::basic.list')

@section('title','Objekte auflisten')

@section('caption')
Objectke von '{{class}}' auflisten
@endsection

@section('headerrow')
 <th>ID</th>
 <th>Klasse</th>
 @foreach ($columns as $col)
 <th>{{ $col }}</th>
 @endforeach
 <th>&nbsp;</th>
 <th>&nbsp;</th>
@endsection

@section('datarow')
 <td>{{ $item->getID() }}</td>
 <td>{{ $item::objectInfos['name'] }}</td>
 @foreach ($columns as $col)
 <td>{{ $item->$col }}</td>
 @endforearch
 <td><a href="{{ $prefix }}/Objects/edit">bearbeiten</a></td>
 <td><a href="{{ $prefix }}/Objects/delete">l&ouml;schen</a></td>
@endsection

