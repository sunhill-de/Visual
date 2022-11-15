@extends('visual::basic.navigation')

@push('css')
  <link rel="stylesheet" href="/css/style.min.css" />
@endpush

@section('title')
Datenbank Hauptseite
@endsection

@section('content')
@parent
<div class="treeview"></div>
<div id="info" class="footer">
 <div class="columns">
 <div class="column"><div class="label">{{ __("Item") }}:</div><div id="itemname"></div></div>
 <div class="column"><div class="label">{{ __("Type") }}:</div><div id="itemtype"></div></div>
 </div>
 <div class="columns"> 
 <div class="column"><div class="label">{{ __("Semantic type") }}:</div><div id="itemsemantic"></div></div>
 <div class="column"><div class="label">{{ __("Unit") }}:</div><div id="itemunit"></div></div>
 </div>
 <div class="columns"> 
 <div class="column"><div class="label">{{ __("Value") }}:</div><div id="itemvalue"></div></div>
 <div class="column"><div class="label">{{ __("Update") }}:</div><div id="itemupdate"></div></div>
 </div>
 <button id="setvalue">Wert setzen</button>
</div>
@endsection
