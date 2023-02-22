<!--  Template for table views  -->
@extends('visual::basic.navigation')

@section('content')
 @hasSection('tableheader')
  @yield('tableheader')
 @endif
 <table class="table is-bordered is-striped is-hoverable">
  <caption>@yield('caption')</caption>
  <thead>
   <tr>
    @foreach ($headers as $entry)
    <th>
     @if (is_null($entry->link))
      {{ $entry->name }}
     @else
      <a href="{{ asset( $entry->link ) }}">{{ $entry->name }}</a>
     @endif
    </th>
    @endforeach
  </tr>
 </thead>
 <tbody>
   @forelse ($items as $row)
  <tr>
   @foreach ($row as $col)
   <td>
    @if (is_null($col->link))
     {{ $col->name }}   
    @else
     <a href="{{ asset( $col->link ) }}">{{ $col->name }}</a>
    @endif
   </td> 
   @endforeach 
  </tr>
  @empty
  <tr>
   <td colspan="100">{{ __("No entries") }}</td>
  </tr>
  @endforelse 
 </tbody>
</table>

@isset($pages)
<nav class="pagination" role="navigation" aria-label="pagination">
<ul class="pagination-list">
@foreach ($pages as $page) 
<li>
<a href="{{ asset( $page->link ) }}" class="pagination-link">{{ $page->text }}</a>
</li>
@endforeach
</ul>
</nav>
@endisset

@hasSection('tablefooter')
  @yield('tablefooter')
@endif

@endsection
  