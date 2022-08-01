@extends('visual::basic.hamburger')

@push('css')
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endpush

@push('js')
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
@endpush

@section('body')

@parent
@if(isset($nav_0) && (null !== $nav_0))
<style>
@foreach ($nav_0 as $entry)
 #mainnav #{{$entry->id}} { background-image: url(/img/{{$entry->icon}}); }
 
@endforeach
</style>
<div class="mainnav" id="mainnav">
 <ul>
  <li><a id="home" href="/">Home</a></li>
@foreach ($nav_0 as $entry)
  <li><a id="{{$entry->id}}" href="/{{$entry->id}}/">{{$entry->name}}</a></li>
@endforeach
 </ul>
</div>
@endif

@if(isset($nav_1) && (null !== $nav_1))
<style>
@foreach ($nav_1 as $entry)
 #subnav #{{$entry->id}} { background-image: url(/img/{{$entry->icon}}); } 
@endforeach
</style>
<div class="subnav" id="subnav">
 <ul>
@foreach ($nav_1 as $entry)
  <li><a id="{{$entry->id}}" href="{{$entry->prefix}}/{{$entry->id}}/">{{$entry->name}}</a></li>
@endforeach
 </ul>
</div>
@endif

@if(null !== $breadcrumbs)
<div id="breadcrumb">
 <ul>
@foreach ($breadcrumbs as $crumb)
  <li><a href="{{$crumb->link}}">{{$crumb->name}}</a></li>
@endforeach
 </ul>
</div>
@endif
<div class="content">
@yield('content')
</div>
@endsection
