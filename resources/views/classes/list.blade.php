@extends('visual::basic.navigation')

@section('title','Klassen auflisten')

@section('body')
@parent
       <div class="list">
       <table>
        <caption>Klassen auflisten</caption>
        <tr>
         <th><a href="{{ $prefix }}/Classes/list/{{ $delta }}/Name">Name</a></th>
         <th><a href="{{ $prefix }}/Classes/list/{{ $delta }}/Parent">Parent</a></th>
         <th>Beschreibung</th>
         <th>&nbsp;</th>
         <th>&nbsp;</th>
         <th>&nbsp;</th>
        </tr>
        @forelse($classes as $class)
        <tr>
         <td>{{$class->name}}</td>
         <td>{{$class->parent}}</td>
         <td>{{$class->description}}</td>
         <td><a href="{{ $prefix }}/Classes/show/{{$class->name}}">anzeigen</a></td>
         <td><a href="{{ $prefix }}/Objects/list/{{$class->name}}">Objekte auflisten</a></td>
         <td><a href="{{ $prefix }}/Objects/add/{{$class->name}}">Objekt hinzuf&uuml;gen</a></td>
        </tr>
        @empty
        <tr>
         <td colspan="5">Keine Eintr&auml;ge</td>
        </tr> 
        @endforelse
       </table></div>
       <a href="/">&Uuml;bersicht</a>
@endsection
