@extends('visual::basic.navigation')

@section('title')
Datenbank Hauptseite
@endsection

@section('content')
@parent
<div class="tile is-ancestor">
 <div class="tile is-parent">
  <article class="tile is-child box">
   <p class="title">Klassen</p>
   <div class="content">
   <div class="block">
    <div class="infoblock"><div class="has-text-weight-bold">Anzahl Klassen:</div><x-visual-data name="database.classes.count" /></div>
    <div class="infoblock"><div class="has-text-weight-bold">Anzahl Root-Klassen:</div><x-visual-data name="database.classes.root_count" /></div>
	</div>
   <div class="block">
	<a class="button" href="/Computer/Database/Classes/list">auflisten</a>
   </div></div>
  </article>
 </div>
 <div class="tile is-parent">
  <article class="tile is-child box">
   <p class="title">Objekte</p>
   <div class="content">
    <div class="block">
    <div class="infoblock"><div class="has-text-weight-bold">Anzahl Objekte:</div><x-visual-data name="database.objects.count" /></div>
    </div>
    <div class="block">
	<a class="button" href="/Computer/Database/Objects/list/object">auflisten</a>
	</div>
   </div>
  </article>
 </div>
 <div class="tile is-parent">
  <article class="tile is-child box">
   <p class="title">Tags</p>
   <div class="content">
    <div class="block">
    <div class="infoblock"><div class="has-text-weight-bold">Anzahl Tags:</div><x-visual-data name="database.tags.count" /></div>
	</div>
	<div class="block">
	<a class="button" href="/Computer/Database/Tags/list">auflisten</a>
	<a class="button" href="/Computer/Database/Tags/add">hinzuf&uuml;gen</a>
    </div>   
   </div>
  </article>
 </div>
</div>

@endsection
