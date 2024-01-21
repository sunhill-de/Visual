@extends('visual::basic.html')

@section('body')
<nav role='navigation'>
  <div id="menuToggle">
    <!--
    A fake / hidden checkbox is used as click reciever,
    so you can use the :checked selector on it.
    -->
    <input type="checkbox" />
    
    <!--
    Some spans to act as a hamburger.
    
    They are acting like a real hamburger,
    not that McDonalds stuff.
    -->
    <span></span>
    <span></span>
    <span></span>
    
    <!--
    Too bad the menu has to be inside of the button
    but hey, it's pure CSS magic.
    -->
    <ul id="menu">
      <a href="#"></a>
      @if(\Sunhill\Visual\Facades\Users::isLoggedIn())
      {{ \Sunhill\Visual\Facades\Users::getCurrentUser() }}
      <a href="{{ route('user.logoff') }}"><li>Logoff</li></a>
      @else
      <a href="{{ route('user.login') }}"><li>Login</li></a>      
      @endif
    </ul>
  </div>
</nav>
@endsection
