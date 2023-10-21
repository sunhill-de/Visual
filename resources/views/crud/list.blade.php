<!--  Template for table views  -->
@extends('visual::basic.navigation')

@section('content')
 @includeWhen($has_filter, 'visual::crud.filter_list')
 @if(!empty($groupactions))
 <form id="groupform" name="groupform" method="post">
 @csrf
 @endif
 <table class="table is-bordered is-striped is-hoverable">
  <caption>{{ $caption }}</caption>
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
 @if(!empty($groupactions))
 {{ __("marked:"); }}
 @foreach($groupactions as $action)
 <input class="button" id="{{ $action->action }}" type="submit" value="{{ $action->title }}" onclick="groupButtonClicked('{{ $action->route }}')">
 @endforeach
 <script>
  function groupButtonClicked( action )	
  {
  	$('#groupform').attr('action', action)
  }	
 </script>
 </form>
 @endif

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

@if(!empty($links))
@foreach($links as $link)
<a href="{{ $link->target }}" class="button @if(isset($link->class) {{ $link->class }}@endif">{{ $link->text }}</a>
@endforeach
@endif

@hasSection('tablefooter')
  @yield('tablefooter')
@endif

@endsection
  