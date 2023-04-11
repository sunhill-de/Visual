@extends('visual::basic.navigation')
@section('content')
  <div>
  <div class="box">
  <article class="message is-danger is-large is-fullwidth">
   <div class="message-header is-fullwidth">{{ __('User error') }}</div>
   <div class="message-body">
   {{ $e->getMessage() }}
   </div>
  </article>
  </div>
 </div> 
@endsection
