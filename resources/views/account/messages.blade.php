@extends('layouts.frontend.app')
@section('title', 'Messages')
@section('content')
<div class="container mt-lg-5 mt-4">
    <div class="row">
        <div class="col-lg-12 d-flex mb-4 align-items-center">
            @livewire('chat.chat-container', ['user_id' => request()->user_id])
        </div>
    </div>
</div>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ url('frontend/css/chat.css') }}">
@endpush