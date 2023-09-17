@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset("css/main.css") }}">
@stop

@section('js')
    <script src="{{ asset("js/main.js") }}"></script>
@stop
