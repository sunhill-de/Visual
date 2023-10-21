<!--  Template for table views  -->
@extends('visual::basic.navigation')

@section('caption')
{{ __('Show :entity',['entity'=>$entity]) }}
@endsection

@section('content')
@foreach($tables as $table)
 <table class="table is-bordered is-striped is-hoverable">
  <caption>{{ $table['caption'] }}</caption>
  <thead>
   <tr>
    @foreach ($table['header'] as $entry)
    <th>{{ $entry }}</th>
    @endforeach
   </tr>
  </thead>
  <tbody>
  @foreach ($table['data'] as $dataset)
  <tr>
   @foreach ($dataset as $entry)
   <td>{!! display_variable($entry) !!}</td>
   @endforeach
  </tr>
  @endforeach
  </tbody>
 </table>
@endforeach
@endsection
  