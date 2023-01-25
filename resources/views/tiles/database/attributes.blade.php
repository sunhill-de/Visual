@extends('visual::basic.tile')

@section('tilecaption', __('Attributes'))

@section('tilebody')
Number of attributes: {{ $number_of_attributes }}

@endsection