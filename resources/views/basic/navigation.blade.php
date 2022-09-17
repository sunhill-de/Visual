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
@foreach ($navigation as $level)
<nav role="navigation" id="nav_level{{ $loop->iteration }}">
 <ul>
@foreach ($level as $entry)
 <li>
 <a href="{{ $entry->link }}">{{ $entry->name }}</a>
 </li>
@endforeach 
 </ul>
</nav>
@endforeach

<!--  Breadcrumbs  -->
@if(null !== $breadcrumbs)
<nav class="breadcrumb" aria-label="breadcrumbs">
 <ul>
@foreach ($breadcrumbs as $crumb)
  <li><a href="{{$crumb->link}}">{{$crumb->name}}</a></li>
@endforeach
 </ul>
</nav>
@endif

<main>
@yield('content')
</main>
@endsection
