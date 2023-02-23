@extends('visual::basic.list')

@section('title','Objekte auflisten')

@section('caption')
Objekte von '{{ $key }}' auflisten
@endsection

@section('tableheader')
<div class="hirarchy">
 <ul>
 <li>Objekthirarchie</li>  
  @foreach ($inheritance as $ancestor)
  <li><a href="{{ route('objects.list',['key'=>$ancestor]) }}">{{ $ancestor }}</a></li>
  @endforeach  
 </ul>
</div>
@endsection

@section('tablefooter')
@if ($namespace::getInfo('instantiable'))
<button>   
<a href="{{ route('objects.add',['class'=> $key]) }}">{{ __('add') }}</a>
</button>
@endif
@endsection



  
