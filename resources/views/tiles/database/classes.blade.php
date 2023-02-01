@extends('visual::basic.tile')

@section('tilecaption', __('Classes'))

@section('tilebody')
Number of Classes: <x-visual-data name="database.classes.count" />

@endsection