@extends('visual::basic.tile')

@section('tilecaption', __('Classes'))

@section('tilebody')
Number of Classes: {{ $number_of_classes }}

@endsection