@extends('visual::basic.html')

@section('body')
<nav role='hamburger'>
  <div id="hamburgerToggle">
    <input type="checkbox" />
    <span></span>
    <span></span>
    <span></span>
    <ul id="hamburger">
      <a href="/"><li>Home</li></a>
      @guest
      <a href="/user/login"><li>Login</li></a>
      @endguest
      @auth
      <a href="/user/logout"><li>Logout</li></a>
      @endauth
    </ul>
  </div>
</nav>
@endsection
