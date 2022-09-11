@if (isset($entry["visible"]) && $entry["visible"])
<li>
 @if (isset($entry["active"]) && $entry["active"])
 <div class="active_navigation">
 @endif
 <a id="{{ $entry['id'] }}" href="{{ $entry['link'] }}">{{ $entry['display_name'] }}</a>
</li> 
@isset($entry["subentries"])
<ul class="nav{{ $entry['depth']+1 }}">
 @foreach($entry["subentries"] as $entry)
	  @include('visual::partials.navigation', json_decode(json_encode($entry),true))
 @endforeach
</ul>
@endisset
@endif