@extends('layouts.frontend.app')
@section('title', 'Dashboard: ' . auth()->user()->name)
@section('content')
    <div class="container-fluid ">
        <div class="container py-5" >
            <div class="row" >
                @include('account.sidebar')
                <div class="col-sm-12 col-lg-8 mt-lg-4">
                    <p class="alert alert-info">
                        Hello {{ auth()->user()->name }}
                        <span class="d-block">
                            From your account dashboard you can view your orders, manage your QR stickers and billing addresses
                            and edit your profile details.
                        </span>
                    </p>
                    <div class="row">
                        @foreach (Helper::getProfileRoute() as $item)
                            <div class="col-md-4 mb-4">
                                <a href="{{ route('account.'.$item['route']) }}" class="list-group-item-action">
                                    <article class="card card-body mini-card shadow-sm">
                                        <figure class="text-center">
                                            <span class="rounded-circle icon-md bg-secondary"><i class="fa {{ $item['icon'] }} text-white"></i></span>
                                            <figcaption class="pt-4">
                                            <h5 class="title">{{ $item['label'] }}</h5>
                                            </figcaption>
                                        </figure>
                                    </article>
                                </a>
                            </div>
                        @endforeach
                        <div class="col-md-4 mb-4">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <article class="card card-body mini-card shadow-sm">
                                    <figure class="text-center">
                                        <button type="submit" class="btn btn-transparent p-0">
                                            <span class="rounded-circle icon-md bg-secondary"><i class="fa fa-sign-out-alt text-white"></i></span>
                                            <figcaption class="pt-4">
                                                <h5 class="title">Logout</h5>
                                            </figcaption>
                                        </button>
                                    </figure>
                                </article>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .mini-card:hover{
            box-shadow: 0 1rem 3rem rgba(0,0,0,.175) !important;
            -webkit-transition: All 500ms ease;
            transform: translatey(-5px);
        }
    </style>
@endpush
