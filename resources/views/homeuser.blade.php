@extends('layouts.app')

@section('content')
<h1>You are {{$user->first_name}} {{$user->last_name}}</h1>
@endsection