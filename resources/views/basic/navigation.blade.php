@extends('visual::basic.hamburger')

@push('css')
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endpush

@prepend('js')
  <script src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>
  <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
  <script src="{{ asset('js/sunhill.js') }}"></script>
  <script src="{{ asset('js/jstree.min.js') }}"></script>
  <script src="{{ asset('js/jquery.cycle.all.js') }}"></script>
@endpush

@section('body')

@parent
<div class="page">
 <!-- Main navigation -->
 @isset($nav_1)
 <nav role="navigation" class="main-navigation">
  <a href="{{ asset('/') }}" ><div id="Home" class="navigation-tile">
   Home
  </div></a>
  @foreach ($nav_1 as $entry)
  <a href="{{ asset( $entry->link ) }}" id="{{ $entry->name }}"><div class="navigation-tile">
   {{ $entry->display_name }}
  </div></a>
  @endforeach
 </nav>
 @endif
 
 <div class="optional-part">
  <!-- Subnavigation -->
  @isset($nav_2)
  <nav role="navigation" class="sub-navigation">
   @foreach ($nav_2 as $entry)
   <a href="{{ asset( $entry->link ) }}" id="{{ $entry->name }}">
    <div class="navigation-tile">
    {{ $entry->display_name }}
    </div>
   </a> 
   @endforeach
  </nav>
  @endif
  <!--  Dropdown menu -->
  @if (isset($nav_3) && !empty($nav_3))
  <nav class="navbar" role="navigation" aria-label="dropdown navigation">
   @foreach ($nav_3 as $entry)
   <div class="navbar-item has-dropdown is-hoverable">
    <a class="navbar-link" href="{{ asset( $entry->link) }}">{{ $entry->display_name }}</a>
    <div class="navbar-dropdown">
    @foreach ($entry->subentries as $subentry)
     <a class="navbar-item" href="{{ asset( $subentry->link ) }}">{{ $subentry->display_name }}</a>
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
    <li @if ($loop->last)class="is-active"@endif>
     <a href="{{ asset( $crumb->link ) }}">{{$crumb->name}}</a>
    </li>
   @endforeach
  </ul>
 </nav>
 @endif
 <!-- content -->
  <div class="mycontent">
  @yield('caption')
  @yield('content')
  </div>
 </div> 
</div>
@endsection
