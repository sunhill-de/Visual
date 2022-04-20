@extends('visual::basic.html')

@section('body')

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
<div class="subnav" id="subnav">
 <ul>
@foreach ($nav_1 as $entry)
  <li><a id="{{$entry->id}}" href="/{{$entry->id}}/">{{$entry->name}}</a></li>
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

@endsection
