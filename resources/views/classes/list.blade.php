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
<div class="flex items-center space-x-1">
@foreach ($pages as $page) 
<a href="{{ $page->link }}" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-blue-400 hover:text-white">{{ $page->text }}</a>
@endforeach
</div>
</div>

@endsection
  