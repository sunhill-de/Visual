@extends('visual::basic.tile')

@section('tilecaption', __('Imports'))

@section('tilebody')
Number of waiting imports: {{ $number_of_imports }}

@endsection