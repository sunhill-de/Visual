@extends('visual::basic.navigation')

@section('title','Objekte auflisten')

@section('caption')
Objekte von '{{ $key }}' auflisten
@endsection

@section('content')
@parent
<div class="list">
 <div id="hirarchy">
  <ul>
  <li>Objekthirarchie</li>  
  @foreach ($inheritance as $ancestor)
  <li><a href="{{ $prefix }}/Objects/list/{{ $ancestor }}">{{ $ancestor }}</a></li>
  @endforeach  
  </ul>
 </div>
 <table>
  <caption>@yield('caption')</caption>
  <tr>
     <th><a href="{{ $prefix }}/Objects/list/{{ $key }}/{{ $delta }}/id">ID</a></th>
     <th>Klasse</th>
     @foreach ($columns as $index => $col)
      @if (is_int($index)
     <th><a href="{{ $prefix }}/Objects/list/{{ $key }}/{{ $delta }}/{{ $col }}">{{ __($col) }}</a></th>
      @else
     <th><a href="{{ $prefix }}/Objects/list/{{ $key }}/{{ $delta }}/{{ $index }}">{{ __($index) }}></th>
      @endif
     @endforeach
     <th>&nbsp;</th>
     <th>&nbsp;</th>
  </tr>
  @forelse ($items as $item)
  <tr>
 <td><a href="{{ $prefix }}/Objects/show/{{ $item->getID() }}">{{ $item->getID() }}</a></td>
 <td><a href="{{ $prefix }}/Objects/list/{{ $item::$object_infos['name'] }}">{{ $item::$object_infos['name'] }}</a></td>
 @foreach ($columns as $index => $col)
  @if (is_int($index))
 <td>{{ $item->$col }}</td>
  @else
    @php
     list($field,$subfield) = explode("=>",$col);
    @endphp
  <td>{{ $item->$field->$subfield }}</td>
  @endif
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
  
