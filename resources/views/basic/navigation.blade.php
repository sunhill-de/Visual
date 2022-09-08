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
<div class="mainnav" id="mainnav">
<ul>
 <li><a id="home" href="/">Home</a></li>
@isset($navigation)
 @foreach ($navigation as $level1_entry)
  @if ($level1_entry->visible)
  <li>
    @if ($level1_entry->active)
    <div class="active_navigation">
    @endif
    <a id="{{ $level1_entry->id }}" href="{{ $level1_entry->link }}">{{ $level1_entry->display_name }}</a>
    @if ($level1_entry->subentries)
     <!-- ******* Level 2 ******* -->
     <ul>
     @foreach ($level1_entry->subentries as $level2_entry)
     <li>
      @if ($level2_entry->active)
      <div class="active_navigation">
      @endif
      <a id="{{ $level2_entry->id }}" href="{{ $level2_entry->link }}">{{ $level2_entry->display_name }}</a>
      @if ($level2_entry->subentries)
      <ul>
      @foreach ($level2_entry->subentries as $level3_entry)
      @if ($level1_entry->subentries)
      <!-- ******* Level 3 ******* -->
     <ul>
     @foreach ($level1_entry->subentries as $level2_entry)
     <li>
      @if ($level2_entry->active)
      <div class="active_navigation">
      @endif
      <a id="{{ $level2_entry->id }}" href="{{ $level2_entry->link }}">{{ $level2_entry->display_name }}</a>
      @if ($level1_entry->subentries)
      <ul>
      @foreach ($level1_entry->subentries as $level2_entry)
     
      @endforeach
      </ul>
      @endif
      @if ($level2_entry->active)
      </div>
      @endif
    </li>      
     @endforeach
     </ul>
     <!-- ******** Level 3 ******** -->
    @endif
     
      @endforeach
      </ul>
      @endif
      @if ($level2_entry->active)
      </div>
      @endif
    </li>      
     @endforeach
     </ul>
     <!-- ******** Level 2 ******** -->
    @endif
    @if ($level1_entry->active)
    </div>
    @endif
  </li>   
  @endif
 @endforeach
@endisset
</ul>

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
