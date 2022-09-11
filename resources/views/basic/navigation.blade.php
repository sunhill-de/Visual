@extends('visual::basic.hamburger')

@push('css')
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endpush

@push('js')
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script src="/js/sunhill.js"></script>
@endpush

@section('body')

@parent

@if(isset($nav_0) && (null !== $nav_0))
<style>
@foreach ($nav_0 as $entry)
 #mainnav #{{$entry->id}} { background-image: url(/img/{{$entry->icon}}); } 
@endforeach
</style>
@endif
<ul class="nav1">
<a href="/" id="Home">Home</a>
@each('visual::partials.navigation',json_decode(json_encode($navigation),true),'entry')
</ul>
<div class="content">
@if(null !== $breadcrumbs)
<div id="breadcrumb">
 <ul>
@foreach ($breadcrumbs as $crumb)
  <li><a href="{{$crumb->link}}">{{$crumb->name}}</a></li>
@endforeach
 </ul>
</div>
@endif
@yield('content')
</div>
@endsection
