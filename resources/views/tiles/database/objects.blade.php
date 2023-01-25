@extends('visual::basic.tile')

@section('tilecaption', __('Objects'))

@section('tilebody')
Number of Objects: {{ $number_of_objects }}

@endsection