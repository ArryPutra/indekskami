@extends('layouts.layout')

@section('content')
    <h1>Halo, <b>{{ auth()->user()->nama }}</b></h1>
@endsection
