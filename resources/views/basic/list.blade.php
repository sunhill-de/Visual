<!--  Template for table views  -->
@extends('visual::basic.navigation')

@section('content')
 @if(!empty($filters))
 <label for="filter">{{ __('Filter') }}</label>
 <select id="filter" name="filter" onchange="return filterchanged()">
  @foreach ($filters as $filter_name => $filter_description)
  <option value="{{$filter_name}}" @selected($filter==$filter_name)>{{ __($filter_description) }}</option>
  @endforeach
 </select>
 @endif
 @hasSection('tableheader')
  @yield('tableheader')
 @endif
 <table class="table is-bordered is-striped is-hoverable">
  <caption>@yield('caption')</caption>
   <thead>
   <tr>
    @foreach ($headers as $entry)
    @if(isset($entry->class))
    <th  class="{{ $entry->class }}">{!! $entry->title !!}</th>        
    @else
    <th>{!! $entry->title !!}</th>    
    @endif
    @endforeach
  </tr>
 </thead>  
 <tbody>
   @forelse ($items as $row)
  <tr>
   @foreach ($row as $col)
   <td>{!! $col !!}</td> 
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
  