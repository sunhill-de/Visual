@extends('visual::basic.navigation')

@section('title','List classes')

@section('caption')
{{ __('List classes') }}
@endsection

@section('content')
@parent
<div class="list">
 <table>
  <caption>@yield('caption')</caption>
  <tr>
   <th>{{ __('Class name') }}</th>
   <th>{{ __('Name') }}</th>
   <th>{{ __('Description') }}</th>
   <th>{{ __('Parent') }}</th>
   <th>&nbsp;</th>
   <th>&nbsp;</th>
   <th>&nbsp;</th>
  </tr>
  @forelse ($items as $row)
  <tr>
   <td>{{ $row->classname }}</td>
   <td>{{ $row->name }}</td>
   <td>{{ $row->description }}</td>
   <td>{{ $row->parent }}</td>
   <td><a href="{{ $prefix }}/Objects/list/{{ $row->name }}">{{ __('list') }}</a></td>
   <td><a href="{{ $prefix }}/Objects/add/{{ $row->name }}">{{ __('add') }}</a></td>
   <td><a href="{{ $prefix }}/Classes/show/{{ $row->name }}">{{ __('show') }}</a></td>
  </tr>
  @empty
  <tr>
   <td colspan="100">{{ __("No entries") }}</td>
  </tr>
  @endforelse
   
</table>
</div>

@endsection
  