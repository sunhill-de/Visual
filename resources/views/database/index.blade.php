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
	<a class="button" href="/Computer/Database/Classes/list">auflisten</a>
   </div>
  </article>
 </div>
 <div class="tile is-parent">
  <article class="tile is-child box">
   <p class="title">Objekte</p>
   <div class="content">
	<a class="button" href="/Computer/Database/Objects/list/object">auflisten</a>
   </div>
  </article>
 </div>
 <div class="tile is-parent">
  <article class="tile is-child box">
   <p class="title">Tags</p>
   <div class="content">
	<a class="button" href="/Computer/Database/Tags/list">auflisten</a>
	<a class="button" href="/Computer/Database/Tags/add">hinzuf&uuml;gen</a>
   </div>
  </article>
 </div>
</div>

@endsection
