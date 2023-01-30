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
  <li><a href="{{ $currentEndpointPath }}/{{ $ancestor }}">{{ $ancestor }}</a></li>
  @endforeach  
 </ul>
</div>
@endsection

@section('tablefooter')
<button>   
<a href="{{ $currentFeaturePath }}/Add/{{ $key }}">{{ __('add') }}</a>
</button>
@endsection



  
