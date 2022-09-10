<li>
 @if (isset($entry["active"]) && $entry["active"])
 <div class="active_navigation">
 @endif
 @if (isset($entry['id']))
 <a id="{{ $entry['id'] }}" href="{{ $entry['link'] }}">{{ $entry['display_name'] }}</a>
 @endif
</li> 
@isset($entry["subentries"])
<ul>
 @foreach($entry["subentries"] as $entry)
	  @include('visual::partials.navigation', json_decode(json_encode($entry),true))
 @endforeach
</ul>
@endisset
