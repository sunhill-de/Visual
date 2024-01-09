<article class="tile is-child box" @isset($linktarget) onclick="{{ $linktarget}}"@endisset>
 <p class="title">@yield('tilecaption')</p>
  <div class="content">
   @yield('tilebody')
  </div>
</article>
