@extends('visual::basic.navigation')

@section('content')
<table class="table is-bordered is-striped is-hoverable">
 <caption>Show dialog input</caption>
 <thead><tr><th>Key</th><th>Value</th></tr></thead>
 <tbody>
  <tr><td>Teststring</td><td>{{ $teststring }}</td></tr>
  <tr><td>Testpasswort</td><td>{{ $testpassword }}</td></tr>
  <tr><td>Testdate</td><td>{{ $testdate }}</td></tr>
  <tr><td>Testdatetime</td><td>{{ $testdatetime }}</td></tr>
  <tr><td>Testtime</td><td>{{ $testtime }}</td></tr>
  <tr><td>Testcolor</td><td>{{ $testcolor }}</td></tr>
  <tr><td>Testnumber</td><td>{{ $testnumber }}</td></tr>
  <tr><td>Testselect</td><td>{{ $testselect }}</td></tr>
  <tr><td>Testradio</td><td>{{ $testradio }}</td></tr>
  <tr><td>Testcheckbox</td><td>{{ $testcheckbox }}</td></tr>
  <tr><td>Testtext</td><td>{{ $testtext }}</td></tr>
  <tr><td>Testlist</td><td>
  <ul>
  @foreach($testlist as $value)
  <li>{{ $value }}</li>
  @endforeach
  </ul></td></tr>
  <tr><td>Testlookuplist</td><td>
  <ul>
  @foreach($testlookuplist as $value)
  <li>{{ $value }}</li>
  @endforeach	
  </ul></td></tr>
  
 </tbody>
</table>
@endsection