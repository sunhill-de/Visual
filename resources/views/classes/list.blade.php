@extends('visual::basic.navigation')

@section('title','Klassen auflisten')

@section('caption')
Klassen auflisten
@endsection

@section('content')
@parent
<div class="list">
 <table>
  <caption>@yield('caption')</caption>
  <tr>
   <th><a href="{{ $prefix }}/Classes/list/{{ $delta }}/Name">Name</a></th>
   <th><a href="{{ $prefix }}/Classes/list/{{ $delta }}/Parent">Parent</a></th>
   <th>Beschreibung</th>
   <th>&nbsp;</th>
   <th>&nbsp;</th>
   <th>&nbsp;</th>
  </tr>
  @forelse ($items as $item)
  <tr>
   <td>{{ $item->name }}</td>
   <td>{{ $item->parent }}</td>
   <td>{{ $item->description }}</td>
   <td><a href="{{ $prefix }}/Classes/show/{{$item->name}}">anzeigen</a></td>
   <td><a href="{{ $prefix }}/Objects/list/{{$item->name}}">Objekte auflisten</a></td>
   <td><a href="{{ $prefix }}/Objects/add/{{$item->name}}">Objekt hinzuf&uuml;gen</a></td> 
  </tr>
  @empty
  <tr>
   <td colspan="100">Keine Eintr&auml;ge</td>
  @endforelse
 </table>
</div>
@endsection  
