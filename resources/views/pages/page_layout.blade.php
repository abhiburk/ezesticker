@extends('layouts.frontend.app')
@section('title', $page->title)
@section('content')
    <div class="container bg-light">
        <div class="card my-5 shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 text-center my-5">
                        <h1 class="text-responsive font-weight-bold d-block">{{ $page->title }}</h1>
                    </div>
                    <div class="col-12">
                        {!! $page->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div> 
@endsection