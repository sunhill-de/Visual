@extends('visual::basic.navigation')

@section('title',__('List tags'))

@section('caption')
{{ __('List tags') }}
@endsection

@section('content')
@parent
<div class="list">
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
<a href="{{ $prefix }}/Tags/add">{{ __('add') }}</a>
</div>

@endsection
