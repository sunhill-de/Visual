@extends('visual::basic.navigation')

@section('content')
<div class="tile is-ancestor">
 @foreach ($tiles as $tile)
 <div class="tile is-parent">
	{!! $tile->content !!}
 </div>
 @if ($loop->iteration % 3 == 0)
 </div>
 <div class="tile is-ancestor">
 @endif
 @endforeach
</div>
@endsection
