@extends('visual::basic.navigation')

@section('title',__('Show object'))

@section('caption')
{{ __('Show object') }}
@endsection

@section('content')
@parent
<div class="list">
    <table>
     <caption>{{ __('Fields') }}</caption>
     <tr>
      <th>{{ __('class') }}</th>
      <th>{{ __('Name') }}</th>
      <th>{{ __('Type') }}</th>
      <th>{{ __('Description') }}</th>
      <th>{{ __('Value') }}</th>
      <th>{{ __('Displayable') }}</th>
      <th>{{ __('Editable') }}</th>
      <th>{{ __('Groupeditable') }}</th>
     </tr>
     @forelse ($fields as $field)
      <tr>
       <td>{{ $field->class }}</td>
       <td>{{ $field->name }}</td>
       <td>{{ $field->type }}</td>
       <td>{{ $field->description }}</td>
       <td><b>{{ $field->value }}</b></td>
       <td>@if ($field->displayable)<div class="yes">Y</div>@else<div class="no">N</div>@endif</td>  
       <td>@if ($field->editable)<div class="yes">Y</div>@else<div class="no">N</div>@endif</td>  
       <td>@if ($field->groupeditable)<div class="yes">Y</div>@else<div class="no">N</div>@endif</td>  
      </tr>
     @empty
     <tr><td colspan="100">{{ __('No fields set') }}</td></tr>
     @endforelse
    </table>
    <h2>{{ __('Tags') }}</h2>
    <ul>
     @forelse ($tags as $tag)
      <li>{{ $tag->name }}</li>
     @empty
      <li>{{ __('No tags set') }}</li>
     @endforelse 
    </ul>
</div>
@endsection
  
