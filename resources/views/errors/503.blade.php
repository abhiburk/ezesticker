@extends('errors.layout')
@section('title', __('Maintainance Mode'))
@section('content')
    <h1>{{ $exception->getMessage() }}<span class="dot">.</span></h1>
@endsection