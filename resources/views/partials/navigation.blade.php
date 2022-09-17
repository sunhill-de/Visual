@if (isset($entry["visible"]) && $entry["visible"])
 <a class="navbar-link" id="{{ $entry['name'] }}" href="{{ $entry['link'] }}">{{ $entry['display_name'] }}</a>
</li> 
@isset($entry["subentries"])
<div class="navbar-dropdown">
<ul class="nav{{ $entry['depth']+1 }}">
 @foreach($entry["subentries"] as $entry)
	  @include('visual::partials.navigation', json_decode(json_encode($entry),true))
 @endforeach
</ul>
</div>
@endisset
@endif