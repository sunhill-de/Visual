@extends('visual::basic.navigation')

@push('css')
  <style>
  .feedback { font-size: 1.4em; }
  .selectable .ui-selecting { background: #FECA40; }
  .selectable .ui-selected { background: #F39814; color: white; }
  .selectable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
  .selectable li { margin: 3px; padding: 0.4em; font-size: 1.4em; height: 18px; }
  </style>
@endpush

@section('title','Objekt hinzufügen')

@section('caption')
Objekt von '{{ $class->name }}' hinzufügen
@endsection

@section('content')
@parent
<form method="post" id="add" name="add" action="{{ $prefix }}/Objects/execadd">
 @csrf
 Klassenname: {{ $class->name }}<br />
 Tabellenname: {{ $class->tablename }}<br />
 <input type="hidden" name="_class" value="{{ $class->name }}" />
 @foreach ($class->fields as $field)
  <x-visual-input id="{{ $class->name }}" name="{{ $field->name }}" action="add" />
 @endforeach
 <input type="submit" value="abschicken" />
</form>
</script>
@endsection
  
