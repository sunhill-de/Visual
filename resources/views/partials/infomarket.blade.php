<li @isset($entry['path']) id="item:{{ $entry['path'] }}" @endif>{{ $entry['name'] }}
   @if (count($entry['entries']) > 0)
    <ul>
  		@foreach($entry['entries'] as $entry)
  		   @include('visual::partials.infomarket', $entry)
  		@endforeach
    </ul>
   @endif
   </li>