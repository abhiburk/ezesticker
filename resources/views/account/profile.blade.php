@extends('layouts.frontend.app')
@section('title', 'Profile: ' . auth()->user()->name)
@section('content')
    <div class="container-fluid ">
        <div class="container py-5" >
            <div class="row" >
                @include('account.sidebar')
                <div class="col-sm-12 col-lg-8 mt-lg-4">
                    <div class="card">
                        <div class="card-body">
                            @if ($message = Session::get('message'))
                                <div class="alert alert-success">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif
                            @livewire('account.profile-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
