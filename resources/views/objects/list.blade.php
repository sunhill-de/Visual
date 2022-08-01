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
     @foreach ($headers as $entry)
     <th>
      @if (is_null($entry->link))
       {{ $entry->name }}
      @else
       <a href="{{ $entry->link }}">{{ $entry->name }}</a>
      @endif
     </th>
     @endforeach
  @forelse ($items as $row)
  <tr>
   @foreach ($row as $col)
   <td>
    @if (is_null($col->link))
     {{ $col->name }}   
    @else
     <a href="{{ $col->link }}">{{ $col->name }}</a>
    @endif
   </td> 
   @endforeach 
  </tr>
  @empty
  <tr>
   <td colspan="100">{{ __("No entries") }}</td>
  </tr>
  @endforelse
   
</table>
<a href="{{ $prefix }}/Objects/add/{{ $key }}">{{ __('add') }}</a>
</div>

@endsection
  
