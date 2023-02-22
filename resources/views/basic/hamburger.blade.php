@extends('visual::basic.html')

@section('body')
<!-- 
<nav role='hamburger'>
  <div id="hamburgerToggle">
    <input type="checkbox" />
    <span></span>
    <span></span>
    <span></span>
    <ul id="hamburger">
      <a href="{{ config('app.url') }}"><li>Home</li></a>
      @guest
      <a href="{{ config('app.url') }}/user/login"><li>Login</li></a>
      @endguest
      @auth
      <a href="{{ config('app.url') }}/user/logout"><li>Logout</li></a>
      @endauth
    </ul>
  </div>
</nav>
 -->
@endsection
