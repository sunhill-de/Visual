@extends('visual::basic.navigation')

@section('title','Objekte auflisten')

@section('caption')
Objekte von '{{ $key }}' auflisten
@endsection

@section('content')
@parent
<div class="list">
 <table>
  <caption>@yield('caption')</caption>
  <tr>
     <th>ID</th>
     <th>Klasse</th>
     @foreach ($columns as $col)
     <th>{{ $col }}</th>
     @endforeach
     <th>&nbsp;</th>
     <th>&nbsp;</th>
  </tr>
  @forelse ($items as $item)
  <tr>
 <td>{{ $item->getID() }}</td>
 <td>{{ $item::objectInfos['name'] }}</td>
 @foreach ($columns as $col)
 <td>{{ $item->$col }}</td>
 @endforeach
 <td><a href="{{ $prefix }}/Objects/edit">bearbeiten</a></td>
 <td><a href="{{ $prefix }}/Objects/delete">l&ouml;schen</a></td>
  </tr>
  @empty
  <tr>
   <td colspan="100">Keine Eintr&auml;ge</td>
  </tr>
  @endforelse
   
</table>
</div>

@endsection
  
