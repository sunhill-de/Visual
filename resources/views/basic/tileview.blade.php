@extends('visual::basic.navigation')

@section('content')
<div class="tile is-ancestor">
 @foreach ($tiles as $tile)
 <div class="tile is-parent">
	{!! $tile->content !!}
 </div>
 @endforeach
</div>
@endsection
