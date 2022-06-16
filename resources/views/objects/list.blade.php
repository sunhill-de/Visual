@extends('visual::basic.navigation')

@section('title','Objekte auflisten')

@section('body')
@parent
       <table>
        <caption>Objekte von '{{$object}}' auflisten</caption>
        <tr>
         <th>Name</th>
         <th>Parent</th>
         <th>&nbsp;</th>
         <th>&nbsp;</th>
         <th>&nbsp;</th>
        </tr>
       </table>
       <a href="/">&Uuml;bersicht</a>
@endsection
