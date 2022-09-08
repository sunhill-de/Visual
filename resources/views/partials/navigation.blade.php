<li>
 @if ($entry->active)
 <div class="active_navigation">
 @endif
 <a id="{{ $entry->id }}" href="{{ $entry->link }}">{{ $entry->display_name }}</a>
</li> 
@isset($entry->subentries)
<ul>
 @foreach($entry->subentries as $entry)
	  @include('partials.navigation', $entry)
 @endforeach
</ul>
@endisset
