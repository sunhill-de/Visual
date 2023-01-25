@extends('visual::basic.tile')

@section('tilecaption', __('Tags'))

@section('tilebody')
Number of Tags: {{ $number_of_tags }}

@endsection