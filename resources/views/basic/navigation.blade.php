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

<!-- Navigation -->
@isset($nav_1)
<nav role="navigation" id="nav_level1">
<ul>
 <a href="/" id="Home">Home</a>
@foreach ($nav_1 as $entry)
 <a href="{{ $entry->link }}" id="{{ $entry->name }}">{{ $entry->display_name }}</a>
@endforeach
</ul>
</nav>
@endif
@isset($nav_2)
<nav role="navigation" id="nav_level2">
<ul>
@foreach ($nav_2 as $entry)
 <a href="{{ $entry->link }}" id="{{ $entry->name }}">{{ $entry->display_name }}</a>
@endforeach
</ul>
</nav>
@endif

<main>
<!--  Dropdown menu -->
@if (isset($nav_3) && !empty($nav_3))
<nav class="navbar" role="navigation" aria-label="dropdown navigation">
@foreach ($nav_3 as $entry)
<div class="navbar-item has-dropdown is-hoverable">
<a class="navbar-link" href="{{ $entry->link }}">{{ $entry->display_name }}</a>
<div class="navbar-dropdown">
@foreach ($entry->subentries as $subentry)
<a class="navbar-item" href="{{ $subentry->link }}">{{ $subentry->display_name }}</a>
@endforeach
</div>
</div>
@endforeach
</nav>
@endif

<!--  Breadcrumbs -->
@if(null !== $breadcrumbs)
<nav class="breadcrumb" aria-label="breadcrumbs" id="breadcrumbs">
 <ul>
@foreach ($breadcrumbs as $crumb)
  <li><a href="{{$crumb->link}}">{{$crumb->name}}</a></li>
@endforeach
 </ul>
</nav>
@endif
@yield('content')
</main>
@endsection
