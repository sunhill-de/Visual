@extends('visual::basic.navigation')

@section('title','Objekte auflisten')

@section('content')
@parent
       <table>
        <caption>Objekte von '{{$class}}' auflisten</caption>
        <tr>
         <th>ID</th>
         <th>Klasse</th>
         @foreach ($columns as $col)
         <th>{{ $col }}</th>
         @endforeach
         <th>&nbsp;</th>
         <th>&nbsp;</th>
        </tr>
        @forelse($objects as $object)
        <tr>
         <td>{{ $object->getID() }}</td>
         <td>{{ $object::objectInfos['name'] }}</td>
         @foreach ($columns as $col)
         <td>{{ $object->$col }}</td>
         @endforeach
         <td><a href="{{ $prefix }}/Objects/edit">bearbeiten</a></td>
         <td><a href="{{ $prefix }}/Objects/delete">l&ouml;schen</a></td>
        </tr>
		@empty
		 <tr>
		  <td colspan="5">No entries</td>
		 </tr>
        @endforelse
       </table>
       <a href="/">&Uuml;bersicht</a>
@endsection
