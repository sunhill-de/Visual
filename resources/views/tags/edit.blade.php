@extends('visual::basic.navigation')

@section('title',$title)

@section('caption')
{{ $title }}
@endsection

@section('content')
@parent
<div class="w-full max-w-sm">
<form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="post" action="{{ $action }}">
 @csrf
 <div class="mb-4">
 <label class="block text-gray-700 text-sm font-bold mb-2" for="tagname">{{ __('Tag name') }}</label>
 <input class="shadow apperance-none border rounded w-full py-3 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="name" type="text" value="{{ $name }}"/>
 </div>
 <div class="mb-6">
 <label class="block text-gray-700 text-sm font-bold mb-2" for="parent">{{ __('Tag parent') }}</label>
 <input class="shadow apperance-none border rounded w-full py-3 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="input_parent" type="text" value="{{ $parent_name }}" />
 <input name="value_parent" type="hidden" value="{{ $parent_id }}" />
 </div>
 <div class="mb-6">
 <label class="md:w-2/3 block text-gray-500 font-bold">
  <input class="mr-2 leading-tight" type="checkbox" name="leafable" checked />
  <span class="text-sm">{{ __('leafable') }}</span>  
 </label>
 <input class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" value="{{ __('send') }}" />
</div>
</form>
</div>
@endsection
  
