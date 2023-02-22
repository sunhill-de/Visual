@extends('visual::basic.navigation')

@section('title')
Personen importieren
@endsection

@section('content')
@parent
<form action="{{ asset('/Computer/Database/Import/ExecImportPersons') }}" method="post">
 @csrf
 <table class="table is-bordered is-striped is-hoverable">
  <caption>Personen importieren</caption>
  <thead>
   <tr>
    <th>&nbsp;</th>
    <th>Vorname</th>
    <th>Nachname</th>
    <th>&nbsp</th>
   </tr> 
  </thead>
  <tbody>
   @forelse ($entries as $row)
   <tr>
    <td><input type="checkbox" name="import{{ $row->id }}" checked></td>
    <td>{{ $row->first_names }}</td>
    <td>{{ $row->last_names }}</td>
    <td><a href="{{ asset("/Computer/Database/Import/CorrectPerson/$row->id")  }}">Korrigieren</a></td>
   </tr>
   @empty
   <tr><td colspan="99">Keine Eintr&auml;ge</td></tr>
   @endforelse
  </tbody>
 </table>
<div class="field is-grouped">
  <div class="control">
    <button class="button is-link">Submit</button>
  </div>
  <div class="control">
    <button class="button is-link is-light">Cancel</button>
  </div>
</div>
</form>  
@endsection