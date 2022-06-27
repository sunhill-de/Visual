@extends('visual::basic.navigation')

@section('content')
@parent
<div class="list">
 @yield('before_table','')
 <table>
  <caption>@yield('caption')</caption>
  <tr>@yield('headerrow')</tr>
  @forelse ($items as $item)
  <tr>
   @yield('datarow')
  </tr>
  @empty
  <tr>
   <td colspan="100%">Keine Eintr&auml;ge</td>
  @endforelse
 </table>
 @yield('after_table','')
</div>
@endsection  
